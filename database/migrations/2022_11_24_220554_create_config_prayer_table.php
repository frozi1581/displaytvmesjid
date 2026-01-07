<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_prayers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id');
            $table->string('name');
            $table->string('box_background_class');
            $table->boolean('is_prayer_time')->default(1);
            $table->integer('time_adjustment')->default(0);
            $table->integer('before_adzan_interval')->default(5);
            $table->integer('iqama_interval')->default(5);
            $table->integer('prayer_interval')->default(5);
            $table->timestamps();

            $table->foreign('mosque_id')
                ->on('mosques')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_prayers');
    }
};
