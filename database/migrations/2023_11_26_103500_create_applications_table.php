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
        Schema::create('applications', function (Blueprint $table) {
            $table->id("application_ID");
            //store ssm file file path
            $table->string("SSM", 256);
            $table->enum("status", ["rejected", "accepted"]);
            $table->string("description", 256);
            $table->bigInteger("parti_ID")->references("parti_ID")->on("pariticipants");            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
