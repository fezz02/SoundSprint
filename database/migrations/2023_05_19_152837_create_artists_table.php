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
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            //$table->string('id')->primary();
            $table->morphs('artable');
            //$table->string('artable_id');
            //$table->string('artable_type');

            $table->string('spotify_artist_id');
            $table->string('name');
            $table->string('href');
            $table->string('spotify_href');

            $table->timestamps();

            $table->unique(['name', 'href']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
