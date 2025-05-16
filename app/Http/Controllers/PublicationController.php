<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class PublicationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|max:50',
            'contenu' => 'required',
            'categorie' => 'nullable|max:50',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4|max:10240'
        ]);

        $publication = new Publication();
        $publication->titre = $request->titre;
        $publication->contenu = $request->contenu;
        $publication->date_publication = now();
        $publication->est_anonyme = $request->has('est_anonyme');
        $publication->categorie = $request->categorie ?: 'general';
        
        // Si l'utilisateur est connecté, associer son ID mais garder l'anonymat
        if (session('user_id') && is_numeric(session('user_id'))) {
            $publication->user_id = (int)session('user_id');
        } else {
            // Valeur par défaut pour user_id si non spécifiée (utilisateur invité/système)
            $publication->user_id = 1; // ID de l'utilisateur système ou admin par défaut
        }

        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('publications', 'public');
            $publication->media = $mediaPath;
        }

        $publication->save();

        return redirect('/home')->with('success', 'Votre publication a été partagée avec succès.');
    }

    public function index()
    {
        $publications = Publication::with('user')
            ->orderBy('date_publication', 'desc')
            ->paginate(10);
            
        return view('publications.index', compact('publications'));
    }
}
