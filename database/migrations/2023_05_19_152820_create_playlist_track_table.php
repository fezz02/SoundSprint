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
        Schema::create('playlist_track', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('playlist_id')
                ->nullable();
            $table->foreign('playlist_id')
                ->references('id')
                ->on('playlists')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            //$table->string('track_id')
            $table->unsignedBigInteger('track_id')
                ->nullable();
            $table->foreign('track_id')
                ->references('id')
                ->on('tracks')
                ->nullOnDelete()
                ->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_track');
    }
};
