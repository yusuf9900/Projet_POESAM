<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom mb-4">
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
                            <div class="user-avatar">
                                {{ substr($user_name ?? 'U', 0, 1) }}
                            </div>
                            <span class="ms-2">{{ $user_name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Paramètres</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/direct-login.php?logout=1"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
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
