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
        Schema::create('twitter_tokens', function (Blueprint $table) {
            $table->id();

            $table->string('consumer_key');
            $table->string('consumer_secret');
            $table->string('token');
            $table->string('token_secret');
            $table->enum('stream_type', [ 'track', 'follow', 'locations' ])->nullable()->default(null);
            $table->json('stream_params')->nullable()->default(null);
            $table->integer('pid')->nullable()->default(null);

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
        Schema::dropIfExists('twitter_tokens');
    }
};
