<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['libelle' => 'ADMINISTRATEUR', 'description' => 'Gestion complète de la plateforme'],
            ['libelle' => 'CONSULTATION', 'description' => 'Accès en lecture seule aux informations'],
            ['libelle' => 'CHARGE BANCASSURANCE', 'description' => 'Responsable des opérations de bancassurance'],
            ['libelle' => 'CHEF AGENCE', 'description' => 'Superviseur des activités en agence'],
            ['libelle' => 'TECHNIQUE', 'description' => 'Support technique et maintenance']
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(['libelle' => $roleData['libelle']], $roleData);
        }
    }
}
