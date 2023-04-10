<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verificator extends Model{
    use HasFactory;
    
    const STATUS_OK = 1;
    const STATUS_NO = 2;
    
    protected $table = 'verificator';
    protected $fillable = [
        'code',
        'email',
        'status',
    ];

}
