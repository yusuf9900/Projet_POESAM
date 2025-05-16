<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark mb-4" style="background-color: #0B0F1A; border-bottom: 1px solid #374151;">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('images/logofinal.png') }}" alt="Logo" style="height: 50px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                @php
                    $is_logged_in = isset($_COOKIE['is_logged_in']) && $_COOKIE['is_logged_in'] === 'true';
                    $user_type = $_COOKIE['user_type'] ?? '';
                    $user_name = $_COOKIE['user_name'] ?? 'Utilisateur';
                    $user_email = $_COOKIE['user_email'] ?? '';
                @endphp
<<<<<<< HEAD

=======
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('welcome') }}">Accueil</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('communaute.index') }}">Communauté</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('evenements.index') }}">
                        <i class="fas fa-calendar-alt me-1"></i>Événements
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('resources.index') }}">Ressources</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('messages.index') }}">Messages</a>
                </li>
                
>>>>>>> 0dc3f44163489ed095f93683950b12f073bda4bb
                @if($is_logged_in)
                    @if($user_type == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/dashboard">Tableau de bord</a>
                        </li>
                    @elseif($user_type == 'organisation')
                        <li class="nav-item">
                            <a class="nav-link" href="/organisation/dashboard">Tableau de bord</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/home">Tableau de bord</a>
                        </li>
                    @endif
                @endif
            </ul>

            <ul class="navbar-nav">
                @if($is_logged_in)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar" style="background-color: #4F46E5;">
                                {{ substr($user_name ?? 'U', 0, 1) }}
                            </div>
                            <span class="ms-2">{{ $user_name }}</span>
                        </a>
<<<<<<< HEAD
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Paramètres</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/direct-login.php?logout=1"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
=======
                        <ul class="dropdown-menu dropdown-menu-end" style="background-color: #1F2937; border: 1px solid #374151;" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item text-gray-300 hover:bg-gray-700" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item text-gray-300 hover:bg-gray-700" href="#"><i class="fas fa-cog me-2"></i>Paramètres</a></li>
                            <li><hr class="dropdown-divider border-gray-600"></li>
                            <li><a class="dropdown-item text-gray-300 hover:bg-gray-700" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
>>>>>>> 0dc3f44163489ed095f93683950b12f073bda4bb
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="/direct-login.php">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/direct-register.php">Inscription</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
