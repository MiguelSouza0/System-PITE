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
        $userAdmin = User::first();

        $atrativos = Atrativo::pluck('id', 'slug')->toArray();

        $roteiros = [
            [
                'titulo' => 'Rota Histórica & Berço da Paraíba no Centro Colonial',
                'descricao' => 'Uma imersão fascinante pela história da terceira capital mais antiga do Brasil, fundada em 1585. O roteiro percorre o suntuoso conjunto barroco do Centro Cultural São Francisco, a histórica Casa da Pólvora (1710), a arborizada Lagoa Solon de Lucena e culmina com o poético pôr do sol nas margens do Rio Sanhauá a partir do Hotel Globo.',
                'ponto_partida' => 'Parque da Lagoa Solon de Lucena - Centro',
                'ponto_chegada' => 'Terraço Panorâmico do Hotel Globo - Varadouro',
                'duracao_estimada_horas' => 4,
                'distancia_total_km' => 3.8,
                'nivel_dificuldade' => 'facil',
                'meio_transporte' => 'a_pe',
                'acessivel_pne' => true,
                'faixa_etaria' => 'Livre para todas as idades (Família, Estudantes e Idosos)',
                'orcamento_nivel' => 'economico',
                'tema' => 'cultural',
                'caracteristicas_percurso' => [
                    'tipo_piso' => 'Calçadão colonial e ruas de paralelepípedo com passeios acessíveis',
                    'relevo' => 'Leve declive em direção ao Rio Sanhauá',
                    'arborizacao' => 'Alta no Parque da Lagoa e Praça São Francisco',
                    'pontos_interesse' => 4,
                    'clima' => 'Agradável e ensolarado com brisa tropical'
                ],
                'servicos_disponiveis' => [
                    'pontos_agua' => 'Bebedouros públicos na Lagoa e no Centro Cultural',
                    'banheiros' => 'Sanitários acessíveis em todos os atrativos do percurso',
                    'alimentacao' => 'Cafeterias históricas, quiosques da Lagoa e bistrôs na Praça Antenor Navarro',
                    'postos_informacao' => 'Centro de Atendimento ao Turista (CAT) no Hotel Globo',
                    'estacionamento' => 'Vagas públicas demarcadas no entorno da Praça da Matriz'
                ],
                'orientacoes_seguranca' => [
                    'geral' => 'Utilize calçados confortáveis para caminhada em piso histórico e mantenha-se hidratado.',
                    'sol' => 'Recomenda-se uso de protetor solar, óculos escuros e chapéu durante as caminhadas matinais.',
                    'telefones_emergencia' => [
                        'Guarda Municipal / Turística' => '153',
                        'Polícia Militar' => '190',
                        'SAMU' => '192',
                        'Corpo de Bombeiros' => '193',
                        'Defesa Civil' => '199'
                    ]
                ],
                'polylines_coordenadas' => [
                    [-7.1215, -34.8825],
                    [-7.1147, -34.8872],
                    [-7.1120, -34.8860],
                    [-7.1128, -34.8885]
                ],
                'atrativos_slugs' => [
                    'parque-da-lagoa-solon-de-lucena',
                    'centro-cultural-sao-francisco',
                    'casa-da-polvora-centro-cultural',
                    'hotel-globo-praca-antenor-navarro'
                ],
                'perfil_publico_alvo' => 'Amantes de história, arquitetura colonial barroca, fotografia urbana e turismo cultural.',
                'gerado_por_ia' => false,
                'validado_por_user_id' => $userAdmin?->id,
                'resumo_ia' => 'Roteiro histórico clássico com ótima acessibilidade, rica arquitetura sacra e o mais belo pôr do sol fluvial de João Pessoa.',
                'ativo' => true
            ],
            [
                'titulo' => 'Circuito das Praias Urbanas & Ponto Mais Oriental das Américas',
                'descricao' => 'Um percurso revigorante ao longo do litoral pessoense, onde o sol nasce primeiro nas Américas continentais. O itinerário passa pelo agito da orla de Tambaú, as falésias de Cabo Branco, o imponente complexo arquitetônico da Estação Cabo Branco assinado por Oscar Niemeyer e o mirante do Farol do Cabo Branco na Ponta do Seixas.',
                'ponto_partida' => 'Feirinha de Artesanato e Busto de Tamandaré - Tambaú',
                'ponto_chegada' => 'Farol do Cabo Branco - Falésias da Ponta do Seixas',
                'duracao_estimada_horas' => 5,
                'distancia_total_km' => 7.2,
                'nivel_dificuldade' => 'facil',
                'meio_transporte' => 'bicicleta',
                'acessivel_pne' => true,
                'faixa_etaria' => 'Livre (Jovens, Adultos e Cicloturistas)',
                'orcamento_nivel' => 'economico',
                'tema' => 'ecoturismo',
                'caracteristicas_percurso' => [
                    'tipo_piso' => 'Ciclovia pavimentada à beira-mar e asfalto com acostamento largo',
                    'relevo' => 'Plano na orla com subida suave para o Altiplano Cabo Branco',
                    'arborizacao' => 'Coqueirais e vegetação de restinga costeira',
                    'pontos_interesse' => 4,
                    'clima' => 'Brisa marinha constante e sol abundante'
                ],
                'servicos_disponiveis' => [
                    'pontos_agua' => 'Quiosques com água de coco natural e postos de hidratação na orla',
                    'banheiros' => 'Quiosques municipais e banheiros acessíveis na Estação Cabo Branco',
                    'alimentacao' => 'Restaurantes de frutos do mar, quiosques da orla e tapiocas em Tambaú',
                    'postos_informacao' => 'CAT Busto de Tamandaré e recepção da Estação Cabo Branco',
                    'estacionamento' => 'Estacionamento amplo gratuito na Estação Cabo Branco e orla'
                ],
                'orientacoes_seguranca' => [
                    'geral' => 'Respeite a faixa de ciclistas e pedestres. Na praia, atente-se às bandeiras de banho dos Bombeiros.',
                    'sol' => 'Hidratação constante com água de coco e uso de protetor solar FPS 50+.',
                    'telefones_emergencia' => [
                        'Guarda Turística' => '153',
                        'Polícia Turística (CEATUR)' => '(83) 3214-8020',
                        'Salva-Vidas (Bombeiros)' => '193',
                        'SAMU' => '192'
                    ]
                ],
                'polylines_coordenadas' => [
                    [-7.1158, -34.8239],
                    [-7.1350, -34.8190],
                    [-7.1492, -34.7997],
                    [-7.1478, -34.7964]
                ],
                'atrativos_slugs' => [
                    'praia-de-tambau-feirinha-de-artesanato',
                    'praia-do-cabo-branco-calcadao-ecologico',
                    'estacao-cabo-branco-ciencia-cultura-e-artes',
                    'farol-do-cabo-branco-ponta-do-seixas'
                ],
                'perfil_publico_alvo' => 'Cicloturistas, apreciadores da natureza litorânea, turistas em busca do ponto extremo oriental.',
                'gerado_por_ia' => false,
                'validado_por_user_id' => $userAdmin?->id,
                'resumo_ia' => 'Trajeto costeiro panorâmico com ciclovia contínua, ciência e a emoção de visitar o ponto mais a leste de todo o continente americano.',
                'ativo' => true
            ],
            [
                'titulo' => 'Rota Gastronômica dos Sabores Paraibanos & Artesanato do MAP',
                'descricao' => 'Uma viagem sensorial inigualável pela premiada culinária regional paraibana e pela tradição centenária do artesanato têxtil. O roteiro inclui visita guiada aos mais de 150 boxes do Mercado de Artesanato Paraibano (MAP), degustação de pratos típicos como carne de sol na nata, rubacão e queijo de coalho, e compras de peças legítimas em algodão colorido.',
                'ponto_partida' => 'Mercado de Artesanato Paraibano (MAP) - Tambaú',
                'ponto_chegada' => 'Feirinha de Tambaú e Orla Gastronômica',
                'duracao_estimada_horas' => 3,
                'distancia_total_km' => 2.1,
                'nivel_dificuldade' => 'facil',
                'meio_transporte' => 'a_pe',
                'acessivel_pne' => true,
                'faixa_etaria' => 'Todas as idades',
                'orcamento_nivel' => 'moderado',
                'tema' => 'gastronomia',
                'caracteristicas_percurso' => [
                    'tipo_piso' => 'Calçadas largas e planas com piso tátil e rampas',
                    'relevo' => 'Completamente plano',
                    'arborizacao' => 'Áreas climatizadas e calçadões com sombra',
                    'pontos_interesse' => 2,
                    'clima' => 'Agradável'
                ],
                'servicos_disponiveis' => [
                    'pontos_agua' => 'Disponível nos centros comerciais e restaurantes',
                    'banheiros' => 'Sanitários climatizados e adaptados para PNE no MAP',
                    'alimentacao' => 'Restaurantes premiados de culinária nordestina e quiosques',
                    'postos_informacao' => 'Balcão de informações turísticas no MAP',
                    'estacionamento' => 'Vagas rotativas e privativas'
                ],
                'orientacoes_seguranca' => [
                    'geral' => 'Compre apenas artesanato com o Selo de Autenticidade Paraibana para valorizar as rendeiras locais.',
                    'telefones_emergencia' => [
                        'Polícia Militar' => '190',
                        'SAMU' => '192',
                        'Procon Municipal' => '151'
                    ]
                ],
                'polylines_coordenadas' => [
                    [-7.1165, -34.8290],
                    [-7.1158, -34.8239]
                ],
                'atrativos_slugs' => [
                    'mercado-de-artesanato-paraibano-map',
                    'praia-de-tambau-feirinha-de-artesanato'
                ],
                'perfil_publico_alvo' => 'Apreciadores da boa mesa nordestina, compradores de artesanato e turistas culturais.',
                'gerado_por_ia' => false,
                'validado_por_user_id' => $userAdmin?->id,
                'resumo_ia' => 'Excelente para tardes e noites, combinando alta gastronomia regional e produtos sustentáveis de algodão colorido.',
                'ativo' => true
            ],
            [
                'titulo' => 'Ecoturismo Marinho & Piscinas Naturais do Seixas e Caribessa',
                'descricao' => 'Uma experiência de conexão pura com a rica biodiversidade marinha e costeira de João Pessoa. O roteiro leva o visitante para as piscinas de corais do Seixas através de catamarãs ecológicos e para as águas límpidas e calmas do Caribessa, com caiaque e observação de tartarugas marinhas.',
                'ponto_partida' => 'Praia do Bessa (Caribessa)',
                'ponto_chegada' => 'Piscinas Naturais do Seixas',
                'duracao_estimada_horas' => 6,
                'distancia_total_km' => 12.5,
                'nivel_dificuldade' => 'medio',
                'meio_transporte' => 'carro',
                'acessivel_pne' => false,
                'faixa_etaria' => 'Adultos, Jovens e Crianças acompanhadas',
                'orcamento_nivel' => 'moderado',
                'tema' => 'aventura',
                'caracteristicas_percurso' => [
                    'tipo_piso' => 'Areia da praia, decks de embarque e navegação costeira',
                    'relevo' => 'Nível do mar',
                    'arborizacao' => 'Ambiente praiano com sol pleno',
                    'pontos_interesse' => 2,
                    'clima' => 'Tropical úmido com água do mar a 28°C'
                ],
                'servicos_disponiveis' => [
                    'pontos_agua' => 'Água mineral a bordo das embarcações credenciadas',
                    'banheiros' => 'Disponíveis nos pontos de apoio em terra firme',
                    'alimentacao' => 'Barracas de praia sustentáveis com peixe frito e frutos do mar',
                    'postos_informacao' => 'Operadoras náuticas credenciadas pela Capitania dos Portos',
                    'estacionamento' => 'Estacionamento de apoio na Praia do Seixas e Bessa'
                ],
                'orientacoes_seguranca' => [
                    'geral' => 'Consulte a tábua de marés com antecedência (maré inferior a 0.5m é ideal). Uso de colete salva-vidas obrigatório durante a travessia de catamarã.',
                    'meio_ambiente' => 'Proibido tocar ou pisar nos corais vivos. Utilize protetor solar biodegradável.',
                    'telefones_emergencia' => [
                        'Capitania dos Portos da Paraíba' => '(83) 3241-2805',
                        'Corpo de Bombeiros / Salvamento Marítimo' => '193',
                        'SAMU' => '192'
                    ]
                ],
                'polylines_coordenadas' => [
                    [-7.0680, -34.8340],
                    [-7.1610, -34.7930]
                ],
                'atrativos_slugs' => [
                    'praia-do-bessa-piscinas-do-caribessa',
                    'piscinas-naturais-do-seixas'
                ],
                'perfil_publico_alvo' => 'Praticantes de esportes náuticos, mergulho livre (snorkel) e amantes de vida marinha.',
                'gerado_por_ia' => false,
                'validado_por_user_id' => $userAdmin?->id,
                'resumo_ia' => 'Roteiro náutico e marinho de grande beleza cênica, ideal para os dias de maré seca matinal.',
                'ativo' => true
            ],
            [
                'titulo' => 'Roteiro Familiar & Verde: Parques Urbanos, Bica e Lagoa',
                'descricao' => 'Um itinerário encantador pensado especialmente para famílias com crianças e idosos. O percurso desfruta das sombras acolhedoras da Mata Atlântica no Parque Zoobotânico Arruda Câmara (A Bica), com pedalinhos e fontes históricas, seguindo para o Parque da Lagoa e encerrando na Estação Cabo Branco com oficinas infantis e planetário.',
                'ponto_partida' => 'Parque Zoobotânico Arruda Câmara (A Bica) - Roger',
                'ponto_chegada' => 'Estação Cabo Branco Ciência, Cultura e Artes',
                'duracao_estimada_horas' => 5,
                'distancia_total_km' => 9.5,
                'nivel_dificuldade' => 'facil',
                'meio_transporte' => 'carro',
                'acessivel_pne' => true,
                'faixa_etaria' => 'Família com crianças e terceira idade',
                'orcamento_nivel' => 'economico',
                'tema' => 'familia',
                'caracteristicas_percurso' => [
                    'tipo_piso' => 'Alamedas pavimentadas, calçadões planos e rampas de acesso',
                    'relevo' => 'Suave e totalmente acessível para carrinhos de bebê e cadeiras de rodas',
                    'arborizacao' => 'Excepcional na Bica e na Lagoa',
                    'pontos_interesse' => 3,
                    'clima' => 'Sombra fresca e agradável'
                ],
                'servicos_disponiveis' => [
                    'pontos_agua' => 'Bebedouros infantis e quiosques em todos os parques',
                    'banheiros' => 'Fraldários e sanitários adaptados com acessibilidade universal',
                    'alimentacao' => 'Lanchonetes saudáveis, sorveterias e praça de alimentação',
                    'postos_informacao' => 'Guichês de atendimento ao visitante na Bica e na Estação',
                    'estacionamento' => 'Estacionamento interno e vigiado'
                ],
                'orientacoes_seguranca' => [
                    'geral' => 'Mantenha as crianças identificadas com pulseira e hidrate os pequenos com frequência.',
                    'telefones_emergencia' => [
                        'Guarda Municipal / Ronda dos Parques' => '153',
                        'SAMU' => '192',
                        'Corpo de Bombeiros' => '193'
                    ]
                ],
                'polylines_coordenadas' => [
                    [-7.1235, -34.8778],
                    [-7.1215, -34.8825],
                    [-7.1492, -34.7997]
                ],
                'atrativos_slugs' => [
                    'parque-zoobotanico-arruda-camara-a-bica',
                    'parque-da-lagoa-solon-de-lucena',
                    'estacao-cabo-branco-ciencia-cultura-e-artes'
                ],
                'perfil_publico_alvo' => 'Famílias com crianças pequenas, idosos e grupos escolares.',
                'gerado_por_ia' => false,
                'validado_por_user_id' => $userAdmin?->id,
                'resumo_ia' => 'Roteiro educativo, seguro e relaxante com contato com a natureza e ciência lúdica para todas as idades.',
                'ativo' => true
            ],
            [
                'titulo' => 'Circuito da Fé, Barroco e Tradições Sacras',
                'descricao' => 'Um roteiro contemplativo de espiritualidade e riqueza histórica através dos mais preservados templos católicos e conventos barrocos de João Pessoa, que testemunharam a evangelização do Nordeste desde o fim do século XVI.',
                'ponto_partida' => 'Igreja de São Francisco (Centro Cultural)',
                'ponto_chegada' => 'Igreja de São Frei Pedro Gonçalves e Hotel Globo',
                'duracao_estimada_horas' => 3,
                'distancia_total_km' => 1.8,
                'nivel_dificuldade' => 'facil',
                'meio_transporte' => 'a_pe',
                'acessivel_pne' => true,
                'faixa_etaria' => 'Livre (Turismo Religioso e Cultural)',
                'orcamento_nivel' => 'gratuito',
                'tema' => 'religioso',
                'caracteristicas_percurso' => [
                    'tipo_piso' => 'Calçamento histórico preservado com rampas laterais',
                    'relevo' => 'Plano no platô histórico',
                    'arborizacao' => 'Praças ajardinadas',
                    'pontos_interesse' => 2,
                    'clima' => 'Silencioso e acolhedor'
                ],
                'servicos_disponiveis' => [
                    'pontos_agua' => 'Disponível nas recepções e sacristias',
                    'banheiros' => 'Sanitários limpos e adaptados',
                    'alimentacao' => 'Cafés e lanchonetes nas proximidades',
                    'postos_informacao' => 'Guias monitores voluntários e credenciados',
                    'estacionamento' => 'Vagas públicas nas imediações'
                ],
                'orientacoes_seguranca' => [
                    'geral' => 'Respeite os momentos de celebração religiosa e as regras de fotografia sem flash no interior dos templos históricos.',
                    'telefones_emergencia' => [
                        'Guarda Municipal' => '153',
                        'Polícia Militar' => '190'
                    ]
                ],
                'polylines_coordenadas' => [
                    [-7.1147, -34.8872],
                    [-7.1128, -34.8885]
                ],
                'atrativos_slugs' => [
                    'centro-cultural-sao-francisco',
                    'hotel-globo-praca-antenor-navarro'
                ],
                'perfil_publico_alvo' => 'Turistas religiosos, pesquisadores de arte sacra e famílias.',
                'gerado_por_ia' => false,
                'validado_por_user_id' => $userAdmin?->id,
                'resumo_ia' => 'Roteiro de contemplação e devoção pelo mais rico patrimônio sacro do Nordeste brasileiro.',
                'ativo' => true
            ]
        ];

        foreach ($roteiros as $rotData) {
            $slugsAtrativos = $rotData['atrativos_slugs'] ?? [];
            unset($rotData['atrativos_slugs']);

            $roteiro = Roteiro::updateOrCreate(
                ['slug' => Str::slug($rotData['titulo'])],
                $rotData
            );

            // Sincronizar atrativos no relacionamento Many-to-Many com ordem e tempos
            $syncData = [];
            $ordem = 1;
            foreach ($slugsAtrativos as $slugAtr) {
                if (isset($atrativos[$slugAtr])) {
                    $syncData[$atrativos[$slugAtr]] = [
                        'ordem' => $ordem,
                        'tempo_estimado' => 45 + ($ordem * 10),
                        'observacao' => 'Parada recomendada para visitação completa e fotos.'
                    ];
                    $ordem++;
                }
            }

            if (!empty($syncData)) {
                $roteiro->atrativos()->sync($syncData);
            }
        }
    }
}
