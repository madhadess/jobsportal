#!/usr/bin/env python3
"""Türkçe TTS — Piper (piper-tts) + Türkçe VITS sesleri (fahrettin, fettah, dfki).

Kullanım: python3 synth.py jobs.json
jobs.json: [{"text": "...", "voice": "tr_TR-fahrettin-medium", "lengthScale": 1.1,
             "noiseScale": 0.667, "noiseW": 0.8, "out": "/abs/path.raw.wav"}]
Her iş için 'out' yoluna mono WAV yazar ve stdout'a JSON satırı basar.
"""
import json
import os
import re
import sys
import wave

import numpy as np

from piper import PiperVoice, SynthesisConfig

ROOT = os.path.abspath(os.path.join(os.path.dirname(__file__), "..", ".."))
VOICES = os.path.join(ROOT, "models", "voices")
_cache = {}


def load(voice: str) -> PiperVoice:
    if voice not in _cache:
        model = os.path.join(VOICES, f"vits-piper-{voice}", f"{voice}.onnx")
        if not os.path.exists(model):
            raise SystemExit(f"Ses modeli yok: {model} — önce `npm run setup:voices`")
        _cache[voice] = PiperVoice.load(model)
    return _cache[voice]


def main():
    jobs = json.load(open(sys.argv[1], encoding="utf-8"))
    for j in jobs:
        v = load(j["voice"])
        cfg = SynthesisConfig(
            length_scale=float(j.get("lengthScale", 1.0)),
            noise_scale=float(j.get("noiseScale", 0.667)),
            noise_w_scale=float(j.get("noiseW", 0.8)),
        )
        os.makedirs(os.path.dirname(j["out"]), exist_ok=True)
        # cümleleri ayrı sentezle, aralarına dramatik sessizlik koy
        pause = float(j.get("sentencePause", 0.4))
        sentences = [x for x in re.split(r"(?<=[.!?…])\s+", j["text"].strip()) if x]
        sr = v.config.sample_rate
        pieces = []
        for k, sent in enumerate(sentences):
            audio = np.concatenate([c.audio_int16_array for c in v.synthesize(sent, syn_config=cfg)])
            pieces.append(audio)
            if k < len(sentences) - 1:
                pieces.append(np.zeros(int(pause * sr), dtype=np.int16))
        with wave.open(j["out"], "wb") as w:
            w.setnchannels(1)
            w.setsampwidth(2)
            w.setframerate(sr)
            w.writeframes(np.concatenate(pieces).tobytes())
        print(json.dumps({"out": j["out"]}), flush=True)


if __name__ == "__main__":
    main()
