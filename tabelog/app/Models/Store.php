<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'image', 'description', 'lowest_price', 'highest_price', 'postal_code', 'Address', 'opening_time', 'closing_time', 'category_id', 'seating_capacity'
    ];
    public static function categories()
    {
        $stores = Category::all();
        $arr = [];
        foreach ($stores as $store) {
            // dd($store->getCategory());
            $arr[] =
                [
                    'id' => $store->id,
                    'category_name' => $store->name
                ];
        }
        return $arr;
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function leftSeat()
    {

        $bookedSeats = $this->bookings()->sum('people_count');
        $remainingSeats = $this->seating_capacity;
        if ($bookedSeats > 0) {
            $remainingSeats =  $this->seating_capacity - $bookedSeats;
        }

        // Ensure remaining seats is not negative
        return max(0, $remainingSeats);
    }

    public function reviews()
    {

        return $this->hasMany(Review::class);
    }
}
