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
        Schema::create('pharma', function (Blueprint $table) {
            $table->id();

            // حقل الفئة
            $table->unsignedBigInteger('category_id')->nullable();

            $table->string('name');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->integer('quantity');
            $table->string('image')->nullable();

            // المفتاح الخارجي
            $table->foreign('category_id')
                  ->references('id')->on('categories')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharma');
    }
}; 