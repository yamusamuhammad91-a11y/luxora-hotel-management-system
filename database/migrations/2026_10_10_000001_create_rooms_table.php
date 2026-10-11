<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the rooms table.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();

            $table->text('description');
            $table->longText('long_description')->nullable();

            $table->decimal('price', 12, 2);
            $table->unsignedTinyInteger('capacity')->default(2);

            $table->string('image')->nullable();
            $table->json('features')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Remove the rooms table if this migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
