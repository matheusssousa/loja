<?php

namespace Database\Seeders;

use App\Models\Produto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produtos = [
            [
                'nome' => 'Camiseta Básica',
                'preco' => 29.99,
                'variacoes' => ['P', 'M', 'G', 'GG'],
            ],
            [
                'nome' => 'Calça Jeans',
                'preco' => 89.90,
                'variacoes' => ['36', '38', '40', '42', '44'],
            ],
            [
                'nome' => 'Tênis Esportivo',
                'preco' => 199.99,
                'variacoes' => ['37', '38', '39', '40', '41', '42'],
            ]
        ];

        foreach ($produtos as $produtoData) {
            $produto = Produto::create($produtoData);
            
            $produto->estoque()->create([
                'quantidade' => rand(10, 100),
            ]);
        }
    }
}
