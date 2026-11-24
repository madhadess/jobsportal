import fs from "node:fs";
import path from "node:path";
import { describe, expect, it } from "vitest";
import { ambienceSegments } from "../src/pipeline/audio";
import { buildScenePrompt } from "../src/pipeline/prompts";
import { buildManifest, distributePadding, splitSubtitle, toSrt } from "../src/pipeline/timeline";
import { EPISODES, getEpisode } from "../src/series";
import { CHARACTERS, LOCATIONS, SERIES, VOICES } from "../src/series/bible";
import type { EpisodeManifest, SfxId } from "../src/series/types";

const fakeSfx = new Proxy({} as Record<SfxId, number>, { get: () => 1.5 });
/** Türkçe anlatımın ölçülmüş hızına yakın sahte süre: ~2,2 kelime/sn */
const fakeVoice = (n: number) =>
  getEpisode(n).scenes.map((s) => s.lines.map((l) => ({ src: "x.wav", seconds: l.text.split(/\s+/).length / 2.2 })));

describe("zamanlama motoru", () => {
  it("bölüm 1 için sahneleri ardışık ve çakışmasız dizer", () => {
    const m = buildManifest({ episode: getEpisode(1), voice: fakeVoice(1), sfxSeconds: fakeSfx, media: [] });
    let cursor = 0;
    for (const s of m.scenes) {
      expect(s.from).toBe(cursor);
      cursor += s.durationInFrames;
      for (const l of s.lines) {
        expect(l.from).toBeGreaterThanOrEqual(s.from);
        expect(l.from + l.durationInFrames).toBeLessThanOrEqual(s.from + s.durationInFrames);
      }
      for (const c of s.sfx) expect(c.from).toBeLessThan(s.from + s.durationInFrames);
    }
    expect(m.endCard.from).toBe(cursor);
    expect(m.durationInFrames).toBe(cursor + m.endCard.durationInFrames);
    expect(m.seconds).toBeGreaterThanOrEqual(SERIES.minSeconds);
  });

  it("kısa bölümü 45 sn alt sınırına kadar gerilime göre doldurur", () => {
    const pads = distributePadding([5, 5], [0, 1], 6);
    expect(pads[0] + pads[1]).toBeCloseTo(6);
    expect(pads[1]).toBeGreaterThan(pads[0]);
    expect(distributePadding([5], [1], -3)).toEqual([0]);
  });

  it("medya yoksa sahneyi eksik olarak işaretler, varsa yolunu koyar", () => {
    const ep = getEpisode(1);
    const media = ep.scenes.map((s, i) => (s.media && i === 1 ? "media/e01/e01s02.mp4" : null));
    const m = buildManifest({ episode: ep, voice: fakeVoice(1), sfxSeconds: fakeSfx, media });
    expect(m.scenes[1].media?.src).toBe("media/e01/e01s02.mp4");
    expect(m.scenes[1].mediaMissing).toBe(false);
    expect(m.scenes[3].mediaMissing).toBe(true);
    expect(m.scenes[0].mediaMissing).toBe(false); // prosedürel sahne
  });

  it("son bölümün kapanış kartı SEZON SONU, diğerleri sonraki bölümü gösterir", () => {
    const m30 = buildManifest({ episode: getEpisode(30), voice: fakeVoice(30), sfxSeconds: fakeSfx, media: [] });
    const m5 = buildManifest({ episode: getEpisode(5), voice: fakeVoice(5), sfxSeconds: fakeSfx, media: [] });
    expect(m30.endCard.text).toBe("SEZON SONU");
    expect(m5.endCard.text).toBe("DEVAM EDECEK — BÖLÜM 6");
  });

  it("SRT üretir", () => {
    const m = buildManifest({ episode: getEpisode(1), voice: fakeVoice(1), sfxSeconds: fakeSfx, media: [] });
    const srt = toSrt(m);
    expect(srt).toMatch(/^1\n00:00:0\d,\d{3} --> 00:00:\d{2},\d{3}\n/);
  });
});

describe("altyazı ve ses", () => {
  it("altyazıyı okunabilir parçalara böler", () => {
    const parts = splitSubtitle("Ölmüş babamın evine taşındığım ilk gece, telefonuma kendi numaramdan bir mesaj geldi.");
    expect(parts.length).toBeGreaterThan(1);
    for (const p of parts) expect(p.length).toBeLessThanOrEqual(40);
    expect(parts.join(" ")).toBe("Ölmüş babamın evine taşındığım ilk gece, telefonuma kendi numaramdan bir mesaj geldi.");
  });

  it("ardışık sahnelerdeki ortam sesini birleştirir, sessiz sahnede keser", () => {
    const segs = ambienceSegments({
      scenes: [
        { from: 0, durationInFrames: 10, ambience: ["roomTone"], silence: false },
        { from: 10, durationInFrames: 10, ambience: ["roomTone", "lowTension"], silence: false },
        { from: 20, durationInFrames: 10, ambience: ["roomTone"], silence: true },
        { from: 30, durationInFrames: 10, ambience: ["roomTone"], silence: false },
      ] as EpisodeManifest["scenes"],
    });
    const room = segs.filter((s) => s.id === "roomTone");
    expect(room).toEqual([
      { id: "roomTone", from: 0, to: 20 },
      { id: "roomTone", from: 30, to: 40 },
    ]);
    expect(segs.find((s) => s.id === "lowTension")).toEqual({ id: "lowTension", from: 10, to: 20 });
  });
});

