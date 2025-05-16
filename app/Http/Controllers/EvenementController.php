<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EvenementController extends Controller
{
    /**
     * Afficher la liste des événements
     */
    public function index()
    {
        $evenements = Evenement::orderBy('date_evenement', 'asc')
                               ->where('date_evenement', '>=', now())
                               ->paginate(10);
                               
        $evenementsPasses = Evenement::orderBy('date_evenement', 'desc')
                                    ->where('date_evenement', '<', now())
                                    ->limit(5)
                                    ->get();
        
        return view('evenements.index', compact('evenements', 'evenementsPasses'));
    }
    
    /**
     * Afficher le formulaire de création d'un événement
     */
    public function create()
    {
        // Vérifier si l'utilisateur a les droits d'accès
        $userId = session('user_id');
        $user = User::find($userId);
        
        if (!$user) {
            return redirect()->route('evenements.index')
                             ->with('error', 'Vous devez être connecté pour créer un événement');
        }
        
        // Vérifier si l'utilisateur est un admin ou une ONG
        if (!in_array($user->user_type, ['admin', 'ong'])) {
            return redirect()->route('evenements.index')
                             ->with('error', 'Vous n\'avez pas les droits pour créer un événement');
        }
        
        return view('evenements.create');
    }
    
    /**
     * Enregistrer un nouvel événement
     */
    public function store(Request $request)
    {
        // Vérifier si l'utilisateur a les droits d'accès
        $userId = session('user_id');
        $user = User::find($userId);
        
        if (!$user || !in_array($user->user_type, ['admin', 'ong'])) {
            return redirect()->route('evenements.index')
                             ->with('error', 'Action non autorisée');
        }
        
        // Valider les données
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'date_evenement' => 'required|date|after:today',
            'heure_evenement' => 'required',
            'adresse' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'places_disponibles' => 'required|integer|min:1',
        ]);
        
        // Créer l'événement
        $evenement = new Evenement();
        $evenement->nom = $request->nom;
        $evenement->description = $request->description;
        
        // Concaténer la date et l'heure
        $dateTime = $request->date_evenement . ' ' . $request->heure_evenement;
        $evenement->date_evenement = date('Y-m-d H:i:s', strtotime($dateTime));
        
        $evenement->adresse = $request->adresse;
        $evenement->places_disponibles = $request->places_disponibles;
        $evenement->places_reservees = 0;
        $evenement->organisation_id = $user->organisation_id ?? null;
        $evenement->user_id = $userId;
        
        // Traiter l'image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . Str::slug($request->nom) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('evenements', $fileName, 'public');
            $evenement->image = $path;
        }
        
        $evenement->save();
        
        return redirect()->route('evenements.show', $evenement->id)
                         ->with('success', 'Événement créé avec succès');
    }
    
    /**
     * Afficher un événement
     */
    public function show($id)
    {
        $evenement = Evenement::with('user')->findOrFail($id);
        
        // Vérifier si l'utilisateur est inscrit à l'événement
        $userId = session('user_id');
        $estInscrit = false;
        
        if ($userId) {
            $estInscrit = DB::table('evenement_participants')
                            ->where('evenement_id', $id)
                            ->where('user_id', $userId)
                            ->exists();
        }
        
        // Événements similaires
        $evenementsSimilaires = Evenement::where('id', '!=', $id)
                                       ->where('date_evenement', '>=', now())
                                       ->limit(3)
                                       ->get();
        
        return view('evenements.show', compact('evenement', 'estInscrit', 'evenementsSimilaires'));
    }
    
    /**
     * Participer à un événement
     */
    public function participer($id)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('evenements.show', $id)
                             ->with('error', 'Vous devez être connecté pour participer');
        }
        
        $evenement = Evenement::findOrFail($id);
        
        // Vérifier si l'événement est complet
        if ($evenement->places_reservees >= $evenement->places_disponibles) {
            return redirect()->route('evenements.show', $id)
                             ->with('error', 'Désolé, cet événement est complet');
        }
        
        // Vérifier si l'utilisateur est déjà inscrit
        $dejaInscrit = DB::table('evenement_participants')
                            ->where('evenement_id', $id)
                            ->where('user_id', $userId)
                            ->exists();
        
        if ($dejaInscrit) {
            return redirect()->route('evenements.show', $id)
                             ->with('error', 'Vous êtes déjà inscrit à cet événement');
        }
        
        // Ajouter l'utilisateur à la liste des participants
        DB::table('evenement_participants')->insert([
            'evenement_id' => $id,
            'user_id' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Mettre à jour le nombre de places réservées
        $evenement->increment('places_reservees');
        
        return redirect()->route('evenements.show', $id)
                         ->with('success', 'Vous êtes maintenant inscrit à cet événement');
    }
    
    /**
     * Annuler la participation à un événement
     */
    public function annuler($id)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('evenements.show', $id)
                             ->with('error', 'Vous devez être connecté pour annuler votre participation');
        }
        
        $evenement = Evenement::findOrFail($id);
        
        // Vérifier si l'utilisateur est inscrit
        $inscrit = DB::table('evenement_participants')
                        ->where('evenement_id', $id)
                        ->where('user_id', $userId);
        
        if (!$inscrit->exists()) {
            return redirect()->route('evenements.show', $id)
                             ->with('error', 'Vous n\'êtes pas inscrit à cet événement');
        }
        
        // Supprimer l'inscription
        $inscrit->delete();
        
        // Décrémenter le nombre de places réservées
        $evenement->decrement('places_reservees');
        
        return redirect()->route('evenements.show', $id)
                         ->with('success', 'Votre participation a été annulée');
    }
    
    /**
     * Afficher le formulaire de modification d'un événement
     */
    public function edit($id)
    {
        $userId = session('user_id');
        $user = User::find($userId);
        $evenement = Evenement::findOrFail($id);
        
        // Vérifier les droits d'accès
        if (!$user || !in_array($user->user_type, ['admin', 'ong'])) {
            return redirect()->route('evenements.index')
                             ->with('error', 'Action non autorisée');
        }
        
        // Vérifier si l'utilisateur est l'organisateur ou un admin
        if ($user->user_type !== 'admin' && $evenement->user_id !== $userId) {
            return redirect()->route('evenements.index')
                             ->with('error', 'Vous ne pouvez pas modifier cet événement');
        }
        
        return view('evenements.edit', compact('evenement'));
    }
    
    /**
     * Mettre à jour un événement
     */
    public function update(Request $request, $id)
    {
        $userId = session('user_id');
        $user = User::find($userId);
        $evenement = Evenement::findOrFail($id);
        
        // Vérifier les droits d'accès
        if (!$user || !in_array($user->user_type, ['admin', 'ong'])) {
            return redirect()->route('evenements.index')
                             ->with('error', 'Action non autorisée');
        }
        
        // Vérifier si l'utilisateur est l'organisateur ou un admin
        if ($user->user_type !== 'admin' && $evenement->user_id !== $userId) {
            return redirect()->route('evenements.index')
                             ->with('error', 'Vous ne pouvez pas modifier cet événement');
        }
        
        // Valider les données
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'date_evenement' => 'required|date',
            'heure_evenement' => 'required',
            'adresse' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'places_disponibles' => 'required|integer|min:' . $evenement->places_reservees,
        ]);
        
        // Mettre à jour l'événement
        $evenement->nom = $request->nom;
        $evenement->description = $request->description;
        
        // Concaténer la date et l'heure
        $dateTime = $request->date_evenement . ' ' . $request->heure_evenement;
        $evenement->date_evenement = date('Y-m-d H:i:s', strtotime($dateTime));
        
        $evenement->adresse = $request->adresse;
        $evenement->places_disponibles = $request->places_disponibles;
        
        // Traiter l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($evenement->image) {
                Storage::disk('public')->delete($evenement->image);
            }
            
            $image = $request->file('image');
            $fileName = time() . '_' . Str::slug($request->nom) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('evenements', $fileName, 'public');
            $evenement->image = $path;
        }
        
        $evenement->save();
        
        return redirect()->route('evenements.show', $evenement->id)
                         ->with('success', 'Événement mis à jour avec succès');
    }
    
    /**
     * Supprimer un événement
     */
    public function destroy($id)
    {
        $userId = session('user_id');
        $user = User::find($userId);
        $evenement = Evenement::findOrFail($id);
        
        // Vérifier les droits d'accès
        if (!$user || !in_array($user->user_type, ['admin', 'ong'])) {
            return redirect()->route('evenements.index')
                             ->with('error', 'Action non autorisée');
        }
        
        // Vérifier si l'utilisateur est l'organisateur ou un admin
        if ($user->user_type !== 'admin' && $evenement->user_id !== $userId) {
            return redirect()->route('evenements.index')
                             ->with('error', 'Vous ne pouvez pas supprimer cet événement');
        }
        
        // Supprimer l'image
        if ($evenement->image) {
            Storage::disk('public')->delete($evenement->image);
        }
        
        // Supprimer les inscriptions
        DB::table('evenement_participants')->where('evenement_id', $id)->delete();
        
        // Supprimer l'événement
        $evenement->delete();
        
        return redirect()->route('evenements.index')
                         ->with('success', 'Événement supprimé avec succès');
    }
    
    /**
     * Afficher les événements à venir
     */
    public function aVenir()
    {
        $evenements = Evenement::orderBy('date_evenement', 'asc')
                               ->where('date_evenement', '>=', now())
                               ->paginate(10);
        
        return view('evenements.a-venir', compact('evenements'));
    }
    
    /**
     * Afficher les événements passés
     */
    public function passes()
    {
        $evenements = Evenement::orderBy('date_evenement', 'desc')
                               ->where('date_evenement', '<', now())
                               ->paginate(10);
        
        return view('evenements.passes', compact('evenements'));
    }
    
    /**
     * Afficher les événements de l'utilisateur
     */
    public function mesEvenements()
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('evenements.index')
                             ->with('error', 'Vous devez être connecté pour voir vos événements');
        }
        
        // Événements organisés
        $evenementsOrganises = Evenement::where('user_id', $userId)
                                       ->orderBy('date_evenement', 'desc')
                                       ->get();
        
        // Événements auxquels l'utilisateur participe
        $evenementsParticipes = Evenement::join('evenement_participants', 'evenements.id', '=', 'evenement_participants.evenement_id')
                                        ->where('evenement_participants.user_id', $userId)
                                        ->orderBy('evenements.date_evenement', 'desc')
                                        ->select('evenements.*')
                                        ->get();
        
        return view('evenements.mes-evenements', compact('evenementsOrganises', 'evenementsParticipes'));
    }
    
    /**
     * Rechercher des événements
     */
    public function recherche(Request $request)
    {
        $query = $request->input('q');
        
        $evenements = Evenement::where(function($queryBuilder) use ($query) {
                                $queryBuilder->where('nom', 'LIKE', "%{$query}%")
                                           ->orWhere('description', 'LIKE', "%{$query}%")
                                           ->orWhere('adresse', 'LIKE', "%{$query}%");
                            })
                            ->orderBy('date_evenement', 'asc')
                            ->paginate(10);
        
        return view('evenements.recherche', compact('evenements', 'query'));
    }
}
