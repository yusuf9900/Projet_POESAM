<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer les publications
        $publications = Publication::orderBy('date_publication', 'desc')->get();

        // Vérifier si l'utilisateur est connecté
        if (isset($_COOKIE['is_logged_in']) && $_COOKIE['is_logged_in'] === 'true') {
            // Mettre à jour la session avec les données des cookies
            session([
                'user_id' => $_COOKIE['user_id'] ?? null,
                'user_email' => $_COOKIE['user_email'] ?? null,
                'user_name' => $_COOKIE['user_name'] ?? null,
                'user_type' => $_COOKIE['user_type'] ?? null,
                'is_logged_in' => true
            ]);

            // Vérifier le type d'utilisateur
            if (isset($_COOKIE['user_type'])) {
                if ($_COOKIE['user_type'] === 'admin') {
                    return redirect('/admin/dashboard');
                } elseif ($_COOKIE['user_type'] === 'organisation') {
                    return redirect('/organisation/dashboard');
                }
                // Les victimes restent sur la page home
            }
        }
        
        // Afficher la page home avec les publications pour tout le monde
        return view('home', compact('publications'));
    }
}
