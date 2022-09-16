<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('moderation_comments', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->uuid('magazine_id');
            $table->uuid('user_id');
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
        });

        DB::statement('ALTER TABLE moderation_comments ALTER COLUMN id SET DEFAULT uuid_generate_v4();');

        //relation
        Schema::table('moderation_comments', function (Blueprint $table) {
            $table->foreign('magazine_id')->references('id')->on('magazines');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moderation_comments');
    }
};
