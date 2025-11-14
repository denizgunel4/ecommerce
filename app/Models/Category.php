<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'category_name',
        'category_text',
        'category_order',
        'category_status',
        'category_int_code',
        'parent_id',
        'category_seo_title',
        'category_seo_text',
        'category_seo_keyword',
    ];

    /*
     * Relationships
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category', 'category_id', 'product_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function toApiArray()
    {
        return [
            'CategoryName' => $this->category_name,
            'CategoryText' => $this->category_text ?? '',
            'CategoryStatus' => $this->category_status ?? 1,
            'CategoryOrder' => $this->category_order ?? 0,
            'CategoryIntCode' => $this->category_int_code ?? null,
            'CategoryParent' => $this->parent_id ?? 0,
            'CategorySeoTitle' => $this->category_seo_title ?? '',
            'CategorySeoText' => $this->category_seo_text ?? '',
            'CategorySeoKeyword' => $this->category_seo_keyword ?? '',
        ];
    }
}