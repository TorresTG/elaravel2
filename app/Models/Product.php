<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'productName',
        'productLine',
        'quantityInStock'
    ];
    
    public function productLine(): BelongsTo
    {
        return $this->belongsTo(ProductLine::class,);
    }
    
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
}
