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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('amount')->comment('Payment amount in cents');
            $table->string('client');
            $table->string('kind');
            $table->string('merchant');
            $table->string('ref');
            $table->string('status');
            $table->dateTime('timestamp');;
            $table->timestamps();

            $table->foreign('client')->references('phone')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
