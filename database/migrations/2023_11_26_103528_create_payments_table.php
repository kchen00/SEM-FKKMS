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
            $table->id("payment_ID");
            $table->foreignId("parti_ID");
            $table->string("payment_proof",256)->nullable();
            $table->enum("status", ["accepted", "rejected","received","on review"]);
            //note left by bursary if the pyament is rejected
            $table->string("notes", 256)->nullable(true);
            $table->string("feedback", 256)->nullable(true);
            $table->float("amount")->nullable(true);
            $table->timestamps();
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
