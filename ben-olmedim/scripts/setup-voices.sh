#!/usr/bin/env bash
# Türkçe Piper (VITS) ses modellerini sherpa-onnx sürümlerinden indirir.
# fahrettin ve fettah: CC0 (ticari kullanım serbest).
# dfki: CC BY-NC-SA 4.0 (ticari kullanım YASAK) — yalnızca TTS_ALLOW_NC=1 ise indirilir.
set -euo pipefail
DIR="$(cd "$(dirname "$0")/.." && pwd)/models/voices"
mkdir -p "$DIR"
BASE="https://github.com/k2-fsa/sherpa-onnx/releases/download/tts-models"
VOICES="vits-piper-tr_TR-fahrettin-medium vits-piper-tr_TR-fettah-medium"
[ "${TTS_ALLOW_NC:-0}" = "1" ] && VOICES="$VOICES vits-piper-tr_TR-dfki-medium"
for v in $VOICES; do
  if [ -d "$DIR/$v" ]; then echo "✓ $v zaten var"; continue; fi
  echo "↓ $v indiriliyor"
  curl -fsSL "$BASE/$v.tar.bz2" -o "$DIR/$v.tar.bz2"
  tar -xjf "$DIR/$v.tar.bz2" -C "$DIR"
  rm "$DIR/$v.tar.bz2"
done
echo "Sesler hazır: $DIR"
