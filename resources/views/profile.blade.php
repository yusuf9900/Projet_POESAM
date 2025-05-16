@php
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Str;
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur - Jigeen</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Variables de thème adaptatives */
        :root[data-theme="light"] {
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
            --gradient-end: #5D5DA8; /* Fin du dégradé - bleu-violet */
            --card-bg: #ffffff;
            --sidebar-bg: #ffffff;
            --sidebar-text: #333333;
            --sidebar-hover: #F5F5F5; /* Gris très pâle pour hover */
            --navbar-bg: #ffffff;
            --success-color: #28a745; /* Vert pour succès */
            --warning-color: #ffc107; /* Jaune pour avertissements */
            --info-color: #17a2b8; /* Bleu clair pour info */
            --danger-color: #dc3545; /* Rouge pour danger */
        }
        
        :root[data-theme="dark"] {
            --primary-color: #3E4095; /* Gardons la même couleur primaire pour cohérence */
            --primary-rgb: 62, 64, 149; /* Valeur RGB de la couleur primaire */
            --secondary-color: #788AA3; /* Bleu gris élégant */
            --accent-color: #FFA41B; /* Orange doux */
            --text-color: #F8F9FA; /* Blanc cassé pour le texte */
            --light-text: #E2E8F0; /* Gris très clair pour texte secondaire */
            --white: #1E1E1E; /* Fond presque noir */
            --light-bg: #121212; /* Fond foncé */
            --border-color: #2C2C2C; /* Gris foncé pour bordures */
            --gradient-start: #3E4095; /* Début du dégradé */
            --gradient-end: #5D5DA8; /* Fin du dégradé */
            --card-bg: #252525; /* Gris foncé pour les cartes */
            --sidebar-bg: #1E1E1E; /* Fond presque noir pour sidebar */
            --sidebar-text: #E2E8F0; /* Gris très clair pour texte sidebar */
            --sidebar-hover: #383838; /* Gris moyen pour hover */
            --navbar-bg: #1E1E1E; /* Fond presque noir pour navbar */
            --success-color: #28a745; /* Vert pour succès */
            --warning-color: #ffc107; /* Jaune pour avertissements */
            --info-color: #17a2b8; /* Bleu clair pour info */
            --danger-color: #dc3545; /* Rouge pour danger */
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            background-color: var(--light-bg);
        }
        
        .dashboard-container {
            padding: 30px 0;
        }
        
        .navbar {
            background-color: var(--navbar-bg);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            padding: 15px 0;
            border-bottom: 1px solid rgba(var(--primary-rgb), 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }
        
        .sidebar {
            background-color: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            padding: 30px;
            height: calc(100vh - 100px);
            position: sticky;
            top: 30px;
        }
        
        .sidebar-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .sidebar-header h3 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 0;
        }
        
        .sidebar-menu {
            list-style: none;
            padding-left: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 15px;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 12px 15px;
            color: var(--sidebar-text);
            border-radius: 10px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            font-weight: 500;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background-color: var(--sidebar-hover);
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .sidebar-menu a i {
            margin-right: 10px;
            font-size: 1.2rem;
            color: var(--primary-color);
        }
        
        .main-content {
            padding: 0 20px;
        }
        
        .welcome-banner {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            color: #FFFFFF;
            border-radius: 15px;
            padding: 35px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(var(--primary-rgb), 0.15);
        }
        
        .welcome-banner h2 {
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .welcome-banner p {
            opacity: 0.9;
            max-width: 600px;
            line-height: 1.6;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            background-color: var(--card-bg);
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }
        
        .card-header {
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .user-avatar-container {
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
            position: relative;
        }
        
        .user-avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            overflow: hidden;
            border: 4px solid var(--white);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .avatar-edit {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background-color: var(--accent-color);
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }
        
        .avatar-edit:hover {
            background-color: var(--primary-color);
            transform: scale(1.1);
        }
        
        .profile-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .stat-item {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            flex: 1;
            margin: 0 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: var(--light-text);
            font-size: 0.9rem;
        }
        
        .profile-form .form-label {
            font-weight: 500;
            color: var(--text-color);
        }
        
        .profile-form .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            background-color: var(--white);
            color: var(--text-color);
            transition: all 0.3s ease;
        }
        
        .profile-form .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 8px;
            font-weight: 500;
            padding: 10px 25px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            background-color: var(--gradient-end);
            border-color: var(--gradient-end);
        }
        
        .publication-list, .comment-list {
            margin-top: 20px;
        }
        
        .publication-item, .comment-item {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 3px solid var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .publication-item:hover, .comment-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        .publication-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--primary-color);
        }
        
        .publication-date, .comment-date {
            font-size: 0.8rem;
            color: var(--light-text);
        }
        
        .tab-content {
            padding: 20px 0;
        }
        
        .nav-tabs {
            border-bottom: 1px solid var(--border-color);
        }
        
        .nav-tabs .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            color: var(--light-text);
            font-weight: 500;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
            background-color: transparent;
        }
        
        .nav-tabs .nav-link:hover {
            border-color: transparent;
            color: var(--primary-color);
        }
        
        #avatar-upload {
            display: none;
        }
        
        @media (max-width: 768px) {
            .profile-stats {
                flex-direction: column;
            }
            
            .stat-item {
                margin: 10px 0;
            }
            
            .user-avatar-container {
                width: 120px;
                height: 120px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <span style="color: var(--primary-color); font-weight: 700;">Jigeen</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars" style="color: var(--text-color);"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('profile') }}">
                            <i class="fas fa-user me-1"></i> Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">
                            <i class="fas fa-sign-out-alt me-1"></i> Déconnexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-sm ms-2 theme-toggle">
                            <i class="fas fa-moon"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container dashboard-container">
        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <h2>Votre Profil</h2>
            <p>Gérez vos informations personnelles, consultez vos publications et commentaires, et personnalisez votre expérience.</p>
        </div>
        
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-12">
                <!-- Profile Overview -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="user-avatar-container">
                                    <div class="user-avatar">
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}">
                                        @else
                                            {{ substr($user->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <label for="avatar-upload" class="avatar-edit">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                </div>
                                <h4 class="mt-3">{{ $user->name }}</h4>
                                <p class="text-muted">{{ $user->email }}</p>
                                
                                @if($user->telephone)
                                    <p><i class="fas fa-phone me-2"></i> {{ $user->telephone }}</p>
                                @endif
                                
                                @if($user->localisation)
                                    <p><i class="fas fa-map-marker-alt me-2"></i> {{ $user->localisation }}</p>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="profile-stats mb-4">
                                    <div class="stat-item">
                                        <div class="stat-number">{{ $stats['total_publications'] }}</div>
                                        <div class="stat-label">Publications</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-number">{{ $stats['total_commentaires'] }}</div>
                                        <div class="stat-label">Commentaires</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-number">{{ $stats['total_reactions_reçues'] }}</div>
                                        <div class="stat-label">Réactions reçues</div>
                                    </div>
                                </div>
                                
                                @if($user->bio)
                                    <div class="mb-4">
                                        <h5>À propos de moi</h5>
                                        <p>{{ $user->bio }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tabs Section -->
                <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Modifier le Profil</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="publications-tab" data-bs-toggle="tab" data-bs-target="#publications" type="button" role="tab">Mes Publications</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments" type="button" role="tab">Mes Commentaires</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="profileTabsContent">
                    <!-- Edit Profile Tab -->
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Modifier vos informations</h5>
                            </div>
                            <div class="card-body">
                                <form class="profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" id="avatar-upload" name="avatar" accept="image/*">
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Nom complet</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Adresse e-mail</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="telephone" class="form-label">Téléphone</label>
                                            <input type="text" class="form-control" id="telephone" name="telephone" value="{{ $user->telephone }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="localisation" class="form-label">Localisation</label>
                                            <input type="text" class="form-control" id="localisation" name="localisation" value="{{ $user->localisation }}">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="bio" class="form-label">Biographie</label>
                                        <textarea class="form-control" id="bio" name="bio" rows="4">{{ $user->bio }}</textarea>
                                    </div>
                                    
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Publications Tab -->
                    <div class="tab-pane fade" id="publications" role="tabpanel" aria-labelledby="publications-tab">
                        <div class="publication-list">
                            @if($publications->count() > 0)
                                @foreach($publications as $publication)
                                    <div class="publication-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h5 class="publication-title">{{ $publication->titre }}</h5>
                                            <span class="publication-date">{{ $publication->date_publication->format('d/m/Y H:i') }}</span>
                                        </div>
                                        <p>{{ Str::limit($publication->contenu, 200) }}</p>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div>
                                                <span class="badge bg-primary me-2">{{ ucfirst($publication->categorie) }}</span>
                                                @if($publication->est_anonyme)
                                                    <span class="badge bg-secondary">Anonyme</span>
                                                @endif
                                            </div>
                                            <div>
                                                <i class="far fa-comment me-1"></i> {{ $publication->commentaires->count() }}
                                                <i class="far fa-heart ms-3 me-1"></i> {{ $publication->reactions->count() }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-info">
                                    Vous n'avez pas encore créé de publications.
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Comments Tab -->
                    <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                        <div class="comment-list">
                            @if($commentaires->count() > 0)
                                @foreach($commentaires as $commentaire)
                                    <div class="comment-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h6>
                                                Sur : 
                                                @if($commentaire->publication)
                                                    <span class="text-primary">{{ Str::limit($commentaire->publication->titre, 50) }}</span>
                                                @else
                                                    <span class="text-muted">Publication supprimée</span>
                                                @endif
                                            </h6>
                                            <span class="comment-date">{{ \Carbon\Carbon::parse($commentaire->date_commentaire)->format('d/m/Y H:i') }}</span>
                                        </div>
                                        <p class="mt-2">{{ $commentaire->contenu }}</p>
                                        <div class="d-flex justify-content-end align-items-center mt-2">
                                            <i class="far fa-heart me-1"></i> {{ $commentaire->reactions->count() }}
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-info">
                                    Vous n'avez pas encore laissé de commentaires.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script pour le changement de thème -->
    <script src="{{ asset('js/theme-switcher.js') }}"></script>
    
    <!-- Script pour le profil -->
    <script>
        $(document).ready(function() {
            // Gestion du changement d'avatar
            $('.avatar-edit').click(function() {
                $('#avatar-upload').click();
            });
            
            // Prévisualisation de l'avatar
            $('#avatar-upload').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('.user-avatar').html('<img src="' + e.target.result + '" alt="Avatar Preview">');
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</body>
</html>
