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
            //$table->unsignedBigInteger('id');
            //$table->id();
            //$table->unsignedBigInteger('id')->autoIncrement();
            //$table->increments('id');
            $table->id();

            $table->unsignedBigInteger('lobby_id');
                //->nullable();
            $table->foreign('lobby_id')
                ->references('id')
                ->on('lobbies')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('track_id');

            $table->foreign('track_id')
                ->references('id')
                ->on('tracks')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedInteger('round_no');

            $table->timestamps();
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
                SET NEW.round_no = (
                    SELECT COALESCE(MAX(round_no), 0) + 1
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
