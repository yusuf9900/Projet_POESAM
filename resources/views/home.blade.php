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
    <title>Tableau de bord - Jigeen</title>
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
<<<<<<< HEAD

=======
        
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
        
>>>>>>> 0dc3f44163489ed095f93683950b12f073bda4bb
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
            position: relative;
            overflow: hidden;
        }
<<<<<<< HEAD

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 100%;
            background-color: var(--secondary-color);
            clip-path: polygon(100% 0, 0 0, 100% 100%);
        }

=======
        
>>>>>>> 0dc3f44163489ed095f93683950b12f073bda4bb
        .welcome-banner h2 {
            color: white;
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 2.2rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .welcome-banner p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 20px;
            max-width: 80%;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        .publication-card {
            margin-bottom: 30px;
            border-radius: 12px;
            overflow: hidden;
            background-color: var(--card-bg);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
            border-left: 3px solid var(--primary-color);
        }
        
        .publication-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .stat-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            border: none;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            padding: 25px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            color: var(--text-color);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .stat-card .icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            transform: rotate(-10deg);
            transition: transform 0.3s ease;
        }

        .stat-card .icon i {
            font-size: 1.8rem;
            color: white;
            transform: rotate(10deg);
        }

        .stat-card h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .stat-card p {
            color: var(--light-text);
            margin-bottom: 0;
        }

        .activity-card {
            background-color: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 30px;
            color: var(--text-color);
        }

        .activity-card h4 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .activity-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .activity-icon {
            width: 45px;
            height: 45px;
            border-radius: 15px;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            transform: rotate(-10deg);
        }

        .activity-icon i {
            font-size: 1.2rem;
            color: white;
            transform: rotate(10deg);
        }

        .activity-content h5 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .activity-content p {
            color: var(--light-text);
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        .activity-content .time {
            color: var(--light-text);
            font-size: 0.8rem;
        }

        .resource-card {
            background-color: var(--white);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .resource-card:hover {
            transform: translateY(-5px);
        }

        .resource-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background-color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .resource-card .icon i {
            font-size: 1.2rem;
            color: var(--primary-color);
        }

        .resource-card h5 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .resource-card p {
            color: var(--light-text);
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            background-color: #FF5A4C; /* Version légèrement plus foncée */
            border-color: #FF5A4C;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            background: transparent;
            border: 2px solid var(--primary-color);
            border-radius: 12px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(138, 86, 226, 0.3);
        }

        /* Styles pour le formulaire de publication */
        .post-form-card {
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            padding: 25px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .post-textarea {
            border: none;
            border-radius: 15px;
            background-color: var(--light-bg);
            padding: 20px;
            font-size: 1rem;
            resize: none;
            transition: all 0.3s ease;
        }

        .post-textarea:focus {
            background-color: white;
            box-shadow: 0 0 0 2px var(--secondary-color);
        }

        .post-actions .btn-light {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: var(--light-bg);
            border: none;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .post-actions .btn-light:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .post-media img, .post-media video {
            border-radius: 8px;
            max-height: 300px;
            width: 100%;
            object-fit: cover;
        }
        
        .post-footer .btn {
            border-color: var(--border-color);
            color: var(--text-color);
            transition: all 0.2s ease;
        }
        
        .post-footer .btn:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        /* Styles des commentaires */
        .comments-section {
            background-color: var(--sidebar-hover);
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
        }
        
        .comment-item, .reply-item {
            background-color: var(--card-bg);
            border-radius: 8px;
            padding: 12px;
            border-left: 3px solid var(--secondary-color);
        }
        
        .reply-item {
            border-left: 2px solid var(--border-color);
        }
        
        .comment-author, .reply-author {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-color);
        }
        
        .comment-time, .reply-time {
            font-size: 0.75rem;
            color: var(--light-text);
        }
        
        .comment-content p, .reply-content p {
            margin-bottom: 0;
            color: var(--text-color);
        }
        
        .comment-actions button, .reply-actions button {
            font-size: 0.8rem;
            color: var(--primary-color);
        }
        
        .reply-btn:hover, .comment-toggle:hover {
            text-decoration: underline;
        }
        
        .highlight-comment {
            box-shadow: 0 0 0 2px var(--accent-color);
            animation: highlight-pulse 2s 1;
        }
        
        .small-avatar {
            width: 28px;
            height: 28px;
            font-size: 0.8rem;
        }
        
        .reaction-btn,
        .reaction-link-mini {
            min-width: 60px;
            border-radius: 30px;
            padding: 0.35rem 0.85rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            box-shadow: 0 2px 5px rgba(var(--primary-rgb), 0.07);
            text-decoration: none;
        }
        
        .reaction-btn:hover {
            transform: translateY(-2px);
        }
        
        .reaction-btn .emoji,
        .reaction-link .emoji {
            font-size: 1.3rem;
            vertical-align: middle;
            margin-right: 0.3rem;
            display: inline-block;
            transition: transform 0.2s ease;
        }
        
        .reaction-btn:hover .emoji,
        .reaction-link:hover .emoji {
            transform: scale(1.2);
        }
        
        .reaction-count {
            display: inline-block;
            min-width: 18px;
            text-align: center;
            font-weight: 600;
        }
        
        .reaction-buttons {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        /* Couleurs spécifiques aux types de réactions */
        .btn-outline-primary.reaction-btn:hover, .btn-primary.reaction-btn {
            background-color: #e53e3e;
            border-color: #e53e3e;
            color: white;
        }
        
        .btn-outline-success.reaction-btn:hover, .btn-success.reaction-btn {
            background-color: #38a169;
            border-color: #38a169;
            color: white;
        }
        
        .btn-outline-info.reaction-btn:hover, .btn-info.reaction-btn {
            background-color: #3182ce;
            border-color: #3182ce;
            color: white;
        }
        
        .btn-outline-warning.reaction-btn:hover, .btn-warning.reaction-btn {
            background-color: #d69e2e;
            border-color: #d69e2e;
            color: white;
        }
        
        .btn-outline-danger.reaction-btn:hover, .btn-danger.reaction-btn {
            background-color: #e05780;
            border-color: #e05780;
            color: white;
        }
        
        /* Styles pour les boutons de réaction sur les commentaires */
        .reaction-buttons-mini {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-top: 8px;
        }
        
        .reaction-btn-mini,
        .reaction-link-mini {
            padding: 3px 10px;
            font-size: 0.75rem;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(var(--primary-rgb), 0.05);
            transition: all 0.3s ease;
        }
        
        .reaction-btn-mini:hover,
        .reaction-link-mini:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 6px rgba(var(--primary-rgb), 0.1);
        }
        
        .emoji-mini {
            font-size: 1rem;
            margin-right: 3px;
            transition: transform 0.2s ease;
        }
        
        .reaction-btn-mini:hover .emoji-mini,
        .reaction-link-mini:hover .emoji-mini {
            transform: scale(1.2);
        }
        
        .reaction-count-mini {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--light-text);
        }
        
        .comment-reactions {
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        /* Styles pour le sélecteur d'emojis */
        .emoji-picker-btn {
            background-color: var(--light-bg);
            border-color: var(--border-color);
            color: var(--accent-color);
            border-radius: 0;
            transition: all 0.2s ease;
        }
        
        .emoji-picker-btn:hover {
            background-color: var(--sidebar-hover);
            color: var(--primary-color);
        }
        
        .emoji-picker {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 10px;
            margin-top: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            position: absolute;
            z-index: 100;
            width: 300px;
            max-width: 100%;
        }
        
        .emoji-container {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 8px;
        }
        
        .emoji-item {
            font-size: 1.5rem;
            cursor: pointer;
            text-align: center;
            padding: 5px;
            border-radius: 5px;
            transition: all 0.2s ease;
        }
        
        .emoji-item:hover {
            background-color: var(--sidebar-hover);
            transform: scale(1.2);
        }
        
        .comment-box-container {
            position: relative;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
<<<<<<< HEAD
    <nav class="navbar navbar-expand-lg navbar-light   shadow-sm">
=======
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background-color: var(--navbar-bg); color: var(--text-color);">
>>>>>>> 0dc3f44163489ed095f93683950b12f073bda4bb
        <div class="container">
            <a class="navbar-brand" href="/">
                <span style="color: var(--primary-color); font-weight: 700;">Jigeen</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Support</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ressources</a>
                    </li>
                    @if(session('is_logged_in'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> {{ session('user_name') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i> Mon profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i> Déconnexion</a></li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Connexion</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="dashboard-container">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="sidebar">
                        <div class="sidebar-header">
                            <h3>Jigeen</h3>
                        </div>
                        <ul class="sidebar-menu">
                            <li><a href="{{ route('home') }}" class="active"><i class="fas fa-home"></i> Tableau de bord</a></li>
                            <li><a href="{{ route('profile') }}"><i class="fas fa-user"></i> Mon profil</a></li>
                            <li><a href="{{ route('messages.index') }}"><i class="fas fa-comment"></i> Messages</a></li>
                            <li><a href="{{ route('resources.index') }}"><i class="fas fa-hands-helping"></i> Ressources</a></li>
                            <li><a href="{{ route('communaute.index') }}"><i class="fas fa-users"></i> Communauté</a></li>
                            <li><a href="{{ route('evenements.index') }}"><i class="fas fa-calendar"></i> Événements</a></li>
                            <li><a href="{{ route('parametres.index') }}"><i class="fas fa-cog"></i> Paramètres</a></li>
                            <li><a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Welcome Banner -->
                        <div class="welcome-banner">
                            @if(session('is_logged_in'))
                                <h2>Bienvenue, {{ session('user_name') }} !</h2>
                            @endif
                            <p>Nous sommes heureux de vous revoir sur votre espace sécurisé. Explorez les ressources disponibles et connectez-vous avec la communauté.</p>
                        </div>
<<<<<<< HEAD
=======
                        
                        <!-- Publication Form -->
                        <div class="post-form-card mb-4">
                            <form action="{{ route('publications.save') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" class="form-control mb-3" name="titre" placeholder="Titre de votre publication..." required>
                                    <textarea class="form-control" name="contenu" rows="4" placeholder="Partagez votre témoignage, poser une question ou partager une ressource..." required></textarea>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <!-- Champs cachés pour les valeurs par défaut -->
                                        <input type="hidden" name="categorie" value="general">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" name="est_anonyme" id="est_anonyme">
                                            <label class="form-check-label" for="est_anonyme">
                                                Publier anonymement
                                            </label>
                                        </div>
                                        <input type="hidden" name="date_publication" value="{{ now() }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-2"></i>Publier
                                        </button>
                                    </div>
                                </div>
                            </form>
                            @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
>>>>>>> 0dc3f44163489ed095f93683950b12f073bda4bb

                        <!-- Stats Row -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stat-card">
                                    <div class="icon">
                                        <i class="fas fa-comment"></i>
                                    </div>
                                    <h3>0</h3>
                                    <p>Nouveaux messages</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card">
                                    <div class="icon">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <h3>2</h3>
                                    <p>Événements à venir</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card">
                                    <div class="icon">
                                        <i class="fas fa-hands-helping"></i>
                                    </div>
                                    <h3>5</h3>
                                    <p>Ressources disponibles</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity and Resources -->
                        <div class="row">
                            <div class="col-md-8">
                                <div class="activity-card">
                                    <h4>Publications récentes</h4>
                                    @if(isset($publications) && count($publications) > 0)
                                        @foreach($publications as $publication)
                                            <div class="post-card mb-4">
                                                <div class="post-header d-flex justify-content-between align-items-center">
                                                    <div class="user-info">
                                                        <h5 class="mb-0">{{ $publication->titre }}</h5>
                                                        <div class="d-flex align-items-center mt-1">
                                                            @if($publication->est_anonyme)
                                                                <span class="author"><i class="fas fa-user-secret me-1"></i> Anonyme</span>
                                                            @else
                                                                <span class="author"><i class="fas fa-user me-1"></i> {{ $publication->user ? $publication->user->name : 'Utilisateur' }}</span>
                                                            @endif
                                                            <span class="dot mx-2">&bull;</span>
                                                            <span class="category">{{ ucfirst($publication->categorie) }}</span>
                                                            <span class="dot mx-2">&bull;</span>
                                                            <span class="date">{{ $publication->date_publication->format('d/m/Y H:i') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="post-body mt-3">
                                                    <p>{{ $publication->contenu }}</p>
                                                    @if($publication->media)
                                                        <div class="post-media mt-3">
                                                            @php
                                                                $extension = pathinfo($publication->media, PATHINFO_EXTENSION);
                                                                $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi']);
                                                            @endphp
                                                            
                                                            @if($isVideo)
                                                                <video controls class="w-100" style="max-height: 300px; object-fit: contain;">
                                                                    <source src="{{ asset('storage/'.$publication->media) }}" type="video/{{ $extension }}">
                                                                    Votre navigateur ne supporte pas les vidéos HTML5.
                                                                </video>
                                                            @else
                                                                <img src="{{ asset('storage/'.$publication->media) }}" class="img-fluid rounded" alt="Image de publication">
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="post-footer mt-3 pt-2 border-top">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                         <div class="reaction-buttons">
                                                            <!-- Soutien (coeur) -->
                                                            <a href="{{ route('reactions.store') }}?publication_id={{ $publication->id }}&type_reaction=soutien" 
                                                               class="btn btn-sm {{ $publication->reactions->where('type', 'soutien')->where('user_id', session('user_id'))->count() > 0 ? 'btn-primary' : 'btn-outline-primary' }} reaction-link">
                                                                <span class="emoji">❤️</span> 
                                                                <span class="reaction-count">{{ $publication->reactions->where('type', 'soutien')->count() }}</span>
                                                            </a>
                                                            
                                                            <!-- Encouragement (applaudissements) -->
                                                            <a href="{{ route('reactions.store') }}?publication_id={{ $publication->id }}&type_reaction=encouragement" 
                                                               class="btn btn-sm ms-1 {{ $publication->reactions->where('type', 'encouragement')->where('user_id', session('user_id'))->count() > 0 ? 'btn-success' : 'btn-outline-success' }} reaction-link">
                                                                <span class="emoji">👏</span> 
                                                                <span class="reaction-count">{{ $publication->reactions->where('type', 'encouragement')->count() }}</span>
                                                            </a>
                                                            
                                                            <!-- Solidarité (poignée de main) -->
                                                            <a href="{{ route('reactions.store') }}?publication_id={{ $publication->id }}&type_reaction=solidarite" 
                                                               class="btn btn-sm ms-1 {{ $publication->reactions->where('type', 'solidarite')->where('user_id', session('user_id'))->count() > 0 ? 'btn-info' : 'btn-outline-info' }} reaction-link">
                                                                <span class="emoji">🤝</span> 
                                                                <span class="reaction-count">{{ $publication->reactions->where('type', 'solidarite')->count() }}</span>
                                                            </a>
                                                            
                                                            <!-- Pouce en l'air -->
                                                            <a href="{{ route('reactions.store') }}?publication_id={{ $publication->id }}&type_reaction=pouce" 
                                                               class="btn btn-sm ms-1 {{ $publication->reactions->where('type', 'pouce')->where('user_id', session('user_id'))->count() > 0 ? 'btn-warning' : 'btn-outline-warning' }} reaction-link">
                                                                <span class="emoji">👍</span>
                                                                <span class="reaction-count">{{ $publication->reactions->where('type', 'pouce')->count() }}</span>
                                                            </a>
                                                            
                                                            <!-- Génial (amour) -->
                                                            <a href="{{ route('reactions.store') }}?publication_id={{ $publication->id }}&type_reaction=genial" 
                                                               class="btn btn-sm ms-1 {{ $publication->reactions->where('type', 'genial')->where('user_id', session('user_id'))->count() > 0 ? 'btn-danger' : 'btn-outline-danger' }} reaction-link">
                                                                <span class="emoji">😍</span>
                                                                <span class="reaction-count">{{ $publication->reactions->where('type', 'genial')->count() }}</span>
                                                            </a>
                                                            <button class="btn btn-sm btn-outline-secondary ms-2 comment-toggle" data-publication-id="{{ $publication->id }}">
                                                                <i class="fas fa-comment me-1"></i> 
                                                                Commenter 
                                                                <span class="comment-count">{{ $publication->commentaires->count() }}</span>
                                                            </button>
                                                        </div>
                                                        <div>
                                                            <button class="btn btn-sm btn-outline-secondary" onclick="navigator.share({title: '{{ $publication->titre }}', text: '{{ Str::limit($publication->contenu, 100) }}', url: window.location.href})">
                                                                <i class="fas fa-share-alt"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Section des commentaires (initialement cachée) -->
                                                    <div class="comments-section" id="comments-{{ $publication->id }}" style="display: none;">
                                                        <!-- Formulaire de commentaire -->
                                                        <form action="{{ route('comments.store') }}" method="POST" class="mb-3 comment-form">
                                                            @csrf
                                                            <input type="hidden" name="publication_id" value="{{ $publication->id }}">

                                                             <div class="comment-box-container">
                                                                 <div class="input-group">
                                                                     <textarea class="form-control" name="contenu" id="comment-textarea-{{ $publication->id }}" rows="2" placeholder="Ajouter un commentaire..." required></textarea>
                                                                     <div class="input-group-append">
                                                                         <button type="button" class="btn btn-light emoji-picker-btn" data-textarea-id="comment-textarea-{{ $publication->id }}"><i class="far fa-smile"></i></button>
                                                                         <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                                                                     </div>
                                                                 </div>
                                                                 <div class="emoji-picker" id="emoji-picker-{{ $publication->id }}" style="display: none;">
                                                                     <div class="emoji-container">
                                                                         <span class="emoji-item" data-emoji="❤️">❤️</span>
                                                                         <span class="emoji-item" data-emoji="👍">👍</span>
                                                                         <span class="emoji-item" data-emoji="👏">👏</span>
                                                                         <span class="emoji-item" data-emoji="😊">😊</span>
                                                                         <span class="emoji-item" data-emoji="😍">😍</span>
                                                                         <span class="emoji-item" data-emoji="😂">😂</span>
                                                                         <span class="emoji-item" data-emoji="🙏">🙏</span>
                                                                         <span class="emoji-item" data-emoji="👌">👌</span>
                                                                         <span class="emoji-item" data-emoji="🎉">🎉</span>
                                                                         <span class="emoji-item" data-emoji="🤔">🤔</span>
                                                                         <span class="emoji-item" data-emoji="😮">😮</span>
                                                                         <span class="emoji-item" data-emoji="😢">😢</span>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                        </form>
                                                        
                                                        <!-- Liste des commentaires -->
                                                        <div class="comments-list">
                                                            @foreach($publication->commentaires->whereNull('parent_id') as $comment)
                                                                <div class="comment-item mb-3" id="comment-{{ $comment->id }}">
                                                                    <div class="comment-header d-flex align-items-center">
                                                                        <div class="user-avatar small-avatar">
                                                                            <i class="fas fa-user"></i>
                                                                            {{ substr($comment->user ? $comment->user->name : 'U', 0, 1) }}
                                                                        </div>
                                                                        <div class="ms-2">
                                                                            <div class="comment-author">
                                                                                {{ $comment->user ? $comment->user->name : 'Utilisateur' }}
                                                                            </div>
                                                                            <div class="comment-time">{{ \Carbon\Carbon::parse($comment->date_commentaire)->diffForHumans() }}</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="comment-content mt-2">
                                                                        <p>{{ $comment->contenu }}</p>
                                                                    </div>
                                                                    
                                                                    <!-- Réactions aux commentaires -->
                                                                    <div class="comment-reactions mt-2">
                                                                        <div class="reaction-buttons-mini">
                                                                            <!-- Soutien (coeur) -->
                                                                            <a href="{{ route('reactions.store') }}?commentaire_id={{ $comment->id }}&type_reaction=soutien" 
                                                                               class="btn btn-sm {{ $comment->reactions->where('type', 'soutien')->where('user_id', session('user_id'))->count() > 0 ? 'btn-primary' : 'btn-outline-primary' }} reaction-link-mini">
                                                                                <span class="emoji-mini">❤️</span>
                                                                                <span class="reaction-count-mini">{{ $comment->reactions->where('type', 'soutien')->count() > 0 ? $comment->reactions->where('type', 'soutien')->count() : '' }}</span>
                                                                            </a>
                                                                            
                                                                            <!-- Encouragement (applaudissements) -->
                                                                            <a href="{{ route('reactions.store') }}?commentaire_id={{ $comment->id }}&type_reaction=encouragement" 
                                                                               class="btn btn-sm {{ $comment->reactions->where('type', 'encouragement')->where('user_id', session('user_id'))->count() > 0 ? 'btn-success' : 'btn-outline-success' }} reaction-link-mini">
                                                                                <span class="emoji-mini">👏</span>
                                                                                <span class="reaction-count-mini">{{ $comment->reactions->where('type', 'encouragement')->count() > 0 ? $comment->reactions->where('type', 'encouragement')->count() : '' }}</span>
                                                                            </a>
                                                                            
                                                                            <!-- Pouce (like) -->
                                                                            <a href="{{ route('reactions.store') }}?commentaire_id={{ $comment->id }}&type_reaction=pouce" 
                                                                               class="btn btn-sm {{ $comment->reactions->where('type', 'pouce')->where('user_id', session('user_id'))->count() > 0 ? 'btn-warning' : 'btn-outline-warning' }} reaction-link-mini">
                                                                                <span class="emoji-mini">👍</span>
                                                                                <span class="reaction-count-mini">{{ $comment->reactions->where('type', 'pouce')->count() > 0 ? $comment->reactions->where('type', 'pouce')->count() : '' }}</span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="comment-actions mt-1">
                                                                        @if(session('user_id') == $comment->user_id || session('user_type') == 'admin')
                                                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-sm btn-link text-danger p-0 ms-2">Supprimer</button>
                                                                            </form>
                                                                        @endif
                                                                    </div>
                                                                    

                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-info">
                                            <p class="mb-0">Aucune publication disponible pour le moment.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="resource-card">
                                    <div class="icon">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <h5>Guide des droits</h5>
                                    <p>Un guide complet sur vos droits et les démarches juridiques.</p>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Consulter</a>
                                </div>
                                <div class="resource-card">
                                    <div class="icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <h5>Numéros d'urgence</h5>
                                    <p>Liste des numéros d'urgence et des services d'aide.</p>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Consulter</a>
                                </div>
                                <div class="resource-card">
                                    <div class="icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <h5>Groupes de soutien</h5>
                                    <p>Rejoignez des groupes de soutien près de chez vous.</p>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Consulter</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script pour le sélecteur d'emojis -->
    <script>
        $(document).ready(function() {
            // Gestion des emojis
            $('.emoji-picker-btn').click(function() {
                var textareaId = $(this).data('textarea-id');
                var publicationId = textareaId.split('-').pop();
                $('#emoji-picker-' + publicationId).toggle();
            });
            
            // Insertion des emojis dans le textarea
            $('.emoji-item').click(function() {
                var emoji = $(this).data('emoji');
                var textareaId = $(this).closest('.comment-box-container').find('textarea').attr('id');
                var textarea = document.getElementById(textareaId);
                var start = textarea.selectionStart;
                var end = textarea.selectionEnd;
                var text = textarea.value;
                var before = text.substring(0, start);
                var after = text.substring(end, text.length);
                textarea.value = before + emoji + after;
                textarea.selectionStart = textarea.selectionEnd = start + emoji.length;
                textarea.focus();
                
                // Cacher le sélecteur après sélection
                $(this).closest('.emoji-picker').hide();
            });
            
            // Fermer le sélecteur d'emojis quand on clique ailleurs
            $(document).click(function(e) {
                if (!$(e.target).closest('.emoji-picker').length && !$(e.target).hasClass('emoji-picker-btn')) {
                    $('.emoji-picker').hide();
                }
            });
        });
    </script>
    <!-- Script pour le changement de thème -->
    <script src="{{ asset('js/theme-switcher.js') }}"></script>
    
    <!-- Script pour les commentaires et réactions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion de l'affichage des commentaires
            const commentToggles = document.querySelectorAll('.comment-toggle');
            commentToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const publicationId = this.getAttribute('data-publication-id');
                    const commentsSection = document.getElementById('comments-' + publicationId);
                    
                    if (commentsSection.style.display === 'none' || commentsSection.style.display === '') {
                        commentsSection.style.display = 'block';
                    } else {
                        commentsSection.style.display = 'none';
                    }
                });
            });
            
            // Effet visuel sur les formulaires de réaction (publications et commentaires)
            const reactionForms = document.querySelectorAll('.reaction-buttons form, .reaction-buttons-mini form');
            reactionForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const button = this.querySelector('button');
                    // Animation de clique
                    button.classList.add('pulse-animation');
                    
                    // Déterminer si c'est une réaction pour une publication ou un commentaire
                    const isCommentReaction = this.querySelector('[name="commentaire_id"]') !== null;
                    
                    // Obtenir le conteneur parent pour accéder à tous les boutons liés au même élément
                    const reactionContainer = this.closest(isCommentReaction ? '.reaction-buttons-mini' : '.reaction-buttons');
                    const currentType = this.querySelector('[name="type_reaction"]').value;
                    
                    // Récupérer l'ID de l'élément (publication ou commentaire)
                    const elementId = isCommentReaction 
                        ? this.querySelector('[name="commentaire_id"]').value
                        : this.querySelector('[name="publication_id"]').value;
                    
                    // Envoyer le formulaire en AJAX
                    const formData = new FormData(this);
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    // Afficher un message de débogage
                    console.log('Envoi de la réaction...', {
                        action: this.action,
                        formData: Object.fromEntries(formData),
                        isCommentReaction: isCommentReaction
                    });
                    
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur réseau: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Afficher la réponse du serveur pour débogage
                        console.log('Réponse reçue:', data);
                        // Déterminer la classe des boutons à sélectionner selon le type d'élément
                        const buttonClass = isCommentReaction ? 'button.reaction-btn-mini' : 'button.reaction-btn';
                        
                        // Réinitialiser toutes les réactions pour cet élément
                        const allReactionButtons = reactionContainer.querySelectorAll(buttonClass);
                        allReactionButtons.forEach(btn => {
                            // Réinitialiser tous les boutons en mode outline
                            btn.classList.remove(
                                'btn-primary', 'btn-success', 'btn-info', 
                                'btn-warning', 'btn-danger'
                            );
                            
                            // Trouver le type de réaction de ce bouton
                            const btnType = btn.closest('form').querySelector('[name="type_reaction"]').value;
                            
                            // Appliquer la classe outline appropriée
                            if (btnType === 'soutien') {
                                btn.classList.add('btn-outline-primary');
                            } else if (btnType === 'encouragement') {
                                btn.classList.add('btn-outline-success');
                            } else if (btnType === 'solidarite') {
                                btn.classList.add('btn-outline-info');
                            } else if (btnType === 'pouce') {
                                btn.classList.add('btn-outline-warning');
                            } else if (btnType === 'genial') {
                                btn.classList.add('btn-outline-danger');
                            }
                        });
                        
                        // Si la réaction est active, mettre en évidence le bouton actuel
                        if (data.active) {
                            button.classList.remove(
                                'btn-outline-primary', 'btn-outline-success', 'btn-outline-info',
                                'btn-outline-warning', 'btn-outline-danger'
                            );
                            
                            if (currentType === 'soutien') {
                                button.classList.add('btn-primary');
                            } else if (currentType === 'encouragement') {
                                button.classList.add('btn-success');
                            } else if (currentType === 'solidarite') {
                                button.classList.add('btn-info');
                            } else if (currentType === 'pouce') {
                                button.classList.add('btn-warning');
                            } else if (currentType === 'genial') {
                                button.classList.add('btn-danger');
                            }
                        }
                        
                        // Mettre à jour tous les compteurs
                        // Déterminer la classe CSS du compteur selon le type de réaction (publication ou commentaire)
                        const counterClass = isCommentReaction ? '.reaction-count-mini' : '.reaction-count';
                        
                        // Obtenir les compteurs actualisés depuis le serveur
                        if (data.counts) {
                            Object.keys(data.counts).forEach(type => {
                                try {
                                    const targetForm = reactionContainer.querySelector(`form [name="type_reaction"][value="${type}"]`).closest('form');
                                    if (targetForm) {
                                        const targetCounter = targetForm.querySelector(counterClass);
                                        if (targetCounter) {
                                            // Pour les commentaires, n'afficher le compteur que s'il y a des réactions
                                            if (isCommentReaction) {
                                                targetCounter.textContent = data.counts[type] > 0 ? data.counts[type] : '';
                                            } else {
                                                targetCounter.textContent = data.counts[type];
                                            }
                                        }
                                    }
                                } catch (e) {
                                    console.error('Erreur lors de la mise à jour du compteur:', e);
                                }
                            });
                        } else {
                            // Fallback: mettre à jour juste le compteur actuel
                            const countElement = button.querySelector(counterClass);
                            if (countElement) {
                                if (isCommentReaction) {
                                    countElement.textContent = data.count > 0 ? data.count : '';
                                } else {
                                    countElement.textContent = data.count;
                                }
                            }
                        }
                        
                        // Afficher un message de confirmation
                        if (data.message) {
                            showMessage(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors du traitement de la réaction:', error);
                        console.log('Erreur lors du traitement de la réaction:', error);
                        showMessage('Erreur: ' + error.message, 'danger');
                    });
                });
            });
            
            // Mise à jour du UI après des actions
            if (window.location.hash) {
                const commentId = window.location.hash.substring(1); // Récupérer l'ID du commentaire (sans le #)
                const commentElement = document.getElementById(commentId);
                
                if (commentElement) {
                    // Déplier la section de commentaires si nécessaire
                    const publicationId = commentElement.closest('.post-card').getAttribute('id').replace('post-', '');
                    const commentsSection = document.getElementById('comments-' + publicationId);
                    commentsSection.style.display = 'block';
                    
                    // Mettre en évidence le commentaire
                    commentElement.classList.add('highlight-comment');
                    commentElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    
                    // Enlever la mise en évidence après quelques secondes
                    setTimeout(() => {
                        commentElement.classList.remove('highlight-comment');
                    }, 3000);
                }
            }
            
            // Afficher des messages de succès
            const showMessage = (message, type = 'success') => {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
                alertDiv.style.zIndex = '9999';
                alertDiv.innerHTML = `${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;
                
                document.body.appendChild(alertDiv);
                
                // Auto-fermeture après 3 secondes
                setTimeout(() => {
                    alertDiv.classList.remove('show');
                    setTimeout(() => alertDiv.remove(), 300);
                }, 3000);
            };
            
            // Détecter les messages flash de Laravel
            if (document.querySelector('.alert-success')) {
                const message = document.querySelector('.alert-success').textContent;
                showMessage(message);
                setTimeout(() => document.querySelector('.alert-success').remove(), 300);
            }
        });
    </script>
</body>
</html>
