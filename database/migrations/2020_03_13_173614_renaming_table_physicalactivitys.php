<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamingTablePhysicalactivitys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('physicalactivitys', function (Blueprint $table) {
            Schema::rename('physicalactivitys', 'physicalActivity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('physicalactivitys', function (Blueprint $table) {
            //
        });
    }
}
