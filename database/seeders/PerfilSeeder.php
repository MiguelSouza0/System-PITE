<?php

namespace Database\Seeders;

use App\Models\Perfil;
use Illuminate\Database\Seeder;

class PerfilSeeder extends Seeder
{
    public function run(): void
    {
        $perfis = [
            [
                'nome' => 'Prefeito Municipal',
                'slug' => 'prefeito',
                'descricao' => 'Acesso ao Dashboard Executivo de Alto Nível e Indicadores de Impacto Estratégico.',
                'permissoes' => ['dashboard.executivo', 'relatorios.macro', 'audit.view']
            ],
            [
                'nome' => 'Secretário de Turismo',
                'slug' => 'secretario',
                'descricao' => 'Gestão Estratégica Completa, Aprovação de Empreendedores e Gestão ESG.',
                'permissoes' => ['dashboard.secretaria', 'empreendedores.aprovar', 'esg.gerenciar', 'atrativos.gerenciar', 'roteiros.gerenciar']
            ],
            [
                'nome' => 'Servidor Público / TÉCNICO',
                'slug' => 'servidor',
                'descricao' => 'Operação Diária de Cadastros, Validação de Avaliações e Cadastro de Eventos.',
                'permissoes' => ['atrativos.criar', 'atrativos.editar', 'eventos.gerenciar', 'avaliacoes.moderar']
            ],
            [
                'nome' => 'Empreendedor Local',
                'slug' => 'empreendedor',
                'descricao' => 'Acesso ao Painel do Empreendedor para Submissão de Cadastro e Gestão do Estabelecimento.',
                'permissoes' => ['painel.empreendedor', 'estabelecimento.editar', 'eventos.solicitar']
            ],
            [
                'nome' => 'Turista / Cidadão',
                'slug' => 'turista',
                'descricao' => 'Acesso ao Portal Público, Assistente Virtual de IA, Criação de Roteiros e Avaliação.',
                'permissoes' => ['portal.acesso', 'roteiros.personalizar', 'avaliacoes.criar']
            ]
        ];

        foreach ($perfis as $perfil) {
            Perfil::updateOrCreate(['slug' => $perfil['slug']], $perfil);
        }
    }
}
