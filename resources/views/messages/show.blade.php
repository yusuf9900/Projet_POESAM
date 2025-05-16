@php
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Str;
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversation - Jigeen</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Styles avec couleurs directes */
        body {
            --primary-color: #3E4095;
            --primary-rgb: 62, 64, 149;
            --secondary-color: #788AA3;
            --accent-color: #FFA41B;
            --text-color: #333333;
            --light-text: #555555;
            --white: #ffffff;
            --light-bg: #F8F9FA;
            --border-color: #E8E8E8;
            --gradient-start: #3E4095;
            --gradient-end: #5D5DA8;
            --card-bg: #ffffff;
            --sidebar-bg: #ffffff;
            --sidebar-text: #333333;
            --sidebar-hover: #F5F5F5;
            --navbar-bg: #ffffff;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --danger-color: #dc3545;
            --message-sent-bg: #E9EFFF;
            --message-received-bg: #F1F1F1;
        }
        
        :root[data-theme="dark"] {
            --primary-color: #3E4095;
            --primary-rgb: 62, 64, 149;
            --secondary-color: #788AA3;
            --accent-color: #FFA41B;
            --text-color: #F8F9FA;
            --light-text: #E2E8F0;
            --white: #1E1E1E;
            --light-bg: #121212;
            --border-color: #2C2C2C;
            --gradient-start: #3E4095;
            --gradient-end: #5D5DA8;
            --card-bg: #252525;
            --sidebar-bg: #1E1E1E;
            --sidebar-text: #E2E8F0;
            --sidebar-hover: #383838;
            --navbar-bg: #1E1E1E;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --danger-color: #dc3545;
            --message-sent-bg: #3E4095;
            --message-received-bg: #2C2C2C;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: #333333;
            background-color: #F8F9FA;
        }
        
        .navbar {
            background-color: #FFFFFF;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            padding: 15px 0;
            border-bottom: 1px solid rgba(62, 64, 149, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }
        
        .conversation-container {
            height: calc(100vh - 70px);
            display: flex;
        }
        
        .conversation-list {
            width: 320px;
            border-right: 1px solid #E8E8E8;
            height: 100%;
            overflow-y: auto;
            background-color: #FFFFFF;
        }
        
        .conversation-chat {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background-color: #FFFFFF;
        }
        
        .chat-header {
            padding: 18px 25px;
            border-bottom: 1px solid #E8E8E8;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #FFFFFF;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.03);
            position: relative;
            z-index: 5;
        }
        
        .chat-user-info {
            display: flex;
            align-items: center;
        }
        
        .chat-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3E4095, #5D5DA8);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 15px;
            box-shadow: 0 3px 10px rgba(62, 64, 149, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.8);
            position: relative;
            overflow: hidden;
        }
        
        .chat-avatar::after {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            width: 25px;
            height: 25px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            opacity: 0.6;
        }
        
        .group-avatar {
            background: linear-gradient(135deg, #FFA41B, #FF8A00);
        }
        
        .chat-user-name {
            font-weight: 600;
            color: #333333;
        }
        
        .chat-actions .btn {
            margin-left: 12px;
            border-radius: 50%;
            width: 38px;
            height: 38px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333333;
            background-color: #FFFFFF;
            border: 1px solid #E8E8E8;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .chat-actions .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: rgba(62, 64, 149, 0.05);
            color: #3E4095;
            border-color: #3E4095;
        }
        
        .chat-messages {
            flex-grow: 1;
            padding: 25px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImEiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgcGF0dGVyblRyYW5zZm9ybT0ic2NhbGUoMykiPjxwYXRoIGQ9Ik0gNiwxMCBsIDQsLTQgbCAtNCwtNCBtIC02LDQgbCAxMCwtMTAgbSAtMTAsMjAgbCAxMCwtMTAiIHN0eWxlPSJzdHJva2U6IzNlNDA5NTsgc3Ryb2tlLW9wYWNpdHk6MC4wNTsgc3Ryb2tlLXdpZHRoOjEuMCIgLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjYSkiIC8+PC9zdmc+');
            background-attachment: fixed;
        }
        
        .message {
            max-width: 70%;
            padding: 12px 18px;
            border-radius: 20px;
            margin-bottom: 18px;
            position: relative;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.3s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .message-sent {
            align-self: flex-end;
            background: linear-gradient(120deg, #3E4095, #5D5DA8);
            color: white;
            border-bottom-right-radius: 4px;
            position: relative;
        }
        
        .message-sent::before {
            content: '';
            position: absolute;
            bottom: 0;
            right: -8px;
            width: 15px;
            height: 15px;
            background: linear-gradient(120deg, #5D5DA8, #3E4095);
            border-bottom-left-radius: 15px;
            z-index: -1;
        }
        
        .message-received {
            align-self: flex-start;
            background-color: #F1F1F1;
            color: #333333;
            border-bottom-left-radius: 4px;
            position: relative;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }
        
        .message-received::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: -8px;
            width: 15px;
            height: 15px;
            background-color: #F1F1F1;
            border-bottom-right-radius: 15px;
            z-index: -1;
        }
        
        .message-content {
            margin-bottom: 5px;
            word-wrap: break-word;
        }
        
        .message-time {
            font-size: 0.7rem;
            text-align: right;
            opacity: 0.7;
            margin-top: 3px;
            letter-spacing: 0.2px;
            font-weight: 500;
        }
        
        .chat-input {
            padding: 18px 25px;
            border-top: 1px solid #E8E8E8;
            background-color: #FFFFFF;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 5;
            box-shadow: 0 -2px 15px rgba(0, 0, 0, 0.03);
        }
        
        .chat-input-box {
            flex-grow: 1;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 25px;
            background-color: var(--white);
            color: var(--text-color);
            resize: none;
        }
        
        .chat-input-box:focus {
            outline: none;
            border-color: var(--primary-color);
        }
        
        .emoji-picker {
            position: absolute;
            bottom: 85px;
            right: 25px;
            background-color: #FFFFFF;
            border: 1px solid #E8E8E8;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            width: 320px;
            animation: fadeInUp 0.3s ease-out;
            overflow: hidden;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .emoji-button, .attachment-button {
            color: #788AA3;
            font-size: 1.2rem;
            cursor: pointer;
            margin-right: 15px;
            transition: all 0.3s ease;
            padding: 8px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .emoji-button:hover, .attachment-button:hover {
            color: #3E4095;
            background-color: rgba(62, 64, 149, 0.08);
            transform: scale(1.1);
        }
        
        .chat-send-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .chat-send-btn:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 5px 15px rgba(var(--primary-rgb), 0.4);
        }
        
        .chat-attachment-btn {
            background-color: transparent;
            color: var(--light-text);
            border: none;
            padding: 0 10px;
            cursor: pointer;
        }
        
        /* Style pour les membres du groupe */
        .group-members {
            padding: 20px;
            background-color: var(--white);
            border-left: 1px solid var(--border-color);
            width: 250px;
            overflow-y: auto;
        }
        
        .members-header {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
        }
        
        .member-item {
            display: flex;
            align-items: center;
            padding: 8px 0;
        }
        
        .member-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 10px;
        }
        
        .member-name {
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .member-status {
            font-size: 0.75rem;
            color: var(--light-text);
        }
        
        .admin-badge {
            font-size: 0.7rem;
            background-color: var(--primary-color);
            color: white;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: 5px;
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

    <!-- Conversation Container -->
    <div class="container-fluid">
        <div class="conversation-container">
            <!-- Conversation List - Using includes -->
            @include('messages.partials.conversation_list', ['conversations' => $conversations, 'currentConversation' => $conversation])
            
            <!-- Main Chat Area -->
            <div class="conversation-chat">
                <!-- Chat Header -->
                <div class="chat-header">
                    <div class="chat-user-info">
                        <div class="chat-avatar {{ $conversation->est_groupe ? 'group-avatar' : '' }}">
                            @if($conversation->est_groupe)
                                <i class="fas fa-users"></i>
                            @else
                                @php 
                                    $otherUser = $conversation->users->where('id', '!=', session('user_id'))->first();
                                @endphp
                                {{ $otherUser ? substr($otherUser->name, 0, 1) : '?' }}
                            @endif
                        </div>
                        <div>
                            <div class="chat-user-name">
                                @if($conversation->est_groupe)
                                    {{ $conversation->titre }}
                                @else
                                    {{ $otherUser ? $otherUser->name : 'Utilisateur inconnu' }}
                                @endif
                            </div>
                            @if($conversation->est_groupe)
                                <div class="chat-user-status">{{ $members->count() }} membres</div>
                            @endif
                        </div>
                    </div>
                    <div class="chat-actions">
                        @if($conversation->est_groupe)
                            <button class="btn" id="toggleMembers"><i class="fas fa-users"></i></button>
                        @endif
                        <button class="btn" data-bs-toggle="modal" data-bs-target="#conversationInfoModal"><i class="fas fa-info-circle"></i></button>
                        <a href="{{ route('messages.leave', $conversation->id) }}" class="btn" onclick="return confirm('Êtes-vous sûr de vouloir quitter cette conversation?')"><i class="fas fa-sign-out-alt"></i></a>
                    </div>
                </div>
                
                <!-- Chat Messages -->
                <div class="chat-messages" id="chatMessages">
                    @foreach($messages as $message)
                        <div class="message {{ $message->user_id == session('user_id') ? 'message-sent' : 'message-received' }}">
                            @if($message->user_id != session('user_id') && $conversation->est_groupe)
                                <div class="message-sender">{{ $message->user->name }}</div>
                            @endif
                            <div class="message-content">{{ $message->contenu }}</div>
                            @if($message->fichier_attaché)
                                <div class="message-attachment">
                                    <a href="{{ asset('storage/'.$message->fichier_attaché) }}" target="_blank">
                                        <i class="fas fa-paperclip"></i> Pièce jointe
                                    </a>
                                </div>
                            @endif
                            <div class="message-time">{{ Carbon::parse($message->created_at)->format('H:i') }}</div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Chat Input -->
                <div class="chat-input">
                    <form action="{{ route('messages.store.message', $conversation->id) }}" method="POST" enctype="multipart/form-data" id="messageForm">
                        @csrf
                        <div class="chat-input-container">
                            <button type="button" class="chat-attachment-btn" id="attachmentBtn">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            <input type="file" name="fichier" id="fichierInput" style="display: none;">
                            <textarea class="chat-input-box" name="contenu" placeholder="Tapez votre message..." required></textarea>
                            <button type="submit" class="chat-send-btn">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Group Members Panel (Hidden by default) -->
            @if($conversation->est_groupe)
                <div class="group-members" id="groupMembers" style="display: none;">
                    <div class="members-header">
                        <div>Membres du groupe</div>
                        @php
                            $isAdmin = $conversation->users()->where('user_id', session('user_id'))->where('est_administrateur', true)->exists();
                        @endphp
                        @if($isAdmin)
                            <button class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#addMembersModal">
                                <i class="fas fa-user-plus"></i> Ajouter
                            </button>
                        @endif
                    </div>
                    <div class="members-list">
                        @foreach($members as $member)
                            <div class="member-item">
                                <div class="member-avatar">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="member-name">
                                        {{ $member->name }}
                                        @if($member->pivot->est_administrateur)
                                            <span class="admin-badge">Admin</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Conversation Info Modal -->
    <div class="modal fade" id="conversationInfoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informations</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Type :</strong> {{ $conversation->est_groupe ? 'Groupe' : 'Conversation individuelle' }}</p>
                    @if($conversation->est_groupe)
                        <p><strong>Nom du groupe :</strong> {{ $conversation->titre }}</p>
                        <p><strong>Créé le :</strong> {{ Carbon::parse($conversation->created_at)->format('d/m/Y à H:i') }}</p>
                        <p><strong>Nombre de membres :</strong> {{ $members->count() }}</p>
                    @else
                        <p><strong>Avec :</strong> {{ $otherUser ? $otherUser->name : 'Utilisateur inconnu' }}</p>
                        <p><strong>Email :</strong> {{ $otherUser ? $otherUser->email : 'N/A' }}</p>
                        <p><strong>Conversation démarrée le :</strong> {{ Carbon::parse($conversation->created_at)->format('d/m/Y à H:i') }}</p>
                    @endif
                    <p><strong>Nombre de messages :</strong> {{ $messages->count() }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Members Modal -->
    @if($conversation->est_groupe && $isAdmin)
        <div class="modal fade" id="addMembersModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter des membres</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('messages.add.membres', $conversation->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Sélectionner des utilisateurs</label>
                                <div class="card p-3" style="max-height: 200px; overflow-y: auto;">
                                    @php
                                        $existingMemberIds = $members->pluck('id')->toArray();
                                        $availableUsers = \App\Models\User::whereNotIn('id', $existingMemberIds)->get();
                                    @endphp
                                    
                                    @if($availableUsers->count() > 0)
                                        @foreach($availableUsers as $user)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="membres[]" value="{{ $user->id }}" id="add-user-{{ $user->id }}">
                                                <label class="form-check-label" for="add-user-{{ $user->id }}">
                                                    {{ $user->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted">Aucun utilisateur disponible</p>
                                    @endif
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Bootstrap & jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chat Scripts -->
    <script>
        $(document).ready(function() {
            // Scroll to bottom of chat
            scrollToBottom();
            
            // Toggle group members panel
            $('#toggleMembers').click(function() {
                $('#groupMembers').toggle();
            });
            
            // File attachment button
            $('#attachmentBtn').click(function() {
                $('#fichierInput').click();
            });
            
            // Show selected file name
            $('#fichierInput').change(function() {
                if (this.files.length > 0) {
                    alert('Fichier sélectionné: ' + this.files[0].name);
                }
            });
            
            // Change theme
            $('.theme-toggle').click(function() {
                if ($('body').attr('data-bs-theme') === 'light') {
                    $('body').attr('data-bs-theme', 'dark');
                    $('.theme-toggle i').removeClass('fa-moon').addClass('fa-sun');
                } else {
                    $('body').attr('data-bs-theme', 'light');
                    $('.theme-toggle i').removeClass('fa-sun').addClass('fa-moon');
                }
            });
            
            // Scroll to bottom function
            function scrollToBottom() {
                var chatMessages = document.getElementById('chatMessages');
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    </script>
</body>
</html>
