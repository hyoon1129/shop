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
        Schema::create('shop_bank', function (Blueprint $table) {
            $table->id();
            $table->string('enable')->default(1);

            $table->string('country')->nullable();

            $table->string('currency')->nullable();

            $table->string('bank_name');
            $table->string('bank_user')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_swift')->nullable();

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
        Schema::dropIfExists('shop_bank');
    }
};
