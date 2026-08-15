@extends('layouts.app')
@section('title', 'Modo Offline — System-PITE')

@section('content')
<div class="container py-4">
    <!-- Banner de Modo Offline -->
    <div class="p-4 rounded-4 text-white mb-4 shadow" style="background: linear-gradient(135deg, #1e293b, #0f172a); border-left: 6px solid var(--pite-gold);">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:50px; height:50px; background:rgba(245,158,11,0.2); color:#fbbf24; font-size:1.6rem;">
                <i class="bi bi-cloud-slash"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-1" style="font-family:'Outfit';">Central de Acesso Offline às Informações</h4>
                <p class="mb-0 text-white text-opacity-80 small" style="max-width:680px;">
                    Projetado para garantir segurança e navegação em áreas rurais, cachoeiras, picos e trilhas com conectividade limitada. Os roteiros e contatos salvos no seu dispositivo continuam acessíveis mesmo sem sinal de internet.
                </p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Coluna de Roteiros Salvos no Dispositivo -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0" style="font-family:'Outfit';">
                        <i class="bi bi-phone text-success me-2"></i> Roteiros Armazenados no Dispositivo
                    </h5>
                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="limparCacheOffline()">
                        <i class="bi bi-trash me-1"></i> Limpar Armazenamento
                    </button>
                </div>

                <div id="listaOfflineContainer">
                    <div class="p-4 bg-light rounded-3 text-center text-muted">
                        <i class="bi bi-cloud-arrow-down fs-2 d-block mb-2 text-success"></i>
                        <p class="mb-0">Verificando roteiros salvos no armazenamento local...</p>
                    </div>
                </div>
            </div>

            <!-- Visualizador do Roteiro Selecionado -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white" id="detalheRoteiroOffline" style="display:none;">
                <div class="d-flex justify-content-between align-items-start mb-3 pb-2 border-bottom">
                    <div>
                        <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-1 mb-1">
                            <i class="bi bi-hdd-fill me-1"></i> Carregado da Memória Offline
                        </span>
                        <h4 class="fw-bold mb-1" id="offTitulo" style="font-family:'Outfit';"></h4>
                        <div class="text-muted small" id="offMeta"></div>
                    </div>
                </div>

                <p class="text-muted small mb-4" id="offDescricao"></p>

                <h6 class="fw-bold mb-3" style="font-family:'Outfit';"><i class="bi bi-signpost-split text-success me-2"></i>Paradas e Orientações Salvas</h6>
                <div class="d-flex flex-column gap-3 mb-4" id="offParadas"></div>
            </div>
        </div>

        <!-- Coluna de Telefones de Emergência e Dicas Offline -->
        <div class="col-lg-4">
            <!-- Telefones de Emergência Permanentes -->
            <div class="card border-0 shadow-sm rounded-4 p-4 text-white mb-4" style="background: linear-gradient(135deg, #b91c1c, #991b1b);">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-shield-fill-exclamation fs-4"></i>
                    <h5 class="fw-bold mb-0" style="font-family:'Outfit';">Emergência & Socorro</h5>
                </div>
                <p class="small text-white text-opacity-85 mb-3">
                    Telefones oficiais de atendimento 24 horas. Funcionam mesmo em roaming nacional:
                </p>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between p-2 rounded-2 bg-black bg-opacity-20 font-monospace">
                        <span>🚓 Polícia Militar</span>
                        <strong class="fs-6">190</strong>
                    </div>
                    <div class="d-flex justify-content-between p-2 rounded-2 bg-black bg-opacity-20 font-monospace">
                        <span>🚑 SAMU Ambulância</span>
                        <strong class="fs-6">192</strong>
                    </div>
                    <div class="d-flex justify-content-between p-2 rounded-2 bg-black bg-opacity-20 font-monospace">
                        <span>🚒 Corpo de Bombeiros</span>
                        <strong class="fs-6">193</strong>
                    </div>
                    <div class="d-flex justify-content-between p-2 rounded-2 bg-black bg-opacity-20 font-monospace">
                        <span>🛡️ Defesa Civil</span>
                        <strong class="fs-6">199</strong>
                    </div>
                    <div class="d-flex justify-content-between p-2 rounded-2 bg-black bg-opacity-20 font-monospace">
                        <span>🏛️ Guarda Municipal</span>
                        <strong class="fs-6">153</strong>
                    </div>
                </div>
            </div>

            <!-- Dicas de Segurança em Áreas Naturais -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h6 class="fw-bold mb-3" style="font-family:'Outfit';"><i class="bi bi-compass text-success me-2"></i>Dicas para Trilhas e Áreas Rurais</h6>
                <ul class="list-unstyled small text-muted d-flex flex-column gap-2 mb-0">
                    <li><i class="bi bi-check-circle-fill text-success me-1"></i> Avise alguém de sua confiança sobre a rota que você irá percorrer.</li>
                    <li><i class="bi bi-check-circle-fill text-success me-1"></i> Carregue a bateria do seu celular a 100% antes de sair.</li>
                    <li><i class="bi bi-check-circle-fill text-success me-1"></i> Mantenha garrafa de água para hidratação constante.</li>
                    <li><i class="bi bi-check-circle-fill text-success me-1"></i> Não saia das trilhas delimitadas e sinalizadas pelo município.</li>
                    <li><i class="bi bi-check-circle-fill text-success me-1"></i> Recolha todo o seu lixo (Princípio ESG Não Deixe Rastros).</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div style="height: 60px;"></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    carregarRoteirosOffline();
});

