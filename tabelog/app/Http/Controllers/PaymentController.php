<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function register_card(Request $request)
    {
        $user = Auth::user();

        $pay_jp_secret = env('PAYJP_SECRET_KEY');
        \Payjp\Payjp::setApiKey($pay_jp_secret);

        $card = [];
        $count = 0;

        if ($user->token != "") {
            // dd(\Payjp\Customer::retrieve($user->token)->cards->all(array("limit" => 1))->data);
            $result = \Payjp\Customer::retrieve($user->token)->cards->all(array("limit" => 1))->data[0];
            $count = \Payjp\Customer::retrieve($user->token)->cards->all()->count;

            $card = [
                'brand' => $result["brand"],
                'exp_month' => $result["exp_month"],
                'exp_year' => $result["exp_year"],
                'last4' => $result["last4"],
                'id' => $result['id']
            ];
        }

        return view('users.register_card', compact('card', 'count'));
    }

    public function token(Request $request)
    {
        $pay_jp_secret = env('PAYJP_SECRET_KEY');
        \Payjp\Payjp::setApiKey($pay_jp_secret);

        $user = Auth::user();
        $customer = $user->token;

        if ($customer != "") {
            $cu = \Payjp\Customer::retrieve($customer);

            $delete_card = $cu->cards->retrieve($cu->cards->data[0]["id"]);
            $delete_card->delete();
            $cu->cards->create(array(
                "card" => request('payjp-token')
            ));
        } else {
            $cu = \Payjp\Customer::create(array(
                "card" => request('payjp-token')
            ));
            $user->token = $cu->id;
            $user->update();
        }

        return redirect()->route('home');
    }

    public function deleteCard(Request $request)
    {
        $pay_jp_secret = env('PAYJP_SECRET_KEY');
        \Payjp\Payjp::setApiKey($pay_jp_secret);

        // Retrieve authenticated user
        $user = Auth::user();
        $customer = $user->token;
        $cardId = $request->cardId;
        if ($customer) {
            try {
                // Retrieve customer details from Payjp
                $cu = \Payjp\Customer::retrieve($customer);

                // Retrieve the card to delete based on $cardId
                $delete_card = $cu->cards->retrieve($cardId);

                // Delete the card
                $delete_card->delete();
                $user->token = "";
                $user->update();

                return redirect()->back()->with('success', 'Card deleted successfully.');
            } catch (\Payjp\Error\Base $e) {
                // Handle Payjp API errors
                return redirect()->back()->with('error', 'Error deleting card: ' . $e->getMessage());
            }
        }
    }

    public function getPremium()
    {
        $pay_jp_secret = env('PAYJP_SECRET_KEY');
        \Payjp\Payjp::setApiKey($pay_jp_secret);

        $user = Auth::user();
        if ($user->token == "") {
            return redirect()->route('mypage.register_card');
        }
        $res = \Payjp\Charge::create(
            [
                "customer" => $user->token,
                "amount" =>  300,
                "currency" => 'jpy'
            ]
        );
        if ($res) {
            $user = Auth::user();
            $user->user_type = 'premium';
            $user->premium_register_date = now();
            $user->save();
            return redirect()->route('home');
        }
    }


    public function cancelPlan()
    {

        $user = Auth::user();
        $user->user_type = 'normal';
        $user->premium_register_date = null;
        $user->update();
        return redirect()->route('home');
    }
}
