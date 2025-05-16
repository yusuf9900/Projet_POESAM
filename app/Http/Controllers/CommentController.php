<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Publication;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Stocker un nouveau commentaire
    public function store(Request $request)
    {
        $request->validate([
            'contenu' => 'required|string',
            'publication_id' => 'required|exists:publications,id'
        ]);

        $comment = new Commentaire();
        $comment->contenu = $request->contenu;
        $comment->publication_id = $request->publication_id;
        $comment->date_commentaire = now();
        
        // Si l'utilisateur est connecté, associer son ID
        if (session('user_id') && is_numeric(session('user_id'))) {
            $comment->user_id = (int)session('user_id');
        } else {
            // Valeur par défaut pour user_id si non spécifiée (utilisateur invité/système)
            $comment->user_id = 1; // ID de l'utilisateur système ou admin par défaut
        }
        
        $comment->save();
        
        // Rediriger vers la publication avec un message de succès
        return back()->with('success', 'Votre commentaire a été ajouté');
    }

    // Supprimer un commentaire
    public function destroy(Commentaire $commentaire)
    {
        // Vérifier que l'utilisateur est autorisé à supprimer ce commentaire
        if (session('user_id') == $commentaire->user_id || session('user_type') == 'admin') {
            $commentaire->delete();
            return back()->with('success', 'Commentaire supprimé avec succès');
        }
        
        return back()->with('error', 'Vous n\'êtes pas autorisé à supprimer ce commentaire');
    }
}
