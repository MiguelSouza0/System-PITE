# 🏛️ System-PITE — Visão Geral do Sistema e do Projeto

## 📖 Introdução
O **System-PITE (Plataforma Integrada de Turismo e Eventos)** é uma plataforma digital de governo inteligente e gestão pública orientada a dados. Desenvolvida para modernizar a promoção do turismo municipal, conectar a cadeia produtiva local e democratizar o acesso à cultura e ao lazer, a plataforma unifica a experiência de **turistas**, a sustentabilidade de **empreendedores locais** e o controle estratégico da **administração municipal (Prefeito e Secretários)**.

---

## ⚙️ Funcionalidades Mapeadas

### 1. [Portal Público do Turista e Cidadão](file:///c:/Users/mathe/Documentos_Local/Reposit%C3%B3rios/System-PITE/Mapeamento_Funcionalidades.md#1-portal-p%C3%BAblico--experi%C3%AAncia-do-turista)
- **Roteiros Personalizados com IA**: Geração inteligente de itinerários por tempo, orçamento e perfil (família, aventura, gastronomia, história).
- **Mapa Turístico Interativo**: Visualização em mapa dinâmico com geolocalização, rotas otimizadas e filtros por categoria.
- **Acessibilidade Universal (PNE/WCAG 2.2 AA)**: Modo alto contraste, ajuste de tipografia e filtros específicos de acessibilidade (rampas, audiodescrição, piso tátil, Libras).
- **Modo Offline**: Download e consulta de dados e mapas para áreas de turismo ecológico sem cobertura de sinal celular.
- **Assistente Virtual Multilíngue**: Suporte em tempo real com tradução automática e respostas auditáveis.
- **Avaliações Validadas (*Zero Fake Reviews*)**: Sistema de avaliação integrado com validação de presença física.

### 2. [Espaço do Empreendedor Local](file:///c:/Users/mathe/Documentos_Local/Reposit%C3%B3rios/System-PITE/Mapeamento_Funcionalidades.md#2-espa%C3%A7o-do-empreendedor-local)
- **Autocadastro Comercial**: Inscrição simplificada de pousadas, restaurantes, artesãos e guias turísticos.
- **Selo Municipal de Validação**: Mecanismo de certificação oficial da Prefeitura para valorizar o comércio formal e de qualidade.
- **Painel de Desempenho**: Métricas de visitas, contatos e inclusão em roteiros sugeridos.

### 3. [Gestão Municipal & Inteligência Estratégica](file:///c:/Users/mathe/Documentos_Local/Reposit%C3%B3rios/System-PITE/Mapeamento_Funcionalidades.md#3-gest%C3%A3o-municipal-prefeito-secret%C3%A1rio-e-t%C3%A9cnico)
- **Visão Executiva (Prefeito)**: Dashboards com métricas de impacto econômico, taxa de retorno, perfil de visitantes e fluxo turístico.
- **Gestão Operacional (Secretaria de Turismo)**: Homologação de cadastros, controle de atrativos e agenda de eventos.
- **Gestão Cadastral (Servidor Técnico)**: Criação e manutenção do acervo turístico municipal.
- **Trilha de Auditoria & LGPD**: Registro inalterável de todas as ações administrativas para total transparência pública.
- **Matriz ESG Municipal**: Acompanhamento e emissão de relatórios oficiais sobre os pilares Ambiental, Social e Governança.

---

## 🔄 Fluxo de Implementação e Arquitetura

O sistema adota uma arquitetura em camadas baseada no padrão **Model-View-Controller (MVC)** sobre o framework **Laravel 11**, com persistência em **PostgreSQL 15** e conteinerização completa em **Docker**.

```mermaid
graph TD
    subgraph Camada_Apresentacao [Camada de Apresentação (Frontend)]
        UI_Turista[Portal do Turista - Blade / Bootstrap 5 / Leaflet]
        UI_Empreendedor[Painel do Empreendedor]
        UI_Admin[Painel Administrativo - Prefeito & Secretaria]
    end

    subgraph Camada_Controle_Negocio [Camada de Controle e Serviços (Backend)]
        Auth_Sec[Middleware de Autenticação & RBAC]
        Controllers[Controllers - Portal, Admin, API]
        Services[Services - IA, Roteirização, ESG, Auditoria]
    end

    subgraph Camada_Dados [Persistência & Integrações]
        DB[(PostgreSQL 15)]
        IA_Engine[OpenAI / Motor Heurístico de IA]
        Maps_API[Leaflet OpenStreetMap API]
    end

    UI_Turista -->|Requisições HTTP/AJAX| Auth_Sec
    UI_Empreendedor -->|Requisições HTTP/AJAX| Auth_Sec
    UI_Admin -->|Requisições HTTP/AJAX| Auth_Sec

    Auth_Sec --> Controllers
    Controllers --> Services
    Services --> DB
    Services --> IA_Engine
    Services --> Maps_API
```

---

## 🧪 Casos de Uso e Perfis de Acesso

| Perfil | Nível de Acesso | Casos de Uso Principais |
| :--- | :--- | :--- |
| **Turista / Cidadão** | Público / Conta Turista | Buscar atrativos, gerar roteiros com IA, avaliar pontos com validação, consultar mapa interativo e salvar roteiro offline. |
| **Empreendedor Local** | Autenticado (`empreendedor`) | Cadastrar estabelecimento, submeter alvarás/certidões, acompanhar métricas de visualização e solicitar Selo Municipal. |
| **Servidor Técnico** | Autenticado (`servidor`) | Cadastrar e editar acervo de atrativos, eventos municipais, categorias e pontos históricos. |
| **Secretário de Turismo** | Autenticado (`secretario`) | Homologar/rejeitar estabelecimentos, gerenciar agenda oficial, analisar ocupação e métricas táticas. |
| **Prefeito Municipal** | Autenticado (`prefeito`) | Visualizar dashboard executivo, índices ESG, indicadores socioeconômicos e relatórios de auditoria. |

---

## ✅ Boas Práticas e Padrões Adotados

- **Código Limpo e MVC**: Separação clara de responsabilidades entre regras de negócio, interfaces e persistência.
- **Segurança da Informação**: Proteção contra ataques CSRF, XSS e SQL Injection via Eloquent ORM.
- **Conformidade com a LGPD**: Minimização da coleta de dados pessoais, consentimento explícito e anonimização de métricas.
- **Acessibilidade Digital**: Conformidade com as diretrizes e-MAG / WCAG 2.2 AA.
- **Auditoria Total**: Rastreamento de operações de criação, alteração e exclusão para transparência com órgãos de controle (TCE/CGU).

---

## 📋 Checklist de Revisão e Governança

- [x] Arquitetura alinhada com as diretrizes do Edital / Hackaton.
- [x] Todos os 5 perfis de usuário contemplados com fluxos seguros.
- [x] Funcionalidades de IA responsável com supervisão humana.
- [x] Recursos de inclusão e acessibilidade universal implementados.
- [x] Mapeamento detalhado de casos de uso e rotas sincronizado no arquivo [`Mapeamento_Funcionalidades.md`](file:///c:/Users/mathe/Documentos_Local/Reposit%C3%B3rios/System-PITE/Mapeamento_Funcionalidades.md).
