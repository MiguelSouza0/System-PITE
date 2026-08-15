# 📁 Estrutura de Pastas — System-PITE

## Visão Geral

O projeto utiliza a estrutura padrão do **Laravel** com organizações adicionais por domínio/módulo, seguindo boas práticas para projetos de médio-grande porte.

---

## Estrutura Completa

```
System-PITE/
│
├── app/                              # Código principal da aplicação
│   ├── Console/
│   │   └── Commands/                 # Comandos Artisan personalizados
│   │       ├── GerarRelatorio.php
│   │       └── LimparCacheMidias.php
│   │
│   ├── Enums/                        # Enumerações do sistema
│   │   ├── StatusCadastro.php        # pendente, aprovado, rejeitado, suspenso
│   │   ├── PerfilUsuario.php         # prefeito, secretario, servidor, turista, empreendedor
│   │   ├── CategoriaAtrativo.php     # historico, cultural, religioso, gastronomico...
│   │   ├── NivelGravidade.php        # baixa, media, alta, critica
│   │   └── TipoMidia.php            # foto, video, audio, 360, drone
│   │
│   ├── Events/                       # Eventos do sistema
│   │   ├── CadastroSubmetido.php
│   │   ├── AvaliacaoCriada.php
│   │   └── OcorrenciaRegistrada.php
│   │
│   ├── Exports/                      # Exportações (PDF, Excel)
│   │   ├── RelatorioAcessosExport.php
│   │   ├── RelatorioEmpreendedoresExport.php
│   │   └── RelatorioIndicadoresExport.php
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Portal/               # 🌐 Portal Público do Turista
│   │   │   │   ├── HomeController.php
│   │   │   │   ├── AtrativoController.php
│   │   │   │   ├── EventoController.php
│   │   │   │   ├── RoteiroController.php
│   │   │   │   ├── BuscaController.php
│   │   │   │   ├── MapaController.php
│   │   │   │   └── UtilidadePublicaController.php
│   │   │   │
│   │   │   ├── Empreendedor/          # 🏪 Área do Empreendedor
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── CadastroController.php
│   │   │   │   ├── ServicoController.php
│   │   │   │   └── DocumentoController.php
│   │   │   │
│   │   │   ├── Admin/                 # ⚙️ Painel Administrativo
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── AtrativoController.php
│   │   │   │   ├── EventoController.php
│   │   │   │   ├── RoteiroController.php
│   │   │   │   ├── EmpreendedorController.php
│   │   │   │   ├── UsuarioController.php
│   │   │   │   ├── CategoriaController.php
│   │   │   │   ├── MidiaController.php
│   │   │   │   ├── AvaliacaoController.php
│   │   │   │   ├── OcorrenciaController.php
│   │   │   │   ├── NotificacaoController.php
│   │   │   │   ├── RelatorioController.php
│   │   │   │   └── AuditoriaController.php
│   │   │   │
│   │   │   ├── AI/                    # 🤖 Inteligência Artificial
│   │   │   │   ├── AssistenteController.php
│   │   │   │   ├── TraducaoController.php
│   │   │   │   └── RoteiroIAController.php
│   │   │   │
│   │   │   └── Auth/                  # 🔐 Autenticação
│   │   │       ├── LoginController.php
│   │   │       ├── RegisterController.php
│   │   │       └── PasswordController.php
│   │   │
│   │   ├── Middleware/
│   │   │   ├── CheckPerfil.php        # Verifica perfil de acesso
│   │   │   ├── RegistrarAuditoria.php # Trilha de auditoria
│   │   │   ├── ValidarEmpreendedor.php
│   │   │   └── ForcarHttps.php
│   │   │
│   │   └── Requests/                  # Form Requests (validação)
│   │       ├── AtrativoRequest.php
│   │       ├── EventoRequest.php
│   │       ├── RoteiroRequest.php
│   │       ├── EmpreendedorRequest.php
│   │       ├── AvaliacaoRequest.php
│   │       └── OcorrenciaRequest.php
│   │
│   ├── Listeners/                     # Listeners de eventos
│   │   ├── EnviarNotificacaoCadastro.php
│   │   └── AlertarAvaliacaoCritica.php
│   │
│   ├── Models/                        # Modelos Eloquent
│   │   ├── User.php
│   │   ├── Perfil.php
│   │   ├── Atrativo.php
│   │   ├── Categoria.php
│   │   ├── Evento.php
│   │   ├── Roteiro.php
│   │   ├── RoteiroAtrativo.php        # Pivot
│   │   ├── Empreendedor.php
│   │   ├── Servico.php
│   │   ├── Avaliacao.php
│   │   ├── Midia.php
│   │   ├── Ocorrencia.php
│   │   ├── Notificacao.php
│   │   ├── Auditoria.php
│   │   ├── UtilidadePublica.php
│   │   └── Acessibilidade.php
│   │
│   ├── Notifications/                 # Notificações Laravel
│   │   ├── AlertaClimatico.php
│   │   ├── EventoProximo.php
│   │   ├── DocumentoVencendo.php
│   │   └── CadastroAprovado.php
│   │
│   ├── Policies/                      # Políticas de autorização
│   │   ├── AtrativoPolicy.php
│   │   ├── EventoPolicy.php
│   │   ├── EmpreendedorPolicy.php
│   │   └── RelatorioPolicy.php
│   │
│   ├── Providers/
│   │   ├── AppServiceProvider.php
│   │   ├── AuthServiceProvider.php
│   │   └── EventServiceProvider.php
│   │
│   └── Services/                      # Camada de serviços (lógica de negócio)
│       ├── AI/
│       │   ├── AssistenteService.php   # Integração com API de IA
│       │   ├── TraducaoService.php     # Tradução automática
│       │   ├── SentimentoService.php   # Análise de sentimento
│       │   └── RoteiroIAService.php    # Geração de roteiros por IA
│       │
│       ├── Busca/
│       │   └── BuscaInteligenteService.php
│       │
│       ├── Dashboard/
│       │   ├── IndicadorService.php
│       │   ├── MapaCalorService.php
│       │   └── EsgService.php
│       │
│       ├── Exportacao/
│       │   ├── PdfService.php
│       │   └── PlanilhaService.php
│       │
│       └── Geolocalizacao/
│           └── MapaService.php
│
├── bootstrap/                         # Bootstrap do Laravel (padrão)
│
├── config/                            # Configurações
│   ├── app.php
│   ├── database.php
│   ├── auth.php
│   ├── ai.php                         # Config da API de IA
│   ├── mapas.php                      # Config do serviço de mapas
│   └── turismo.php                    # Configs específicas do domínio
│
├── database/
│   ├── factories/                     # Factories para testes
│   │   ├── AtrativoFactory.php
│   │   ├── EventoFactory.php
│   │   ├── EmpreendedorFactory.php
│   │   └── UserFactory.php
│   │
│   ├── migrations/                    # Migrations (ordem cronológica)
│   │   ├── 0001_create_perfis_table.php
│   │   ├── 0002_create_users_table.php
│   │   ├── 0003_create_categorias_table.php
│   │   ├── 0004_create_atrativos_table.php
│   │   ├── 0005_create_eventos_table.php
│   │   ├── 0006_create_roteiros_table.php
│   │   ├── 0007_create_roteiro_atrativo_table.php
│   │   ├── 0008_create_empreendedores_table.php
│   │   ├── 0009_create_servicos_table.php
│   │   ├── 0010_create_avaliacoes_table.php
│   │   ├── 0011_create_midias_table.php
│   │   ├── 0012_create_ocorrencias_table.php
│   │   ├── 0013_create_notificacoes_table.php
│   │   ├── 0014_create_auditorias_table.php
│   │   └── 0015_create_utilidades_publicas_table.php
│   │
│   └── seeders/                       # Carga inicial de dados
│       ├── DatabaseSeeder.php
│       ├── PerfilSeeder.php
│       ├── CategoriaSeeder.php
│       ├── AdminSeeder.php
│       └── UtilidadePublicaSeeder.php
│
├── docs/                              # 📚 Documentação do projeto
│   ├── DOCUMENTACAO_COMPLETA.md
│   ├── ESTRUTURA_PASTAS.md
│   ├── API.md                         # Documentação de APIs
│   ├── DEPLOY.md                      # Guia de implantação
│   └── diagramas/
│       ├── modelo-dados.png
│       ├── arquitetura.png
│       └── fluxos-navegacao.png
│
├── public/                            # Arquivos públicos
│   ├── index.php
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   ├── images/
│   │   ├── logo/
│   │   ├── icons/
│   │   └── banners/
│   └── uploads/                       # Mídias enviadas (fotos, vídeos)
│       ├── atrativos/
│       ├── eventos/
│       ├── empreendedores/
│       └── qrcodes/
│
├── resources/
│   ├── css/                           # CSS fonte (compilado pelo Vite)
│   │   ├── app.css
│   │   ├── _variables.css
│   │   ├── portal.css                 # Estilos do portal público
│   │   ├── admin.css                  # Estilos do painel admin
│   │   └── acessibilidade.css         # Alto contraste, fontes grandes
│   │
│   ├── js/                            # JavaScript fonte
│   │   ├── app.js
│   │   ├── mapa.js                    # Integração com mapas
│   │   ├── busca.js                   # Busca inteligente (frontend)
│   │   ├── assistente.js              # Chat com IA
│   │   ├── dashboard-charts.js        # Gráficos do dashboard
│   │   ├── offline.js                 # Service Worker / modo offline
│   │   └── qrcode.js                  # Geração de QR Codes
│   │
│   ├── lang/                          # Traduções multilíngue
│   │   ├── pt-BR/
│   │   ├── en/
│   │   ├── es/
│   │   └── fr/
│   │
│   └── views/                         # Templates Blade
│       ├── layouts/
│       │   ├── portal.blade.php       # Layout do portal público
│       │   ├── admin.blade.php        # Layout do painel admin
│       │   └── empreendedor.blade.php # Layout área empreendedor
│       │
│       ├── components/                # Componentes Blade reutilizáveis
│       │   ├── card-atrativo.blade.php
│       │   ├── card-evento.blade.php
│       │   ├── mapa.blade.php
│       │   ├── avaliacao.blade.php
│       │   ├── busca.blade.php
│       │   ├── selo-validado.blade.php
│       │   └── indicador-esg.blade.php
│       │
│       ├── portal/                    # 🌐 Views do Portal
│       │   ├── home.blade.php
│       │   ├── atrativos/
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   ├── eventos/
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   ├── roteiros/
│       │   │   ├── index.blade.php
│       │   │   ├── show.blade.php
│       │   │   └── personalizado.blade.php
│       │   ├── busca/
│       │   │   └── resultados.blade.php
│       │   ├── mapa/
│       │   │   └── interativo.blade.php
│       │   └── utilidade-publica/
│       │       └── index.blade.php
│       │
│       ├── empreendedor/              # 🏪 Views do Empreendedor
│       │   ├── dashboard.blade.php
│       │   ├── cadastro.blade.php
│       │   ├── servicos.blade.php
│       │   └── documentos.blade.php
│       │
│       ├── admin/                     # ⚙️ Views do Admin
│       │   ├── dashboard.blade.php
│       │   ├── atrativos/
│       │   ├── eventos/
│       │   ├── roteiros/
│       │   ├── empreendedores/
│       │   ├── usuarios/
│       │   ├── avaliacoes/
│       │   ├── ocorrencias/
│       │   ├── notificacoes/
│       │   ├── relatorios/
│       │   ├── auditoria/
│       │   ├── indicadores/
│       │   │   ├── economicos.blade.php
│       │   │   ├── comportamento.blade.php
│       │   │   ├── esg.blade.php
│       │   │   └── mapa-calor.blade.php
│       │   └── dashboard-executivo/
│       │       └── index.blade.php
│       │
│       ├── auth/                      # 🔐 Views de autenticação
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   └── forgot-password.blade.php
│       │
│       └── emails/                    # Templates de e-mail
│           ├── cadastro-aprovado.blade.php
│           ├── documento-vencendo.blade.php
│           └── alerta-emergencial.blade.php
│
├── routes/
│   ├── web.php                        # Rotas web gerais
│   ├── portal.php                     # Rotas do portal público
│   ├── empreendedor.php               # Rotas da área do empreendedor
│   ├── admin.php                      # Rotas do painel administrativo
│   └── api.php                        # Rotas de API (IA, integrações)
│
├── storage/                           # Storage do Laravel (padrão)
│
├── tests/
│   ├── Feature/
│   │   ├── Portal/
│   │   ├── Empreendedor/
│   │   ├── Admin/
│   │   └── AI/
│   └── Unit/
│       ├── Models/
│       └── Services/
│
├── .env.example                       # Variáveis de ambiente (modelo)
├── .gitignore
├── composer.json                      # Dependências PHP
├── package.json                       # Dependências JS (Bootstrap, etc.)
├── vite.config.js                     # Build de assets
├── phpunit.xml                        # Configuração de testes
└── README.md
```

