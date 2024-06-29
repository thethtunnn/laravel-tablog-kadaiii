<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function show($id)

    {
        if (Auth::user()->user_type == 'premium') {
            $item = Store::findOrFail($id);
            return view('meals.show', compact('item'));
        }
        return redirect()->route('home');
    }
}
