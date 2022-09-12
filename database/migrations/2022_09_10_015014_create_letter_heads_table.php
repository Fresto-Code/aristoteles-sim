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
        Schema::create('letter_heads', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->uuid('letter_id');
            $table->string('title');
            $table->string('left_picture')->nullable();
            $table->string('right_picture')->nullable();
            $table->string('detail')->nullable();
            $table->string('sub_detail')->nullable();
            $table->timestamps();
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
        });

        DB::statement('ALTER TABLE letter_heads ALTER COLUMN id SET DEFAULT uuid_generate_v4();');

        //relation
        Schema::table('letter_heads', function (Blueprint $table) {
            $table->foreign('letter_id')->references('id')->on('letters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('letter_heads');
    }
};
