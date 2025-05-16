@extends('layouts.app')

@section('title', 'Communauté')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="categories-sidebar">
                <div class="categories-header">
                    <h4><i class="fas fa-list-alt me-2"></i> Catégories</h4>
                </div>
                <ul class="categories-menu">
                    <li class="{{ !isset($categorie) ? 'active' : '' }}">
                        <a href="{{ route('communaute.index') }}">
                            <i class="fas fa-th-large me-2"></i> Toutes les discussions
                        </a>
                    </li>
                    @foreach($categories as $cat)
                    <li class="{{ isset($categorie) && $categorie->id == $cat->id ? 'active' : '' }}">
                        <a href="{{ route('communaute.category', $cat->id) }}">
                            <i class="{{ $cat->icone ?? 'fas fa-folder' }} me-2"></i> {{ $cat->nom }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            
            <!-- Recherche -->
            <div class="search-sidebar mt-4">
                <div class="search-header">
                    <h4><i class="fas fa-search me-2"></i> Rechercher</h4>
                </div>
                <div class="search-body">
                    <form action="{{ route('communaute.search') }}" method="GET">
                        <div class="search-input-wrapper">
                            <input type="text" name="q" class="search-input" placeholder="Rechercher une discussion..." value="{{ $query ?? '' }}">
                            <button type="submit" class="search-button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Événements -->
            <div class="events-sidebar mt-4">
                <div class="events-header">
                    <h4><i class="fas fa-calendar-alt me-2"></i> Événements</h4>
                </div>
                <div class="events-body">
                    <div class="events-info">
                        <p>Découvrez les prochains événements de notre communauté</p>
                        <a href="{{ route('evenements.index') }}" class="btn btn-event">
                            <i class="fas fa-calendar-alt me-2"></i> Voir les événements
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Content -->
        <div class="col-lg-9">
            <div class="community-header">
                <div class="community-title">
                    @if(isset($categorie))
                        <h2><i class="{{ $categorie->icone ?? 'fas fa-comments' }} me-2"></i>{{ $categorie->nom }}</h2>
                    @elseif(isset($query))
                        <h2><i class="fas fa-search me-2"></i>Résultats pour "{{ $query }}"</h2>
                    @else
                        <h2><i class="fas fa-comments me-2"></i>Discussions récentes</h2>
                    @endif
                </div>
                
                @if($user_id)
                <a href="{{ route('communaute.create') }}" class="new-discussion-btn">
                    <i class="fas fa-plus-circle me-2"></i> Nouvelle discussion
                </a>
                @endif
            </div>
            
            <!-- Posts -->
            @if(count($posts) > 0)
                <div class="discussion-list">
                    @foreach($posts as $post)
                    <div class="discussion-card">
                        <div class="discussion-content">
                            <div class="discussion-author">
                                <div class="author-avatar">
                                    <span>{{ substr($post->user->name ?? 'U', 0, 1) }}</span>
                                </div>
                                <div class="author-info">
                                    <span class="author-name">{{ $post->user->name ?? 'Anonyme' }}</span>
                                    <span class="post-date">{{ $post->created_at->format('d/m/Y à H:i') }}</span>
                                </div>
                                <div class="post-category">
                                    <i class="{{ $post->categorie->icone ?? 'fas fa-folder' }}"></i> {{ $post->categorie->nom ?? 'Non classé' }}
                                </div>
                            </div>
                            <div class="discussion-body">
                                <h3 class="discussion-title">
                                    <a href="{{ route('communaute.show', $post->id) }}">
                                        {{ $post->titre }}
                                    </a>
                                </h3>
                                <div class="discussion-excerpt">
                                    {{ Str::limit(strip_tags($post->contenu), 150) }}
                                </div>
                            </div>
                            <div class="discussion-footer">
                                <div class="discussion-stats">
                                    <span class="stat-item">
                                        <i class="fas fa-comment"></i> {{ $post->commentaires->count() }}
                                    </span>
                                    <span class="stat-item">
                                        <i class="fas fa-heart"></i> {{ $post->likes->count() }}
                                    </span>
                                </div>
                                <a href="{{ route('communaute.show', $post->id) }}" class="read-more-btn">
                                    Lire la suite <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> Aucune discussion trouvée.
                    @if($user_id)
                        <a href="{{ route('communaute.create') }}" class="alert-link">Créer une nouvelle discussion</a> pour démarrer la conversation.
                    @endif
                </div>
            @endif
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
    .container-fluid {
        padding: 0 30px;
    }

    /* Styles de la sidebar */
    .categories-sidebar, .search-sidebar {
        background-color: var(--white);
        border-radius: 10px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .categories-header, .search-header {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        color: var(--white);
        padding: 15px 20px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .categories-header h4, .search-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
    }

    .categories-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .categories-menu li {
        border-bottom: 1px solid var(--border-color);
    }

    .categories-menu li:last-child {
        border-bottom: none;
    }

    .categories-menu li a {
        display: block;
        padding: 15px 20px;
        color: var(--text-color);
        text-decoration: none;
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .categories-menu li a:hover {
        background-color: rgba(var(--primary-rgb), 0.05);
        color: var(--primary-color);
    }

    .categories-menu li.active a {
        background-color: rgba(var(--primary-rgb), 0.1);
        color: var(--primary-color);
        border-left: 4px solid var(--primary-color);
        font-weight: 600;
    }

    /* Styles de recherche */
    .search-body {
        padding: 20px;
    }

    .search-input-wrapper {
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 12px 50px 12px 15px;
        border: 1px solid var(--border-color);
        border-radius: 50px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.2);
    }

    .search-button {
        position: absolute;
        right: 5px;
        top: 5px;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        color: white;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .search-button:hover {
        transform: scale(1.05);
    }

    /* Styles de l'en-tête de communauté */
    .community-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border-color);
    }

    .community-title h2 {
        font-size: 24px;
        font-weight: 600;
        color: var(--primary-color);
        margin: 0;
    }

    .new-discussion-btn {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        color: white;
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 500;
        text-decoration: none;
        box-shadow: 0 4px 10px rgba(var(--primary-rgb), 0.3);
        transition: all 0.3s ease;
    }

    .new-discussion-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(var(--primary-rgb), 0.2);
    }

    /* Styles des cartes de discussion */
    .discussion-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .discussion-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        transition: all 0.3s ease;
        border-left: 4px solid var(--primary-color);
    }

    .discussion-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .discussion-content {
        padding: 20px;
    }

    .discussion-author {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .author-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 18px;
        margin-right: 12px;
    }

    .author-info {
        display: flex;
        flex-direction: column;
    }

    .author-name {
        font-weight: 600;
        color: var(--text-color);
        font-size: 15px;
    }

    .post-date {
        font-size: 13px;
        color: var(--light-text);
    }

    .post-category {
        margin-left: auto;
        background-color: rgba(var(--primary-rgb), 0.1);
        color: var(--primary-color);
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 500;
    }

    .discussion-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .discussion-title a {
        color: var(--primary-color);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .discussion-title a:hover {
        color: var(--accent-color);
    }

    .discussion-excerpt {
        color: var(--light-text);
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .discussion-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid var(--border-color);
    }

    .discussion-stats {
        display: flex;
        gap: 15px;
    }

    .stat-item {
        display: flex;
        align-items: center;
        color: var(--light-text);
        font-size: 14px;
    }

    .stat-item i {
        margin-right: 5px;
        color: var(--primary-color);
    }

    .read-more-btn {
        color: var(--primary-color);
        font-weight: 500;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .read-more-btn:hover {
        color: var(--accent-color);
    }

    /* Pagination */
    .pagination {
        margin-top: 30px;
    }

    .page-link {
        color: var(--primary-color);
        border-radius: 50%;
        margin: 0 5px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    /* Styles pour le bloc d'événements */
    .events-sidebar {
        background-color: var(--white);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .events-header {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        color: white;
        padding: 15px 20px;
    }
    
    .events-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 1.2rem;
    }
    
    .events-body {
        padding: 20px;
    }
    
    .events-info {
        text-align: center;
    }
    
    .events-info p {
        color: var(--text-color);
        margin-bottom: 15px;
    }
    
    .btn-event {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
    }
    
    .btn-event:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(var(--primary-rgb), 0.3);
        color: white;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .container-fluid {
            padding: 0 15px;
        }

        .discussion-author {
            flex-wrap: wrap;
        }

        .post-category {
            margin-left: 0;
            margin-top: 10px;
            width: fit-content;
        }
    }
</style>
@endsection
