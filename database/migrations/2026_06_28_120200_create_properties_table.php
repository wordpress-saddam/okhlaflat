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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('property_code')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('rent');
            $table->integer('deposit');
            $table->string('property_type'); // e.g. flat, pg, room, house
            $table->tinyInteger('bhk'); // e.g. 1, 2, 3
            $table->integer('area'); // in sq ft
            $table->string('floor'); // e.g. Ground, 1st, 2nd
            $table->string('furnishing'); // e.g. furnished, semi-furnished, unfurnished
            $table->string('availability'); // e.g. immediate, specific_date
            $table->string('approximate_location'); // Publicly visible e.g. Batla House near Metro
            $table->string('nearest_metro')->nullable();
            $table->string('landmark')->nullable();
            
            // Sensitive fields hidden from public view
            $table->text('exact_address');
            $table->string('building_number');
            $table->string('owner_name');
            $table->string('owner_contact');

            // Verification & Publication statuses
            $table->string('verification_status')->default('pending'); // pending, verified, rejected
            $table->string('publication_status')->default('draft'); // draft, published, archived

            // Relations
            $table->foreignId('locality_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_agent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();

            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('rent');
            $table->index('property_type');
            $table->index('bhk');
            $table->index('verification_status');
            $table->index('publication_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
