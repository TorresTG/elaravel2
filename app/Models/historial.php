<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'historial'; // Nombre corregido
    protected $fillable = ['user_id', 'user_name', 'url', 'methodo', 'func'];
    
    // Relación opcional si necesitas acceder al usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
