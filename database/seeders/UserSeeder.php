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

        // Turista de demonstração (acesso rápido)
        $perfilTurista = Perfil::where('slug', 'turista')->first();

        User::updateOrCreate(
            ['email' => 'turista@email.com'],
            [
                'name' => 'Maria Silva',
                'password' => Hash::make('SenhaPITE2026!'),
                'perfil_id' => $perfilTurista?->id,
                'ativo' => true,
                'nacionalidade' => 'Brasileira',
                'cep' => '01310-100',
                'cidade_origem' => 'São Paulo',
                'estado_origem' => 'SP',
                'pais_origem' => 'Brasil',
                'possui_conjuge' => true,
                'possui_filhos' => true,
                'quantidade_filhos' => 2,
                'interesses' => ['natureza', 'gastronomia', 'cultural', 'historia', 'familia'],
                'necessidades_especiais' => [],
            ]
        );

        // Empreendedor de demonstração (acesso rápido)
        $perfilEmpreendedor = Perfil::where('slug', 'empreendedor')->first();

        $userEmp = User::updateOrCreate(
            ['email' => 'pousada.recanto@email.com'],
            [
                'name' => 'Carlos Eduardo (Pousada Recanto)',
                'password' => Hash::make('SenhaPITE2026!'),
                'perfil_id' => $perfilEmpreendedor?->id,
                'ativo' => true
            ]
        );

        \App\Models\Empreendedor::updateOrCreate(
            ['user_id' => $userEmp->id],
            [
                'cnpj_cpf' => '12.345.678/0001-90',
                'razao_social' => 'Pousada Recanto das Serras LTDA',
                'nome_fantasia' => 'Pousada Recanto das Serras',
                'tipo_servico' => 'Hospedagem & Hotelaria',
                'descricao' => 'Pousada ecológica com selo verde, café colonial e quartos acessíveis.',
                'endereco' => 'Estrada das Serras, 500',
                'bairro' => 'Alto da Serra',
                'telefone' => '(83) 98888-7777',
                'email' => 'pousada.recanto@email.com',
                'status_aprovacao' => 'aprovado',
                'selo_validado' => true,
                'vencimento_documentos' => now()->addYear(),
            ]
        );
    }
}
