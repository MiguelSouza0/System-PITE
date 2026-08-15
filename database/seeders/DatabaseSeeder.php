<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PerfilSeeder::class,
            CategoriaSeeder::class,
            UserSeeder::class,
            AtrativoSeeder::class,
            EventoSeeder::class,
            IndicadorEsgSeeder::class,
            EmpreendedorSeeder::class,
        ]);
    }
}
