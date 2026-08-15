<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Perfil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TuristaAuthController extends Controller
{
    /**
     * Exibe formulário de registro do turista.
     */
    public function showRegistro()
    {
        if (Auth::check() && Auth::user()->isTurista()) {
            return redirect()->route('turista.dashboard');
        }
        return view('auth.registro-turista');
    }

    /**
     * Processa o registro do turista.
     */
    public function registro(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'nacionalidade' => 'nullable|string|max:100',
            'cep' => 'nullable|string|max:20',
            'cidade_origem' => 'nullable|string|max:255',
            'estado_origem' => 'nullable|string|max:255',
            'pais_origem' => 'nullable|string|max:255',
            'possui_conjuge' => 'nullable|boolean',
            'possui_filhos' => 'nullable|boolean',
            'quantidade_filhos' => 'nullable|integer|min:0|max:20',
            'interesses' => 'nullable|array',
            'interesses.*' => 'string|in:natureza,historia,gastronomia,aventura,cultural,religioso,rural,negocios,saude,nautico,compras,familia',
            'necessidades_especiais' => 'nullable|array',
        ]);

        $perfilTurista = Perfil::where('slug', 'turista')->first();

        $possuiFilhos = $request->boolean('possui_filhos');
        $quantidadeFilhos = $possuiFilhos ? (int) ($validated['quantidade_filhos'] ?? 1) : 0;

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'perfil_id' => $perfilTurista?->id,
            'ativo' => true,
            'nacionalidade' => $validated['nacionalidade'] ?? 'Brasileira',
            'cep' => $validated['cep'] ?? null,
            'cidade_origem' => $validated['cidade_origem'] ?? null,
            'estado_origem' => $validated['estado_origem'] ?? null,
            'pais_origem' => $validated['pais_origem'] ?? 'Brasil',
            'possui_conjuge' => $request->boolean('possui_conjuge'),
            'possui_filhos' => $possuiFilhos,
            'quantidade_filhos' => $quantidadeFilhos,
            'interesses' => $validated['interesses'] ?? [],
            'necessidades_especiais' => $validated['necessidades_especiais'] ?? [],
        ]);

        Auth::login($user);

        return redirect()->route('turista.dashboard')
            ->with('bemVindo', 'Bem-vindo ao System-PITE! Sua jornada turística começa agora.');
    }

    /**
     * Exibe formulário de login unificado para todos os perfis (Turista, Prefeito, Secretário, Servidor, Empreendedor).
     */
    public function showLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isTurista()) {
                return redirect()->route('turista.dashboard');
            }
            if ($user->isEmpreendedor()) {
                return redirect()->route('empreendedor.dashboard');
            }
            if ($user->isAdmin() || $user->isPrefeito() || $user->isSecretario() || $user->isServidor()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('portal.home');
        }
        return view('auth.login-turista');
    }

    /**
     * Processa o login unificado do sistema.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('lembrar') || $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->isTurista()) {
                return redirect()->intended(route('turista.dashboard'));
            }
            if ($user->isEmpreendedor()) {
                return redirect()->intended(route('empreendedor.dashboard'));
            }
            if ($user->isAdmin() || $user->isPrefeito() || $user->isSecretario() || $user->isServidor()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('portal.home'));
        }

        return back()->withErrors([
            'email' => 'As credenciais informadas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    /**
     * Exibe formulário de cadastro exclusivo para novos empreendedores locais.
     */
    public function showRegistroEmpreendedor()
    {
        if (Auth::check()) {
            if (Auth::user()->isEmpreendedor()) {
                return redirect()->route('empreendedor.cadastro');
            }
            return redirect()->route('portal.home');
        }
        return view('auth.registro-empreendedor');
    }

    /**
     * Processa o cadastro de novo usuário empreendedor e submete seu estabelecimento inicial.
     */
    public function registroEmpreendedor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'razao_social' => 'required|string|max:255',
            'nome_fantasia' => 'nullable|string|max:255',
            'cnpj_cpf' => 'required|string|max:20',
            'tipo_servico' => 'required|string|in:hospedagem,gastronomia,guia,artesanato,transporte,agencia,experiencia',
            'descricao' => 'nullable|string|max:1000',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:100',
            'instagram' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
        ]);

        $perfilEmpreendedor = Perfil::where('slug', 'empreendedor')->first();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'perfil_id' => $perfilEmpreendedor?->id,
            'ativo' => true,
        ]);

        $empreendedor = \App\Models\Empreendedor::create([
            'user_id' => $user->id,
            'razao_social' => $validated['razao_social'],
            'nome_fantasia' => $validated['nome_fantasia'] ?? $validated['razao_social'],
            'cnpj_cpf' => $validated['cnpj_cpf'],
            'tipo_servico' => $validated['tipo_servico'],
            'descricao' => $validated['descricao'] ?? null,
            'telefone' => $validated['telefone'] ?? null,
            'email' => $validated['email'],
            'website' => $validated['website'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'endereco' => $validated['endereco'] ?? null,
            'bairro' => $validated['bairro'] ?? null,
            'status_aprovacao' => 'pendente',
            'selo_validado' => false,
        ]);

        \App\Models\Auditoria::registrar(
            'autocadastro_empreendedor',
            'empreendedores',
            $empreendedor->id,
            null,
            $empreendedor->toArray()
        );

        Auth::login($user);

        return redirect()->route('empreendedor.dashboard')
            ->with('sucesso', 'Conta de Empreendedor criada com sucesso! O estabelecimento "' . ($empreendedor->nome_fantasia ?? $empreendedor->razao_social) . '" foi enviado para homologação da Secretaria Municipal de Turismo.');
    }
}
