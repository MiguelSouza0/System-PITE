# 📄 Documentação Completa — System-PITE

## Plataforma Inteligente de Turismo Municipal

> **Desafio Destino Turístico Municipal** — Transformando territórios em experiências turísticas inteligentes.
> Patrocinador: Máxima Tecnologia LTDA

---

## 📑 Sumário

1. [Visão Geral](#1-visão-geral)
2. [Objeto e Finalidade](#2-objeto-e-finalidade)
3. [Arquitetura e Stack Tecnológica](#3-arquitetura-e-stack-tecnológica)
4. [Módulos Funcionais](#4-módulos-funcionais)
5. [Modelo de Dados](#5-modelo-de-dados)
6. [Requisitos Não-Funcionais](#6-requisitos-não-funcionais)
7. [Segurança e LGPD](#7-segurança-e-lgpd)
8. [Critérios de Avaliação](#8-critérios-de-avaliação)
9. [Entregáveis](#9-entregáveis)
10. [Glossário](#10-glossário)

---

## 1. Visão Geral

### 1.1 Contexto

O **System-PITE** é uma plataforma digital inteligente de turismo municipal, concebida no âmbito do Hackaton **"Destino Turístico Municipal"**. A proposta integra, em um único ecossistema digital, as necessidades de três atores principais:

| Ator | Papel |
|------|-------|
| **Turista** | Consumidor final — busca informações, roteiros, serviços e experiências |
| **Empreendedor Local** | Oferece serviços turísticos — hospedagem, gastronomia, guias, artesanato |
| **Administração Pública** | Gestão, monitoramento, indicadores e políticas públicas |

### 1.2 Premissas Fundamentais

- O turismo municipal deve ser tratado como **política pública estruturante** (emprego, renda, inclusão, cultura).
- A plataforma deve ir **além de um portal institucional** — deve cobrir toda a jornada turística.
- A solução deve ser **escalável e replicável** para municípios de diferentes portes.
- Uso de **IA responsável** com supervisão humana e transparência.

---

## 2. Objeto e Finalidade

### 2.1 Objeto

Desenvolvimento de plataforma digital composta por:

1. **Portal Público** — voltado ao turista
2. **Área do Empreendedor** — para prestadores de serviços locais
3. **Painel Administrativo** — para a gestão municipal

### 2.2 Finalidades

- Ampliar a visibilidade do município e facilitar o planejamento de viagens
- Prolongar a permanência do visitante e estimular o consumo local
- Fortalecer pequenos negócios da cadeia turística
- Fornecer inteligência estratégica à Administração Pública
- Transformar dados de acesso e interações em indicadores gerenciais

---

## 3. Arquitetura e Stack Tecnológica

### 3.1 Tecnologias Obrigatórias (Seção 23 do Edital)

| Camada | Tecnologia | Observação |
|--------|-----------|------------|
| **Backend** | PHP + Laravel (versão estável mais recente) | Arquitetura MVC |
| **Frontend** | Bootstrap (versão estável mais recente) | Responsivo e acessível |
| **Banco de Dados** | PostgreSQL (versão estável mais recente) | Compatível com Laravel |
| **Markup/Estilo** | HTML5, CSS3, JavaScript | Versões atuais |
| **Versionamento** | Git | Controle de código-fonte |

### 3.2 Padrões de Desenvolvimento

- Arquitetura **MVC** (Model-View-Controller)
- **Migrations** e **Seeders** para criação e carga do banco
- Chaves primárias, estrangeiras, índices e restrições
- Codificação **UTF-8**
- Validação de dados no **frontend e backend**
- Proteção contra **SQL Injection, XSS, CSRF**
- Compatibilidade com navegadores atuais
- Dependências atualizadas e sem vulnerabilidades conhecidas
- Código organizado, documentado e de fácil manutenção

### 3.3 Diagrama de Arquitetura (Alto Nível)

```
┌─────────────────────────────────────────────────────┐
│                    FRONTEND                         │
│  Bootstrap · HTML5 · CSS3 · JavaScript              │
│  ┌──────────┐  ┌──────────────┐  ┌───────────────┐  │
│  │  Portal   │  │    Área      │  │    Painel     │  │
│  │  Turista  │  │ Empreendedor │  │ Administrativo│  │
│  └──────────┘  └──────────────┘  └───────────────┘  │
└──────────────────────┬──────────────────────────────┘
                       │ HTTP/HTTPS
┌──────────────────────┴──────────────────────────────┐
│                   BACKEND (Laravel)                  │
│  Controllers · Models · Services · Middleware        │
│  ┌─────────┐  ┌──────────┐  ┌────────────────────┐  │
│  │  API IA  │  │  Mapas   │  │  Relatórios/Export │  │
│  │(Externo) │  │(Externo) │  │   (PDF/Planilha)  │  │
│  └─────────┘  └──────────┘  └────────────────────┘  │
└──────────────────────┬──────────────────────────────┘
                       │
┌──────────────────────┴──────────────────────────────┐
│               PostgreSQL Database                    │
│  Migrations · Seeders · Índices · FK · Auditoria     │
└─────────────────────────────────────────────────────┘
```

---

## 4. Módulos Funcionais

### 4.1 Portal Público do Turista (Seção 4)

**Página Inicial:**
- Interface moderna, intuitiva e responsiva
- Acesso rápido: **O que fazer · Onde ficar · Onde comer · Como se deslocar · Eventos**

**Busca Inteligente:**
- Busca por palavras-chave, categorias, localização, datas, interesses, orçamento
- Busca por **linguagem natural** (ex: "passeios gratuitos", "locais acessíveis")
- Filtros por perfil do visitante e duração da atividade

**Atrativos Turísticos:**

Categorias: histórico, cultural, religioso, gastronômico, rural, ecológico, esportivo, náutico, aventura, negócios, eventos, saúde, lazer.

Cada atrativo contém:

| Campo | Descrição |
|-------|-----------|
| Descrição e contexto histórico | Texto detalhado |
| Endereço e geolocalização | Mapa interativo |
| Horário de funcionamento | Dias e horários |
| Formas de acesso | Transporte, estacionamento |
| Tempo médio de visitação | Estimativa |
| Valores cobrados | Ingressos, taxas |
| Contatos | Telefone, e-mail, site |
| Acessibilidade | Rampas, elevadores, Libras |
| Restrições e segurança | Orientações |
| Mídias | Fotos, vídeos, 360° |
| Avaliações | Notas e comentários |
| Serviços próximos | Restaurantes, hospedagens |

**Estabelecimentos e Serviços:**
- Restaurantes, bares, cafeterias, mercados, feiras
- Meios de hospedagem, guias turísticos, agências
- Transportadores, artesãos, artistas, produtores culturais
- Cadastros validados pela Administração Municipal

**Agenda de Eventos:**
- Pesquisa por período, localidade, categoria, faixa etária, gratuidade, acessibilidade
- Informações: programação, local, horário, organizador, ingressos, capacidade, alterações

**Utilidade Pública:**
- Unidades de saúde, hospitais, farmácias
- Postos policiais, Corpo de Bombeiros, defesa civil
- Terminais de transporte, táxis, aplicativos
- Centros de atendimento ao turista

---

### 4.2 Roteiros Turísticos Inteligentes (Seção 5)

- Roteiros **predefinidos** e **personalizados**
- Estruturados por: tema, duração, localização, dificuldade, transporte, acessibilidade, orçamento
- Cada roteiro: pontos de partida/chegada, atrativos, ordem de visitação, tempo estimado, distância, serviços no caminho
- **IA** cria roteiros personalizados com base nas preferências do usuário
- Integração com **mapas interativos** e geolocalização
- **Modo offline** para áreas com conectividade limitada (mapas, descrições, rotas, telefones de emergência)

---

### 4.3 Inteligência Artificial (Seção 6)

| Funcionalidade | Descrição |
|---------------|-----------|
| Assistente Virtual | Responde perguntas sobre atrativos, eventos, hospedagem, gastronomia |
| Linguagem Natural | Interpreta solicitações do turista |
| Tradução Automática | Tradução multilíngue de conteúdos |
| Geração de Descrições | Criação assistida de textos para atrativos |
| Classificação de Imagens | Categorização automática de fotos |
| Análise de Avaliações | Sentimento e temas das avaliações |
| Audiodescrição | Acessibilidade para deficientes visuais |
| Roteiros Personalizados | Criação baseada em preferências |

**Princípios obrigatórios de IA:**
- Transparência — conteúdo gerado por IA deve ser identificado
- Supervisão humana — IA não substitui validação humana
- Proteção de dados e prevenção de discriminação
- Base oficial de dados como fonte primária

---

### 4.4 Acessibilidade e Inclusão (Seção 7)

- Navegação por teclado
- Compatibilidade com leitores de tela
- Contraste adequado e ampliação de fontes
- Descrição textual de imagens (alt text)
- Legendas em vídeos e audiodescrição
- Campos específicos de acessibilidade nos cadastros (rampas, elevadores, banheiros adaptados, piso tátil, Libras, cardápio acessível)
- Filtro de busca por experiências acessíveis

---

### 4.5 Conteúdos Imersivos e Audiovisuais (Seção 8)

- Fotografias, vídeos, imagens aéreas (drones)
- Visitas virtuais e visualização 360°
- Realidade aumentada
- Áudios, podcasts e conteúdos educativos
- **QR Codes** nos locais de visitação (conteúdos históricos, culturais, ambientais, segurança)
- Controle de autoria e autorização de uso

---

### 4.6 Área dos Empreendedores (Seção 9)

- Cadastro de empreendedores, guias, artesãos, restaurantes, hospedagens
- Inserção e atualização de informações, horários, imagens, documentos
- Acompanhamento do status de aprovação
- **Nenhum cadastro publicado sem validação municipal**
- Registro de responsável, data da última atualização, situação de regularidade
- Alertas de informações desatualizadas e documentos próximos do vencimento
- Possibilidade de **selo de fornecedor validado**

---

### 4.7 Painel Administrativo (Seção 10)

**Gestão de Conteúdos:**
- CRUD completo (inclusão, edição, publicação, desativação, exclusão lógica)
- Trilha de auditoria (usuário, data, horário, operação)

**Gestão de Cadastros:**
- Status: pendentes, aprovados, rejeitados, suspensos, desatualizados
- Alertas: informações incompletas, eventos próximos, documentos vencidos, avaliações críticas

**Perfis de Acesso:**

| Perfil | Acesso |
|--------|--------|
| Prefeito / Secretário de Turismo | Indicadores executivos e estratégicos |
| Servidor de Conteúdo | Gestão de atrativos, eventos, mídias |
| Servidor de Cadastro | Aprovação de empreendedores |
| Servidor de Atendimento | Reclamações, ocorrências |
| Servidor de Fiscalização | Auditorias, verificações |

**Notificações:**
- Envio por critérios de localização, idioma, interesse, evento ou emergência
- Divulgação de programação cultural, alertas climáticos, interdições, campanhas

---

### 4.8 Dashboard Executivo (Seção 11)

- Acessos totais, visitantes únicos, recorrentes, tempo médio, taxa de retorno
- Páginas mais visitadas, pesquisas realizadas, roteiros mais consultados
- Origem geográfica dos acessos (município, estado, país)
- Idiomas, dispositivos e canais de origem
- Comparações mensais, trimestrais e anuais
- Indicadores por categoria turística

---

### 4.9 Indicadores Econômicos e Territoriais (Seções 12–13)

- Empreendedores cadastrados e distribuição territorial
- Estimativas de movimentação econômica (claramente identificadas como projeções)
- Permanência e gasto médio do turista
- Ocupação de hospedagens e participação em eventos

**Inteligência Territorial e Mapas de Calor:**
- Concentração de interesse turístico por região
- Bairros com menor presença de equipamentos
- Rotas mais consultadas
- Apoio a decisões sobre sinalização, infraestrutura, mobilidade e segurança
- Dados de localização **agregados e anonimizados**

---

### 4.10 Indicadores de Comportamento e IA (Seção 14)

- Perguntas mais realizadas ao assistente virtual
- Temas pesquisados e atrativos mais sugeridos
- Análise de sentimento de avaliações
- Organização de reclamações por tema, local, período e gravidade
- Diferenciação de avaliações legítimas vs. conteúdos suspeitos/ofensivos

---

### 4.11 Segurança do Turista (Seção 15)

- Contatos de emergência e orientações preventivas
- Alertas climáticos, interdições, riscos ambientais
- Registro de ocorrências e incidentes (local, categoria, data, gravidade, atendimento)
- Comunicados emergenciais
- **Não substitui canais oficiais de emergência**

---

### 4.12 Indicadores ESG (Seção 16)

| Pilar | Indicadores |
|-------|------------|
| **Ambiental** | Redução de materiais impressos, QR Codes, áreas protegidas, capacidade de visitação |
| **Social** | Acessibilidade, inclusão de pequenos negócios, comunidades tradicionais, valorização cultural |
| **Governança** | Processos de aprovação, trilhas de auditoria, reclamações, providências, relatórios |

Alinhamento com **ODS**: trabalho decente, crescimento econômico, redução de desigualdades, cidades sustentáveis, consumo responsável, preservação do patrimônio.

---

### 4.13 Relatórios e Captação de Recursos (Seção 17)

- Relatórios consolidados filtrados por período, categoria, região, atrativo, evento, público
- Exportação em **PDF** e **planilhas eletrônicas**
- Dados: acessos, origem dos visitantes, atrativos, eventos, empreendedores, acessibilidade, sustentabilidade, reclamações
- Apoio a propostas para: Ministério do Turismo, Embratur, Sudene, Banco do Nordeste, BNDES, Caixa, Sebrae
- **Não afirma automaticamente que o município atende requisitos de financiamento**

---

## 5. Modelo de Dados

### 5.1 Entidades Principais

```
┌──────────────┐     ┌──────────────┐     ┌──────────────────┐
│   Usuarios   │     │   Atrativos  │     │     Eventos      │
├──────────────┤     ├──────────────┤     ├──────────────────┤
│ id (PK)      │     │ id (PK)      │     │ id (PK)          │
│ nome         │     │ nome         │     │ titulo           │
│ email        │     │ descricao    │     │ descricao        │
│ senha (hash) │     │ contexto_hist│     │ data_inicio      │
│ perfil (FK)  │     │ categoria_id │     │ data_fim         │
│ ativo        │     │ endereco     │     │ local            │
│ created_at   │     │ latitude     │     │ organizador      │
│ updated_at   │     │ longitude    │     │ capacidade       │
└──────────────┘     │ horario_func │     │ gratuito         │
                     │ valor        │     │ acessibilidade   │
┌──────────────┐     │ acessibilid. │     │ categoria_id(FK) │
│   Perfis     │     │ status       │     │ status           │
├──────────────┤     │ created_at   │     └──────────────────┘
│ id (PK)      │     └──────────────┘
│ nome         │                          ┌──────────────────┐
│ permissoes   │     ┌──────────────┐     │ Empreendedores   │
└──────────────┘     │  Categorias  │     ├──────────────────┤
                     ├──────────────┤     │ id (PK)          │
┌──────────────┐     │ id (PK)      │     │ razao_social     │
│  Avaliacoes  │     │ nome         │     │ cnpj_cpf         │
├──────────────┤     │ icone        │     │ tipo_servico     │
│ id (PK)      │     │ descricao    │     │ contato          │
│ atrativo_id  │     └──────────────┘     │ status_aprovacao │
│ usuario_id   │                          │ selo_validado    │
│ nota         │     ┌──────────────┐     │ docs_vencimento  │
│ comentario   │     │   Roteiros   │     │ aprovado_por(FK) │
│ sentimento   │     ├──────────────┤     └──────────────────┘
│ moderado     │     │ id (PK)      │
│ created_at   │     │ titulo       │     ┌──────────────────┐
└──────────────┘     │ tema         │     │   Ocorrencias    │
                     │ duracao      │     ├──────────────────┤
┌──────────────┐     │ dificuldade  │     │ id (PK)          │
│    Midias    │     │ transporte   │     │ local            │
├──────────────┤     │ acessivel    │     │ categoria        │
│ id (PK)      │     │ orcamento    │     │ data             │
│ tipo         │     │ distancia_km │     │ gravidade        │
│ url          │     │ personalizado│     │ situacao         │
│ autoria      │     └──────────────┘     │ descricao        │
│ autorizado   │                          └──────────────────┘
│ entidade_id  │
│ entidade_tipo│     ┌──────────────┐     ┌──────────────────┐
└──────────────┘     │ Auditoria    │     │  Notificacoes    │
                     ├──────────────┤     ├──────────────────┤
                     │ id (PK)      │     │ id (PK)          │
                     │ usuario_id   │     │ titulo           │
                     │ acao         │     │ mensagem         │
                     │ tabela       │     │ tipo             │
                     │ registro_id  │     │ criterio_envio   │
                     │ dados_antes  │     │ enviado_em       │
                     │ dados_depois │     └──────────────────┘
                     │ ip           │
                     │ created_at   │
                     └──────────────┘
```

### 5.2 Relacionamentos Principais

- `Usuarios` N:1 `Perfis`
- `Atrativos` N:1 `Categorias`
- `Atrativos` 1:N `Avaliacoes`
- `Atrativos` 1:N `Midias`
- `Roteiros` N:N `Atrativos` (tabela pivot `roteiro_atrativo`)
- `Eventos` N:1 `Categorias`
- `Empreendedores` N:N `Categorias` de serviço
- `Auditoria` registra ações de `Usuarios` em qualquer entidade

---

## 6. Requisitos Não-Funcionais

### 6.1 Usabilidade
- Interface responsiva (desktop, tablet, mobile)
- Navegação intuitiva e fluida
- Busca por linguagem natural

### 6.2 Desempenho
- Tempo de carregamento otimizado
- Suporte a acesso concorrente
- Cache de consultas frequentes

### 6.3 Escalabilidade
- Arquitetura modular para inclusão de funcionalidades sem reconstrução
- Replicável para municípios de diferentes portes

### 6.4 Interoperabilidade (Seção 19)
- APIs documentadas com padrões abertos
- Integração com sistemas externos (mapas, plataformas estaduais/federais)
- Controle de acesso, registro de utilização e tratamento de falhas nas integrações
- Evitar dependência de tecnologias proprietárias

### 6.5 Manutenibilidade
- Código organizado e documentado
- Todas as tecnologias com suporte ativo (não descontinuadas)

### 6.6 Modo Offline
- Mapas, descrições, rotas e telefones de emergência disponíveis offline
- Conteúdos previamente armazenados no dispositivo

---

## 7. Segurança e LGPD

### 7.1 Segurança da Informação (Seção 18)

| Requisito | Implementação |
|-----------|--------------|
| Autenticação | Login seguro com senhas protegidas (bcrypt) |
| Autorização | Controle por perfis de acesso |
| Criptografia | HTTPS/TLS para todas as comunicações |
| Auditoria | Registro de acessos administrativos |
| Backup | Cópias de segurança e recuperação de dados |
| Proteção Web | Contra SQL Injection, XSS, CSRF |
| Validação | Dados validados no frontend e backend |

### 7.2 Proteção de Dados (LGPD)

- **Minimização**: coletar apenas dados necessários
- **Finalidade**: informar para que os dados são coletados
- **Transparência**: informar quais dados, finalidades e tempo de armazenamento
- **Direitos do titular**: mecanismos para exercício dos direitos
- **Anonimização**: dados analíticos apresentados de forma agregada
- **Não rastreamento**: sem rastreamento individual sem base legal e consentimento

---

## 8. Critérios de Avaliação (Seção 21)

| Critério | Descrição |
|----------|-----------|
| **Aderência** | Grau de atendimento às necessidades do turismo municipal |
| **Valor ao Turista** | Capacidade de gerar valor real para o visitante |
| **Utilidade Administrativa** | Valor do painel para a Administração Pública |
| **Viabilidade** | Possibilidade real de implementação |
| **Inovação** | Soluções criativas e diferenciadas |
| **UX/UI** | Qualidade da experiência do usuário |
| **Acessibilidade** | Conformidade com boas práticas |
| **Segurança** | Robustez das medidas de proteção |
| **IA Responsável** | Uso ético e transparente de IA |
| **Escalabilidade** | Capacidade de crescimento |
| **Replicabilidade** | Uso por diferentes municípios |
| **Qualidade Técnica** | Código, arquitetura, documentação |

> **Nota:** A mera apresentação de grande quantidade de funcionalidades **não** garante melhor avaliação. A banca observará **coerência, funcionalidade demonstrada e resolução de problemas concretos**.

---

## 9. Entregáveis (Seção 20)

### 9.1 Solução Funcional / Protótipo

O protótipo deve demonstrar no mínimo:
- Pesquisa de atrativos
- Visualização de informações turísticas
- Criação/apresentação de roteiros
- Interação com recurso de IA
- Exibição de indicadores administrativos

### 9.2 Apresentação

- Problema identificado
- Proposta de solução
- Arquitetura tecnológica
- Fluxos de navegação
- Modelo de dados
- Funcionalidades implementadas
- Medidas de segurança
- Critérios de acessibilidade
- Estratégia de escalabilidade

### 9.3 Documentação Técnica

- Funcionamento da solução
- Tecnologias empregadas
- Limitações existentes
- Etapas para implantação definitiva

---

## 10. Glossário

| Termo | Definição |
|-------|-----------|
| **PITE** | Plataforma Inteligente de Turismo Experiencial |
| **Trade Turístico** | Conjunto de empresas e profissionais do setor de turismo |
| **ESG** | Environmental, Social and Governance |
| **ODS** | Objetivos de Desenvolvimento Sustentável (ONU) |
| **LGPD** | Lei Geral de Proteção de Dados (Lei 13.709/2018) |
| **MVC** | Model-View-Controller — padrão arquitetural |
| **Mapa de Calor** | Visualização que indica concentração de atividade por região |
| **QR Code** | Código bidimensional que direciona para conteúdos digitais |
| **Selo de Fornecedor** | Certificação municipal de validação de prestadores |
| **Exclusão Lógica** | Registro marcado como inativo sem remoção física do banco |

---

## Resultado Esperado (Seção 22)

> O principal resultado esperado **não é apenas a criação de um portal visualmente atrativo**, mas o desenvolvimento de uma **ferramenta de gestão pública orientada por dados**, capaz de conectar turismo, tecnologia, desenvolvimento econômico, cultura, inclusão e sustentabilidade.

A plataforma deve transformar:
- Informações dispersas em **Inteligência**
- Atrativos em **Experiências**
- Empreendedores em **Rede econômica organizada**
- Dados turísticos em **Instrumentos de desenvolvimento municipal**

---

*Documento elaborado com base no edital "HACKATON PROJETO v3" — Máxima Tecnologia LTDA.*
*Diretor: Marconi Duarte*
