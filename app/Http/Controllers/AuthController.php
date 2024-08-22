<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function handleLogin(AuthRequest $request)
    {
        // Récupérer les informations d'identification de la requête
        $credentials = $request->only(['email', 'password']);

        // Tenter de connecter l'utilisateur
        if (Auth::attempt($credentials)) {
            // Vérifier que l'utilisateur est bien authentifié
            if (Auth::check()) {
                // Rediriger vers le tableau de bord avec un message de succès
                return redirect()->route('dashboard')->with('success_msg', 'Vous etes connectés!');
            }
        } else {
            // Si la tentative échoue, retourner à la page de connexion avec un message d'erreur
            return redirect()->back()->with('error_msg', 'Paramètre de connexion non reconnu');
        }
    }
}
