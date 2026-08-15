# Mapeamento de Funcionalidades

## Funcionalidades Implentadas - *Funcionamentos do protótipo*

### Tela Inicial

#### Encontre o seu destino

A funcionalidade tem o papel de pesquisar pontos turisticos cadastrados no banco de dados através uma filtragem por comparação de texto e categoria aplicada aos dados cadastrados.

Dentro das categorias permitidas para a filtragem de uma pesquisa para o turista temos

- Turismo Ecológico e de Aventura
- Patrimônio Histórico e Cultural
- Gastronomia Local
- Hospedagem e Hotelaria
- Eventos e Festividades
- Artesanato e Comércio Local

### Tela de Login

Na opção de entrar, a opção de acesso deve ser outros formatos de meio de entrada como o google, o linkedin, facebook etc. Rapido deve ser substituido

### Perfis

#### Prefeito

Definição documentação: O prefeito e o secretário municipal de Turismo poderão ter acesso aos indicadores executivos e estratégicos

Todas as alterações relevantes deverão ser registradas em trilha de auditoria, contendo identificação do usuário, data, horário e operação realizada.

A gestão deverá acompanhar cadastros pendentes, aprovados, rejeitados, suspensos e desatualizados.

**Dashboard** - O painel deverá demonstrar:

- Visitação e Recorrência ao Site:

  - O número total de acessos;
  - Visitantes únicos;
  - Usuários recorrentes;
  - Tempo médio de navegação;
  - Taxa de retorno;

- Acessos e Funcionalidades:

  - Páginas mais visitadas;
  - Roteiros mais consultados;
  - Atrativos mais acessados;
  - Eventos mais pesquisados;
  - Serviços locais com maior interesse.

> Necessidade Dashboard: Levantamento de 

Indicadores e dashboard para administração:


#### Secretaria do Turismo

xxx

#### Tecnico servidor

xxxx

## Necessidades de acordo com a documentação

### **Funcionalidades do MVP (Prioridade Máxima)**

***Comparação de Dados**

***Planejamento de Roteiro:** Sistema de "carrinho" onde o usuário seleciona pontos turísticos e o sistema calcula rotas otimizadas entre eles.

***Conteúdo Histórico:** Informações detalhadas sobre o contexto histórico dos destinos.

***Pesquisa de Integrações:** Estudo das APIs do **Google Maps** (filtros), **Booking/Trivago** (hospedagem) e **Uber/99** (preços de transporte).

### 🔌 Integrações e APIs Externas (Pesquisa de Viabilidade)

Para garantir que a solução seja inteligente e conectada, a equipe definiu as seguintes APIs para investigação e possível integração:

***Google Maps API:** É considerada a integração mínima essencial para o projeto. Será utilizada para a **exibição de mapas**, localização exata de pontos históricos e aplicação de **filtros de pesquisa** para estabelecimentos locais, como restaurantes.

***Uber:** Estas APIs serão pesquisadas com o objetivo de fornecer ao usuário uma **estimativa de preços de transporte** em tempo real. A finalidade é auxiliar o turista no planejamento financeiro de seus deslocamentos entre os diferentes pontos do roteiro.

***Booking APIs:** O foco nestas integrações é a **referência de hospedagem**. O sistema utilizará esses dados para sugerir hotéis e comparar preços, priorizando acomodações que estejam geograficamente próximas aos pontos turísticos selecionados pelo usuário.

### **✨ Funcionalidades Extras (Ordem de Prioridade)**

Caso o escopo base seja concluído, as seguintes funcionalidades serão implementadas nesta ordem:

1. **Eventos (Alta Prioridade):** Recomendação de shows, jogos de futebol e datas festivas (ex: São João), que são grandes atrativos na região.

2. **Análise de Perfil:** Sugestões personalizadas com base no comportamento do usuário (ex: foco em museus para quem gosta de história ou boates para quem busca festas).

3. **Indicação do Dia:** Destaques baseados na popularidade momentânea de locais ou adequação ao perfil do dia específico.

## 💰 Modelo de Negócio (Monetização)

A sustentabilidade financeira será baseada em **publicidade e conteúdo patrocinado**. Hotéis, restaurantes e agências de turismo poderão pagar para ter **prioridade nas recomendações**, aparecendo no topo das listagens.
