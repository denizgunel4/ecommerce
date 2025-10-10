<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantValue extends Model
{
    use HasFactory;

    protected $table = 'variant_values';

    protected $fillable = [
        'variant_id',
        'value_name',
        'integration_code',
        'value_order',
    ];

    /*
     * Relationships
     */
    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id');
    }

    public function toApiArray($version = 'v1')
    {
        if ($version === 'v2') {
            return [
                'Name'            => $this->value_name,
                'IntegrationCode' => $this->integration_code,
                'Order'           => $this->value_order ?? 0,
            ];
        }

        return [
            $this->integration_code => $this->value_name,
        ];
    }
}

