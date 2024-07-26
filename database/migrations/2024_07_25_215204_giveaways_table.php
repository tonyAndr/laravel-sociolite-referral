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
        Schema::create('giveaways', function (Blueprint $table) {
            $table->id();
            $table->timestamp('finalization_date')->nullable();
            $table->integer('winner_id')->nullable();
            $table->integer('reward')->default(100);
            $table->integer('participants_count')->default(100);
            $table->string('status')->default('active'); // or finished
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
