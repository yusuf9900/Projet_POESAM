@extends('layouts.app')

@section('title', 'Paramètres')

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
        --danger-color: #dc3545; /* Rouge pour les alertes */
        --warning-color: #ffc107; /* Jaune pour les avertissements */
        --success-color: #28a745; /* Vert pour les succès */
    }

    /* Header de la page */
    .settings-header {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        padding: 2.5rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 40px 40px;
        box-shadow: 0 4px 15px rgba(var(--primary-rgb), 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .settings-header:before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 80%);
        transform-origin: center;
        animation: pulse 15s infinite linear;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(0.8) rotate(0deg);
            opacity: 0.5;
        }
        50% {
            transform: scale(1.2) rotate(180deg);
            opacity: 0.8;
        }
        100% {
            transform: scale(0.8) rotate(360deg);
            opacity: 0.5;
        }
    }

    .settings-header h1 {
        color: white;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .settings-header p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Navigation des onglets */
    .settings-tabs {
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 2rem;
        display: flex;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .settings-tabs .nav-item {
        margin-bottom: -1px;
    }

    .settings-tabs .nav-link {
        padding: 1.2rem 1.5rem;
        border: none;
        border-bottom: 3px solid transparent;
        font-weight: 500;
        color: var(--light-text);
        transition: all 0.3s ease;
        position: relative;
        width: 100%;
        border-radius: 10px 10px 0 0;
        margin-right: 5px;
    }

    .settings-tabs .nav-link.active {
        color: var(--primary-color);
        border-bottom-color: var(--primary-color);
        background-color: rgba(var(--primary-rgb), 0.05);
        box-shadow: 0 -3px 10px rgba(0, 0, 0, 0.05);
    }

    .settings-tabs .nav-link:hover {
        color: var(--primary-color);
        background-color: rgba(var(--primary-rgb), 0.02);
        transform: translateY(-3px);
    }

    .settings-tabs .nav-link .badge {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        border-radius: 50px;
        background-color: var(--accent-color);
    }
    
    .tab-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 4px 10px rgba(var(--primary-rgb), 0.2);
        transition: all 0.3s ease;
    }
    
    .nav-link:hover .tab-icon, .nav-link.active .tab-icon {
        transform: scale(1.1);
        box-shadow: 0 6px 15px rgba(var(--primary-rgb), 0.3);
    }

    /* Contenu des paramètres */
    .settings-content {
        padding: 2rem 0;
    }

    .settings-card {
        background-color: var(--white);
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        overflow: hidden;
        border: none;
        transition: all 0.5s ease;
        opacity: 0;
        transform: translateY(20px);
    }
    
    .animated-card.show {
        opacity: 1;
        transform: translateY(0);
    }
    
    .settings-card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .settings-card-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .settings-card-header h2 {
        margin: 0;
        color: var(--text-color);
        font-weight: 600;
        font-size: 1.5rem;
    }

    .settings-card-body {
        padding: 2rem;
    }

    /* Formulaires */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-color);
    }

    .form-control {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(var(--primary-rgb), 0.1);
    }

    .form-text {
        font-size: 0.85rem;
        color: var(--light-text);
        margin-top: 0.5rem;
    }

    /* Photo de profil améliorée */
    .profile-photo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        margin-bottom: 1.5rem;
        position: relative;
        box-shadow: 0 5px 15px rgba(var(--primary-rgb), 0.2);
        border: 5px solid white;
        transition: all 0.4s ease;
    }
    
    .profile-photo:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(var(--primary-rgb), 0.3);
    }

    .profile-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.5s ease;
    }

    .profile-photo-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .profile-photo:hover .profile-photo-overlay {
        opacity: 1;
    }

    .profile-photo-overlay i {
        color: white;
        font-size: 2rem;
        transform: scale(0.8);
        transition: all 0.3s ease;
    }
    
    .profile-photo:hover .profile-photo-overlay i {
        transform: scale(1);
    }
    
    .avatar-upload-info {
        transition: all 0.3s ease;
    }
    
    .avatar-badge {
        transform: translateY(-10px);
        opacity: 0;
        transition: all 0.4s ease;
    }
    
    .profile-photo:hover + .avatar-upload-info .avatar-badge {
        transform: translateY(0);
        opacity: 1;
    }

    /* Switches */
    .form-switch {
        padding-left: 2.5rem;
        margin-bottom: 1rem;
    }

    .form-switch .form-check-input {
        width: 2.5rem;
        height: 1.25rem;
        margin-left: -2.5rem;
        background-color: var(--border-color);
        border: none;
    }

    .form-switch .form-check-input:checked {
        background-color: var(--primary-color);
    }

    .form-switch .form-check-label {
        font-weight: 500;
        color: var(--text-color);
    }

    /* Boutons améliorés */
    .btn {
        border-radius: 50px; /* Plus arrondi pour un look moderne */
        padding: 0.85rem 1.75rem;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Animation plus dynamique */
        position: relative;
        overflow: hidden;
        z-index: 1;
        letter-spacing: 0.5px;
    }
    
    /* Effet d'ondulation (ripple) */
    .btn:after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%, -50%);
        transform-origin: 50% 50%;
        z-index: -1;
    }
    
    .btn:focus:not(:active)::after {
        animation: ripple 1s ease-out;
    }
    
    @keyframes ripple {
        0% {
            transform: scale(0, 0);
            opacity: 0.5;
        }
        20% {
            transform: scale(25, 25);
            opacity: 0.3;
        }
        100% {
            transform: scale(50, 50);
            opacity: 0;
        }
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        border: none;
        box-shadow: 0 4px 10px rgba(var(--primary-rgb), 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 7px 20px rgba(var(--primary-rgb), 0.4);
    }
    
    .btn-primary:focus {
        box-shadow: 0 0 0 0.25rem rgba(var(--primary-rgb), 0.25);
    }
    
    /* Effet de brillance */
    .btn-primary:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.7s ease;
    }
    
    .btn-primary:hover:before {
        left: 100%;
    }
    
    .btn-pressed {
        transform: scale(0.97) !important;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1) !important;
    }
    
    /* Bouton danger modifié */
    .btn-danger {
        background: linear-gradient(135deg, #ff5f6d, #ca2141);
        border: none;
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.2);
    }
    
    .btn-danger:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 7px 20px rgba(220, 53, 69, 0.4);
        background: linear-gradient(135deg, #ff5f6d, #ad182f);
    }
    
    /* Bouton outline */
    .btn-outline-primary {
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        background: transparent;
        transition: all 0.3s ease;
    }
    
    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 7px 20px rgba(var(--primary-rgb), 0.2);
    }
    
    /* Animation pour les switches */
    .form-switch {
        transition: all 0.3s ease;
    }
    
    .switch-hover {
        transform: translateX(5px);
    }
    
    /* Animation pour les champs de formulaire */
    .form-group {
        position: relative;
        transition: all 0.3s ease;
    }
    
    .form-group.focused label {
        color: var(--primary-color);
        transform: translateY(-5px);
        font-size: 0.9rem;
    }
    
    .form-label {
        transition: all 0.3s ease;
    }

    .btn-outline-secondary {
        border: 2px solid var(--light-text);
        color: var(--light-text);
        background: transparent;
    }

    .btn-outline-secondary:hover {
        background-color: var(--light-text);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 7px 20px rgba(0, 0, 0, 0.1);
    }
    
    /* Style flottant pour certains boutons */
    .btn-float {
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .btn-float:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0) 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .btn-float:hover:after {
        opacity: 1;
    }
    
    /* Effet de charge pour le bouton de soumission */
    .btn-save {
        position: relative;
        overflow: hidden;
    }
    
    .btn-save.loading:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 0%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.2);
        transition: width 1s linear;
    }
    
    .btn-save.loading:before {
        width: 100%;
    }
    
    /* Badge pour indiquer des modifications non sauvegardées */
    .unsaved-changes {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: var(--accent-color);
        animation: pulse-badge 1.5s infinite;
    }
    
    @keyframes pulse-badge {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.3);
            opacity: 0.7;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Séparateur */
    .divider {
        height: 1px;
        background-color: var(--border-color);
        margin: 2rem 0;
    }

    /* Zone de suppression de compte */
    .danger-zone {
        background-color: rgba(220, 53, 69, 0.05);
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .danger-zone h3 {
        color: var(--danger-color);
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }

    .danger-zone p {
        color: var(--text-color);
        margin-bottom: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 767.98px) {
        .settings-header {
            padding: 2rem 0;
            border-radius: 0 0 30px 30px;
        }

        .settings-tabs .nav-link {
            padding: 0.75rem 1rem;
        }

        .settings-card-body {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="settings-header text-center">
    <div class="container">
        <h1>Paramètres du compte</h1>
        <p>Gérez vos informations personnelles, la sécurité de votre compte et vos préférences</p>
    </div>
</div>

<div class="container">
    <!-- Messages de succès/erreur -->
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

    <!-- Navigation des onglets (améliorée) -->
    <ul class="nav nav-pills settings-tabs" id="settingsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">
                <div class="d-flex align-items-center">
                    <div class="tab-icon"><i class="fas fa-user"></i></div>
                    <div class="ms-2">
                        <span class="d-block">Profil</span>
                        <small class="text-muted">Informations personnelles</small>
                    </div>
                </div>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false">
                <div class="d-flex align-items-center">
                    <div class="tab-icon"><i class="fas fa-lock"></i></div>
                    <div class="ms-2">
                        <span class="d-block">Sécurité</span>
                        <small class="text-muted">Protection du compte</small>
                    </div>
                </div>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="notifications-tab" data-bs-toggle="tab" href="#notifications" role="tab" aria-controls="notifications" aria-selected="false">
                <div class="d-flex align-items-center">
                    <div class="tab-icon"><i class="fas fa-bell"></i></div>
                    <div class="ms-2">
                        <span class="d-block">Notifications</span>
                        <small class="text-muted">Préférences d'alertes</small>
                    </div>
                </div>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="privacy-tab" data-bs-toggle="tab" href="#privacy" role="tab" aria-controls="privacy" aria-selected="false">
                <div class="d-flex align-items-center">
                    <div class="tab-icon"><i class="fas fa-shield-alt"></i></div>
                    <div class="ms-2">
                        <span class="d-block">Confidentialité</span>
                        <small class="text-muted">Gestion de la vie privée</small>
                    </div>
                </div>
            </a>
        </li>
    </ul>

    <!-- Contenu des onglets -->
    <div class="tab-content settings-content" id="settingsTabsContent">
        <!-- Onglet Profil -->
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="card settings-card">
                <div class="settings-card-header">
                    <h2><i class="fas fa-user-circle me-2"></i> Informations personnelles</h2>
                </div>
                <div class="settings-card-body">
                    <form action="{{ route('parametres.updateProfile') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        @method('POST')
                        
                        <div class="text-center mb-4">
                            <div class="profile-photo mx-auto">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}" class="avatar-image">
                                @else
                                    <img src="{{ asset('img/default-avatar.png') }}" alt="{{ $user->name }}" class="avatar-image">
                                @endif
                                <label for="avatar" class="profile-photo-overlay">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" id="avatar" name="avatar" class="d-none">
                            </div>
                            <div class="avatar-upload-info">
                                <span class="badge bg-primary mb-2 avatar-badge">Photo de profil</span>
                                <small class="text-muted d-block">Cliquez sur l'image pour changer votre photo</small>
                                <small class="text-muted d-block">Formats acceptés: JPG, PNG (max 2MB)</small>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Nom complet</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">Adresse email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text">Cette adresse email sera utilisée pour les notifications et la connexion</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="form-label">Numéro de téléphone</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="bio" class="form-label">Courte biographie</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text">Partagez quelques informations sur vous (max 500 caractères)</small>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-save">
                                <i class="fas fa-save me-2"></i>Enregistrer les modifications
                                <span class="btn-hover-effect"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Onglet Sécurité -->
        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
            <div class="card settings-card">
                <div class="settings-card-header">
                    <h2><i class="fas fa-lock me-2"></i> Modification du mot de passe</h2>
                </div>
                <div class="settings-card-body">
                    <form action="{{ route('parametres.updatePassword') }}" method="POST" id="passwordForm" class="needs-validation" novalidate>
                        @csrf
                        @method('POST')
                        
                        <div class="form-group">
                            <label for="current_password" class="form-label">Mot de passe actuel</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text">Utilisez au moins 8 caractères avec des lettres, chiffres et symboles</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-key me-2"></i>Mettre à jour le mot de passe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="danger-zone">
                <h3><i class="fas fa-exclamation-triangle me-2"></i> Zone de danger</h3>
                <p>La suppression de votre compte est irréversible et entraînera la perte de toutes vos données et activités.</p>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    <i class="fas fa-trash-alt me-2"></i>Supprimer mon compte
                </button>
            </div>
        </div>
        
        <!-- Onglet Notifications -->
        <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
            <div class="card settings-card">
                <div class="settings-card-header">
                    <h2><i class="fas fa-bell me-2"></i> Préférences de notification</h2>
                </div>
                <div class="settings-card-body">
                    <form action="{{ route('parametres.updateNotifications') }}" method="POST" id="notificationsForm" class="needs-validation" novalidate>
                        @csrf
                        @method('POST')
                        
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="notification_email" name="notification_email" {{ $user->notification_email ? 'checked' : '' }}>
                            <label class="form-check-label" for="notification_email">
                                Recevoir des notifications par email
                            </label>
                            <small class="form-text d-block">Les emails concernant la sécurité de votre compte seront toujours envoyés</small>
                        </div>
                        
                        <div class="divider"></div>
                        
                        <h4 class="mb-3">Notifications spécifiques</h4>
                        
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="notification_evenements" name="notification_evenements" {{ $user->notification_evenements ? 'checked' : '' }}>
                            <label class="form-check-label" for="notification_evenements">
                                Événements à venir
                            </label>
                            <small class="form-text d-block">Recevoir des rappels pour les événements auxquels vous êtes inscrit</small>
                        </div>
                        
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="notification_messages" name="notification_messages" {{ $user->notification_messages ? 'checked' : '' }}>
                            <label class="form-check-label" for="notification_messages">
                                Nouveaux messages
                            </label>
                            <small class="form-text d-block">Être notifié lorsque vous recevez un nouveau message</small>
                        </div>
                        
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="notification_communaute" name="notification_communaute" {{ $user->notification_communaute ? 'checked' : '' }}>
                            <label class="form-check-label" for="notification_communaute">
                                Activité de la communauté
                            </label>
                            <small class="form-text d-block">Notifications sur les commentaires et réponses à vos publications</small>
                        </div>
                        
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer les préférences
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Onglet Confidentialité -->
        <div class="tab-pane fade" id="privacy" role="tabpanel" aria-labelledby="privacy-tab">
            <div class="card settings-card">
                <div class="settings-card-header">
                    <h2><i class="fas fa-shield-alt me-2"></i> Confidentialité</h2>
                </div>
                <div class="settings-card-body">
                    <form action="{{ route('parametres.updatePrivacy') }}" method="POST" id="privacyForm" class="needs-validation" novalidate>
                        @csrf
                        @method('POST')
                        
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="profil_public" name="profil_public" {{ $user->profil_public ? 'checked' : '' }}>
                            <label class="form-check-label" for="profil_public">
                                Profil public
                            </label>
                            <small class="form-text d-block">Autoriser les autres utilisateurs à voir votre profil</small>
                        </div>
                        
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="masquer_activite" name="masquer_activite" {{ $user->masquer_activite ? 'checked' : '' }}>
                            <label class="form-check-label" for="masquer_activite">
                                Masquer mon activité
                            </label>
                            <small class="form-text d-block">Masquer vos commentaires et publications dans les flux d'activité publics</small>
                        </div>
                        
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="masquer_participation" name="masquer_participation" {{ $user->masquer_participation ? 'checked' : '' }}>
                            <label class="form-check-label" for="masquer_participation">
                                Masquer ma participation aux événements
                            </label>
                            <small class="form-text d-block">Masquer votre participation dans les listes d'inscrits aux événements</small>
                        </div>
                        
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer les paramètres
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression de compte -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">Confirmation de suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('parametres.deleteAccount') }}" method="POST" id="deleteAccountForm">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Attention :</strong> Cette action est irréversible et entraînera la perte de toutes vos données.
                    </div>
                    <p>Pour confirmer la suppression de votre compte, veuillez saisir votre mot de passe ci-dessous :</p>
                    <div class="form-group">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="delete_password" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-2"></i>Supprimer définitivement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Animation de l'en-tête au chargement
        $('.settings-header').hide().fadeIn(800);
        
        // Initialisation avec des animations
        $('.settings-card').addClass('animated-card');
        setTimeout(function() {
            $('.settings-card').addClass('show');
        }, 300);
        
        // Activation des onglets Bootstrap 5
        var triggerTabList = [].slice.call(document.querySelectorAll('#settingsTabs a'));
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl);

            triggerEl.addEventListener('click', function (event) {
                event.preventDefault();
                tabTrigger.show();
                
                // Animation des cartes lors du changement d'onglet
                document.querySelectorAll('.settings-card').forEach(function(card) {
                    card.classList.remove('show');
                });
                
                setTimeout(function() {
                    document.querySelectorAll('.settings-card').forEach(function(card) {
                        card.classList.add('show');
                    });
                }, 150);
            });
        });
        
        // Gestion du hash dans l'URL
        let hash = window.location.hash;
        if (hash) {
            const triggerEl = document.querySelector('#settingsTabs a[href="' + hash + '"]');
            if (triggerEl) {
                const tabTrigger = new bootstrap.Tab(triggerEl);
                tabTrigger.show();
            }
        }
        
        // Activer le premier onglet par défaut si aucun hash
        if (!hash) {
            const firstTab = document.querySelector('#settingsTabs a:first-child');
            if (firstTab) {
                const tab = new bootstrap.Tab(firstTab);
                tab.show();
            }
        }
        
        // Mise à jour de l'URL lors du changement d'onglet
        document.querySelectorAll('#settingsTabs a').forEach(function(tabEl) {
            tabEl.addEventListener('shown.bs.tab', function (event) {
                window.location.hash = event.target.hash;
            });
        });
        
        // Animation des switches
        document.querySelectorAll('.form-switch').forEach(function(switchEl) {
            switchEl.addEventListener('mouseenter', function() {
                this.classList.add('switch-hover');
            });
            switchEl.addEventListener('mouseleave', function() {
                this.classList.remove('switch-hover');
            });
        });
        
        // Animation des champs de formulaire
        document.querySelectorAll('.form-control').forEach(function(input) {
            input.addEventListener('focus', function() {
                this.closest('.form-group')?.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (this.value === '') {
                    this.closest('.form-group')?.classList.remove('focused');
                }
            });
            
            // Vérification initiale des champs non vides
            if (input.value !== '') {
                input.closest('.form-group')?.classList.add('focused');
            }
        });
        
        // Prévisualisation de l'image de profil avec transition
        $('#avatar').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('.profile-photo img').fadeOut(300, function() {
                        $(this).attr('src', e.target.result).fadeIn(300);
                    });
                }
                reader.readAsDataURL(file);
            }
        });
        
        // Animation améliorée lors du clic sur les boutons
        $('.btn').on('mousedown', function() {
            $(this).addClass('btn-pressed');
        }).on('mouseup mouseleave', function() {
            $(this).removeClass('btn-pressed');
        });
        
        // Effet de chargement lors de la soumission des formulaires
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                
                // Ajouter une icône de chargement
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Traitement en cours...';
                
                // Rétablir le bouton après 5 secondes si le formulaire n'a pas été soumis
                setTimeout(function() {
                    if (submitBtn.classList.contains('loading')) {
                        submitBtn.classList.remove('loading');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                }, 5000);
                
                return true;
            });
        });
        
        // Détecter les modifications non sauvegardées dans les formulaires
        let formChanged = false;
        
        // Fonction pour gérer les changements de formulaire
        function handleFormChange(input) {
            formChanged = true;
            const form = input.closest('form');
            const submitBtn = form.querySelector('button[type="submit"]');
            
            if (submitBtn && !submitBtn.querySelector('.unsaved-changes')) {
                const changeIndicator = document.createElement('span');
                changeIndicator.className = 'unsaved-changes';
                submitBtn.appendChild(changeIndicator);
                
                // Animation subtile du bouton
                submitBtn.classList.add('pulse-animation');
            }
        }
        
        // Écouter les événements de changement
        document.querySelectorAll('form :input').forEach(function(input) {
            input.addEventListener('change', function() {
                handleFormChange(this);
            });
            
            input.addEventListener('input', function() {
                handleFormChange(this);
            });
        });
        
        // Écouter les cases à cocher spécifiquement pour les switches
        document.querySelectorAll('.form-check-input[type="checkbox"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                handleFormChange(this);
                
                // Soumettre automatiquement le formulaire de notifications et confidentialité
                if (this.closest('form').id === 'notificationsForm' || this.closest('form').id === 'privacyForm') {
                    // Soumission différée (pour montrer l'animation)
                    setTimeout(() => {
                        this.closest('form').submit();
                    }, 300);
                }
            });
        });
        
        // Réinitialiser l'indicateur après la soumission
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function() {
                formChanged = false;
                this.querySelectorAll('.unsaved-changes').forEach(function(indicator) {
                    indicator.remove();
                });
            });
        });
        
        // Avertir l'utilisateur s'il quitte la page avec des modifications non sauvegardées
        window.addEventListener('beforeunload', function(e) {
            if (formChanged) {
                // Message standard pour la confirmation de navigation
                e.preventDefault();
                e.returnValue = "";
                return "";
            }
        });
    });
</script>
@endsection
