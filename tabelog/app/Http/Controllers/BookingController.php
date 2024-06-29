<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Meal;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request, $id)
    {
        $store = Store::findOrFail($id);

        $booking = new Booking();
        $booking->user_id = auth()->id();
        $booking->store_id = $store->id;
        $booking->booking_time = $request->input('booking_time');
        $booking->people_count = $request->input('people_count');

        if ($store->leftSeat() < $request->input('people_count')) {
            return redirect()->back()->withErrors(['message' => 'Only ' . $store->leftSeat() . 'Seats left']);
        }
        // $booking->total_price = $request->input('total_price');
        $booking->save();


        // $pay_jp_secret = env('PAYJP_SECRET_KEY');
        // \Payjp\Payjp::setApiKey($pay_jp_secret);

        // $user = Auth::user();

        // $res = \Payjp\Charge::create(
        //     [
        //         "customer" => $user->token,
        //         "amount" =>  '445',
        //         // "amount" =>  $booking->total_price,

        //         "currency" => 'jpy'
        //     ]
        // );

        return redirect()->route('booking');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('booking');
    }
}
