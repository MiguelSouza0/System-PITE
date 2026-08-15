<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atrativo;
use App\Models\Empreendedor;
use App\Models\IndicadorEsg;

class RelatorioController extends Controller
{
    /**
     * Exporta relatório em formato CSV de Dados Abertos de Turismo Municipal.
     */
    public function exportarCsv()
    {
        $fileName = 'dados_abertos_turismo_' . date('Y-m-d') . '.csv';
        $atrativos = Atrativo::with('categoria')->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($atrativos) {
            $file = fopen('php://output', 'w');
            // UTF-8 BOM para Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, ['ID', 'Nome', 'Categoria', 'Endereco', 'Latitude', 'Longitude', 'Horario', 'Status']);

            foreach ($atrativos as $at) {
                fputcsv($file, [
                    $at->id,
                    $at->nome,
                    $at->categoria->nome ?? 'Geral',
                    $at->endereco,
                    $at->latitude,
                    $at->longitude,
                    $at->horario_funcionamento,
                    $at->ativo ? 'Ativo' : 'Inativo'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Exporta Relatório de Governança ESG Municipal em formato HTML impresso/PDF.
     */
    public function exportarEsgPdf()
    {
        $indicadores = IndicadorEsg::all();
        $empreendedores = Empreendedor::where('status_aprovacao', 'aprovado')->get();
        $atrativosCount = Atrativo::where('ativo', true)->count();

        return view('admin.relatorios.esg_pdf', compact('indicadores', 'empreendedores', 'atrativosCount'));
    }
}
