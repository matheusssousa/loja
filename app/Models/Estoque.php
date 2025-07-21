<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    /** @use HasFactory<\Database\Factories\EstoqueFactory> */
    use HasFactory;

    protected $fillable = [
        'produto_id',
        'quantidade',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
