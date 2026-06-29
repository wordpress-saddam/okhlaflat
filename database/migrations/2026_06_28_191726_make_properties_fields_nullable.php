<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->integer('rent')->nullable()->change();
            $table->integer('deposit')->nullable()->change();
            $table->string('property_type')->nullable()->change();
            $table->tinyInteger('bhk')->nullable()->change();
            $table->integer('area')->nullable()->change();
            $table->string('floor')->nullable()->change();
            $table->string('furnishing')->nullable()->change();
            $table->string('availability')->nullable()->change();
            $table->string('approximate_location')->nullable()->change();
            $table->text('exact_address')->nullable()->change();
            $table->string('building_number')->nullable()->change();
            $table->string('owner_name')->nullable()->change();
            $table->string('owner_contact')->nullable()->change();
            
            // locality_id is a foreign key, making it nullable requires changing the constraint if we really wanted to, but we can just set it as nullable
            $table->foreignId('locality_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('title')->nullable(false)->change();
            $table->integer('rent')->nullable(false)->change();
            $table->integer('deposit')->nullable(false)->change();
            $table->string('property_type')->nullable(false)->change();
            $table->tinyInteger('bhk')->nullable(false)->change();
            $table->integer('area')->nullable(false)->change();
            $table->string('floor')->nullable(false)->change();
            $table->string('furnishing')->nullable(false)->change();
            $table->string('availability')->nullable(false)->change();
            $table->string('approximate_location')->nullable(false)->change();
            $table->text('exact_address')->nullable(false)->change();
            $table->string('building_number')->nullable(false)->change();
            $table->string('owner_name')->nullable(false)->change();
            $table->string('owner_contact')->nullable(false)->change();
            
            $table->foreignId('locality_id')->nullable(false)->change();
        });
    }
};
