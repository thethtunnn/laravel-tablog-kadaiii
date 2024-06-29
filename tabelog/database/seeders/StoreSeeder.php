<?php

namespace Database\Seeders;

use App\Models\Cagegory;
use App\Models\Category;
use App\Models\Meal;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $imageData = file_get_contents('https://www.themealdb.com/images/media/meals/wuxrtu1483564410.jpg');
        // $result = file_put_contents(public_path('storage/image.jpg'), $imageData);
        // dd(asset('storage/image.jpg'));
        $response = Http::get('https://www.themealdb.com/api/json/v1/1/search.php?s');
        $php_array = $response->json()['meals'];
        $restaurants = [
            "NAGOYA BURGER 名駅店", "Shanties", "割烹 柏木", "油そば専門店ブラブラ 半田店", "にく屋 浄心店", "TRED", "きんやま", "NAGOYA BURGER 名古屋店", "焼肉小山", "焼き鳥七輪 栄住吉店", "肉の庭", "CRAFT BEER NAGOYA2", "麺屋やしろ", "ハワイアンバーベキュー 名古屋店", "日本酒処 花雅", "なわ", "お酒とご飯", "焼肉SUKI 名古屋新幹線口店", "焼き鳥 はなれ", "割烹旬菜花", "ちゃんこ屋 あかね", "肉の庭半田店", "オーガニック食堂Sngi", "寿司 やなや", "ハワイアンバーベキュー 太田川店", "中華一番", "厚切りステーキとハンバーグ たはらや", "名古屋ラーメン 半田店", "炭火やきとり オマメ", "ラーメン 餃子 ひびき", "つけ麺MENMARU", "でろ助 金山店", "はらみ専門店 七輪屋", "かどや本店 JR名古屋駅店", "手打ちそば 子石", "焼肉 カウカウ", "すし徳", "手打ちそば 中石", "麺屋しろ", "焼肉SUKI 阿久比店", "炭火串焼コケッコ屋 大須店", "晴々久", "おはんざい", "名古屋お好み焼き", "油そば専門店ブラブラ 名古屋駅前店", "まるまる飯", "焼き鳥七輪 太田川店", "新みくじ", "溝口", "KOTABUKI", "カジュアルてっぱん焼き", "ひこぞう", "キッチンマルポワ", "魚と野菜と酒", "麺屋名古屋 名古屋金山店", "やきにく 加藤", "すし処みか", "炭火やきとり マメ", "上下月", "名古屋ラーメン 栄本店", "肉とホルモンの店 YAMI", "焼肉とホルモン焼き 新瑞橋店", "ニクサカバ", "よはく", "お酒とお肉", "和牛焼肉Wocca", "なかみどり", "けろ助 金山店", "魚と野菜と酒 じゃばらむ", "大衆焼肉酒場 ホルモン屋 栄店", "麺屋名古屋 半田店", "かつおか", "CRAFT BEER NAGOYA", "TRED2", "どんどん 名駅南一丁目", "二代目 康", "天ぷらとワインの大島", "すし処ゆか", "焼肉ボンバー", "やきにく 佐藤", "串カツ 今池店", "まつおか", "大衆焼肉酒場 ホルモン屋 半田店", "萬新軒", "ハワイアンバーベキュー ささしま太田川店", "焼き鳥 はな", "口々", "焼肉とホルモン 新瑞橋店", "上月", "オーガニック食堂Angi", "焼き鳥 せぶん", "キッチンマルポー", "ニクサカバ半田店", "ちょもらんま", "やきにく 山崎", "台湾ラーメン 田中 守山本店", "割烹 加藤", "ちょもちょもらんま", "炭火串焼コケッコ屋 半田店", "割烹旬菜"
        ];

        foreach ($php_array as $item) {
            $categoies[] = $item['strArea'];
        }
        $categoies = array_unique($categoies);
        foreach ($categoies as $category) {
            Category::create([
                'name' => $category
            ]);
        }

        $stores = [];

        for ($i = 0; $i < count($php_array); $i++) {
            $lowest_price = rand(20, 50);
            $highest_price = rand(51, 100);
            // dd(Category::where('name', $php_array[$i]['strArea'])->get()->pluck('id'));
            $imageData = file_get_contents($php_array[$i]['strMealThumb']);
            $result = file_put_contents(public_path('stores/' . $i . '.jpg'), $imageData);

            $stores[$i] = [
                'name' => $restaurants[$i],
                'category_id' => Category::where('name', $php_array[$i]['strArea'])->pluck('id')->first(),

                // 'image' => 'stores/' . $i . '.jpg',
                'image' => $i . '.jpg',
                'description' => 'Offer Delicious Food',
                'lowest_price' => $lowest_price,
                'highest_price' => $highest_price,
                'postal_code' => fake()->postcode(),
                'Address' => fake()->city(),
                'opening_time' => Carbon::createFromTime(8, 0, 0)->format('H:i:s'),
                'closing_time' =>  Carbon::createFromTime(22, 0, 0)->format('H:i:s'),
                'seating_capacity' => rand(20, 50)




            ];
        }
        Store::insert($stores);
    }
}
