<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use App\Models\Publication;
use App\Models\Commentaire;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    /**
     * Stocker ou mettre à jour une réaction
     * Supporte les requêtes GET et POST
     */
    public function store(Request $request)
    {
        // Validation des entrées
        $request->validate([
            'type_reaction' => 'required|string',
            'publication_id' => 'required_without:commentaire_id|exists:publications,id',
            'commentaire_id' => 'required_without:publication_id|exists:commentaires,id'
        ]);
        
        // Si c'est une requête GET (liens simples), ajouter un jeton CSRF
        if ($request->isMethod('get')) {
            $request->session()->regenerateToken();
        }
        
        // Obtenir l'ID utilisateur depuis la session
        $userId = session('user_id') ? (int)session('user_id') : 1;
        
        // Déterminer si c'est une réaction pour un commentaire ou une publication
        $isCommentReaction = $request->has('commentaire_id');
        $elementId = $isCommentReaction ? $request->commentaire_id : $request->publication_id;
        $elementType = $isCommentReaction ? 'commentaire' : 'publication';
        
        // Trouver la réaction existante (peu importe le type)
        $existingReaction = Reaction::where($elementType . '_id', $elementId)
            ->where('user_id', $userId)
            ->first();
            
        // Variables de réponse
        $isActive = false;
        $message = '';
        
        // Traitement de la réaction
        if ($existingReaction && $existingReaction->type === $request->type_reaction) {
            // Si la réaction est du même type, on la supprime (toggle)
            $existingReaction->delete();
            $message = 'Réaction retirée';
        } elseif ($existingReaction) {
            // Si la réaction est d'un autre type, on la modifie
            $oldType = $existingReaction->type;
            $existingReaction->type = $request->type_reaction;
            $existingReaction->save();
            $message = 'Réaction changée';
            $isActive = true;
        } else {
            // Si aucune réaction n'existe, on en crée une nouvelle
            $reaction = new Reaction();
            if ($isCommentReaction) {
                $reaction->commentaire_id = $elementId;
            } else {
                $reaction->publication_id = $elementId;
            }
            $reaction->user_id = $userId;
            $reaction->type = $request->type_reaction;
            $reaction->save();
            $message = 'Réaction ajoutée';
            $isActive = true;
        }
        
        // Préparation des données de réponse
        $reactionTypes = ['soutien', 'encouragement', 'solidarite', 'pouce', 'genial'];
        
        // Récupérer toutes les réactions pour l'élément
        $allReactions = Reaction::where($elementType . '_id', $elementId)->get();
        
        // Compter par type
        $counts = [];
        foreach ($reactionTypes as $type) {
            $counts[$type] = $allReactions->where('type', $type)->count();
        }
        
        // Compter spécifiquement pour le type demandé
        $count = $allReactions->where('type', $request->type_reaction)->count();
        
        // Total des réactions
        $totalReactions = $allReactions->count();
        
        // Réaction actuelle de l'utilisateur
        $userCurrentReaction = Reaction::where($elementType . '_id', $elementId)
            ->where('user_id', $userId)
            ->first();
        $currentReactionType = $userCurrentReaction ? $userCurrentReaction->type : null;
        
        // Réponse en fonction du type de requête
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'count' => $count,
                'counts' => $counts,
                'totalReactions' => $totalReactions,
                'active' => $isActive,
                'type' => $request->type_reaction,
                'userReactionType' => $currentReactionType,
                'isCommentReaction' => $isCommentReaction,
                'elementId' => $elementId,
                'elementType' => $elementType
            ]);
        }
        
        // Si c'est une requête GET (liens simples), rediriger vers la page précédente
        if ($request->isMethod('get')) {
            // Ajouter un paramètre pour forcer le rechargement (empecher la mise en cache)
            $backUrl = url()->previous() . (parse_url(url()->previous(), PHP_URL_QUERY) ? '&' : '?') . 'refresh=' . time();
            return redirect($backUrl)->with('success', $message);
        }
        
        // Redirection standard pour les requêtes POST non-AJAX
        return back()->with('success', $message);
    }
    
    /**
     * Supprimer une réaction
     */
    public function destroy(Reaction $reaction)
    {
        // Vérifier l'autorisation
        if (session('user_id') == $reaction->user_id || session('user_type') == 'admin') {
            $reaction->delete();
            return back()->with('success', 'Réaction supprimée');
        }
        
        return back()->with('error', 'Vous n\'\u00eates pas autorisé à supprimer cette réaction');
    }
}