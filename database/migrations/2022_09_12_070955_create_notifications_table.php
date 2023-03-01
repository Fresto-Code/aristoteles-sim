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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();
            $table->uuid('hyperlink_id')->nullable();
            $table->string('hyperlink_type')->nullable();
            $table->string('notification_content')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
        });

        DB::statement('ALTER TABLE notifications ALTER COLUMN id SET DEFAULT uuid_generate_v4();');

        //relation
        Schema::table('notifications', function (Blueprint $table) {
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
        Schema::dropIfExists('notifications');
    }
};
