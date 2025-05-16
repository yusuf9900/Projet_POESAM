@extends('layouts.app')

@section('title', $post->titre)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('communaute.index') }}">Communauté</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('communaute.category', $post->categorie_id) }}">{{ $post->categorie->nom }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $post->titre }}</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
        <!-- Article principal -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-circle me-3">
                            <span class="initials">{{ substr($post->user->name ?? 'User', 0, 1) }}</span>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $post->user->name }}</h6>
                            <small class="text-muted">{{ $post->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        
                        @if($user_id && $user_id == $post->user_id)
                        <div class="ms-auto">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="postActions" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="postActions">
                                    <li><a class="dropdown-item" href="{{ route('communaute.edit', $post->id) }}"><i class="fas fa-edit me-2"></i> Modifier</a></li>
                                    <li>
                                        <form action="{{ route('communaute.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce post ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-trash me-2"></i> Supprimer
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <h1 class="card-title h3 mb-3">{{ $post->titre }}</h1>
                    
                    @if($post->image)
                    <div class="post-image mb-4">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->titre }}" class="img-fluid rounded">
                    </div>
                    @endif
                    
                    <div class="post-content mb-4">
                        {!! nl2br(e($post->contenu)) !!}
                    </div>
                    
                    <div class="post-actions d-flex align-items-center">
                        <button class="btn btn-sm {{ $isLiked ? 'btn-danger' : 'btn-outline-danger' }} me-2 like-button" data-post-id="{{ $post->id }}">
                            <i class="fas fa-heart me-1"></i> <span class="like-count">{{ $post->likes->count() }}</span> likes
                        </button>
                        
                        <span class="me-3">
                            <i class="fas fa-comment me-1"></i> {{ $post->commentaires->count() }} commentaires
                        </span>
                        
                        <span class="badge bg-primary">{{ $post->categorie->nom }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Section commentaires -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Commentaires ({{ $post->commentaires->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($user_id)
                    <form action="{{ route('communaute.comment.store', $post->id) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control" name="contenu" rows="3" placeholder="Ajouter un commentaire..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Publier</button>
                    </form>
                    @else
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i> Vous devez être <a href="{{ route('login') }}">connecté</a> pour ajouter un commentaire.
                    </div>
                    @endif
                    
                    <div class="comments-list">
                        @if(count($post->commentaires) > 0)
                            @foreach($post->commentaires as $commentaire)
                            <div class="comment mb-3 pb-3 border-bottom">
                                <div class="d-flex">
                                    <div class="avatar-circle-sm me-2">
                                        <span class="initials-sm">{{ substr($commentaire->user->name ?? 'U', 0, 1) }}</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h6 class="mb-0">{{ $commentaire->user->name }}</h6>
                                                <small class="text-muted">{{ $commentaire->created_at->format('d/m/Y H:i') }}</small>
                                            </div>
                                            
                                            @if($user_id && $user_id == $commentaire->user_id)
                                            <div>
                                                <form action="{{ route('communaute.comment.destroy', $commentaire->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="comment-content mt-2">
                                            {{ $commentaire->contenu }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted">Aucun commentaire pour le moment. Soyez le premier à commenter !</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Author info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">À propos de l'auteur</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-circle me-3">
                            <span class="initials">{{ substr($post->user->name ?? 'User', 0, 1) }}</span>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $post->user->name }}</h6>
                            <small class="text-muted">Membre depuis {{ $post->user->created_at->format('M Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related posts -->
            @if(count($similarPosts) > 0)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Discussions similaires</h5>
                </div>
                <div class="card-body">
                    <div class="similar-posts">
                        @foreach($similarPosts as $similar)
                        <div class="similar-post mb-3 pb-3 border-bottom">
                            <h6 class="mb-1">
                                <a href="{{ route('communaute.show', $similar->id) }}" class="text-decoration-none">
                                    {{ $similar->titre }}
                                </a>
                            </h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $similar->created_at->format('d/m/Y') }}</small>
                                <div>
                                    <span class="badge bg-secondary me-1">
                                        <i class="fas fa-comment me-1"></i> {{ $similar->commentaires->count() }}
                                    </span>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-heart me-1"></i> {{ $similar->likes->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Actions -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('communaute.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i> Retour aux discussions
                        </a>
                        @if($user_id)
                        <a href="{{ route('communaute.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Nouvelle discussion
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Variables de couleur */
    :root {
        --primary-color: #3E4095; /* Bleu professionnel */
        --primary-rgb: 62, 64, 149; /* Valeur RGB de la couleur primaire */
        --secondary-color: #788AA3; /* Bleu gris élégant */
        --accent-color: #FFA41B; /* Orange doux pour les accents */
        --text-color: #333333; /* Gris foncé - pour le texte principal */
        --light-text: #555555; /* Gris moyen - pour texte secondaire */
        --white: #ffffff;
        --light-bg: #F8F9FA; /* Fond très légèrement gris */
        --border-color: #E8E8E8; /* Gris très clair pour bordures */
        --gradient-start: #3E4095; /* Début du dégradé - bleu professionnel */
        --gradient-end: #5C5EBA; /* Fin du dégradé - bleu plus clair */
    }

    /* Styles généraux */
    .container {
        max-width: 1200px;
        padding: 0 20px;
    }

    /* Breadcrumb */
    .breadcrumb {
        background-color: transparent;
        padding: 0.75rem 0;
        margin-bottom: 1.5rem;
    }

    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .breadcrumb-item a:hover {
        color: var(--accent-color);
    }

    .breadcrumb-item.active {
        color: var(--light-text);
    }

    /* Carte principale du post */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .card-body {
        padding: 2rem;
    }

    /* Profil de l'auteur */
    .avatar-circle {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        text-align: center;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 10px rgba(var(--primary-rgb), 0.3);
    }
    
    .initials {
        font-size: 26px;
        color: white;
        font-weight: bold;
    }

    /* Post styling */
    .card-title {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 1.5rem;
        font-size: 2rem;
    }

    .post-content {
        font-size: 1.1rem;
        line-height: 1.7;
        color: var(--text-color);
        white-space: pre-line;
        padding: 1rem 0;
    }

    /* Post image */
    .post-image {
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .post-image img {
        width: 100%;
        height: auto;
    }

    /* Actions buttons */
    .post-actions {
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .like-button {
        border-radius: 50px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .like-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-danger {
        background-color: #ff6b6b;
        border-color: #ff6b6b;
    }

    .btn-outline-danger {
        color: #ff6b6b;
        border-color: #ff6b6b;
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.9rem;
    }

    /* Commentaires */
    .card-header {
        background-color: var(--light-bg);
        border-bottom: 1px solid var(--border-color);
        padding: 1.25rem 2rem;
    }

    .card-header h5 {
        margin: 0;
        color: var(--primary-color);
        font-weight: 600;
    }

    .comment {
        position: relative;
        padding: 1rem 0;
    }

    .avatar-circle-sm {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        text-align: center;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .initials-sm {
        font-size: 16px;
        color: white;
        font-weight: bold;
    }

    .comment h6 {
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 0.25rem;
    }

    .comment-content {
        color: var(--text-color);
        font-size: 1rem;
        line-height: 1.6;
    }

    /* Sidebar */
    .author-info-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        border: none;
    }

    .author-info-header {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        color: white;
        padding: 1.25rem;
        border: none;
    }

    .author-info-header h5 {
        margin: 0;
        font-weight: 600;
    }

    .author-info-body {
        padding: 1.5rem;
    }

    /* Similar Posts */
    .similar-post {
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }

    .similar-post:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .similar-post h6 {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .similar-post h6 a {
        color: var(--primary-color);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .similar-post h6 a:hover {
        color: var(--accent-color);
    }

    /* Actions card */
    .actions-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border: none;
    }

    .actions-body {
        padding: 1.5rem;
    }

    .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(var(--primary-rgb), 0.2);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        border: none;
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(var(--primary-rgb), 0.3);
    }

    /* Comment form */
    .form-control {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(var(--primary-rgb), 0.15);
    }

    /* Responsive adaptations */
    @media (max-width: 991.98px) {
        .card-body {
            padding: 1.5rem;
        }

        .author-info-card, .similar-posts-card, .actions-card {
            margin-top: 1rem;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Like functionality
        const likeButtons = document.querySelectorAll('.like-button');
        
        likeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const postId = this.getAttribute('data-post-id');
                
                fetch(`/communaute/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const likeCount = this.querySelector('.like-count');
                        likeCount.textContent = data.likesCount;
                        
                        if (data.action === 'liked') {
                            this.classList.remove('btn-outline-danger');
                            this.classList.add('btn-danger');
                        } else {
                            this.classList.remove('btn-danger');
                            this.classList.add('btn-outline-danger');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
@endsection
