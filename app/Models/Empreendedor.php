<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empreendedor extends Model
{
    use HasFactory;

    protected $table = 'empreendedores';

    protected $fillable = [
        'user_id',
        'razao_social',
        'nome_fantasia',
        'cnpj_cpf',
        'tipo_servico', // hospedagem, gastronomia, guia, artesanato, transporte, agencia
        'descricao',
        'endereco',
        'bairro',
        'telefone',
        'email',
        'website',
        'instagram',
        'status_aprovacao', // pendente, aprovado, rejeitado, suspenso
        'selo_validado',
        'vencimento_documentos',
        'observacoes_admin',
        'aprovado_por_user_id'
    ];

    protected $casts = [
        'selo_validado' => 'boolean',
        'vencimento_documentos' => 'date'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function aprovador()
    {
        return $this->belongsTo(User::class, 'aprovado_por_user_id');
    }
}
