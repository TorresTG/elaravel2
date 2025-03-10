<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Office extends Model
{
    use HasFactory;

    protected $primaryKey = 'officeCode';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'officeCode',
        'city',
        'phone',
        'country'
    ];
    
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'officeCode', 'officeCode');
    }
}
