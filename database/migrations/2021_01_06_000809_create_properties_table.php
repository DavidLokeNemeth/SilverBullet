<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->integer('property_type_id')->unsigned();
            $table->string('county');
            $table->string('country');
            $table->string('town');
            $table->text('description');
            $table->string('address');
            $table->string('image_full');
            $table->string('image_thumbnail');
            $table->decimal('latitude')->nullable();
            $table->decimal('longitude')->nullable();
            $table->integer('num_bedrooms');
            $table->integer('num_bathrooms');
            $table->string('price');
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();
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
    }
}
