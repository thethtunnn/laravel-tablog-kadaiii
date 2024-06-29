<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

// use Illuminate\Auth\Passwords\CanResetPassword;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser

{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'postal_code',
        'address',
        'phone_number',
        'birthday',
        'occupation',
        'premium_register_date'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->user_type_admin_normal == 'admin';
    }
    public function favoriteStores()
    {
        return $this->belongsToMany(Store::class, 'favorites');
    }


    public function meals()
    {
        return $this->belongsToMany(Meal::class);
    }
    public function hasFavoritedMeal($mealId)
    {
        return $this->favoriteStores()->where('store_id', $mealId)->exists();
    }
    public function checkPremiumStatus()
    {

        if ($this->user_type === 'premium' && $this->premium_register_date !== null) {
            $expiryDate = (new Carbon($this->premium_register_date))->addDays(30);


            if (Carbon::now()->greaterThan($expiryDate)) {
                $this->user_type = 'normal';
                $this->save();
            }
        }
    }
}
