<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name', 200);
            $table->string('brand_int_code')->nullable()->unique();
            $table->boolean('brand_status')->default(0);
            $table->integer('brand_order')->default(1);
            $table->text('brand_text')->nullable();
            $table->string('brand_seo_title')->nullable();
            $table->text('brand_seo_text')->nullable();
            $table->text('brand_seo_keyword')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