describe("dizi verisi", () => {
  it("30 bölümün tamamı sıralı ve eksiksiz", () => {
    expect(EPISODES.map((e) => e.number)).toEqual(Array.from({ length: 30 }, (_, i) => i + 1));
  });

  it("her bölümde kanca, yeni bilgi, final ve devamlılık notu var", () => {
    for (const e of EPISODES) {
      expect(e.hook.length, `B${e.number} hook`).toBeGreaterThan(10);
      expect(e.revelation.length, `B${e.number} revelation`).toBeGreaterThan(10);
      expect(e.cliffhanger.length, `B${e.number} cliffhanger`).toBeGreaterThan(10);
      if (e.number > 1) expect(e.continuesFrom, `B${e.number}`).toContain(`Bölüm ${e.number - 1}`);
    }
  });

  it("her sahne görüntülenebilir; konuşanlar, karakterler ve mekânlar tanımlı", () => {
    for (const e of EPISODES)
      for (const [i, s] of e.scenes.entries()) {
        expect(s.media || s.insert, `B${e.number} sahne ${i + 1}`).toBeTruthy();
        for (const l of s.lines) expect(VOICES[l.speaker], l.speaker).toBeDefined();
        for (const c of s.media?.characters ?? []) expect(CHARACTERS[c], c).toBeDefined();
        if (s.media?.location) expect(LOCATIONS[s.media.location]).toBeDefined();
      }
  });

  it("ilk bölüm verilen senaryodaki kilit cümleleri içerir", () => {
    const text = getEpisode(1).scenes.flatMap((s) => s.lines.map((l) => l.text)).join(" ");
    expect(text).toContain("Çünkü o kişi sensin.");
    expect(text).toContain("İçerideki ben değilim.");
    const last = getEpisode(30).scenes.at(-1)!.lines.map((l) => l.text).join(" ");
    expect(last).toContain("bu sefer beni kurtaracak mısın?");
  });

  it("özel bölüm: replik bağlantılı zamanlar ve sahne karakterleri geçerli", () => {
    const ep = getEpisode(101);
    expect(ep.slug).toBe("kapi-tavan");
    for (const [i, sc] of ep.scenes.entries()) {
      if (sc.insert?.kind !== "stage") continue;
      const refs = sc.insert.actors.flatMap((a) => [a.appearAt, a.vanishAt, ...(a.poseAt ?? []).map((p) => p[0]), ...(a.exprAt ?? []).map((p) => p[0]), ...(a.moveTo ? [a.moveTo[0], a.moveTo[1]] : [])]);
      for (const r of refs) {
        if (typeof r !== "string") continue;
        const n = Number(/^[LE](\d+)/.exec(r)?.[1]);
        expect(n, `sahne ${i + 1}: ${r}`).toBeLessThan(sc.lines.length);
      }
    }
  });

  it("üretim promptu stil, karakter kimliği ve mekânı içerir", () => {
    const s = getEpisode(2).scenes[0];
    const p = buildScenePrompt(s, 6)!;
    expect(p.prompt).toContain("photorealistic");
    expect(p.prompt).toContain(CHARACTERS.arasKanli.identity);
    expect(p.prompt).toContain(LOCATIONS.koridor3.prompt);
    expect(p.referenceImages).toContain(CHARACTERS.arasKanli.referenceImage);
  });

  it("hazırlanmış manifestler bölümün süre aralığında (dizi 45–60 sn, özel bölüm kendi aralığı)", () => {
    const dir = path.join(__dirname, "..", "public", "manifests");
    const files = fs.existsSync(dir) ? fs.readdirSync(dir).filter((f) => f.endsWith(".json")) : [];
    for (const f of files) {
      const m = JSON.parse(fs.readFileSync(path.join(dir, f), "utf8")) as EpisodeManifest;
      const [lo, hi] = getEpisode(m.episode).durationRange ?? [45, 60];
      expect(m.seconds, f).toBeGreaterThanOrEqual(lo);
      expect(m.seconds, f).toBeLessThanOrEqual(hi);
    }
  });
});
