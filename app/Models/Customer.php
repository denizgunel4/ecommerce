<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'customer_status',
        'customer_id',
    ];

    /*
     * Relationships
     */
    public function products()
    {
    return $this->hasMany(Product::class, 'customer_id');
    }


    public function toApiArray()
    {
        return [
            'CustomerName' => $this->customer_name,
            'CustomerEmail' => $this->customer_email ?? '',
            'CustomerPhone' => $this->customer_phone ?? '',
            'CustomerAddress' => $this->customer_address ?? '',
            'CustomerStatus' => $this->customer_status ?? 1,
            'CustomerIntCode' => $this->customer_id,
        ];
    }
}

