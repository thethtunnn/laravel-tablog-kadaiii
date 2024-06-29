<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Order;

class MealOrderController extends Controller
{
    public function order(Request $request, $id)
    {
        $meal = Meal::findOrFail($id);

        $order = new Order();
        $order->user_id = auth()->id();
        $order->meal_id = $meal->id;
        $order->booking_date = $request->input('booking_date');
        $order->item_number = $request->input('item_number');
        $order->total_price = $request->input('total_price');
        $order->save();

        return redirect()->back()->with('success', 'Meal ordered successfully!');
    }
}
