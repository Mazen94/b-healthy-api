<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoremenuIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storemenu_ingredients', function (Blueprint $table) {
            $table->unsignedBigInteger('storemenu_id');
            $table->unsignedBigInteger('ingredients_id');
            $table->foreign('storemenu_id')->references('id')->on('storemenu')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('ingredients_id')->references('id')->on('ingredients')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('quantite');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storemenu_ingredients');
    }
}
