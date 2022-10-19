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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->default(null);
            $table->text('body')->nullable()->default(null);
            $table->string('image')->nullable()->default(null);
            $table->timestamp('publish_at')->nullable()->default(null);
            $table->string('url');
            $table->string('hash')->unique();
            $table->enum('status', [ 'wait', 'ok', 'fail', 'called' ])->default('wait');
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
        Schema::dropIfExists('news');
    }
};
