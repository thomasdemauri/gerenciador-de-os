<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HandymanService;
use App\Models\ProductService;
use App\Models\Customer;
use App\Models\User;

class ServiceOrder extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceOrderFactory> */
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_id',
        'vehicle',
        'total_services',
        'total_products',
        'discount',
        'total_so',
        'status',
        'data_os',
        'observation'
    ];


    public function handymanServices()
    {
        return $this->hasMany(handymanService::class);
    }

    public function products()
    {
        return $this->hasMany(ProductService::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
