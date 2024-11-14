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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('imageable_type'); // Menyimpan model tipe (misalnya 'App\Models\Product')
            $table->foreignId('imageable_id'); // Menyimpan model id (misalnya produk_id)
            $table->string('image_path');
            $table->boolean('is_primary')->default(false); // Untuk menandakan gambar utama
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();

            // Index untuk mempercepat pencarian berdasarkan relasi polymorphic
            $table->index(['imageable_type', 'imageable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
