<?php

namespace Database\Seeders;

use App\Models\Cupom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CupomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cupons = [
            [
                'codigo' => 'DESCONTO10',
                'desconto' => 10.00,
                'valor_minimo' => 50.00,
                'data_expiracao' => now()->addDays(30),
            ],
            [
                'codigo' => 'FRETE15',
                'desconto' => 15.00,
                'valor_minimo' => 100.00,
                'data_expiracao' => now()->addDays(15),
            ],
            [
                'codigo' => 'PROMO25',
                'desconto' => 25.00,
                'valor_minimo' => 200.00,
                'data_expiracao' => now()->addDays(7),
            ],
            [
                'codigo' => 'WELCOME20',
                'desconto' => 20.00,
                'valor_minimo' => 80.00,
                'data_expiracao' => now()->addDays(60),
            ],
            [
                'codigo' => 'EXPIRED5',
                'desconto' => 5.00,
                'valor_minimo' => 30.00,
                'data_expiracao' => now()->subDays(1),
            ]
        ];

        foreach ($cupons as $cupomData) {
            Cupom::create($cupomData);
        }
    }
}
