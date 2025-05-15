<!-- Barre latérale -->
<div class="col-md-3 col-lg-2 d-md-block sidebar" style="min-height: calc(100vh - 56px); background-color: #6a1b9a; padding: 0;">
    <div class="position-sticky">
        <div class="d-flex align-items-center justify-content-center py-3" style="background-color: #4a148c;">
            <h4 class="text-white mb-0">{{ $userType === 'admin' ? 'Administration' : 'Organisation' }}</h4>
        </div>
        <ul class="nav flex-column py-3">
            <li class="nav-item">
                <a class="nav-link text-white py-3 px-4 {{ request()->is($userType.'/dashboard') ? 'active' : '' }}"
                   href="/{{ $userType }}/dashboard"
                   style="{{ request()->is($userType.'/dashboard') ? 'background-color: #8e44ad;' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i>
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
                    <i class="fas fa-building me-2"></i>
                    Organisations
                    <i class="fas fa-chevron-down float-end mt-1"></i>
                </a>
                <div class="collapse {{ request()->is('admin/organisations*') || request()->is('admin/create-organisation') ? 'show' : '' }}"
                     id="organisationsSubmenu"
                     style="background-color: #5d1d89;">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white py-2 ps-5 {{ request()->is('admin/create-organisation') ? 'active' : '' }}"
                               href="/admin/create-organisation"
                               style="{{ request()->is('admin/create-organisation') ? 'background-color: #9b59b6;' : '' }}">
                                <i class="fas fa-plus-circle me-2"></i>
                                Créer
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white py-2 ps-5 {{ request()->is('admin/organisations') ? 'active' : '' }}"
                               href="/admin/organisations"
                               style="{{ request()->is('admin/organisations') ? 'background-color: #9b59b6;' : '' }}">
                                <i class="fas fa-list me-2"></i>
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
                    <i class="fas fa-users me-2"></i>
                    Utilisateurs
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link text-white py-3 px-4 {{ request()->is('admin/statistics*') ? 'active' : '' }}"
                   href="#"
                   style="{{ request()->is('admin/statistics*') ? 'background-color: #8e44ad;' : '' }}">
                    <i class="fas fa-chart-bar me-2"></i>
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
                    <i class="fas fa-chart-bar me-2"></i>
                    Statistiques
                </a>
            </li>
            @endif

            <li class="nav-item">
                <a class="nav-link text-white py-3 px-4 {{ request()->is($userType.'/settings*') ? 'active' : '' }}"
                   href="#"
                   style="{{ request()->is($userType.'/settings*') ? 'background-color: #8e44ad;' : '' }}">
                    <i class="fas fa-cog me-2"></i>
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
