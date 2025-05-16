<!-- Barre latérale -->
<style>
    .sidebar {
        background-color: var(--sidebar-bg);
        border-right: 1px solid var(--border-color);
        min-height: 100vh;
        padding: 0;
    }
    
    .sidebar-header {
        background-color: var(--bg-secondary);
        border-bottom: 1px solid var(--border-color);
        padding: 1rem;
    }
    
    .sidebar-link {
        color: var(--sidebar-text);
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    /* S'assurer que le texte est visible dans les deux thèmes */
    [data-theme="light"] .sidebar-link {
        color: #1E293B;
        font-weight: 500;
    }
    
    [data-theme="dark"] .sidebar-link {
        color: #94A3B8;
    }
    
    .sidebar-link:hover {
        color: var(--text-primary);
        background-color: var(--sidebar-hover);
    }
    
    .sidebar-link.active {
        color: var(--text-primary);
        background-color: var(--sidebar-hover);
        border-left: 3px solid var(--sidebar-active);
    }
    
    .sidebar-icon {
        width: 1.25rem;
        margin-right: 0.75rem;
        color: var(--text-secondary);
        transition: color 0.3s ease;
    }
    
    [data-theme="light"] .sidebar-icon {
        color: #4F46E5;
    }
    
    [data-theme="dark"] .sidebar-icon {
        color: #64748B;
    }
    
    .sidebar-link:hover .sidebar-icon,
    .sidebar-link.active .sidebar-icon {
        color: var(--sidebar-active);
    }
    
    /* Couleurs de survol */
    [data-theme="light"] .sidebar-link:hover,
    [data-theme="light"] .sidebar-link.active {
        color: #1E293B;
        background-color: #E2E8F0;
        font-weight: 600;
    }
    
    [data-theme="dark"] .sidebar-link:hover,
    [data-theme="dark"] .sidebar-link.active {
        color: #F1F5F9;
        background-color: #1E293B;
    }
    
    .submenu {
        background-color: var(--bg-primary);
        border-left: 1px solid var(--border-color);
        margin-left: 1rem;
    }
    
    .submenu .sidebar-link {
        padding-left: 2.5rem;
    }
    
    /* Pour s'assurer que le texte du header est lisible dans les deux thèmes */
    .sidebar-header h4 {
        color: var(--text-primary);
        font-weight: 600;
    }
    
    [data-theme="light"] .sidebar-header {
        background-color: #F1F5F9;
        border-bottom: 1px solid #E2E8F0;
    }
    
    [data-theme="dark"] .sidebar-header {
        background-color: #1E293B;
        border-bottom: 1px solid #1E293B;
    }
</style>
<div class="col-md-3 col-lg-2 d-md-block sidebar">
    <div class="position-sticky">
        <div class="sidebar-header d-flex align-items-center justify-content-center">
            <h4 class="mb-0">{{ $userType === 'admin' ? 'Administration' : 'Organisation' }}</h4>
        </div>
        <ul class="nav flex-column py-3">
            <li class="nav-item">
<<<<<<< HEAD
                <a class="nav-link text-white py-3 px-4 {{ request()->is($userType.'/dashboard') ? 'active' : '' }}"
                   href="/{{ $userType }}/dashboard"
                   style="{{ request()->is($userType.'/dashboard') ? 'background-color: #8e44ad;' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i>
=======
                <a class="sidebar-link {{ request()->is($userType.'/dashboard') ? 'active' : '' }}" 
                   href="/{{ $userType }}/dashboard">
                    <i class="fas fa-tachometer-alt sidebar-icon"></i>
>>>>>>> 0dc3f44163489ed095f93683950b12f073bda4bb
                    Tableau de bord
                </a>
            </li>

            @if($userType === 'admin')
            <li class="nav-item">
                <a class="nav-link text-white py-3 px-4 {{ request()->is('admin/organisations*') ? 'active' : '' }}"
                   href="#"
                   data-bs-toggle="collapse"
                   data-bs-target="#organisationsSubmenu"
                   style="{{ request()->is('admin/organisations*') ? 'background-color: #8e44ad;' : '' }}">
                    <i class="fas fa-file-alt sidebar-icon"></i>
                    Organisations
                    <i class="fas fa-chevron-down float-end mt-1"></i>
                </a>
<<<<<<< HEAD
                <div class="collapse {{ request()->is('admin/organisations*') || request()->is('admin/create-organisation') ? 'show' : '' }}"
                     id="organisationsSubmenu"
                     style="background-color: #5d1d89;">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white py-2 ps-5 {{ request()->is('admin/create-organisation') ? 'active' : '' }}"
                               href="/admin/create-organisation"
                               style="{{ request()->is('admin/create-organisation') ? 'background-color: #9b59b6;' : '' }}">
                                <i class="fas fa-plus-circle me-2"></i>
=======
                <div class="collapse submenu {{ request()->is('admin/organisations*') || request()->is('admin/create-organisation') ? 'show' : '' }}" 
                     id="organisationsSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="sidebar-link {{ request()->is('admin/create-organisation') ? 'active' : '' }}" 
                               href="/admin/create-organisation">
                                <i class="fas fa-plus-circle sidebar-icon"></i>
>>>>>>> 0dc3f44163489ed095f93683950b12f073bda4bb
                                Créer
                            </a>
                        </li>
                        <li class="nav-item">
<<<<<<< HEAD
                            <a class="nav-link text-white py-2 ps-5 {{ request()->is('admin/organisations') ? 'active' : '' }}"
                               href="/admin/organisations"
                               style="{{ request()->is('admin/organisations') ? 'background-color: #9b59b6;' : '' }}">
                                <i class="fas fa-list me-2"></i>
=======
                            <a class="sidebar-link {{ request()->is('admin/organisations') ? 'active' : '' }}" 
                               href="/admin/organisations">
                                <i class="fas fa-list sidebar-icon"></i>
>>>>>>> 0dc3f44163489ed095f93683950b12f073bda4bb
                                Liste
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link text-white py-3 px-4 {{ request()->is('admin/users*') ? 'active' : '' }}"
                   href="#"
                   style="{{ request()->is('admin/users*') ? 'background-color: #8e44ad;' : '' }}">
                    <i class="fas fa-users sidebar-icon"></i>
                    Utilisateurs
                </a>
            </li> --}}
            <li class="nav-item">
