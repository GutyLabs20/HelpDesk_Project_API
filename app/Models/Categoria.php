<?php

namespace App\Models;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory, ApiTrait;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre', 'descripcion', 'slug', 'activo'
    ];

    //Agregando una coleccion
    // protected $allowIncluded = ['publicaciones', 'publicaciones.usuario'];
    protected $allowFilter = ['id', 'nombre', 'descripcion', 'slug'];
    protected $allowSort = ['id', 'nombre', 'descripcion', 'slug'];
}
