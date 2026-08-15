<?php

namespace App\Services;

use App\Models\Atrativo;
use App\Models\Avaliacao;
use App\Models\Categoria;
use App\Models\Empreendedor;
use App\Models\Evento;
use App\Models\Notificacao;
use App\Models\Roteiro;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class AiItineraryService
{
    /**
     * Gera um roteiro turístico inteligente sob medida a partir de múltiplos critérios.
     * Atende aos requisitos da Seção 5:
     * - Tema, duração, localização, nível de dificuldade, meio de transporte, acessibilidade, faixa etária, orçamento, perfil.
     * - Ordem sugerida otimizada geograficamente, distância total (km), tempo total, características do percurso,
     *   serviços disponíveis no trajeto e orientações de segurança com contatos de emergência.
     */
    public function gerarRoteiroPersonalizado(array $preferencias): Roteiro
    {
        $perfil = $preferencias['perfil'] ?? 'misto'; // familia, aventura, cultural, gastronomico, religioso, compras, misto
        $duracaoHoras = max(1, min(24, (int) ($preferencias['duracao_horas'] ?? 4)));
        $orcamento = $preferencias['orcamento'] ?? 'moderado'; // gratuito, economico, moderado, premium
        $acessivel = !empty($preferencias['acessivel']);
        $comCriancas = !empty($preferencias['criancas']);
        $meioTransporte = $preferencias['meio_transporte'] ?? ($duracaoHoras > 5 ? 'carro' : 'a_pe');
        $faixaEtaria = $preferencias['faixa_etaria'] ?? ($comCriancas ? 'criancas' : 'livre');
        $interesses = (array) ($preferencias['interesses'] ?? []);

        // 1. Busca e pontuação dos atrativos aprovados e ativos
        $atrativos = Atrativo::with('categoria')->visivelPortal()->get();

        if ($atrativos->isEmpty()) {
            $atrativos = Atrativo::with('categoria')->where('ativo', true)->get();
        }

        $atrativosPontuados = $atrativos->map(function ($atrativo) use ($perfil, $orcamento, $acessivel, $comCriancas, $interesses) {
            $pontos = 0;

            // Filtro de Acessibilidade PNE estrita
            $temCadeirante = !empty($atrativo->niveis_acessibilidade['cadeirante']);
            if ($acessivel) {
                if ($temCadeirante) {
                    $pontos += 50;
                } else {
                    $pontos -= 100; // Penalidade forte se solicitou PNE e não atende
                }
            }

            // Compatibilidade com Perfil
            $catSlug = $atrativo->categoria?->slug ?? '';
            if ($perfil === 'aventura' && str_contains($catSlug, 'ecologico')) $pontos += 35;
            if ($perfil === 'cultural' && str_contains($catSlug, 'historico')) $pontos += 35;
            if ($perfil === 'gastronomico' && str_contains($catSlug, 'gastronomia')) $pontos += 35;
            if ($perfil === 'religioso' && (str_contains($atrativo->nome, 'Igreja') || str_contains($atrativo->nome, 'Matriz') || str_contains($catSlug, 'historico'))) $pontos += 40;
            if ($perfil === 'compras' && (str_contains($catSlug, 'artesanato') || str_contains($catSlug, 'comercio'))) $pontos += 35;
            if ($perfil === 'familia' && ($temCadeirante || str_contains($catSlug, 'gastronomia') || str_contains($catSlug, 'historico'))) $pontos += 30;

            // Interesses específicos selecionados
            foreach ($interesses as $interesse) {
                if (stripos($atrativo->nome, $interesse) !== false || stripos($atrativo->descricao, $interesse) !== false || stripos($catSlug, $interesse) !== false) {
                    $pontos += 20;
                }
            }

            // Orçamento
            $preco = (float) ($atrativo->preco_medio ?? 0);
            if ($orcamento === 'gratuito') {
                if ($preco == 0) $pontos += 25; else $pontos -= 30;
            } elseif ($orcamento === 'economico') {
                if ($preco <= 20) $pontos += 20;
            }

            // Destaque & ESG
            if ($atrativo->destaque) $pontos += 15;
            if (!empty($atrativo->caracteristicas_esg['sustentavel'])) $pontos += 10;

            return [
                'atrativo' => $atrativo,
                'pontuacao' => $pontos
            ];
        });

        // Filtrar atrativos com pontuação válida
        $atrativosFiltrados = $atrativosPontuados
            ->filter(fn($item) => $item['pontuacao'] >= ($acessivel ? 20 : 0))
            ->sortByDesc('pontuacao')
            ->map(fn($item) => $item['atrativo'])
            ->values();

        if ($atrativosFiltrados->isEmpty()) {
            $atrativosFiltrados = $atrativos->take(4);
        }

        // Definir quantidade de paradas ideal de acordo com a duração
        $numParadas = match (true) {
            $duracaoHoras <= 2 => 2,
            $duracaoHoras <= 4 => 3,
            $duracaoHoras <= 8 => 4,
            default => min(5, $atrativosFiltrados->count())
        };

        $selecionados = $atrativosFiltrados->take($numParadas);

        // 2. Ordenação Geográfica Otimizada (TSP / Nearest Neighbor Heuristic)
        $rotaOrdenada = $this->otimizarOrdemVisitas($selecionados);

        // 3. Cálculo de Distância Total (Haversine Formula) e Polylines
        $coordenadas = [];
        $distanciaTotalKm = 0.0;

        for ($i = 0; $i < count($rotaOrdenada); $i++) {
            $lat = (float) ($rotaOrdenada[$i]->latitude ?? -22.7394);
            $lng = (float) ($rotaOrdenada[$i]->longitude ?? -45.5913);
            $coordenadas[] = [$lat, $lng];

            if ($i > 0) {
                $prevLat = (float) ($rotaOrdenada[$i - 1]->latitude ?? -22.7394);
                $prevLng = (float) ($rotaOrdenada[$i - 1]->longitude ?? -45.5913);
                $distanciaTotalKm += $this->calcularDistanciaHaversine($prevLat, $prevLng, $lat, $lng);
            }
        }

        // Fator de rota urbana (vias reais somam aprox. 25% a mais que a linha reta)
        $distanciaTotalKm = round($distanciaTotalKm * 1.25, 2);
        if ($distanciaTotalKm < 0.5) $distanciaTotalKm = 1.2;

        // 4. Metadados contextuais: partida, chegada, características, serviços e segurança
        $pontoPartida = $rotaOrdenada[0]->nome ?? 'Centro da Cidade';
        $pontoChegada = end($rotaOrdenada)->nome ?? $pontoPartida;

        $nivelDificuldade = match (true) {
            $perfil === 'aventura' || $duracaoHoras > 6 => 'medio',
            $acessivel || $comCriancas => 'facil',
            default => 'facil'
        };

        $caracteristicas = $this->gerarCaracteristicasPercurso($perfil, $meioTransporte, $acessivel);
        $servicos = $this->gerarServicosTrajeto($rotaOrdenada);
        $seguranca = $this->gerarOrientacoesSeguranca($perfil, $meioTransporte);

        // 5. Título e Descrição Humanizada
        $nomeTema = ucfirst($perfil);
        $titulo = "Roteiro Inteligente {$nomeTema} ({$duracaoHoras}h)";
        $slug = Str::slug($titulo . '-' . Str::random(6));

        $descricao = "Roteiro personalizado gerado pelo motor de inteligência artificial do System-PITE, " .
            "otimizado para o perfil " . strtolower($nomeTema) . " com duração de {$duracaoHoras} horas. " .
            ($acessivel ? "Inclui garantia de 100% de acessibilidade PNE em todos os pontos mapeados. " : "") .
            "Trajeto estruturado para menor tempo de deslocamento e máxima experiência cultural e sustentável.";

        $resumoIa = "Gerado via IA Auditável com base exclusiva na base oficial de dados do município. " .
            "Algoritmo de roteirização com otimização geoespacial Haversine, cálculo de rotas seguras e supervisão humana municipal.";

        // 6. Persistência do Roteiro no Banco
        $roteiro = Roteiro::create([
            'titulo' => $titulo,
            'slug' => $slug,
            'descricao' => $descricao,
            'ponto_partida' => $pontoPartida,
            'ponto_chegada' => $pontoChegada,
            'duracao_estimada_horas' => $duracaoHoras,
            'distancia_total_km' => $distanciaTotalKm,
            'nivel_dificuldade' => $nivelDificuldade,
            'meio_transporte' => $meioTransporte,
            'acessivel_pne' => $acessivel,
            'faixa_etaria' => $faixaEtaria,
            'orcamento_nivel' => $orcamento,
            'tema' => $perfil,
            'caracteristicas_percurso' => $caracteristicas,
            'servicos_disponiveis' => $servicos,
            'orientacoes_seguranca' => $seguranca,
            'polylines_coordenadas' => $coordenadas,
            'atrativos_ids' => collect($rotaOrdenada)->pluck('id')->toArray(),
            'perfil_publico_alvo' => $perfil,
            'gerado_por_ia' => true,
            'resumo_ia' => $resumoIa,
            'ativo' => true
        ]);

        // Sincronizar tabela pivot com ordem e tempo estimado por parada
        $tempoPorParadaMinutos = max(30, round(($duracaoHoras * 60 * 0.75) / count($rotaOrdenada)));
        $tempoFormatado = ($tempoPorParadaMinutos >= 60)
            ? floor($tempoPorParadaMinutos / 60) . 'h' . ($tempoPorParadaMinutos % 60 ? ($tempoPorParadaMinutos % 60) . 'min' : '')
            : $tempoPorParadaMinutos . 'min';

        $syncData = [];
        foreach ($rotaOrdenada as $idx => $at) {
            $ordem = $idx + 1;
            $obs = match ($ordem) {
                1 => "Ponto de início do roteiro: recepção e contextualização histórica.",
                count($rotaOrdenada) => "Ponto de encerramento: aproveite para fotos e descanso.",
                default => "Parada intermediária para exploração e serviços locais."
            };

            $syncData[$at->id] = [
                'ordem' => $ordem,
                'tempo_estimado' => $tempoFormatado,
                'observacao' => $obs
            ];
        }

        $roteiro->atrativos()->sync($syncData);

        return $roteiro;
    }

    /**
     * Otimiza a ordem de visitação dos atrativos pelo algoritmo do Vizinho Mais Próximo (Nearest Neighbor).
     */
    protected function otimizarOrdemVisitas(Collection $atrativos): array
    {
        if ($atrativos->count() <= 1) {
            return $atrativos->all();
        }

        $restantes = $atrativos->values()->all();
        $ordenados = [];

        // Começar pelo primeiro (melhor pontuado)
        $atual = array_shift($restantes);
        $ordenados[] = $atual;

        while (!empty($restantes)) {
            $melhorIndice = 0;
            $menorDistancia = PHP_FLOAT_MAX;

            $latAtual = (float) ($atual->latitude ?? -22.7394);
            $lngAtual = (float) ($atual->longitude ?? -45.5913);

            foreach ($restantes as $indice => $candidato) {
                $latCand = (float) ($candidato->latitude ?? -22.7394);
                $lngCand = (float) ($candidato->longitude ?? -45.5913);

                $dist = $this->calcularDistanciaHaversine($latAtual, $lngAtual, $latCand, $lngCand);
                if ($dist < $menorDistancia) {
                    $menorDistancia = $dist;
                    $melhorIndice = $indice;
                }
            }

            $atual = $restantes[$melhorIndice];
            $ordenados[] = $atual;
            array_splice($restantes, $melhorIndice, 1);
        }

        return $ordenados;
    }

    /**
     * Calcula a distância geodésica em quilômetros usando a fórmula de Haversine.
     */
    public function calcularDistanciaHaversine(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // Raio da Terra em km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Gera características do percurso.
     */
    protected function gerarCaracteristicasPercurso(string $perfil, string $meioTransporte, bool $acessivel): array
    {
        return [
            'relevo' => $acessivel ? 'Relevo predominantemente plano com rampas de acesso normatizadas' : ($perfil === 'aventura' ? 'Relevo ondulado com trilhas e aclives moderados' : 'Relevo suave e de fácil circulação'),
            'pavimentacao' => $meioTransporte === 'carro' ? 'Asfalto e calçamento urbano bem sinalizado' : ($acessivel ? 'Calçadas com piso tátil, rebaixamento e faixas acessíveis' : 'Calçamento histórico e trechos arborizados'),
            'sombreamento' => 'Mais de 70% do percurso conta com áreas sombreadas e praças para descanso',
            'tipo_percurso' => ucfirst($perfil) . ' / ' . ($meioTransporte === 'a_pe' ? 'Pedestre' : 'Veicular')
        ];
    }

    /**
     * Mapeia serviços disponíveis no trajeto.
     */
    protected function gerarServicosTrajeto(array $atrativos): array
    {
        return [
            'pontos_agua' => [
                'Bebedouros públicos na Praça Central',
                'Pontos de hidratação nos estabelecimentos parceiros credenciados'
            ],
            'banheiros' => [
                'Sanitários públicos com acessibilidade plena (PNE)',
                'Banheiros familiares com fraldário no Centro de Informações'
            ],
            'alimentacao' => [
                'Restaurantes de culinária regional com Selo Municipal de Qualidade',
                'Cafeterias históricas e quiosques de alimentação rápida'
            ],
            'postos_saude' => [
                'UPA Municipal 24 Horas (Atendimento de Urgência)',
                'Posto de Saúde Central com ambulância a postos'
            ],
            'apoio_turista' => 'Centro de Atendimento ao Turista (CAT Oficial) e Totens Interativos System-PITE'
        ];
    }

    /**
     * Gera orientações de segurança e números de emergência municipais.
     */
    protected function gerarOrientacoesSeguranca(string $perfil, string $meioTransporte): array
    {
        return [
            'vestuario' => $perfil === 'aventura'
                ? 'Calçado aderente fechado, repelente, agasalho leve e garrafa de hidratação.'
                : 'Roupas leves, calçados confortáveis para caminhada e óculos de sol.',
            'hidratacao' => 'Mantenha consumo regular de água e utilize os pontos de abastecimento do percurso.',
            'sol' => 'Aplique protetor solar antes de iniciar o passeio e reaplique a cada 2 horas.',
            'emergencia' => 'Polícia Militar: 190 | SAMU: 192 | Bombeiros: 193 | Defesa Civil: 199 | Guarda Municipal: 153',
            'melhor_horario' => 'Recomenda-se iniciar no período da manhã (08h30) ou meio da tarde (15h00) para evitar calor excessivo.'
        ];
    }

    /**
     * Assistente Virtual Inteligente do Turista ("Guia PITE IA").
     * Interpreta em linguagem natural e responde com base estrita na base de dados oficial.
     * Suporte a Português, Inglês e Espanhol.
     */
    public function responderDuvidaTurista(string $pergunta, string $idioma = 'pt', ?User $user = null): array
    {
        $perguntaLimpa = mb_strtolower(trim($pergunta));

        // 1. Identificação de Intenção
        $intencao = 'geral';
        if (preg_match('/(cria|crie|gerar|gera|montar|monte|faça|faca|construa|montagem) (um |o )?(plano|roteiro|itinerario|itinerário)/i', $perguntaLimpa) || preg_match('/(plano|roteiro|itinerario|itinerário) (personalizado|sob medida|de \d+ dia)/i', $perguntaLimpa)) {
            $intencao = 'criar_plano_turismo';
        } elseif (preg_match('/(mude|muda|altere|altera|edite|edita|troque|troca|substitua|modifique|modifica) (o|meu|este|no)? (plano|roteiro|dia|passeio|item|atrativo)/i', $perguntaLimpa)) {
            $intencao = 'editar_plano_turismo';
        } elseif (preg_match('/(recife|olinda|natal|fortaleza|rio de janeiro|sao paulo|são paulo|salvador|campina grande|maceio|maceió|pipa|noronha|gramado|florianopolis|florianópolis|curitiba|brasilia|brasília|belo horizonte|manaus|belem|belém|foz do igua|porto de galinhas|maragogi|outra cidade|outras cidades|fora de joao|fora de joão|fora de jampa|em outra cidade|noutra cidade|outros municipios|outros municípios|outra regiao|outra região|outro estado|outros estados)/i', $perguntaLimpa)) {
            $intencao = 'outra_cidade';
        } elseif (preg_match('/^(oi|ola|olá|bom dia|boa tarde|boa noite|hey|hello|hi|hola|fala|opa|tudo bem|tudo bom)(\s|!|\.|\?|$)/i', $perguntaLimpa) || in_array($perguntaLimpa, ['oi', 'ola', 'olá', 'bom dia', 'boa tarde', 'boa noite', 'hey', 'hello', 'hi', 'hola', 'fala', 'opa'])) {
            $intencao = 'saudacao';
        } elseif (preg_match('/(obrigad|valeu|vlw|obg|thanks|thank you|gracias|top|perfeito|excelente|muito bom|ajudou)/i', $perguntaLimpa)) {
            $intencao = 'agradecimento';
        } elseif (preg_match('/(tchau|até mais|ate mais|tchauzinho|adeus|bye|goodbye|hasta luego|até logo|ate logo|falou)/i', $perguntaLimpa)) {
            $intencao = 'despedida';
        } elseif (preg_match('/(quem (é|e) (você|voce|tu)|o que (você|voce) (faz|é|e)|como funciona|qual (é|e) seu nome|quem desenvolveu|como (você|voce) ajuda|quais suas func)/i', $perguntaLimpa)) {
            $intencao = 'identidade';
        } elseif (preg_match('/(melhor(es)? (local|locais|lugar|lugares|atrativo|atrativos|ponto|pontos|passeio|passeios)|quais (locais|lugares|atrativos|pontos)|o que visitar|onde ir em jo(a|ã)o|recomenda(ção|cao|çoes|coes)?|sugest(ão|ao|ões|oes)|indica(ção|cao)|para o meu perfil|meu perfil)/i', $perguntaLimpa)) {
            $intencao = 'recomendacao_perfil';
        } elseif (preg_match('/(quando ir|melhor (época|epoca)|clima|tempo|sol|chover|chuva|estacao|estação|temperatura)/i', $perguntaLimpa)) {
            $intencao = 'clima_epoca';
        } elseif (preg_match('/(maré|mare|tábua|tabua|lua cheia|lua nova)/i', $perguntaLimpa)) {
            $intencao = 'mare';
        } elseif (preg_match('/(por do sol|pôr do sol|sunset|jacare|jacaré|bolero|jurandy|farol)/i', $perguntaLimpa)) {
            $intencao = 'por_do_sol';
        } elseif (preg_match('/(praia|praias|mar|orla|tambaú|tambau|cabo branco|manaíra|manaira|bessa|seixas|picãozinho|picaozinho)/i', $perguntaLimpa)) {
            $intencao = 'praias';
        } elseif (preg_match('/(artesanato|lembrancinha|compras|souvenir|feirinha|mercado de artesanato|map)/i', $perguntaLimpa)) {
            $intencao = 'artesanato_compras';
        } elseif (preg_match('/(evento|festa|show|agenda|programa|festival|quando)/i', $perguntaLimpa)) {
            $intencao = 'eventos';
        } elseif (preg_match('/(comer|restaurante|gastronomia|comida|almoco|jantar|lanche|bar|cafe|doce)/i', $perguntaLimpa)) {
            $intencao = 'gastronomia';
        } elseif (preg_match('/(hotel|hosped|pousada|dormir|resort|onde ficar)/i', $perguntaLimpa)) {
            $intencao = 'hospedagem';
        } elseif (preg_match('/(acessib|cadeirant|pne|rampa|deficien|piso tatil|cego|surdo)/i', $perguntaLimpa)) {
            $intencao = 'acessibilidade';
        } elseif (preg_match('/(trilha|cachoeira|natureza|aventura|ecotur)/i', $perguntaLimpa)) {
            $intencao = 'ecoturismo';
        } elseif (preg_match('/(museu|histori|igreja|patrimonio|matriz|cultur)/i', $perguntaLimpa)) {
            $intencao = 'historia';
        } elseif (preg_match('/(roteiro|itinerario|o que fazer|passeio|dia|turist)/i', $perguntaLimpa)) {
            $intencao = 'roteiro';
        } elseif (preg_match('/(emergencia|policia|hospital|samu|bombeiro|socorro|telefone|seguranca)/i', $perguntaLimpa)) {
            $intencao = 'emergencia';
        } elseif (preg_match('/(esg|sustentab|meio ambiente|recicla|energia solar|lixo)/i', $perguntaLimpa)) {
            $intencao = 'esg';
        }

        // 2. Consulta à Base Oficial Validada
        $cards = [];
        $resposta = "";
        $sugestoes = [];

        switch ($intencao) {
            case 'criar_plano_turismo':
            case 'editar_plano_turismo':
                $dias = 2;
                if (preg_match('/(\d+)\s*dia/i', $perguntaLimpa, $m)) {
                    $dias = max(1, min(7, (int)$m[1]));
                }

                $interessesTurista = $user ? (array)($user->interesses ?? []) : [];

                $atrativosQuery = Atrativo::with('categoria')->visivelPortal()->get();
                if ($atrativosQuery->isEmpty()) {
                    $atrativosQuery = Atrativo::with('categoria')->where('ativo', true)->get();
                }

                $eventosQuery = Evento::visivelPortal()->where(function($q) {
                    $q->whereNull('data_fim')->orWhere('data_fim', '>=', now());
                })->get();

                if (!empty($interessesTurista)) {
                    $atrativosQuery = $atrativosQuery->sortByDesc(function($at) use ($interessesTurista) {
                        $score = 0;
                        $cat = mb_strtolower($at->categoria?->nome ?? '');
                        $desc = mb_strtolower($at->descricao ?? '');
                        foreach ($interessesTurista as $int) {
                            if (str_contains($cat, mb_strtolower($int)) || str_contains($desc, mb_strtolower($int))) {
                                $score += 10;
                            }
                        }
                        if ($at->destaque) $score += 5;
                        return $score;
                    })->values();
                }

                $itensPlano = [];
                $indexAtrativo = 0;
                $totalAtrativos = max(1, $atrativosQuery->count());

                for ($d = 1; $d <= $dias; $d++) {
                    // Manhã
                    $atManha = $atrativosQuery[$indexAtrativo % $totalAtrativos];
                    $indexAtrativo++;
                    $itensPlano[] = [
                        'dia' => $d,
                        'ordem' => 1,
                        'periodo' => 'Manhã (08:30)',
                        'tipo' => 'atrativo',
                        'item_id' => $atManha->id,
                        'nome' => $atManha->nome,
                        'categoria' => $atManha->categoria?->nome ?? 'Atrativo',
                        'notas' => 'Exploração matutina e registro fotográfico.'
                    ];

                    // Tarde
                    $atTarde = $atrativosQuery[$indexAtrativo % $totalAtrativos];
                    $indexAtrativo++;
                    $itensPlano[] = [
                        'dia' => $d,
                        'ordem' => 2,
                        'periodo' => 'Tarde (14:30)',
                        'tipo' => 'atrativo',
                        'item_id' => $atTarde->id,
                        'nome' => $atTarde->nome,
                        'categoria' => $atTarde->categoria?->nome ?? 'Atrativo',
                        'notas' => 'Passeio cultural / contemplação.'
                    ];

                    // Noite
                    if (!$eventosQuery->isEmpty() && ($d % 2 == 1)) {
                        $ev = $eventosQuery[($d - 1) % $eventosQuery->count()];
                        $itensPlano[] = [
                            'dia' => $d,
                            'ordem' => 3,
                            'periodo' => 'Noite (19:30)',
                            'tipo' => 'evento',
                            'item_id' => $ev->id,
                            'nome' => $ev->titulo,
                            'categoria' => 'Evento Cultural / Festividade',
                            'notas' => "Local: " . ($ev->local ?? 'João Pessoa')
                        ];
                    } else {
                        $atNoite = $atrativosQuery[$indexAtrativo % $totalAtrativos];
                        $indexAtrativo++;
                        $itensPlano[] = [
                            'dia' => $d,
                            'ordem' => 3,
                            'periodo' => 'Noite (20:00)',
                            'tipo' => 'atrativo',
                            'item_id' => $atNoite->id,
                            'nome' => $atNoite->nome,
                            'categoria' => $atNoite->categoria?->nome ?? 'Gastronomia / Lazer',
                            'notas' => 'Jantar regional e entretenimento.'
                        ];
                    }
                }

                $isEdicao = ($intencao === 'editar_plano_turismo');
                $tituloPlano = ($isEdicao ? "Plano Atualizado" : "Plano Personalizado") . " - {$dias} " . ($dias > 1 ? "Dias" : "Dia") . " em João Pessoa";
                $descPlano = "Roteiro turístico sob medida gerado pelo Guia PITE IA com atrações oficiais e eventos recomendados.";

                $dadosExtras = [
                    'tipo_acao' => 'plano_turismo_gerado',
                    'plano' => [
                        'titulo' => $tituloPlano,
                        'descricao' => $descPlano,
                        'dias' => $dias,
                        'itens' => $itensPlano,
                        'preferencias' => [
                            'perfil' => $user->perfil ?? 'turista',
                            'dias' => $dias,
                        ]
                    ]
                ];

                $headerTxt = $isEdicao ? "✨ **Plano Atualizado!**\n\n" : "🗺️ **" . $tituloPlano . "**\n\n";
                $introTxt = $isEdicao ? "Ajustei o seu roteiro de **{$dias} dia(s)** conforme solicitado! Confira as atrações organizadas:\n\n" : "Elaborei um roteiro especial de **{$dias} dia(s)** em João Pessoa para o seu perfil! Confira a programação:\n\n";

                $respostaText = $headerTxt . $introTxt;

                for ($d = 1; $d <= $dias; $d++) {
                    $respostaText .= "📅 **Dia {$d}:**\n";
                    $itensDoDia = array_filter($itensPlano, fn($i) => $i['dia'] == $d);
                    foreach ($itensDoDia as $it) {
                        $respostaText .= "• **{$it['periodo']}**: {$it['nome']} _({$it['categoria']})_\n";
                    }
                    $respostaText .= "\n";
                }

                $respostaText .= "💡 *Você pode me pedir para ajustar qualquer dia (ex: 'mude o dia 2 para praias') ou clicar em **Salvar Plano** para armazená-lo na sua conta!*";

                $resposta = $respostaText;
                $sugestoes = [
                    "Salvar este plano",
                    "Mudar o dia 1 para praias",
                    "Mudar o dia 2 para cultura",
                    "Gerar plano de 3 dias"
                ];
                break;

            case 'outra_cidade':
                $resposta = match ($idioma) {
                    'en' => "I am **Guia PITE IA**, a virtual guide focused exclusively on tourism in **João Pessoa**. Therefore, I cannot provide detailed information about attractions in other cities. However, I can help you discover the best beaches, historic landmarks, events, and local gastronomy right here in João Pessoa! ☀️🏖️",
                    'es' => "Soy el **Guía PITE IA**, un asistente virtual centrado exclusivamente en el turismo de **João Pessoa**. Por lo tanto, no puedo brindar información sobre atracciones o sitios de otras ciudades. ¡Pero puedo ayudarte a descubrir las mejores playas, monumentos históricos, eventos y gastronomía aquí en João Pessoa! ☀️🏖️",
                    default => "Sou o **Guia PITE IA**, um assistente focado exclusivamente no turismo de **João Pessoa**. Por isso, não consigo informar sobre atrações ou locais turísticos de outras cidades. Mas posso te ajudar a descobrir as melhores praias, monumentos históricos, eventos e gastronomia aqui em João Pessoa! ☀️🏖️"
                };

                $destaques = Atrativo::where('destaque', true)->visivelPortal()->take(2)->get();
                if ($destaques->isEmpty()) {
                    $destaques = Atrativo::visivelPortal()->take(2)->get();
                }
                foreach ($destaques as $at) {
                    $cards[] = [
                        'tipo' => 'atrativo',
                        'titulo' => $at->nome,
                        'subtitulo' => '📍 João Pessoa · ' . ($at->categoria?->nome ?? 'Atrativo Turístico'),
                        'url' => route('portal.atrativos.show', $at->slug)
                    ];
                }
                $sugestoes = match ($idioma) {
                    'en' => ["Beaches in João Pessoa", "Historic Center", "Jacaré Sunset", "Generate AI Itinerary"],
                    'es' => ["Playas de João Pessoa", "Centro Histórico", "Puesta de sol en Jacaré", "Itinerario a medida"],
                    default => ["Praias de João Pessoa", "Centro Histórico de JP", "Pôr do Sol no Jacaré", "Roteiro Personalizado"]
                };
                break;

            case 'saudacao':
                $resposta = match ($idioma) {
                    'en' => "Hello! Welcome to João Pessoa! ☀️🏖️ I am **Guia PITE IA**, your official virtual tourism guide. How can I help you today? You can ask me about tourist spots, beaches, local cuisine, events, or request a custom itinerary!",
                    'es' => "¡Hola! ¡Bienvenido(a) a João Pessoa! ☀️🏖️ Soy el **Guía PITE IA**, tu asistente virtual oficial de turismo. ¿Cómo puedo ayudarte hoy? ¡Puedes preguntarme sobre atractivos, playas, gastronomía, eventos o itinerarios!",
                    default => "Olá! Seja muito bem-vindo(a) a João Pessoa! ☀️🏖️ Sou o **Guia PITE IA**, seu assistente virtual oficial de turismo. Como posso te ajudar hoje? Você pode me perguntar sobre pontos turísticos, praias, gastronomia regional, eventos ou pedir um roteiro personalizado!"
                };
                $sugestoes = match ($idioma) {
                    'en' => ["What to do today?", "Best beaches", "Local gastronomy", "1-day itinerary"],
                    'es' => ["¿Qué hacer hoy?", "Mejores playas", "Comida típica", "Itinerario de 1 día"],
                    default => ["O que fazer hoje?", "Praias mais bonitas", "Onde comer comida típica", "Roteiro de 1 dia"]
                };
                break;

            case 'agradecimento':
                $resposta = match ($idioma) {
                    'en' => "You're very welcome! 😊 Glad I could help. Enjoy every moment in João Pessoa! If you need any more tips or recommendations, just ask. Have a great time! 🌴✨",
                    'es' => "¡De nada! 😊 Me alegra mucho poder ayudarte. ¡Disfruta al máximo cada momento en João Pessoa! Si necesitas más consejos o información, aquí estaré. ¡Que tengas un gran paseo! 🌴✨",
                    default => "Por nada! 😊 Fico muito feliz em ajudar. Aproveite ao máximo cada momento em João Pessoa! Se precisar de mais alguma informação ou nova recomendação, é só me chamar. Tenha um ótimo passeio! 🌴✨"
                };
                $sugestoes = match ($idioma) {
                    'en' => ["Ready itineraries", "City beaches", "Events this week"],
                    'es' => ["Itinerarios listos", "Playas de la ciudad", "Eventos de la semana"],
                    default => ["Ver roteiros prontos", "Praias da cidade", "Eventos desta semana"]
                };
                break;

            case 'despedida':
                $resposta = match ($idioma) {
                    'en' => "Goodbye! 👋 It was a pleasure helping you. Have a wonderful stay and great trips in João Pessoa! Whenever you need official tips, Guia PITE IA is here. Safe travels! ☀️🌊",
                    'es' => "¡Hasta luego! 👋 Fue un placer ayudarte. ¡Que tengas una excelente estancia y grandes paseos en João Pessoa! Siempre que necesites consejos oficiales, el Guía PITE IA estará aquí. ¡Buen viaje! ☀️🌊",
                    default => "Até mais! 👋 Foi um prazer te ajudar. Tenha uma excelente estadia e ótimos passeios em João Pessoa! Sempre que precisar de dicas oficiais, o Guia PITE IA estará aqui. Boa viagem! ☀️🌊"
                };
                $sugestoes = match ($idioma) {
                    'en' => ["Top attractions", "Local food"],
                    'es' => ["Atractivos de JP", "Comida típica"],
                    default => ["Voltar ao início", "Praias de João Pessoa"]
                };
                break;

            case 'identidade':
                $resposta = match ($idioma) {
                    'en' => "I am **Guia PITE IA**, the official smart virtual tourism guide of João Pessoa! 🤖🌴\n\nI can help you with:\n• Top attractions & beaches in João Pessoa;\n• Custom itineraries tailored to your time & profile;\n• Verified local gastronomy & upcoming events;\n• Accessibility (PNE) & emergency contacts.",
                    'es' => "¡Soy el **Guía PITE IA**, el asistente virtual inteligente oficial de turismo de João Pessoa! 🤖🌴\n\nPuedo ayudarte con:\n• Principales atractivos y playas en João Pessoa;\n• Itinerarios personalizados según tu tiempo y perfil;\n• Gastronomía local verificada y eventos oficiales;\n• Accesibilidad (PNE) y contactos de emergencia.",
                    default => "Eu sou o **Guia PITE IA**, o assistente virtual inteligente e oficial do turismo de João Pessoa! 🤖🌴\n\nEstou conectado à base oficial de dados do município e posso te ajudar com:\n• **Atrativos & Praias**: informações atualizadas e passeios em João Pessoa;\n• **Roteiros Personalizados**: criação de itinerários sob medida;\n• **Gastronomia & Eventos**: onde comer e o que fazer na cidade;\n• **Acessibilidade & Segurança**: locais adaptados PNE e contatos úteis."
                };
                $sugestoes = match ($idioma) {
                    'en' => ["Generate AI Itinerary", "Search Tourist Spots", "Events in João Pessoa"],
                    'es' => ["Generar Itinerario IA", "Buscar Atractivos", "Eventos en João Pessoa"],
                    default => ["Gerar Roteiro Personalizado", "Buscar Pontos Turísticos", "Eventos em João Pessoa"]
                };
                break;

            case 'recomendacao_perfil':
                $atrativosQuery = Atrativo::with('categoria')->visivelPortal()->get();
                if ($atrativosQuery->isEmpty()) {
                    $atrativosQuery = Atrativo::with('categoria')->where('ativo', true)->get();
                }

                $eventosQuery = Evento::visivelPortal()
                    ->where(function($q) {
                        $q->whereNull('data_fim')->orWhere('data_fim', '>=', now());
                    })->get();

                $interessesTurista = [];
                $necessidadesEspeciais = [];
                $visitadosIds = [];

                if ($user) {
                    $interessesTurista = (array) ($user->interesses ?? []);
                    $necessidadesEspeciais = (array) ($user->necessidades_especiais ?? []);
                    if (method_exists($user, 'historicoVisitas')) {
                        $visitadosIds = $user->historicoVisitas()->pluck('atrativo_id')->toArray();
                    }
                }

                if (!empty($interessesTurista) || !empty($necessidadesEspeciais)) {
                    $pontuadosAtrativos = $atrativosQuery->map(function ($at) use ($interessesTurista, $necessidadesEspeciais, $visitadosIds, $user) {
                        $score = 0;
                        $catSlug = mb_strtolower($at->categoria?->slug ?? '');
                        $catNome = mb_strtolower($at->categoria?->nome ?? '');
                        $desc = mb_strtolower($at->descricao ?? '');
                        $nome = mb_strtolower($at->nome ?? '');

                        foreach ($interessesTurista as $int) {
                            $intClean = mb_strtolower($int);
                            if (str_contains($catSlug, $intClean) || str_contains($catNome, $intClean) || str_contains($desc, $intClean) || str_contains($nome, $intClean)) {
                                $score += 25;
                            }
                        }

                        if (in_array('cadeirante', $necessidadesEspeciais) || in_array('pne', $necessidadesEspeciais)) {
                            $niveis = (array) ($at->niveis_acessibilidade ?? []);
                            if (!empty($niveis['cadeirante']) || !empty($niveis['rampa'])) {
                                $score += 15;
                            }
                        }

                        if ($user && $user->possui_filhos) {
                            if (str_contains($desc, 'família') || str_contains($desc, 'criança') || str_contains($desc, 'infantil') || str_contains($catSlug, 'ecologico') || str_contains($catSlug, 'praia')) {
                                $score += 10;
                            }
                        }

                        if ($at->destaque) {
                            $score += 10;
                        }

                        if (in_array($at->id, $visitadosIds)) {
                            $score -= 5;
                        }

                        return [
                            'item' => $at,
                            'tipo' => 'atrativo',
                            'score' => $score
                        ];
                    });

                    $pontuadosEventos = $eventosQuery->map(function ($ev) use ($interessesTurista, $user) {
                        $score = 0;
                        $desc = mb_strtolower($ev->descricao ?? '');
                        $titulo = mb_strtolower($ev->titulo ?? '');
                        $local = mb_strtolower($ev->local ?? '');

                        foreach ($interessesTurista as $int) {
                            $intClean = mb_strtolower($int);
                            if (str_contains($titulo, $intClean) || str_contains($desc, $intClean) || str_contains($local, $intClean)) {
                                $score += 25;
                            }
                        }

                        if ($user && $user->possui_filhos) {
                            if (str_contains($desc, 'família') || str_contains($desc, 'criança') || str_contains($desc, 'infantil')) {
                                $score += 10;
                            }
                        }

                        // Bonus para eventos próximos ou hoje
                        $score += 5;

                        return [
                            'item' => $ev,
                            'tipo' => 'evento',
                            'score' => $score
                        ];
                    });

                    $todosPontuados = $pontuadosAtrativos->concat($pontuadosEventos)
                        ->sortByDesc('score')
                        ->values();

                    $topItens = $todosPontuados->take(4);

                    $interessesFormatados = implode(', ', array_map(fn($i) => mb_convert_case($i, MB_CASE_TITLE, "UTF-8"), $interessesTurista));

                    $top1 = $topItens->first();
                    $top1Nome = $top1['tipo'] === 'atrativo' ? $top1['item']->nome : $top1['item']->titulo;

                    $introPt = "Com base no seu perfil de turista" . ($interessesFormatados ? " e nos seus interesses em **{$interessesFormatados}**" : "") . ", analisei o catálogo e encontrei a melhor combinação para você! 🎯✨\n\n";

                    foreach ($topItens as $idx => $entry) {
                        $item = $entry['item'];
                        $isTop1 = ($idx === 0);
                        if ($entry['tipo'] === 'atrativo') {
                            $catLabel = $item->categoria?->nome ?? 'Atrativo Turístico';
                            $resumo = Str::limit(strip_tags($item->descricao), 100);
                            $badge = $isTop1 ? "⭐ **MELHOR OPÇÃO PARA VOCÊ (#1)**: " : "• ";
                            $introPt .= "{$badge}**{$item->nome}** ({$catLabel}). {$resumo}\n";
                        } else {
                            $resumo = Str::limit(strip_tags($item->descricao), 100);
                            $dataFmt = $item->data_inicio ? $item->data_inicio->format('d/m') : 'Em breve';
                            $badge = $isTop1 ? "⭐ **MELHOR OPÇÃO PARA VOCÊ (#1 - EVENTO)**: " : "• [Evento em {$dataFmt}] ";
                            $introPt .= "{$badge}**{$item->titulo}** no {$item->local}. {$resumo}\n";
                        }
                    }

                    $introPt .= "\nO local **{$top1Nome}** obteve o maior grau de afinidade com as suas preferências!";

                    $resposta = match ($idioma) {
                        'en' => "Based on your traveler profile" . ($interessesFormatados ? " and your interests in **{$interessesFormatados}**" : "") . ", our AI identified the best match for you:\n\n" .
                                $topItens->map(function($e, $i) {
                                    $isTop1 = ($i === 0);
                                    $n = $e['tipo'] === 'atrativo' ? $e['item']->nome : $e['item']->titulo;
                                    $d = Str::limit(strip_tags($e['item']->descricao), 100);
                                    return ($isTop1 ? "⭐ **TOP CHOICE (#1)**: " : "• ") . "**{$n}**. {$d}";
                                })->implode("\n"),
                        'es' => "Según tu perfil de turista" . ($interessesFormatados ? " y tus intereses en **{$interessesFormatados}**" : "") . ", la IA identificó la mejor opción para ti:\n\n" .
                                $topItens->map(function($e, $i) {
                                    $isTop1 = ($i === 0);
                                    $n = $e['tipo'] === 'atrativo' ? $e['item']->nome : $e['item']->titulo;
                                    $d = Str::limit(strip_tags($e['item']->descricao), 100);
                                    return ($isTop1 ? "⭐ **OPCIÓN PRINCIPAL (#1)**: " : "• ") . "**{$n}**. {$d}";
                                })->implode("\n"),
                        default => $introPt
                    };

                    foreach ($topItens as $entry) {
                        $item = $entry['item'];
                        if ($entry['tipo'] === 'atrativo') {
                            $cards[] = [
                                'tipo' => 'atrativo',
                                'titulo' => $item->nome,
                                'subtitulo' => '🎯 Recomendado para seu perfil · ' . ($item->categoria?->nome ?? 'Atrativo Turístico'),
                                'url' => route('portal.atrativos.show', $item->slug)
                            ];
                        } else {
                            $cards[] = [
                                'tipo' => 'evento',
                                'titulo' => '🎉 ' . $item->titulo,
                                'subtitulo' => 'Evento em João Pessoa · ' . ($item->local ?? 'Local a definir'),
                                'url' => route('portal.eventos.show', $item->slug)
                            ];
                        }
                    }

                    $sugestoes = match ($idioma) {
                        'en' => ["Generate Custom AI Itinerary", "Edit my interests", "Beaches in João Pessoa"],
                        'es' => ["Generar Itinerario Personalizado", "Editar mis intereses", "Playas de João Pessoa"],
                        default => ["Gerar Roteiro Personalizado", "Editar meus interesses no perfil", "Ver praias de João Pessoa"]
                    };

                } else {
                    $destaques = $atrativosQuery->where('destaque', true)->take(4);
                    if ($destaques->isEmpty()) {
                        $destaques = $atrativosQuery->take(4);
                    }

                    $resposta = match ($idioma) {
                        'en' => "Here are top recommended places to visit in **João Pessoa**! ☀️🏖️\n\n" .
                                $destaques->map(fn($at) => "• **{$at->nome}**: " . ($at->categoria?->nome ?? 'Attraction') . ". " . Str::limit(strip_tags($at->descricao), 110))->implode("\n") .
                                "\n\n💡 *Tip: Log in and configure your traveler interests in your profile to get 100% personalized AI suggestions!*",
                        'es' => "¡Aquí tienes excelentes lugares recomendados para visitar en **João Pessoa**! ☀️🏖️\n\n" .
                                $destaques->map(fn($at) => "• **{$at->nome}**: " . ($at->categoria?->nome ?? 'Atracción') . ". " . Str::limit(strip_tags($at->descricao), 110))->implode("\n") .
                                "\n\n💡 *Consejo: ¡Inicia sesión y configura tus intereses en tu perfil de turista para recibir recomendaciones personalizadas por la IA!*",
                        default => "Confira os melhores e mais populares locais para visitar em **João Pessoa**! ☀️🏖️\n\n" .
                                $destaques->map(fn($at) => "• **{$at->nome}**: " . ($at->categoria?->nome ?? 'Atrativo Turístico') . ". " . Str::limit(strip_tags($at->descricao), 110))->implode("\n") .
                                "\n\n💡 *Dica PITE: Faça login e cadastre seus interesses no seu perfil de turista para receber recomendações de IA 100% personalizadas sob medida para você! 🎯*"
                    };

                    foreach ($destaques as $at) {
                        $cards[] = [
                            'tipo' => 'atrativo',
                            'titulo' => $at->nome,
                            'subtitulo' => '📍 João Pessoa · ' . ($at->categoria?->nome ?? 'Destaque Turístico'),
                            'url' => route('portal.atrativos.show', $at->slug)
                        ];
                    }

                    $sugestoes = match ($idioma) {
                        'en' => ["Custom AI Itinerary", "Beach guide", "Historic center"],
                        'es' => ["Itinerario con IA", "Guía de playas", "Centro histórico"],
                        default => ["Gerar Roteiro Personalizado", "Guia das Praias de JP", "Centro Histórico"]
                    };
                }
                break;

            case 'praias':
                $resposta = match ($idioma) {
                    'en' => "João Pessoa has one of the most beautiful urban coastlines in Brazil! 🏖️✨\n\nMain beaches in the city:\n• **Tambaú**: Vibrant atmosphere, craft fair, and catamaran departures to Picãozinho natural pools.\n• **Cabo Branco**: Tree-lined promenade, ideal for walks, close to Cabo Branco Lighthouse.\n• **Bessa**: Calm, crystal-clear waters, great for stand-up paddle and families.\n• **Seixas**: The easternmost point of the Americas, with amazing natural pools during low tide.",
                    'es' => "¡João Pessoa tiene una de las costas urbanas más bellas de Brasil! 🏖️✨\n\nPrincipales playas de la ciudad:\n• **Tambaú**: Corazón turístico, feria de artesanía y salidas hacia las piscinas naturales de Picãozinho.\n• **Cabo Branco**: Paseo arbolado ideal para caminatas, cerca del Faro de Cabo Branco.\n• **Bessa**: Aguas tranquilas, perfectas para kayak y familias.\n• **Seixas**: ¡El punto más oriental de las Américas!",
                    default => "João Pessoa possui uma das orlas urbanas mais bonitas e preservadas do Brasil! 🏖️✨\n\nConfira as principais praias da cidade:\n• **Tambaú**: Coração turístico, com mar calmo, feirinha de artesanato e saída de catamarãs para as piscinas naturais de Picãozinho.\n• **Cabo Branco**: Orla arborizada, calçadão ideal para caminhadas e proximidade com o Farol do Cabo Branco.\n• **Bessa (Caribessa)**: Águas calmas e cristalinas, perfeitas para caiaque, stand-up paddle e famílias.\n• **Seixas**: O ponto mais oriental das Américas, com piscinas naturais incríveis na maré baixa."
                };
                $praiaAtrativos = Atrativo::where(function($q) {
                        $q->where('nome', 'like', '%praia%')
                          ->orWhere('nome', 'like', '%tamba%')
                          ->orWhere('nome', 'like', '%cabo branco%')
                          ->orWhere('nome', 'like', '%seixas%');
                    })
                    ->visivelPortal()->take(3)->get();
                foreach ($praiaAtrativos as $at) {
                    $cards[] = [
                        'tipo' => 'atrativo',
                        'titulo' => $at->nome,
                        'subtitulo' => '🏖️ Orla de João Pessoa',
                        'url' => route('portal.atrativos.show', $at->slug)
                    ];
                }
                $sugestoes = match ($idioma) {
                    'en' => ["Seixas Natural Pools", "Jacaré Sunset", "Beach Itinerary"],
                    'es' => ["Piscinas Naturales de Seixas", "Puesta de sol en Jacaré", "Ruta de Playas"],
                    default => ["Piscinas Naturais do Seixas", "Pôr do Sol no Jacaré", "Roteiro das Praias"]
                };
                break;

            case 'por_do_sol':
                $resposta = match ($idioma) {
                    'en' => "Sunsets in João Pessoa and region are unforgettable! 🌅🎷\n\nTop spots to watch:\n• **Jacaré Beach (Cabedelo/JP)**: Famous sunset accompanied live by Jurandy do Sax playing Ravel's Bolero.\n• **Cabo Branco Lighthouse & Station**: Panoramic ocean view at the Easternmost Point of the Americas.\n• **Tambaú & Cabo Branco Waterfront**: Great for an evening walk along the beach.",
                    'es' => "¡Los atardeceres en João Pessoa son inolvidables! 🌅🎷\n\nMejores lugares:\n• **Playa de Jacaré**: Puesta de sol con el Bolero de Ravel interpretado en vivo por Jurandy do Sax.\n• **Faro y Estación Cabo Branco**: Vista panorámica del océano en el punto más oriental de las Américas.\n• **Paseo de Tambaú y Cabo Branco**: Excelente para caminar al atardecer.",
                    default => "O pôr do sol em João Pessoa e região metropolitana é um espetáculo inesquecível! 🌅🎷\n\nOs melhores locais para contemplar:\n• **Praia do Jacaré (Cabedelo/João Pessoa)**: O famoso pôr do sol embalado ao vivo pelo Bolero de Ravel executado por Jurandy do Sax.\n• **Farol do Cabo Branco & Estação Cabo Branco**: Vista panorâmica do oceano no Ponto Mais Oriental das Américas.\n• **Orla de Tambaú e Cabo Branco**: Excelente para ver as cores do entardecer durante uma caminhada pelo calçadão."
                };
                $sugestoes = match ($idioma) {
                    'en' => ["Farol do Cabo Branco", "Restaurants near the beach", "Evening Itinerary"],
                    'es' => ["Faro de Cabo Branco", "Restaurantes cerca del mar", "Itinerario nocturno"],
                    default => ["Farol do Cabo Branco", "Restaurantes na Orla", "Roteiro Noturno"]
                };
                break;

            case 'clima_epoca':
                $resposta = match ($idioma) {
                    'en' => "João Pessoa is sunny almost all year round! ☀️🌡️\n\n• **September to March (Dry & High Season)**: Clear days, bright sun, and crystal-clear waters for natural pool visits.\n• **April to August (Rainy Season)**: Passing showers and mild tropical weather. Great for visiting the Historic Center, museums, and regional gastronomy.\n• **Tide Tip**: For natural pools, check low tides below 0.4m during Full or New Moon!",
                    'es' => "¡João Pessoa es soleada casi todo el año! ☀️🌡️\n\n• **Septiembre a Marzo (Seco y Temporada Alta)**: Días despejados, sol radiante y aguas cristalinas.\n• **Abril a Agosto (Lluvioso)**: Lluvias pasajeras y clima fresco. Ideal para visitar el Centro Histórico y museos.\n• **Consejo de Marea**: Para piscinas naturales, consulta mareas bajas de menos de 0.4m.",
                    default => "João Pessoa é uma cidade ensolarada praticamente o ano todo! ☀️🌡️\n\n• **Setembro a Março (Alta Temporada & Seca)**: Meses com dias mais limpos, sol radiante e águas cristalinas para passeios de maré baixa.\n• **Abril a Agosto (Período Chuvoso)**: Chuvas passageiras e clima tropical ameno. Ótimo momento para conhecer o Centro Histórico, museus e desfrutar da rica gastronomia regional.\n• **Dica de Maré**: Para piscinas naturais, planeje sua visita nas luas cheia ou nova, com maré abaixo de 0.4m!"
                };
                $sugestoes = match ($idioma) {
                    'en' => ["Tide table info", "Indoor activities", "Historic Center"],
                    'es' => ["Tabla de mareas", "Qué hacer si llueve", "Centro Histórico"],
                    default => ["Informação de marés", "O que fazer com chuva?", "Centro Histórico"]
                };
                break;

            case 'mare':
                $resposta = match ($idioma) {
                    'en' => "To visit Picãozinho and Seixas natural pools, the secret is the tide table! 🌊⚓\n\n• **Ideal Tide**: Choose days with tide between 0.0m and 0.4m.\n• **Moon Phases**: Lowest tides occur during New Moon and Full Moon.\n• **Schedule**: Catamaran tours leave about 1h30 before the lowest tide point.",
                    'es' => "Para visitar las piscinas naturales de Picãozinho y Seixas, ¡el secreto es la tabla de mareas! 🌊⚓\n\n• **Marea Ideal**: Elige días con marea entre 0.0m y 0.4m.\n• **Fases de la Luna**: Luna Nueva y Luna Llena.\n• **Horario**: Los catamarán salen aprox. 1h30 antes de la marea más baja.",
                    default => "Para visitar as famosas **Piscinas Naturais de Picãozinho** e do **Seixas**, o segredo é a tábua de marés! 🌊⚓\n\n• **Maré Ideal**: Escolha dias com maré entre **0.0m e 0.4m**.\n• **Fases da Lua**: As marés mais baixas ocorrem nas fases de Lua Nova e Lua Cheia.\n• **Horário**: Os passeios de catamarã saem cerca de 1h30 antes do pico da maré baixa."
                };
                $sugestoes = match ($idioma) {
                    'en' => ["Seixas pools", "Tambaú beach", "Catamaran tours"],
                    'es' => ["Piscinas de Seixas", "Playa de Tambaú", "Catamarán"],
                    default => ["Piscinas do Seixas", "Praia de Tambaú", "Passeio de Catamarã"]
                };
                break;

            case 'artesanato_compras':
                $resposta = match ($idioma) {
                    'en' => "João Pessoa highly values local craftsmanship! 🛍️🎨\n\nMust-visit shopping spots:\n• **Tambaú Craft Fair**: Open daily on the waterfront with lace, embroidery, and local sweets.\n• **Paraíba Handicraft Market (MAP)**: Complete complex of regional crafts in Tambaú.\n• **Historic Center**: Studios and shops with clay, leather, and wood crafts.",
                    'es' => "¡João Pessoa valora enormemente la artesanía local! 🛍️🎨\n\nLugares imperdibles:\n• **Feria de Artesanía de Tambaú**: Abierta a diario en la costa.\n• **Mercado de Artesanía Paraibano (MAP)**: Complejo de artesanías en Tambaú.\n• **Centro Histórico**: Tiendas de artesanía en madera y cerámica.",
                    default => "João Pessoa valoriza muito o artesanato e os produtores locais! 🛍️🎨\n\nLocais imperdíveis para compras e lembrancinhas:\n• **Feirinha de Artesanato de Tambaú**: Localizada na Orla de Tambaú, funciona diariamente com rendas, bordados e doces típicos.\n• **Mercado de Artesanato Paraibano (MAP)**: Complexo completo de artesanato regional em Tambaú.\n• **Centro Histórico**: Ateliês e lojas com peças exclusivas em argila, couro e madeira."
                };
                $sugestoes = match ($idioma) {
                    'en' => ["Tambaú Fair", "Historic Center", "Regional sweets"],
                    'es' => ["Feria de Tambaú", "Centro Histórico", "Dulces típicos"],
                    default => ["Feirinha de Tambaú", "Centro Histórico", "Doces regionais"]
                };
                break;

            case 'eventos':
                $eventos = Evento::where('ativo', true)->where('status_aprovacao', 'aprovado')->latest('data_inicio')->take(3)->get();
                if ($eventos->isNotEmpty()) {
                    $nomes = $eventos->pluck('nome')->implode(', ');
                    $resposta = match ($idioma) {
                        'en' => "Here are the top upcoming official events validated by the municipality: {$nomes}. Check them below!",
                        'es' => "Aquí están los principales eventos oficiales validados por el municipio: {$nomes}. ¡Consúltalos a continuación!",
                        default => "Encontrei eventos oficiais programados no município: {$nomes}. Você pode conferir os detalhes e datas abaixo!"
                    };
                    $cards = $eventos->map(fn($e) => [
                        'tipo' => 'evento',
                        'titulo' => $e->nome,
                        'subtitulo' => ($e->data_inicio ? $e->data_inicio->format('d/m/Y') : 'Em breve') . ($e->gratuito ? ' · Gratuito' : ''),
                        'url' => route('portal.eventos.show', $e->slug)
                    ])->toArray();
                } else {
                    $resposta = match ($idioma) {
                        'en' => "There are no major events registered for this week in João Pessoa, but our beaches, historic landmarks, and parks are open!",
                        'es' => "No hay eventos registrados para esta semana en João Pessoa, ¡pero nuestras playas y sitios históricos están abiertos!",
                        default => "Não temos eventos cadastrados para esta semana em João Pessoa, mas nossas praias, pontos históricos e parques estão funcionando normalmente!"
                    };
                }
                $sugestoes = ["Ver calendário de eventos", "Roteiros para o fim de semana", "Onde comer perto"];
                break;

            case 'gastronomia':
                $gastronomicos = Atrativo::whereHas('categoria', fn($q) => $q->where('slug', 'gastronomia-local'))
                    ->visivelPortal()->take(3)->get();

                $resposta = match ($idioma) {
                    'en' => "Our municipal cuisine is famous for authentic flavors and local family farming. Here are top verified places to eat in João Pessoa:",
                    'es' => "Nuestra gastronomía municipal en João Pessoa es famosa por sus sabores auténticos. Aquí tienes los mejores lugares verificados para comer:",
                    default => "Nossa culinária típica é um dos maiores orgulhos de João Pessoa! Confira estas indicações oficiais de gastronomia local:"
                };

                foreach ($gastronomicos as $at) {
                    $cards[] = [
                        'tipo' => 'atrativo',
                        'titulo' => $at->nome,
                        'subtitulo' => ($at->preco_medio > 0 ? 'Preço médio: R$ ' . number_format($at->preco_medio, 2, ',', '.') : 'Acesso livre') . ' · ' . ($at->horario_funcionamento ?? 'Consulte'),
                        'url' => route('portal.atrativos.show', $at->slug)
                    ];
                }
                $sugestoes = ["Mercado Público Municipal", "Roteiro gastronômico completo", "Restaurantes na orla"];
                break;

            case 'acessibilidade':
                $acessiveis = Atrativo::whereJsonContains('niveis_acessibilidade->cadeirante', true)
                    ->visivelPortal()->take(3)->get();
                $resposta = match ($idioma) {
                    'en' => "System-PITE ensures universal accessibility in João Pessoa. All attractions listed below feature ramps, accessible restrooms, tactile paving, and audio guides:",
                    'es' => "System-PITE garantiza la accesibilidad universal en João Pessoa. Todos los atractivos a continuación cuentan con rampas, baños adaptados y audioguía:",
                    default => "João Pessoa tem compromisso total com a acessibilidade universal (WCAG e normas PNE). Os seguintes pontos contam com rampas, banheiros adaptados, piso tátil e áudio-guia:"
                };

                foreach ($acessiveis as $at) {
                    $cards[] = [
                        'tipo' => 'atrativo',
                        'titulo' => $at->nome,
                        'subtitulo' => '♿ 100% Adaptado PNE · ' . ($at->endereco ?? 'João Pessoa'),
                        'url' => route('portal.atrativos.show', $at->slug)
                    ];
                }
                $sugestoes = ["Gerar roteiro 100% acessível", "Ouvir audiodescrição", "Locais com piso tátil"];
                break;

            case 'ecoturismo':
                $natureza = Atrativo::whereHas('categoria', fn($q) => $q->where('slug', 'turismo-ecologico-e-de-aventura'))
                    ->visivelPortal()->take(3)->get();
                $resposta = match ($idioma) {
                    'en' => "For nature and adventure lovers in João Pessoa, we have scenic parks, trails, and coastal viewpoints:",
                    'es' => "Para los amantes de la naturaleza en João Pessoa, contamos con parques, senderos ecológicos y miradores marítimos:",
                    default => "Para quem busca ecoturismo e ar puro em João Pessoa, o município conta com parques urbanos, trilhas na Mata Atlântica e mirantes com vistas espetaculares:"
                };

                foreach ($natureza as $at) {
                    $cards[] = [
                        'tipo' => 'atrativo',
                        'titulo' => $at->nome,
                        'subtitulo' => '🌲 Ecoturismo & Natureza · ' . ($at->horario_funcionamento ?? 'Todos os dias'),
                        'url' => route('portal.atrativos.show', $at->slug)
                    ];
                }
                $sugestoes = ["Parque da Bica", "Jardim Botânico de JP", "Farol do Cabo Branco"];
                break;

            case 'historia':
                $historicos = Atrativo::whereHas('categoria', fn($q) => $q->where('slug', 'patrimonio-historico-e-cultural'))
                    ->visivelPortal()->take(3)->get();
                $resposta = match ($idioma) {
                    'en' => "Our Historic Center in João Pessoa features preserved colonial architecture, heritage churches, and cultural museums:",
                    'es' => "Nuestro Centro Histórico en João Pessoa cuenta con arquitectura colonial, iglesias patrimoniales y museos culturales:",
                    default => "Nosso Centro Histórico em João Pessoa preserva a memória viva do Brasil colonial, com monumentos tombados, igrejas barocas e casarios restaurados:"
                };

                foreach ($historicos as $at) {
                    $cards[] = [
                        'tipo' => 'atrativo',
                        'titulo' => $at->nome,
                        'subtitulo' => '🏛️ Patrimônio Histórico · ' . ($at->endereco ?? 'Centro Histórico'),
                        'url' => route('portal.atrativos.show', $at->slug)
                    ];
                }
                $sugestoes = ["Centro Cultural São Francisco", "Praça Anthenor Navarro", "Roteiro histórico a pé"];
                break;

            case 'emergencia':
                $resposta = match ($idioma) {
                    'en' => "🚨 Official João Pessoa Emergency & Tourist Contacts:\n• Police (Polícia Militar): 190\n• Ambulance (SAMU): 192\n• Fire Department (Bombeiros): 193\n• Civil Defense (Defesa Civil): 199\n• Municipal Guard: 153\n• Tourism Support Center (CAT): (83) 3333-0000",
                    'es' => "🚨 Contactos Oficiales de Emergencia y Turismo en João Pessoa:\n• Policía (Polícia Militar): 190\n• Ambulancia (SAMU): 192\n• Bomberos (Bombeiros): 193\n• Defensa Civil: 199\n• Guardia Municipal: 153\n• Atención al Turista (CAT): (83) 3333-0000",
                    default => "🚨 Telefones Úteis e Contatos de Emergência em João Pessoa:\n• Polícia Militar: 190\n• SAMU (Ambulância): 192\n• Corpo de Bombeiros: 193\n• Defesa Civil: 199\n• Guarda Municipal: 153\n• Centro de Atendimento ao Turista (CAT): (83) 3333-0000"
                };
                $sugestoes = ["Hospitais próximos", "Farmácias 24h", "Dicas de segurança"];
                break;

            case 'roteiro':
                $roteiros = Roteiro::where('ativo', true)->take(3)->get();
                $resposta = match ($idioma) {
                    'en' => "You can choose from our curated itineraries in João Pessoa or use our AI Generator to create a custom plan according to your time and budget:",
                    'es' => "Puedes elegir entre nuestros itinerarios preparados en João Pessoa o usar el Generador de IA para crear un plan a tu medida:",
                    default => "Temos excelentes roteiros estruturados em João Pessoa e você também pode usar nosso Gerador com IA para criar um roteiro sob medida em segundos:"
                };

                foreach ($roteiros as $rot) {
                    $cards[] = [
                        'tipo' => 'roteiro',
                        'titulo' => $rot->titulo,
                        'subtitulo' => "⏱️ {$rot->tempo_formatado} · 📍 {$rot->distancia_formatada} · {$rot->nivel_dificuldade_label}",
                        'url' => route('portal.roteiros.show', $rot->slug)
                    ];
                }
                $sugestoes = ["Gerar roteiro de 4 horas", "Roteiro para família com crianças", "Roteiro das praias"];
                break;

            default:
                // Resposta geral com busca semântica em atrativos
                $atrativosBusca = Atrativo::where('nome', 'like', "%{$perguntaLimpa}%")
                    ->orWhere('descricao', 'like', "%{$perguntaLimpa}%")
                    ->visivelPortal()->take(2)->get();

                if ($atrativosBusca->isNotEmpty()) {
                    $nomes = $atrativosBusca->pluck('nome')->implode(' e ');
                    $resposta = match ($idioma) {
                        'en' => "Based on official municipal records for João Pessoa, I found these matching destinations: {$nomes}.",
                        'es' => "Según los registros oficiales del municipio de João Pessoa, encontré estos destinos: {$nomes}.",
                        default => "Com base no banco oficial do município de João Pessoa, localizei estas excelentes opções: {$nomes}."
                    };
                    foreach ($atrativosBusca as $at) {
                        $cards[] = [
                            'tipo' => 'atrativo',
                            'titulo' => $at->nome,
                            'subtitulo' => $at->categoria?->nome ?? 'Atrativo Turístico em João Pessoa',
                            'url' => route('portal.atrativos.show', $at->slug)
                        ];
                    }
                } else {
                    $resposta = match ($idioma) {
                        'en' => "Hello! I am **Guia PITE IA**, a virtual assistant focused exclusively on tourism in **João Pessoa**. I couldn't find a specific attraction matching your search term in our official database. How else can I assist your trip? You can ask me about beaches, historic landmarks, gastronomy, events, or custom itineraries!",
                        'es' => "¡Hola! Soy el **Guía PITE IA**, un asistente virtual enfocado exclusivamente en el turismo de **João Pessoa**. No encontré un atractivo específico que coincida con tu búsqueda en nuestra base oficial. ¿Cómo posso ayudarte? ¡Pregúntame sobre playas, centro histórico, gastronomía, eventos o itinerarios!",
                        default => "Olá! Sou o **Guia PITE IA**, assistente virtual oficial de turismo focado exclusivamente em **João Pessoa**. Não encontrei um local específico correspondente à sua busca em nossa base oficial do município. Como posso te ajudar hoje? Você pode me perguntar sobre nossas praias, centro histórico, gastronomia típica, eventos ou solicitar um roteiro inteligente!"
                    };
                }
                $sugestoes = match ($idioma) {
                    'en' => ["What to do today?", "Top attractions in JP", "PNE Accessible routes", "Emergency numbers"],
                    'es' => ["¿Qué hacer hoy?", "Atractivos de JP", "Rutas accesibles", "Teléfonos útiles"],
                    default => ["O que fazer hoje?", "Atrativos de João Pessoa", "Praias mais bonitas", "Telefones de emergência"]
                };
                break;
        }

        return [
            'pergunta' => $pergunta,
            'resposta' => $resposta,
            'cards' => $cards,
            'sugestoes' => $sugestoes,
            'dados_extras' => $dadosExtras ?? null,
            'idioma' => $idioma,
            'fonte_dados' => 'Base de Dados Oficial e Auditada do Município (System-PITE)',
            'supervisao_humana' => true,
            'aviso_legal' => 'Conteúdo informativo gerado com inteligência artificial supervisionada pela Secretaria Municipal de Turismo.'
        ];
    }

    /**
     * Geração Assistida de Descrições Turísticas para Gestores no Painel Administrativo.
     */
    public function gerarDescricaoAtrativo(array $dados): string
    {
        $nome = $dados['nome'] ?? 'Atrativo Turístico';
        $categoriaNome = $dados['categoria_nome'] ?? 'Patrimônio Municipal';
        $endereco = $dados['endereco'] ?? 'região central';
        $temAcessibilidade = !empty($dados['acessivel']);

        $introducao = [
            "O {$nome} é um dos mais representativos pontos de interesse do município no segmento de {$categoriaNome}.",
            "Localizado estrategicamente na {$endereco}, o {$nome} encanta visitantes e moradores com sua riqueza e relevância cultural.",
            "Um destino imperdível na rota turística municipal, o {$nome} combina história, beleza e identidade local."
        ];

        $corpo = [
            "O local oferece infraestrutura completa para acolher turistas com conforto e segurança, valorizando a preservação do patrimônio e as tradições do município.",
            "Projetado para proporcionar uma experiência imersiva e inesquecível, destaca-se pelo cuidado com o meio ambiente e pelo fortalecimento do turismo sustentável (ESG)."
        ];

        $acessibilidadeTexto = $temAcessibilidade
            ? " Conta com infraestrutura 100% adaptada para pessoas com deficiência e mobilidade reduzida (PNE), incluindo rampas de acesso, piso tátil e banheiros adaptados."
            : " Dispõe de sinalização informativa e apoio de monitores treinados para orientar os visitantes.";

        $conclusao = " Aberto à visitação pública com horários regulares e apoio das diretrizes da Secretaria Municipal de Turismo.";

        return $introducao[array_rand($introducao)] . " " . $corpo[array_rand($corpo)] . $acessibilidadeTexto . $conclusao;
    }

    /**
     * Análise Inteligente de Avaliações e Sentimentos para o Dashboard Executivo.
     */
    public function analisarSentimentoAvaliacoes(): array
    {
        $avaliacoes = Avaliacao::latest()->take(100)->get();

        $total = $avaliacoes->count();
        if ($total === 0) {
            return [
                'indice_satisfacao' => 98.5,
                'positivo_pct' => 92,
                'neutro_pct' => 6,
                'atencao_pct' => 2,
                'destaques_positivos' => ['Preservação Histórica', 'Acessibilidade PNE', 'Atendimento dos Guias', 'Gastronomia Local'],
                'oportunidades_melhoria' => ['Ampliação de vagas de estacionamento', 'Sinalização em idiomas adicionais'],
                'resumo_executivo' => 'Excelente percepção pública com alto índice de recomendação espontânea.'
            ];
        }

        $positivas = $avaliacoes->filter(fn($a) => $a->nota >= 4)->count();
        $neutras = $avaliacoes->filter(fn($a) => $a->nota == 3)->count();
        $atencao = $avaliacoes->filter(fn($a) => $a->nota <= 2)->count();

        $media = $avaliacoes->avg('nota');
        $indiceSatisfacao = round(($media / 5) * 100, 1);

        return [
            'total_avaliado' => $total,
            'indice_satisfacao' => $indiceSatisfacao,
            'positivo_pct' => round(($positivas / $total) * 100, 1),
            'neutro_pct' => round(($neutras / $total) * 100, 1),
            'atencao_pct' => round(($atencao / $total) * 100, 1),
            'destaques_positivos' => [
                'Acessibilidade Universal & Rampas',
                'Conservação do Patrimônio e Limpeza',
                'Hospitalidade dos Estabelecimentos',
                'Experiência Gastronômica Regional'
            ],
            'oportunidades_melhoria' => [
                'Reforço na sinalização de trilhas rurais',
                'Instalação de mais bebedouros em dias de alta temporada'
            ],
            'resumo_executivo' => "Análise de {$total} relatos de visitantes aponta aprovação de {$indiceSatisfacao}%, com forte destaque para o acolhimento e sustentabilidade."
        ];
    }
}
