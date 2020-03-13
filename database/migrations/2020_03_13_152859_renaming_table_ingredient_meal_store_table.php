<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamingTableIngredientMealStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingredient_mealStore', function (Blueprint $table) {
            Schema::rename('ingredient_mealStore', 'ingredient_meal_store');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ingredient_mealStore', function (Blueprint $table) {
            //
        });
    }
}
