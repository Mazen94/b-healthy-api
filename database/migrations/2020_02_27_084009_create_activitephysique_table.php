<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitephysiqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activitephysique', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('distance');
            $table->string('activite_type');
            $table->integer('energy_burned');
            $table->time('duration', 0);
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patient');
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
        Schema::dropIfExists('activitephysique');
    }
}
