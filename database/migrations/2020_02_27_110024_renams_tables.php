<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('nutritionist', 'nutritionists');
        Schema::rename('activitephysique', 'activitephysiques');
        Schema::rename('conversation', 'conversations');
        Schema::rename('menu', 'menus');
        Schema::rename('menu_ingredients', 'menus_ingredients');
        Schema::rename('notification', 'notifications');
        Schema::rename('patient', 'patients');
        Schema::rename('recommandation', 'recommandations');
        Schema::rename('patient_recommandation', 'patients_recommandations');
        Schema::rename('storemenu', 'storemenus');
        Schema::rename('storemenu_ingredients', 'storemenus_ingredients');
        Schema::rename('visit', 'visits');
        Schema::rename('menu_recommandation', 'menus_recommandations');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename( 'nutritionists','nutritionist');
        Schema::rename('activitephysiques', 'activitephysique');
        Schema::rename('conversations', 'conversation');
        Schema::rename('menus', 'menu');
        Schema::rename('menus_ingredients', 'menu_ingredients');
        Schema::rename('notifications', 'notification');
        Schema::rename('patients', 'patient');
        Schema::rename('recommandations', 'recommandation');
        Schema::rename('patients_recommandations', 'patient_recommandation');
        Schema::rename('storemenus', 'storemenu');
        Schema::rename('storemenus_ingredients', 'storemenu_ingredients');
        Schema::rename('visits', 'visits');
        Schema::rename('menus_recommandations', 'menu_recommandation');

    }
}