---

## Justificativas da Organização

### 1. Controllers divididos por contexto

```
Controllers/
├── Portal/        → Turista (público, sem auth)
├── Empreendedor/  → Prestadores (auth + perfil empreendedor)
├── Admin/         → Gestão municipal (auth + perfil admin)
├── AI/            → Endpoints de IA (assistente, tradução)
└── Auth/          → Login, registro, senhas
```

**Por quê?** Cada contexto tem regras de acesso, middleware e lógica diferentes. Separar evita controllers gigantes e facilita aplicar middleware por grupo de rotas.

### 2. Services como camada de negócio

```
Services/
├── AI/            → Integrações com APIs de IA
├── Busca/         → Lógica de busca inteligente
├── Dashboard/     → Cálculo de indicadores
├── Exportacao/    → Geração de PDFs e planilhas
└── Geolocalizacao/ → Mapas e localização
```

**Por quê?** Mantém os Controllers magros (thin controllers). A lógica complexa fica nos Services, que são testáveis e reutilizáveis.

### 3. Views espelham os Controllers

```
views/
├── portal/        → Telas do turista
├── empreendedor/  → Telas do empreendedor
├── admin/         → Telas administrativas
├── components/    → Componentes reutilizáveis
└── layouts/       → Layouts base (Bootstrap)
```

