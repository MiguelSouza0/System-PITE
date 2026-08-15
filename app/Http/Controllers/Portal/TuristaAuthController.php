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
     * Exibe formulário de login do turista.
     */
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->isTurista()) {
            return redirect()->route('turista.dashboard');
        }
        return view('auth.login-turista');
    }

    /**
     * Processa o login do turista.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('lembrar'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->isTurista()) {
                return redirect()->intended(route('turista.dashboard'));
            }

            // Se não é turista, redireciona conforme perfil
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            if ($user->isEmpreendedor()) {
                return redirect()->route('empreendedor.dashboard');
            }

            return redirect()->route('portal.home');
        }

        return back()->withErrors([
            'email' => 'As credenciais informadas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }
}
