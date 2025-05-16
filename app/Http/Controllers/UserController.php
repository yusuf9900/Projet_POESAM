<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Publication;
use App\Models\Commentaire;

class UserController extends Controller
{
    /**
     * Afficher le profil de l'utilisateur
     */
    public function profile()
    {
        // Récupérer l'ID de l'utilisateur depuis la session
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/')->with('error', 'Vous devez être connecté pour accéder à votre profil');
        }
        
        // Récupérer l'utilisateur
        $user = User::find($userId);
        
        if (!$user) {
            return redirect('/')->with('error', 'Profil non trouvé');
        }
        
        // Récupérer les publications de l'utilisateur
        $publications = Publication::where('user_id', $userId)
            ->orderBy('date_publication', 'desc')
            ->get();
        
        // Récupérer les commentaires de l'utilisateur
        $commentaires = Commentaire::where('user_id', $userId)
            ->orderBy('date_commentaire', 'desc')
            ->get();
        
        // Statistiques
        $stats = [
            'total_publications' => $publications->count(),
            'total_commentaires' => $commentaires->count(),
            'total_reactions_reçues' => $this->getTotalReactions($userId),
        ];
        
        return view('profile', compact('user', 'publications', 'commentaires', 'stats'));
    }
    
    /**
     * Mettre à jour le profil de l'utilisateur
     */
    public function update(Request $request)
    {
        // Récupérer l'ID de l'utilisateur depuis la session
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/')->with('error', 'Vous devez être connecté pour mettre à jour votre profil');
        }
        
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$userId,
            'bio' => 'nullable|string|max:500',
            'telephone' => 'nullable|string|max:20',
            'localisation' => 'nullable|string|max:255',
        ]);
        
        // Récupérer l'utilisateur
        $user = User::find($userId);
        
        if (!$user) {
            return redirect('/')->with('error', 'Profil non trouvé');
        }
        
        // Mettre à jour les informations
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;
        $user->telephone = $request->telephone;
        $user->localisation = $request->localisation;
        
        // Gestion de l'avatar si présent
        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }
        
        $user->save();
        
        // Mettre à jour les informations de session si nécessaire
        session(['user_name' => $user->name]);
        
        return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès');
    }
    
    /**
     * Calculer le nombre total de réactions reçues par l'utilisateur
     */
    private function getTotalReactions($userId)
    {
        // Récupérer les IDs des publications de l'utilisateur
        $publicationIds = Publication::where('user_id', $userId)->pluck('id')->toArray();
        
        // Récupérer les IDs des commentaires de l'utilisateur
        $commentaireIds = Commentaire::where('user_id', $userId)->pluck('id')->toArray();
        
        // Compter les réactions sur les publications
        $pubReactions = \App\Models\Reaction::whereIn('publication_id', $publicationIds)->count();
        
        // Compter les réactions sur les commentaires
        $comReactions = \App\Models\Reaction::whereIn('commentaire_id', $commentaireIds)->count();
        
        return $pubReactions + $comReactions;
    }
}
