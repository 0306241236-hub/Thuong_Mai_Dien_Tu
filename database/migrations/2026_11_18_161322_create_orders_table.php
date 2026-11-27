<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('receiver_name', 150);
                $table->string('receiver_phone', 20);
                $table->text('shipping_address');
                $table->decimal('total_amount', 12, 2);
                $table->string('payment_method', 50)->default('COD');
                $table->string('status', 30)->default('pending'); // pending | shipping | completed | cancelled
                $table->timestamps();

                $table->index(['user_id', 'status']);
            });
        } elseif (!Schema::hasColumn('orders', 'payment_method')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('payment_method', 50)->default('COD')->after('total_amount');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};