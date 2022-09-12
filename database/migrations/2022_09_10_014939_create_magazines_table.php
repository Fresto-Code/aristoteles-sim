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
        Schema::create('magazines', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->uuid('author_id');
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('url')->nullable();
            $table->string('cover')->nullable();
            $table->enum('moderation_status', ['draft', 'published'])->default('draft');
            $table->timestamps();
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
        });

        DB::statement('ALTER TABLE magazines ALTER COLUMN id SET DEFAULT uuid_generate_v4();');

         //relation
         Schema::table('magazines', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('magazines');
    }
};