function carregarRoteirosOffline() {
    const container = document.getElementById('listaOfflineContainer');
    const lista = JSON.parse(localStorage.getItem('system_pite_offline_lista') || '[]');

    if (lista.length === 0) {
        container.innerHTML = `
            <div class="p-4 bg-light rounded-3 text-center text-muted">
                <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
                <h6>Nenhum roteiro salvo offline no momento.</h6>
                <p class="small mb-3">Para salvar um roteiro e usá-lo em trilhas sem sinal, acesse qualquer roteiro e clique em <strong>Salvar Roteiro Offline</strong>.</p>
                <a href="{{ route('portal.roteiros') }}" class="btn btn-pite btn-sm rounded-pill">
                    <i class="bi bi-search me-1"></i> Explorar Roteiros
                </a>
            </div>
        `;
        return;
    }

    let html = '<div class="row g-3">';
    lista.forEach(item => {
        html += `
            <div class="col-md-6">
                <div class="p-3 border rounded-3 bg-light h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h6 class="fw-bold mb-1" style="font-family:'Outfit';">${item.titulo}</h6>
                        <small class="text-muted d-block mb-2">⏱️ ${item.tempo} · 📍 ${item.distancia}</small>
                        <small class="text-muted" style="font-size:0.75rem;">Salvo em: ${item.salvo_em}</small>
                    </div>
                    <button class="btn btn-pite btn-sm rounded-pill mt-3" onclick="abrirRoteiroOffline(${item.id})">
                        <i class="bi bi-eye me-1"></i> Visualizar Roteiro
                    </button>
                </div>
            </div>
        `;
    });
    html += '</div>';

    container.innerHTML = html;
}

function abrirRoteiroOffline(id) {
    const raw = localStorage.getItem('system_pite_roteiro_' + id);
    if (!raw) {
        alert('Dados deste roteiro não encontrados no armazenamento local.');
        return;
    }

    const data = JSON.parse(raw);
    const rot = data.roteiro;
    const atrativos = rot.atrativos || [];

    const painel = document.getElementById('detalheRoteiroOffline');
    painel.style.display = 'block';

    document.getElementById('offTitulo').textContent = rot.titulo;
    document.getElementById('offMeta').textContent = `⏱️ ${rot.duracao_estimada_horas}h de duração · 📍 ${rot.distancia_total_km || 0} km`;
    document.getElementById('offDescricao').textContent = rot.descricao;

    let paradasHtml = '';
    atrativos.forEach((at, idx) => {
        const obs = at.pivot ? at.pivot.observacao : '';
        paradasHtml += `
            <div class="p-3 border rounded-3 bg-light">
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <span class="badge bg-success rounded-pill">Parada ${idx + 1}</span>
                    <small class="text-muted">${at.pivot ? at.pivot.tempo_estimado : ''}</small>
                </div>
                <h6 class="fw-bold mb-1">${at.nome}</h6>
                <p class="small text-muted mb-1">${at.descricao || ''}</p>
                <small class="text-muted d-block"><i class="bi bi-geo-alt me-1"></i>${at.endereco || 'Centro'}</small>
                ${obs ? `<small class="d-block text-success mt-1">💡 ${obs}</small>` : ''}
            </div>
        `;
    });

    document.getElementById('offParadas').innerHTML = paradasHtml;
    painel.scrollIntoView({ behavior: 'smooth' });
}

function limparCacheOffline() {
    if (confirm('Tem certeza que deseja apagar todos os roteiros salvos no dispositivo?')) {
        const lista = JSON.parse(localStorage.getItem('system_pite_offline_lista') || '[]');
        lista.forEach(item => {
            localStorage.removeItem('system_pite_roteiro_' + item.id);
        });
        localStorage.removeItem('system_pite_offline_lista');
        document.getElementById('detalheRoteiroOffline').style.display = 'none';
        carregarRoteirosOffline();
    }
}
</script>
@endpush
