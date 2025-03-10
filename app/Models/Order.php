<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $primaryKey = 'orderNumber';
    
    protected $fillable = [
        'orderNumber',
        'orderDate',
        'status',
        'customerNumber'
    ];
    
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customerNumber', 'customerNumber');
    }
    
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'orderNumber', 'orderNumber');
    }
}
