<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $table = 'variants';

    protected $fillable = [
        'variant_name',
        'variant_status',
        'variant_order',
        'variant_int_code',
    ];

    /*
     * Relationships
     */
    public function values()
    {
        return $this->hasMany(VariantValue::class, 'variant_id');
    }

    public function toApiArray($version = 'v1')
    {
        if ($version === 'v2') {
            return [
                'VaryantName'   => $this->variant_name,
                'VaryantStatus' => $this->variant_status ?? 1,
                'VaryantOrder'  => $this->variant_order ?? 0,
                'VaryantValues' => $this->values->map(function ($value) {
                    return [
                        'Name'             => $value->value_name,
                        'IntegrationCode'  => $value->integration_code,
                        'Order'            => $value->value_order ?? 0,
                    ];
                })->toArray(),
            ];
        }

        $valueArray = [];
        foreach ($this->values as $value) {
            $valueArray[] = [
                $value->integration_code => $value->value_name
            ];
        }

        return [
            'VaryantName'        => $this->variant_name,
            'VaryantStatus'      => $this->variant_status ?? 1,
            'VaryantOrder'       => $this->variant_order ?? 0,
            'VaryantValueNames'  => $valueArray,
        ];
    }
}
