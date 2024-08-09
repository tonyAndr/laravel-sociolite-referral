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
        Schema::create('master_tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('buyer_id');
            $table->string('status', 20)->default('pre-review');
            $table->string('proof_type', 20)->default('none'); // text, screenshot
            $table->text('description')->nullable();
            $table->text('title')->nullable();
            $table->integer('requested')->default(0);
            $table->integer('fullfilled')->default(0);
            $table->float('price')->default(0); // = ppr * requested
            $table->integer('user_reward')->default(5);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_tasks');
    }
};
