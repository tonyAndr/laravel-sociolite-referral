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
        Schema::table('bot_user', function (Blueprint $table) {
            $table->bigInteger('ref_id')->nullable()->comment('Who invited - TG ID');
            $table->integer('balance')->default(0)->comment('Referral balance in STARS (TG currency)');
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
