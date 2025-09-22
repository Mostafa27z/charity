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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('national_id', 20)->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender', ['male','female'])->nullable();
            $table->date('birth_date')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->integer('family_size')->nullable();
            $table->decimal('income', 10, 2)->nullable();
            $table->text('notes')->nullable();

            // ➡️ New association reference
            $table->foreignId('association_id')
                  ->constrained('associations')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
