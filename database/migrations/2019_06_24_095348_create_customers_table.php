<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string("uuid")->unique();
            $table->string("name");
            $table->string("instanceURL");
            $table->string("contactPhone");
            $table->string("contactEmail");

            $table->boolean('hasSMS')->default(true);
            $table->boolean('hasEmail')->default(true);
            $table->boolean('activated')->default(false);
            $table->integer('limit')->default(1000);
            $table->integer('credit')->default(1000);

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
        Schema::dropIfExists('customers');
    }
}
