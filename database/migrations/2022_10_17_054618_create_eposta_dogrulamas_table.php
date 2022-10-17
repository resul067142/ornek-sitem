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
        Schema::create('eposta_dogrulamas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('uyeler_id');
            $table->foreign('uyeler_id')
                ->references('id')
                ->on('uyeler')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('token')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eposta_dogrulamas');
    }
};
