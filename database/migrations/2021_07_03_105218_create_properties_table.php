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
            $table->uuid('uuid');
            $table->foreignId('property_type_id')->constrained('property_types');
            $table->string('county');
            $table->string('country');
            $table->string('town');
            $table->longText('description');
            $table->string('address');
            $table->string('image_full');
            $table->string('image_thumbnail');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->integer('num_bedrooms');
            $table->integer('num_bathrooms');
            $table->integer('price');
            $table->enum('type', ['sale', 'rent']);
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
    }
}
