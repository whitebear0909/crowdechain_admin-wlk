<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('transaction_info');
            $table->string('APIKEY')->nullable();
            $table->bigInteger('timestamp')->nullable();
            $table->string('divisa');
            $table->integer('amount');
            $table->string('codiceTransazione');
            $table->string('mac');
            $table->integer('status');
            $table->string('transaction_code');
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
        Schema::dropIfExists('transactions');
    }
}
