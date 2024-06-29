<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Models\Meal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MealOrderController;

use App\Http\Controllers\MealController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StoreController;
use App\Models\Booking;
use App\Models\Store;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Password;



Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// forgot pw 


Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');


Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');


// forgot pw 


//reset pw 
Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');


Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');


//reset pw 
Route::group([], function () {
    Route::get('/login', fn () => view('auth/login'))->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');




    Route::post('/register', [AuthController::class, 'makeRegister'])->name('auth.register');
    Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
});
Route::get('/', [HomeController::class, 'index'])->name('home');

//rotue to get search by store name 
Route::get('/search-by-store-name', [HomeController::class, 'searchByStoreName'])->name('SearchBystoreName');


// -------------------------------------------------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {






    //-----------------------------uer profile =---------------------------------------------------

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/edit-profile', [AuthController::class, 'EditProfile'])->name('edit-profile');
    Route::post('/update-profile', [AuthController::class, 'UpdateProfile'])->name('update-profile');
    //uer profile 

    Route::get('users/mypage/register_card', [PaymentController::class, 'register_card'])->name('mypage.register_card');
    Route::post('users/mypage/token', [PaymentController::class, 'token'])->name('mypage.token');
    Route::post('/deleteCard', [PaymentController::class, 'deleteCard'])->name('deleteCard');
    Route::post('/cancel-plan', [PaymentController::class, 'cancelPlan'])->name('cancelPlan');


    Route::post('/make_fav/{id}', function ($id) {
        $user = Auth::user();
        $meal = Store::findOrFail($id);

        if ($user->favoriteStores()->where('store_id', $id)->exists()) {
            // Meal is already favorited, unfavorite it
            $user->favoriteStores()->detach($id);
            return redirect()->back(); // 
        } else {
            // Meal is not favorited, favorite it
            $user->favoriteStores()->attach($id);
            return redirect()->back(); // 
        }
    })->name('make_fav');



    Route::get('booking', function () {
        $bookings = Booking::where('user_id', auth()->id())->with('store')->get();


        return view('booking', compact('bookings'));
    })->name('booking');

    Route::get('cancel-booking/{booking}', [BookingController::class, 'destroy'])->name('cancel-booking');

    //
    // review section start 

    Route::post('review/{store}', [ReviewController::class, 'store'])->name('store-review');
    Route::get('review/{review}', [ReviewController::class, 'edit'])->name('edit-review');
    Route::post('review', [ReviewController::class, 'update'])->name('update-review');
    Route::delete('review/{review}', [ReviewController::class, 'delete'])->name('delete-review');
    // review section    end 


    //logout 


    Route::get('/meals/{id}', [StoreController::class, 'show'])->name('meals.show')->middleware('auth');
    Route::post('/order_meal/{id}', [BookingController::class, 'store'])->name('order_meal')->middleware('auth');
    Route::get('/apply-premium', fn () => view('users/apply_premium'))->name('users.apply_permium')->middleware('auth');

    //apply for premium 
    Route::post('/apply-premium', [PaymentController::class, 'getPremium'])->name('users.apply_permium')->middleware('auth');
});
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
