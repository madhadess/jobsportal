import path from "node:path";
import { fileURLToPath } from "node:url";

export const ROOT = path.resolve(path.dirname(fileURLToPath(import.meta.url)), "..", "..");
export const PUBLIC = path.join(ROOT, "public");
export const VO_DIR = path.join(PUBLIC, "audio", "vo");
export const SFX_DIR = path.join(PUBLIC, "audio", "sfx");
export const MEDIA_DIR = path.join(PUBLIC, "media");
export const MANIFEST_DIR = path.join(PUBLIC, "manifests");
export const OUT_DIR = path.join(ROOT, "out");
export const REPORT_DIR = path.join(ROOT, "reports");
export const CACHE_DIR = path.join(ROOT, ".cache");
export const pub = (abs: string) => path.relative(PUBLIC, abs).split(path.sep).join("/");
