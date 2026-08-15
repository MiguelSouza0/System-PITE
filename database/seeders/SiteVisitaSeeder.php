<?php

namespace Database\Seeders;

use App\Models\SiteVisita;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SiteVisitaSeeder extends Seeder
{
    public function run(): void
    {
        if (SiteVisita::count() > 0) {
            return;
        }

        $urls = [
            '/',
            '/atrativos',
            '/atrativos/1',
            '/atrativos/2',
            '/eventos',
            '/mapa-interativo',
            '/roteiros-inteligentes',
            '/transparencia-esg',
        ];

        $devices = ['mobile', 'mobile', 'desktop', 'desktop', 'desktop', 'tablet'];
        $now = Carbon::now();
        $records = [];

        // Gera 1.250 visitas distribuídas nos últimos 30 dias
        for ($i = 30; $i >= 0; $i--) {
            $data = (clone $now)->subDays($i);
            $qtdDia = rand(35, 75);

            for ($j = 0; $j < $qtdDia; $j++) {
                $ipFicticio = '192.168.' . rand(1, 100) . '.' . rand(1, 250);
                $records[] = [
                    'ip_hash' => hash('sha256', $ipFicticio . $data->toDateString()),
                    'url' => $urls[array_rand($urls)],
                    'metodo' => 'GET',
                    'dispositivo' => $devices[array_rand($devices)],
                    'navegador' => 'Mozilla/5.0 (Standard Browser)',
                    'user_id' => null,
                    'data_visita' => $data->toDateString(),
                    'created_at' => $data->copy()->addMinutes(rand(10, 1400)),
                    'updated_at' => $data->copy()->addMinutes(rand(10, 1400)),
                ];
            }
        }

        // Inserir em lotes de 200
        foreach (array_chunk($records, 200) as $chunk) {
            SiteVisita::insert($chunk);
        }
    }
}
