<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nome' => 'Turismo Ecológico e de Aventura', 'icone' => 'bi-tree', 'descricao' => 'Trilhas, cachoeiras, parques naturais e atividades ao ar livre.'],
            ['nome' => 'Patrimônio Histórico e Cultural', 'icone' => 'bi-bank', 'descricao' => 'Museus, igrejas históricas, monumentos e centro histórico.'],
            ['nome' => 'Gastronomia Local', 'icone' => 'bi-egg-fried', 'descricao' => 'Restaurantes de culinária típica, feiras artesanais e bistrôs.'],
            ['nome' => 'Hospedagem e Hotelaria', 'icone' => 'bi-house-heart', 'descricao' => 'Hotéis, pousadas de charme, resorts e hospedagens rurais.'],
            ['nome' => 'Eventos e Festividades', 'icone' => 'bi-calendar-event', 'descricao' => 'Festas tradicionais, festivais culturais e feiras municipais.'],
            ['nome' => 'Artesanato e Comércio Local', 'icone' => 'bi-shop', 'descricao' => 'Mercados de artesanato, ateliês e produtores locais.']
        ];

        foreach ($categorias as $cat) {
            Categoria::updateOrCreate(
                ['slug' => Str::slug($cat['nome'])],
                [
                    'nome' => $cat['nome'],
                    'icone' => $cat['icone'],
                    'descricao' => $cat['descricao'],
                    'ativo' => true
                ]
            );
        }
    }
}
