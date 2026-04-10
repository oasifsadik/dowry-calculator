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
            'profession' => 'required|in:student,job_holder,business',
            'education'  => 'required|in:ssc,hsc,bachelor,masters,phd',
            'income'     => 'nullable|integer|min:0',
            'height'     => 'required|in:short,average,tall,very_tall',
            'looks'      => 'required|in:simple,average,handsome,very_handsome',
            'district'   => 'required|string|max:100',
        ]);
 
        // ═══ BASE ════════════════════════════════════════════════════
        $base = match ($request->profession) {
            'student'    => 300000,
            'job_holder' => 1200000,
            'business'   => 3500000,
        };
 
        // ═══ EDUCATION ═══════════════════════════════════════════════
        $educationBonus = match ($request->education) {
            'ssc'     => 0,
            'hsc'     => 75000,
            'bachelor'=> 350000,
            'masters' => 800000,
            'phd'     => 2500000,
        };
 
        // ═══ AGE ═════════════════════════════════════════════════════
        $age       = (int) $request->age;
        $ageFactor = max(0, (35 - $age)) * 20000;
 
        // ═══ INCOME ══════════════════════════════════════════════════
        $income      = (int) ($request->income ?? 0);
        $incomeBonus = $income * 18;
 
        // ═══ HEIGHT ══════════════════════════════════════════════════
        $heightBonus = match ($request->height) {
            'short'    => -50000,
            'average'  => 80000,
            'tall'     => 250000,
            'very_tall'=> 500000,
        };
 
        // ═══ LOOKS ═══════════════════════════════════════════════════
        $looksBonus = match ($request->looks) {
            'simple'       => 0,
            'average'      => 50000,
            'handsome'     => 200000,
            'very_handsome'=> 500000,
        };
 
        // ═══ DISTRICT ════════════════════════════════════════════════
        $premiumDistricts = ['dhaka','ঢাকা','chittagong','চট্টগ্রাম','sylhet','সিলেট','rajshahi','রাজশাহী'];
        $districtBonus    = in_array(mb_strtolower($request->district), $premiumDistricts) ? 350000 : 80000;
 
        // ═══ RANDOM MARKET FACTOR (same input → different result) ════
        $randomMultiplier = mt_rand(78, 148) / 100;
 
        // ═══ RANDOM FUNNY BONUSES (2টি random নেওয়া হয়) ════════════
        $funnyBonuses = [
            ['label' => '🌙 রাতে নাক ডাকার বিশেষ ট্যাক্স',        'amount' => -mt_rand(20000,  90000)],
            ['label' => '☕ চা না খেলে বিপদ ভাতা',                 'amount' =>  mt_rand(15000,  80000)],
            ['label' => '📱 রিলস দেখার সময় অপচয় জরিমানা',          'amount' => -mt_rand(10000,  70000)],
            ['label' => '🍛 ভাত ৩ প্লেট খাওয়ার সারচার্জ',          'amount' => -mt_rand(5000,   45000)],
            ['label' => '💪 জিমে যাওয়ার বডি প্রিমিয়াম',            'amount' =>  mt_rand(60000, 200000)],
            ['label' => '🎮 গেমার লাইফস্টাইল ট্যাক্স',             'amount' => -mt_rand(25000, 100000)],
            ['label' => '🧔 দাড়ির স্টাইল পয়েন্ট বোনাস',           'amount' =>  mt_rand(10000,  75000)],
            ['label' => '🚗 গাড়ি-বাইক সম্পদ প্রিমিয়াম',           'amount' =>  mt_rand(80000, 350000)],
            ['label' => '😴 দিনে ঘুমানোর অলসতা জরিমানা',           'amount' => -mt_rand(30000, 130000)],
            ['label' => '🍳 রান্না জানার বিরল প্রতিভা বোনাস',       'amount' =>  mt_rand(40000, 160000)],
            ['label' => '📚 বই পড়ার বুদ্ধিজীবী সার্টিফিকেট',       'amount' =>  mt_rand(20000,  90000)],
            ['label' => '🌿 চুলে তেল দেওয়ার ঐতিহ্য পুরস্কার',      'amount' =>  mt_rand(10000,  50000)],
            ['label' => '🐓 মুরগি খাওয়ার বিশেষ দক্ষতা বোনাস',      'amount' =>  mt_rand(8000,   40000)],
            ['label' => '😤 রাগ হলে কথা না বলার রিস্ক প্রিমিয়াম',  'amount' => -mt_rand(40000, 180000)],
            ['label' => '🎤 বেসুরো গান গাওয়ার শাস্তি',             'amount' => -mt_rand(15000,  60000)],
            ['label' => '🏏 ক্রিকেট দেখতে বসলে ওঠে না ট্যাক্স',    'amount' => -mt_rand(20000,  80000)],
            ['label' => '🌞 সকালে উঠতে না পারার জরিমানা',          'amount' => -mt_rand(10000,  55000)],
            ['label' => '🥊 তর্কে কখনো হারে না বোনাস',             'amount' =>  mt_rand(30000, 120000)],
        ];
 
        $pickedKeys   = array_rand($funnyBonuses, 2);
        $randomBonus1 = $funnyBonuses[$pickedKeys[0]];
        $randomBonus2 = $funnyBonuses[$pickedKeys[1]];
 
        // ═══ SUB-TOTAL + RANDOM ═══════════════════════════════════════
        $subTotal = $base + $educationBonus + $ageFactor + $incomeBonus
                  + $heightBonus + $looksBonus + $districtBonus;
 
        $marketAdjustment = (int) (($randomMultiplier - 1.0) * $subTotal);
        $subTotal         = (int) ($subTotal * $randomMultiplier);
        $total            = $subTotal + $randomBonus1['amount'] + $randomBonus2['amount'];
        $total            = max(50000, $total);
 
        // ═══ BREAKDOWN ════════════════════════════════════════════════
        $breakdown = [
            ['label' => '💼 পেশা মূল্যায়ন',              'amount' => $base],
            ['label' => '🎓 শিক্ষাগত যোগ্যতা বোনাস',      'amount' => $educationBonus],
            ['label' => '🎂 তারুণ্যের বাজার দর',           'amount' => $ageFactor],
            ['label' => '💵 আয়ের হিস্যা (দেড় বছর)',       'amount' => $incomeBonus],
            ['label' => '📏 উচ্চতার মূল্য',                'amount' => $heightBonus],
            ['label' => '😎 সৌন্দর্য কর',                  'amount' => $looksBonus],
            ['label' => '📍 এলাকার প্রিমিয়াম',             'amount' => $districtBonus],
            ['label' => '🎲 আজকের জামাই বাজারের ওঠানামা', 'amount' => $marketAdjustment],
            $randomBonus1,
            $randomBonus2,
        ];
 
        // ═══ TIER ═════════════════════════════════════════════════════
        [$tierLabel, $tierColor, $tierEmoji, $tierDesc] = match (true) {
            $total >= 10000000 => ['কোটিপতি জামাই',      '#FFD700', '👑', 'শ্বশুর বাড়ি বিক্রি করেও কুলাবে না!'],
            $total >= 5000000  => ['মেগা সুপার জামাই',    '#FF4500', '🔥', 'পাত্রীর বাবা হার্ট অ্যাটাকের কিনারায়!'],
            $total >= 3000000  => ['হাই-ভোল্টেজ জামাই',  '#9B59B6', '⚡', 'শ্বশুর বাড়ির সব সম্পদ জমা হচ্ছে!'],
            $total >= 1500000  => ['প্রিমিয়াম জামাই',    '#E63946', '🌟', 'পাত্রী পক্ষ রাতের ঘুম হারিয়েছে!'],
            $total >= 800000   => ['ভালোমানের জামাই',    '#118AB2', '😎', 'মধ্যবিত্ত শ্বশুর বাড়ি ঋণ নেবে!'],
            $total >= 400000   => ['মোটামুটি জামাই',     '#06D6A0', '🙂', 'শ্বশুর বাড়ি দরদাম করতে আসবে!'],
            default            => ['সাদামাটা জামাই',     '#95A5A6', '😅', 'বর পক্ষ পালাবে কিনা সন্দেহ!'],
        };
 
        // ═══ FUNNY MESSAGES ═══════════════════════════════════════════
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
        ];
 
        $funMessage = $funMessages[array_rand($funMessages)];
 
        // ═══ PROFESSION LABEL ═══════════════════════════════════════════
        $profLabel = match ($request->profession) {
            'student'    => 'ছাত্র 🎓',
            'job_holder' => 'চাকরিজীবী 👔',
            'business'   => 'ব্যবসায়ী 💰',
        };
 
        // ═══ SESSION এ SAVE ══════════════════════════════════════════════
        session(['joutuk_result' => [
            'name'       => $request->name,
            'age'        => $age,
            'profession' => $profLabel,
            'district'   => $request->district,
            'total'      => $total,
            'breakdown'  => $breakdown,
            'tierLabel'  => $tierLabel,
            'tierColor'  => $tierColor,
            'tierEmoji'  => $tierEmoji,
            'tierDesc'   => $tierDesc,
            'funMessage' => $funMessage,
        ]]);
 
        return response()->json([
            'success'  => true,
            'redirect' => route('joutuk.result'),
        ]);
    }
}
