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
        //
        Schema::table('master_tasks', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
        });

        Schema::table('user_tasks', function (Blueprint $table) {
            $table->foreignId('master_task_id')->constrained()->cascadeOnDelete();
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
