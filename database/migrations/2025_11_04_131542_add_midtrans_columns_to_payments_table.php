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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('order_id')->unique()->after('id');
            $table->foreignId('enrollment_id')->nullable()->after('user_id')->constrained('enrollments')->cascadeOnDelete();
            $table->string('snap_token')->nullable()->after('metadata');
            $table->string('transaction_id')->nullable()->after('snap_token');
            $table->string('transaction_status')->nullable()->after('transaction_id');
            $table->string('fraud_status')->nullable()->after('transaction_status');
            $table->timestamp('paid_at')->nullable()->after('fraud_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'order_id',
                'enrollment_id',
                'snap_token',
                'transaction_id',
                'transaction_status',
                'fraud_status',
                'paid_at'
            ]);
        });
    }
};
