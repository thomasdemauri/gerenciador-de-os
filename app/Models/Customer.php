<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceOrder;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'nickname',
        'phone',
    ];

    public function orderServices()
    {
        return $this->hasMany(ServiceOrder::class);
    }
}
