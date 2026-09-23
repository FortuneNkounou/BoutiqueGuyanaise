<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Épices & Condiments',
                'slug'        => 'epices-condiments',
                'description' => 'Épices locales, piments, marinades et sauces typiques de Guyane.',
            ],
            [
                'name'        => 'Boissons',
                'slug'        => 'boissons',
                'description' => 'Jus de fruits tropicaux, sirops, rhums et boissons artisanales.',
            ],
            [
                'name'        => 'Produits Frais',
                'slug'        => 'produits-frais',
                'description' => 'Fruits et légumes frais de Guyane, directement des producteurs locaux.',
            ],
            [
                'name'        => 'Artisanat',
                'slug'        => 'artisanat',
                'description' => 'Objets artisanaux, bijoux et décorations fabriqués en Guyane.',
            ],
            [
                'name'        => 'Confiseries',
                'slug'        => 'confiseries',
                'description' => 'Sucreries, confitures et douceurs typiques de Guyane.',
            ],
        ];

        foreach ($categories as $data) {
            Category::create($data);
        }
    }
}
