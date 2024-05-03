<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'titulo', 'imagem', 'conteudo', 'data_publicacao', 'status'];

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'blog_categoria');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
