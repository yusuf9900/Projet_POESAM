<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\CategoriePost;
use App\Models\Commentaire;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CommunauteController extends Controller
{
    /**
     * Afficher la liste des posts
     */
    public function index(Request $request)
    {
        $categorie_id = $request->input('categorie');
        $user_id = session('user_id');
        
        $query = Post::with(['user', 'categorie', 'commentaires'])
                      ->where('statut', 'actif')
                      ->orderBy('created_at', 'desc');
                      
        if ($categorie_id) {
            $query->where('categorie_id', $categorie_id);
        }
        
        $posts = $query->paginate(10);
        $categories = CategoriePost::all();
        
        return view('communaute.index', compact('posts', 'categories', 'user_id', 'categorie_id'));
    }
    
    /**
     * Afficher le formulaire de création d'un post
     */
    public function create()
    {
        $user_id = session('user_id');
        
        if (!$user_id) {
            return redirect()->route('communaute.index')
                             ->with('error', 'Vous devez être connecté pour créer un post');
        }
        
        $categories = CategoriePost::all();
        return view('communaute.create', compact('categories'));
    }
    
    /**
     * Enregistrer un nouveau post
     */
    public function store(Request $request)
    {
        $user_id = session('user_id');
        
        if (!$user_id) {
            return redirect()->route('communaute.index')
                             ->with('error', 'Vous devez être connecté pour créer un post');
        }
        
        $request->validate([
            'titre' => 'required|string|max:100',
            'contenu' => 'required|string',
            'categorie_id' => 'required|exists:categories_posts,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $post = new Post();
        $post->titre = $request->titre;
        $post->contenu = $request->contenu;
        $post->categorie_id = $request->categorie_id;
        $post->user_id = $user_id;
        $post->statut = 'actif';
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . Str::slug($request->titre) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('posts', $fileName, 'public');
            $post->image = $path;
        }
        
        $post->save();
        
        return redirect()->route('communaute.show', $post->id)
                         ->with('success', 'Votre post a été publié avec succès');
    }
    
    /**
     * Afficher un post spécifique
     */
    public function show($id)
    {
        $post = Post::with(['user', 'categorie', 'commentaires.user'])
                    ->findOrFail($id);
        
        $user_id = session('user_id');
        $isLiked = false;
        
        if ($user_id) {
            $isLiked = $post->isLikedByUser($user_id);
        }
        
        // Posts similaires
        $similarPosts = Post::where('id', '!=', $post->id)
                          ->where('categorie_id', $post->categorie_id)
                          ->where('statut', 'actif')
                          ->limit(3)
                          ->get();
        
        return view('communaute.show', compact('post', 'similarPosts', 'isLiked', 'user_id'));
    }
    
    /**
     * Afficher le formulaire de modification d'un post
     */
    public function edit($id)
    {
        $user_id = session('user_id');
        $post = Post::findOrFail($id);
        
        if (!$user_id) {
            return redirect()->route('communaute.index')
                             ->with('error', 'Vous devez être connecté pour modifier un post');
        }
        
        if ($post->user_id != $user_id) {
            return redirect()->route('communaute.index')
                             ->with('error', 'Vous ne pouvez pas modifier ce post');
        }
        
        $categories = CategoriePost::all();
        return view('communaute.edit', compact('post', 'categories'));
    }
    
    /**
     * Mettre à jour un post
     */
    public function update(Request $request, $id)
    {
        $user_id = session('user_id');
        $post = Post::findOrFail($id);
        
        if (!$user_id) {
            return redirect()->route('communaute.index')
                             ->with('error', 'Vous devez être connecté pour modifier un post');
        }
        
        if ($post->user_id != $user_id) {
            return redirect()->route('communaute.index')
                             ->with('error', 'Vous ne pouvez pas modifier ce post');
        }
        
        $request->validate([
            'titre' => 'required|string|max:100',
            'contenu' => 'required|string',
            'categorie_id' => 'required|exists:categories_posts,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $post->titre = $request->titre;
        $post->contenu = $request->contenu;
        $post->categorie_id = $request->categorie_id;
        
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            
            $image = $request->file('image');
            $fileName = time() . '_' . Str::slug($request->titre) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('posts', $fileName, 'public');
            $post->image = $path;
        }
        
        $post->save();
        
        return redirect()->route('communaute.show', $post->id)
                         ->with('success', 'Votre post a été mis à jour avec succès');
    }
    
    /**
     * Supprimer un post
     */
    public function destroy($id)
    {
        $user_id = session('user_id');
        $post = Post::findOrFail($id);
        
        if (!$user_id) {
            return redirect()->route('communaute.index')
                             ->with('error', 'Vous devez être connecté pour supprimer un post');
        }
        
        if ($post->user_id != $user_id) {
            return redirect()->route('communaute.index')
                             ->with('error', 'Vous ne pouvez pas supprimer ce post');
        }
        
        // Supprimer l'image si elle existe
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        
        $post->delete();
        
        return redirect()->route('communaute.index')
                         ->with('success', 'Votre post a été supprimé avec succès');
    }
    
    /**
     * Ajouter un commentaire à un post
     */
    public function storeComment(Request $request, $post_id)
    {
        $user_id = session('user_id');
        
        if (!$user_id) {
            return redirect()->route('communaute.show', $post_id)
                             ->with('error', 'Vous devez être connecté pour commenter');
        }
        
        $request->validate([
            'contenu' => 'required|string',
        ]);
        
        $commentaire = new Commentaire();
        $commentaire->contenu = $request->contenu;
        $commentaire->post_id = $post_id;
        $commentaire->user_id = $user_id;
        $commentaire->save();
        
        return redirect()->route('communaute.show', $post_id)
                         ->with('success', 'Votre commentaire a été ajouté');
    }
    
    /**
     * Supprimer un commentaire
     */
    public function destroyComment($id)
    {
        $user_id = session('user_id');
        $commentaire = Commentaire::findOrFail($id);
        $post_id = $commentaire->post_id;
        
        if (!$user_id) {
            return redirect()->route('communaute.show', $post_id)
                             ->with('error', 'Vous devez être connecté pour supprimer un commentaire');
        }
        
        if ($commentaire->user_id != $user_id) {
            return redirect()->route('communaute.show', $post_id)
                             ->with('error', 'Vous ne pouvez pas supprimer ce commentaire');
        }
        
        $commentaire->delete();
        
        return redirect()->route('communaute.show', $post_id)
                         ->with('success', 'Votre commentaire a été supprimé');
    }
    
    /**
     * Liker/Unliker un post
     */
    public function toggleLike($post_id)
    {
        $user_id = session('user_id');
        
        if (!$user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Vous devez être connecté pour liker un post'
            ]);
        }
        
        $post = Post::findOrFail($post_id);
        $like = Like::where('post_id', $post_id)
                    ->where('user_id', $user_id)
                    ->first();
        
        if ($like) {
            // Si déjà liké, supprimer le like
            $like->delete();
            $action = 'unliked';
        } else {
            // Sinon, ajouter un like
            $like = new Like();
            $like->post_id = $post_id;
            $like->user_id = $user_id;
            $like->save();
            $action = 'liked';
        }
        
        // Récupérer le nouveau nombre de likes
        $likesCount = $post->getLikesCountAttribute();
        
        return response()->json([
            'success' => true,
            'action' => $action,
            'likesCount' => $likesCount
        ]);
    }
    
    /**
     * Filtrer les posts par catégorie
     */
    public function filterByCategory($categorie_id)
    {
        $user_id = session('user_id');
        
        $posts = Post::with(['user', 'categorie', 'commentaires'])
                    ->where('statut', 'actif')
                    ->where('categorie_id', $categorie_id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        $categories = CategoriePost::all();
        $categorie = CategoriePost::findOrFail($categorie_id);
        
        return view('communaute.index', compact('posts', 'categories', 'user_id', 'categorie'));
    }
    
    /**
     * Rechercher des posts
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $user_id = session('user_id');
        
        $posts = Post::with(['user', 'categorie', 'commentaires'])
                    ->where('statut', 'actif')
                    ->where(function($queryBuilder) use ($query) {
                        $queryBuilder->where('titre', 'LIKE', "%{$query}%")
                                    ->orWhere('contenu', 'LIKE', "%{$query}%");
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        $categories = CategoriePost::all();
        
        return view('communaute.index', compact('posts', 'categories', 'user_id', 'query'));
    }
}
