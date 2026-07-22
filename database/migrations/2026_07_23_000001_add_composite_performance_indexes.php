<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ponytail: composite indexes for common multi-column filter patterns

        // waste_listings: marketplace filters on (verification + availability + created_at)
        Schema::table('waste_listings', function (Blueprint $table) {
            $table->index(
                ['verification_status', 'availability_status', 'created_at'],
                'wl_verified_available_latest'
            );
        });

        // orders: buyer/seller order list + filter by status
        Schema::table('orders', function (Blueprint $table) {
            $table->index(['buyer_id', 'order_status'], 'orders_buyer_status');
            $table->index(['seller_id', 'order_status'], 'orders_seller_status');
        });

        // listing_images: primary image lookup
        Schema::table('listing_images', function (Blueprint $table) {
            $table->index(['listing_id', 'is_primary'], 'li_listing_primary');
        });
    }

    public function down(): void
    {
        Schema::table('waste_listings', function (Blueprint $table) {
            $table->dropIndex('wl_verified_available_latest');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_buyer_status');
            $table->dropIndex('orders_seller_status');
        });

        Schema::table('listing_images', function (Blueprint $table) {
            $table->dropIndex('li_listing_primary');
        });
    }
};
