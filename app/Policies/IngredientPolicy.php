<?php

namespace App\Policies;

use App\Ingredient;
use App\Nutritionist;
use Illuminate\Auth\Access\HandlesAuthorization;

class IngredientPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view the ingredient.
     *
     * @param  \App\Nutritionist  $user
     * @param  \App\Ingredient  $ingredient
     * @return mixed
     */
    public function view(Nutritionist $user, Ingredient $ingredient)
    {
        return $user->id === $ingredient->nutritionist_id;
    }

    /**
     * Determine whether the user can update the ingredient.
     *
     * @param  \App\Nutritionist  $user
     * @param  \App\Ingredient  $ingredient
     * @return mixed
     */
    public function update(Nutritionist $user,  Ingredient $ingredient)
    {
        return $user->id === $ingredient->nutritionist_id;
    }

    /**
     * Determine whether the user can delete the ingredient.
     *
     * @param  \App\Nutritionist  $user
     * @param  \App\Ingredient  $ingredient
     * @return mixed
     */
    public function delete(Nutritionist $user, Ingredient $ingredient)
    {
        return $user->id === $ingredient->nutritionist_id;
    }


}
