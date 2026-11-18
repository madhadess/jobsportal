// Yapay zekâ görsel/video üretim servis katmanı.
//
// Sağlayıcılar: Replicate, fal.ai (REST). Anahtar yoksa HİÇBİR şey üretilmiş gibi gösterilmez:
// sahneler "eksik medya" olarak raporlanır ve Remotion yalnızca prosedürel katmanları çizer.
//
// Önbellek: .cache/media-index.json — tam prompt özeti → üretilmiş dosya. Aynı prompt tekrar
// üretilmez; senaryo değişmediği sürece bölüm yeniden render edildiğinde ücret ödenmez.
import crypto from "node:crypto";
import fs from "node:fs";
import path from "node:path";
import { buildScenePrompt, type BuiltPrompt } from "../../src/pipeline/prompts";
import type { EpisodeSpec } from "../../src/series/types";
import { CACHE_DIR, MEDIA_DIR, ROOT, pub } from "./paths";

const EXTS = [".mp4", ".webm", ".mov", ".png", ".jpg", ".jpeg", ".webp"];

export const sceneMediaBase = (ep: number, si: number) =>
  `e${String(ep).padStart(2, "0")}s${String(si + 1).padStart(2, "0")}`;

/** public/media/eXX/eXXsYY.(mp4|png…) — elle eklenen ya da üretilen dosyayı bulur. */
export function findSceneMedia(ep: number, si: number): string | null {
  const dir = path.join(MEDIA_DIR, `e${String(ep).padStart(2, "0")}`);
  const base = sceneMediaBase(ep, si);
  for (const ext of EXTS) {
    const p = path.join(dir, base + ext);
    if (fs.existsSync(p)) return pub(p);
  }
  return null;
}

export function promptHash(b: BuiltPrompt) {
  return crypto.createHash("sha1").update(b.prompt + "|" + b.negative + "|" + b.referenceImages.join(",")).digest("hex").slice(0, 16);
}

type IndexEntry = { file: string; provider: string; model: string; createdAt: string };
const indexFile = path.join(CACHE_DIR, "media-index.json");
const readIndex = (): Record<string, IndexEntry> => (fs.existsSync(indexFile) ? JSON.parse(fs.readFileSync(indexFile, "utf8")) : {});
const writeIndex = (i: Record<string, IndexEntry>) => {
  fs.mkdirSync(CACHE_DIR, { recursive: true });
  fs.writeFileSync(indexFile, JSON.stringify(i, null, 2));
};

// ------------------------------------------------------------------ sağlayıcılar

export type GenerateRequest = BuiltPrompt & { type: "video" | "image"; refImageDataUri?: string };

export interface MediaProvider {
  name: string;
  model(type: "video" | "image"): string;
  generate(req: GenerateRequest): Promise<{ url: string }>;
}

const sleep = (ms: number) => new Promise((r) => setTimeout(r, ms));

/** Replicate — https://replicate.com/docs/reference/http */
class ReplicateProvider implements MediaProvider {
  name = "replicate";
  constructor(private token: string) {}
  model(type: "video" | "image") {
    return type === "video"
      ? process.env.REPLICATE_VIDEO_MODEL ?? "kwaivgi/kling-v2.1"
      : process.env.REPLICATE_IMAGE_MODEL ?? "black-forest-labs/flux-1.1-pro";
  }
  async generate(req: GenerateRequest) {
    const model = this.model(req.type);
    const input: Record<string, unknown> =
      req.type === "video"
        ? { prompt: req.prompt, negative_prompt: req.negative, aspect_ratio: "9:16", duration: req.seconds > 5 ? 10 : 5 }
        : { prompt: req.prompt, aspect_ratio: "9:16", output_format: "png" };
    if (req.refImageDataUri) input[process.env.REPLICATE_REF_IMAGE_KEY ?? "start_image"] = req.refImageDataUri;
    const res = await fetch(`https://api.replicate.com/v1/models/${model}/predictions`, {
      method: "POST",
      headers: { Authorization: `Bearer ${this.token}`, "Content-Type": "application/json", Prefer: "wait=60" },
      body: JSON.stringify({ input }),
    });
    if (!res.ok) throw new Error(`Replicate ${res.status}: ${await res.text()}`);
    let pred = (await res.json()) as { status: string; output: unknown; error?: string; urls: { get: string } };
    for (let i = 0; i < 240 && !["succeeded", "failed", "canceled"].includes(pred.status); i++) {
      await sleep(5000);
      pred = (await (await fetch(pred.urls.get, { headers: { Authorization: `Bearer ${this.token}` } })).json()) as typeof pred;
    }
    if (pred.status !== "succeeded") throw new Error(`Replicate üretimi başarısız: ${pred.error ?? pred.status}`);
    const out = Array.isArray(pred.output) ? pred.output[0] : pred.output;
    if (typeof out !== "string") throw new Error("Replicate çıktısı beklenmeyen biçimde");
    return { url: out };
  }
}

