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
        Schema::create('shop_dispute_history', function (Blueprint $table) {
            $table->id();

            $table->string('enable')->default(1);
            $table->bigInteger('dispute_id'); //주문번호

            $table->text('content')->nullable();  //제목

            $table->string('email')->nullable();  //제목

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
        Schema::dropIfExists('shop_dispute_history');
    }
};
