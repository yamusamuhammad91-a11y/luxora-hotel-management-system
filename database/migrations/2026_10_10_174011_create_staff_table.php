<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();

            $table->string('staff_number')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();

            $table->string('department');
            $table->string('position');
            $table->date('hire_date')->nullable();

            $table->decimal('salary', 12, 2)->nullable();
            $table->string('employment_type')->default('full_time');

            $table->string('status')->default('active');
            $table->text('address')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['department', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
