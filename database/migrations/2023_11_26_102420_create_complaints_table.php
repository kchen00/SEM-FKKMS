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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id("complaint_ID");
            $table->string("parti_ID")->references("parti_ID")->on("participants");
            $table->string("tech_ID")->references("tech_ID")->on("tech_teams");
            $table->enum("complaint_status", ["open", "close", "in_progress", "completed"]);
            $table->string("description", 256);
            $table->string("complaint_title", 256);
            $table->string("complaint_solution", 256);
            
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
