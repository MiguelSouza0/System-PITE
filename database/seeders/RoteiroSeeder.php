<?php

namespace Database\Seeders;

use App\Models\Atrativo;
use App\Models\Roteiro;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoteiroSeeder extends Seeder
{
    public function run(): void
    {
        $validador = User::whereHas('perfil', fn($q) => $q->whereIn('slug', ['secretario', 'servidor']))->first() ?? User::first();
        $atrativos = Atrativo::all();

        if ($atrativos->isEmpty()) {
            return;
        }

        $centroHistorico = $atrativos->firstWhere('slug', 'centro-historico-igreja-matriz') ?? $atrativos->first();
        $parqueCachoeiras = $atrativos->firstWhere('slug', 'parque-ecologico-das-cachoeiras') ?? $atrativos->skip(1)->first() ?? $centroHistorico;
        $mercadoPublico = $atrativos->firstWhere('slug', 'mercado-publico-municipal-feira-gastronomica') ?? $atrativos->skip(2)->first() ?? $centroHistorico;
        $miranteSerra = $atrativos->firstWhere('slug', 'mirante-do-alto-da-serra') ?? $atrativos->skip(3)->first() ?? $centroHistorico;

        $roteiros = [
            [
                'titulo' => 'Roteiro Histórico & Cultural do Centro Colonial',
                'slug' => 'roteiro-historico-cultural-centro-colonial',
                'descricao' => 'Caminhada guiada pelo coração histórico do município. Descubra casarios preservados do século XVIII, arte sacra colonial, monumentos e feiras de artesanato com acessibilidade plena.',
                'ponto_partida' => 'Praça da Matriz (Centro Histórico)',
                'ponto_chegada' => 'Mercado Público Municipal',
                'duracao_estimada_horas' => 3,
                'distancia_total_km' => 2.4,
                'nivel_dificuldade' => 'facil',
                'meio_transporte' => 'a_pe',
                'acessivel_pne' => true,
                'faixa_etaria' => 'livre',
                'orcamento_nivel' => 'gratuito',
                'tema' => 'historico',
                'perfil_publico_alvo' => 'cultural',
                'caracteristicas_percurso' => [
                    'relevo' => 'Plano e calçamento regular',
                    'pavimentacao' => 'Piso intertravado e calçadão com piso tátil',
                    'sombreamento' => '80% arborizado com bancos de descanso',
                    'tipo_percurso' => 'Urbano / Histórico'
                ],
                'servicos_disponiveis' => [
                    'pontos_agua' => ['Bebedouro da Matriz', 'Posto de Informações Turísticas'],
                    'banheiros' => ['Banheiro público acessível da Praça', 'Sanitários do Mercado'],
                    'alimentacao' => ['Cafeterias históricas', 'Docerias típicas', 'Bistrôs'],
                    'postos_saude' => ['UBS Centro (Rua do Comércio, 45)'],
                    'apoio_turista' => 'Centro de Atendimento ao Turista (CAT Centro)'
                ],
                'orientacoes_seguranca' => [
                    'vestuario' => 'Roupas leves e calçados confortáveis para caminhada em pedra',
                    'hidratacao' => 'Mantenha garrafa d\'água abastecida nos pontos do trajeto',
                    'sol' => 'Uso de protetor solar e chapéu nas praças abertas',
                    'emergencia' => 'Polícia Militar: 190 | SAMU: 192 | Guarda Municipal: 153',
                    'melhor_horario' => 'Manhã (08h30 às 11h30) ou Tarde (15h às 18h)'
                ],
                'polylines_coordenadas' => [
                    [-22.7394, -45.5913],
                    [-22.7388, -45.5908],
                    [-22.7380, -45.5900]
                ],
                'gerado_por_ia' => false,
                'validado_por_user_id' => $validador?->id,
                'resumo_ia' => 'Roteiro oficial aprovado pela Secretaria Municipal de Turismo com foco em patrimônio imaterial e acessibilidade plena (WCAG 2.2 AA).',
                'ativo' => true,
                'atrativos' => [
                    ['id' => $centroHistorico->id, 'ordem' => 1, 'tempo_estimado' => '1h30', 'observacao' => 'Visita à Igreja Matriz, Museu Sacro e casarios históricos.'],
                    ['id' => $mercadoPublico->id, 'ordem' => 2, 'tempo_estimado' => '1h30', 'observacao' => 'Degustação gastronômica, artesanato típico e compras regionais.']
                ]
            ],
            [
                'titulo' => 'Circuito Ecoturismo das Cachoeiras & Mirante da Serra',
                'slug' => 'circuito-ecoturismo-cachoeiras-mirante-serra',
                'descricao' => 'Uma imersão completa na natureza municipal. Conheça as quatro cachoeiras mais preservadas da região com banho refrescante, trilhas ecológicas sinalizadas e encerramento com o pôr do sol inesquecível no Mirante 360°.',
                'ponto_partida' => 'Portal da Estrada Ecológica Municipal (Km 0)',
                'ponto_chegada' => 'Mirante do Alto da Serra',
                'duracao_estimada_horas' => 6,
                'distancia_total_km' => 14.8,
                'nivel_dificuldade' => 'medio',
                'meio_transporte' => 'carro',
                'acessivel_pne' => false,
                'faixa_etaria' => 'jovens',
                'orcamento_nivel' => 'economico',
                'tema' => 'ecoturismo',
                'perfil_publico_alvo' => 'aventura',
                'caracteristicas_percurso' => [
                    'relevo' => 'Trilhas de terra batida com aclives moderados e pedras',
                    'pavimentacao' => 'Estrada ecológica cascalhada + passarelas de madeira',
                    'sombreamento' => 'Mata Atlântica fechada (90% de sombra na trilha)',
                    'tipo_percurso' => 'Natural / Rural / Ecoturismo'
                ],
                'servicos_disponiveis' => [
                    'pontos_agua' => ['Sede do Parque Ecológico', 'Quiosque do Mirante'],
                    'banheiros' => ['Vestiários e sanitários na entrada do Parque'],
                    'alimentacao' => ['Restaurante de comida caipira e lanchonetes orgânicas'],
                    'postos_saude' => ['Posto de Primeiros Socorros do Parque'],
                    'apoio_turista' => 'Base dos Condutores de Ecoturismo Credenciados'
                ],
                'orientacoes_seguranca' => [
                    'vestuario' => 'Tênis aderente para trilha ou bota, roupa de banho por baixo e repelente',
                    'hidratacao' => 'Levar no mínimo 1,5L de água por pessoa',
                    'sol' => 'Protetor solar biodegradável para proteger as nascentes',
                    'emergencia' => 'Corpo de Bombeiros: 193 | Defesa Civil: 199 | Polícia Ambiental: (83) 3218-5000',
                    'melhor_horario' => 'Início às 08h00 para aproveitar as cachoeiras com sol e chegar ao mirante às 17h00.'
                ],
                'polylines_coordenadas' => [
                    [-22.7450, -45.5850],
                    [-22.7380, -45.5900],
                    [-22.7290, -45.6020]
                ],
                'gerado_por_ia' => false,
                'validado_por_user_id' => $validador?->id,
                'resumo_ia' => 'Roteiro de turismo de natureza com protocolo ESG de baixo impacto e coleta de resíduos zero.',
                'ativo' => true,
                'atrativos' => [
                    ['id' => $parqueCachoeiras->id, 'ordem' => 1, 'tempo_estimado' => '3h30', 'observacao' => 'Trilha das 4 quedas d\'água, banho de cachoeira e visita ao viveiro nativo.'],
                    ['id' => $mercadoPublico->id, 'ordem' => 2, 'tempo_estimado' => '1h30', 'observacao' => 'Almoço caipira típico com ingredientes da agricultura familiar.'],
                    ['id' => $miranteSerra->id, 'ordem' => 3, 'tempo_estimado' => '1h00', 'observacao' => 'Pôr do sol panorâmico 360° na passarela de vidro.'],
                ]
            ],
            [
                'titulo' => 'Circuito Gastronômico & Sabores da Terra',
                'slug' => 'circuito-gastronomico-sabores-da-terra',
                'descricao' => 'Uma viagem sensorial pela culinária típica, quitutes tradicionais, doces caseiros e queijos artesanais produzidos por agricultores locais com certificação de origem.',
                'ponto_partida' => 'Mercado Público Municipal',
                'ponto_chegada' => 'Feira Noturna de Artesanato e Gastronomia',
                'duracao_estimada_horas' => 4,
                'distancia_total_km' => 3.2,
                'nivel_dificuldade' => 'facil',
                'meio_transporte' => 'a_pe',
                'acessivel_pne' => true,
                'faixa_etaria' => 'livre',
                'orcamento_nivel' => 'moderado',
                'tema' => 'gastronomia',
                'perfil_publico_alvo' => 'familia',
                'caracteristicas_percurso' => [
                    'relevo' => 'Plano urbano',
                    'pavimentacao' => 'Asfalto com calçadas rebaixadas e piso tátil',
                    'sombreamento' => 'Ambientes cobertos e bulevares arborizados',
                    'tipo_percurso' => 'Gastronômico / Cultural'
                ],
                'servicos_disponiveis' => [
                    'pontos_agua' => ['Bebedouros nos estabelecimentos e praças'],
                    'banheiros' => ['Banheiros acessíveis em todos os pontos parceiros'],
                    'alimentacao' => ['Restaurantes com selo municipal de qualidade'],
                    'postos_saude' => ['UPA Central 24h'],
                    'apoio_turista' => 'Tenda Gastronômica Municipal'
                ],
                'orientacoes_seguranca' => [
                    'vestuario' => 'Roupas leves e confortáveis',
                    'hidratacao' => 'Beba água entre as degustações',
                    'sol' => 'Proteção solar padrão',
                    'emergencia' => 'Vigilância Sanitária: (83) 3333-1122 | SAMU: 192',
                    'melhor_horario' => 'Início às 11h30 para o almoço ou às 17h30 para o circuito noturno.'
                ],
                'polylines_coordenadas' => [
                    [-22.7380, -45.5900],
                    [-22.7394, -45.5913]
                ],
                'gerado_por_ia' => false,
                'validado_por_user_id' => $validador?->id,
                'resumo_ia' => 'Roteiro com foco em economia criativa local e incentivo à agricultura familiar sustentável.',
                'ativo' => true,
                'atrativos' => [
                    ['id' => $mercadoPublico->id, 'ordem' => 1, 'tempo_estimado' => '2h00', 'observacao' => 'Degustação guiada de queijos, embutidos e pratos de panelada regional.'],
                    ['id' => $centroHistorico->id, 'ordem' => 2, 'tempo_estimado' => '2h00', 'observacao' => 'Cafeteria colonial e compras de doces artesanais e licores típicos.']
                ]
            ],
            [
                'titulo' => 'Roteiro de Fé, Tradições e Igrejas Coloniais',
                'slug' => 'roteiro-fe-tradicoes-igrejas-coloniais',
                'descricao' => 'Caminhada de contemplação e devoção pelas capelas históricas, santuários e cruzeiros centenários que marcam a fundação e a espiritualidade do nosso povo.',
                'ponto_partida' => 'Igreja Matriz Nossa Senhora do Rosário',
                'ponto_chegada' => 'Capela do Alto do Cruzeiro',
                'duracao_estimada_horas' => 3,
                'distancia_total_km' => 1.8,
                'nivel_dificuldade' => 'facil',
                'meio_transporte' => 'a_pe',
                'acessivel_pne' => true,
                'faixa_etaria' => 'melhor_idade',
                'orcamento_nivel' => 'gratuito',
                'tema' => 'religioso',
                'perfil_publico_alvo' => 'cultural',
                'caracteristicas_percurso' => [
                    'relevo' => 'Suave aclive até o cruzeiro com rampas e corrimãos',
                    'pavimentacao' => 'Piso histórico com faixas acessíveis contínuas',
                    'sombreamento' => 'Praças ajardinadas com bancos frondosos',
                    'tipo_percurso' => 'Religioso / Contemplativo'
                ],
                'servicos_disponiveis' => [
                    'pontos_agua' => ['Bebedouro na Sacristia e Casa Paroquial'],
                    'banheiros' => ['Sanitários no Centro Pastoral'],
                    'alimentacao' => ['Casas de chá e lanchonetes tradicionais'],
                    'postos_saude' => ['Posto de Apoio da Cruz Vermelha / UBS'],
                    'apoio_turista' => 'Secretaria Paroquial e Guias da Pastoral do Turismo'
                ],
                'orientacoes_seguranca' => [
                    'vestuario' => 'Traje respeitoso para ambientes religiosos e calçado macio',
                    'hidratacao' => 'Levar água em dias quentes',
                    'sol' => 'Sombrinha ou chapéu para o percurso do cruzeiro',
                    'emergencia' => 'Guarda Municipal: 153 | SAMU: 192',
                    'melhor_horario' => 'Manhãs de Quarta a Domingo (08h30 às 11h30).'
                ],
                'polylines_coordenadas' => [
                    [-22.7394, -45.5913],
                    [-22.7380, -45.5900]
                ],
                'gerado_por_ia' => false,
                'validado_por_user_id' => $validador?->id,
                'resumo_ia' => 'Roteiro de turismo religioso e imaterial com infraestrutura adaptada para idosos e mobilidade reduzida.',
                'ativo' => true,
                'atrativos' => [
                    ['id' => $centroHistorico->id, 'ordem' => 1, 'tempo_estimado' => '2h00', 'observacao' => 'Visita à Nave Central, Altar Barroco e Cripta Histórica.'],
                    ['id' => $mercadoPublico->id, 'ordem' => 2, 'tempo_estimado' => '1h00', 'observacao' => 'Feira de arte sacra, terços artesanais e imagens talhadas em madeira.']
                ]
            ],
            [
                'titulo' => 'Roteiro Express: Cartões-Postais em Meio Dia',
                'slug' => 'roteiro-express-cartoes-postais-meio-dia',
                'descricao' => 'Ideal para quem tem pouco tempo mas não abre mão de conhecer os principais pontos turísticos da cidade com conforto e agilidade.',
                'ponto_partida' => 'Centro Histórico & Matriz',
                'ponto_chegada' => 'Mirante do Alto da Serra',
                'duracao_estimada_horas' => 4,
                'distancia_total_km' => 8.5,
                'nivel_dificuldade' => 'facil',
                'meio_transporte' => 'carro',
                'acessivel_pne' => true,
                'faixa_etaria' => 'livre',
                'orcamento_nivel' => 'moderado',
                'tema' => 'misto',
                'perfil_publico_alvo' => 'familia',
                'caracteristicas_percurso' => [
                    'relevo' => 'Urbano e serra pavimentada',
                    'pavimentacao' => '100% asfaltado com vagas demarcadas',
                    'sombreamento' => 'Locais com estacionamento e áreas cobertas',
                    'tipo_percurso' => 'Panorâmico / Rodoviário'
                ],
                'servicos_disponiveis' => [
                    'pontos_agua' => ['Disponível em todos os 3 atrativos'],
                    'banheiros' => ['Banheiros acessíveis em todos os pontos'],
                    'alimentacao' => ['Restaurantes, quiosques e cafeterias'],
                    'postos_saude' => ['Hospital Regional e UPA'],
                    'apoio_turista' => 'Totens de autoatendimento inteligente'
                ],
                'orientacoes_seguranca' => [
                    'vestuario' => 'Roupas casuais e câmera ou smartphone carregado',
                    'hidratacao' => 'Água mineral disponível nos locais',
                    'sol' => 'Protetor solar e óculos escuros',
                    'emergencia' => 'Polícia Rodoviária: 191 | SAMU: 192',
                    'melhor_horario' => '14h00 às 18h00 para fotos perfeitas na golden hour do Mirante.'
                ],
                'polylines_coordenadas' => [
                    [-22.7394, -45.5913],
                    [-22.7380, -45.5900],
                    [-22.7290, -45.6020]
                ],
                'gerado_por_ia' => false,
                'validado_por_user_id' => $validador?->id,
                'resumo_ia' => 'Roteiro otimizado por algoritmo de menor trajeto conectando as 3 principais atrações municipais.',
                'ativo' => true,
                'atrativos' => [
                    ['id' => $centroHistorico->id, 'ordem' => 1, 'tempo_estimado' => '1h15', 'observacao' => 'Passeio fotográfico no centro histórico e Igreja Matriz.'],
                    ['id' => $mercadoPublico->id, 'ordem' => 2, 'tempo_estimado' => '1h15', 'observacao' => 'Parada gourmet para lanche regional e café especial.'],
                    ['id' => $miranteSerra->id, 'ordem' => 3, 'tempo_estimado' => '1h30', 'observacao' => 'Passarela panorâmica e fotos no deck de vidro ao entardecer.']
                ]
            ],
            [
                'titulo' => 'Grande Travessia Municipal: Fim de Semana Completo',
                'slug' => 'grande-travessia-municipal-fim-de-semana',
                'descricao' => 'A jornada definitiva de 2 dias pelo município: patrimônio cultural no sábado de manhã, gastronomia e artesanato à tarde, noitada gastronômica, e ecoturismo com cachoeiras e mirante no domingo!',
                'ponto_partida' => 'Hotel Fazenda / Pousada Central',
                'ponto_chegada' => 'Mirante do Alto da Serra',
                'duracao_estimada_horas' => 16,
                'distancia_total_km' => 22.0,
                'nivel_dificuldade' => 'medio',
                'meio_transporte' => 'misto',
                'acessivel_pne' => false,
                'faixa_etaria' => 'adultos',
                'orcamento_nivel' => 'premium',
                'tema' => 'misto',
                'perfil_publico_alvo' => 'aventura',
                'caracteristicas_percurso' => [
                    'relevo' => 'Misto (urbano plano + serra e trilha florestal)',
                    'pavimentacao' => 'Asfalto, calçamento histórico e trilha de terra batida',
                    'sombreamento' => 'Alternância entre ambientes urbanos e mata nativa',
                    'tipo_percurso' => 'Circuito Completo 2 Dias'
                ],
                'servicos_disponiveis' => [
                    'pontos_agua' => ['Em todos os atrativos e pousadas parceiras'],
                    'banheiros' => ['Rede completa de sanitários no trajeto'],
                    'alimentacao' => ['Restaurantes credenciados e café colonial'],
                    'postos_saude' => ['Rede municipal de saúde integrada'],
                    'apoio_turista' => 'Linha Direta do Turista via WhatsApp Oficial'
                ],
                'orientacoes_seguranca' => [
                    'vestuario' => 'Traga mochila com troca de roupas, tênis reserva, agasalho leve para a serra e protetor solar',
                    'hidratacao' => 'Mantenha-se constantemente hidratado ao longo dos 2 dias',
                    'sol' => 'Reposição frequente de filtro solar',
                    'emergencia' => 'Defesa Civil: 199 | SAMU: 192 | Polícia: 190 | CAT Municipal: (83) 3333-0000',
                    'melhor_horario' => 'Sábado das 09h às 21h e Domingo das 08h às 18h.'
                ],
                'polylines_coordenadas' => [
                    [-22.7394, -45.5913],
                    [-22.7380, -45.5900],
                    [-22.7450, -45.5850],
                    [-22.7290, -45.6020]
                ],
                'gerado_por_ia' => false,
                'validado_por_user_id' => $validador?->id,
                'resumo_ia' => 'Experiência imersiva integrada validada pelo Conselho Municipal de Turismo e ESG Sustentabilidade.',
                'ativo' => true,
                'atrativos' => [
                    ['id' => $centroHistorico->id, 'ordem' => 1, 'tempo_estimado' => '3h00', 'observacao' => 'Sábado Manhã: Tour histórico completo com guia local.'],
                    ['id' => $mercadoPublico->id, 'ordem' => 2, 'tempo_estimado' => '3h00', 'observacao' => 'Sábado Tarde: Almoço típico e feira de artesanato.'],
                    ['id' => $parqueCachoeiras->id, 'ordem' => 3, 'tempo_estimado' => '5h00', 'observacao' => 'Domingo Manhã: Ecoturismo, banho de cachoeira e trilhas.'],
                    ['id' => $miranteSerra->id, 'ordem' => 4, 'tempo_estimado' => '2h00', 'observacao' => 'Domingo Fim de Tarde: Encerramento no Mirante com vista do vale.']
                ]
            ]
        ];

        foreach ($roteiros as $data) {
            $atrativosData = $data['atrativos'] ?? [];
            unset($data['atrativos']);

            $roteiro = Roteiro::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );

            // Sincronizar tabela pivot
            $syncData = [];
            $ids = [];
            foreach ($atrativosData as $item) {
                $syncData[$item['id']] = [
                    'ordem' => $item['ordem'],
                    'tempo_estimado' => $item['tempo_estimado'],
                    'observacao' => $item['observacao']
                ];
                $ids[] = $item['id'];
            }

            $roteiro->atrativos()->sync($syncData);
            $roteiro->update(['atrativos_ids' => $ids]);
        }
    }
}
