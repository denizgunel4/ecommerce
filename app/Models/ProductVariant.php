<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'variant_id',
        'variant_value1_id',
        'variant_value2_id',
        'variant_value3_id',
        'variant_code',
        'variant_product_code',
        'barcode',
        'variant_price',
        'variant_discount',
        'variant_sale_price',
        'variant_vat_excluded_price',
        'variant_vat_rate',
        'variant_cost_price',
        'variant_profit_rate',
        'variant_market_price',
        'variant_stock_amount',
        'variant_is_reduced',
        'variant_status',
        'variant_seo_title',
        'variant_seo_description',
        'variant_seo_keywords',
        'variant_seo_url',
        'desi_kg',
        'deger0',
        'deger1',
        'deger2',
    ];

    protected $casts = [
        'variant_is_reduced' => 'boolean',
    ];

    /*
     * Relationships
     */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function variantValues()
    {
    return $this->belongsToMany(VariantValue::class, 'product_variant_values', 'product_variant_id', 'variant_value_id');
    }

    public function toApiArray()
    {
        return [
            'ProductID' => $this->product_id,
            'VaryantPrice' => $this->variant_price ?? 0,
            'VaryantDiscount' => $this->variant_discount ?? 0,
            'VaryantSalePrice' => $this->variant_sale_price ?? null,
            'VaryantVatExcludedPrice' => $this->variant_vat_excluded_price ?? 0,
            'VaryantVatRate' => $this->variant_vat_rate ?? 0,
            'VaryantCostPrice' => $this->variant_cost_price ?? 0,
            'VaryantProfitRate' => $this->variant_profit_rate ?? 0,
            'VaryantMarketPrice' => $this->variant_market_price ?? 0,
            'VaryantCode' => $this->variant_code,
            'VaryantProductCode' => $this->variant_product_code,
            'Barkod' => $this->barcode,
            'VaryantStockAmount' => $this->variant_stock_amount ?? 0,
            'VaryantIsReduced' => $this->variant_is_reduced ?? false,
            'VaryantValue1' => $this->variant_value1_id,
            'VaryantValue2' => $this->variant_value2_id,
            'VaryantValue3' => $this->variant_value3_id,
            'VaryantStatus' => $this->variant_status ?? 1,
            'VaryantSeoTitle' => $this->variant_seo_title ?? '',
            'VaryantSeoDescription' => $this->variant_seo_description ?? '',
            'VaryantSeoKeywords' => $this->variant_seo_keywords ?? '',
            'VaryantSeoUrl' => $this->variant_seo_url ?? '',
            'DesiKilogram' => $this->desi_kg ?? 0,
            'Deger0' => $this->deger0 ?? null,
            'Deger1' => $this->deger1 ?? null,
            'Deger2' => $this->deger2 ?? null,
        ];
    }
}
