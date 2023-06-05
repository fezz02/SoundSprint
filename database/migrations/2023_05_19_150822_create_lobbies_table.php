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
        Schema::create('lobbies', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            //$table->morphs('playable');
            $table->unsignedBigInteger('playlist_id')
                ->nullable();
            $table->foreign('playlist_id')
                ->references('id')
                ->on('playlists')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->integer('current_players')->default(0);
            $table->integer('max_players')->default(2);
            //$table->unsignedTinyInteger('status')->default(0);
            $table->enum('status', [
                'queue',
                'starting',
                'playing',
                'finished',
                'error',
                'cancelled',
                'timeout'
            ]);
            
            $table->unsignedTinyInteger('game')->default(0);
            
            $table->enum('privacy', [
                'public',
                'private',
                'friends_only',
                'invite_only'
            ]);
            $table->string('password')->nullable();

            $table->datetime('next_round_at')->nullable();
            $table->datetime('timeout_at')->nullable();
            $table->datetime('started_at')->nullable();
            $table->datetime('finished_at')->nullable();

            $table->unique(['code', 'game']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lobbies');
    }
};
