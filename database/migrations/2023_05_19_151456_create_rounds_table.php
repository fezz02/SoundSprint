<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('lobby_id');

            $table->foreign('lobby_id')
                ->references('id')
                ->on('lobbies')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('track_id')
                ->references('id')
                ->on('tracks')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->primary(['id', 'lobby_id']);
        });

        $this->createCustomAutoIncrementTrigger();
    }

    public function down()
    {
        $this->dropCustomAutoIncrementTrigger();

        Schema::dropIfExists('rounds');
    }

    private function createCustomAutoIncrementTrigger()
    {
        DB::unprepared('
            CREATE TRIGGER round_id_auto_increment BEFORE INSERT ON rounds
            FOR EACH ROW
            BEGIN
                SET NEW.id = (
                    SELECT COALESCE(MAX(id), 0) + 1
                    FROM rounds
                    WHERE lobby_id = NEW.lobby_id
                );
            END
        ');
    }

    private function dropCustomAutoIncrementTrigger()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS round_id_auto_increment');
    }
};
