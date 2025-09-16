<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationOptionsTable extends Migration
{
    public function up()
    {
       

        Schema::create('variation_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variation_id')->constrained()->cascadeOnDelete();
            $table->string('value'); // e.g. Large, Red
            $table->string('sku')->nullable();
            $table->decimal('price_modifier', 12, 2)->default(0); // additive modifier
            $table->integer('stock')->default(0);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('variation_options');
    }
}
