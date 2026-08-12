<?php

namespace Database\Seeders;

use App\Models\Empreendedor;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmpreendedorSeeder extends Seeder
{
    public function run(): void
    {
        $userServidor = User::where('email', 'tecnico.turismo@municipio.gov.br')->first();

        if ($userServidor) {
            Empreendedor::updateOrCreate(
                ['cnpj_cpf' => '12.345.678/0001-90'],
                [
                    'user_id' => $userServidor->id,
                    'razao_social' => 'Pousada Recanto das Serras LTDA',
                    'nome_fantasia' => 'Pousada Recanto das Serras',
                    'tipo_servico' => 'Hospedagem & Hotelaria',
                    'descricao' => 'Pousada ecológica com selo verde, café colonial e quartos acessíveis.',
                    'endereco' => 'Estrada das Serras, 500',
                    'bairro' => 'Alto da Serra',
                    'telefone' => '(83) 98888-7777',
                    'email' => 'contato@pousadarecanto.com.br',
                    'status_aprovacao' => 'aprovado',
                    'selo_validado' => true,
                    'vencimento_documentos' => now()->addYear(),
                    'aprovado_por_user_id' => $userServidor->id
                ]
            );
        }
    }
}
