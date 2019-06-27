<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->uuid("msgId");
            $table->string("msgContent");

            $table->enum('status', ['SENT', 'PENDING', 'FAILED', 'CANCELLED']);
            $table->enum('channel', ['SMS', 'EMAIL', 'VOICE']);
            $table->string('phone_number');
            $table->string('email');
            $table->string('category');
            $table->string('subject');
            $table->string('sendOn')->nullable()->default(''); // send the notification on a specific date time

            $table->bigInteger('customer_id')->unsigned();
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');        

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
        Schema::dropIfExists('notifications');
    }
}
