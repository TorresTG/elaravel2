<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'customerNumber';
    
    protected $fillable = [
        'customerNumber',
        'customerName',
        'phone',
        'salesRepEmployeeNumber'
    ];
    
    public function salesRep(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'salesRepEmployeeNumber', 'employeeNumber');
    }
    
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customerNumber', 'customerNumber');
    }
    
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'customerNumber', 'customerNumber');
    }
}
