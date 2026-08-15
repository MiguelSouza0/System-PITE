# 📚 Documentação do Projeto — System-PITE

**Plataforma Inteligente de Turismo Municipal**

---

## 1. Visão Geral do Sistema

O **System-PITE** é uma plataforma de gestão pública e promoção turística orientada por dados, desenvolvida para o Hackathon **"Destino Turístico Municipal"** (patrocinado por *Máxima Tecnologia LTDA*). 

A solução conecta três pilares:
1. **Turista / Cidadão**: Pesquisa inteligente de pontos turísticos, agenda de eventos, mapa interativo e gerador de roteiros personalizados com IA.
2. **Empreendedor Local**: Cadastro e visibilidade de estabelecimentos (hospedagens, restaurantes, guias, artesanato) com moderação e selo municipal.
3. **Gestão Pública Municipal**: Painel executivo do prefeito, gráficos em tempo real, relatórios ESG, exportação de dados abertos e trilha de auditoria para transparência.

---

## 2. Tecnologias Empregadas

- **Backend**: PHP 8.2 + Framework Laravel 11 (MVC)
- **Banco de Dados**: PostgreSQL 16 (com suporte a JSONB e consultas espaciais/coordenadas)
- **Ambiente de Execução**: Docker Compose (`system_pite_app` na porta 8000 e `system_pite_db` na porta 5432)
- **Frontend & Design System**: HTML5, CSS3 Vanilla com variáveis CSS, Bootstrap 5, Bootstrap Icons, Google Fonts (Outfit & Inter)
- **Visualização de Dados & Mapas**: Chart.js 4.4, Leaflet JS 1.9
- **Segurança & LGPD**: Autenticação nativa com Bcrypt, middleware por perfis (`CheckPerfil`), CSRF protection, sanitarização e audit logs.

---

## 3. O que FOI IMPLEMENTADO (Trabalho Realizado)

### 3.1 Infraestrutura & Banco de Dados (100% Funcional)
- ✅ **Docker Compose**: Containers integrados PHP CLI + PostgreSQL configurados e saudáveis.
- ✅ **Migrations & Schema**: 14 tabelas migradas no PostgreSQL:
  1. `perfis` (Prefeito, Secretário, Servidor, Empreendedor)
  2. `users` (Usuários com perfil e senha criptografada)
  3. `categorias` (Patrimônio Histórico, Ecoturismo, Gastronomia, Hospedagem, etc.)
  4. `atrativos` (Coordenadas, acessibilidade JSON, status, horários, preços)
  5. `eventos` (Festivais, feiras, datas, gratuidade, organizadores)
  6. `roteiros` (Roteiros com flag `gerado_por_ia`)
  7. `empreendedores` (CNPJ/CPF, tipo de serviço, status de aprovação, selos)
  8. `avaliacoes` (Notas de 1 a 5 estrelas, opiniões e origem do turista)
  9. `indicadores_esg` (Métricas dos pilares Ambiental, Social e Governança)
  10. `midias` (Polimórfica para fotos, vídeos e audiodescrições)
  11. `auditoria` (Trilha de auditoria para registrar ações de criação/edição/exclusão)
  12. `notificacoes` (Envio de alertas e comunicados de emergência)
  13. `ocorrencias` (Registro de incidentes e segurança do turista)
  14. `roteiro_atrativo` (Tabela pivot com ordem de visitação e tempo estimado)
- ✅ **Seeders Completo**: Dados de teste oficiais para categorias, atrativos, eventos, empreendedores, perfil e usuários.

### 3.2 Portal Público do Turista
- ✅ **Página Inicial (Home)**: Banner Hero com busca rápida, atrativos em destaque, grid de categorias e indicadores ESG. *(Layout ajustado para eliminar cortes no rodapé)*.
- ✅ **Listagem e Filtros de Atrativos (`/atrativos`)**: Busca textual, filtro por categoria, faixa de preço e flag de acessibilidade PNE.
- ✅ **Detalhe do Atrativo (`/atrativos/{slug}`)**:
  - Descrição histórica e contexto.
  - Grade de infraestrutura de acessibilidade PNE (rampas, piso tátil, áudio-guia).
  - Formulário para envio de **avaliações auditadas** (nota + comentário + origem do turista).
  - **QR Code Oficial gerado dinamicamente** para afixação em placas físicas locais.
- ✅ **Mapa Interativo (`/mapa-interativo`)**: Integração Leaflet alimentada via endpoint JSON (`/api/atrativos-mapa`), com marcadores coloridos por categoria, popups com link e legenda dinâmica.
- ✅ **Roteiros Inteligentes com IA (`/roteiros-inteligentes`)**:
  - Formulário interativo (Perfil do passeio, horas disponíveis, acessibilidade).
  - Integração AJAX com `AiItineraryService` que gera sugestões dinâmicas de visitação consumindo atrativos do banco de dados.
