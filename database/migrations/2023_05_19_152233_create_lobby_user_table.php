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

            $table->unsignedBigInteger('user_id')
                ->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('lobby_id')
                ->nullable();
            $table->foreign('lobby_id')
                ->references('id')
                ->on('lobbies')
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
