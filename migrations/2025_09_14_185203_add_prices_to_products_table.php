<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */public function up(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->decimal('price_before', 10, 2)->nullable()->after('images');
$table->decimal('price_after', 10, 2)->nullable()->after('price_before');

    });
}

public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn(['price_before', 'price_after']);
    });
}

};
