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
            $table->increments('id');
            $table->integer('word_id')->unsigned()->nullable();
            $table->string('sender_account', 20);
            $table->string('receiver_account', 20);
            $table->double('price', 20, 2);
            $table->string('currency', 10);
            $table->dateTime('datetime');
            $table->string('KS', 10);
            $table->string('VS', 10);
            $table->string('SS', 10);
            /**
             * Foreign keys
             */
            $table->foreign('word_id')->references('id')->on('words');
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
