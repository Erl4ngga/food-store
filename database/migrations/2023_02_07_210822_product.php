<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary');
            $table->longText('description')->nullable();
            $table->text('photo');
            $table->integer('stock')->default(1);
            $table->enum('condition',['default','new','hot'])->default('default');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->string('size')->nullable();
            $table->string('currency')->nullable();
            $table->string('rgb')->nullable()->default(null);
            $table->decimal('sold', 10, 2)->default(0);
            $table->decimal('price', 10, 2);
            $table->decimal('discount', 5, 2)->nullable();            
            $table->boolean('is_featured')->deault(false);
            $table->date('countdown_date')->nullable();
            $table->time('countdown_time')->nullable();
            $table->integer('countdown_duration')->default(0)->nullable();
            $table->unsignedBigInteger('cat_id')->nullable();
            $table->unsignedBigInteger('child_cat_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('SET NULL');
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('SET NULL');
            $table->foreign('child_cat_id')->references('id')->on('categories')->onDelete('SET NULL');
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
        Schema::dropIfExists('products');
    }
}