- ✅ **Agenda Cultural de Eventos (`/eventos` e `/eventos/{slug}`)**: Programação oficial de festivais e eventos com filtro por gratuidade e integração com os locais mapeados.
- ✅ **Portal ESG (`/esg-transparencia`)**: Painel de transparência de dados públicos e sustentabilidade.

### 3.3 Painel Administrativo de Gestão Municipal (`/admin`)
- ✅ **Autenticação & Acesso Rápido**: Tela de login (`/login`) com suporte a *Quick-Login* para simulação de perfis de Prefeito, Secretário e Servidor.
- ✅ **Middleware de Proteção por Perfil**: Verificação no kernel do Laravel garantindo que apenas perfis autorizados acessem as rotas administrativas.
- ✅ **Dashboard Executivo do Prefeito (`/admin/dashboard`)**:
  - KPIs em tempo real (Total de atrativos, empreendedores aprovados e pendentes, eventos e média de avaliações).
  - Gráfico Doughnut (Atrativos por Categoria).
  - Gráfico de Barras (Empreendedores por Status).
  - Gráfico Radar (Índice ESG por Pilar).
  - Tabela dos últimos cadastros e lista de aprovações pendentes.
- ✅ **CRUD Completo de Atrativos (`/admin/atrativos`)**:
  - Listagem com paginação e busca.
  - Formulário de criação e edição com checkboxes de acessibilidade PNE.
  - **Exclusão Lógica** (alteração do status para `inativo`).
  - Registro automático das operações na tabela `auditoria`.
- ✅ **Exportação de Relatórios Oficiais**:
  - **Relatório ESG em PDF**: `/admin/relatorios/esg-pdf` (Pronto para impressão oficial com timbre municipal).
  - **Dados Abertos em CSV**: `/admin/relatorios/csv` (Download imediato de planilha padronizada).

---

## 4. O que FALTA FAZER (Roadmap de Evolução Futura)

Embora o protótipo funcional para o hackathon atinja 100% dos requisitos fundamentais do edital, as seguintes melhorias podem ser implementadas em uma fase de implantação definitiva:

### 🟡 Prioridade Média (Interface Admin Secundária)
1. **CRUD Admin de Empreendedores**:
   - Criar controller para ação de aprovar (`status_aprovacao = 'aprovado'`) ou rejeitar cadastros enviados pelos empreendedores locais com emissão do Selo Municipal.
2. **CRUD Admin de Eventos**:
   - Interface administrativa dedicada para criar e editar eventos sem necessidade de inserção via seeders/banco.
3. **Painel Visual da Trilha de Auditoria (`/admin/auditoria-logs`)**:
   - Renderizar tabela interativa para filtrar logs de acessos e alterações gravados na tabela `auditoria`.

### 🔵 Prioridade Baixa / Recursos Avançados
4. **Integração Nativa com API OpenAI (LLM Real)**:
   - Atualmente, o `AiItineraryService` realiza filtragem heurística auditável dos atrativos do banco. Pode-se adicionar uma chave de API para chamadas ao ChatGPT ou Gemini caso o município opte por IA generativa completa.
5. **Modo Offline (PWA - Progressive Web App)**:
   - Adicionar `service-worker.js` e manifesto PWA para salvar o mapa e telefones de emergência no cache do navegador do turista.
6. **Upload Real de Arquivos de Mídia**:
   - Implementar formulário de upload de imagens para a pasta `storage/app/public` com vinculação no model `Midia`.

---

## 5. Resumo da Estrutura de Arquivos Criados / Modificados

```
System-PITE/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/ (DashboardController, AtrativoAdminController, RelatorioController)
│   │   │   ├── Auth/ (AuthController)
│   │   │   └── Portal/ (HomeController, AtrativoController, MapaController, RoteiroController, EventoController, AvaliacaoController)
│   │   └── Middleware/ (CheckPerfil.php)
│   ├── Models/ (Atrativo, Avaliacao, Categoria, Empreendedor, Evento, IndicadorEsg, Midia, Auditoria, Notificacao, Ocorrencia, Perfil, Roteiro, User)
│   └── Services/ (AiItineraryService, EsgMetricService)
├── database/
│   ├── migrations/ (14 tabelas criadas)
│   └── seeders/ (AtrativoSeeder, CategoriaSeeder, EmpreendedorSeeder, EventoSeeder, IndicadorEsgSeeder, PerfilSeeder, UserSeeder)
├── resources/views/
│   ├── admin/ (dashboard/prefeito, atrativos/index e create/edit, empreendedores, esg, auditoria, relatorios/esg_pdf)
│   ├── auth/ (login.blade.php)
│   ├── empreendedor/ (dashboard, cadastro)
│   ├── layouts/ (app.blade.php com navbar, footer e acessibilidade)
│   └── portal/ (home, atrativos/index e show, eventos/index e show, mapa, roteiros, esg)
└── routes/
    └── web.php (31 rotas mapeadas)
```
