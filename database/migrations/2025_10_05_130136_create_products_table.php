<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_code')->nullable()->unique();
            $table->string('product_strich_code')->nullable();
            $table->boolean('product_status')->default(1);
            $table->decimal('product_price', 10, 2)->default(0);
            $table->decimal('product_discount_rate', 5, 2)->nullable();
            $table->decimal('product_sale_price', 10, 2)->nullable();
            $table->decimal('product_cost_price', 10, 2)->nullable();
            $table->decimal('product_profit_rate', 5, 2)->nullable();
            $table->decimal('product_vat_excluded_price', 10, 2)->nullable();
            $table->decimal('product_vat_rate', 5, 2)->nullable();
            $table->decimal('product_tax_rate', 5, 2)->nullable();
            $table->unsignedBigInteger('product_brand_id')->nullable();
            $table->unsignedBigInteger('product_supplier_id')->nullable();
            $table->string('product_unit')->nullable();
            $table->integer('product_buy_min')->nullable();
            $table->integer('product_buy_increase')->nullable();
            $table->string('product_varyant1')->nullable();
            $table->string('product_varyant2')->nullable();
            $table->string('product_varyant3')->nullable();
            $table->integer('product_order')->nullable();
            $table->string('product_type')->nullable();
            $table->text('product_shrt_text')->nullable();
            $table->longText('product_text')->nullable();
            $table->string('product_seo_title')->nullable();
            $table->text('product_seo_text')->nullable();
            $table->string('product_seo_keyword')->nullable();
            $table->boolean('product_show_case')->default(false);
            $table->boolean('product_opportunity')->default(false);
            $table->boolean('product_free_ship')->default(false);
            $table->string('product_ship_time')->nullable();
            $table->string('product_free_ins_time')->nullable();
            $table->string('product_guarantee')->nullable();
            $table->boolean('product_editor_choice')->default(false);
            $table->boolean('product_fast_ship')->default(false);
            $table->boolean('product_same_day_delivery')->default(false);
            $table->boolean('product_discounted')->default(false);
            $table->boolean('product_bundle')->default(false);
            $table->text('product_gifts')->nullable();
            $table->json('domains')->nullable();
            $table->json('image_list')->nullable();
            $table->json('properties')->nullable();
            $table->string('deger0')->nullable();
            $table->string('deger1')->nullable();
            $table->string('deger2')->nullable();
            $table->timestamps();

            $table->foreign('product_brand_id')->references('id')->on('brands')->onDelete('set null');
            $table->foreign('product_supplier_id')->references('id')->on('suppliers')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

