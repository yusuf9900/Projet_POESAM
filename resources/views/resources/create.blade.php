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
    <title>Ajouter une ressource - Jigeen</title>
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
        
        .resource-form {
            background-color: #FFFFFF;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }
        
        .form-title {
            font-weight: 700;
            color: #333333;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .form-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #3E4095, #5D5DA8);
            border-radius: 3px;
        }
        
        .form-label {
            font-weight: 500;
            color: #555555;
            margin-bottom: 8px;
        }
        
        .form-control {
            border: 1px solid #E8E8E8;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #333333;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03) inset;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #3E4095;
            box-shadow: 0 0 0 3px rgba(62, 64, 149, 0.1), 0 2px 8px rgba(0, 0, 0, 0.03) inset;
            outline: none;
        }
        
        .form-select {
            border: 1px solid #E8E8E8;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #333333;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03) inset;
            transition: all 0.3s ease;
            height: auto;
        }
        
        .form-select:focus {
            border-color: #3E4095;
            box-shadow: 0 0 0 3px rgba(62, 64, 149, 0.1), 0 2px 8px rgba(0, 0, 0, 0.03) inset;
            outline: none;
        }
        
        .resource-type-options {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }
        
        .resource-type-option {
            position: relative;
            flex: 1;
            min-width: 120px;
        }
        
        .resource-type-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .resource-type-option label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 15px;
            border: 1px solid #E8E8E8;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .resource-type-option input[type="radio"]:checked + label {
            border-color: #3E4095;
            background-color: rgba(62, 64, 149, 0.05);
            box-shadow: 0 3px 10px rgba(62, 64, 149, 0.1);
            transform: translateY(-3px);
        }
        
        .resource-type-option i {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #3E4095;
        }
        
        .resource-type-option span {
            font-weight: 500;
            color: #333333;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #3E4095, #5D5DA8);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 4px 12px rgba(62, 64, 149, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-submit i {
            margin-right: 10px;
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(62, 64, 149, 0.4);
        }
        
        .alert-validation {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 5px;
        }
        
        .dynamic-fields {
            margin-top: 20px;
        }
        
        .file-upload {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            border: 2px dashed #E8E8E8;
            border-radius: 10px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-bottom: 15px;
        }
        
        .file-upload:hover {
            border-color: #3E4095;
            background-color: rgba(62, 64, 149, 0.02);
        }
        
        .file-upload i {
            font-size: 3rem;
            color: #3E4095;
            margin-bottom: 10px;
        }
        
        .file-upload h5 {
            color: #333333;
            margin-bottom: 10px;
        }
        
        .file-upload p {
            color: #788AA3;
            font-size: 0.9rem;
            margin-bottom: 0;
        }
        
        .file-upload input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        
        .file-preview {
            display: none;
            padding: 15px;
            margin-top: 15px;
            border: 1px solid #E8E8E8;
            border-radius: 10px;
            background-color: #FAFAFA;
        }
        
        .file-preview-content {
            display: flex;
            align-items: center;
        }
        
        .file-preview-icon {
            font-size: 2rem;
            color: #3E4095;
            margin-right: 15px;
        }
        
        .file-preview-info {
            flex-grow: 1;
        }
        
        .file-preview-name {
            font-weight: 500;
            color: #333333;
            margin-bottom: 3px;
        }
        
        .file-preview-size {
            color: #788AA3;
            font-size: 0.85rem;
        }
        
        .file-preview-remove {
            color: #dc3545;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-preview-remove:hover {
            transform: scale(1.1);
        }
        
        .url-preview {
            margin-top: 15px;
            padding: 15px;
            border: 1px solid #E8E8E8;
            border-radius: 10px;
            background-color: #FAFAFA;
        }
        
        .url-preview-title {
            font-weight: 500;
            color: #333333;
            margin-bottom: 5px;
        }
        
        .url-preview-content {
            display: flex;
            align-items: center;
        }
        
        .url-preview-icon {
            font-size: 1.5rem;
            color: #3E4095;
            margin-right: 15px;
        }
        
        .url-preview-link {
            color: #3E4095;
            text-decoration: none;
            transition: all 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 300px;
        }
        
        .url-preview-link:hover {
            text-decoration: underline;
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
    
    <!-- Resource Create Form Section -->
    <div class="container resource-container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('resources.index') }}">Ressources</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ajouter une ressource</li>
            </ol>
        </nav>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Resource Form -->
                <div class="resource-form">
                    <h2 class="form-title">Ajouter une nouvelle ressource</h2>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <h2>Ajouter une nouvelle ressource</h2>
                    
                    <form action="{{ route('resources.store') }}" method="post">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="titre">Titre de la ressource *</label>
                            <input type="text" name="titre" id="titre" class="form-control @error('titre') is-invalid @enderror" value="{{ old('titre') }}" required maxlength="50">
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="description">Description *</label>
                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="contenu">Contenu *</label>
                            <textarea name="contenu" id="contenu" rows="6" class="form-control @error('contenu') is-invalid @enderror" required>{{ old('contenu') }}</textarea>
                            @error('contenu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="type_ressource">Type de ressource *</label>
                            <input type="text" name="type_ressource" id="type_ressource" class="form-control @error('type_ressource') is-invalid @enderror" value="{{ old('type_ressource') }}" required maxlength="50">
                            @error('type_ressource')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Exemple: Document, Vidéo, Article, Guide, etc.</small>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="lien">Lien de la ressource *</label>
                            <input type="url" name="lien" id="lien" class="form-control @error('lien') is-invalid @enderror" value="{{ old('lien') }}" required maxlength="100">
                            @error('lien')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Lien vers la ressource (site web, document en ligne, vidéo, etc.)</small>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="organisation_id">Organisation *</label>
                            <select name="organisation_id" id="organisation_id" class="form-control @error('organisation_id') is-invalid @enderror" required>
                                <option value="">Sélectionner une organisation</option>
                                @foreach($organisations as $organisation)
                                    <option value="{{ $organisation->id }}" {{ old('organisation_id') == $organisation->id ? 'selected' : '' }}>{{ $organisation->name }}</option>
                                @endforeach
                            </select>
                            @error('organisation_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="dynamic-fields">
                            <!-- File upload fields (document, image) -->
                            <div id="file-fields" class="mb-4">
                                <label class="form-label">Fichier <span class="text-danger">*</span></label>
                                <div class="file-upload" id="file-upload-area">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <h5>Déposez votre fichier ici</h5>
                                    <p>ou cliquez pour parcourir vos fichiers</p>
                                    <input type="file" id="resource_file" name="resource_file">
                                </div>
                                
                                <div class="file-preview" id="file-preview">
                                    <div class="file-preview-content">
                                        <i class="file-preview-icon fas fa-file"></i>
                                        <div class="file-preview-info">
                                            <div class="file-preview-name"></div>
                                            <div class="file-preview-size"></div>
                                        </div>
                                        <i class="file-preview-remove fas fa-times"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Enregistrer la ressource
                            </button>
                            <a href="{{ route('resources.index') }}" class="btn btn-secondary btn-lg ms-2">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap & jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Handle resource type change
            $('input[name="type"]').on('change', function() {
                const type = $(this).val();
                
                if (type === 'document' || type === 'image') {
                    $('#file-fields').show();
                    $('#url-fields').hide();
                } else if (type === 'link' || type === 'video') {
                    $('#file-fields').hide();
                    $('#url-fields').show();
                }
            });
            
            // Handle file upload
            $('#resource_file').on('change', function(e) {
                const file = e.target.files[0];
                
                if (file) {
                    // Update preview
                    $('.file-preview-name').text(file.name);
                    $('.file-preview-size').text(formatFileSize(file.size));
                    
                    // Show preview
                    $('#file-preview').show();
                    
                    // Update icon based on file type
                    const fileType = file.type;
                    let iconClass = 'fas fa-file';
                    
                    if (fileType.includes('pdf')) {
                        iconClass = 'fas fa-file-pdf';
                    } else if (fileType.includes('image')) {
                        iconClass = 'fas fa-file-image';
                    } else if (fileType.includes('word')) {
                        iconClass = 'fas fa-file-word';
                    } else if (fileType.includes('excel') || fileType.includes('sheet')) {
                        iconClass = 'fas fa-file-excel';
                    } else if (fileType.includes('powerpoint') || fileType.includes('presentation')) {
                        iconClass = 'fas fa-file-powerpoint';
                    } else if (fileType.includes('zip') || fileType.includes('rar') || fileType.includes('archive')) {
                        iconClass = 'fas fa-file-archive';
                    }
                    
                    $('.file-preview-icon').attr('class', `file-preview-icon ${iconClass}`);
                }
            });
            
            // Clear file
            $('.file-preview-remove').on('click', function() {
                $('#resource_file').val('');
                $('#file-preview').hide();
            });
            
            // URL preview
            $('#resource_url').on('input', function() {
                const url = $(this).val();
                
                if (url && isValidURL(url)) {
                    $('#url-preview-link').text(url);
                    $('#url-preview-link').attr('href', url);
                    $('#url-preview').show();
                    
                    // Check if YouTube or Video
                    if (url.includes('youtube.com') || url.includes('youtu.be')) {
                        $('.url-preview-icon').attr('class', 'url-preview-icon fab fa-youtube');
                    } else if (url.includes('vimeo.com')) {
                        $('.url-preview-icon').attr('class', 'url-preview-icon fab fa-vimeo');
                    } else {
                        $('.url-preview-icon').attr('class', 'url-preview-icon fas fa-link');
                    }
                } else {
                    $('#url-preview').hide();
                }
            });
            
            // Format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
            
            // Validate URL
            function isValidURL(string) {
                try {
                    new URL(string);
                    return true;
                } catch (_) {
                    return false;
                }
            }
        });
    </script>
</body>
</html>