<<<<<<< HEAD
                <a class="nav-link text-white py-3 px-4 {{ request()->is('admin/statistics*') ? 'active' : '' }}"
                   href="#"
                   style="{{ request()->is('admin/statistics*') ? 'background-color: #8e44ad;' : '' }}">
                    <i class="fas fa-chart-bar me-2"></i>
=======
                <a class="sidebar-link {{ request()->is('admin/statistiques') ? 'active' : '' }}" 
                   href="{{ route('admin.statistiques') }}">
                    <i class="fas fa-chart-bar sidebar-icon"></i>
>>>>>>> 0dc3f44163489ed095f93683950b12f073bda4bb
                    Statistiques
                </a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link text-white py-3 px-4 {{ request()->is('organisation/cases*') ? 'active' : '' }}"
                   href="#"
                   style="{{ request()->is('organisation/cases*') ? 'background-color: #8e44ad;' : '' }}">
                    <i class="fas fa-folder-open me-2"></i>
                    Gestion des cas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white py-3 px-4 {{ request()->is('organisation/stats*') ? 'active' : '' }}"
                   href="#"
                   style="{{ request()->is('organisation/stats*') ? 'background-color: #8e44ad;' : '' }}">
                    <i class="fas fa-chart-bar sidebar-icon"></i>
                    Statistiques
                </a>
            </li>
            @endif

            <li class="nav-item">
                <a class="nav-link text-white py-3 px-4 {{ request()->is($userType.'/settings*') ? 'active' : '' }}"
                   href="#"
                   style="{{ request()->is($userType.'/settings*') ? 'background-color: #8e44ad;' : '' }}">
                    <i class="fas fa-cog sidebar-icon"></i>
                    Paramètres
                </a>
            </li>
            <li class="nav-item mt-3">
                <a class="nav-link text-white py-3 px-4" href="/direct-login.php?logout=1">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Déconnexion
                </a>
            </li>
        </ul>
    </div>
</div>
