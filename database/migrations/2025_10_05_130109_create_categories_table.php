<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name', 200);
            $table->text('category_text')->nullable();
            $table->integer('category_order')->default(0);
            $table->integer('category_status')->default(1);
            $table->string('category_int_code')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->string('category_seo_title', 255)->nullable();
            $table->string('category_seo_text', 255)->nullable();
            $table->string('category_seo_keyword')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
