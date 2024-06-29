<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Store;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    function index(Request $request)
    {
        $category  = null;

        $query = Store::query();
        if ($request->query('category')) {
            $category = $request->query('category');
            $query->where('category_id', $category);
        }

        $stores = $query->get();


        return view('home', ['stores' => $stores]);
    }


    function searchByStoreName(Request $request)
    {
        $storeName = $request->storename;
        $stores = Store::where('name', 'LIKE', '%' . $storeName . '%')->get();
        return view('home', ['stores' => $stores]);
    }
}
