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
            $table->foreignId('coupon_id')->nullable()->after('enrollment_id')->constrained('coupons')->nullOnDelete();
            $table->decimal('subtotal', 12, 2)->after('amount');
            $table->decimal('discount_amount', 12, 2)->default(0)->after('subtotal');
            $table->decimal('tax_amount', 12, 2)->default(0)->after('discount_amount');
            $table->decimal('tax_rate', 5, 2)->default(0)->after('tax_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['coupon_id']);
            $table->dropColumn([
                'coupon_id',
                'subtotal',
                'discount_amount',
                'tax_amount',
                'tax_rate'
            ]);
        });
    }
};
