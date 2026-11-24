#!/usr/bin/env python3
"""Özgün korku ses efektleri ve ortam sesleri — tamamen matematiksel sentez (numpy).

Hiçbir dış kayıt kullanılmaz; çıktılar bu projeye aittir, lisans sorunu yoktur.
Kullanım: python3 generate_sfx.py <çıktı_klasörü>
"""
import os
import sys

import numpy as np
import soundfile as sf

SR = 48000
rng = np.random.default_rng(317)


def t(sec):
    return np.arange(int(sec * SR)) / SR


def norm(x, peak=0.9):
    m = np.max(np.abs(x)) or 1.0
    return x / m * peak


def env(n, attack, release, sustain=None):
    """Basit AR zarfı (saniye)."""
    e = np.ones(n)
    a = max(1, int(attack * SR))
    r = max(1, int(release * SR))
    e[:a] = np.linspace(0, 1, a)
    if sustain is None:
        e[-r:] *= np.linspace(1, 0, r)
    return e


def lowpass(x, cutoff):
    # tek kutuplu IIR alçak geçiren (vektörel değil ama yeterince hızlı)
    a = np.exp(-2 * np.pi * cutoff / SR)
    y = np.empty_like(x)
    acc = 0.0
    for i, v in enumerate(x):
        acc = (1 - a) * v + a * acc
        y[i] = acc
    return y


def fft_filter(x, lo=0, hi=None):
    X = np.fft.rfft(x)
    f = np.fft.rfftfreq(len(x), 1 / SR)
    mask = (f >= lo) & (f <= (hi or SR))
    X[~mask] = 0
    return np.fft.irfft(X, len(x))


def pink(n):
    X = np.fft.rfft(rng.standard_normal(n))
    f = np.fft.rfftfreq(n)
    f[0] = 1
    X /= np.sqrt(f)
    return norm(np.fft.irfft(X, n), 1)


def brown(n):
    return norm(np.cumsum(rng.standard_normal(n)) - np.convolve(np.cumsum(rng.standard_normal(n)), np.ones(4000) / 4000, "same"), 1)


