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
        Schema::create('shop_wish', function (Blueprint $table) {
            $table->id();

            $table->string('email'); //주문자정보

            ## 상품정보
            $table->bigInteger('product_id'); // 제품 번호
            $table->string('product'); // 제품명
            $table->string('image')->nullable();

            ##
            $table->string('expire')->nullable();   // 만료일자시 삭제
            $table->string('later')->nullable();

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
        Schema::dropIfExists('shop_wish');
    }
};
