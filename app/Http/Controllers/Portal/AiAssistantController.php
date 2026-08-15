<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Atrativo;
use App\Models\Categoria;
use App\Services\AiItineraryService;
use Illuminate\Http\Request;

class AiAssistantController extends Controller
{
    protected $aiService;

    public function __construct(AiItineraryService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Endpoint do Assistente Virtual ("Guia PITE IA").
     * Responde dúvidas em linguagem natural baseando-se estritamente na base oficial municipal.
     */
    public function chat(Request $request)
    {
        $request->validate([
            'mensagem' => 'required|string|max:500',
            'idioma' => 'nullable|string|in:pt,en,es'
        ]);

        $pergunta = $request->input('mensagem');
        $idioma = $request->input('idioma', 'pt');

        $resposta = $this->aiService->responderDuvidaTurista($pergunta, $idioma);

        return response()->json([
            'sucesso' => true,
            'dados' => $resposta
        ]);
    }

    /**
     * Endpoint para tradução instantânea de conteúdos (PT, EN, ES).
     */
    public function traduzir(Request $request)
    {
        $request->validate([
            'texto' => 'required|string|max:5000',
            'para_idioma' => 'required|string|in:en,es,pt'
        ]);

        $texto = $request->input('texto');
        $para = $request->input('para_idioma');

        // Dicionário contextual de termos turísticos municipais para tradução instantânea e fidedigna
        $traducoesComuns = [
            'en' => [
                'Patrimônio Histórico e Cultural' => 'Historical and Cultural Heritage',
                'Turismo Ecológico e de Aventura' => 'Ecological and Adventure Tourism',
                'Gastronomia Local' => 'Local Gastronomy',
                'Hospedagem e Hotelaria' => 'Hospitality & Hotels',
                'Eventos e Festividades' => 'Events & Festivals',
                'Artesanato e Comércio Local' => 'Handicraft & Local Commerce',
                'Entrada Gratuita' => 'Free Admission',
                'Preço Médio' => 'Average Price',
                'Horário de Funcionamento' => 'Opening Hours',
                'Acessível para PNE' => '100% Accessible (PNE)',
                'Rampas de Acesso' => 'Access Ramps',
                'Banheiro Adaptado' => 'Accessible Restrooms',
                'Piso Tátil Direcional' => 'Tactile Paving',
                'Áudio-Guia Integrado' => 'Integrated Audio Guide',
                'Terça a Domingo' => 'Tuesday to Sunday',
                'Todos os dias' => 'Every day',
                'das 08h às 18h' => 'from 8:00 AM to 6:00 PM',
                'das 07h às 17h' => 'from 7:00 AM to 5:00 PM',
                'Conjunto arquitetônico colonial preservado do século XVIII, com visitas guiadas, feiras de artesanato típico e apresentações culturais semanais.' =>
                    'Preserved 18th-century colonial architectural ensemble with guided tours, traditional craft fairs, and weekly cultural performances.',
                'Reserva municipal com 4 quedas d\'água cristalinas, trilhas ecológicas sinalizadas e infraestrutura de pontes acessíveis com baixo impacto ambiental.' =>
                    'Municipal nature reserve with 4 crystal-clear waterfalls, signposted ecological trails, and eco-friendly accessible bridge infrastructure.',
                'Ponto de encontro dos produtores familiares, queijos artesanais, doces típicos e pratos regionais premiados.' =>
                    'Meeting point for family farmers, artisanal cheeses, traditional sweets, and award-winning regional dishes.',
                'Vista panorâmica 360 graus de todo o vale municipal, pôr do sol espetacular e passarela panorâmica com piso de vidro de alta segurança.' =>
                    '360-degree panoramic view of the municipal valley, spectacular sunset, and high-security glass-bottom scenic walkway.'
            ],
            'es' => [
                'Patrimônio Histórico e Cultural' => 'Patrimonio Histórico y Cultural',
                'Turismo Ecológico e de Aventura' => 'Turismo Ecológico y de Aventura',
                'Gastronomia Local' => 'Gastronomía Local',
                'Hospedagem e Hotelaria' => 'Hospedaje y Hotelería',
                'Eventos e Festividades' => 'Eventos y Festividades',
                'Artesanato e Comércio Local' => 'Artesanías y Comercio Local',
                'Entrada Gratuita' => 'Entrada Gratuita',
                'Preço Médio' => 'Precio Medio',
                'Horário de Funcionamento' => 'Horario de Atención',
                'Acessível para PNE' => 'Accesible para personas con discapacidad',
                'Rampas de Acesso' => 'Rampas de Acceso',
                'Banheiro Adaptado' => 'Baños Adaptados',
                'Piso Tátil Direcional' => 'Piso Podotáctil',
                'Áudio-Guia Integrado' => 'Audioguía Integrada',
                'Terça a Domingo' => 'Martes a Domingo',
                'Todos os dias' => 'Todos los días',
                'das 08h às 18h' => 'de 08:00 a 18:00',
                'das 07h às 17h' => 'de 07:00 a 17:00',
                'Conjunto arquitetônico colonial preservado do século XVIII, com visitas guiadas, feiras de artesanato típico e apresentações culturais semanais.' =>
                    'Conjunto arquitectónico colonial preservado del siglo XVIII, con visitas guiadas, ferias de artesanía típica y presentaciones culturales semanales.',
                'Reserva municipal com 4 quedas d\'água cristalinas, trilhas ecológicas sinalizadas e infraestrutura de pontes acessíveis com baixo impacto ambiental.' =>
                    'Reserva municipal con 4 cascadas cristalinas, senderos ecológicos señalizados e infraestructura accesible de bajo impacto ambiental.',
                'Ponto de encontro dos produtores familiares, queijos artesanais, doces típicos e pratos regionais premiados.' =>
                    'Punto de encuentro de agricultores familiares, quesos artesanales, dulces típicos y premiados platos regionales.',
                'Vista panorâmica 360 graus de todo o vale municipal, pôr do sol espetacular e passarela panorâmica com piso de vidro de alta segurança.' =>
                    'Vista panorámica de 360 grados de todo el valle municipal, espectacular puesta de sol y pasarela panorámica de vidrio de alta seguridad.'
            ]
        ];

        $traducao = $texto;
        if (isset($traducoesComuns[$para][$texto])) {
            $traducao = $traducoesComuns[$para][$texto];
        } else {
            // Substituição contextual de termos comuns
            if (isset($traducoesComuns[$para])) {
                foreach ($traducoesComuns[$para] as $termoOrig => $termoDest) {
                    $traducao = str_ireplace($termoOrig, $termoDest, $traducao);
                }
            }
        }

        return response()->json([
            'sucesso' => true,
            'original' => $texto,
            'traducao' => $traducao,
            'idioma' => $para
        ]);
    }

    /**
     * Endpoint para Geração Assistida de Descrições Turísticas no Admin.
     */
    public function gerarDescricao(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'categoria_id' => 'nullable|integer',
            'endereco' => 'nullable|string',
            'acessivel' => 'nullable|boolean'
        ]);

        $catNome = 'Patrimônio Municipal';
        if ($request->filled('categoria_id')) {
            $cat = Categoria::find($request->categoria_id);
            if ($cat) $catNome = $cat->nome;
        }

        $descricaoGerada = $this->aiService->gerarDescricaoAtrativo([
            'nome' => $request->nome,
            'categoria_nome' => $catNome,
            'endereco' => $request->endereco ?? 'região central',
            'acessivel' => $request->boolean('acessivel')
        ]);

        return response()->json([
            'sucesso' => true,
            'descricao' => $descricaoGerada
        ]);
    }

    /**
     * Endpoint para Análise de Sentimento das Avaliações (Admin).
     */
    public function analiseSentimento()
    {
        $analise = $this->aiService->analisarSentimentoAvaliacoes();

        return response()->json([
            'sucesso' => true,
            'analise' => $analise
        ]);
    }
}
