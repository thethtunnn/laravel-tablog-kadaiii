<?php

namespace Database\Seeders;

use App\Models\Cagegory;
use App\Models\Category;
use App\Models\Meal;
use Illuminate\Support\Facades\Http;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $response = Http::get('https://www.themealdb.com/api/json/v1/1/search.php?s');
        $php_array = $response->json()['meals'];
        $categoies = [];
        foreach ($php_array as $item) {
            $categoies[] = $item['strArea'];
        }
        $categoies = array_unique($categoies);
        foreach ($categoies as $category) {
            Category::create([
                'name' => $category
            ]);
        }
        $meals = [];
        for ($i = 0; $i < count($php_array); $i++) {
            // dd(Category::where('name', $php_array[$i]['strArea'])->get()->pluck('id'));
            $meals[$i] = [
                'name' => $php_array[$i]['strMeal'],
                'category' => Category::where('name', $php_array[$i]['strArea'])->pluck('id')->first(),
                'price' => rand(1111, 9999),
                'thumbnail' => $php_array[$i]['strMealThumb'],
            ];
        }

        Meal::insert($meals);
    }
}
