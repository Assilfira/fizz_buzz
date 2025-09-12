<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fizzbuzz_request_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('int1');
            $table->unsignedInteger('int2');
            $table->unsignedInteger('limit');
            $table->string('str1', 15);
            $table->string('str2', 15);
            $table->unsignedBigInteger('hits')->default(0);

            $table->primary(['int1', 'int2', 'limit', 'str1', 'str2'], 'fbrs_pk');
            $table->index('hits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fizzbuzz_request_stats');
    }
};
