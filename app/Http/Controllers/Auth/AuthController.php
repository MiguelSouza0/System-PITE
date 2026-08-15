<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Usuário ou senha incorretos. Verifique os dados digitados.',
        ])->onlyInput('email');
    }

    public function quickLogin(string $perfil)
    {
        $emails = [
            'prefeito' => 'prefeito@municipio.gov.br',
            'secretario' => 'secretario.turismo@municipio.gov.br',
            'servidor' => 'tecnico.turismo@municipio.gov.br',
        ];

        if (!isset($emails[$perfil])) {
            return redirect()->route('login');
        }

        $user = User::where('email', $emails[$perfil])->first();
        if ($user) {
            Auth::login($user);
            request()->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('login')->with('error', 'Usuário não encontrado. Execute as migrações e seeders.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('portal.home');
    }
}
