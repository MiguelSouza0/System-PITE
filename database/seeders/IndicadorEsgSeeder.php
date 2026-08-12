<?php

namespace Database\Seeders;

use App\Models\IndicadorEsg;
use Illuminate\Database\Seeder;

class IndicadorEsgSeeder extends Seeder
{
    public function run(): void
    {
        $indicadores = [
            [
                'pilar' => 'ambiental',
                'metrica' => 'Taxa de Reciclagem de Resíduos em Eventos',
                'valor' => 94.50,
                'unidade_medida' => '%',
                'ano_referencia' => 2026,
                'status_auditoria' => 'auditado'
            ],
            [
                'pilar' => 'ambiental',
                'metrica' => 'Uso de Energia Solar em Prédios e Parques Públicos',
                'valor' => 78.00,
                'unidade_medida' => '%',
                'ano_referencia' => 2026,
                'status_auditoria' => 'auditado'
            ],
            [
                'pilar' => 'social',
                'metrica' => 'Atrativos Municipais com Acessibilidade PNE',
                'valor' => 85.00,
                'unidade_medida' => '%',
                'ano_referencia' => 2026,
                'status_auditoria' => 'auditado'
            ],
            [
                'pilar' => 'social',
                'metrica' => 'Empreendedores Locais Beneficiados pela Rede',
                'valor' => 120.00,
                'unidade_medida' => 'famílias',
                'ano_referencia' => 2026,
                'status_auditoria' => 'auditado'
            ],
            [
                'pilar' => 'governanca',
                'metrica' => 'Conformidade com LGPD e Dados Abertos',
                'valor' => 100.00,
                'unidade_medida' => '%',
                'ano_referencia' => 2026,
                'status_auditoria' => 'auditado'
            ],
            [
                'pilar' => 'governanca',
                'metrica' => 'Índice de Transparência e Auditoria de Selos',
                'valor' => 96.00,
                'unidade_medida' => '%',
                'ano_referencia' => 2026,
                'status_auditoria' => 'auditado'
            ],
        ];

        foreach ($indicadores as $ind) {
            IndicadorEsg::updateOrCreate(
                [
                    'pilar' => $ind['pilar'],
                    'metrica' => $ind['metrica'],
                    'ano_referencia' => $ind['ano_referencia']
                ],
                $ind
            );
        }
    }
}
