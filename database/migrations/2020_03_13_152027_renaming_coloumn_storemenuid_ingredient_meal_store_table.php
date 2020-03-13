<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamingColoumnStoremenuidIngredientMealStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingredient_mealStore', function (Blueprint $table) {
            $table->renameColumn('storemenu_id', 'mealStore_id');
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
