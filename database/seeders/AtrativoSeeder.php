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
        $catEco = Categoria::where('slug', 'turismo-ecologico-e-de-aventura')->first() ?? Categoria::first();
        $catHist = Categoria::where('slug', 'patrimonio-historico-e-cultural')->first() ?? Categoria::first();
        $catGastro = Categoria::where('slug', 'gastronomia-local')->first() ?? Categoria::first();
        $catArte = Categoria::where('slug', 'artesanato-e-comercio-local')->first() ?? Categoria::first();
        $catHosp = Categoria::where('slug', 'hospedagem-e-hotelaria')->first() ?? Categoria::first();

        $atrativos = [
            [
                'nome' => 'Farol do Cabo Branco & Ponta do Seixas',
                'descricao' => 'Monumento geográfico emblemático que sinaliza o ponto mais oriental das Américas continentais. Oferece mirante com vista panorâmica do oceano Atlântico, falésias vivas, vegetação litorânea preservada e memorial geográfico.',
                'descricao_curta' => 'O ponto mais oriental das Américas com vista panorâmica para o Atlântico.',
                'categoria_id' => $catHist?->id ?? 2,
                'latitude' => -7.1478,
                'longitude' => -34.7964,
                'endereco' => 'Falésias do Cabo Branco, Ponta do Seixas',
                'cep' => '58045-670',
                'bairro' => 'Cabo Branco',
                'cidade' => 'João Pessoa',
                'uf' => 'PB',
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
                    'coleta_seletiva' => true,
                    'energia_solar' => true,
                    'preservacao_falesias' => true
                ],
                'destaque' => true,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
            ],
            [
                'nome' => 'Centro Cultural São Francisco',
                'descricao' => 'Um dos mais extraordinários complexos barrocos do Brasil colonial, fundado no século XVI. Conta com a Igreja de São Francisco, Convento de Santo Antônio, claustro com rico conjunto de azulejos portugueses, capela dourada e museu de arte sacra popular.',
                'descricao_curta' => 'Obra-prima do barroco brasileiro com azulejaria portuguesa do século XVI.',
                'categoria_id' => $catHist?->id ?? 2,
                'latitude' => -7.1147,
                'longitude' => -34.8872,
                'endereco' => 'Praça São Francisco, s/n - Centro Histórico',
                'cep' => '58010-650',
                'bairro' => 'Centro Histórico',
                'cidade' => 'João Pessoa',
                'uf' => 'PB',
                'horario_funcionamento' => 'Terça a Domingo, das 08h30 às 17h',
                'preco_medio' => 12.00,
                'niveis_acessibilidade' => [
                    'cadeirante' => true,
                    'rampas' => true,
                    'banheiro_adaptado' => true,
                    'piso_tatile' => false,
                    'audio_guia' => true
                ],
                'caracteristicas_esg' => [
                    'sustentavel' => true,
                    'restauro_patrimonial' => true,
                    'educacao_patrimonial' => true
                ],
                'destaque' => true,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
            ],
            [
                'nome' => 'Estação Cabo Branco Ciência, Cultura e Artes',
                'descricao' => 'Projetada pelo consagrado arquiteto Oscar Niemeyer, a Estação Cabo Branco reúne arte contemporânea, ciência, tecnologia e educação. O complexo abriga torre mirante envidraçada, auditório, planetário, praça de esculturas e terraço panorâmico.',
                'descricao_curta' => 'Complexo cultural e arquitetônico assinado por Oscar Niemeyer.',
                'categoria_id' => $catHist?->id ?? 2,
                'latitude' => -7.1492,
                'longitude' => -34.7997,
                'endereco' => 'Av. João Cirilo da Silva, s/n - Altiplano Cabo Branco',
                'cep' => '58046-010',
                'bairro' => 'Altiplano',
                'cidade' => 'João Pessoa',
                'uf' => 'PB',
                'horario_funcionamento' => 'Terça a Domingo, das 09h às 18h',
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
                    'energia_solar' => true,
                    'educacao_ambiental' => true
                ],
                'destaque' => true,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
            ],
            [
                'nome' => 'Praia de Tambaú & Feirinha de Artesanato',
                'descricao' => 'O coração turístico da orla pessoense. Conta com calçadão arborizado, quiosques gastronômicos, feirinha de artesanato com produtos em renda e algodão colorido, ciclovia e embarque para as piscinas naturais de Picãozinho.',
                'descricao_curta' => 'Orla vibrante com feira artesanal, calçadão e piscinas naturais.',
                'categoria_id' => $catArte?->id ?? 6,
                'latitude' => -7.1158,
                'longitude' => -34.8239,
                'endereco' => 'Av. Almirante Tamandaré, s/n - Tambaú',
                'cep' => '58039-010',
                'bairro' => 'Tambaú',
                'cidade' => 'João Pessoa',
                'uf' => 'PB',
                'horario_funcionamento' => 'Acesso público 24 horas; Feirinha das 16h às 23h',
                'preco_medio' => 0.00,
                'niveis_acessibilidade' => [
                    'cadeirante' => true,
                    'rampas' => true,
                    'banheiro_adaptado' => true,
                    'piso_tatile' => true,
                    'audio_guia' => false
                ],
                'caracteristicas_esg' => [
                    'sustentavel' => true,
                    'coleta_seletiva' => true,
                    'incentivo_comercio_local' => true
                ],
                'destaque' => true,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
            ],
            [
                'nome' => 'Praia do Cabo Branco & Calçadão Ecológico',
                'descricao' => 'Praia urbana famosa pela tranquilidade, ampla faixa de areia dourada e coqueirais. Diariamente, das 5h às 8h da manhã, a avenida beira-mar é fechada exclusivamente para caminhadas, corrida e ciclismo.',
                'descricao_curta' => 'Extensa orla para esportes, ciclovia e banho de mar em águas mornas.',
                'categoria_id' => $catEco?->id ?? 1,
                'latitude' => -7.1350,
                'longitude' => -34.8190,
                'endereco' => 'Av. Cabo Branco - Orla',
                'cep' => '58045-010',
                'bairro' => 'Cabo Branco',
                'cidade' => 'João Pessoa',
                'uf' => 'PB',
                'horario_funcionamento' => 'Acesso público livre',
                'preco_medio' => 0.00,
                'niveis_acessibilidade' => [
                    'cadeirante' => true,
                    'rampas' => true,
                    'banheiro_adaptado' => true,
                    'piso_tatile' => true,
                    'audio_guia' => false
                ],
                'caracteristicas_esg' => [
                    'sustentavel' => true,
                    'mobilidade_ativa' => true,
                    'coleta_seletiva' => true
                ],
                'destaque' => true,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
            ],
            [
                'nome' => 'Praia do Bessa & Piscinas do Caribessa',
                'descricao' => 'Conhecida carinhosamente como "Caribessa" pelas suas águas calmas, mornas e transparentes protegidas por barreiras de corais. Excelente ponto para caiaque, stand-up paddle e mergulho de observação da vida marinha.',
                'descricao_curta' => 'Águas calmas e cristalinas protegidas por corais ideais para SUP.',
                'categoria_id' => $catEco?->id ?? 1,
                'latitude' => -7.0680,
                'longitude' => -34.8340,
                'endereco' => 'Av. Arthur Monteiro de Paiva - Bessa',
                'cep' => '58035-240',
                'bairro' => 'Bessa',
                'cidade' => 'João Pessoa',
                'uf' => 'PB',
                'horario_funcionamento' => 'Acesso público livre',
                'preco_medio' => 0.00,
                'niveis_acessibilidade' => [
                    'cadeirante' => true,
                    'rampas' => true,
                    'banheiro_adaptado' => false,
                    'piso_tatile' => false,
                    'audio_guia' => false
                ],
                'caracteristicas_esg' => [
                    'sustentavel' => true,
                    'protecao_marinha' => true,
                    'ecoturismo_responsavel' => true
                ],
                'destaque' => true,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
            ],
            [
                'nome' => 'Parque Zoobotânico Arruda Câmara (A Bica)',
                'descricao' => 'Autêntico santuário ecológico de Mata Atlântica encravado no centro urbano de João Pessoa. O parque conta com a histórica Fonte de Santo Antônio (século XVIII), lago com pedalinhos, alamedas arborizadas centenárias e viveiros conservacionistas.',
                'descricao_curta' => 'Reserva de Mata Atlântica urbana com fontes históricas e lago.',
                'categoria_id' => $catEco?->id ?? 1,
                'latitude' => -7.1235,
                'longitude' => -34.8778,
                'endereco' => 'Av. Gouveia Nóbrega, s/n - Roger',
                'cep' => '58020-560',
                'bairro' => 'Roger',
                'cidade' => 'João Pessoa',
                'uf' => 'PB',
                'horario_funcionamento' => 'Terça a Domingo, das 08h às 17h',
                'preco_medio' => 3.00,
                'niveis_acessibilidade' => [
                    'cadeirante' => true,
                    'rampas' => true,
                    'banheiro_adaptado' => true,
                    'piso_tatile' => true,
                    'audio_guia' => true
                ],
                'caracteristicas_esg' => [
                    'sustentavel' => true,
                    'preservacao_biodiversidade' => true,
                    'reflorestamento' => true,
                    'carbono_neutro' => true
                ],
                'destaque' => true,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
            ],
            [
                'nome' => 'Hotel Globo & Praça Antenor Navarro',
                'descricao' => 'Construído em 1929 no coração do Centro Histórico, o Hotel Globo preserva mobília de época e terraço panorâmico com a vista mais poética do Pôr do Sol no Rio Sanhauá, rio onde nasceu a cidade de João Pessoa em 1585.',
                'descricao_curta' => 'Mirante histórico e arquitetura eclética com vista do pôr do sol no Rio Sanhauá.',
                'categoria_id' => $catHist?->id ?? 2,
                'latitude' => -7.1128,
                'longitude' => -34.8885,
                'endereco' => 'Praça de São Frei Pedro Gonçalves, s/n - Varadouro',
                'cep' => '58010-610',
                'bairro' => 'Varadouro',
                'cidade' => 'João Pessoa',
                'uf' => 'PB',
                'horario_funcionamento' => 'Diariamente, das 09h às 18h',
                'preco_medio' => 0.00,
                'niveis_acessibilidade' => [
                    'cadeirante' => true,
                    'rampas' => true,
                    'banheiro_adaptado' => true,
                    'piso_tatile' => false,
                    'audio_guia' => true
                ],
                'caracteristicas_esg' => [
                    'sustentavel' => true,
                    'patrimonio_historico' => true,
                    'acesso_democratizado' => true
                ],
                'destaque' => true,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
            ],
            [
                'nome' => 'Mercado de Artesanato Paraibano (MAP)',
                'descricao' => 'O maior centro de comercialização de artesanato genuíno da Paraíba. Mais de 150 boxes especializados em rendas de labirinto, renascença, bordados, couro, cachaças premiadas do brejo paraibano e peças exclusivas em algodão colorido agroecológico.',
                'descricao_curta' => 'Mais de 150 lojas com o melhor do artesanato, rendas e produtos típicos.',
                'categoria_id' => $catArte?->id ?? 6,
                'latitude' => -7.1165,
                'longitude' => -34.8290,
                'endereco' => 'Av. Sen. Ruy Carneiro, 241 - Tambaú',
                'cep' => '58039-010',
                'bairro' => 'Tambaú',
                'cidade' => 'João Pessoa',
                'uf' => 'PB',
                'horario_funcionamento' => 'Segunda a Sábado, das 09h às 19h; Domingo das 10h às 18h',
                'preco_medio' => 45.00,
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
                    'geracao_renda_feminina' => true
                ],
                'destaque' => true,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
            ],
            [
                'nome' => 'Parque da Lagoa Solon de Lucena',
                'descricao' => 'Principal cartão-postal urbano e parque central da cidade. Rodeado por dezenas de palmeiras-imperiais centenárias, o parque possui espelho d\'água, pista de corrida, ciclovia, quadras poliesportivas, praça de alimentação e fonte luminosa com projeções aquáticas.',
                'descricao_curta' => 'Parque central com espelho d\'água, palmeiras-imperiais e fonte luminosa.',
                'categoria_id' => $catEco?->id ?? 1,
                'latitude' => -7.1215,
                'longitude' => -34.8825,
                'endereco' => 'Parque Solon de Lucena, s/n - Centro',
                'cep' => '58013-130',
                'bairro' => 'Centro',
                'cidade' => 'João Pessoa',
                'uf' => 'PB',
                'horario_funcionamento' => 'Aberto 24 horas',
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
                    'arborizacao_urbana' => true,
                    'coleta_seletiva' => true
                ],
                'destaque' => true,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
            ],
            [
                'nome' => 'Piscinas Naturais do Seixas',
                'descricao' => 'Bancadas de corais com águas calmas, mornas e cristalinas situadas no litoral oriental. O passeio de catamarã durante a maré baixa permite nadar com peixes tropicais coloridos em um aquário natural inesquecível.',
                'descricao_curta' => 'Aquário natural de corais e peixes coloridos com passeios de catamarã.',
                'categoria_id' => $catEco?->id ?? 1,
                'latitude' => -7.1610,
                'longitude' => -34.7930,
                'endereco' => 'Praia do Seixas - Ponto de Embarque',
                'cep' => '58045-560',
                'bairro' => 'Praia do Seixas',
                'cidade' => 'João Pessoa',
                'uf' => 'PB',
                'horario_funcionamento' => 'Passeios diários conforme a tábua de marés (maré baixa)',
                'preco_medio' => 60.00,
                'niveis_acessibilidade' => [
                    'cadeirante' => false,
                    'rampas' => false,
                    'banheiro_adaptado' => false,
                    'piso_tatile' => false,
                    'audio_guia' => false
                ],
                'caracteristicas_esg' => [
                    'sustentavel' => true,
                    'turismo_marinho_sustentavel' => true,
                    'limite_capacidade_diaria' => true
                ],
                'destaque' => true,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
            ],
            [
                'nome' => 'Casa da Pólvora & Centro Cultural',
                'descricao' => 'Erguida em 1710 por ordem da Coroa Portuguesa, a Casa da Pólvora é um marco da arquitetura militar colonial. Situada no alto da Ladeira de São Francisco, oferece museu da cidade e mirante espetacular com visão panorâmica do Vale do Sanhauá.',
                'descricao_curta' => 'Marco da arquitetura militar de 1710 com mirante para o vale histórico.',
                'categoria_id' => $catHist?->id ?? 2,
                'latitude' => -7.1120,
                'longitude' => -34.8860,
                'endereco' => 'Ladeira de São Francisco, s/n - Centro Histórico',
                'cep' => '58010-660',
                'bairro' => 'Centro Histórico',
                'cidade' => 'João Pessoa',
                'uf' => 'PB',
                'horario_funcionamento' => 'Segunda a Sexta, das 09h às 17h; Sábado das 10h às 16h',
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
                    'preservacao_patrimonial' => true
                ],
                'destaque' => true,
                'ativo' => true,
                'status_aprovacao' => 'aprovado',
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
