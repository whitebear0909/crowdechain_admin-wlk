<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddYoutubeUrlMeetingPointToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            //'meta_title','meta_description','meta_keyphrases','meta_keywords','url_personalizzato'
            $table->string('url_youtube_slider')->nullable();
            $table->text('description_meeting_point')->nullable();
            $table->string('img_meeting_point')->nullable();
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->drop('url_youtube_slider');
            $table->drop('description_meeting_point');
            $table->drop('img_meeting_point');
            $table->drop('lat');
            $table->drop('lon');            
        });
    }
}
