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
        Schema::create('round_track', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('round_id');

            $table->foreign('round_id')
                ->references('id')
                ->on('rounds')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

                $table->unsignedBigInteger('track_id');

            $table->foreign('track_id')
                ->references('id')
                ->on('tracks')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('round_track');
    }
};
