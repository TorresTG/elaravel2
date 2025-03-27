<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'igmar_db';

    protected $fillable = ['user_id', 'url', 'methodo', 'header', 'func', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
