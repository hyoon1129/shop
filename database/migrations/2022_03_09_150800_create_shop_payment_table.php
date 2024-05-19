<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_payment', function (Blueprint $table) {
            $table->id();
            $table->string('enable')->default(1);
            $table->string('name');

            $table->string('test')->nullable();
            $table->string('code')->nullable();
            $table->string('payment')->nullable();
            $table->string('pg_id')->nullable();
            $table->string('pg_password')->nullable();
            $table->string('pg_key')->nullable();
            $table->string('pg_url')->nullable();
            $table->string('pg_url_test')->nullable();
            $table->string('descript')->nullable();


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
        Schema::dropIfExists('shop_payment');
    }
};
