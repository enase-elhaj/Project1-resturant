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
        Schema::create('bookings', function (Blueprint $table) {
            // $table->id();
            // $table->unsignedBigInteger('user_id');
            // $table->date('date');
            // $table->string('time')->nullable();
            // $table->string('nameb');
            // $table->string('phone');
            // $table->integer('persons');
            // $table->enum('status', ['Waiting', 'Rejected', 'Approved'])->default('Waiting');
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->timestamps();

            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->time('time');
            $table->string('nameb');
            $table->string('phone');
            $table->integer('persons');
            $table->enum('status', ['Waiting', 'Rejected', 'Approved'])->default('Waiting');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
