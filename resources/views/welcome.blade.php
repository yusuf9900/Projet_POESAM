@php
    use Illuminate\Support\Facades\Auth;
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jigeen - Un espace sécurisé pour partager et recevoir du soutien</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>

    <style>
        :root {
            --primary-color: #8a56e2;
            --secondary-color: #f0ebfa;
            --accent-color: #ff6b6b;
            --text-color: #333;
            --light-text: #6c757d;
            --white: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            background-color: #fcfcfc;
            overflow-x: hidden;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 10px 24px;
            border-radius: 50px;
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
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(138, 86, 226, 0.3);
        }

        .navbar {
            padding: 15px 0;
            background-color: var(--white);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .navbar-brand i {
            margin-right: 10px;
            color: var(--primary-color);
        }

        .hero-section {
            background-color: var(--secondary-color);
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background-color: rgba(138, 86, 226, 0.1);
            border-radius: 50%;
            top: -100px;
            left: -100px;
            z-index: 0;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background-color: rgba(138, 86, 226, 0.1);
            border-radius: 50%;
            bottom: -200px;
            right: -200px;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-title span {
            color: var(--primary-color);
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--light-text);
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .feature-card {
            background-color: var(--white);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .icon-chat {
            background-color: rgba(138, 86, 226, 0.1);
            color: var(--primary-color);
        }

        .icon-heart {
            background-color: rgba(255, 107, 107, 0.1);
            color: var(--accent-color);
        }

        .icon-users {
            background-color: rgba(52, 152, 219, 0.1);
            color: #3498db;
        }

        .icon-shield {
            background-color: rgba(230, 126, 34, 0.1);
            color: #e67e22;
        }

        .feature-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .feature-text {
            color: var(--light-text);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .story-card {
            background-color: var(--white);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .story-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .story-text {
            font-style: italic;
            color: var(--text-color);
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .story-author {
            font-weight: 600;
            color: var(--primary-color);
        }

        .story-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        .story-reactions {
            display: flex;
            align-items: center;
        }

        .reaction-icon {
            color: var(--primary-color);
            margin-right: 5px;
        }

        .testimonial-section {
            background-color: var(--secondary-color);
            padding: 80px 0;
            position: relative;
        }

        .testimonial-card {
            background-color: var(--white);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .testimonial-quote {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .testimonial-author {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .testimonial-role {
            color: var(--light-text);
            font-size: 0.9rem;
        }

        .cta-section {
            background-color: var(--primary-color);
            padding: 80px 0;
            color: var(--white);
            text-align: center;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .cta-text {
            font-size: 1.1rem;
            margin-bottom: 30px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-white {
            background-color: var(--white);
            color: var(--primary-color);
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-right: 15px;
        }

        .btn-white:hover {
            background-color: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-white {
            color: var(--white);
            border: 2px solid var(--white);
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-white:hover {
            background-color: var(--white);
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .footer {
            background-color: #f8f9fa;
            padding: 60px 0 30px;
        }

        .footer-logo {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 15px;
            display: inline-block;
        }

        .footer-description {
            color: var(--light-text);
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .footer-heading {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--text-color);
        }

        .footer-links {
            list-style: none;
            padding-left: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: var(--light-text);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary-color);
            text-decoration: none;
            padding-left: 5px;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #e9ecef;
            margin-top: 30px;
            color: var(--light-text);
            font-size: 0.9rem;
        }

        @media (max-width: 991.98px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .cta-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 767.98px) {
            .hero-section {
                padding: 70px 0;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .cta-title {
                font-size: 1.8rem;
            }

            .cta-text {
                font-size: 1rem;
            }

            .btn-white, .btn-outline-white {
                display: block;
                width: 100%;
                margin-bottom: 15px;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <span class="text-primary font-bold text-xl">Jigeen</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/home">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Comment ça marche</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Témoignages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    @php
                        $is_logged_in = isset($_COOKIE['is_logged_in']) && $_COOKIE['is_logged_in'] === 'true';
                        $user_name = $_COOKIE['user_name'] ?? '';
                    @endphp

                    @if($is_logged_in)
                        <li class="nav-item">
                            <span class="nav-link">Bienvenue {{ $user_name }} !</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/direct-login.php?logout=1">Déconnexion</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-outline-primary ms-lg-3" href="/direct-login.php">Se connecter</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="btn btn-primary ms-lg-3" href="/direct-register.php">S'inscrire</a>
                    </li>
                </div>
            </div>
        </div>
    </nav>

    <!-- Messages Flash -->
    @if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif



    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title">
                        <span>Partagez</span> votre histoire,<br>
                        <span>Recevez</span> du soutien
                    </h1>
                    <p class="hero-subtitle">
                        Un espace sécurisé pour les femmes victimes de violences, où vous pouvez partager votre expérience, recevoir du soutien et vous connecter avec des ONG prêtes à vous aider.
                    </p>
                    <div class="d-flex flex-wrap">
                        <a href="#" class="btn btn-primary me-3 mb-3 mb-md-0">Rejoindre la communauté</a>
                        <a href="#" class="btn btn-outline-primary">Besoin d'aide immédiate?</a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="{{ asset('images/hero-image.svg') }}" alt="Femmes solidaires" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Stories Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
            <div class="col-lg-6 mt-5 mt-lg-0">
                    <img src="{{ asset('images/sharing.svg') }}" alt="Partage d'expériences" class="img-fluid">
                </div>
                <div class="col-lg-6">

                    <h2 class="mb-4">Histoires de courage récentes</h2>

                    <div class="story-card">
                        <p class="story-text">"J'ai trouvé la force de parler après des années de silence..."</p>
                        <div class="story-meta">
                            <span class="story-author">Histoire #1</span>
                            <div class="story-reactions">
                                <i class="fas fa-heart reaction-icon"></i> 42
                                <i class="fas fa-comment ms-3 reaction-icon"></i> 7
                            </div>
                        </div>
                    </div>

                    <div class="story-card">
                        <p class="story-text">"J'ai trouvé la force de parler après des années de silence..."</p>
                        <div class="story-meta">
                            <span class="story-author">Histoire #2</span>
                            <div class="story-reactions">
                                <i class="fas fa-heart reaction-icon"></i> 42
                                <i class="fas fa-comment ms-3 reaction-icon"></i> 7
                            </div>
                        </div>
                    </div>

                    <div class="story-card">
                        <p class="story-text">"J'ai trouvé la force de parler après des années de silence..."</p>
                        <div class="story-meta">
                            <span class="story-author">Histoire #3</span>
                            <div class="story-reactions">
                                <i class="fas fa-heart reaction-icon"></i> 42
                                <i class="fas fa-comment ms-3 reaction-icon"></i> 7
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="#" class="btn btn-outline-primary">Voir plus d'histoires</a>
                    </div>
                </div>


            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3">Comment ça fonctionne</h2>
                <p class="text-muted">Notre plateforme est construite pour vous offrir un espace sûr et sécurisé, où vous pouvez partager et recevoir du soutien.</p>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                    <div class="feature-card text-center">
                        <div class="feature-icon icon-heart mx-auto">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3 class="feature-title">Recevoir du soutien</h3>
                        <p class="feature-text">Une communauté bienveillante prête à vous écouter et vous encourager.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                    <div class="feature-card text-center">
                        <div class="feature-icon icon-chat mx-auto">
                            <i class="fas fa-comment"></i>
                        </div>
                        <h3 class="feature-title">Partager son histoire</h3>
                        <p class="feature-text">Un espace sûr pour raconter votre expérience et briser le silence.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                    <div class="feature-card text-center">
                        <div class="feature-icon icon-heart mx-auto">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3 class="feature-title">Recevoir du soutien</h3>
                        <p class="feature-text">Une communauté bienveillante prête à vous écouter et vous encourager.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4 mb-md-0">
                    <div class="feature-card text-center">
                        <div class="feature-icon icon-users mx-auto">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h3 class="feature-title">Connexion avec des ONG</h3>
                        <p class="feature-text">Accès direct à des organisations spécialisées prêtes à vous aider.</p>
                    </div>
                </div>


            </div>

            <div class="text-center mt-5">
                <a href="#" class="btn btn-primary">En savoir plus sur notre mission</a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonial-section mb-0 pb-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3">Témoignages</h2>
                <p class="text-muted">Découvrez comment notre plateforme a aidé d'autres femmes à retrouver espoir et soutien.</p>
            </div>

            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text">Grâce à cette plateforme, j'ai pu partager mon histoire et trouver du soutien auprès d'autres personnes qui ont vécu des expériences similaires. Je me sens moins seule dans mon parcours.</p>
                        <h4 class="testimonial-author">Marie, 34 ans</h4>
                    </div>
                </div>

                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text">Après des années de silence, j'ai enfin trouvé un espace sûr pour exprimer ce que j'ai vécu. Les ONG partenaires m'ont fourni l'aide dont j'avais besoin pour reconstruire ma vie.</p>
                        <h4 class="testimonial-author">Sophie, 27 ans</h4>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text">En tant que représentante d'une ONG, cette plateforme nous a permis d'aider plus de femmes et d'intervenir plus rapidement. Un outil indispensable pour notre travail.</p>
                        <h4 class="testimonial-author">Laure, Coordinatrice ONG</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="partners-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3">Nos Partenaires</h2>
                <p class="text-muted">Ils nous font confiance et nous soutiennent dans notre mission.</p>
            </div>

            <div class="position-relative">
                <!-- Prev Button -->
                <div class="swiper-button-prev custom-swiper-button-prev">
                    <i class="fas fa-chevron-left"></i>
                </div>

                <!-- Next Button -->
                <div class="swiper-button-next custom-swiper-button-next">
                    <i class="fas fa-chevron-right"></i>
                </div>

                <!-- Swiper -->
                <div class="swiper partners-swiper">
                    <div class="swiper-wrapper">
                        <!-- Partner 1 -->
                        <div class="swiper-slide">
                            <div class="partner-item">
                                <img src="{{ asset('images/partners/unicef.svg') }}" alt="UNICEF" class="img-fluid">
                            </div>
                        </div>

                        <!-- Partner 2 -->
                        <div class="swiper-slide">
                            <div class="partner-item">
                                <img src="{{ asset('images/partners/onu.svg') }}" alt="ONU" class="img-fluid">
                            </div>
                        </div>

                        <!-- Partner 3 -->
                        <div class="swiper-slide">
                            <div class="partner-item">
                                <img src="{{ asset('images/partners/unesco.svg') }}" alt="UNESCO" class="img-fluid">
                            </div>
                        </div>

                        <!-- Partner 4 -->
                        <div class="swiper-slide">
                            <div class="partner-item">
                                <img src="{{ asset('images/partners/oms.svg') }}" alt="OMS" class="img-fluid">
                            </div>
                        </div>

                        <!-- Partner 5 -->
                        <div class="swiper-slide">
                            <div class="partner-item">
                                <img src="{{ asset('images/partners/unfpa.svg') }}" alt="UNFPA" class="img-fluid">
                            </div>
                        </div>

                        <!-- Partner 6 -->
                        <div class="swiper-slide">
                            <div class="partner-item">
                                <img src="{{ asset('images/partners/unwomen.svg') }}" alt="UN Women" class="img-fluid">
                            </div>
                        </div>

                        <!-- Partner 7 -->
                        <div class="swiper-slide">
                            <div class="partner-item">
                                <img src="{{ asset('images/partners/amnesty.svg') }}" alt="Amnesty International" class="img-fluid">
                            </div>
                        </div>

                        <!-- Partner 8 -->
                        <div class="swiper-slide">
                            <div class="partner-item">
                                <img src="{{ asset('images/partners/croixrouge.svg') }}" alt="Croix Rouge" class="img-fluid">
                            </div>
                        </div>

                        <!-- Partner 9 -->
                        <div class="swiper-slide">
                            <div class="partner-item">
                                <img src="{{ asset('images/partners/msf.svg') }}" alt="Médecins Sans Frontières" class="img-fluid">
                            </div>
                        </div>

                        <!-- Partner 10 -->
                        <div class="swiper-slide">
                            <div class="partner-item">
                                <img src="{{ asset('images/partners/care.svg') }}" alt="CARE International" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .partners-section {
                background-color: var(--white);
                padding: 80px 0;
            }

            .partner-item {
                height: 220px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 20px;
                margin: 20px;
                background-color: #fff;
                border-radius: 15px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.08);
                transition: all 0.3s ease;
            }

            .partner-item img {
                height: 140px;
                width: auto;
                max-width: 100%;
                margin-bottom: 20px;
                filter: none;
                opacity: 1;
                transition: all 0.3s ease;
            }

            .partner-item:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            }

            .partner-item:hover img {
                transform: scale(1.1);
            }

            .custom-swiper-button-prev,
            .custom-swiper-button-next {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                width: 40px;
                height: 40px;
                background-color: var(--white);
                border-radius: 50%;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                z-index: 10;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--primary-color);
                transition: all 0.3s ease;
            }

            .custom-swiper-button-prev {
                left: -20px;
            }

            .custom-swiper-button-next {
                right: -20px;
            }

            .custom-swiper-button-prev:hover,
            .custom-swiper-button-next:hover {
                background-color: var(--primary-color);
                color: var(--white);
            }

            @media (max-width: 768px) {
                .custom-swiper-button-prev {
                    left: 0;
                }

                .custom-swiper-button-next {
                    right: 0;
                }
            }
        </style>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">Prête à partager votre histoire?</h2>
            <p class="cta-text">Rejoignez notre communauté et découvrez le pouvoir du partage et du soutien.</p>
            <div>
                <a href="#" class="btn btn-white">Créer un compte</a>
                <a href="{{ route('communaute.index') }}" class="btn btn-outline-white">Rejoindre la communauté</a>
                <a href="#" class="btn btn-outline-white">En savoir plus</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <a href="#" class="footer-logo">
                        <i class="fas fa-heart"></i> Jigeen
                    </a>
                    <p class="footer-description">Une plateforme sécurisée pour partager, soutenir et connecter les femmes victimes de violence.</p>
                </div>

                <div class="col-md-4 col-lg-2 mb-4 mb-md-0">
                    <h4 class="footer-heading">Navigation</h4>
                    <ul class="footer-links">
                        <li><a href="#">Accueil</a></li>
                        <li><a href="#">Histoires</a></li>
                        <li><a href="{{ route('resources.index') }}">Ressources</a></li>
                        <li><a href="{{ route('communaute.index') }}">Communauté</a></li>
                        <li><a href="#">ONG Partenaires</a></li>
                    </ul>
                </div>

                <div class="col-md-4 col-lg-2 mb-4 mb-md-0">
                    <h4 class="footer-heading">Aide</h4>
                    <ul class="footer-links">
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Support</a></li>
                        <li><a href="#">Urgences</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>

                <div class="col-md-4 col-lg-2">
                    <h4 class="footer-heading">Légal</h4>
                    <ul class="footer-links">
                        <li><a href="#">Conditions d'utilisation</a></li>
                        <li><a href="#">Politique de confidentialité</a></li>
                        <li><a href="#">Cookies</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 Courage Echo. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script>
        // Initialize Swiper
        const swiper = new Swiper('.partners-swiper', {
            slidesPerView: 1,
            spaceBetween: 60,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
            },
            breakpoints: {
                // when window width is >= 480px
                480: {
                    slidesPerView: 1,
                },
                // when window width is >= 768px
                768: {
                    slidesPerView: 2,
                },
                // when window width is >= 992px
                992: {
                    slidesPerView: 3,
                },
                // when window width is >= 1200px
                1200: {
                    slidesPerView: 4,
                }
            }
        });
    </script>
</body>
</html>
