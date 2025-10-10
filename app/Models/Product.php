<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'product_code',
        'product_strich_code',
        'product_status',
        'product_price',
        'product_discount_rate',
        'product_sale_price',
        'product_cost_price',
        'product_profit_rate',
        'product_vat_excluded_price',
        'product_vat_rate',
        'product_tax_rate',
        'product_brand_id',
        'product_supplier_id',
        'product_unit',
        'product_buy_min',
        'product_buy_increase',
        'product_varyant1',
        'product_varyant2',
        'product_varyant3',
        'product_order',
        'product_type',
        'product_shrt_text',
        'product_text',
        'product_seo_title',
        'product_seo_text',
        'product_seo_keyword',
        'product_show_case',
        'product_opportunity',
        'product_free_ship',
        'product_ship_time',
        'product_free_ins_time',
        'product_guarantee',
        'product_editor_choice',
        'product_fast_ship',
        'product_same_day_delivery',
        'product_discounted',
        'product_bundle',
        'product_gifts',
        'domains',
        'image_list',
        'properties',
        'deger0',
        'deger1',
        'deger2',
    ];

    protected $casts = [
        'domains' => 'array',
        'image_list' => 'array',
        'properties' => 'array',
    ];

    /*
     * Relationships
     */

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'product_brand_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariantValue::class, 'product_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id');
    }

    
    public function toApiArray()
    {
        return [
            'ProductName' => $this->product_name,
            'ProductPrice' => $this->product_price,
            'ProductDiscountRate' => $this->product_discount_rate,
            'ProductSalePrice' => $this->product_sale_price,
            'ProductBrandID' => $this->product_brand_id,
            'ProductSupplierID' => $this->product_supplier_id,
            'ProductVaryant1' => $this->product_varyant1,
            'ProductVaryant2' => $this->product_varyant2,
            'ProductVaryant3' => $this->product_varyant3,
            'ProductCategories' => $this->categories ? $this->categories->pluck('id')->toArray() : [],
            'ImageList' => $this->image_list,
            'Ozellikler' => $this->properties,
            'ProductCode' => $this->product_code,
            'ProductStrichCode' => $this->product_strich_code,
            'ProductStatus' => $this->product_status,
            'ProductShrtText' => $this->product_shrt_text,
            'ProductText' => $this->product_text,
            'ProductSeoTitle' => $this->product_seo_title,
            'ProductSeoText' => $this->product_seo_text,
            'ProductSeoKeyword' => $this->product_seo_keyword,
            'Domains' => $this->domains,
            'Deger0' => $this->deger0,
            'Deger1' => $this->deger1,
            'Deger2' => $this->deger2,
        ];
    }
}
