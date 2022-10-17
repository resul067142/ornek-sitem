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
        Schema::table('uyeler', function (Blueprint $table) {
            $table->timestamp('e_posta_dogrulanma_zamani')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uyeler', function (Blueprint $table) {
            $table->dropColumn('e_posta_dogrulanma_zamani');
        });
    }
};
