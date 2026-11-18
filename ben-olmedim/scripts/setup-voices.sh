#!/usr/bin/env bash
# Türkçe Piper (VITS) ses modellerini sherpa-onnx sürümlerinden indirir.
# Modeller MIT/CC lisanslı açık kaynak Piper sesleridir (bkz. models/voices/*/MODEL_CARD).
set -euo pipefail
DIR="$(cd "$(dirname "$0")/.." && pwd)/models/voices"
mkdir -p "$DIR"
BASE="https://github.com/k2-fsa/sherpa-onnx/releases/download/tts-models"
for v in vits-piper-tr_TR-fahrettin-medium vits-piper-tr_TR-fettah-medium vits-piper-tr_TR-dfki-medium; do
  if [ -d "$DIR/$v" ]; then echo "✓ $v zaten var"; continue; fi
  echo "↓ $v indiriliyor"
  curl -fsSL "$BASE/$v.tar.bz2" -o "$DIR/$v.tar.bz2"
  tar -xjf "$DIR/$v.tar.bz2" -C "$DIR"
  rm "$DIR/$v.tar.bz2"
done
echo "Sesler hazır: $DIR"
