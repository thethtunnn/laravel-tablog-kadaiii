<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;
use Illuminate\Support\Facades\Auth;

class MealController extends Controller
{
    public function show($id)

    {
        if (Auth::user()->user_type == 'premium') {
            $meal = Meal::findOrFail($id);
            return view('meals.show', compact('meal'));
        }
        return redirect()->route('home');
    }
}
