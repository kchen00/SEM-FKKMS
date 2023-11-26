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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id("rental_ID");
            $table->string("description", 256);
            $table->enum("status", ["on going", "teminated"]);
            $table->bigInteger("parti_ID")->references("parti_ID")->on("pariticipants");
            $table->bigInteger("kiosk_ID")->references("kiosk_ID")->on("kiosks");
            $table->timestamp("startdate")->nullable();
            $table->timestamp("enddate")->nullable();
            $table->bigInteger("payment_ID")->references("payment_ID")->on("payments");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
