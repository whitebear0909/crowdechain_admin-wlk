<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMetaTagsToProducts extends Migration
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
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keyphrases')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('url_personalizzato')->nullable();
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
            $table->drop('meta_title');
            $table->drop('meta_description');
            $table->drop('meta_keyphrases');
            $table->drop('meta_keywords');
            $table->drop('url_personalizzato');            //
        });
    }
}
