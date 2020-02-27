<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuRecommandationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_recommandation', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('recommandation_id');
            $table->foreign('menu_id')->references('id')->on('menu')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('recommandation_id')->references('id')->on('recommandation')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->date('date');

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
        Schema::dropIfExists('menu_recommandation');
    }
}
