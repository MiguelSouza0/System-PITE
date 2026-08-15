<?php

namespace Database\Seeders;

use App\Models\Evento;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        $eventos = [
            [
                'titulo' => 'Festival Municipal de Inverno & Gastronomia',
                'descricao' => 'Grande celebração com feira gastronômica, shows ao vivo, concurso de chefs locais e apresentações folclóricas.',
                'data_inicio' => now()->addDays(5)->setTime(18, 0),
                'data_fim' => now()->addDays(8)->setTime(23, 0),
                'local' => 'Praça da Matriz - Centro',
                'preco_ingresso' => 0.00,
                'organizador' => 'Secretaria Municipal de Turismo',
                'gratuito' => true,
                'ativo' => true
            ],
            [
                'titulo' => 'Circuito de Ecoturismo & Trilha Inclusiva',
                'descricao' => 'Passeio guiado para todas as idades e acessibilidade garantida com interpretes de LIBRAS e guias especializados.',
                'data_inicio' => now()->addDays(12)->setTime(8, 30),
                'data_fim' => now()->addDays(12)->setTime(14, 0),
                'local' => 'Parque Ecológico das Cachoeiras',
                'preco_ingresso' => 0.00,
                'organizador' => 'Secretaria de Meio Ambiente e Turismo',
                'gratuito' => true,
                'ativo' => true
            ],
        ];

        foreach ($eventos as $ev) {
            Evento::updateOrCreate(
                ['slug' => Str::slug($ev['titulo'])],
                $ev
            );
        }
    }
}
