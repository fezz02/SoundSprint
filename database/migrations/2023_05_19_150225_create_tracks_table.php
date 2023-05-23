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
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('album_id');
            $table->foreign('album_id')
                ->references('id')
                ->on('albums')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('name');
            $table->string('href');
            $table->unsignedBigInteger('duration_ms')->default(0);
            $table->integer('popularity')->default(0);
            $table->string('preview_url')->nullable();
            $table->boolean('explicit')->default(false);
            $table->timestamps();

            $table->unique(['name', 'href']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
