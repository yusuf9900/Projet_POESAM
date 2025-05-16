@extends('layouts.app')

@section('styles')
<style>
    /* Variables de couleur */
    :root {
        --primary-color: #3E4095; /* Bleu professionnel */
        --primary-rgb: 62, 64, 149; /* Valeur RGB de la couleur primaire */
        --secondary-color: #788AA3; /* Bleu gris élégant */
        --accent-color: #FFA41B; /* Orange doux pour les accents */
        --success-color: #28a745; /* Vert pour les succès */
        --danger-color: #dc3545; /* Rouge pour les alertes */
        --text-color: #333333; /* Gris foncé - pour le texte principal */
        --light-text: #555555; /* Gris moyen - pour texte secondaire */
        --white: #ffffff;
        --light-bg: #F8F9FA; /* Fond très légèrement gris */
        --border-color: #E8E8E8; /* Gris très clair pour bordures */
        --gradient-start: #3E4095; /* Début du dégradé - bleu professionnel */
        --gradient-end: #5C5EBA; /* Fin du dégradé - bleu plus clair */
    }

    /* Style général */
    .container {
        max-width: 1200px;
        padding: 0 20px;
    }
    
    /* Fil d'ariane */
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
    
    /* Carte principale */
    .event-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .event-header {
        position: relative;
    }
    
    .event-image {
        width: 100%;
        height: 350px;
        object-fit: cover;
    }
    
    .event-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        padding: 2rem 1.5rem 1.5rem;
    }
    
    .event-overlay h1 {
        color: white;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 2.25rem;
    }
    
    .event-date-badge {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        display: inline-block;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        box-shadow: 0 5px 15px rgba(var(--primary-rgb), 0.3);
    }
    
    .event-action-buttons {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        display: flex;
        gap: 0.75rem;
    }
    
    .btn-action {
        background-color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        color: var(--text-color);
        transition: all 0.3s ease;
    }
    
    .btn-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    
    .btn-action-primary {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        color: white;
    }
    
    .btn-action-danger {
        background-color: var(--danger-color);
        color: white;
    }
    
    /* Contenu principal */
    .event-body {
        padding: 2rem;
    }
    
    .event-info {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }
    
    .event-info-item {
        display: flex;
        align-items: center;
    }
    
    .event-info-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end), 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }
    
    .event-info-icon i {
        color: var(--primary-color);
        font-size: 1.25rem;
    }
    
    .event-info-content h5 {
        font-size: 0.9rem;
        color: var(--light-text);
        margin-bottom: 0.25rem;
        font-weight: 500;
    }
    
    .event-info-content p {
        font-size: 1.1rem;
        color: var(--text-color);
        font-weight: 600;
        margin-bottom: 0;
    }
    
    .event-description {
        margin-bottom: 2rem;
    }
    
    .event-description h3 {
        color: var(--text-color);
        font-weight: 700;
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }
    
    .event-description p {
        color: var(--text-color);
        line-height: 1.7;
        font-size: 1.05rem;
        white-space: pre-line;
    }
    
    /* Carte latérale */
    .sidebar-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .sidebar-card-header {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        color: white;
        padding: 1.5rem;
        border-bottom: none;
    }
    
    .sidebar-card-header h5 {
        margin: 0;
        font-weight: 600;
    }
    
    .sidebar-card-body {
        padding: 1.5rem;
    }
    
    /* Actions */
    .participation-card {
        text-align: center;
    }
    
    .places-info {
        margin-bottom: 1.5rem;
    }
    
    .places-count {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        line-height: 1;
    }
    
    .places-label {
        color: var(--light-text);
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }
    
    .btn-participer {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        font-weight: 500;
        width: 100%;
        transition: all 0.3s ease;
    }
    
    .btn-participer:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(var(--primary-rgb), 0.25);
    }
    
    .btn-annuler {
        background-color: var(--danger-color);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        font-weight: 500;
        width: 100%;
        transition: all 0.3s ease;
    }
    
    .btn-annuler:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(220, 53, 69, 0.25);
    }
    
    .btn-complet {
        background-color: var(--light-text);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        font-weight: 500;
        width: 100%;
        cursor: not-allowed;
    }
    
    .event-confirmed {
        background-color: var(--success-color);
        color: white;
        text-align: center;
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1rem;
    }
    
    .event-confirmed i {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    
    /* Organisateur */
    .organizer-info {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .organizer-avatar {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
        font-weight: 600;
        font-size: 1.5rem;
    }
    
    .organizer-details h5 {
        margin: 0 0 0.25rem;
        font-weight: 600;
        color: var(--text-color);
    }
    
    .organizer-details p {
        margin: 0;
        color: var(--light-text);
        font-size: 0.9rem;
    }
    
    /* Événements similaires */
    .similar-event {
        display: flex;
        align-items: center;
        margin-bottom: 1.25rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--border-color);
    }
    
    .similar-event:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .similar-event-img {
        width: 70px;
        height: 70px;
        border-radius: 8px;
        object-fit: cover;
        margin-right: 1rem;
    }
    
    .similar-event-info h6 {
        margin: 0 0 0.25rem;
        font-weight: 600;
    }
    
    .similar-event-info h6 a {
        color: var(--text-color);
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .similar-event-info h6 a:hover {
        color: var(--primary-color);
    }
    
    .similar-event-date {
        font-size: 0.85rem;
        color: var(--light-text);
        display: flex;
        align-items: center;
    }
    
    .similar-event-date i {
        margin-right: 0.5rem;
        color: var(--primary-color);
    }
    
    /* Call to action */
    .cta-card {
        background: linear-gradient(135deg, var(--primary-color), #7C7DDF);
        border: none;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        color: white;
        box-shadow: 0 10px 30px rgba(var(--primary-rgb), 0.2);
    }
    
    .cta-card h5 {
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .cta-card p {
        margin-bottom: 1.5rem;
        opacity: 0.9;
    }
    
    .btn-cta {
        background-color: white;
        color: var(--primary-color);
        border: none;
        border-radius: 50px;
        padding: 0.6rem 1.75rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    /* Responsive */
    @media (max-width: 991.98px) {
        .event-image {
            height: 300px;
        }
        
        .event-overlay h1 {
            font-size: 1.75rem;
        }
        
        .sidebar-card {
            margin-top: 2rem;
        }
    }
    
    @media (max-width: 767.98px) {
        .event-image {
            height: 250px;
        }
        
        .event-overlay h1 {
            font-size: 1.5rem;
        }
        
        .event-date-badge {
            top: 1rem;
            left: 1rem;
            padding: 0.4rem 1rem;
            font-size: 0.9rem;
        }
        
        .event-action-buttons {
            top: 1rem;
            right: 1rem;
        }
        
        .btn-action {
            width: 35px;
            height: 35px;
        }
        
        .event-body {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Fil d'ariane -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('evenements.index') }}">Événements</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $evenement->nom }}</li>
        </ol>
    </nav>
    
    <!-- Affichage des messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    <div class="row">
        <!-- Colonne principale -->
        <div class="col-lg-8">
            <div class="card event-card">
                <div class="event-header">
                    @if($evenement->image)
                        <img src="{{ asset('storage/'.$evenement->image) }}" class="event-image" alt="{{ $evenement->nom }}">
                    @else
                        <img src="{{ asset('img/event-placeholder.jpg') }}" class="event-image" alt="{{ $evenement->nom }}">
                    @endif
                    
                    <div class="event-date-badge">
                        <i class="far fa-calendar-alt mr-2"></i>{{ date('d M Y', strtotime($evenement->date_evenement)) }}
                    </div>
                    
                    <div class="event-action-buttons">
                        <a href="#" class="btn-action" title="Partager" onclick="shareEvent()">
                            <i class="fas fa-share-alt"></i>
                        </a>
                        
                        @if(session('user_id') && ($evenement->user_id == session('user_id') || session('user_type') == 'admin'))
                            <a href="{{ route('evenements.edit', $evenement->id) }}" class="btn-action btn-action-primary" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <button type="button" class="btn-action btn-action-danger" title="Supprimer" data-toggle="modal" data-target="#deleteModal">
                                <i class="fas fa-trash"></i>
                            </button>
                        @endif
                    </div>
                    
                    <div class="event-overlay">
                        <h1>{{ $evenement->nom }}</h1>
                    </div>
                </div>
                
                <div class="event-body">
                    <div class="event-info">
                        <div class="event-info-item">
                            <div class="event-info-icon">
                                <i class="far fa-clock"></i>
                            </div>
                            <div class="event-info-content">
                                <h5>Date et heure</h5>
                                <p>{{ date('d M Y à H:i', strtotime($evenement->date_evenement)) }}</p>
                            </div>
                        </div>
                        
                        <div class="event-info-item">
                            <div class="event-info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="event-info-content">
                                <h5>Localisation</h5>
                                <p>{{ $evenement->adresse }}</p>
                            </div>
                        </div>
                        
                        <div class="event-info-item">
                            <div class="event-info-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="event-info-content">
                                <h5>Places</h5>
                                <p>{{ $evenement->places_reservees }} / {{ $evenement->places_disponibles }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="event-description">
                        <h3>À propos de l'événement</h3>
                        <p>{{ $evenement->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Colonne latérale -->
        <div class="col-lg-4">
            <!-- Carte d'inscription -->
            <div class="card sidebar-card participation-card">
                <div class="sidebar-card-header">
                    <h5>Participer à cet événement</h5>
                </div>
                <div class="sidebar-card-body">
                    <div class="places-info">
                        <div class="places-count">
                            {{ $evenement->places_disponibles - $evenement->places_reservees }}
                        </div>
                        <div class="places-label">
                            Places disponibles sur {{ $evenement->places_disponibles }}
                        </div>
                    </div>
                    
                    @if(!session('user_id'))
                        <a href="{{ route('login') }}" class="btn btn-participer">
                            <i class="fas fa-sign-in-alt mr-2"></i>Se connecter pour participer
                        </a>
                    @elseif($estInscrit)
                        <div class="event-confirmed mb-3">
                            <i class="fas fa-check-circle d-block"></i>
                            Vous êtes inscrit à cet événement
                        </div>
                        <a href="{{ route('evenements.annuler', $evenement->id) }}" class="btn btn-annuler" onclick="return confirm('Êtes-vous sûr de vouloir annuler votre participation ?')">
                            <i class="fas fa-times mr-2"></i>Annuler ma participation
                        </a>
                    @elseif($evenement->places_reservees >= $evenement->places_disponibles)
                        <button class="btn btn-complet" disabled>
                            <i class="fas fa-ban mr-2"></i>Événement complet
                        </button>
                    @elseif(strtotime($evenement->date_evenement) < time())
                        <button class="btn btn-complet" disabled>
                            <i class="fas fa-history mr-2"></i>Événement terminé
                        </button>
                    @else
                        <a href="{{ route('evenements.participer', $evenement->id) }}" class="btn btn-participer">
                            <i class="fas fa-check-circle mr-2"></i>Je participe
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Carte de l'organisateur -->
            <div class="card sidebar-card">
                <div class="sidebar-card-header">
                    <h5>Organisateur</h5>
                </div>
                <div class="sidebar-card-body">
                    <div class="organizer-info">
                        <div class="organizer-avatar">
                            {{ substr($evenement->user->name ?? 'Anon', 0, 1) }}
                        </div>
                        <div class="organizer-details">
                            <h5>{{ $evenement->user->name ?? 'Anonyme' }}</h5>
                            <p>{{ $evenement->user->user_type ?? 'Utilisateur' }}</p>
                        </div>
                    </div>
                    <p class="mb-0">Organisateur expérimenté avec plusieurs événements à son actif.</p>
                </div>
            </div>
            
            <!-- Événements similaires -->
            @if($evenementsSimilaires->count() > 0)
            <div class="card sidebar-card">
                <div class="sidebar-card-header">
                    <h5>Événements similaires</h5>
                </div>
                <div class="sidebar-card-body">
                    @foreach($evenementsSimilaires as $similaire)
                    <div class="similar-event">
                        @if($similaire->image)
                            <img src="{{ asset('storage/'.$similaire->image) }}" class="similar-event-img" alt="{{ $similaire->nom }}">
                        @else
                            <img src="{{ asset('img/event-placeholder.jpg') }}" class="similar-event-img" alt="{{ $similaire->nom }}">
                        @endif
                        
                        <div class="similar-event-info">
                            <h6><a href="{{ route('evenements.show', $similaire->id) }}">{{ $similaire->nom }}</a></h6>
                            <div class="similar-event-date">
                                <i class="far fa-calendar-alt"></i>
                                {{ date('d M Y', strtotime($similaire->date_evenement)) }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- CTA pour créer un événement -->
            <div class="cta-card">
                <h5>Vous avez une idée d'événement ?</h5>
                <p>Partagez-la avec notre communauté et créez votre propre événement.</p>
                <a href="{{ route('evenements.create') }}" class="btn btn-cta">Créer un événement</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
@if(session('user_id') && ($evenement->user_id == session('user_id') || session('user_type') == 'admin'))
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cet événement ? Cette action est irréversible.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <form action="{{ route('evenements.destroy', $evenement->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    function shareEvent() {
        if (navigator.share) {
            navigator.share({
                title: "{{ $evenement->nom }}",
                text: "Rejoins-moi à cet événement : {{ $evenement->nom }}",
                url: window.location.href
            }).then(() => {
                console.log('Partage réussi');
            }).catch((error) => {
                console.log('Erreur de partage', error);
            });
        } else {
            // Fallback pour les navigateurs qui ne supportent pas l'API de partage
            alert("Copiez ce lien pour partager : " + window.location.href);
        }
    }
</script>
@endsection
