<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    /** @use HasFactory<\Database\Factories\PedidoFactory> */
    use HasFactory;

    protected $fillable = [
        'cupom_id',
        'status',
        'total',
        'cliente_email',
        'endereco',
    ];
    
    public function cupom()
    {
        return $this->belongsTo(Cupom::class, 'cupom_id');
    }

    public function produtos()
    {
        return $this->belongsToMany(Produto::class)->withPivot('quantidade', 'preco_unitario')->withTimestamps();
    }
}
