<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('price_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discount_id')->constrained();
            $table->tinyInteger('type')->comment('1:Percentage Discount, 2:Flat Discount');
            $table->decimal('minimum_spend_amount', 10, 2);
            $table->decimal('digit', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('price_discounts');
    }
};
