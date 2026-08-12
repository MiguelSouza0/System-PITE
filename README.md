
# System-PITE - Plataforma Inteligente de Turismo Municipal 🏛️✈️

> **Ferramenta de Gestão Pública Orientada a Dados para o Turismo Municipal**
> *Desenvolvido para o Hackaton de Turismo*

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15-4169E1?style=for-the-badge&logo=postgresql&logoColor=white)](https://www.postgresql.org)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![Docker](https://img.shields.io/badge/Docker-Supported-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://www.docker.com)
[![LGPD](https://img.shields.io/badge/LGPD-Conforme-00875F?style=for-the-badge)](https://www.gov.br/cidadania/pt-br/acesso-a-informacao/lgpd)

---

## 📋 Sobre o Projeto

O **System-PITE** é uma plataforma de gestão pública moderna, sustentável e acessível, projetada para transformar o turismo municipal. Conectando **turistas**, **empreendedores locais** e a **administração municipal (Prefeito e Secretários)**, o sistema utiliza inteligência artificial auditável, métricas ESG e geolocalização para promover o desenvolvimento socioeconômico e ambiental da região.

---

## 🌟 Principais Funcionalidades

### 🤖 1. Roteiros Inteligentes & IA Auditável

- **Geração Personalizada**: Roteiros baseados no perfil do turista (família, ecoturismo, cultura, gastronomia), tempo disponível e orçamento.
- **IA Transparente**: Supervisão humana garantida, rastreabilidade de fontes e conformidade com os princípios éticos da IA na administração pública.

### ♿ 2. Acessibilidade Universal (PNE)

- **Filtros de Acessibilidade**: Localização de atrativos com rampas, banheiros adaptados, piso tátil e audio-guia.
- **Recursos de Interface**: Modo Alto Contraste, controle dinâmico de tamanho de fonte e conformidade WCAG 2.2 AA.

### 🍃 3. Matriz ESG & Transparência Pública

- **Painel ESG Municipal**: Indicadores dos pilares **Ambiental** (reciclagem, pegada de carbono), **Social** (inclusão comunitária, acessibilidade) e **Governança** (dados abertos, LGPD).
- **Relatórios Executivos**: Exportação e visualização transparente dos impactos turísticos no município.

### 🏪 4. Espaço do Empreendedor Local

- **Autocadastro e Validação**: Empreendedores locais (hotéis, restaurantes, guias, artesãos) podem cadastrar seus estabelecimentos.
- **Selo de Validação Municipal**: Sistema de aprovação pela Secretaria de Turismo para garantir qualidade e procedência.

### 📊 5. Painéis de Gestão (Prefeito & Secretário)

- **Visão Executiva (Prefeito)**: Dashboards macro com KPIs estratégicos, retorno socioeconômico e estatísticas municipais.
- **Gestão Operacional (Secretaria)**: Moderação de estabelecimentos, cadastro de eventos, gestão de atrativos e trilhas de auditoria.

### 🛡️ 6. Conformidade com LGPD & Zero Avaliações Falsas

- **Anonimização de Dados**: Proteção de dados dos turistas conforme a Lei nº 13.709/2018 (LGPD).
- **Validação de Visitas**: Avaliações de pontos turísticos vinculadas a comprovantes ou geolocalização validada para eliminar *fake reviews*.

---

## 🛠️ Arquitetura e Stack Tecnológica

- **Backend**: PHP 8.2 / [Laravel 11.x](https://laravel.com)
- **Banco de Dados**: [PostgreSQL 15](https://www.postgresql.org)
- **Frontend**: Blade Templates, [Bootstrap 5.3](https://getbootstrap.com), Bootstrap Icons, [Leaflet.js](https://leafletjs.com) (Mapas)
- **Compilador de Assets**: [Vite](https://vitejs.dev)
- **Conteinerização**: Docker & Docker Compose

---

## 📁 Estrutura do Projeto

```
System-PITE/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/            # DashboardController, EmpreendedorController, EsgController
│   │   │   └── Portal/           # HomeController, AtrativoController, RoteiroController
│   ├── Models/                   # Atrativo, Categoria, Evento, Roteiro, Empreendedor, User, Perfil, Avaliacao, IndicadorEsg
│   └── Services/                 # AiItineraryService, EsgMetricService, AccessibilityService
├── database/
│   ├── migrations/               # Migrações PostgreSQL estruturadas
│   └── seeders/                  # Seeders com perfis, categorias e usuários iniciais
├── docs/
│   ├── DOCUMENTACAO_COMPLETA.md  # Mapeamento completo dos 23 Requisitos do Hackaton
│   └── ESTRUTURA_PASTAS.md       # Arquitetura MVC e padrões de projeto
├── resources/
│   ├── views/
│   │   ├── admin/                # Dashboards de gestão (Prefeito / Secretaria)
│   │   ├── empreendedor/         # Espaço do Empreendedor
│   │   ├── layouts/              # Base layout com acessibilidade e navegação
│   │   └── portal/               # Portal público (Home, Atrativos, Mapa, Roteiros IA, ESG)
├── routes/
│   └── web.php                   # Rotas do portal, empreendedor e administração
├── docker-compose.yml
├── Dockerfile
└── README.md
```

---

## 🚀 Como Executar o Projeto

### Pré-requisitos

- [Docker](https://www.docker.com/) e [Docker Compose](https://docs.docker.com/compose/) instalados no ambiente.
- *(Opcional)* PHP 8.2+ e Composer para execução sem Docker.

### Passo a Passo via Docker

1. **Clonar o Repositório**:

   ```bash
   git clone https://github.com/MiguelSouza0/System-PITE.git
   cd System-PITE
   ```
2. **Configurar as Variáveis de Ambiente**:

   ```bash
   cp .env.example .env
   ```
3. **Subir os Containers (Aplicação + PostgreSQL)**:

   ```bash
   # Caso precise de privilégios para o socket do Docker:
   docker-compose up -d --build
   # ou: sudo docker-compose up -d --build
   ```
4. **Instalar Dependências e Executar Migrações com Seeders**:

   ```bash
   docker-compose exec app composer install
   docker-compose exec app php artisan key:generate
   docker-compose exec app php artisan migrate --seed
   ```
5. **Acessar a Aplicação**:

   - **Portal Público**: [http://localhost:8000](http://localhost:8000)
   - **Mapa Interativo**: [http://localhost:8000/mapa-interativo](http://localhost:8000/mapa-interativo)
   - **Roteiros IA**: [http://localhost:8000/roteiros-inteligentes](http://localhost:8000/roteiros-inteligentes)
   - **Painel ESG**: [http://localhost:8000/esg-transparencia](http://localhost:8000/esg-transparencia)
   - **Painel Administrativo**: [http://localhost:8000/admin/dashboard](http://localhost:8000/admin/dashboard)

---

## 🔑 Credenciais de Teste (Seeders)

| Perfil                           | E-mail                                  | Senha Padrão      |
| :------------------------------- | :-------------------------------------- | :----------------- |
| **Prefeito Municipal**     | `prefeito@municipio.gov.br`           | `SenhaPITE2026!` |
| **Secretário de Turismo** | `secretario.turismo@municipio.gov.br` | `SenhaPITE2026!` |
| **Servidor Técnico**      | `tecnico.turismo@municipio.gov.br`    | `SenhaPITE2026!` |

---

## 📚 Documentação Técnica

Para detalhes aprofundados sobre a especificação funcional e arquitetural:

- 📄 [Documentação Completa dos Requisitos (`docs/DOCUMENTACAO_COMPLETA.md`)](docs/DOCUMENTACAO_COMPLETA.md)
- 📐 [Guia de Arquitetura e Estrutura de Pastas (`docs/ESTRUTURA_PASTAS.md`)](docs/ESTRUTURA_PASTAS.md)

---

## 📄 Licença

Este projeto foi desenvolvido para fins do **Hackaton de Turismo**, sob diretrizes de código aberto e replicabilidade para gestão pública municipal.
