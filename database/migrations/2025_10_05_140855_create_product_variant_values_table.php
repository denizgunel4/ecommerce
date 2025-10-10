<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('variant_id');
            $table->unsignedBigInteger('variant_value1_id')->nullable();
            $table->unsignedBigInteger('variant_value2_id')->nullable();
            $table->unsignedBigInteger('variant_value3_id')->nullable();
            
            $table->decimal('variant_price', 15, 2)->default(0);
            $table->decimal('variant_discount', 5, 2)->default(0);
            $table->decimal('variant_sale_price', 15, 2)->nullable();
            $table->decimal('variant_vat_excluded_price', 15, 2)->nullable();
            $table->decimal('variant_cost_price', 15, 2)->nullable();
            $table->decimal('variant_profit_rate', 5, 2)->nullable();
            
            $table->integer('variant_stock_amount')->default(0);
            $table->boolean('variant_is_reduced')->default(false);
            $table->integer('variant_status')->default(1);
            
            $table->string('variant_code')->nullable();
            $table->string('variant_product_code')->nullable();
            $table->string('barcode', 64)->nullable();
            
            $table->string('variant_seo_title')->nullable();
            $table->string('variant_seo_description')->nullable();
            $table->string('variant_seo_keywords')->nullable();
            $table->string('variant_seo_url')->nullable();
            $table->decimal('variant_market_price', 15, 2)->nullable();
            
            $table->decimal('desi_kg', 8, 2)->nullable();
            $table->string('deger0')->nullable();
            $table->string('deger1')->nullable();
            $table->string('deger2')->nullable();

            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');
            $table->foreign('variant_value1_id')->references('id')->on('variant_values')->onDelete('set null');
            $table->foreign('variant_value2_id')->references('id')->on('variant_values')->onDelete('set null');
            $table->foreign('variant_value3_id')->references('id')->on('variant_values')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
}
