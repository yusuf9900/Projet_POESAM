@php
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
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
        :root {
            --primary-color: #8a56e2;
            --secondary-color: #f0ebfa;
            --accent-color: #ff6b6b;
            --text-color: #333;
            --light-text: #6c757d;
            --white: #ffffff;
            --light-bg: #f8f9fa;
            --border-color: #e9ecef;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            background-color: var(--light-bg);
        }

        .dashboard-container {
            padding: 30px 0;
        }

        .sidebar {
            background-color: var(--white);
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
            display: flex;
            align-items: center;
            color: var(--text-color);
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background-color: var(--secondary-color);
            color: var(--primary-color);
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
            background-color: var(--white);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

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

        .welcome-banner h2 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 10px;
        }

        .welcome-banner p {
            color: var(--light-text);
            margin-bottom: 0;
            max-width: 80%;
        }

        .stat-card {
            background-color: var(--white);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .stat-card .icon i {
            font-size: 1.5rem;
            color: var(--primary-color);
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
            background-color: var(--white);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 30px;
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
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .activity-icon i {
            font-size: 1rem;
            color: var(--primary-color);
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
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #7442d3;
            border-color: #7442d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(138, 86, 226, 0.3);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(138, 86, 226, 0.3);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light   shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">
                <span style="color: #8a56e2; font-weight: 700;">Jigeen</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Tableau de bord</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Messages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ressources</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Communauté</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> {{ session('user_name') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Mon profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Paramètres</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/direct-login.php?logout=1"><i class="fas fa-sign-out-alt me-2"></i> Déconnexion</a></li>
                        </ul>
                    </li>
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
                            <li><a href="#" class="active"><i class="fas fa-home"></i> Tableau de bord</a></li>
                            <li><a href="#"><i class="fas fa-user"></i> Mon profil</a></li>
                            <li><a href="#"><i class="fas fa-comment"></i> Messages</a></li>
                            <li><a href="#"><i class="fas fa-hands-helping"></i> Ressources</a></li>
                            <li><a href="#"><i class="fas fa-users"></i> Communauté</a></li>
                            <li><a href="#"><i class="fas fa-calendar"></i> Événements</a></li>
                            <li><a href="#"><i class="fas fa-cog"></i> Paramètres</a></li>
                            <li><a href="/direct-login.php?logout=1"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
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
                                    <h4>Activités récentes</h4>
                                    <div class="activity-item">
                                        <div class="activity-icon">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="activity-content">
                                            <h5>Bienvenue sur Jigeen !</h5>
                                            <p>Vous avez créé votre compte avec succès.</p>
                                            <span class="time">Aujourd'hui</span>
                                        </div>
                                    </div>
                                    <div class="activity-item">
                                        <div class="activity-icon">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                        <div class="activity-content">
                                            <h5>Nouvel événement : Atelier de soutien</h5>
                                            <p>Un nouvel atelier de soutien est prévu pour la semaine prochaine.</p>
                                            <span class="time">Il y a 2 jours</span>
                                        </div>
                                    </div>
                                    <div class="activity-item">
                                        <div class="activity-icon">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        <div class="activity-content">
                                            <h5>Nouvelle ressource disponible</h5>
                                            <p>Un guide sur les droits des femmes a été ajouté aux ressources.</p>
                                            <span class="time">Il y a 3 jours</span>
                                        </div>
                                    </div>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
