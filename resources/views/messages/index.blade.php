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
    <title>Messagerie - Jigeen</title>
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
        
        .container-fluid {
            padding: 0;
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
        
        .messaging-container {
            height: calc(100vh - 70px);
            display: flex;
        }
        
        .conversation-list {
            width: 320px;
            border-right: 1px solid var(--border-color);
            height: 100%;
            overflow-y: auto;
            background-color: var(--sidebar-bg);
        }
        
        .conversation-header {
            padding: 20px;
            border-bottom: 1px solid #E0E0E0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #FFFFFF;
            position: sticky;
            top: 0;
            z-index: 5;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            backdrop-filter: blur(5px);
        }
        
        .conversation-header h4 {
            margin: 0;
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .new-conversation-btn {
            background: linear-gradient(135deg, #3E4095, #5D5DA8);
            color: white;
            border: none;
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(62, 64, 149, 0.3);
        }
        
        .new-conversation-btn:hover {
            background-color: var(--gradient-end);
            transform: scale(1.1);
        }
        
        .search-box {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 61px;
            background-color: var(--sidebar-bg);
            z-index: 4;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }
        
        .search-input {
            width: 100%;
            padding: 12px 20px;
            border: 1px solid var(--border-color);
            border-radius: 25px;
            background-color: var(--white);
            color: var(--text-color);
            transition: all 0.3s ease;
            font-size: 0.9rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03) inset;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="%23AAAAAA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>');
            background-repeat: no-repeat;
            background-position: calc(100% - 12px) center;
            padding-right: 40px;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #3E4095;
            box-shadow: 0 0 0 3px rgba(62, 64, 149, 0.1);
            transform: translateY(-1px);
        }
        
        .conversation-item {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: var(--text-color);
            position: relative;
        }
        
        .conversation-item::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background-color: #3E4095;
            transition: all 0.3s ease;
            opacity: 0.7;
        }
        
        .conversation-item:hover {
            background-color: #F5F5F5;
            transform: translateX(3px);
        }
        
        .conversation-item.active {
            background-color: rgba(62, 64, 149, 0.05);
        }
        
        .conversation-item.active::after {
            width: 3px;
        }
        
        .conversation-item.unread {
            background-color: rgba(var(--primary-rgb), 0.05);
        }
        
        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3E4095, #5D5DA8);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 15px;
            flex-shrink: 0;
            box-shadow: 0 3px 8px rgba(62, 64, 149, 0.25);
            border: 2px solid rgba(255, 255, 255, 0.9);
            position: relative;
            overflow: hidden;
        }
        
        .user-avatar::after {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            opacity: 0.6;
        }
        
        .conversation-info {
            flex-grow: 1;
            overflow: hidden;
        }
        
        .conversation-name {
            font-weight: 600;
            margin-bottom: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .conversation-last-message {
            font-size: 0.85rem;
            color: var(--light-text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .conversation-meta {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            margin-left: 10px;
            flex-shrink: 0;
        }
        
        .conversation-time {
            font-size: 0.75rem;
            color: var(--light-text);
            margin-bottom: 3px;
        }
        
        .unread-count {
            background: linear-gradient(135deg, #3E4095, #5D5DA8);
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(62, 64, 149, 0.3);
            position: relative;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(62, 64, 149, 0.4);
            }
            70% {
                box-shadow: 0 0 0 6px rgba(62, 64, 149, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(62, 64, 149, 0);
            }
        }
        
        .welcome-message {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 20px;
            text-align: center;
            background-color: var(--card-bg);
            flex-grow: 1;
            position: relative;
            overflow: hidden;
        }
        
        .welcome-message::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at top right, rgba(62, 64, 149, 0.05) 0%, transparent 70%);
            top: 0;
            left: 0;
            z-index: 0;
        }
        
        .welcome-message::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at bottom left, rgba(62, 64, 149, 0.05) 0%, transparent 70%);
            top: 0;
            left: 0;
            z-index: 0;
        }
        
        .welcome-icon {
            font-size: 4.5rem;
            color: #3E4095;
            margin-bottom: 25px;
            background: linear-gradient(135deg, #3E4095, #5D5DA8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            position: relative;
            z-index: 1;
            text-shadow: 0 5px 15px rgba(62, 64, 149, 0.2);
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% {
                transform: translatey(0px);
            }
            50% {
                transform: translatey(-10px);
            }
            100% {
                transform: translatey(0px);
            }
        }
        
        .welcome-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: #3E4095;
            position: relative;
            z-index: 1;
            letter-spacing: -0.5px;
        }
        
        .welcome-title::after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #3E4095, #5D5DA8);
            margin: 15px auto 0;
            border-radius: 3px;
        }
        
        .welcome-subtitle {
            font-size: 1.1rem;
            color: var(--light-text);
            max-width: 500px;
            margin-bottom: 30px;
        }
        
        .modal-header, .modal-footer {
            background-color: var(--card-bg);
            border-color: var(--border-color);
        }
        
        .modal-body {
            background-color: var(--white);
        }
        
        .modal-title {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .form-label {
            color: var(--text-color);
            font-weight: 500;
        }
        
        .form-control {
            border-color: var(--border-color);
            color: var(--text-color);
            background-color: var(--white);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(var(--primary-rgb), 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3E4095, #5D5DA8);
            border: none;
            padding: 12px 28px;
            font-weight: 600;
            border-radius: 30px;
            box-shadow: 0 4px 12px rgba(62, 64, 149, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #5D5DA8, #3E4095);
            z-index: -1;
            transition: opacity 0.3s ease;
            opacity: 0;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(62, 64, 149, 0.4);
        }
        
        .btn-primary:hover::after {
            opacity: 1;
        }
        
        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 3px 8px rgba(var(--primary-rgb), 0.3);
        }
        
        .group-icon {
            background-color: #FFA41B;
            background: linear-gradient(135deg, #FFA41B, #FF8A00);
            font-size: 0.9rem;
        }
    </style>
</head>
<body data-bs-theme="light">
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
                        <a class="nav-link active" href="{{ route('messages.index') }}">
                            <i class="fas fa-envelope me-1"></i> Messages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile') }}">
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

    <!-- Messaging Container -->
    <div class="container-fluid">
        <div class="messaging-container">
            <!-- Conversation List -->
            <div class="conversation-list">
                <div class="conversation-header">
                    <h4>Messages</h4>
                    <button class="new-conversation-btn" data-bs-toggle="modal" data-bs-target="#newConversationModal">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Rechercher une conversation...">
                </div>
                <div class="conversations">
                    @if($conversations->count() > 0)
                        @foreach($conversations as $conversation)
                            @php
                                $otherUser = $conversation->users->where('id', '!=', session('user_id'))->first();
                                $unreadCount = $conversation->messagesNonLus(session('user_id'));
                                $lastMessage = $conversation->dernierMessage;
                                $isUnread = $unreadCount > 0;
                                $timestamp = $lastMessage ? $lastMessage->created_at : $conversation->created_at;
                                $displayTime = $timestamp->isToday() ? $timestamp->format('H:i') : $timestamp->format('d/m/Y');
                            @endphp
                            <a href="{{ route('messages.show', $conversation->id) }}" class="conversation-item {{ $isUnread ? 'unread' : '' }}">
                                <div class="user-avatar {{ $conversation->est_groupe ? 'group-icon' : '' }}">
                                    @if($conversation->est_groupe)
                                        <i class="fas fa-users"></i>
                                    @else
                                        {{ $otherUser ? substr($otherUser->name, 0, 1) : '?' }}
                                    @endif
                                </div>
                                <div class="conversation-info">
                                    <div class="conversation-name">
                                        @if($conversation->est_groupe)
                                            {{ $conversation->titre }}
                                        @else
                                            {{ $otherUser ? $otherUser->name : 'Utilisateur inconnu' }}
                                        @endif
                                    </div>
                                    <div class="conversation-last-message">
                                        {{ $lastMessage ? Str::limit($lastMessage->contenu, 30) : 'Aucun message' }}
                                    </div>
                                </div>
                                <div class="conversation-meta">
                                    <div class="conversation-time">{{ $displayTime }}</div>
                                    @if($isUnread)
                                        <div class="unread-count">{{ $unreadCount }}</div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="p-4 text-center text-muted">
                            Aucune conversation pour le moment
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Welcome Message (when no conversation is selected) -->
            <div class="welcome-message">
                <div class="welcome-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <h2 class="welcome-title">Bienvenue dans votre messagerie</h2>
                <p class="welcome-subtitle">Sélectionnez une conversation existante ou démarrez une nouvelle conversation pour commencer.</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newConversationModal">
                    <i class="fas fa-plus me-2"></i> Nouvelle conversation
                </button>
            </div>
        </div>
    </div>
    
    <!-- New Conversation Modal -->
    <div class="modal fade" id="newConversationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nouvelle conversation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs mb-3" id="conversationTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="individual-tab" data-bs-toggle="tab" data-bs-target="#individual" type="button" role="tab">Individuelle</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="group-tab" data-bs-toggle="tab" data-bs-target="#group" type="button" role="tab">Groupe</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="conversationTabsContent">
                        <!-- Individual Conversation Form -->
                        <div class="tab-pane fade show active" id="individual" role="tabpanel" aria-labelledby="individual-tab">
                            <form action="{{ route('messages.store.conversation') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Sélectionner un utilisateur</label>
                                    <select name="user_id" id="user_id" class="form-select" required>
                                        <option value="">Choisir un utilisateur</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Démarrer la conversation</button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Group Conversation Form -->
                        <div class="tab-pane fade" id="group" role="tabpanel" aria-labelledby="group-tab">
                            <form action="{{ route('messages.store.groupe') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="titre" class="form-label">Nom du groupe</label>
                                    <input type="text" class="form-control" id="titre" name="titre" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Membres du groupe</label>
                                    <div class="card p-3" style="max-height: 200px; overflow-y: auto;">
                                        @foreach($users as $user)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="membres[]" value="{{ $user->id }}" id="user-{{ $user->id }}">
                                                <label class="form-check-label" for="user-{{ $user->id }}">
                                                    {{ $user->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Créer le groupe</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script pour la recherche -->
    <script>
        $(document).ready(function() {
            $('.search-input').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('.conversation-item').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            
            // Changement de thème
            $('.theme-toggle').click(function() {
                if ($('body').attr('data-bs-theme') === 'light') {
                    $('body').attr('data-bs-theme', 'dark');
                    $('.theme-toggle i').removeClass('fa-moon').addClass('fa-sun');
                } else {
                    $('body').attr('data-bs-theme', 'light');
                    $('.theme-toggle i').removeClass('fa-sun').addClass('fa-moon');
                }
            });
        });
    </script>
</body>
</html>