def reverb(x, decay=1.6, mix=0.3):
    n = int(decay * SR)
    ir = rng.standard_normal(n) * np.exp(-np.linspace(0, 7, n))
    ir = fft_filter(ir, 80, 6000)
    wet = np.convolve(x, ir)[: len(x) + n // 2]
    dry = np.pad(x, (0, len(wet) - len(x)))
    return dry * (1 - mix) + norm(wet, np.max(np.abs(x)) + 1e-9) * mix


def stereo(x, width=0.0):
    if width <= 0:
        return np.stack([x, x], 1)
    d = int(0.012 * SR * width)
    l = x
    r = np.concatenate([np.zeros(d), x[:-d]]) if d else x
    return np.stack([l, r], 1)


def loopify(x, fade=1.5):
    """Uçları çapraz geçişle birleştirerek kesintisiz döngü."""
    f = int(fade * SR)
    head, tail = x[:f], x[-f:]
    ramp = np.linspace(0, 1, f)
    if x.ndim == 2:
        ramp = ramp[:, None]
    mid = x[f:-f]
    joined = tail * (1 - ramp) + head * ramp
    return np.concatenate([joined, mid])


# ------------------------- tek seferlik efektler -------------------------

def knock_single(power=1.0):
    n = int(0.45 * SR)
    tt = np.arange(n) / SR
    body = (np.sin(2 * np.pi * 95 * tt) * 0.9 + np.sin(2 * np.pi * 180 * tt) * 0.5 + np.sin(2 * np.pi * 410 * tt) * 0.25)
    body *= np.exp(-tt * 18)
    click = rng.standard_normal(n) * np.exp(-tt * 240)
    click = fft_filter(click, 300, 4500)
    thump = fft_filter(rng.standard_normal(n) * np.exp(-tt * 40), 40, 400)
    return (body * 0.8 + click * 0.5 + thump * 0.6) * power


def knock3():
    out = np.zeros(int(2.6 * SR))
    for i, (pos, p) in enumerate([(0.0, 1.0), (0.62, 1.05), (1.24, 1.15)]):
        k = knock_single(p)
        s = int(pos * SR)
        out[s : s + len(k)] += k
    return stereo(norm(reverb(out, 1.2, 0.22), 0.95)[: int(2.6 * SR)], 0.3)


def knock1():
    out = np.zeros(int(0.8 * SR))
    k = knock_single(0.7)
    out[: len(k)] += k
    return stereo(norm(reverb(out, 0.8, 0.2), 0.7)[: len(out)], 0.3)


def phone_vibrate():
    out = np.zeros(int(2.4 * SR))
    for start in (0.0, 1.2):
        d = 0.55
        tt = t(d)
        buzz = np.sign(np.sin(2 * np.pi * 175 * tt)) * 0.4 + np.sin(2 * np.pi * 350 * tt) * 0.3
        buzz = fft_filter(buzz, 120, 2000)
        buzz *= env(len(tt), 0.01, 0.05) * (0.8 + 0.2 * np.sin(2 * np.pi * 11 * tt))
        s = int(start * SR)
        out[s : s + len(buzz)] += buzz
    # ahşap yüzeyde rezonans
    return stereo(norm(reverb(out, 0.5, 0.18)[: len(out)], 0.7))


def phone_notify():
    tt = t(1.4)
    tone = np.sin(2 * np.pi * 880 * tt) * np.exp(-tt * 6) + np.sin(2 * np.pi * 1320 * tt) * np.exp(-tt * 8) * 0.5
    tone[int(0.16 * SR):] += (np.sin(2 * np.pi * 1174 * tt) * np.exp(-tt * 6))[: len(tone) - int(0.16 * SR)] * 0.7
    return stereo(norm(reverb(tone, 1.0, 0.25)[: len(tt)], 0.45))


def phone_ring():
    out = np.zeros(int(5.0 * SR))
    for s0 in (0.0, 2.4):
        tt = t(1.4)
        r = (np.sin(2 * np.pi * 440 * tt) + np.sin(2 * np.pi * 480 * tt)) * 0.5
        r *= (np.sin(2 * np.pi * 20 * tt) > 0) * 0.5 + 0.5
        r *= env(len(tt), 0.02, 0.1)
        s = int(s0 * SR)
        out[s : s + len(r)] += r
    out = fft_filter(out, 300, 3400)
    return stereo(norm(out, 0.45))


def heartbeat(beats=6, bpm=62):
    period = 60 / bpm
    out = np.zeros(int((beats * period + 0.6) * SR))
    for i in range(beats):
        for off, amp in ((0, 1.0), (0.28, 0.7)):
            tt = t(0.25)
            thump = np.sin(2 * np.pi * (48 + 20 * np.exp(-tt * 30)) * tt) * np.exp(-tt * 16) * amp
            s = int((i * period + off) * SR)
            out[s : s + len(thump)] += thump
    return stereo(norm(out, 0.9))


def clock_tick(count=12):
    out = np.zeros(int((count + 0.3) * SR))
    for i in range(count):
        tt = t(0.06)
        c = rng.standard_normal(len(tt)) * np.exp(-tt * 300)
        c = fft_filter(c, 1800, 7000) * (1.0 if i % 2 == 0 else 0.7)
        s = int(i * SR)
        out[s : s + len(c)] += c
    return stereo(norm(reverb(out, 0.6, 0.25)[: len(out)], 0.5))


def breath():
    n = int(3.2 * SR)
    noise = fft_filter(pink(n), 200, 2600)
    tt = np.arange(n) / SR
    e = np.clip(np.sin(np.pi * tt / 1.5), 0, None) ** 2 * (tt < 1.5) + np.clip(np.sin(np.pi * (tt - 1.7) / 1.4), 0, None) ** 2 * (tt > 1.7) * (tt < 3.1) * 0.8
    return stereo(norm(noise * e, 0.55), 0.4)


def wood_creak():
    tt = t(2.0)
    f0 = 140 + 60 * np.sin(2 * np.pi * 0.7 * tt) + 25 * rng.standard_normal(len(tt)).cumsum() / SR
    phase = 2 * np.pi * np.cumsum(f0) / SR
    pulses = (np.sin(phase) > 0.96).astype(float)
    sig = fft_filter(pulses, 100, 3000)
    sig = reverb(sig * env(len(tt), 0.3, 0.6), 0.8, 0.3)[: len(tt)]
    return stereo(norm(sig, 0.5), 0.5)


def footsteps(count=6, gap=0.75):
    out = np.zeros(int((count * gap + 0.8) * SR))
    for i in range(count):
        tt = t(0.3)
        heel = fft_filter(rng.standard_normal(len(tt)), 80, 900) * np.exp(-tt * 30)
        grit = fft_filter(rng.standard_normal(len(tt)), 2000, 6000) * np.exp(-tt * 60) * 0.3
        s = int(i * gap * SR)
        out[s : s + len(tt)] += (heel + grit) * (0.8 + 0.2 * rng.random())
    return stereo(norm(reverb(out, 1.4, 0.35)[: len(out)], 0.55), 0.6)


def metal_scrape():
    tt = t(2.2)
    f = 600 + 400 * np.sin(2 * np.pi * 0.4 * tt) + 80 * np.sin(2 * np.pi * 7 * tt)
    s = np.sin(2 * np.pi * np.cumsum(f) / SR) + 0.5 * np.sin(2 * np.pi * np.cumsum(f * 2.71) / SR)
    s += fft_filter(rng.standard_normal(len(tt)), 1500, 7000) * 0.6
    s *= env(len(tt), 0.15, 0.5) * (0.6 + 0.4 * np.abs(np.sin(2 * np.pi * 3 * tt)))
    return stereo(norm(reverb(s, 1.5, 0.35)[: len(tt)], 0.45), 0.5)


def riser(sec=4.0):
    tt = t(sec)
    f = 60 * (2 ** (tt / sec * 3))
    s = np.sin(2 * np.pi * np.cumsum(f) / SR) * 0.5 + np.sin(2 * np.pi * np.cumsum(f * 1.5) / SR) * 0.3
    s += fft_filter(pink(len(tt)), 200, 8000) * (tt / sec) * 0.4
    s *= (tt / sec) ** 2
    return stereo(norm(s, 0.7), 0.5)


def hit_low():
    tt = t(3.5)
    boom = np.sin(2 * np.pi * (32 + 50 * np.exp(-tt * 8)) * tt) * np.exp(-tt * 1.4)
    crack = fft_filter(rng.standard_normal(len(tt)), 100, 5000) * np.exp(-tt * 20) * 0.6
    return stereo(norm(reverb(boom + crack, 2.5, 0.3)[: len(tt)], 0.95), 0.4)


def static_burst():
    tt = t(0.9)
    s = rng.standard_normal(len(tt)) * (0.6 + 0.4 * (np.sin(2 * np.pi * 60 * tt) > 0))
    s = fft_filter(s, 400, 9000) * env(len(tt), 0.005, 0.3)
    return stereo(norm(s, 0.5))


def door_handle():
    out = np.zeros(int(2.0 * SR))
    for pos in (0.0, 0.18, 0.35, 0.9):
        tt = t(0.25)
        m = (np.sin(2 * np.pi * 2300 * tt) + np.sin(2 * np.pi * 3700 * tt) * 0.6) * np.exp(-tt * 35)
        m += fft_filter(rng.standard_normal(len(tt)), 1000, 6000) * np.exp(-tt * 50) * 0.5
        s = int(pos * SR)
        out[s : s + len(tt)] += m
    return stereo(norm(reverb(out, 0.7, 0.25)[: len(out)], 0.55), 0.3)


def paper_slide():
    tt = t(1.6)
    s = fft_filter(rng.standard_normal(len(tt)), 1500, 9000) * env(len(tt), 0.2, 0.4)
    s *= 0.6 + 0.4 * np.abs(np.sin(2 * np.pi * 2.5 * tt))
    return stereo(norm(s, 0.4))


def fire_crackle(sec=6.0):
    n = int(sec * SR)
    base = fft_filter(brown(n), 30, 500) * 0.5
    out = base.copy()
    for _ in range(int(sec * 14)):
        pos = rng.integers(0, n - 4000)
        tt = t(0.02)
        c = rng.standard_normal(len(tt)) * np.exp(-tt * 400) * rng.uniform(0.3, 1.2)
        out[pos : pos + len(tt)] += fft_filter(c, 1200, 9000)
    return stereo(norm(out, 0.6), 0.7)


def elevator_ding():
    tt = t(2.0)
    s = np.sin(2 * np.pi * 1046 * tt) * np.exp(-tt * 2.5) + np.sin(2 * np.pi * 2093 * tt) * np.exp(-tt * 4) * 0.3
    return stereo(norm(reverb(s, 1.0, 0.3)[: len(tt)], 0.45))


def tape_click():
    tt = t(0.5)
    c = fft_filter(rng.standard_normal(len(tt)), 500, 6000) * np.exp(-tt * 120)
    hiss = fft_filter(rng.standard_normal(len(tt)), 3000, 10000) * 0.05 * (tt > 0.05)
    return stereo(norm(c + hiss, 0.6))


def glitch():
    tt = t(1.0)
    s = np.zeros(len(tt))
    for _ in range(14):
        a = rng.integers(0, len(tt) - 3000)
        b = a + rng.integers(400, 3000)
        f = rng.uniform(100, 3000)
        s[a:b] += np.sign(np.sin(2 * np.pi * f * tt[a:b])) * rng.uniform(0.2, 0.8)
    s += rng.standard_normal(len(tt)) * 0.15
    return stereo(norm(s * env(len(tt), 0.001, 0.2), 0.5), 0.4)


def plaster_crack():
    tt = t(1.4)
    s = np.zeros(len(tt))
    for _ in range(9):
        pos = rng.integers(0, int(0.5 * SR))
        c = fft_filter(rng.standard_normal(4000), 400, 7000) * np.exp(-np.arange(4000) / 500)
        s[pos : pos + 4000] += c * rng.uniform(0.4, 1)
    debris = fft_filter(rng.standard_normal(len(tt)), 1500, 8000) * np.exp(-tt * 3) * 0.25
    return stereo(norm(reverb(s + debris, 0.9, 0.25)[: len(tt)], 0.7), 0.4)


def scratching(sec=4.0):
    n = int(sec * SR)
    out = np.zeros(n)
    pos = 0
    while pos < n - SR // 2:
        d = int(rng.uniform(0.15, 0.45) * SR)
        tt = np.arange(d) / SR
        s = fft_filter(rng.standard_normal(d), 1800, 8000) * np.sin(np.pi * tt / tt[-1]) * (0.7 + 0.3 * np.sin(2 * np.pi * 30 * tt))
        out[pos : pos + d] += s
        pos += d + int(rng.uniform(0.1, 0.5) * SR)
    out = lowpass(out, 2500)  # duvarın arkasından boğuk
    return stereo(norm(reverb(out, 0.6, 0.3)[:n], 0.45), 0.3)


def doors_open():
    out = np.zeros(int(4.5 * SR))
    for i in range(9):
        c = wood_creak()[:, 0] * rng.uniform(0.4, 1.0)
        h = door_handle()[:, 0] * 0.4
        s = int(rng.uniform(0.0, 1.8) * SR)
        out[s : s + len(c)] += c
        out[s : s + len(h)] += h
    return stereo(norm(reverb(out, 2.0, 0.4)[: len(out)], 0.8), 0.8)


def power_down():
    tt = t(3.0)
    f = 120 * np.exp(-tt * 1.2) + 20
    s = np.sign(np.sin(2 * np.pi * np.cumsum(f) / SR)) * np.exp(-tt * 0.9)
    s = fft_filter(s, 20, 2000) + fft_filter(rng.standard_normal(len(tt)), 50, 300) * np.exp(-tt * 1.5) * 0.4
    return stereo(norm(s, 0.75), 0.3)


def child_hum():
    """Uzak, kelimesiz bir ninni mırıltısı — perdesi kayan sinüsler."""
    notes = [0, 3, 5, 3, 0, -2, 0]
    out = np.array([])
    for i, semi in enumerate(notes):
        d = 0.55 if i < len(notes) - 1 else 1.1
        tt = t(d)
        f = 392 * 2 ** (semi / 12) * (1 + 0.006 * np.sin(2 * np.pi * 5 * tt))
        v = np.sin(2 * np.pi * np.cumsum(f) / SR) + 0.3 * np.sin(4 * np.pi * np.cumsum(f) / SR)
        v *= env(len(tt), 0.08, 0.15)
        out = np.concatenate([out, v])
    out = lowpass(out, 1800)
    return stereo(norm(reverb(out, 2.5, 0.55)[: len(out) + SR], 0.3), 0.6)


def sudden_silence():
    """Kısa bir hava emişi: ortam kesildiği anı vurgular."""
    tt = t(0.6)
    s = fft_filter(rng.standard_normal(len(tt)), 100, 3000) * np.linspace(1, 0, len(tt)) ** 3
    return stereo(norm(s, 0.25))


# ------------------------- döngüsel ortam sesleri -------------------------

def amb_room_tone(sec=30):
    n = int(sec * SR)
    s = fft_filter(pink(n), 30, 700) * 0.6 + np.sin(2 * np.pi * 50 * t(sec)) * 0.03
    return loopify(stereo(norm(s, 0.35), 0.8))


def amb_fluorescent(sec=30):
    tt = t(sec)
    hum = sum(np.sin(2 * np.pi * 100 * k * tt) / k for k in (1, 2, 3, 5)) * 0.25
    buzz = fft_filter(rng.standard_normal(len(tt)), 2000, 8000) * 0.06 * (1 + np.sin(2 * np.pi * 100 * tt))
    flick = np.ones(len(tt))
    for _ in range(int(sec * 0.6)):
        a = rng.integers(0, len(tt) - SR // 4)
        flick[a : a + int(rng.uniform(0.03, 0.2) * SR)] = rng.uniform(0.1, 0.5)
    room = fft_filter(pink(len(tt)), 40, 500) * 0.25
    return loopify(stereo(norm((hum + buzz) * flick + room, 0.4), 0.5))


def amb_corridor_drone(sec=30):
    tt = t(sec)
    d = np.sin(2 * np.pi * 43 * tt) + np.sin(2 * np.pi * 43.7 * tt) + 0.5 * np.sin(2 * np.pi * 86.3 * tt)
    wind = fft_filter(pink(len(tt)), 100, 1200) * (0.5 + 0.5 * np.sin(2 * np.pi * 0.07 * tt))
    return loopify(stereo(norm(d * 0.5 + wind * 0.6, 0.4), 0.9))


def amb_low_tension(sec=30):
    tt = t(sec)
    s = np.sin(2 * np.pi * 36 * tt) * 0.6 + np.sin(2 * np.pi * 54.4 * tt) * 0.3 + np.sin(2 * np.pi * 72.8 * tt + np.sin(2 * np.pi * 0.2 * tt)) * 0.2
    s *= 0.75 + 0.25 * np.sin(2 * np.pi * 0.13 * tt)
    hiss = fft_filter(pink(len(tt)), 3000, 9000) * 0.05
    return loopify(stereo(norm(s + hiss, 0.45), 0.7))


def amb_basement_hum(sec=30):
    tt = t(sec)
    s = sum(np.sin(2 * np.pi * 60 * k * tt) / (k * k) for k in range(1, 7)) * 0.4
    drip = np.zeros(len(tt))
    for _ in range(int(sec / 2.5)):
        p = rng.integers(0, len(tt) - 6000)
        dt = np.arange(6000) / SR
        drip[p : p + 6000] += np.sin(2 * np.pi * (1800 - 9000 * dt) * dt) * np.exp(-dt * 60) * 0.3
    rumble = fft_filter(brown(len(tt)), 20, 120) * 0.5
    return loopify(stereo(norm(s + rumble + reverb(drip, 1.2, 0.5)[: len(tt)], 0.4), 0.8))


def amb_fire_roar(sec=30):
    n = int(sec * SR)
    roar = fft_filter(brown(n), 20, 400) * 0.8 + fft_filter(pink(n), 300, 3000) * 0.3
    return loopify(stereo(norm(roar + fire_crackle(sec)[:, 0] * 0.6, 0.55), 0.9))


def amb_rain(sec=30):
    n = int(sec * SR)
    r = fft_filter(rng.standard_normal(n), 800, 9000) * 0.4 + fft_filter(pink(n), 100, 900) * 0.3
    return loopify(stereo(norm(r, 0.35), 1))


def amb_city_morning(sec=30):
    tt = t(sec)
    traffic = fft_filter(brown(len(tt)), 30, 600) * 0.6
    birds = np.zeros(len(tt))
    for _ in range(int(sec / 3)):
        p = rng.integers(0, len(tt) - SR // 2)
        bt = np.arange(SR // 3) / SR
        f = 3200 + 900 * np.sin(2 * np.pi * 14 * bt)
        birds[p : p + len(bt)] += np.sin(2 * np.pi * np.cumsum(f) / SR) * np.sin(np.pi * bt / bt[-1]) * 0.15
    return loopify(stereo(norm(traffic + reverb(birds, 1.0, 0.4)[: len(tt)], 0.3), 0.9))


# ------------------------- özel bölüm: KAPI. TAVAN. -------------------------

def slap():
    tt = t(0.5)
    s = fft_filter(rng.standard_normal(len(tt)), 600, 9000) * np.exp(-tt * 70)
    s += fft_filter(rng.standard_normal(len(tt)), 150, 900) * np.exp(-tt * 40) * 0.5
    return stereo(norm(reverb(s, 0.5, 0.2)[: len(tt)], 0.8), 0.2)


def body_fall():
    tt = t(1.6)
    thud = np.sin(2 * np.pi * (55 + 40 * np.exp(-tt * 12)) * tt) * np.exp(-tt * 7)
    cloth = fft_filter(rng.standard_normal(len(tt)), 300, 3500) * np.exp(-tt * 9) * 0.4
    second = np.zeros(len(tt))
    k = int(0.18 * SR)
    second[k:] = thud[: len(tt) - k] * 0.45
    return stereo(norm(reverb(thud + cloth + second, 0.9, 0.25)[: len(tt)], 0.95), 0.3)


def motorbike(sec=6.0):
    tt = t(sec)
    rpm = 38 + 22 * np.clip(tt / 1.5, 0, 1) + 6 * np.sin(2 * np.pi * 0.4 * tt)
    ph = 2 * np.pi * np.cumsum(rpm) / SR
    eng = np.sign(np.sin(ph)) * 0.5 + np.sin(2 * ph) * 0.3 + np.sin(3 * ph) * 0.15
    eng = fft_filter(eng, 30, 2500) + fft_filter(rng.standard_normal(len(tt)), 200, 1800) * 0.15
    pan = np.clip(tt / sec, 0, 1)
    env_ = np.minimum(1, tt / 0.6) * np.minimum(1, (sec - tt) / 1.2)
    l = eng * env_ * (1 - pan * 0.6)
    r = eng * env_ * (0.4 + pan * 0.6)
    return np.stack([norm(l, 0.6), norm(r, 0.6)], 1)


def glass_clink():
    tt = t(1.2)
    s = sum(np.sin(2 * np.pi * f * tt) * np.exp(-tt * d) for f, d in ((2350, 6), (3720, 9), (5100, 12)))
    s += fft_filter(rng.standard_normal(len(tt)), 2000, 9000) * np.exp(-tt * 120) * 0.5
    return stereo(norm(reverb(s, 0.8, 0.2)[: len(tt)], 0.5))


def door_slam():
    tt = t(2.0)
    hit = np.sin(2 * np.pi * (70 + 60 * np.exp(-tt * 20)) * tt) * np.exp(-tt * 9)
    rattle = fft_filter(rng.standard_normal(len(tt)), 800, 5000) * np.exp(-tt * 18) * 0.5
    return stereo(norm(reverb(hit + rattle, 1.6, 0.35)[: len(tt)], 0.95), 0.4)


def liquid_splash():
    tt = t(1.4)
    s = np.zeros(len(tt))
    for _ in range(40):
        p = rng.integers(0, int(0.6 * SR))
        d = np.arange(2500) / SR
        s[p : p + 2500] += np.sin(2 * np.pi * rng.uniform(400, 1400) * d * (1 + d * 8)) * np.exp(-d * 60) * rng.uniform(0.2, 0.8)
    s += fft_filter(rng.standard_normal(len(tt)), 300, 3000) * np.exp(-tt * 6) * 0.4
    return stereo(norm(s, 0.6), 0.3)


def music_cut():
    """Müziğin aniden kesildiği an: kısa bir 'tık' ve boşalan oda."""
    tt = t(0.8)
    c = fft_filter(rng.standard_normal(len(tt)), 200, 6000) * np.exp(-tt * 200)
    hum = np.sin(2 * np.pi * 50 * tt) * np.exp(-tt * 6) * 0.2
    return stereo(norm(c + hum, 0.6))


def amb_party_music(sec=32):
    """Özgün dans ritmi (124 BPM): bas davul, bas hattı, hi-hat, akor — duvar arkasından gibi hafif boğuk."""
    n = int(sec * SR)
    out = np.zeros(n)
    beat = 60 / 124
    tt = np.arange(n) / SR
    for b in range(int(sec / beat)):
        s = int(b * beat * SR)
        kt = np.arange(int(0.25 * SR)) / SR
        kick = np.sin(2 * np.pi * (45 + 90 * np.exp(-kt * 30)) * kt) * np.exp(-kt * 14)
        out[s : s + len(kick)] += kick[: n - s] * 0.9
        hs = s + int(beat / 2 * SR)
        if hs < n - 3000:
            hat = fft_filter(rng.standard_normal(3000), 6000, 12000) * np.exp(-np.arange(3000) / 300)
            out[hs : hs + 3000] += hat * 0.25
        if b % 2 == 1:
            sn = fft_filter(rng.standard_normal(6000), 800, 6000) * np.exp(-np.arange(6000) / 900)
            out[s : s + 6000] += sn[: n - s] * 0.35
    roots = [55, 55, 65.4, 49]
    for i in range(int(sec / (beat * 4))):
        f = roots[i % 4]
        s, e = int(i * 4 * beat * SR), min(n, int((i + 1) * 4 * beat * SR))
        seg = tt[s:e] - tt[s]
        gate = (np.sin(2 * np.pi * seg / (beat / 2)) > -0.3).astype(float)
        out[s:e] += np.sign(np.sin(2 * np.pi * f * seg)) * 0.25 * gate
        out[s:e] += sum(np.sin(2 * np.pi * f * 4 * r * seg) for r in (1, 1.26, 1.5)) * 0.05
    out = lowpass(out, 2200)  # yan odadan duyuluyormuş gibi
    return loopify(stereo(norm(reverb(out, 0.8, 0.25)[:n], 0.7), 0.6), 0.5)


def amb_night_street(sec=30):
    n = int(sec * SR)
    wind = fft_filter(pink(n), 80, 900) * (0.6 + 0.4 * np.sin(2 * np.pi * 0.05 * t(sec)))
    far = fft_filter(brown(n), 30, 300) * 0.5
    dog = np.zeros(n)
    for p in (int(7 * SR), int(19 * SR)):
        for k in range(2):
            d = np.arange(int(0.18 * SR)) / SR
            bark = np.sin(2 * np.pi * (420 - 200 * d) * d) * np.exp(-d * 18)
            q = p + int(k * 0.35 * SR)
            dog[q : q + len(d)] += fft_filter(bark + rng.standard_normal(len(d)) * 0.3, 200, 2500) * 0.15
    return loopify(stereo(norm(wind * 0.5 + far + reverb(dog, 2.0, 0.6)[:n], 0.35), 0.9))


def amb_siren(sec=30):
    tt = t(sec)
    f = 700 + 350 * np.sin(2 * np.pi * 0.35 * tt)
    s = np.sin(2 * np.pi * np.cumsum(f) / SR) + 0.3 * np.sin(4 * np.pi * np.cumsum(f) / SR)
    s = lowpass(s, 1800) * 0.4  # uzaktan
    return loopify(stereo(norm(reverb(s, 2.5, 0.6)[: len(tt)], 0.3), 0.8))


EFFECTS = {
    "knock3": knock3,
    "knock1": knock1,
    "phoneVibrate": phone_vibrate,
    "phoneNotify": phone_notify,
    "phoneRing": phone_ring,
    "heartbeat": heartbeat,
    "clockTick": clock_tick,
    "breath": breath,
    "woodCreak": wood_creak,
    "footsteps": footsteps,
    "metalScrape": metal_scrape,
    "riser": riser,
    "hitLow": hit_low,
    "staticBurst": static_burst,
    "doorHandle": door_handle,
    "paperSlide": paper_slide,
    "fireCrackle": fire_crackle,
    "elevatorDing": elevator_ding,
    "tapeClick": tape_click,
    "glitch": glitch,
    "plasterCrack": plaster_crack,
    "scratching": scratching,
    "doorsOpen": doors_open,
    "powerDown": power_down,
    "childHum": child_hum,
    "suddenSilence": sudden_silence,
    "slap": slap,
    "bodyFall": body_fall,
    "motorbike": motorbike,
    "glassClink": glass_clink,
    "doorSlam": door_slam,
    "liquidSplash": liquid_splash,
    "musicCut": music_cut,
}

AMBIENCE = {
    "roomTone": amb_room_tone,
    "fluorescent": amb_fluorescent,
    "corridorDrone": amb_corridor_drone,
    "lowTension": amb_low_tension,
    "basementHum": amb_basement_hum,
    "fireRoar": amb_fire_roar,
    "rain": amb_rain,
    "cityMorning": amb_city_morning,
    "partyMusic": amb_party_music,
    "nightStreet": amb_night_street,
    "siren": amb_siren,
}


def main():
    out = sys.argv[1] if len(sys.argv) > 1 else "public/audio/sfx"
    only = set(sys.argv[2:])
    os.makedirs(out, exist_ok=True)
    for name, fn in {**EFFECTS, **{f"amb_{k}": v for k, v in AMBIENCE.items()}}.items():
        if only and name not in only:
            continue
        path = os.path.join(out, f"{name}.wav")
        audio = fn()
        if audio.ndim == 1:
            audio = stereo(audio)
        sf.write(path, audio.astype(np.float32), SR, subtype="PCM_16")
        print(f"✓ {name:16s} {len(audio) / SR:5.2f}s")


if __name__ == "__main__":
    main()
