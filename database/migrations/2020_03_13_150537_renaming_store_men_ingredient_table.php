<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamingStoreMenIngredientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('storemenus_ingredients', function (Blueprint $table) {
            Schema::rename('storemenus_ingredients', 'ingredient_mealStore');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('storemenus_ingredients', function (Blueprint $table) {
            //
        });
    }
}
