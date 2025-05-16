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
    <title>{{ $resource->title }} - Jigeen</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Couleurs principales */
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
        
        .resource-container {
            padding: 30px 0;
        }
        
        .breadcrumb {
            margin-bottom: 25px;
            padding: 12px 20px;
            background-color: #FFFFFF;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .breadcrumb-item a {
            color: #788AA3;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .breadcrumb-item a:hover {
            color: #3E4095;
        }
        
        .breadcrumb-item.active {
            color: #3E4095;
            font-weight: 500;
        }
        
        .resource-header {
            background-color: #FFFFFF;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }
        
        .resource-title {
            font-weight: 700;
            color: #333333;
            margin-bottom: 5px;
        }
        
        .resource-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
            color: #788AA3;
            font-size: 0.9rem;
        }
        
        .resource-meta-item {
            display: flex;
            align-items: center;
        }
        
        .resource-meta-item i {
            margin-right: 5px;
        }
        
        .resource-type-badge {
            display: inline-block;
            background: linear-gradient(135deg, #3E4095, #5D5DA8);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-right: 10px;
        }
        
        .resource-categories {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }
        
        .category-badge {
            background-color: rgba(62, 64, 149, 0.1);
            color: #3E4095;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .category-badge i {
            margin-right: 5px;
        }
        
        .category-badge:hover {
            background-color: #3E4095;
            color: white;
            text-decoration: none;
        }
        
        .resource-actions {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }
        
        .btn-action {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn-view {
            background: linear-gradient(135deg, #3E4095, #5D5DA8);
            color: white;
            box-shadow: 0 4px 10px rgba(62, 64, 149, 0.3);
        }
        
        .btn-view:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(62, 64, 149, 0.4);
            color: white;
        }
        
        .btn-download {
            background: linear-gradient(135deg, #FFA41B, #FF8A00);
            color: white;
            box-shadow: 0 4px 10px rgba(255, 164, 27, 0.3);
        }
        
        .btn-download:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(255, 164, 27, 0.4);
            color: white;
        }
        
        .btn-action i {
            margin-right: 10px;
        }
        
        .resource-content {
            background-color: #FFFFFF;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }
        
        .resource-description {
            color: #333333;
            line-height: 1.7;
            margin-bottom: 25px;
        }
        
        .resource-preview {
            margin-top: 25px;
        }
        
        .resource-image {
            width: 100%;
            max-height: 500px;
            object-fit: contain;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .resource-document {
            padding: 50px;
            background-color: #F5F5F5;
            border-radius: 10px;
            text-align: center;
        }
        
        .resource-document i {
            font-size: 5rem;
            color: #3E4095;
            margin-bottom: 15px;
        }
        
        .resource-document p {
            font-size: 1.1rem;
            color: #555555;
            margin-bottom: 25px;
        }
        
        .resource-video {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 */
            height: 0;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }
        
        .resource-video iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
        
        .resource-user {
            display: flex;
            align-items: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #E8E8E8;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3E4095, #5D5DA8);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 15px;
            box-shadow: 0 3px 8px rgba(62, 64, 149, 0.25);
            border: 2px solid rgba(255, 255, 255, 0.9);
        }
        
        .user-info h5 {
            font-weight: 600;
            margin-bottom: 3px;
            color: #333333;
        }
        
        .user-info p {
            color: #788AA3;
            font-size: 0.9rem;
            margin: 0;
        }
        
        .related-resources {
            background-color: #FFFFFF;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        
        .related-title {
            font-weight: 600;
            margin-bottom: 20px;
            color: #3E4095;
            position: relative;
            padding-bottom: 10px;
        }
        
        .related-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #3E4095, #5D5DA8);
            border-radius: 3px;
        }
        
        .related-card {
            display: flex;
            background-color: #FFFFFF;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            margin-bottom: 15px;
            text-decoration: none;
            color: inherit;
        }
        
        .related-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            color: inherit;
        }
        
        .related-card-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            flex-shrink: 0;
        }
        
        .related-card-body {
            padding: 15px;
            flex-grow: 1;
        }
        
        .related-card-title {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 5px;
            color: #333333;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .related-card-meta {
            display: flex;
            color: #788AA3;
            font-size: 0.8rem;
        }
        
        .related-card-meta span {
            margin-right: 10px;
            display: flex;
            align-items: center;
        }
        
        .related-card-meta i {
            margin-right: 3px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('resources.index') }}">Ressources</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('messages.index') }}">Messages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile') }}">Profil</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Resource Detail Section -->
    <div class="container resource-container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('resources.index') }}">Ressources</a></li>
                @if($resource->categories->count() > 0)
                    <li class="breadcrumb-item"><a href="{{ route('resources.category', $resource->categories->first()->id) }}">{{ $resource->categories->first()->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $resource->title }}</li>
            </ol>
        </nav>
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Resource Header -->
                <div class="resource-header">
                    <h2 class="resource-title">{{ $resource->titre }}</h2>
                    
                    <div class="resource-meta">
                        <div class="resource-meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $resource->created_at->format('d M Y') }}
                        </div>
                        <div class="resource-meta-item">
                            <i class="fas fa-eye"></i>
                            {{ $resource->views }} vues
                        </div>
                        <div class="resource-meta-item">
                            <i class="fas fa-download"></i>
                            {{ $resource->downloads }} téléchargements
                        </div>
                    </div>
                    
                    <div>
                        <span class="resource-type-badge">
                            @if($resource->type == 'document')
                                <i class="fas fa-file-pdf me-1"></i> Document
                            @elseif($resource->type == 'link')
                                <i class="fas fa-link me-1"></i> Lien
                            @elseif($resource->type == 'video')
                                <i class="fas fa-video me-1"></i> Vidéo
                            @elseif($resource->type == 'image')
                                <i class="fas fa-image me-1"></i> Image
                            @else
                                <i class="fas fa-file me-1"></i> Fichier
                            @endif
                        </span>
                        
                        @if($resource->categories->count() > 0)
                            <div class="resource-categories">
                                @foreach($resource->categories as $category)
                                    <a href="{{ route('resources.category', $category->id) }}" class="category-badge">
                                        <i class="{{ $category->icon ?? 'fas fa-folder' }}"></i>
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <div class="resource-actions">
                        @if($resource->type == 'link' || $resource->type == 'video')
                            <a href="{{ $resource->resource_url }}" target="_blank" class="btn-action btn-view">
                                <i class="fas fa-external-link-alt"></i> Voir
                            </a>
                        @endif
                        
                        @if($resource->file_path)
                            <a href="{{ route('resources.download', $resource->id) }}" class="btn-action btn-download">
                                <i class="fas fa-download"></i> Télécharger
                            </a>
                        @endif
                    </div>
                </div>
                
                <!-- Resource Content -->
                <div class="resource-content">
                    @if($resource->description)
                        <div class="resource-description">
                            <h4>Description</h4>
                            <div class="description-content">
                                {{ $resource->description }}
                            </div>
                        </div>
                    @endif
                    
                    <div class="resource-content">
                        <h4>Contenu</h4>
                        <div class="content-details">
                            {{ $resource->contenu }}
                        </div>
                    </div>
                    
                    <div class="resource-preview">
                        @if($resource->type == 'image' && $resource->file_path)
                            <img src="{{ asset('storage/' . $resource->file_path) }}" alt="{{ $resource->titre }}" class="resource-image">
                        @elseif($resource->type == 'document' && $resource->file_path)
                            <div class="resource-document">
                                <i class="fas fa-file-pdf"></i>
                                <p>{{ pathinfo($resource->file_path, PATHINFO_EXTENSION) }} - Document</p>
                                <a href="{{ route('resources.download', $resource->id) }}" class="btn-action btn-download">
                                    <i class="fas fa-download"></i> Télécharger
                                </a>
                            </div>
                        @elseif($resource->type == 'video' && $resource->resource_url)
                            <div class="resource-video">
                                @php
                                    // Extract YouTube ID
                                    $youtubeId = null;
                                    if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $resource->resource_url, $matches)) {
                                        $youtubeId = $matches[1];
                                    }
                                @endphp
                                
                                @if($youtubeId)
                                    <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        La vidéo n'est pas disponible en prévisualisation. Cliquez sur le bouton "Voir" pour accéder au contenu.
                                    </div>
                                @endif
                            </div>
                        @elseif($resource->type == 'link')
                            <div class="link-preview">
                                <a href="{{ $resource->lien }}" target="_blank" class="btn btn-primary">
                                    <i class="fas fa-external-link-alt"></i> Accéder au lien
                                </a>
                            </div>
                        @endif
                    </div>
                    
                    <!-- User Info -->
                    <div class="resource-user">
                        <div class="user-avatar">
                            {{ substr($resource->user->name, 0, 1) }}
                        </div>
                        <div class="user-info">
                            <h5>{{ $resource->user->name }}</h5>
                            <p>Membre depuis {{ $resource->user->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Related Resources -->
                @if($similarResources->count() > 0)
                    <div class="related-resources">
                        <h5 class="related-title">Ressources similaires</h5>
                        
                        @foreach($similarResources as $similar)
                            <a href="{{ route('resources.show', $similar->id) }}" class="related-card">
                                @if($similar->thumbnail)
                                    <img src="{{ asset('storage/' . $similar->thumbnail) }}" alt="{{ $similar->titre }}" class="related-card-img">
                                @elseif($similar->type == 'document')
                                    <div class="related-card-img d-flex align-items-center justify-content-center bg-light">
                                        <i class="fas fa-file-pdf fa-2x text-muted"></i>
                                    </div>
                                @elseif($similar->type == 'link')
                                    <div class="related-card-img d-flex align-items-center justify-content-center bg-light">
                                        <i class="fas fa-link fa-2x text-muted"></i>
                                    </div>
                                @elseif($similar->type == 'video')
                                    <div class="related-card-img d-flex align-items-center justify-content-center bg-light">
                                        <i class="fas fa-video fa-2x text-muted"></i>
                                    </div>
                                @else
                                    <div class="related-card-img d-flex align-items-center justify-content-center bg-light">
                                        <i class="fas fa-file fa-2x text-muted"></i>
                                    </div>
                                @endif
                                
                                <div class="related-card-body">
                                    <h6 class="related-card-title">{{ $similar->titre }}</h6>
                                    <div class="related-card-meta">
                                        <span><i class="fas fa-eye"></i> {{ $similar->views }}</span>
                                        <span><i class="fas fa-download"></i> {{ $similar->downloads }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
