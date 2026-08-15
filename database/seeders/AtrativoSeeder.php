<?php

namespace Database\Seeders;

use App\Models\Atrativo;
use App\Models\Categoria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AtrativoSeeder extends Seeder
{
    public function run(): void
    {
        $catEco = Categoria::where('slug', 'turismo-ecologico-e-de-aventura')->first();
        $catHist = Categoria::where('slug', 'patrimonio-historico-e-cultural')->first();
        $catGastro = Categoria::where('slug', 'gastronomia-local')->first();
        $catHosp = Categoria::where('slug', 'hospedagem-e-hotelaria')->first();

        $atrativos = [
            [
                'nome' => 'Centro Histórico & Igreja Matriz',
                'descricao' => 'Conjunto arquitetônico colonial preservado do século XVIII, com visitas guiadas, feiras de artesanato típico e apresentações culturais semanais.',
                'descricao_curta' => 'Patrimônio histórico cultural com arquitetura colonial e visitas guiadas.',
                'categoria_id' => $catHist?->id ?? 2,
                'latitude' => -22.7394,
                'longitude' => -45.5913,
                'endereco' => 'Praça da Matriz, Centro Histórico',
                'horario_funcionamento' => 'Terça a Domingo, das 08h às 18h',
                'preco_medio' => 0.00,
                'niveis_acessibilidade' => [
                    'cadeirante' => true,
                    'rampas' => true,
                    'banheiro_adaptado' => true,
                    'piso_tatile' => true,
                    'audio_guia' => true
                ],
                'caracteristicas_esg' => [
                    'sustentavel' => true,
                    'coleta_seletiva' => true,
                    'energia_solar' => false
                ],
                'destaque' => true,
                'ativo' => true,
            ],
            [
                'nome' => 'Parque Ecológico das Cachoeiras',
                'descricao' => 'Reserva municipal com 4 quedas d\'água cristalinas, trilhas ecológicas sinalizadas e infraestrutura de pontes acessíveis com baixo impacto ambiental.',
                'descricao_curta' => 'Trilhas na Mata Atlântica com cachoeiras cristalinas e preservação.',
                'categoria_id' => $catEco?->id ?? 1,
                'latitude' => -22.7450,
                'longitude' => -45.5850,
                'endereco' => 'Estrada Ecológica Municipal, Km 4',
                'horario_funcionamento' => 'Todos os dias, das 07h às 17h',
                'preco_medio' => 15.00,
                'niveis_acessibilidade' => [
                    'cadeirante' => true,
                    'rampas' => true,
                    'banheiro_adaptado' => true,
                    'piso_tatile' => false,
                    'audio_guia' => true
                ],
                'caracteristicas_esg' => [
                    'sustentavel' => true,
                    'coleta_seletiva' => true,
                    'energia_solar' => true,
                    'carbono_neutro' => true
                ],
                'destaque' => true,
                'ativo' => true,
            ],
            [
                'nome' => 'Mercado Público Municipal & Feira Gastronômica',
                'descricao' => 'Ponto de encontro dos produtores familiares, queijos artesanais, doces típicos e pratos regionais premiados.',
                'descricao_curta' => 'Culinária regional autêntica e produtos de agricultura familiar.',
                'categoria_id' => $catGastro?->id ?? 3,
                'latitude' => -22.7380,
                'longitude' => -45.5900,
                'endereco' => 'Av. Beira Rio, 120 - Centro',
                'horario_funcionamento' => 'Quarta a Domingo, das 09h às 22h',
                'preco_medio' => 35.00,
                'niveis_acessibilidade' => [
                    'cadeirante' => true,
                    'rampas' => true,
                    'banheiro_adaptado' => true,
                    'piso_tatile' => true,
                    'audio_guia' => false
                ],
                'caracteristicas_esg' => [
                    'sustentavel' => true,
                    'comercio_justo' => true,
                    'reciclagem' => true
                ],
                'destaque' => true,
                'ativo' => true,
            ],
            [
                'nome' => 'Mirante do Alto da Serra',
                'descricao' => 'Vista panorâmica 360 graus de todo o vale municipal, pôr do sol espetacular e passarela panorâmica com piso de vidro de alta segurança.',
                'descricao_curta' => 'Vista panorâmica espetacular do vale com passarela acessível.',
                'categoria_id' => $catEco?->id ?? 1,
                'latitude' => -22.7290,
                'longitude' => -45.6020,
                'endereco' => 'Alto do Mirante, s/n',
                'horario_funcionamento' => 'Diariamente, das 06h às 19h',
                'preco_medio' => 0.00,
                'niveis_acessibilidade' => [
                    'cadeirante' => true,
                    'rampas' => true,
                    'banheiro_adaptado' => true,
                    'piso_tatile' => true,
                    'audio_guia' => true
                ],
                'caracteristicas_esg' => [
                    'sustentavel' => true,
                    'energia_solar' => true
                ],
                'destaque' => true,
                'ativo' => true,
            ],
        ];

        foreach ($atrativos as $data) {
            Atrativo::updateOrCreate(
                ['slug' => Str::slug($data['nome'])],
                $data
            );
        }
    }
}
