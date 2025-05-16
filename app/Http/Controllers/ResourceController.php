<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Resource;
use App\Models\ResourceCategory;
use App\Models\User;

class ResourceController extends Controller
{
    /**
     * Afficher la liste des ressources
     */
    public function index()
    {
        $resources = Resource::with('user')
                            ->orderBy('created_at', 'desc')
                            ->paginate(12);
        
        // On n'a pas de catégories dans cette version, on utilise les types de ressources 
        $types = Resource::select('type_ressource')->distinct()->get();
        
        return view('resources.index', compact('resources', 'types'));
    }
    
    /**
     * Afficher une catégorie spécifique
     */
    public function category($type)
    {
        $resources = Resource::where('type_ressource', $type)
                           ->orderBy('created_at', 'desc')
                           ->paginate(12);
        
        $types = Resource::select('type_ressource')->distinct()->get();
        
        return view('resources.index', compact('resources', 'types', 'type'));
    }
    
    /**
     * Afficher une ressource spécifique
     */
    public function show($id)
    {
        $resource = Resource::with('user', 'organisation')->findOrFail($id);
        
        // Pas de compteur de vues dans cette table
        
        // Ressources similaires
        $similarResources = Resource::where('id', '!=', $resource->id)
                                  ->where('type_ressource', $resource->type_ressource)
                                  ->limit(4)
                                  ->get();
        
        return view('resources.show', compact('resource', 'similarResources'));
    }
    
    /**
     * Formulaire de création d'une ressource
     */
    public function create()
    {
        // Vérifier si l'utilisateur a le droit de créer une ressource
        $userId = session('user_id');
        $user = User::find($userId);
        $organisations = \App\Models\Organisation::all();
        
        if (!$user) {
            return redirect()->route('resources.index')->with('error', 'Vous devez être connecté pour ajouter des ressources');
        }
        
        return view('resources.create', compact('organisations'));
    }
    
    /**
     * Enregistrement d'une nouvelle ressource
     */
    public function store(Request $request)
    {
        // Vérifier si l'utilisateur est connecté
        $userId = session('user_id');
        $user = User::find($userId);
        
        if (!$user) {
            return redirect()->route('resources.index')->with('error', 'Vous devez être connecté pour ajouter des ressources');
        }
        
        $request->validate([
            'titre' => 'required|max:50',
            'description' => 'required',
            'contenu' => 'required',
            'type_ressource' => 'required|max:50',
            'lien' => 'required|max:100',
            'organisation_id' => 'required|exists:organisations,id',
        ]);
        
        $resource = new Resource();
        $resource->user_id = $userId;
        $resource->organisation_id = $request->organisation_id;
        $resource->titre = $request->titre;
        $resource->description = $request->description;
        $resource->contenu = $request->contenu;
        $resource->lien = $request->lien;
        $resource->type_ressource = $request->type_ressource;
        
        $resource->save();
        
        return redirect()->route('resources.show', $resource->id)->with('success', 'Ressource ajoutée avec succès');
    }
    
    /**
     * Voir une ressource externe
     */
    public function download($id)
    {
        $resource = Resource::findOrFail($id);
        
        if (!$resource->lien) {
            return back()->with('error', 'Cette ressource ne contient pas de lien');
        }
        
        return redirect()->away($resource->lien);
    }
    
    /**
     * Rechercher des ressources
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $resources = Resource::where(function($queryBuilder) use ($query) {
                               $queryBuilder->where('titre', 'LIKE', "%{$query}%")
                                          ->orWhere('description', 'LIKE', "%{$query}%");
                           })
                           ->paginate(12);
        
        $types = Resource::select('type_ressource')->distinct()->get();
        
        return view('resources.index', compact('resources', 'types', 'query'));
    }
}
