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
            $table->string('cinsiyet')->nullable()->default(null);
            $table->string('dogum_tarihi')->nullable()->default(null);
            $table->string('lat')->nullable()->default(null);
            $table->string('lon')->nullable()->default(null);
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
            $table->dropColumn('cinsiyet');
            $table->dropColumn('dogum_tarihi');
            $table->dropColumn('lat');
            $table->dropColumn('lon');
        });
    }
};
