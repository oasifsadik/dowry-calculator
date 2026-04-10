<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎊 রেজাল্ট: {{ $data['name'] }} ভাই এর যৌতুক!</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Baloo+Da+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --red:    #E63946;
            --orange: #FF6B2B;
            --yellow: #FFD166;
            --green:  #06D6A0;
            --teal:   #118AB2;
            --navy:   #073B4C;
            --cream:  #FFF8F0;
            --tier:   {{ $data['tierColor'] }};
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Hind Siliguri', sans-serif;
            background: var(--cream); min-height: 100vh; overflow-x: hidden;
        }
        body::before {
            content: ''; position: fixed; inset: 0;
            background:
                radial-gradient(ellipse at 20% 10%, rgba(230,57,70,.14) 0%, transparent 55%),
                radial-gradient(ellipse at 80% 90%, rgba(255,107,43,.12) 0%, transparent 55%);
            pointer-events: none; z-index: 0;
        }

        /* Floating emojis */
        .floaters { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .floater  { position: absolute; opacity: .13; animation: rise linear infinite; }
        @keyframes rise {
            from { transform: translateY(105vh) rotate(0deg);   opacity: .13; }
            to   { transform: translateY(-10vh)  rotate(360deg); opacity: 0;   }
        }

        /* Confetti */
        .cc { position: fixed; inset: 0; pointer-events: none; z-index: 999; overflow: hidden; }
        .cp {
            position: absolute; top: -12px; border-radius: 3px;
            animation: cf linear forwards;
        }
        @keyframes cf {
            0%   { transform: translateY(0)    rotate(0deg);   opacity: 1; }
            100% { transform: translateY(110vh) rotate(720deg); opacity: 0; }
        }

        .wrap { position: relative; z-index: 1; max-width: 820px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }

        /* ── HERO CARD ── */
        .hero {
            background: linear-gradient(145deg, var(--navy), #0a4f6a, var(--teal));
            border-radius: 28px; padding: 3rem 2rem 2.5rem;
            text-align: center; position: relative; overflow: hidden;
            box-shadow: 0 25px 70px rgba(7,59,76,.35);
            animation: pop .6s cubic-bezier(.34,1.56,.64,1) both;
        }
        @keyframes pop { from { opacity:0; transform:scale(.88); } to { opacity:1; transform:scale(1); } }

        /* Big decorative emoji */
        .hero::before {
            content: '💒'; position: absolute; font-size: 9rem;
            opacity: .06; bottom: -1.5rem; right: -1rem; line-height: 1;
        }
        .hero::after {
            content: '💍'; position: absolute; font-size: 5rem;
            opacity: .07; top: -1rem; left: -0.5rem; line-height: 1;
        }

        /* Big emoji avatar */
        .avatar-ring {
            width: 110px; height: 110px; border-radius: 50%;
            border: 4px solid rgba(255,255,255,.25);
            background: rgba(255,255,255,.12);
            display: grid; place-items: center;
            font-size: 4rem; margin: 0 auto 1.2rem;
            animation: bounce 2.5s ease-in-out infinite;
        }
        @keyframes bounce {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-8px); }
        }

        .tier-pill {
            display: inline-block;
            background: var(--tier);
            color: #000; font-weight: 800; font-size: .88rem;
            padding: .38rem 1.1rem; border-radius: 999px;
            letter-spacing: .04em; margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,.25);
            animation: pop .7s .2s both;
        }
        .hero-name {
            font-family: 'Baloo Da 2', cursive;
            color: #fff; font-size: clamp(1.6rem, 5vw, 2.4rem); font-weight: 800;
            line-height: 1.15; margin-bottom: .35rem;
            animation: pop .7s .3s both;
        }
        .hero-meta {
            color: rgba(255,255,255,.65); font-size: .9rem;
            animation: pop .7s .4s both;
        }
        .hero-desc {
            margin-top: .9rem; background: rgba(255,255,255,.12);
            border-radius: 12px; padding: .6rem 1rem;
            color: rgba(255,255,255,.85); font-size: .92rem; font-style: italic;
            animation: pop .7s .5s both;
        }

        /* ── AMOUNT SECTION ── */
        .amount-card {
            background: #fff; border-radius: 24px; margin-top: 1.5rem;
            box-shadow: 0 15px 50px rgba(0,0,0,.07);
            padding: 2.5rem 2rem; text-align: center;
            animation: rise2 .6s .3s ease both;
        }
        @keyframes rise2 { from { opacity:0; transform:translateY(25px); } to { opacity:1; transform:translateY(0); } }

        .amount-lbl {
            font-size: .82rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: .14em; color: #bbb; margin-bottom: .6rem;
        }
        .amount-num {
            font-family: 'Baloo Da 2', cursive;
            font-size: clamp(2.8rem, 8vw, 4.5rem); font-weight: 800; line-height: 1;
            background: linear-gradient(135deg, var(--red), var(--orange));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .amount-word { color: #aaa; font-size: .92rem; margin-top: .35rem; }

        .fun-box {
            display: inline-block; margin-top: 1.2rem;
            background: linear-gradient(135deg, #FFF3CD, #FFE8A3);
            border: 1.5px solid #FFD166; border-radius: 14px;
            padding: .8rem 1.3rem; font-size: .97rem; font-weight: 600; color: #6B4A00;
            animation: wiggle 1s .8s ease both;
        }
        @keyframes wiggle {
            0%,100% { transform: rotate(0deg); }
            25%      { transform: rotate(-2deg); }
            75%      { transform: rotate(2deg); }
        }

        .fact-box {
            display: block; margin-top: .8rem;
            background: linear-gradient(135deg, #E8F8F5, #D1F2EB);
            border: 1.5px solid #A9DFBF; border-radius: 14px;
            padding: .7rem 1.2rem; font-size: .9rem; font-weight: 500; color: #1E8449;
        }

        /* ── BREAKDOWN ── */
        .bd-card {
            background: #fff; border-radius: 24px; margin-top: 1.5rem;
            box-shadow: 0 15px 50px rgba(0,0,0,.07); padding: 1.8rem 2rem;
            animation: rise2 .6s .5s ease both;
        }
        .bd-title {
            font-family: 'Baloo Da 2', cursive; font-size: 1.15rem; font-weight: 700;
            color: var(--navy); margin-bottom: 1.1rem; display: flex; align-items: center; gap: .5rem;
        }
        .bd-list { display: flex; flex-direction: column; gap: .5rem; }

        .bd-item {
            display: flex; align-items: center; gap: .8rem;
            padding: .65rem .9rem; border-radius: 11px; background: #FAFAFA;
            transition: background .2s;
        }
        .bd-item:hover { background: #FFF0EC; }
        .bd-item.negative { background: #FFF5F5; }
        .bd-item.negative:hover { background: #FFE8E8; }

        .bd-lbl { flex: 1; font-size: .88rem; color: #555; }
        .bd-bar-wrap { flex: 2; height: 6px; background: #eee; border-radius: 999px; overflow: hidden; }
        .bd-bar {
            height: 100%; border-radius: 999px; width: 0;
            transition: width 1.2s cubic-bezier(.22,1,.36,1);
        }
        .bd-bar.pos { background: linear-gradient(90deg, var(--red), var(--orange)); }
        .bd-bar.neg { background: linear-gradient(90deg, #95A5A6, #7F8C8D); }
        .bd-amt { font-weight: 700; font-size: .84rem; min-width: 100px; text-align: right; }
        .bd-amt.pos { color: var(--red); }
        .bd-amt.neg { color: #95A5A6; }

        /* ── ACTIONS ── */
        .actions {
            display: flex; gap: 1rem; flex-wrap: wrap;
            margin-top: 1.5rem; animation: rise2 .6s .7s ease both;
        }
        .btn {
            flex: 1; min-width: 130px; padding: .85rem 1.2rem;
            border: none; border-radius: 13px; cursor: pointer;
            font-family: 'Hind Siliguri', sans-serif; font-size: .95rem; font-weight: 600;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            transition: transform .2s, box-shadow .2s;
        }
        .btn:hover { transform: translateY(-2px); }

        .btn-back   { background: #f0f0f0; color: var(--navy); }
        .btn-share  {
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: #fff; box-shadow: 0 6px 20px rgba(37,211,102,.3);
        }
        .btn-copy   {
            background: linear-gradient(135deg, var(--teal), var(--navy));
            color: #fff; box-shadow: 0 6px 20px rgba(17,138,178,.3);
        }
        .btn-again  {
            background: linear-gradient(135deg, var(--red), var(--orange));
            color: #fff; box-shadow: 0 6px 20px rgba(230,57,70,.3);
        }

        /* Toast */
        .toast {
            position: fixed; bottom: 1.5rem; left: 50%;
            transform: translateX(-50%) translateY(5rem);
            background: var(--navy); color: #fff;
            padding: .75rem 1.4rem; border-radius: 999px;
            font-size: .88rem; transition: transform .3s; z-index: 9999; white-space: nowrap;
        }
        .toast.on { transform: translateX(-50%) translateY(0); }

        footer { text-align: center; padding: 2rem 1rem; color: #bbb; font-size: .82rem; }
        footer strong { color: var(--red); }
    </style>
</head>
<body>

<div class="floaters" id="fl"></div>
<div class="cc"       id="cc"></div>
<div class="toast"    id="toast"></div>

<div class="wrap">

    <!-- HERO -->
    <div class="hero">
        <div class="avatar-ring">{{ $data['tierEmoji'] }}</div>
        <div class="tier-pill">{{ $data['tierLabel'] }}</div>
        <div class="hero-name">{{ $data['name'] }} ভাই</div>
        <div class="hero-meta">
            বয়স: {{ $data['age'] }} বছর &nbsp;·&nbsp; {{ $data['profession'] }} &nbsp;·&nbsp; {{ $data['district'] }}
        </div>
        <div class="hero-desc">"{{ $data['tierDesc'] }}"</div>
    </div>

    <!-- AMOUNT -->
    <div class="amount-card">
        <div class="amount-lbl">আপনার মোট যৌতুকের পরিমাণ</div>
        <div class="amount-num" id="amountNum">৳ 0</div>
        <div class="amount-word" id="amountWord"></div>
        <div class="fun-box">😂 {{ $data['funMessage'] }}</div>
        <div class="fact-box">{{ $data['funFact'] }}</div>
    </div>

    <!-- ACTIONS -->
    <div class="actions">
        <a href="/" class="btn btn-back">🏠 ফিরে যান</a>
        <button class="btn btn-again" id="btnAgain">🎲 আবার হিসাব করুন</button>
        <button class="btn btn-copy"  id="btnCopy">📋 কপি করুন</button>
        <button class="btn btn-share" id="btnShare">📱 শেয়ার করুন</button>
    </div>

    <footer>
        <p>⚠️ এটি সম্পূর্ণ <strong>মজার জন্য</strong> তৈরি। যৌতুক আইনত দণ্ডনীয় অপরাধ 💚</p>
    </footer>
</div>

<script>
// ── Data from PHP ──────────────────────────────────────────
const TOTAL = {{ $data['total'] }};
const NAME  = @json($data['name']);

// ── Floaters ──────────────────────────────────────────────
const emo = ['💍','👰','💒','🎊','💐','🥳','🎉','❤️','🌸','😂','💸','🏚️'];
const fc  = document.getElementById('fl');
for (let i = 0; i < 16; i++) {
    const d = document.createElement('div');
    d.className = 'floater';
    d.textContent = emo[Math.floor(Math.random() * emo.length)];
    d.style.cssText = `left:${Math.random()*100}vw;font-size:${1+Math.random()*1.8}rem;animation-duration:${8+Math.random()*14}s;animation-delay:${Math.random()*8}s`;
    fc.appendChild(d);
}

// ── Confetti ──────────────────────────────────────────────
function launchConfetti() {
    const colors = ['#E63946','#FF6B2B','#FFD166','#06D6A0','#118AB2','#FF6B9D','#9B59B6'];
    const cc = document.getElementById('cc');
    for (let i = 0; i < 100; i++) {
        const p = document.createElement('div');
        p.className = 'cp';
        const sz = 6 + Math.random() * 10;
        p.style.cssText = `
            left:${Math.random()*100}vw;
            width:${sz}px; height:${sz}px;
            background:${colors[Math.floor(Math.random()*colors.length)]};
            border-radius:${Math.random()>.5?'50%':'3px'};
            animation-duration:${1.5+Math.random()*2.5}s;
            animation-delay:${Math.random()*.6}s;
        `;
        cc.appendChild(p);
        setTimeout(() => p.remove(), 5000);
    }
}

// ── Counter animation ─────────────────────────────────────
function formatBDT(n) {
    return '৳ ' + Math.abs(n).toLocaleString('en-BD');
}
function inWords(n) {
    if (n >= 10000000) return (n/10000000).toFixed(2) + ' কোটি টাকা';
    if (n >= 100000)   return (n/100000).toFixed(2)   + ' লক্ষ টাকা';
    if (n >= 1000)     return (n/1000).toFixed(1)     + ' হাজার টাকা';
    return n + ' টাকা';
}
function animCount(el, target, dur = 2000) {
    const s = performance.now();
    (function f(now) {
        const p = Math.min((now - s) / dur, 1);
        const e = 1 - Math.pow(1 - p, 4);
        el.textContent = formatBDT(Math.floor(e * target));
        if (p < 1) requestAnimationFrame(f);
    })(performance.now());
}

// ── Init on load ──────────────────────────────────────────
window.addEventListener('load', () => {
    launchConfetti();
    animCount(document.getElementById('amountNum'), TOTAL);
    document.getElementById('amountWord').textContent = inWords(TOTAL);

    // Animate bars
    setTimeout(() => {
        document.querySelectorAll('.bd-item').forEach(row => {
            row.querySelector('.bd-bar').style.width = row.dataset.pct + '%';
        });
    }, 400);
});

// ── Toast ─────────────────────────────────────────────────
function toast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg; t.classList.add('on');
    setTimeout(() => t.classList.remove('on'), 2600);
}

// ── Share text ────────────────────────────────────────────
function buildShareText() {
    const formatted = '৳ ' + TOTAL.toLocaleString('en-BD');
    return `আমি যৌতুক ক্যালকুলেটরে হিসাব করলাম!\n${NAME} ভাই এর যৌতুক: ${formatted} 😂\nতুমিও হিসাব করো: {{ url('/') }}`;
}

// ── Buttons ───────────────────────────────────────────────
document.getElementById('btnShare').addEventListener('click', () => {
    const text = buildShareText();
    if (navigator.share) {
        navigator.share({ title: 'যৌতুক ক্যালকুলেটর', text });
    } else {
        navigator.clipboard.writeText(text).then(() => toast('✅ কপি হয়ে গেছে! শেয়ার করুন!'));
    }
});

document.getElementById('btnCopy').addEventListener('click', () => {
    navigator.clipboard.writeText(buildShareText())
        .then(() => toast('✅ ক্লিপবোর্ডে কপি হয়েছে!'));
});

document.getElementById('btnAgain').addEventListener('click', () => {
    window.location.href = '/';
});
</script>
</body>
</html>