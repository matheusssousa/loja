<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupom extends Model
{
    /** @use HasFactory<\Database\Factories\CupomFactory> */
    use HasFactory;

    protected $fillable = [
        'codigo',
        'desconto',
        'data_expiracao',
        'valor_minimo',
    ];

    protected $casts = [
        'data_expiracao' => 'datetime',
        'valor_minimo' => 'decimal:2',
        'desconto' => 'decimal:2',
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function scopeSearch(Builder $query, $request)
    {
        return $query->when($request->codigo, function (Builder $query, $codigo) {
            return $query->where('codigo', 'like', "%{$codigo}%");
        })->when($request->data_expiracao, function (Builder $query, $dataExpiracao) {
            return $query->whereDate('data_expiracao', $dataExpiracao);
        });
    }
}
