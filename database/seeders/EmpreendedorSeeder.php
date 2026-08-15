<?php

namespace Database\Seeders;

use App\Models\Empreendedor;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmpreendedorSeeder extends Seeder
{
    public function run(): void
    {
        $userServidor = User::where('email', 'tecnico.turismo@municipio.gov.br')->first() ?? User::first();
        $userEmpreendedor = User::where('email', 'empreendedor@negocio.com')->first() ?? $userServidor;

        $empreendedores = [
            [
                'cnpj_cpf' => '08.765.432/0001-10',
                'razao_social' => 'Mangai Gastronomia Paraibana LTDA',
                'nome_fantasia' => 'Restaurante Mangai Manaíra',
                'tipo_servico' => 'gastronomia',
                'descricao' => 'Referência nacional em culinária nordestina autêntica, bufê com carne de sol na nata, baião de dois, queijo coalho e doces tradicionais.',
                'endereco' => 'Av. Edson Ramalho, 696',
                'bairro' => 'Manaíra',
                'telefone' => '(83) 3246-8600',
                'email' => 'contato@mangai.com.br',
                'instagram' => '@mangairestaurante',
                'status_aprovacao' => 'aprovado',
                'selo_validado' => true,
            ],
            [
                'cnpj_cpf' => '14.234.567/0001-88',
                'razao_social' => 'Nau Frutos do Mar LTDA',
                'nome_fantasia' => 'Restaurante Nau Frutos do Mar',
                'tipo_servico' => 'gastronomia',
                'descricao' => 'Alta gastronomia de frutos do mar com camarões, lagostas e peixes frescos da costa paraibana em ambiente de arquitetura premiada.',
                'endereco' => 'Rua Lupércio Branco, 130',
                'bairro' => 'Manaíra',
                'telefone' => '(83) 3247-1588',
                'email' => 'joaopessoa@naufrutosdomar.com.br',
                'instagram' => '@naurestaurante',
                'status_aprovacao' => 'aprovado',
                'selo_validado' => true,
            ],
            [
                'cnpj_cpf' => '22.333.444/0001-99',
                'razao_social' => 'Bar do Cuscuz & Sabores LTDA',
                'nome_fantasia' => 'Bar do Cuscuz Orla de Cabo Branco',
                'tipo_servico' => 'gastronomia',
                'descricao' => 'Ponto de encontro à beira-mar com cuscuz recheado, petiscos paraibanos, música ao vivo e chopp gelado.',
                'endereco' => 'Av. Cabo Branco, 3056',
                'bairro' => 'Cabo Branco',
                'telefone' => '(83) 3247-4560',
                'email' => 'contato@bardocuscuz.com.br',
                'instagram' => '@bardocuscuzoficial',
                'status_aprovacao' => 'aprovado',
                'selo_validado' => true,
            ],
            [
                'cnpj_cpf' => '05.444.333/0001-22',
                'razao_social' => 'Pousada Tambaú Praia LTDA',
                'nome_fantasia' => 'Pousada Tambaú Praia',
                'tipo_servico' => 'hospedagem',
                'descricao' => 'Hospedagem aconchegante a 150m da praia de Tambaú, com café da manhã regional, quartos acessíveis e selo de sustentabilidade.',
                'endereco' => 'Rua Nego, 400',
                'bairro' => 'Tambaú',
                'telefone' => '(83) 3226-7890',
                'email' => 'reservas@tambaupraia.com.br',
                'instagram' => '@pousadatambaupraia',
                'status_aprovacao' => 'aprovado',
                'selo_validado' => true,
            ],
            [
                'cnpj_cpf' => '30.123.456/0001-55',
                'razao_social' => 'Oceana Resort & Hotelaria LTDA',
                'nome_fantasia' => 'Hotel Oceana Atlântico',
                'tipo_servico' => 'hospedagem',
                'descricao' => 'Resort urbano à beira-mar no Bessa com piscinas infinitas, spa, alta gastronomia e práticas ecológicas de energia solar e reuso de água.',
                'endereco' => 'Av. Gov. Argemiro de Figueiredo, 2100',
                'bairro' => 'Bessa',
                'telefone' => '(83) 2106-9000',
                'email' => 'contato@oceanahotel.com.br',
                'instagram' => '@oceanahotelofficial',
                'status_aprovacao' => 'aprovado',
                'selo_validado' => true,
            ],
            [
                'cnpj_cpf' => '11.888.999/0001-44',
                'razao_social' => 'Ateliê do Labirinto & Rendas da Paraíba',
                'nome_fantasia' => 'Rendas & Algodão Colorido do MAP',
                'tipo_servico' => 'artesanato',
                'descricao' => 'Produção e venda de rendas tradicionais de labirinto, renascença e peças confeccionadas com o legítimo algodão colorido da Paraíba.',
                'endereco' => 'Av. Sen. Ruy Carneiro, 241 - Box 32',
                'bairro' => 'Tambaú',
                'telefone' => '(83) 98877-6655',
                'email' => 'rendas.paraiba@artesanato.com',
                'instagram' => '@rendasdolabirinto_pb',
                'status_aprovacao' => 'aprovado',
                'selo_validado' => true,
            ],
            [
                'cnpj_cpf' => '19.777.666/0001-33',
                'razao_social' => 'Catamarãs do Seixas & Ecoturismo Marinho',
                'nome_fantasia' => 'Passeios Náuticos Piscinas do Seixas',
                'tipo_servico' => 'experiencia',
                'descricao' => 'Passeios de catamarã para as piscinas naturais do Seixas com guias de biologia marinha, máscara de snorkel inclusa e segurança certificada pela Marinha.',
                'endereco' => 'Praia do Seixas - Píer Principal',
                'bairro' => 'Praia do Seixas',
                'telefone' => '(83) 99988-1122',
                'email' => 'passeios@catamarasseixas.com.br',
                'instagram' => '@catamarasseixas',
                'status_aprovacao' => 'aprovado',
                'selo_validado' => true,
            ],
            [
                'cnpj_cpf' => '25.999.000/0001-77',
                'razao_social' => 'Associação dos Guias de Turismo da Paraíba',
                'nome_fantasia' => 'SINGTUR-PB Guias Credenciados',
                'tipo_servico' => 'guia',
                'descricao' => 'Profissionais bilíngues credenciados pelo Ministério do Turismo e Prefeitura para condução histórica, ecoturismo e passeios personalizados.',
                'endereco' => 'Rua Duque de Caxias, 45',
                'bairro' => 'Centro',
                'telefone' => '(83) 3241-5500',
                'email' => 'guias@singturpb.org.br',
                'instagram' => '@guiasparaiba_singtur',
                'status_aprovacao' => 'aprovado',
                'selo_validado' => true,
            ]
        ];

        foreach ($empreendedores as $emp) {
            Empreendedor::updateOrCreate(
                ['cnpj_cpf' => $emp['cnpj_cpf']],
                array_merge($emp, [
                    'user_id' => $userEmpreendedor->id,
                    'aprovado_por_user_id' => $userServidor->id,
                ])
            );
        }
    }
}
