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
        Schema::table('kitaplars', function (Blueprint $table) {
            $table->bigInteger('uyeler_id')->nullable()->default(null);
            $table->foreign('uyeler_id')
                ->references('id')
                ->on('uyeler')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kitaplars', function (Blueprint $table) {
            $table->dropColumn('uyeler_id');
        });
    }
};
