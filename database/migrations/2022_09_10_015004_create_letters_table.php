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
        Schema::create('letters', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->uuid('user_recipient_id')->nullable();
            $table->boolean('is_reviewed')->default(false);
            $table->string('note')->nullable();
            $table->string('url')->nullable();
            $table->string('reply_latter')->nullable();
            $table->timestamps();
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
        });

        DB::statement('ALTER TABLE letters ALTER COLUMN id SET DEFAULT uuid_generate_v4();');

        //relation
        Schema::table('letters', function (Blueprint $table) {
            $table->foreign('user_recipient_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('letters');
    }
};
