<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Compte administrateur
        User::create([
            'name'     => 'Administrateur',
            'email'    => 'admin@boutiqueguyanaise.fr',
            'password' => Hash::make('admin1234'),
            'role'     => 'admin',
            'phone'    => '0594000001',
            'address'  => '1 Rue de la République, Cayenne, 97300',
        ]);

        // Compte utilisateur de test
        User::create([
            'name'     => 'Jean Dupont',
            'email'    => 'jean@example.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'phone'    => '0594000002',
            'address'  => '12 Avenue du Général de Gaulle, Kourou, 97310',
        ]);

        // Deuxième utilisateur de test
        User::create([
            'name'     => 'Marie Martin',
            'email'    => 'marie@example.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'phone'    => '0594000003',
            'address'  => '5 Boulevard du Marché, Remire-Montjoly, 97354',
        ]);
    }
}
