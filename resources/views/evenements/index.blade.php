@extends('layouts.app')

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

    /* Header de la page */
    .events-header {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        padding: 3rem 0;
        margin-bottom: 3rem;
        border-radius: 0 0 50px 50px;
        box-shadow: 0 5px 15px rgba(var(--primary-rgb), 0.1);
    }

    .events-header h1 {
        color: white;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .events-header p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        max-width: 700px;
        margin: 0 auto 1.5rem;
    }

    .search-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .search-form {
        position: relative;
    }

    .search-input {
        border-radius: 50px;
        padding: 1rem 1.5rem;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        font-size: 1rem;
        width: 100%;
    }

    .search-button {
        position: absolute;
        right: 5px;
        top: 5px;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        border: none;
        border-radius: 50px;
        color: white;
        padding: 0.6rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .search-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(var(--primary-rgb), 0.2);
    }

    /* Navigation onglets */
    .nav-tabs {
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 2rem;
        display: flex;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .nav-tabs .nav-item {
        margin-bottom: -1px;
    }

    .nav-tabs .nav-link {
        color: var(--secondary-color);
        border: none;
        border-bottom: 2px solid transparent;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .nav-tabs .nav-link:hover {
        color: var(--primary-color);
    }

    .nav-tabs .nav-link.active {
        color: var(--primary-color);
        border-bottom: 2px solid var(--primary-color);
        background-color: transparent;
    }

    /* Carte d'événement */
    .event-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .event-img {
        height: 200px;
        object-fit: cover;
    }

    .event-date-tag {
        position: absolute;
        top: 15px;
        left: 15px;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        box-shadow: 0 3px 10px rgba(var(--primary-rgb), 0.3);
    }

    .event-capacity-tag {
        position: absolute;
        top: 15px;
        right: 15px;
        background: var(--accent-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        box-shadow: 0 3px 10px rgba(255, 164, 27, 0.3);
    }

    .event-card-body {
        padding: 1.5rem;
    }

    .event-title {
        font-weight: 700;
        margin-bottom: 0.75rem;
        color: var(--text-color);
        font-size: 1.25rem;
    }

    .event-title a {
        color: var(--text-color);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .event-title a:hover {
        color: var(--primary-color);
    }

    .event-address {
        color: var(--light-text);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        font-size: 0.9rem;
    }

    .event-address i {
        margin-right: 0.5rem;
        color: var(--primary-color);
    }

    .event-action {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }

    .btn-event {
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-event:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        border: none;
    }

    .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        color: white;
    }

    /* Cartes d'événements passés */
    .past-events {
        padding: 2rem 0;
        background-color: var(--light-bg);
        border-radius: 12px;
        margin-top: 3rem;
        margin-bottom: 3rem;
    }

    .past-events h3 {
        color: var(--text-color);
        margin-bottom: 1.5rem;
        font-weight: 700;
    }

    .past-event-card {
        background-color: white;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .past-event-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .past-event-card .event-title {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .past-event-date {
        color: var(--light-text);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    /* Call to action */
    .cta-section {
        background: linear-gradient(135deg, var(--primary-color), #7C7DDF);
        padding: 3rem 0;
        border-radius: 12px;
        margin-bottom: 3rem;
        box-shadow: 0 10px 30px rgba(var(--primary-rgb), 0.2);
    }

    .cta-section h2 {
        color: white;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .cta-section p {
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 1.5rem;
        font-size: 1.1rem;
    }

    .btn-cta {
        background-color: white;
        color: var(--primary-color);
        border-radius: 50px;
        padding: 0.75rem 2rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    /* Pagination */
    .pagination {
        margin-top: 2rem;
        margin-bottom: 3rem;
        justify-content: center;
    }

    .page-item .page-link {
        color: var(--primary-color);
        border: none;
        padding: 0.5rem 1rem;
        font-weight: 500;
        margin: 0 0.25rem;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .page-item .page-link:hover {
        background-color: var(--light-bg);
    }

    .page-item.active .page-link {
        background-color: var(--primary-color);
        color: white;
        box-shadow: 0 5px 10px rgba(var(--primary-rgb), 0.2);
    }

    .page-item.disabled .page-link {
        color: var(--light-text);
        opacity: 0.5;
    }

    /* Responsive */
    @media (max-width: 991.98px) {
        .events-header {
            padding: 2rem 0;
            border-radius: 0 0 30px 30px;
        }

        .events-header h1 {
            font-size: 1.75rem;
        }

        .nav-tabs {
            flex-wrap: nowrap;
        }

        .nav-tabs .nav-link {
            padding: 0.75rem 1rem;
            white-space: nowrap;
        }
    }

    @media (max-width: 767.98px) {
        .cta-section {
            padding: 2rem 0;
        }

        .search-input {
            padding: 0.75rem 1.25rem;
        }

        .search-button {
            padding: 0.5rem 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="events-header text-center">
    <div class="container">
        <h1>Événements et Activités</h1>
        <p>Découvrez tous les événements organisés par notre communauté. Participez, échangez et faites avancer la cause ensemble.</p>
        
        <div class="search-container">
            <form action="{{ route('evenements.recherche') }}" method="GET" class="search-form">
                <input type="text" name="q" class="form-control search-input" placeholder="Rechercher un événement...">
                <button type="submit" class="search-button">Rechercher</button>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <ul class="nav nav-tabs" id="eventsTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="upcoming-tab" data-toggle="tab" href="#upcoming" role="tab" aria-controls="upcoming" aria-selected="true">
                À venir
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="past-tab" data-toggle="tab" href="#past" role="tab" aria-controls="past" aria-selected="false">
                Passés
            </a>
        </li>
        @if(session('user_id'))
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="my-events-tab" data-toggle="tab" href="#my-events" role="tab" aria-controls="my-events" aria-selected="false">
                Mes événements
            </a>
        </li>
        @endif
    </ul>
    
    <div class="tab-content" id="eventsTabContent">
        <!-- Onglet événements à venir -->
        <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
            @if($evenements->count() > 0)
                <div class="row">
                    @foreach($evenements as $evenement)
                    <div class="col-md-6 col-lg-4">
                        <div class="card event-card">
                            @if($evenement->image)
                                <img src="{{ asset('storage/'.$evenement->image) }}" class="card-img-top event-img" alt="{{ $evenement->nom }}">
                            @else
                                <img src="{{ asset('img/event-placeholder.jpg') }}" class="card-img-top event-img" alt="{{ $evenement->nom }}">
                            @endif
                            
                            <div class="event-date-tag">
                                <i class="far fa-calendar-alt mr-1"></i> 
                                {{ date('d M', strtotime($evenement->date_evenement)) }}
                            </div>
                            
                            <div class="event-capacity-tag">
                                <i class="fas fa-users mr-1"></i>
                                {{ $evenement->places_reservees }}/{{ $evenement->places_disponibles }}
                            </div>
                            
                            <div class="event-card-body">
                                <h5 class="event-title">
                                    <a href="{{ route('evenements.show', $evenement->id) }}">{{ $evenement->nom }}</a>
                                </h5>
                                
                                <div class="event-address">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $evenement->adresse }}
                                </div>
                                
                                <p class="event-date">
                                    <i class="far fa-clock text-primary mr-1"></i>
                                    {{ date('d M Y à H:i', strtotime($evenement->date_evenement)) }}
                                </p>
                                
                                <div class="event-action">
                                    <a href="{{ route('evenements.show', $evenement->id) }}" class="btn btn-outline-primary btn-event">
                                        Détails
                                    </a>
                                    
                                    @if(session('user_id'))
                                        <a href="{{ route('evenements.participer', $evenement->id) }}" class="btn btn-primary btn-event">
                                            Participer
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-primary btn-event">
                                            Connectez-vous
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="pagination-container">
                    {{ $evenements->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <p class="mb-0">Aucun événement à venir pour le moment.</p>
                </div>
            @endif
            
            @if(session('user_id'))
                <div class="text-center mb-5">
                    <a href="{{ route('evenements.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus-circle mr-2"></i>Organiser un événement
                    </a>
                </div>
            @endif
        </div>
        
        <!-- Onglet événements passés -->
        <div class="tab-pane fade" id="past" role="tabpanel" aria-labelledby="past-tab">
            @if($evenementsPasses->count() > 0)
                <div class="row">
                    @foreach($evenementsPasses as $evenement)
                    <div class="col-md-6">
                        <div class="past-event-card">
                            <div class="row">
                                <div class="col-4">
                                    @if($evenement->image)
                                        <img src="{{ asset('storage/'.$evenement->image) }}" class="img-fluid rounded" alt="{{ $evenement->nom }}">
                                    @else
                                        <img src="{{ asset('img/event-placeholder.jpg') }}" class="img-fluid rounded" alt="{{ $evenement->nom }}">
                                    @endif
                                </div>
                                <div class="col-8">
                                    <h5 class="event-title">
                                        <a href="{{ route('evenements.show', $evenement->id) }}">{{ $evenement->nom }}</a>
                                    </h5>
                                    <div class="past-event-date">
                                        <i class="far fa-calendar-alt text-secondary mr-1"></i>
                                        {{ date('d M Y', strtotime($evenement->date_evenement)) }}
                                    </div>
                                    <a href="{{ route('evenements.show', $evenement->id) }}" class="btn btn-sm btn-outline-primary mt-2">
                                        Voir le compte-rendu
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('evenements.passes') }}" class="btn btn-outline-secondary">
                        Voir tous les événements passés
                    </a>
                </div>
            @else
                <div class="alert alert-info">
                    <p class="mb-0">Aucun événement passé dans notre historique.</p>
                </div>
            @endif
        </div>
        
        <!-- Onglet mes événements (visible uniquement si connecté) -->
        @if(session('user_id'))
        <div class="tab-pane fade" id="my-events" role="tabpanel" aria-labelledby="my-events-tab">
            <a href="{{ route('evenements.mes-evenements') }}" class="btn btn-primary mb-4">
                <i class="fas fa-list mr-2"></i>Voir tous mes événements
            </a>
        </div>
        @endif
    </div>
    
    <!-- Section CTA -->
    <div class="cta-section text-center">
        <div class="container">
            <h2>Vous avez un événement à partager ?</h2>
            <p>Organisez votre propre événement et partagez-le avec notre communauté engagée.</p>
            @if(session('user_id'))
                <a href="{{ route('evenements.create') }}" class="btn btn-cta">Créer un événement</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-cta">Connectez-vous pour créer un événement</a>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Activation des onglets Bootstrap
        $('#eventsTab a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
        
        // Gestion du hash dans l'URL pour activer les onglets
        var hash = window.location.hash;
        if (hash) {
            $('#eventsTab a[href="' + hash + '"]').tab('show');
        }
        
        // Mise à jour de l'URL lors du changement d'onglet
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            window.location.hash = e.target.hash;
        });
    });
</script>
@endsection
