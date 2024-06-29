<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Meal;
use Illuminate\Auth\Access\HandlesAuthorization;

class MealPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any meals.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        // Logic to determine if the user can view any meals
        return false; // Example: allow all users to view meals
    }

    /**
     * Determine whether the user can view the meal.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Meal  $meal
     * @return mixed
     */
    public function view(User $user, Meal $meal)
    {
        // Logic to determine if the user can view the specified meal
        return false; // Example: allow all users to view any meal
    }

    /**
     * Determine whether the user can create meals.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // Logic to determine if the user can create meals
        return $user->is_admin; // Example: only admins can create meals
    }

    /**
     * Determine whether the user can update the meal.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Meal  $meal
     * @return mixed
     */
    public function update(User $user, Meal $meal)
    {
        // Logic to determine if the user can update the specified meal
        return $user->id === $meal->user_id; // Example: only meal owner can update
    }

    /**
     * Determine whether the user can delete the meal.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Meal  $meal
     * @return mixed
     */
    public function delete(User $user, Meal $meal)
    {
        // Logic to determine if the user can delete the specified meal
        return $user->id === $meal->user_id || $user->is_admin; // Example: owner or admin can delete
    }
}
