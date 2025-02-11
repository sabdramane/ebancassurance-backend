<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypePrestation;

class TypePrestationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typePrestations = [
            ['libelle' => 'Décès'],
            ['libelle' => 'Invalidité permanent'],
            ['libelle' => "Perte d'emploi"],
            ['libelle' => 'Ristourne']
        ];

        foreach ($typePrestations as $typePrestationData) {
            TypePrestation::firstOrCreate(['libelle' => $typePrestationData['libelle']], $typePrestationData);
        }
    }
}
