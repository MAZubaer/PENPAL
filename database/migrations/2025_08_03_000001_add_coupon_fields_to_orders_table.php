<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('coupon_code')->nullable();
            $table->decimal('discounted_total', 10, 2)->nullable();
        });
    }
    public function down() {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['coupon_code', 'discounted_total']);
        });
    }
};
