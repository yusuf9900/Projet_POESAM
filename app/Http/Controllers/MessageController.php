<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    /**
     * Afficher la liste des conversations de l'utilisateur
     */
    public function index()
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/')->with('error', 'Vous devez être connecté pour accéder à la messagerie');
        }
        
        // Récupérer toutes les conversations de l'utilisateur avec le dernier message
        $conversations = Conversation::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with(['dernierMessage', 'users'])->get();
        
        // Récupérer la liste des utilisateurs pour créer de nouvelles conversations
        $users = User::where('id', '!=', $userId)->get();
        
        return view('messages.index', compact('conversations', 'users'));
    }
    
    /**
     * Afficher une conversation
     */
    public function show($id)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/')->with('error', 'Vous devez être connecté pour accéder à la messagerie');
        }
        
        $conversation = Conversation::findOrFail($id);
        
        // Vérifier si l'utilisateur est membre de la conversation
        if (!$conversation->estMembre($userId)) {
            return redirect()->route('messages.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette conversation');
        }
        
        // Marquer tous les messages non lus comme lus
        Message::where('conversation_id', $id)
            ->where('user_id', '!=', $userId)
            ->where('est_lu', false)
            ->update(['est_lu' => true]);
        
        // Mettre à jour le timestamp de dernier accès
        $conversation->users()->updateExistingPivot($userId, ['dernier_accès' => now()]);
        
        // Récupérer les messages de la conversation
        $messages = $conversation->messages()->with('user')->get();
        
        // Récupérer les membres de la conversation
        $members = $conversation->users()->get();
        
        return view('messages.show', compact('conversation', 'messages', 'members'));
    }
    
    /**
     * Créer une nouvelle conversation
     */
    public function storeConversation(Request $request)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/')->with('error', 'Vous devez être connecté pour créer une conversation');
        }
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'titre' => 'nullable|string|max:255',
        ]);
        
        // Vérifier si une conversation existe déjà entre ces deux utilisateurs
        $existingConversation = Conversation::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->whereHas('users', function ($query) use ($request) {
            $query->where('user_id', $request->user_id);
        })->where('est_groupe', false)
        ->first();
        
        if ($existingConversation) {
            return redirect()->route('messages.show', $existingConversation->id);
        }
        
        // Créer une nouvelle conversation
        $conversation = Conversation::create([
            'titre' => $request->titre,
            'est_groupe' => false
        ]);
        
        // Ajouter les utilisateurs à la conversation
        $conversation->users()->attach([
            $userId => ['est_administrateur' => true, 'dernier_accès' => now()],
            $request->user_id => ['est_administrateur' => false, 'dernier_accès' => null]
        ]);
        
        return redirect()->route('messages.show', $conversation->id);
    }
    
    /**
     * Créer un groupe de discussion
     */
    public function storeGroupe(Request $request)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/')->with('error', 'Vous devez être connecté pour créer un groupe');
        }
        
        $request->validate([
            'titre' => 'required|string|max:255',
            'membres' => 'required|array|min:1',
            'membres.*' => 'exists:users,id'
        ]);
        
        // Créer une nouvelle conversation de groupe
        $conversation = Conversation::create([
            'titre' => $request->titre,
            'est_groupe' => true
        ]);
        
        // Ajouter l'utilisateur actuel comme administrateur
        $membres = [$userId => ['est_administrateur' => true, 'dernier_accès' => now()]];
        
        // Ajouter les autres membres
        foreach ($request->membres as $membreId) {
            if ($membreId != $userId) {
                $membres[$membreId] = ['est_administrateur' => false, 'dernier_accès' => null];
            }
        }
        
        $conversation->users()->attach($membres);
        
        return redirect()->route('messages.show', $conversation->id);
    }
    
    /**
     * Envoyer un message
     */
    public function storeMessage(Request $request, $conversationId)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/')->with('error', 'Vous devez être connecté pour envoyer un message');
        }
        
        $request->validate([
            'contenu' => 'required|string',
            'fichier' => 'nullable|file|max:10240', // Max 10 MB
        ]);
        
        $conversation = Conversation::findOrFail($conversationId);
        
        // Vérifier si l'utilisateur est membre de la conversation
        if (!$conversation->estMembre($userId)) {
            return redirect()->route('messages.index')->with('error', 'Vous n\'êtes pas autorisé à envoyer un message dans cette conversation');
        }
        
        $fichierAttaché = null;
        
        // Traiter le fichier attaché s'il existe
        if ($request->hasFile('fichier')) {
            $fichierAttaché = $request->file('fichier')->store('fichiers_messages', 'public');
        }
        
        // Créer le message
        $message = Message::create([
            'conversation_id' => $conversationId,
            'user_id' => $userId,
            'contenu' => $request->contenu,
            'fichier_attaché' => $fichierAttaché,
            'est_lu' => false
        ]);
        
        // Mettre à jour le timestamp de dernier accès
        $conversation->users()->updateExistingPivot($userId, ['dernier_accès' => now()]);
        
        // Si c'est une requête AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('user')
            ]);
        }
        
        return redirect()->route('messages.show', $conversation->id);
    }
    
    /**
     * Ajouter des membres à un groupe
     */
    public function addMembres(Request $request, $conversationId)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/')->with('error', 'Vous devez être connecté pour ajouter des membres');
        }
        
        $request->validate([
            'membres' => 'required|array|min:1',
            'membres.*' => 'exists:users,id'
        ]);
        
        $conversation = Conversation::findOrFail($conversationId);
        
        // Vérifier si l'utilisateur est administrateur du groupe
        $estAdmin = $conversation->users()
            ->where('user_id', $userId)
            ->where('est_administrateur', true)
            ->exists();
            
        if (!$estAdmin) {
            return redirect()->route('messages.show', $conversation->id)
                ->with('error', 'Vous n\'êtes pas autorisé à ajouter des membres à ce groupe');
        }
        
        // Ajouter les membres
        $membres = [];
        foreach ($request->membres as $membreId) {
            if (!$conversation->estMembre($membreId)) {
                $membres[$membreId] = ['est_administrateur' => false, 'dernier_accès' => null];
            }
        }
        
        if (!empty($membres)) {
            $conversation->users()->attach($membres);
        }
        
        return redirect()->route('messages.show', $conversation->id)
            ->with('success', 'Membres ajoutés avec succès');
    }
    
    /**
     * Quitter un groupe ou supprimer une conversation
     */
    public function leaveConversation($conversationId)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/')->with('error', 'Vous devez être connecté pour quitter une conversation');
        }
        
        $conversation = Conversation::findOrFail($conversationId);
        
        // Vérifier si l'utilisateur est membre de la conversation
        if (!$conversation->estMembre($userId)) {
            return redirect()->route('messages.index')
                ->with('error', 'Vous n\'êtes pas membre de cette conversation');
        }
        
        // Si c'est une conversation de groupe
        if ($conversation->est_groupe) {
            // Retirer l'utilisateur du groupe
            $conversation->users()->detach($userId);
            
            // Si le groupe est vide, le supprimer
            if ($conversation->users()->count() == 0) {
                $conversation->delete();
            }
        } else {
            // Pour une conversation à deux, supprimer la conversation
            $conversation->delete();
        }
        
        return redirect()->route('messages.index')
            ->with('success', 'Vous avez quitté la conversation');
    }
}
