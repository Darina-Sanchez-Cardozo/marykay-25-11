<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id_admin';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'password'
    ];
}
