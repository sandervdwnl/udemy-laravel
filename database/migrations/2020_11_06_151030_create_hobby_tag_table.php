<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHobbyTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hobby_tag', function (Blueprint $table) {
            // Voeg col hobby_tag>hobby_id toe met waarde bigint 
            $table->unsignedBigInteger('hobby_id')->nullable();
            // Voeg col hobby_tag>tag_id toe met waarde bigint
            $table->unsignedBigInteger('tag_id')->nullable();
            // Voeg timestamp col toe
            $table->timestamps();
            // Maakt PK aan uit combi van beide id's om een uniek id te creeëren
            $table->primary(['hobby_id', 'tag_id']);
            // Col hobby_id wordt FK en refereert hobbies>id
            $table->foreign('hobby_id')->references('id')->on('hobbies')
                ->onDelete('cascade');
            // Col hobby_id wordt FK en refereert hobbies>id
            $table->foreign('tag_id')->references('id')->on('tags')
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
        Schema::dropIfExists('hobby_tag');
    }
}