/** fal.ai kuyruk API — https://docs.fal.ai/model-endpoints/queue */
class FalProvider implements MediaProvider {
  name = "fal";
  constructor(private key: string) {}
  model(type: "video" | "image") {
    return type === "video"
      ? process.env.FAL_VIDEO_MODEL ?? "fal-ai/kling-video/v2.1/master/text-to-video"
      : process.env.FAL_IMAGE_MODEL ?? "fal-ai/flux-pro/v1.1";
  }
  async generate(req: GenerateRequest) {
    const model = this.model(req.type);
    const input: Record<string, unknown> =
      req.type === "video"
        ? { prompt: req.prompt, negative_prompt: req.negative, aspect_ratio: "9:16", duration: req.seconds > 5 ? "10" : "5" }
        : { prompt: req.prompt, image_size: { width: 1080, height: 1920 } };
    if (req.refImageDataUri) input[process.env.FAL_REF_IMAGE_KEY ?? "image_url"] = req.refImageDataUri;
    const headers = { Authorization: `Key ${this.key}`, "Content-Type": "application/json" };
    const sub = await fetch(`https://queue.fal.run/${model}`, { method: "POST", headers, body: JSON.stringify(input) });
    if (!sub.ok) throw new Error(`fal ${sub.status}: ${await sub.text()}`);
    const q = (await sub.json()) as { status_url: string; response_url: string };
    for (let i = 0; i < 240; i++) {
      const st = (await (await fetch(q.status_url, { headers })).json()) as { status: string };
      if (st.status === "COMPLETED") break;
      if (st.status === "FAILED" || st.status === "ERROR") throw new Error("fal üretimi başarısız");
      await sleep(5000);
    }
    const out = (await (await fetch(q.response_url, { headers })).json()) as { video?: { url: string }; images?: { url: string }[] };
    const url = out.video?.url ?? out.images?.[0]?.url;
    if (!url) throw new Error("fal çıktısında medya yok");
    return { url };
  }
}

export function configuredProvider(): MediaProvider | null {
  const pref = process.env.MEDIA_PROVIDER;
  if ((pref === "replicate" || !pref) && process.env.REPLICATE_API_TOKEN) return new ReplicateProvider(process.env.REPLICATE_API_TOKEN);
  if ((pref === "fal" || !pref) && process.env.FAL_KEY) return new FalProvider(process.env.FAL_KEY);
  return null;
}

function refDataUri(refs: string[]): string | undefined {
  for (const r of refs) {
    const p = path.join(ROOT, r);
    if (fs.existsSync(p)) return `data:image/${path.extname(p).slice(1)};base64,${fs.readFileSync(p).toString("base64")}`;
  }
  return undefined;
}

export type MediaStatus = {
  sceneIndex: number;
  id: string;
  type: "video" | "image";
  status: "present" | "generated" | "cached" | "missing" | "failed";
  file: string | null;
  prompt: BuiltPrompt;
  error?: string;
  missingRefs: string[];
};

/** Bir bölümün medya durumunu çıkarır; sağlayıcı varsa ve generate=true ise eksikleri üretir. */
export async function resolveEpisodeMedia(
  ep: EpisodeSpec,
  sceneSeconds: number[],
  opts: { generate: boolean; log?: (s: string) => void },
): Promise<MediaStatus[]> {
  const log = opts.log ?? (() => {});
  const provider = opts.generate ? configuredProvider() : null;
  const index = readIndex();
  const out: MediaStatus[] = [];
  for (const [si, scene] of ep.scenes.entries()) {
    const built = buildScenePrompt(scene, sceneSeconds[si] ?? 5);
    if (!built || !scene.media) continue;
    const id = sceneMediaBase(ep.number, si);
    const missingRefs = built.referenceImages.filter((r) => !fs.existsSync(path.join(ROOT, r)));
    const existing = findSceneMedia(ep.number, si);
    const st: MediaStatus = { sceneIndex: si, id, type: scene.media.type, status: existing ? "present" : "missing", file: existing, prompt: built, missingRefs };
    const h = promptHash(built);
    if (!existing && index[h] && fs.existsSync(path.join(ROOT, index[h].file))) {
      // aynı prompt başka bir sahnede üretilmiş → kopyala (ücretsiz yeniden kullanım)
      const ext = path.extname(index[h].file);
      const dest = path.join(MEDIA_DIR, `e${String(ep.number).padStart(2, "0")}`, id + ext);
      fs.mkdirSync(path.dirname(dest), { recursive: true });
      fs.copyFileSync(path.join(ROOT, index[h].file), dest);
      st.status = "cached";
      st.file = pub(dest);
    } else if (!existing && provider) {
      try {
        log(`  ${id}: ${provider.name}/${provider.model(scene.media.type)} ile üretiliyor…`);
        const { url } = await provider.generate({ ...built, type: scene.media.type, refImageDataUri: refDataUri(built.referenceImages) });
        const r = await fetch(url);
        if (!r.ok) throw new Error(`indirme ${r.status}`);
        const ext = scene.media.type === "video" ? ".mp4" : ".png";
        const dest = path.join(MEDIA_DIR, `e${String(ep.number).padStart(2, "0")}`, id + ext);
        fs.mkdirSync(path.dirname(dest), { recursive: true });
        fs.writeFileSync(dest, Buffer.from(await r.arrayBuffer()));
        index[h] = { file: path.relative(ROOT, dest), provider: provider.name, model: provider.model(scene.media.type), createdAt: new Date().toISOString() };
        writeIndex(index);
        st.status = "generated";
        st.file = pub(dest);
      } catch (e) {
        st.status = "failed";
        st.error = (e as Error).message;
      }
    }
    out.push(st);
  }
  return out;
}
