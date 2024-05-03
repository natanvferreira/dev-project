<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['titulo'];

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_categoria');
    }

    public static function buscaPeloNome($titulo)
    {
        return static::where('titulo', $titulo)->first();
    }
}
