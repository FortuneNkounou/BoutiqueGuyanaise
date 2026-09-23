<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Récupère les IDs des catégories par slug
        $epices     = Category::where('slug', 'epices-condiments')->first();
        $boissons   = Category::where('slug', 'boissons')->first();
        $frais      = Category::where('slug', 'produits-frais')->first();
        $artisanat  = Category::where('slug', 'artisanat')->first();
        $confiserie = Category::where('slug', 'confiseries')->first();

        $products = [
            [
                'name'        => 'Piment végétarien séché',
                'slug'        => 'piment-vegetarien-seche',
                'description' => 'Piment végétarien de Guyane séché et conditionné. Idéal pour relever vos plats.',
                'price'       => 4.50,
                'stock'       => 100,
                'active'      => true,
                'categories'  => [$epices->id],
            ],
            [
                'name'        => 'Sauce chien maison',
                'slug'        => 'sauce-chien-maison',
                'description' => 'Marinade créole traditionnelle à base de citron, persil, piment et épices.',
                'price'       => 6.00,
                'stock'       => 60,
                'active'      => true,
                'categories'  => [$epices->id],
            ],
            [
                'name'        => 'Rhum arrangé passion-mangue',
                'slug'        => 'rhum-arrange-passion-mangue',
                'description' => 'Rhum blanc arrangé avec des fruits tropicaux : fruit de la passion et mangue.',
                'price'       => 18.00,
                'stock'       => 40,
                'active'      => true,
                'categories'  => [$boissons->id],
            ],
            [
                'name'        => 'Sirop de tamarin',
                'slug'        => 'sirop-tamarin',
                'description' => 'Sirop artisanal de tamarin, parfait pour les cocktails et les boissons fraîches.',
                'price'       => 7.50,
                'stock'       => 50,
                'active'      => true,
                'categories'  => [$boissons->id, $confiserie->id],
            ],
            [
                'name'        => 'Jus de corossol',
                'slug'        => 'jus-corossol',
                'description' => 'Jus naturel de corossol (graviola), riche en vitamines et 100% local.',
                'price'       => 5.00,
                'stock'       => 80,
                'active'      => true,
                'categories'  => [$boissons->id, $frais->id],
            ],
            [
                'name'        => 'Caramboles fraîches (500g)',
                'slug'        => 'caramboles-fraiches',
                'description' => 'Caramboles fraîches récoltées localement. Sucrées et croquantes.',
                'price'       => 3.50,
                'stock'       => 30,
                'active'      => true,
                'categories'  => [$frais->id],
            ],
            [
                'name'        => 'Panier en vannerie amérindienne',
                'slug'        => 'panier-vannerie-amerindienne',
                'description' => 'Panier artisanal tressé à la main par des artisans amérindiens de Guyane.',
                'price'       => 35.00,
                'stock'       => 15,
                'active'      => true,
                'categories'  => [$artisanat->id],
            ],
            [
                'name'        => 'Collier de graines naturelles',
                'slug'        => 'collier-graines-naturelles',
                'description' => 'Collier artisanal fabriqué avec des graines et graminées de la forêt amazonienne.',
                'price'       => 12.00,
                'stock'       => 25,
                'active'      => true,
                'categories'  => [$artisanat->id],
            ],
            [
                'name'        => 'Confiture de goyave',
                'slug'        => 'confiture-goyave',
                'description' => 'Confiture maison de goyave rose, sans conservateurs, préparée selon la recette créole.',
                'price'       => 5.50,
                'stock'       => 70,
                'active'      => true,
                'categories'  => [$confiserie->id, $frais->id],
            ],
            [
                'name'        => 'Tablette de chocolat noir au piment',
                'slug'        => 'chocolat-noir-piment',
                'description' => 'Chocolat noir 70% cacao avec une touche de piment guyanais. Alliance surprenante.',
                'price'       => 4.00,
                'stock'       => 90,
                'active'      => true,
                'categories'  => [$confiserie->id, $epices->id],
            ],
        ];

        foreach ($products as $data) {
            $categories = $data['categories'];
            unset($data['categories']);

            $product = Product::create($data);
            // Attache les catégories (relation Many-to-Many)
            $product->categories()->attach($categories);
        }
    }
}
