<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductLine extends Model
{
    use HasFactory;
    protected $primaryKey = 'productLine';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'productLine',
        'textDescription',
        'image'
    ];
    
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'productLine', 'productLine');
    }

}
