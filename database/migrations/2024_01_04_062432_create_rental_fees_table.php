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
        Schema::create('rental_fees', function (Blueprint $table) {
            $table->id('rentFee_ID');
            $table->foreignId("parti_ID")->references("parti_ID")->on("participants")->nullable();
            $table->string('month')->nullable();
            $table->float('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_fees');
    }
};
