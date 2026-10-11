<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('category')->default('general');
            $table->text('description');

            $table->string('image')->nullable();

            $table->decimal('price', 12, 2)->default(0);
            $table->string('price_type')->default('fixed');

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('display_order')->default(0);

            $table->timestamps();

            $table->index(['is_active', 'display_order']);
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
