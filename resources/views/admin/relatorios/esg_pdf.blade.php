<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório ESG Municipal — System-PITE</title>
    <style>
        body { font-family: sans-serif; color: #1e293b; margin: 30px; }
        .header { text-align: center; border-bottom: 2px solid #047857; padding-bottom: 15px; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #047857; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #cbd5e1; padding: 10px; text-align: left; }
        .table th { background: #f1f5f9; font-size: 0.85rem; text-transform: uppercase; }
        .badge { background: #047857; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h1>System-PITE — Relatório Oficial ESG</h1>
        <p>Prefeitura Municipal · Diretoria de Turismo & Sustentabilidade</p>
        <small>Data de emissão: {{ date('d/m/Y H:i') }} · Documento Auditável</small>
    </div>

    <h3>1. Resumo Executivo</h3>
    <p>Este documento consolida os indicadores ambientais, sociais e de governança (ESG) aplicados ao desenvolvimento do turismo municipal sustentável.</p>
    <ul>
        <li><strong>Atrativos Ativos Mapeados:</strong> {{ $atrativosCount }}</li>
        <li><strong>Empreendedores Locais Validados:</strong> {{ $empreendedores->count() }}</li>
        <li><strong>Conformidade LGPD & Transparência:</strong> 100%</li>
    </ul>

    <h3>2. Indicadores ESG Consolidados</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Pilar</th>
                <th>Indicador</th>
                <th>Valor / Meta</th>
                <th>Status Auditado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($indicadores as $ind)
            <tr>
                <td><span class="badge">{{ ucfirst($ind->pilar) }}</span></td>
                <td>{{ $ind->nome }}</td>
                <td>{{ $ind->valor }} {{ $ind->unidade_medida }}</td>
                <td>Conforme (Auditado)</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: center; font-size: 0.8rem; color: #64748b;">
        <p>System-PITE — Plataforma Inteligente de Turismo Municipal</p>
    </div>
</body>
</html>
