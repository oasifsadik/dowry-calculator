<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>🎊 যৌতুক ক্যালকুলেটর — বাংলাদেশের #১ মজার সাইট!</title>
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
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Hind Siliguri', sans-serif;
            background: var(--cream);
            min-height: 100vh;
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse at 15% 15%, rgba(230,57,70,.13) 0%, transparent 50%),
                radial-gradient(ellipse at 85% 85%, rgba(255,107,43,.11) 0%, transparent 50%);
            pointer-events: none; z-index: 0;
        }

        /* Floating emojis */
        .floaters { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .floater {
            position: absolute; font-size: 1.8rem; opacity: .12;
            animation: rise linear infinite;
        }
        @keyframes rise {
            from { transform: translateY(105vh) rotate(0deg);   opacity: .12; }
            to   { transform: translateY(-10vh)  rotate(360deg); opacity: 0;   }
        }

        .wrap { position: relative; z-index: 1; max-width: 820px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }

        /* Header */
        header { text-align: center; padding: 2.5rem 1rem 1.8rem; animation: drop .7s ease both; }
        @keyframes drop {
            from { opacity: 0; transform: translateY(-28px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--red), var(--orange));
            color: #fff; font-size: .78rem; font-weight: 700;
            letter-spacing: .12em; text-transform: uppercase;
            padding: .32rem .95rem; border-radius: 999px; margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(230,57,70,.4);
        }
        h1 {
            font-family: 'Baloo Da 2', cursive;
            font-size: clamp(2.2rem, 6vw, 3.6rem); font-weight: 800; line-height: 1.1;
            background: linear-gradient(135deg, var(--red) 0%, var(--orange) 55%, var(--yellow) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
            margin-bottom: .5rem;
        }
        .subtitle { color: #666; font-size: 1rem; }
        .subtitle strong { color: var(--red); }

        /* Card */
        .card {
            background: #fff; border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,.08), 0 4px 16px rgba(230,57,70,.05);
            overflow: hidden; animation: rise2 .7s .2s ease both;
        }
        @keyframes rise2 { from { opacity:0; transform:translateY(28px); } to { opacity:1; transform:translateY(0); } }

        .card-top {
            background: linear-gradient(135deg, var(--red), var(--orange));
            padding: 1.6rem 2rem; display: flex; align-items: center; gap: 1rem;
        }
        .card-top-icon {
            font-size: 2rem; background: rgba(255,255,255,.2);
            width: 52px; height: 52px; border-radius: 14px;
            display: grid; place-items: center; flex-shrink: 0;
        }
        .card-top h2 { color: #fff; font-family: 'Baloo Da 2', cursive; font-size: 1.35rem; font-weight: 700; }
        .card-top p  { color: rgba(255,255,255,.85); font-size: .88rem; margin-top: .12rem; }

        /* Form */
        .form-body { padding: 2rem; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.15rem; }
        @media (max-width: 580px) { .grid { grid-template-columns: 1fr; } }

        .fg { display: flex; flex-direction: column; gap: .42rem; }
        .fg.full { grid-column: 1 / -1; }

        label {
            font-size: .83rem; font-weight: 600; color: var(--navy);
            display: flex; align-items: center; gap: .38rem;
        }
        .opt { font-size: .72rem; font-weight: 400; color: #bbb; margin-left: auto; }

        input, select {
            width: 100%; padding: .72rem 1rem;
            border: 2px solid #eee; border-radius: 12px;
            font-family: 'Hind Siliguri', sans-serif; font-size: .95rem; color: var(--navy);
            background: #FAFAFA; outline: none; appearance: none;
            transition: border-color .22s, box-shadow .22s, background .22s;
        }
        input:focus, select:focus {
            border-color: var(--red); background: #fff;
            box-shadow: 0 0 0 4px rgba(230,57,70,.10);
        }
        select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23E63946' stroke-width='2.5'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right .85rem center;
            padding-right: 2.4rem; cursor: pointer;
        }
        .err { color: var(--red); font-size: .76rem; font-weight: 500; display: none; }
        .inp-err { border-color: var(--red) !important; }

        /* Submit */
        .btn-submit {
            width: 100%; margin-top: .6rem; padding: 1rem 2rem;
            background: linear-gradient(135deg, var(--red), var(--orange));
            color: #fff; border: none; border-radius: 14px;
            font-family: 'Baloo Da 2', cursive; font-size: 1.18rem; font-weight: 700;
            cursor: pointer; display: flex; align-items: center; justify-content: center; gap: .6rem;
            box-shadow: 0 8px 25px rgba(230,57,70,.35);
            transition: transform .2s, box-shadow .2s;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 14px 35px rgba(230,57,70,.45); }
        .btn-submit:active { transform: none; }
        .btn-submit.busy { pointer-events: none; opacity: .8; }
        .spin {
            width: 20px; height: 20px; border: 3px solid rgba(255,255,255,.35);
            border-top-color: #fff; border-radius: 50%;
            animation: sp .7s linear infinite; display: none;
        }
        .btn-submit.busy .spin { display: block; }
        @keyframes sp { to { transform: rotate(360deg); } }
        .btn-txt::after { content: 'যৌতুক হিসাব করুন 💍'; }
        .btn-submit.busy .btn-txt::after { content: 'হিসাব করছি...'; }

        /* Disclaimer */
        .disclaimer {
            margin-top: 1rem; padding: .75rem 1rem;
            background: #FFF9EC; border: 1px solid #FFD166; border-radius: 10px;
            font-size: .82rem; color: #7A5C00; text-align: center; line-height: 1.5;
        }

        footer { text-align: center; padding: 2rem 1rem; color: #bbb; font-size: .83rem; animation: rise2 .7s .4s ease both; }
        footer strong { color: var(--red); }

        /* Toast */
        .toast {
            position: fixed; bottom: 1.5rem; left: 50%;
            transform: translateX(-50%) translateY(5rem);
            background: var(--navy); color: #fff;
            padding: .75rem 1.4rem; border-radius: 999px;
            font-size: .88rem; transition: transform .3s; z-index: 999; white-space: nowrap;
        }
        .toast.on { transform: translateX(-50%) translateY(0); }
    </style>
</head>
<body>

<div class="floaters" id="fl"></div>
<div class="toast" id="toast"></div>

<div class="wrap">

    <header>
        <div class="badge">🎊 বাংলাদেশের সেরা মজার সাইট</div>
        <h1>যৌতুক ক্যালকুলেটর 💒</h1>
        <p class="subtitle">তথ্য দিন, জানুন আপনি কত <strong>টাকা যৌতুক</strong> পাওয়ার যোগ্য! (প্রতিবার ভিন্ন রেজাল্ট 🎲)</p>
    </header>

    <div class="card">
        <div class="card-top">
            <div class="card-top-icon">📋</div>
            <div>
                <h2>পাত্রের তথ্য পূরণ করুন</h2>
                <p>সব তথ্য সঠিকভাবে দিন — যত সৎ, তত মজার রেজাল্ট!</p>
            </div>
        </div>

        <form class="form-body" id="jForm" novalidate>
            @csrf
            <div class="grid">

                <div class="fg">
                    <label>👤 আপনার নাম</label>
                    <input type="text" name="name" id="name" placeholder="যেমন: জিসান করিম">
                    <span class="err" id="e-name"></span>
                </div>

                <div class="fg">
                    <label>🎂 বয়স (বছর)</label>
                    <input type="number" name="age" id="age" placeholder="যেমন: 26" min="18" max="60">
                    <span class="err" id="e-age"></span>
                </div>

                <div class="fg">
                    <label>💼 পেশা</label>
                    <select name="profession" id="profession">
                        <option value="">— পেশা বেছে নিন —</option>
                        <option value="student">ছাত্র 🎓</option>
                        <option value="job_holder">চাকরিজীবী 👔</option>
                        <option value="business">ব্যবসায়ী 💰</option>
                    </select>
                    <span class="err" id="e-profession"></span>
                </div>

                <div class="fg">
                    <label>🎓 শিক্ষাগত যোগ্যতা</label>
                    <select name="education" id="education">
                        <option value="">— শিক্ষা বেছে নিন —</option>
                        <option value="ssc">SSC পাস</option>
                        <option value="hsc">HSC পাস</option>
                        <option value="bachelor">স্নাতক (Bachelor)</option>
                        <option value="masters">স্নাতকোত্তর (Masters)</option>
                        <option value="phd">PhD 🔬</option>
                    </select>
                    <span class="err" id="e-education"></span>
                </div>

                <div class="fg">
                    <label>💵 মাসিক আয় (টাকা) <span class="opt">ঐচ্ছিক</span></label>
                    <input type="number" name="income" id="income" placeholder="যেমন: 50000" min="0">
                </div>

                <div class="fg">
                    <label>📍 জেলা</label>
                    <input type="text" name="district" id="district" placeholder="যেমন: ঢাকা">
                    <span class="err" id="e-district"></span>
                </div>

                <div class="fg">
                    <label>📏 উচ্চতা</label>
                    <select name="height" id="height">
                        <option value="">— উচ্চতা বেছে নিন —</option>
                        <option value="short">খাটো (5′ এর নিচে)</option>
                        <option value="average">মাঝারি (5′–5′7″)</option>
                        <option value="tall">লম্বা (5′8″–5′11″)</option>
                        <option value="very_tall">অনেক লম্বা (6′+) 🏀</option>
                    </select>
                    <span class="err" id="e-height"></span>
                </div>

                <div class="fg">
                    <label>😎 চেহারা</label>
                    <select name="looks" id="looks">
                        <option value="">— চেহারা বেছে নিন —</option>
                        <option value="simple">সাদামাটা</option>
                        <option value="average">মোটামুটি</option>
                        <option value="handsome">সুদর্শন ✨</option>
                        <option value="very_handsome">অসাধারণ সুন্দর 🌟</option>
                    </select>
                    <span class="err" id="e-looks"></span>
                </div>

            </div>

            <button type="submit" class="btn-submit" id="subBtn">
                <div class="spin"></div>
                <span class="btn-txt"></span>
            </button>

            <p class="disclaimer">⚠️ এটি সম্পূর্ণ <strong>মজার জন্য</strong> তৈরি। যৌতুক আইনত দণ্ডনীয় অপরাধ — দেবেন না, নেবেন না! 💚</p>
        </form>
    </div>

    <footer>
        <p>Made with ❤️ & 😂 by <strong><a href="https://www.facebook.com/oasifsadikjisan" target="_blank">Oasif Sadik Jisan</a></strong></p>
    </footer>

</div>

<script>
// Floaters
const emo = ['💍','👰','💒','🎊','💐','🥳','💃','🎉','❤️','🌸','😂','💸'];
const fc  = document.getElementById('fl');
for (let i = 0; i < 14; i++) {
    const d = document.createElement('div');
    d.className = 'floater';
    d.textContent = emo[Math.floor(Math.random() * emo.length)];
    d.style.cssText = `left:${Math.random()*100}vw;animation-duration:${9+Math.random()*13}s;animation-delay:${Math.random()*10}s;font-size:${1.1+Math.random()*1.4}rem`;
    fc.appendChild(d);
}

function toast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg; t.classList.add('on');
    setTimeout(() => t.classList.remove('on'), 2600);
}

function clearErrs() {
    document.querySelectorAll('.err').forEach(e => { e.textContent = ''; e.style.display = 'none'; });
    document.querySelectorAll('.inp-err').forEach(e => e.classList.remove('inp-err'));
}
function showErr(id, msg) {
    const e = document.getElementById('e-' + id); if (e) { e.textContent = msg; e.style.display = 'block'; }
    const i = document.getElementById(id); if (i) i.classList.add('inp-err');
}

document.getElementById('jForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    clearErrs();
    const btn = document.getElementById('subBtn');
    btn.classList.add('busy');

    try {
        const res  = await fetch('{{ route("joutuk.calculate") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: new FormData(this),
        });
        const data = await res.json();

        if (!res.ok) {
            if (data.errors) {
                const map = { name:'name', age:'age', profession:'profession',
                              education:'education', district:'district',
                              height:'height', looks:'looks' };
                Object.entries(data.errors).forEach(([k, v]) => { if (map[k]) showErr(map[k], v[0]); });
            }
            return;
        }
        if (data.success && data.redirect) {
            window.location.href = data.redirect;
        }
    } catch {
        toast('কিছু একটা সমস্যা হয়েছে! আবার চেষ্টা করুন।');
    } finally {
        btn.classList.remove('busy');
    }
});
</script>
</body>
</html>