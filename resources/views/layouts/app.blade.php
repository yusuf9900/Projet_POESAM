<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jigeen - Plateforme de protection</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        /* Theme Variables */
        :root[data-theme="light"] {
            --bg-primary: #F8FAFC;
            --bg-secondary: #F1F5F9;
            --bg-card: #FFFFFF;
            --text-primary: #0F172A; /* Plus foncé pour un meilleur contraste */
            --text-secondary: #334155; /* Plus foncé pour un meilleur contraste */
            --text-muted: #64748B; /* Plus foncé pour un meilleur contraste */
            --border-color: #CBD5E1;
            --sidebar-bg: #F8FAFC;
            --sidebar-text: #1E293B; /* Plus foncé pour un meilleur contraste */
            --sidebar-hover: #E2E8F0;
            --sidebar-active: #4F46E5;
            --navbar-bg: #FFFFFF;
            --footer-height: 400px;
        }

        :root[data-theme="dark"] {
            --bg-primary: #111827;
            --bg-secondary: #1F2937;
            --bg-card: #1F2937;
            --text-primary: #F9FAFB;
            --text-secondary: #D1D5DB;
            --text-muted: #9CA3AF;
            --border-color: #374151;
            --sidebar-bg: #0F172A;
            --sidebar-text: #94A3B8;
            --sidebar-hover: #1E293B;
            --sidebar-active: #6366F1;
            --navbar-bg: #0B0F1A;
        }

        /* Base Styles */
        html {
            position: relative;
            min-height: 100%;
        }
        
        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            margin-bottom: 400px; /* Hauteur approximative du footer */
        }

        /* Theme Switcher */
        .theme-switcher {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 8px 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .theme-switcher:hover {
            box-shadow: 0 8px 12px -1px rgba(0, 0, 0, 0.2);
        }

        .theme-icon {
            font-size: 1.2rem;
            color: var(--text-primary);
        }
        .bg-violet-900 {
            background-color: #4C1D95;
        }
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        :root {
            --primary-color: #8e44ad;
            --secondary-color: #9b59b6;
            --accent-color: #d35400;
            --light-color: #f8f9fa;
            --bg-violet-900-color: #343a40;
        }
        
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar-custom {
            background-color: var(--primary-color);
        }
        
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: white;
        }
        
        .navbar-custom .nav-link:hover {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .card-header {
            border-radius: 10px 10px 0 0 !important;
            font-weight: bold;
        }
        
        /* Les styles du footer sont maintenant dans la section footer */
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--secondary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    @include('layouts.navbar')

    <!-- Contenu principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer fixe en bas -->
    <footer class="footer mt-auto py-4">
        <div class="container">
            <div class="row footer-main-content">
                <!-- Colonne gauche : Logo et description -->
                <div class="col-lg-4 col-md-4 footer-brand-section">
                    <div class="footer-brand mb-3">
                        <i class="fas fa-shield-alt me-2"></i>
                        <span class="h5 fw-bold m-0">Jigeen</span>
                    </div>
                    <div class="footer-description-wrapper w-100">
                        <p class="footer-description">Une plateforme innovante dédiée à la protection et à l'autonomisation des femmes face aux violences basées sur le genre au Sénégal.</p>
                    </div>
                    <div class="social-links mt-4">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <!-- Colonne du milieu : Liens utiles -->
                <div class="col-lg-4 col-md-4 footer-links-section">
                    <div class="row">
                        <!-- Liens rapides -->
                        <div class="col-6">
                            <h6 class="footer-heading">Liens rapides</h6>
                            <ul class="footer-nav">
                                <li><a href="/">Accueil</a></li>
                                <li><a href="#">À propos</a></li>
                                <li><a href="#">Services</a></li>
                                <li><a href="#">Contact</a></li>
                            </ul>
                        </div>
                        
                        <!-- Ressources -->
                        <div class="col-6">
                            <h6 class="footer-heading">Ressources</h6>
                            <ul class="footer-nav">
                                <li><a href="#">Blog</a></li>
                                <li><a href="#">FAQ</a></li>
                                <li><a href="#">Témoignages</a></li>
                                <li><a href="#">Support</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Colonne droite : Contact -->
                <div class="col-lg-4 col-md-4 footer-contact-section">
                    <h6 class="footer-heading">Contact</h6>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> Dakar, Sénégal</li>
                        <li><i class="fas fa-envelope"></i> contact@jigeen.org</li>
                        <li><i class="fas fa-phone"></i> +221 XX XXX XX XX</li>
                        <li><i class="fas fa-clock"></i> Lun-Ven: 9h-17h</li>
                    </ul>
                </div>
            </div>
            
            <!-- Ligne de séparation -->
            <hr class="my-4 opacity-25">
            
            <!-- Copyright et liens légaux : trois colonnes alignées -->
            <div class="row footer-bottom align-items-center text-center">
                <div class="col-md-4 copyright mb-3 mb-md-0">
                    <p class="m-0">&copy; {{ date('Y') }} Jigeen</p>
                </div>
                <div class="col-md-4 attribution mb-3 mb-md-0">
                    <p class="m-0">Tous droits réservés</p>
                </div>
                <div class="col-md-4 legal-links d-flex justify-content-md-end justify-content-center">
                    <a href="#">Politique de confidentialité</a>
                    <a href="#" class="ms-3">Conditions d'utilisation</a>
                </div>
            </div>
        </div>
    </footer>
    
    <style>
        /* Styles du footer avec adaptation au thème */
        .footer {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            border-top: 1px solid var(--border-color);
        }
        
        .gradient-text {
            color: #4F46E5;
        }
        
        /* Footer styling */
        .footer {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            border-top: 1px solid var(--border-color);
            padding-top: 3rem;
            padding-bottom: 1.5rem;
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 400px; /* Hauteur approximative du footer */
        }
        
        .footer-main-content {
            margin-bottom: 2rem;
        }
        

        
        /* Footer brand section */
        .footer-brand {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .footer-brand i {
            font-size: 1.5rem;
            color: #4F46E5;
            margin-right: 0.5rem;
        }
        
        .footer-description-wrapper {
            display: block;
            width: 100%;
        }
        
        .footer-description {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 0;
            width: 100%;
            display: inline-block;
            max-width: 100%;
        }
        
        /* Social links */
        .social-links {
            display: flex;
            gap: 12px;
        }
        
        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--bg-primary);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background-color: #4F46E5;
            color: white;
            transform: translateY(-3px);
        }
        
        /* Footer headings */
        .footer-heading {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.25rem;
            position: relative;
        }
        
        .footer-heading::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 30px;
            height: 2px;
            background-color: #4F46E5;
        }
        
        /* Footer navigation */
        .footer-nav, .footer-contact {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-nav li, .footer-contact li {
            margin-bottom: 0.75rem;
            display: flex;
            align-items: baseline;
        }
        
        .footer-nav a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }
        
        .footer-nav a:hover {
            color: #4F46E5;
            padding-left: 5px;
        }
        
        /* Contact info */
        .footer-contact li {
            color: var(--text-secondary);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }
        
        .footer-contact li i {
            color: #4F46E5;
            width: 20px;
            margin-right: 10px;
        }
        
        /* Footer bottom section */
        .footer-bottom {
            padding-top: 1rem;
            font-size: 0.85rem;
        }
        
        .copyright, .attribution {
            color: var(--text-secondary);
        }
        
        .legal-links {
            gap: 20px;
        }
        
        .legal-links a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .legal-links a:hover {
            color: #4F46E5;
        }
        
        /* Responsive styles */
        @media (max-width: 991px) {
            .footer-brand-section,
            .footer-links-section,
            .footer-contact-section {
                margin-bottom: 1.5rem;
            }
        }
        
        @media (max-width: 767px) {
            body {
                margin-bottom: 600px; /* Hauteur approximative du footer sur mobile */
            }
            
            .footer {
                height: 600px; /* Hauteur approximative du footer sur mobile */
            }
            
            .footer-heading {
                margin-top: 1.5rem;
                margin-bottom: 1rem;
            }
            
            .footer-links-section .row {
                margin-top: 1rem;
            }
            
            .legal-links {
                justify-content: center;
            }
            
            .legal-links a {
                margin: 0 10px;
            }
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Theme Switcher Script -->
    <script src="{{ asset('js/theme-switcher.js') }}"></script>
    
    <!-- Le script theme-switcher.js gère le thème sur toutes les pages -->
    @yield('scripts')
</body>
</html>
