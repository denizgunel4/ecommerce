<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';

    protected $fillable = [
        'brand_name',
        'brand_int_code',
        'brand_status',
        'brand_order',
        'brand_text',
        'brand_seo_title',
        'brand_seo_text',
        'brand_seo_keyword',
    ];

    /*
     * Relationships
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'product_brand_id');
    }

    public function toApiArray()
    {
        return [
            'BrandName' => $this->brand_name,
            'BrandIntCode' => $this->brand_int_code ?? null,
            'BrandStatus' => $this->brand_status ?? 0,
            'BrandOrder' => $this->brand_order ?? 1,
            'BrandText' => $this->brand_text ?? '',
            'BrandSeoTitle' => $this->brand_seo_title ?? '',
            'BrandSeoText' => $this->brand_seo_text ?? '',
            'BrandSeoKeyword' => $this->brand_seo_keyword ?? '',
        ];
    }
}

