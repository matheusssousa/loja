<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    /** @use HasFactory<\Database\Factories\ProdutoFactory> */
    use HasFactory;

    protected $fillable = [
        'nome',
        'preco',
        'variacoes',
    ];

    protected $casts = [
        'variacoes' => 'array',
    ];

    public function scopeSearch(Builder $query, $request)
    {
        return $query->when($request->nome, function (Builder $query, $nome) {
            return $query->where('nome', 'like', "%{$nome}%");
        });
    }

    public function estoque()
    {
        return $this->hasOne(Estoque::class);
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class)->withPivot('quantidade', 'preco_unitario')->withTimestamps();
    }
}
