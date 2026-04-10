<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JoutukController extends Controller
{
    public function index()
    {
        return view('index');
    }
 
    public function result()
    {
        if (! session()->has('joutuk_result')) {
            return redirect()->route('joutuk.index');
        }
        $data = session('joutuk_result');
        return view('result', compact('data'));
    }
 
    public function calculate(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'age'        => 'required|integer|min:18|max:60',
            'profession' => 'required|in:student,job_holder,business,bekar,juyari',
            'education'  => 'required|in:ssc,hsc,bachelor,masters,phd',
            'income'     => 'nullable|integer|min:0',
            'height'     => 'required|in:short,average,tall,very_tall',
            'looks'      => 'required|in:simple,average,handsome,very_handsome',
            'district'   => 'required|string|max:100',
        ]);
 
        // ═══ BASE (অনেক কমানো হয়েছে) ══════════════════════════════
        $base = match ($request->profession) {
            'student'    => 30000,
            'job_holder' => 120000,
            'business'   => 300000,
            'bekar'      => -20000,   // বেকার হলে উল্টো মাইনাস! 😂
            'juyari'     => -50000,   // জুয়ারি — সবচেয়ে বিপদ! 💀
        };
 
        // ═══ EDUCATION ═══════════════════════════════════════════════
        $educationBonus = match ($request->education) {
            'ssc'     => 0,
            'hsc'     => 5000,
            'bachelor'=> 25000,
            'masters' => 60000,
            'phd'     => 150000,
        };
 
        // ═══ AGE ═════════════════════════════════════════════════════
        $age       = (int) $request->age;
        $ageFactor = max(0, (30 - $age)) * 1500;
 
        // ═══ INCOME ══════════════════════════════════════════════════
        $income      = (int) ($request->income ?? 0);
        $incomeBonus = (int) ($income * 2.5); // আড়াই মাসের বেতন
 
        // ═══ HEIGHT ══════════════════════════════════════════════════
        $heightBonus = match ($request->height) {
            'short'    => -10000,
            'average'  => 5000,
            'tall'     => 15000,
            'very_tall'=> 30000,
        };
 
        // ═══ LOOKS ═══════════════════════════════════════════════════
        $looksBonus = match ($request->looks) {
            'simple'       => 0,
            'average'      => 3000,
            'handsome'     => 15000,
            'very_handsome'=> 35000,
        };
 
        // ═══ DISTRICT ════════════════════════════════════════════════
        $premiumDistricts = ['dhaka','ঢাকা','chittagong','চট্টগ্রাম','sylhet','সিলেট','rajshahi','রাজশাহী'];
        $districtBonus    = in_array(mb_strtolower($request->district), $premiumDistricts) ? 20000 : 5000;
 
        // ═══ RANDOM MARKET FACTOR ════════════════════════════════════
        $randomMultiplier = mt_rand(60, 130) / 100;
 
        // ═══ RANDOM FUNNY BONUSES ════════════════════════════════════
        $funnyBonuses = [
            ['label' => '🌙 রাতে নাক ডাকার বিশেষ ট্যাক্স',           'amount' => -mt_rand(2000,  8000)],
            ['label' => '☕ চা না খেলে বিপদ ভাতা',                    'amount' =>  mt_rand(1000,  6000)],
            ['label' => '📱 রিলস দেখার সময় অপচয় জরিমানা',             'amount' => -mt_rand(1000,  5000)],
            ['label' => '🍛 ভাত ৩ প্লেট খাওয়ার সারচার্জ',             'amount' => -mt_rand(500,   3000)],
            ['label' => '💪 জিমে যাওয়ার বডি প্রিমিয়াম',               'amount' =>  mt_rand(5000, 15000)],
            ['label' => '🎮 গেমার লাইফস্টাইল ট্যাক্স',                'amount' => -mt_rand(2000,  8000)],
            ['label' => '🧔 দাড়ির স্টাইল পয়েন্ট বোনাস',              'amount' =>  mt_rand(1000,  5000)],
            ['label' => '🚗 গাড়ি-বাইক সম্পদ প্রিমিয়াম',              'amount' =>  mt_rand(8000, 25000)],
            ['label' => '😴 দিনে ঘুমানোর অলসতা জরিমানা',              'amount' => -mt_rand(2000, 10000)],
            ['label' => '🍳 রান্না জানার বিরল প্রতিভা বোনাস',          'amount' =>  mt_rand(3000, 12000)],
            ['label' => '📚 বই পড়ার বুদ্ধিজীবী সার্টিফিকেট',          'amount' =>  mt_rand(1500,  7000)],
            ['label' => '🌿 চুলে তেল দেওয়ার ঐতিহ্য পুরস্কার',         'amount' =>  mt_rand(500,   3000)],
            ['label' => '🐓 মুরগি খাওয়ার বিশেষ দক্ষতা বোনাস',         'amount' =>  mt_rand(500,   2500)],
            ['label' => '😤 রাগ হলে কথা না বলার রিস্ক প্রিমিয়াম',     'amount' => -mt_rand(3000, 12000)],
            ['label' => '🎤 বেসুরো গান গাওয়ার শাস্তি',                'amount' => -mt_rand(1000,  4000)],
            ['label' => '🏏 ক্রিকেট দেখতে বসলে ওঠে না ট্যাক্স',       'amount' => -mt_rand(1500,  6000)],
            ['label' => '🌞 সকালে উঠতে না পারার জরিমানা',             'amount' => -mt_rand(800,   4000)],
            ['label' => '🥊 তর্কে কখনো হারে না বোনাস',                'amount' =>  mt_rand(2000,  9000)],
            ['label' => '🪥 দাঁত ব্রাশ না করার বিশেষ জরিমানা',         'amount' => -mt_rand(1000,  5000)],
            ['label' => '🐟 মাছ কাটতে পারার বিরল দক্ষতা',             'amount' =>  mt_rand(500,   3000)],
            ['label' => '📺 নাটক দেখার নেশার ট্যাক্স',                'amount' => -mt_rand(1000,  4500)],
            ['label' => '🧦 মোজা গন্ধের বিশেষ ডিসকাউন্ট',            'amount' => -mt_rand(500,   2000)],
            ['label' => '🤳 সেলফি তোলার অভ্যাস ভাতা',                'amount' =>  mt_rand(1000,  4000)],
            ['label' => '🎯 লক্ষ্যহীন জীবনের রিস্ক ফি',               'amount' => -mt_rand(5000, 20000)],
        ];
 
        $pickedKeys   = array_rand($funnyBonuses, 2);
        $randomBonus1 = $funnyBonuses[$pickedKeys[0]];
        $randomBonus2 = $funnyBonuses[$pickedKeys[1]];
 
        // ═══ CALCULATE ════════════════════════════════════════════════
        $subTotal         = $base + $educationBonus + $ageFactor + $incomeBonus
                          + $heightBonus + $looksBonus + $districtBonus;
        $marketAdjustment = (int) (($randomMultiplier - 1.0) * $subTotal);
        $subTotal         = (int) ($subTotal * $randomMultiplier);
        $total            = $subTotal + $randomBonus1['amount'] + $randomBonus2['amount'];
 
        // বেকার বা জুয়ারি হলে minimum আরও কম 😂
        $minAmount = in_array($request->profession, ['bekar', 'juyari']) ? 1000 : 5000;
        $total     = max($minAmount, $total);
 
        // ═══ TIER ═════════════════════════════════════════════════════
        [$tierLabel, $tierColor, $tierEmoji, $tierDesc] = match (true) {
            $total >= 500000  => ['কোটিপতি জামাই',      '#FFD700', '👑', 'শ্বশুর বাড়ি বিক্রি করেও কুলাবে না!'],
            $total >= 200000  => ['মেগা সুপার জামাই',    '#FF4500', '🔥', 'পাত্রীর বাবা হার্ট অ্যাটাকের কিনারায়!'],
            $total >= 100000  => ['হাই-ভোল্টেজ জামাই',  '#9B59B6', '⚡', 'শ্বশুর বাড়ির সব সম্পদ জমা হচ্ছে!'],
            $total >= 50000   => ['প্রিমিয়াম জামাই',    '#E63946', '🌟', 'পাত্রী পক্ষ রাতের ঘুম হারিয়েছে!'],
            $total >= 20000   => ['ভালোমানের জামাই',    '#118AB2', '😎', 'মধ্যবিত্ত শ্বশুর বাড়ি ঋণ নেবে!'],
            $total >= 5000    => ['মোটামুটি জামাই',     '#06D6A0', '🙂', 'শ্বশুর বাড়ি দরদাম করতে আসবে!'],
            $total >= 1000    => ['সাদামাটা জামাই',     '#95A5A6', '😅', 'বর পক্ষ পালাবে কিনা সন্দেহ!'],
            default           => ['নো-ভ্যালু জামাই',    '#7F8C8D', '💀', 'শ্বশুর বাড়ি উল্টো মামলা দেবে!'],
        };
 
        // বেকার/জুয়ারির জন্য special tier override
        if ($request->profession === 'bekar') {
            $tierLabel = 'বেকার জামাই'; $tierColor = '#E74C3C';
            $tierEmoji = '🥲'; $tierDesc = 'পাত্রীর বাবা বললেন: চাকরি পাইলে আসো!';
        }
        if ($request->profession === 'juyari') {
            $tierLabel = 'জুয়ারি জামাই'; $tierColor = '#2C3E50';
            $tierEmoji = '🎰'; $tierDesc = 'পাত্রীর মা বললেন: আল্লাহ মাফ করো!';
        }
 
        // ═══ FUNNY MESSAGES (বেশি মজার) ═══════════════════════════════
        $funMessages = [
            "শ্বশুর মশাই চশমা মুছে আবার হিসাব মিলাচ্ছেন! 🤓",
            "পাত্রীর মা বেহুশ হয়ে গেছেন! 😵",
            "শ্বশুর বাড়িতে জরুরি পারিবারিক মিটিং ডাকা হয়েছে! 🚨",
            "পাত্রী পক্ষ ক্যালকুলেটর ভেঙে ফেলেছে! 💥",
            "শ্বশুর বলছেন: 'মেয়েটারে বিদেশে পাঠায় দিলেই হত!' 😒",
            "পাত্রীর ভাই বলেছে: 'আমি আর কোনো দিন বিয়ে করুম না!' 🙅",
            "পাড়ার সবাই শুনে বলছে: 'এই জামাই পাইলে আমরাও মেয়ে দিতাম!' 😂",
            "শ্বশুর গ্রামের শেষ জমিটাও নিলামে দিচ্ছেন! 🏚️",
            "পাত্রীর দাদা বলেছেন: 'আমার আমলে এত যৌতুক ছিল না!' 👴",
            "শ্বশুর বাড়ির গরু-ছাগলও বিক্রির তালিকায়! 🐄",
            "পাত্রীর মা বলছেন: 'এই জামাইয়ের জন্য আমি ভিক্ষায় যাব!' 😭",
            "শ্বশুর ব্যাংকে লোনের আবেদন করতে গেছেন! 🏦",
            "পাত্রী বলেছে: 'মা, আমি বিয়েই করুম না!' 😤",
            "শ্বশুর রাতে স্বপ্নে দেখছেন ব্যাংক থেকে নোটিশ এসেছে! 💸",
            "পাত্রীর চাচা বললেন: 'এই ছেলেরে দেখলেই আমার বুক জ্বলে!' 🔥",
            "শ্বশুর মশাই ঢাকা থেকে গ্রামে পালিয়ে গেছেন! 🏃",
            "পাত্রীর মামা বলছেন: 'এই বিয়েতে আমি নাই!' 🙈",
            "শ্বশুর বললেন: 'আমার মেয়েকে বিক্রি করছি নাকি!' 😡",
            "পাত্রী পক্ষ কাবিননামায় শর্ত জুড়ে দিয়েছে! 📜",
            "শ্বশুর বললেন: 'জামাই আসার আগেই আমি হাসপাতালে!' 🏥",
            "পাত্রীর বাবা রাতে ঘুমের মধ্যে চিৎকার করেন: 'কত টাকা?!' 😱",
            "শ্বশুর বাড়ির পোষা বিড়ালও বিক্রি হয়ে গেছে! 🐱",
            "পাত্রীর দাদি বলছেন: 'এই ছেলে দেখতে ভালো তো, কিন্তু দাম এত কেন?!' 👵",
            "শ্বশুর ভাবছেন মেয়েকে বিদেশে পাঠিয়ে দেবেন! ✈️",
        ];
 
        // বেকার/জুয়ারি হলে আলাদা মেসেজ
        if ($request->profession === 'bekar') {
            $funMessages = [
                "শ্বশুর বললেন: 'চাকরি নাই তো বিয়ে নাই!' 😤",
                "পাত্রী বলেছে: 'বেকার জামাই? না ভাই, না!' 🙅‍♀️",
                "শ্বশুর হাসতে হাসতে দরজা বন্ধ করে দিলেন! 🚪",
                "পাত্রীর মা বললেন: 'আমার মেয়ে কি ভাত রান্না করে খাওয়াবে?' 😑",
                "পাড়ার লোকজন বলছে: 'বেকার জামাই! হায় হায়!' 😂",
            ];
        }
        if ($request->profession === 'juyari') {
            $funMessages = [
                "শ্বশুর বললেন: 'জুয়ারি জামাই? বাড়ি থেকে বের হও!' 🏃",
                "পাত্রীর মা অজ্ঞান হয়ে গেছেন! 😵",
                "পাত্রী বলেছে: 'আমি কি পাপ করেছিলাম?' 😭",
                "শ্বশুর বললেন: 'মেয়েকে জুয়ার টেবিলে বাজি ধরবে নাকি?' 😡",
                "পাড়ার ইমাম সাহেব দোয়া পড়তে এসেছেন! 🤲",
            ];
        }
 
        $funMessage = $funMessages[array_rand($funMessages)];
 
        // ═══ PROFESSION LABEL ════════════════════════════════════════
        $profLabel = match ($request->profession) {
            'student'    => 'ছাত্র 🎓',
            'job_holder' => 'চাকরিজীবী 👔',
            'business'   => 'ব্যবসায়ী 💰',
            'bekar'      => 'বেকার 🥲',
            'juyari'     => 'জুয়ারি 🎰',
        };
 
        // ═══ EXTRA FUNNY FACT (নতুন!) ═══════════════════════════════
        $funFacts = [
            "💡 মজার তথ্য: এই যৌতুকে ঢাকা থেকে কক্সবাজার " . mt_rand(2, 15) . " বার যাওয়া যাবে!",
            "💡 মজার তথ্য: এই টাকায় " . mt_rand(50, 500) . " কেজি গরুর মাংস কেনা যাবে!",
            "💡 মজার তথ্য: এই যৌতুকে " . mt_rand(100, 2000) . " টি বিরিয়ানির প্যাকেট কেনা যাবে!",
            "💡 মজার তথ্য: শ্বশুর এই টাকা জোগাড় করতে " . mt_rand(1, 10) . " বছর লাগবে!",
            "💡 মজার তথ্য: এই টাকায় " . mt_rand(5, 50) . " ভরি সোনা কেনা যেত!",
            "💡 মজার তথ্য: শ্বশুর বাড়ির " . mt_rand(1, 3) . " টি গরু বিক্রি করলেই হবে!",
        ];
        $funFact = $funFacts[array_rand($funFacts)];
 
        // ═══ SESSION এ SAVE ══════════════════════════════════════════
        session(['joutuk_result' => [
            'name'       => $request->name,
            'age'        => $age,
            'profession' => $profLabel,
            'district'   => $request->district,
            'total'      => $total,
            'tierLabel'  => $tierLabel,
            'tierColor'  => $tierColor,
            'tierEmoji'  => $tierEmoji,
            'tierDesc'   => $tierDesc,
            'funMessage' => $funMessage,
            'funFact'    => $funFact,
        ]]);
 
        return response()->json([
            'success'  => true,
            'redirect' => route('joutuk.result'),
        ]);
    }
}
