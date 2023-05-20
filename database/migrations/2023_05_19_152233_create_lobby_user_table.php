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
        Schema::create('lobby_user', function (Blueprint $table) {
            $table->id();
            $table->foreign('track_id')
                ->references('id')
                ->on('tracks')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->boolean('guessed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lobby_user');
    }
};
