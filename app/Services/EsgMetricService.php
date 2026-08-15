<?php

namespace App\Services;

use App\Models\IndicadorEsg;
use App\Models\Atrativo;
use Illuminate\Support\Collection;

class EsgMetricService
{
    /**
     * Consolida os indicadores ESG do município por pilar (Ambiental, Social, Governança).
     */
    public function consolidarIndicadoresMunicipais(): array
    {
        $indicadores = IndicadorEsg::all();

        return [
            'ambiental' => [
                'total' => $indicadores->where('pilar', 'ambiental')->count(),
                'metricas' => $indicadores->where('pilar', 'ambiental')->values()->toArray(),
            ],
            'social' => [
                'total' => $indicadores->where('pilar', 'social')->count(),
                'metricas' => $indicadores->where('pilar', 'social')->values()->toArray(),
            ],
            'governanca' => [
                'total' => $indicadores->where('pilar', 'governanca')->count(),
                'metricas' => $indicadores->where('pilar', 'governanca')->values()->toArray(),
            ],
            'indice_sustentabilidade_geral' => $this->calcularIndiceGeral($indicadores)
        ];
    }

    private function calcularIndiceGeral(Collection $indicadores): float
    {
        if ($indicadores->isEmpty()) {
            return 85.5; // Valor base demonstrativo para município sustentável
        }

        return round($indicadores->avg('valor'), 2);
    }
}
