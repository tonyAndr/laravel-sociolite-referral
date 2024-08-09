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
            $table->mediumText('telegram_payment_charge_id')->nullable();
            $table->mediumText('reason')->nullable(); 
            $table->integer('invoice_msg_id')->nullable();
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
