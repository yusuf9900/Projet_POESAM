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
    <title>Ressources - Jigeen</title>
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
        
        .category-sidebar {
            background-color: #FFFFFF;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 20px;
            height: fit-content;
            position: sticky;
            top: 100px;
        }
        
        .category-sidebar h5 {
            font-weight: 600;
            margin-bottom: 20px;
            color: #3E4095;
            position: relative;
            padding-bottom: 10px;
        }
        
        .category-sidebar h5::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #3E4095, #5D5DA8);
            border-radius: 3px;
        }
        
        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .category-item {
            margin-bottom: 15px;
        }
        
        .category-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #333333;
            padding: 8px 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .category-link:hover {
            background-color: rgba(62, 64, 149, 0.05);
            color: #3E4095;
            transform: translateX(3px);
        }
        
        .category-link.active {
            background-color: rgba(62, 64, 149, 0.1);
            color: #3E4095;
            font-weight: 500;
        }
        
        .category-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #3E4095, #5D5DA8);
            border-radius: 8px;
            margin-right: 12px;
            color: white;
            font-size: 0.9rem;
        }
        
        .resource-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .resource-title {
            font-weight: 600;
            color: #333333;
            margin: 0;
        }
        
        .btn-add-resource {
            background: linear-gradient(135deg, #3E4095, #5D5DA8);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 500;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 10px rgba(62, 64, 149, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-add-resource i {
            margin-right: 8px;
        }
        
        .btn-add-resource:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(62, 64, 149, 0.4);
            color: white;
        }
        
        .search-form {
            margin-bottom: 25px;
        }
        
        .search-input {
            border-radius: 30px;
            border: 1px solid #E8E8E8;
            padding: 12px 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #3E4095;
            box-shadow: 0 0 0 3px rgba(62, 64, 149, 0.1);
        }
        
        .resource-card {
            background-color: #FFFFFF;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            margin-bottom: 25px;
            position: relative;
            height: 100%;
        }
        
        .resource-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .resource-card-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-bottom: 1px solid #E8E8E8;
        }
        
        .resource-type-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #3E4095, #5D5DA8);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(62, 64, 149, 0.3);
        }
        
        .resource-card-body {
            padding: 20px;
        }
        
        .resource-card-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #333333;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            height: 50px;
        }
        
        .resource-card-description {
            color: #555555;
            font-size: 0.9rem;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 60px;
        }
        
        .resource-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-top: 1px solid #F1F1F1;
            background-color: #FAFAFA;
        }
        
        .resource-card-meta {
            display: flex;
            align-items: center;
            color: #788AA3;
            font-size: 0.8rem;
        }
        
        .resource-card-meta i {
            margin-right: 5px;
        }
        
        .resource-card-meta span {
            margin-right: 15px;
        }
        
        .resource-card-action {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-view {
            color: #3E4095;
            background-color: rgba(62, 64, 149, 0.1);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .btn-view:hover {
            background-color: #3E4095;
            color: white;
            transform: scale(1.1);
        }
        
        .btn-download {
            color: #FFA41B;
            background-color: rgba(255, 164, 27, 0.1);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .btn-download:hover {
            background-color: #FFA41B;
            color: white;
            transform: scale(1.1);
        }
        
        .empty-resources {
            text-align: center;
            padding: 50px 20px;
            background-color: #FFFFFF;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
        }
        
        .empty-resources i {
            font-size: 3rem;
            color: #E0E0E0;
            margin-bottom: 20px;
        }
        
        .empty-resources h4 {
            color: #555555;
            margin-bottom: 10px;
        }
        
        .empty-resources p {
            color: #788AA3;
            margin-bottom: 25px;
        }
        
        .pagination {
            margin-top: 30px;
            justify-content: center;
        }
        
        .page-link {
            color: #3E4095;
            border-radius: 5px;
            margin: 0 3px;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .page-link:hover {
            background-color: rgba(62, 64, 149, 0.05);
            color: #3E4095;
        }
        
        .page-item.active .page-link {
            background-color: #3E4095;
            border-color: #3E4095;
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
    
    <!-- Resource Section -->
    <div class="container resource-container">
        <div class="row">
            <!-- Sidebar with Categories -->
            <div class="col-lg-3 mb-4">
                <div class="categories-container">
                    <h4>Types de ressources</h4>
                    <ul class="categories-list">
                        <li class="{{ !isset($type) && !isset($query) ? 'active' : '' }}">
                            <a href="{{ route('resources.index') }}">
                                <i class="fas fa-folder"></i>
                                Toutes les ressources
                            </a>
                        </li>
                        @foreach($types as $typeItem)
                        <li class="{{ isset($type) && $type == $typeItem->type_ressource ? 'active' : '' }}">
                            <a href="{{ route('resources.category', $typeItem->type_ressource) }}">
                                <i class="fas fa-folder"></i>
                                {{ $typeItem->type_ressource }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="resource-header">
                    <h3 class="resource-title">
                        @if(isset($type))
                            Ressources de type "{{ $type }}"
                        @elseif(isset($query))
                            Résultats pour "{{ $query }}"
                        @else
                            Toutes les ressources
                        @endif
                    </h3>
                    @php
                        $user = \App\Models\User::find(session('user_id'));
                    @endphp
                    @if($user)
                        <a href="{{ route('resources.create') }}" class="btn btn-add-resource">
                            <i class="fas fa-plus"></i> Ajouter une ressource
                        </a>
                    @endif
                </div>
                
                <!-- Search Form -->
                <form action="{{ route('resources.search') }}" method="GET" class="search-form">
                    <div class="input-group">
                        <input type="text" class="search-input" name="q" placeholder="Rechercher des ressources..." value="{{ $query ?? '' }}">
                        <button type="submit" class="btn" style="display: none;"></button>
                    </div>
                </form>
                
                @if($resources->count() > 0)
                    <div class="row">
                        @foreach($resources as $resource)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="resource-card">
                                    @if($resource->thumbnail)
                                        <img src="{{ asset('storage/' . $resource->thumbnail) }}" alt="{{ $resource->title }}" class="resource-card-img">
                                    @elseif($resource->type_ressource == 'document')
                                        <div class="resource-card-img d-flex align-items-center justify-content-center bg-light">
                                            <i class="fas fa-file-pdf fa-3x text-muted"></i>
                                        </div>
                                    @elseif($resource->type_ressource == 'link')
                                        <div class="resource-card-img d-flex align-items-center justify-content-center bg-light">
                                            <i class="fas fa-link fa-3x text-muted"></i>
                                        </div>
                                    @else
                                        <div class="resource-card-img d-flex align-items-center justify-content-center bg-light">
                                            <i class="fas fa-file fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    
                                    <span class="resource-type-badge">
                                        @if($resource->type_ressource == 'document')
                                            <i class="fas fa-file-pdf me-1"></i> Document
                                        @elseif($resource->type_ressource == 'link')
                                            <i class="fas fa-link me-1"></i> Lien
                                        @elseif($resource->type_ressource == 'video')
                                            <i class="fas fa-video me-1"></i> Vidéo
                                        @elseif($resource->type_ressource == 'image')
                                            <i class="fas fa-image me-1"></i> Image
                                        @else
                                            <i class="fas fa-file me-1"></i> Fichier
                                        @endif
                                    </span>
                                    
                                    <div class="resource-card-body">
                                        <h5 class="resource-card-title">{{ $resource->title }}</h5>
                                        <p class="resource-card-description">{{ Str::limit($resource->description, 100) }}</p>
                                    </div>
                                    
                                    <div class="resource-card-footer">
                                        <div class="resource-card-meta">
                                            <i class="fas fa-eye"></i>
                                            <span>{{ $resource->views }}</span>
                                            <i class="fas fa-download"></i>
                                            <span>{{ $resource->downloads }}</span>
                                        </div>
                                        <div class="resource-card-action">
                                            <a href="{{ route('resources.show', $resource->id) }}" class="btn btn-view" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($resource->file_path)
                                            <a href="{{ route('resources.download', $resource->id) }}" class="btn btn-download" title="Télécharger">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $resources->links() }}
                    </div>
                @else
                    <div class="empty-resources">
                        <i class="fas fa-search"></i>
                        <h4>Aucune ressource trouvée</h4>
                        <p>Il n'y a pas encore de ressources dans cette catégorie.</p>
                        @php
                            $user = \App\Models\User::find(session('user_id'));
                        @endphp
                        @if($user)
                            <a href="{{ route('resources.create') }}" class="btn btn-add-resource">
                                <i class="fas fa-plus"></i> Ajouter une ressource
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
