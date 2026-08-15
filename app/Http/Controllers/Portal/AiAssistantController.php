<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\AiConversa;
use App\Models\AiPlanoTurismo;
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
     * Responde dúvidas em linguagem natural e persiste no banco se o usuário estiver autenticado.
     */
    public function chat(Request $request)
    {
        $request->validate([
            'mensagem' => 'required|string|max:500',
            'idioma' => 'nullable|string|in:pt,en,es',
            'sessao_id' => 'nullable|string|max:64',
        ]);

        $pergunta = $request->input('mensagem');
        $idioma = $request->input('idioma', 'pt');
        $sessaoId = $request->input('sessao_id') ?? 'anon-' . session()->getId();
        $user = $request->user();

        // 1. Processar a pergunta pelo serviço de IA
        $resposta = $this->aiService->responderDuvidaTurista($pergunta, $idioma, $user);

        // 2. Persistir conversa no banco se o usuário estiver autenticado
        if ($user) {
            // Salvar mensagem do usuário
            AiConversa::create([
                'user_id' => $user->id,
                'sessao_id' => $sessaoId,
                'remetente' => 'user',
                'mensagem' => $pergunta,
                'idioma' => $idioma,
            ]);

            // Salvar resposta do bot
            AiConversa::create([
                'user_id' => $user->id,
                'sessao_id' => $sessaoId,
                'remetente' => 'bot',
                'mensagem' => $resposta['resposta'],
                'dados_extras' => [
                    'cards' => $resposta['cards'] ?? [],
                    'sugestoes' => $resposta['sugestoes'] ?? [],
                    'dados_extras' => $resposta['dados_extras'] ?? null,
                ],
                'idioma' => $idioma,
            ]);
        }

        return response()->json([
            'sucesso' => true,
            'sessao_id' => $sessaoId,
            'dados' => $resposta
        ]);
    }

    /**
     * Carrega o histórico de mensagens salvas da sessão do usuário autenticado.
     */
    public function carregarHistorico(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['sucesso' => true, 'mensagens' => []]);
        }

        $sessaoId = $request->input('sessao_id');

        $query = AiConversa::where('user_id', $user->id);
        if ($sessaoId) {
            $query->where('sessao_id', $sessaoId);
        }

        $conversas = $query->orderBy('created_at', 'asc')->get();

        $mensagensFormatted = $conversas->map(function ($c) {
            return [
                'id' => $c->id,
                'remetente' => $c->remetente,
                'mensagem' => $c->mensagem,
                'dados_extras' => $c->dados_extras,
                'idioma' => $c->idioma,
                'data' => $c->created_at->format('H:i'),
            ];
        });

        return response()->json([
            'sucesso' => true,
            'mensagens' => $mensagensFormatted
        ]);
    }

    /**
     * Limpa o histórico de chat da sessão ativa.
     */
    public function limparHistorico(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $sessaoId = $request->input('sessao_id');
            $query = AiConversa::where('user_id', $user->id);
            if ($sessaoId) {
                $query->where('sessao_id', $sessaoId);
            }
            $query->delete();
        }

        return response()->json(['sucesso' => true, 'mensagem' => 'Histórico limpo com sucesso.']);
    }

    // --- PAINEL DE PLANOS DE TURISMO PERSONALIZADOS ---

    /**
     * Salva um novo plano de turismo gerado pela IA na conta do turista.
     */
    public function salvarPlano(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:1000',
            'dias' => 'required|integer|min:1|max:30',
            'itens' => 'required|array',
            'preferencias' => 'nullable|array',
            'sessao_chat_id' => 'nullable|string|max:64',
        ]);

        $user = $request->user();
        if (!$user) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'É necessário estar autenticado para salvar um plano de viagem.'
            ], 401);
        }

        $plano = AiPlanoTurismo::create([
            'user_id' => $user->id,
            'titulo' => $request->titulo,
            'descricao' => $request->descricao ?? 'Plano personalizado criado com o Guia PITE IA.',
            'dias' => $request->dias,
            'itens' => $request->itens,
            'preferencias' => $request->preferencias,
            'status' => 'ativo',
            'sessao_chat_id' => $request->sessao_chat_id,
        ]);

        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Plano de turismo salvo com sucesso!',
            'plano' => $plano
        ], 201);
    }

    /**
     * Lista os planos salvos do usuário autenticado.
     */
    public function listarPlanos(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['sucesso' => false, 'mensagem' => 'Não autenticado.'], 401);
        }

        $planos = AiPlanoTurismo::doUsuario($user->id)->latest()->get();

        return response()->json([
            'sucesso' => true,
            'planos' => $planos
        ]);
    }

    /**
     * Retorna os detalhes de um plano específico.
     */
    public function detalharPlano(int $id, Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['sucesso' => false, 'mensagem' => 'Não autenticado.'], 401);
        }

        $plano = AiPlanoTurismo::doUsuario($user->id)->findOrFail($id);

        return response()->json([
            'sucesso' => true,
            'plano' => $plano,
            'itens_por_dia' => $plano->itensPorDia()
        ]);
    }

    /**
     * Atualiza itens ou metadados de um plano de turismo existente.
     */
    public function atualizarPlano(int $id, Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['sucesso' => false, 'mensagem' => 'Não autenticado.'], 401);
        }

        $plano = AiPlanoTurismo::doUsuario($user->id)->findOrFail($id);

        $request->validate([
            'titulo' => 'sometimes|string|max:255',
            'descricao' => 'sometimes|nullable|string',
            'status' => 'sometimes|in:rascunho,ativo,concluido,arquivado',
            'itens' => 'sometimes|array',
        ]);

        $plano->update($request->only(['titulo', 'descricao', 'status', 'itens']));

        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Plano atualizado com sucesso!',
            'plano' => $plano
        ]);
    }

    /**
     * Remove ou arquiva um plano salvo.
     */
    public function excluirPlano(int $id, Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['sucesso' => false, 'mensagem' => 'Não autenticado.'], 401);
        }

        $plano = AiPlanoTurismo::doUsuario($user->id)->findOrFail($id);
        $plano->delete();

        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Plano removido com sucesso.'
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

        $traducoesComuns = [
            'en' => [
                'Patrimônio Histórico e Cultural' => 'Historical and Cultural Heritage',
                'Turismo Ecológico e de Aventura' => 'Ecological and Adventure Tourism',
                'Gastronomia Local' => 'Local Gastronomy',
                'Hospedagem e Hotelaria' => 'Hospitality & Hotels',
                'Eventos e Festividades' => 'Events & Festivals',
                'Artesanato e Comércio Local' => 'Handicraft & Local Commerce',
            ],
            'es' => [
                'Patrimônio Histórico e Cultural' => 'Patrimonio Histórico y Cultural',
                'Turismo Ecológico e de Aventura' => 'Turismo Ecológico y de Aventura',
                'Gastronomia Local' => 'Gastronomía Local',
                'Hospedagem e Hotelaria' => 'Hospedaje y Hotelería',
                'Eventos e Festividades' => 'Eventos y Festividades',
                'Artesanato e Comércio Local' => 'Artesanías y Comercio Local',
            ]
        ];

        $traducao = $texto;
        if (isset($traducoesComuns[$para][$texto])) {
            $traducao = $traducoesComuns[$para][$texto];
        } else {
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
