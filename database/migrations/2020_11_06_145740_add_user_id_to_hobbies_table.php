<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToHobbiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hobbies', function (Blueprint $table) {
            //Maak col aan user_id met big integer waarde
            $table->unsignedBigInteger('user_id')
                // Als 2e col na col id plaatsen
                ->after('id')
                // dit voorkomt errors
                ->nullable();

            // deze col hobbies>user_id is Foreign Key
            $table->foreign('user_id')
                // en refereert naar users>id
                ->references('id')->on('users')
                // bij verwijderen user, verwijder alle entries
                // gelinkt aan deze user, ook in andere tabellen
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hobbies', function (Blueprint $table) {
            // Verwijder FK (gebruik hier altijd een array)
            $table->dropForeign(['user_id']);
            // Verwijder col hobbies>user_id
            $table->dropColumn('user_id');
        });
    }
}
