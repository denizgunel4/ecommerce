<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variant_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('variant_id');
            $table->string('value_name');
            $table->string('integration_code')->nullable();
            $table->integer('order')->default(0);
            $table->integer('status')->default(1); //active/inactive
            $table->timestamps();

            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variant_values');
    }
};

