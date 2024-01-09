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
            $table->id("rentals_ID");
            $table->string("description", 256);
            $table->enum("status", ["on going", "teminated"]);
            $table->foreignId("parti_ID")->references("parti_ID")->on("participants")->nullable();
            $table->foreignId("kiosk_ID")->references("kiosk_ID")->on("kiosks")->nullable();
            $table->timestamp("startdate")->nullable();
            $table->timestamp("enddate")->nullable();
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