### 4. Rotas separadas por contexto

```
routes/
├── portal.php       → Route::prefix('/')
├── empreendedor.php → Route::prefix('empreendedor')->middleware('auth', 'perfil:empreendedor')
├── admin.php        → Route::prefix('admin')->middleware('auth', 'perfil:admin')
└── api.php          → Route::prefix('api')
```

**Por quê?** Cada arquivo de rota aplica seu próprio middleware e prefixo, mantendo `web.php` limpo.

### 5. Uploads organizados por entidade

```
public/uploads/
├── atrativos/
├── eventos/
├── empreendedores/
└── qrcodes/
```

**Por quê?** Facilita backup, limpeza e controle de permissões por tipo de mídia.

---

## Dependências Recomendadas (composer.json)

| Pacote | Finalidade |
|--------|-----------|
| `laravel/framework` | Framework principal |
| `laravel/sanctum` | Autenticação API |
| `spatie/laravel-permission` | Perfis e permissões |
| `spatie/laravel-activitylog` | Trilha de auditoria |
| `spatie/laravel-medialibrary` | Gestão de mídias |
| `maatwebsite/excel` | Exportação planilhas |
| `barryvdh/laravel-dompdf` | Exportação PDF |
| `simplesoftwareio/simple-qrcode` | Geração de QR Codes |
| `mcamara/laravel-localization` | Tradução multilíngue |
| `openai-php/laravel` | Integração com IA |

## Dependências Frontend (package.json)

| Pacote | Finalidade |
|--------|-----------|
| `bootstrap` | Framework CSS responsivo |
| `chart.js` | Gráficos do dashboard |
| `leaflet` | Mapas interativos (open-source) |
| `sweetalert2` | Alertas e confirmações |
