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
                'titulo' => 'Festival Forró Verão de João Pessoa',
                'descricao' => 'O maior festival gratuito de forró do litoral paraibano, reunindo grandes ícones do forró tradicional, xote, baião e artistas locais na orla da capital.',
                'data_inicio' => now()->addDays(5)->setTime(19, 0),
                'data_fim' => now()->addDays(20)->setTime(02, 0),
                'local' => 'Busto de Tamandaré - Orla de Tambaú / Cabo Branco',
                'preco_ingresso' => 0.00,
                'organizador' => 'Secretaria Municipal de Turismo de João Pessoa',
                'gratuito' => true,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
            ],
            [
                'titulo' => 'Espetáculo do Pôr do Sol com Bolero de Ravel',
                'descricao' => 'Apresentação cultural diária e consagrada do saxofonista Jurandy do Sax ao cair da tarde, acompanhado por feira gastronômica e artesanato regional.',
                'data_inicio' => now()->addDays(2)->setTime(16, 30),
                'data_fim' => now()->addDays(30)->setTime(18, 30),
                'local' => 'Praia do Jacaré - Calçadão Cultural',
                'preco_ingresso' => 0.00,
                'organizador' => 'Associação dos Empreendedores do Jacaré & Sec. Turismo',
                'gratuito' => true,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
            ],
            [
                'titulo' => 'Festa das Neves (Padroeira da Cidade)',
                'descricao' => 'Tradicional celebração histórica e religiosa com mais de quatro séculos de história, shows populares, parque de diversões infantil e gastronomia típica.',
                'data_inicio' => now()->addDays(15)->setTime(17, 0),
                'data_fim' => now()->addDays(22)->setTime(23, 59),
                'local' => 'Parque Solon de Lucena (Lagoa) e Centro Histórico',
                'preco_ingresso' => 0.00,
                'organizador' => 'Prefeitura Municipal de João Pessoa / Arquidiocese da Paraíba',
                'gratuito' => true,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
            ],
            [
                'titulo' => 'Folia de Rua & Desfile das Muriçocas do Miramar',
                'descricao' => 'O maior bloco de arrasto pré-carnavalesco do Brasil, arrastando centenas de milhares de foliões ao som de frevo, axé e maracatu ao longo da Av. Epitácio Pessoa.',
                'data_inicio' => now()->addDays(25)->setTime(20, 0),
                'data_fim' => now()->addDays(26)->setTime(04, 0),
                'local' => 'Avenida Epitácio Pessoa até o Busto de Tamandaré',
                'preco_ingresso' => 0.00,
                'organizador' => 'Associação Folia de Rua & Prefeitura de João Pessoa',
                'gratuito' => true,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
            ],
            [
                'titulo' => 'Salão do Artesanato Paraibano',
                'descricao' => 'Megaexposição oficial do artesanato estadual com rendeiras de labirinto e renascença, escultores em madeira, cerâmica e produtos de algodão colorido.',
                'data_inicio' => now()->addDays(8)->setTime(15, 0),
                'data_fim' => now()->addDays(28)->setTime(22, 0),
                'local' => 'Espaço Cultural José Lins do Rego - Tambauzinho',
                'preco_ingresso' => 0.00,
                'organizador' => 'Governo do Estado da Paraíba & Programa de Artesanato',
                'gratuito' => true,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
            ],
            [
                'titulo' => 'Meia Maratona das Praias de João Pessoa',
                'descricao' => 'Prova esportiva de corrida rústica e inclusiva passando pelas mais belas praias da orla pessoense com percursos de 5km, 10km e 21km.',
                'data_inicio' => now()->addDays(18)->setTime(05, 30),
                'data_fim' => now()->addDays(18)->setTime(10, 30),
                'local' => 'Largada e Chegada no Busto de Tamandaré - Orla',
                'preco_ingresso' => 60.00,
                'organizador' => 'Federação Paraibana de Atletismo & Sec. de Esportes',
                'gratuito' => false,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
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
