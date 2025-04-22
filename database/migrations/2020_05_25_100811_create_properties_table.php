<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('type_property_id');
            $table->unsignedInteger('list_view_id');
            $table->unsignedInteger('type_finish_id');
            $table->unsignedInteger('governorate_id');
            $table->unsignedInteger('city_id')->nullable();
            $table->unsignedInteger('type_payment_id');
            $table->enum('type_rent' , array('daily', 'monthly'))->nullable();
            $table->enum('list_section' , array('sell', 'rent'));
            $table->double('area',20);
            $table->smallInteger('num_floor');
            $table->smallInteger('num_rooms');
            $table->smallInteger('num_bathroom');
            $table->text('location')->nullable();
            $table->double('price')->default(0);
            $table->boolean('is_special')->default(0)->comment('0 => not special , 1 => special');
            $table->text('link_youtube')->nullable();
            $table->boolean('status')->default(0)->comment('0 => not active , 1 => active');
            $table->timestamps();
        });


        Schema::create('description_properties', function(Blueprint $table){
            $table->id();
            $table->string('title');
            $table->text('details');
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('images', function(Blueprint $table){
            $table->id();
            $table->string('source');
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('type')->default('image');
            $table->timestamps();
        });



        Schema::create('list_views', function(Blueprint $table){
            $table->id();
            $table->text('name');
            $table->timestamps();
        });

        Schema::create('type_finishes', function(Blueprint $table){
            $table->id();
            $table->text('name');
            $table->timestamps();
        });


        Schema::create('type_payments', function(Blueprint $table){
            $table->id();
            $table->text('name');
            $table->timestamps();
        });


        Schema::create('type_properties', function(Blueprint $table){
            $table->id();
            $table->text('name');
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
        Schema::dropIfExists('properties');
        Schema::dropIfExists('description_properties');
        Schema::dropIfExists('images');
        Schema::dropIfExists('list_views');
        Schema::dropIfExists('type_finishes');
        Schema::dropIfExists('type_payments');
        Schema::dropIfExists('type_properties');
    }
};
