<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;
    protected $primaryKey = 'employeeNumber';
    protected $fillable = [
        'employeeNumber',
        'lastName',
        'firstName',
        'officeCode'
    ];
    
    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'officeCode', 'officeCode');
    }
    
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'salesRepEmployeeNumber', 'employeeNumber');
    }
}
