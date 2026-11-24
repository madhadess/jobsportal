#!/usr/bin/env python3
"""Doğal Türkçe TTS — Trendyol-TTS (VoxCPM2 tabanlı, MIT lisanslı ağırlıklar).

GPU varsa kullanır, yoksa CPU'da çalışır (≈5× gerçek zaman).

Kullanım: <venv>/bin/python voxcpm_synth.py jobs.json
jobs.json: [{"text": "...", "speaker": "hikaye", "refPath": "/abs/voices/hikaye.wav",
             "refText": "referans kaydın tam dökümü", "design": "(yoksa) ses tarifi",
             "pause": 0.35, "out": "/abs/out.raw.wav"}]

- Her konuşanın sesi sabit bir referans kayıttan "devam modu" ile klonlanır (kayıt + dökümü).
  Referans yoksa bir kez ses tasarımıyla üretilir ve diske yazılır.
- Her replik faster-whisper ile geri yazıya çevrilip metinle karşılaştırılır (duyulan sözcük
  oranı). Oran %88'in altındaysa replik en fazla 3 kez yeniden üretilir, en iyisi seçilir.
"""
import difflib
import json
import os
import re
import sys
import time

import numpy as np
import soundfile as sf
import torch

_asr = None


def asr_model():
    global _asr
    if _asr is None:
        try:
            from faster_whisper import WhisperModel

            _asr = WhisperModel(os.environ.get("TTS_ASR_MODEL", "small"), device="cpu", compute_type="int8")
        except Exception as e:  # doğrulama isteğe bağlı
            print(json.dumps({"asr": f"kapalı: {e}"}), flush=True)
            _asr = False
    return _asr


def norm(s: str) -> list:
    s = s.lower().replace("i̇", "i")
    s = re.sub(r"[^\wçğıöşü ]+", " ", s)
    return s.split()


def score(audio: np.ndarray, sr: int, text: str) -> float:
    m = asr_model()
    if not m:
        return 1.0
    import librosa

    y = librosa.resample(audio.astype(np.float32), orig_sr=sr, target_sr=16000)
    segs, _ = m.transcribe(y, language="tr", beam_size=5, vad_filter=True, condition_on_previous_text=False)
    heard = " ".join(s.text for s in segs)
    exp, got = norm(text), norm(heard)
    if not exp:
        return 1.0
    # duyulması gereken sözcüklerin oranı (Whisper'ın uydurduğu fazladan sözcükler cezalandırılmaz)
    matched = sum(b.size for b in difflib.SequenceMatcher(None, exp, got).get_matching_blocks())
    return matched / len(exp)


def sentences(text: str) -> list:
    parts = re.split(r"(?<=[.!?…])\s+", text.strip())
    return [p for p in parts if p]


def main():
    jobs = json.load(open(sys.argv[1], encoding="utf-8"))
    if not jobs:
        return
    from turkish_tts import TurkishTTS

    device = os.environ.get("TTS_DEVICE") or ("cuda" if torch.cuda.is_available() else "cpu")
    torch.set_num_threads(os.cpu_count() or 4)
    t0 = time.time()
    tts = TurkishTTS(device=device, optimize=False)
    sr = tts.sample_rate
    print(json.dumps({"loaded": round(time.time() - t0, 1), "device": device}), flush=True)
    retries = int(os.environ.get("TTS_RETRIES", "3"))

    for j in jobs:
        ref, ref_text = j["refPath"], j["refText"]
        if not os.path.exists(ref):
            os.makedirs(os.path.dirname(ref), exist_ok=True)
            tts.save(f"({j['design']}){ref_text}", ref)
            print(json.dumps({"designed": j["speaker"], "ref": ref}), flush=True)
        t = time.time()
        best, best_s, tries = None, -1.0, 0
        for attempt in range(retries):
            tries += 1
            wav = tts._model.generate(text=j["text"], prompt_wav_path=ref, prompt_text=ref_text, reference_wav_path=ref)
            wav = np.asarray(wav, dtype=np.float32).reshape(-1)
            s = score(wav, sr, j["text"])
            if s > best_s:
                best, best_s = wav, s
            if s >= 0.88:
                break
        os.makedirs(os.path.dirname(j["out"]), exist_ok=True)
        sf.write(j["out"], best, sr, subtype="PCM_16")
        print(json.dumps({"out": os.path.basename(j["out"]), "speaker": j["speaker"], "sec": round(time.time() - t, 1), "tries": tries, "match": round(best_s, 2)}), flush=True)


if __name__ == "__main__":
    main()
