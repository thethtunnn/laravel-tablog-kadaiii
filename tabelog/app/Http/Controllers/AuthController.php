<?php

namespace App\Http\Controllers;

use App\Models\ProfileType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Monolog\Handler\RollbarHandler;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Illuminate\Auth\Events\Registered;
use PhpParser\Node\Expr\FuncCall;

class AuthController extends Controller
{


    public function register()
    {

        return view('auth/register');
    }

    public function makeRegister(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'postal_code' => ['required', 'min:7'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'min:11'],
            'birthday' => ['nullable'],
            'occupation' => ['nullable', 'string', 'max:255'],
        ]);
        $request->user_type_admin_normal = 'normal';
        $user =  User::create($request->all());



        // Auth::login($user);
        event(new Registered($user));
        return redirect(route('home'));
    }

    public function login(Request $request)

    {


        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $user->checkPremiumStatus();
            return redirect(route('home'));
        }


        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }


    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function EditProfile()
    {
        $user = Auth::user();
        return view('edit_profile', compact('user'));
    }

    public function UpdateProfile(Request $request)
    {


        $request->validate([
            // 'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

            // 'postal_code' => ['required', 'digits:7'],
            // 'address' => ['required', 'string', 'max:255'],
            // 'phone_number' => ['required', 'digits_between:10, 11'],

            // 'occupation' => ['nullable', 'string', 'max:255'],
        ]);
        $user = Auth::user();
        $data = $request->only([
            'name', 'email', 'postal_code', 'address', 'phone_number', 'birthday', 'occupation', 'password'

        ]);

        $user->update($data);
        return view('profile', compact('user'));
    }
}
