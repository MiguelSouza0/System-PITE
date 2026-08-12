<?php

namespace Database\Seeders;

use App\Models\Perfil;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $perfilPrefeito = Perfil::where('slug', 'prefeito')->first();
        $perfilSecretario = Perfil::where('slug', 'secretario')->first();
        $perfilServidor = Perfil::where('slug', 'servidor')->first();

        User::updateOrCreate(
            ['email' => 'prefeito@municipio.gov.br'],
            [
                'name' => 'Prefeito Municipal',
                'password' => Hash::make('SenhaPITE2026!'),
                'perfil_id' => $perfilPrefeito?->id,
                'ativo' => true
            ]
        );

        User::updateOrCreate(
            ['email' => 'secretario.turismo@municipio.gov.br'],
            [
                'name' => 'Secretário de Turismo',
                'password' => Hash::make('SenhaPITE2026!'),
                'perfil_id' => $perfilSecretario?->id,
                'ativo' => true
            ]
        );

        User::updateOrCreate(
            ['email' => 'tecnico.turismo@municipio.gov.br'],
            [
                'name' => 'Servidor Técnico',
                'password' => Hash::make('SenhaPITE2026!'),
                'perfil_id' => $perfilServidor?->id,
                'ativo' => true
            ]
        );
    }
}
