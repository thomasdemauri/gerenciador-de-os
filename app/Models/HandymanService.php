<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceOrder;

class HandymanService extends Model
{
    /** @use HasFactory<\Database\Factories\HandymanServiceFactory> */
    use HasFactory;

    protected $fillable = [
        'service_order_id',
        'description',
        'quantity',
        'unit_price',
        'total_price'
    ];

    public function orderService()
    {
        return $this->belongsTo(ServiceOrder::class);
    }
}
