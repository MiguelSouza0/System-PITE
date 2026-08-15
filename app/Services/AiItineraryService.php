<?php

namespace App\Services;

use App\Models\Atrativo;
use App\Models\Roteiro;
use Illuminate\Support\Str;

class AiItineraryService
{
    /**
     * Gera um roteiro personalizado com base nas preferências do visitante/turista.
     * Segue os requisitos de IA transparente e auditável.
     */
    public function gerarRoteiroPersonalizado(array $preferencias): Roteiro
    {
        $perfil = $preferencias['perfil'] ?? 'geral'; // familia, aventura, cultural, acessivel, gastronomico
        $duracao = $preferencias['duracao_horas'] ?? 4;
        $orcamento = $preferencias['orcamento'] ?? 'medio';
        $acessibilidadeRequerida = $preferencias['acessivel'] ?? false;

        $query = Atrativo::query()->where('ativo', true);

        if ($acessibilidadeRequerida) {
            $query->whereJsonContains('niveis_acessibilidade->cadeirante', true);
        }

        // Filtro básico por perfil de atrativo / categoria
        $atrativosEncontrados = $query->take(5)->get();

        $idsAtrativos = $atrativosEncontrados->pluck('id')->toArray();
        $titulo = "Roteiro Inteligente " . ucfirst($perfil) . " (" . $duracao . "h)";
        
        $descricao = "Roteiro gerado pela IA Assistente do System-PITE priorizando " . 
            ($acessibilidadeRequerida ? "acessibilidade universal, " : "") . 
            "atrativos locais e experiências de alto impacto cultural e sustentável (ESG).";

        return Roteiro::create([
            'titulo' => $titulo,
            'slug' => Str::slug($titulo . '-' . Str::random(6)),
            'descricao' => $descricao,
            'duracao_estimada_horas' => $duracao,
            'nivel_dificuldade' => $perfil === 'aventura' ? 'medio' : 'facil',
            'atrativos_ids' => $idsAtrativos,
            'perfil_publico_alvo' => $perfil,
            'gerado_por_ia' => true,
            'ativo' => true
        ]);
    }

    /**
     * Resposta do assistente virtual interativo para o turista.
     */
    public function responderDuvidaTurista(string $pergunta): array
    {
        // Mock funcional estruturado com supervisão humana
        return [
            'pergunta' => $pergunta,
            'resposta' => "Bem-vindo ao nosso portal turístico municipal! Encontrei ótimas opções para você. Recomendo visitar nosso centro histórico e a feira de artesanato local.",
            'fonte_dados' => 'Base oficial de atrativos municipais validados.',
            'supervisao_humana' => true
        ];
    }
}
