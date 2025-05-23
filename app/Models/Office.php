<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Office extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'city',
        'phone',
        'country'
    ];
    
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
