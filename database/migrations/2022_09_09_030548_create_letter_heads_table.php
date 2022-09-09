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
        Schema::create('letter_heads', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('letter_id');
            $table->string('title');
            $table->string('left_picture')->nullable();
            $table->string('right_picture')->nullable();
            $table->string('detail')->nullable();
            $table->string('sub_detail')->nullable();
            $table->timestamps();
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
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
