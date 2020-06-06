<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPcitureToPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'patients',
            function (Blueprint $table) {
                $table->string('photo', 255)->default('defaultPatient.png');;
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'patients',
            function (Blueprint $table) {
                $table->dropColumn('photo');
            }
        );
    }
}
