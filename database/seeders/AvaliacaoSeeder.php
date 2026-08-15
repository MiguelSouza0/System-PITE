<?php

namespace Database\Seeders;

use App\Models\Atrativo;
use App\Models\Avaliacao;
use App\Models\User;
use Illuminate\Database\Seeder;

class AvaliacaoSeeder extends Seeder
{
    public function run(): void
    {
        $atrativos = Atrativo::all();
        $user = User::first();

        if ($atrativos->isEmpty() || !$user) {
            return;
        }

        $comentarios = [
            'Lugar maravilhoso, infraestrutura impecável e atendimento acolhedor.',
            'Excelente experiência para a família, guias muito atenciosos.',
            'Acessibilidade muito boa com rampas e sinalização tátil.',
            'Ponto turístico imperdível na cidade. Vista deslumbrante!',
            'Gastronomia local fantástica nas proximidades. Recomendo muito.',
            'Ótima conservação histórica e ambiental.',
            'Passeio agradável, vale a pena visitar nos finais de semana.'
        ];

        $origens = ['local', 'nacional', 'internacional'];

        // Gerar avaliações distribuídas ao longo dos últimos 12 meses para dados ricos de sazonalidade e fluxo
        foreach ($atrativos as $atrativo) {
            for ($mes = 1; $mes <= 12; $mes++) {
                // Quantidade variando para simular alta e baixa temporada (alta: Jan, Fev, Jun, Jul, Dez)
                $qtdAvaliacoes = in_array($mes, [1, 2, 6, 7, 12]) ? rand(4, 8) : rand(1, 3);

                for ($i = 0; $i < $qtdAvaliacoes; $i++) {
                    $dia = rand(1, 28);
                    $dataVisita = now()->setMonth($mes)->setDay($dia)->subYear(now()->month < $mes ? 1 : 0);

                    Avaliacao::create([
                        'atrativo_id' => $atrativo->id,
                        'user_id' => $user->id,
                        'nota' => rand(4, 5),
                        'comentario' => $comentarios[array_rand($comentarios)],
                        'visitado_em' => $dataVisita,
                        'status_verificacao' => 'verificado',
                        'origem_turista' => $origens[array_rand($origens)],
                        'created_at' => $dataVisita,
                        'updated_at' => $dataVisita,
                    ]);
                }
            }
        }
    }
}
