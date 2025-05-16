@extends('layouts.app')

@section('styles')
<style>
    /* Variables de couleur */
    :root {
        --primary-color: #3E4095; /* Bleu professionnel */
        --primary-rgb: 62, 64, 149; /* Valeur RGB de la couleur primaire */
        --secondary-color: #788AA3; /* Bleu gris élégant */
        --accent-color: #FFA41B; /* Orange doux pour les accents */
        --text-color: #333333; /* Gris foncé - pour le texte principal */
        --light-text: #555555; /* Gris moyen - pour texte secondaire */
        --white: #ffffff;
        --light-bg: #F8F9FA; /* Fond très légèrement gris */
        --border-color: #E8E8E8; /* Gris très clair pour bordures */
        --gradient-start: #3E4095; /* Début du dégradé - bleu professionnel */
        --gradient-end: #5C5EBA; /* Fin du dégradé - bleu plus clair */
    }

    /* Header de la page */
    .create-header {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        padding: 3rem 0;
        margin-bottom: 3rem;
        border-radius: 0 0 50px 50px;
        box-shadow: 0 5px 15px rgba(var(--primary-rgb), 0.1);
        text-align: center;
    }

    .create-header h1 {
        color: white;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .create-header p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        max-width: 700px;
        margin: 0 auto;
    }

    /* Formulaire */
    .form-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 3rem;
    }

    .form-card-header {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end), 0.1);
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .form-card-header h2 {
        margin: 0;
        color: var(--primary-color);
        font-weight: 600;
        font-size: 1.5rem;
    }

    .form-card-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        width: 100%;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(var(--primary-rgb), 0.15);
    }

    textarea.form-control {
        min-height: 150px;
    }

    .form-help {
        color: var(--light-text);
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    .input-group {
        display: flex;
        align-items: center;
    }

    .input-group-text {
        background-color: var(--light-bg);
        border: 1px solid var(--border-color);
        border-right: none;
        border-radius: 8px 0 0 8px;
        padding: 0.75rem 1rem;
        color: var(--light-text);
    }

    .input-group .form-control {
        border-radius: 0 8px 8px 0;
    }

    /* File upload */
    .custom-file {
        position: relative;
        display: block;
        width: 100%;
        height: auto;
    }

    .custom-file-input {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        cursor: pointer;
        opacity: 0;
        z-index: 2;
    }

    .custom-file-label {
        position: relative;
        background-color: white;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-weight: 400;
        color: var(--light-text);
        z-index: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .custom-file-label::after {
        content: "Parcourir";
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        padding: 0.75rem 1rem;
        background-color: var(--light-bg);
        border-left: 1px solid var(--border-color);
        border-radius: 0 8px 8px 0;
    }

    /* Image preview */
    .image-preview {
        max-width: 100%;
        height: 200px;
        background-color: var(--light-bg);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-top: 1rem;
    }

    .image-preview img {
        max-width: 100%;
        max-height: 100%;
    }

    .image-preview-placeholder {
        color: var(--light-text);
        text-align: center;
        padding: 1rem;
    }

    /* Actions */
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-color);
    }

    .btn {
        border-radius: 50px;
        padding: 0.75rem 2rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        border: none;
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(var(--primary-rgb), 0.25);
    }

    .btn-outline-secondary {
        border: 1px solid var(--light-text);
        color: var(--light-text);
        background-color: transparent;
    }

    .btn-outline-secondary:hover {
        background-color: var(--light-text);
        color: white;
        transform: translateY(-3px);
    }

    /* Guidelines */
    .guidelines-card {
        border: none;
        border-radius: 12px;
        background-color: var(--light-bg);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .guidelines-card h3 {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.2rem;
    }

    .guidelines-list {
        list-style-type: none;
        padding-left: 0;
        margin-bottom: 0;
    }

    .guidelines-list li {
        position: relative;
        padding-left: 2rem;
        margin-bottom: 0.75rem;
        color: var(--text-color);
    }

    .guidelines-list li:before {
        content: '\f058';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        left: 0;
        top: 0;
        color: var(--primary-color);
    }

    .guidelines-list li:last-child {
        margin-bottom: 0;
    }

    /* Responsive */
    @media (max-width: 991.98px) {
        .create-header {
            padding: 2rem 0;
            border-radius: 0 0 30px 30px;
        }

        .form-card-body {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column-reverse;
            gap: 1rem;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="create-header">
    <div class="container">
        <h1>Créer un nouvel événement</h1>
        <p>Partagez votre événement avec notre communauté et invitez d'autres membres à y participer</p>
    </div>
</div>

<div class="container">
    <!-- Messages d'erreur ou de succès -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Formulaire de création -->
        <div class="col-lg-8">
            <div class="card form-card">
                <div class="form-card-header">
                    <h2>Informations sur l'événement</h2>
                </div>
                <div class="form-card-body">
                    <form action="{{ route('evenements.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label for="nom" class="form-label">Nom de l'événement *</label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom') }}" required>
                            <small class="form-help">Choisissez un titre court et descriptif</small>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" required>{{ old('description') }}</textarea>
                            <small class="form-help">Décrivez votre événement en détail : objectifs, programme, public cible, etc.</small>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_evenement" class="form-label">Date *</label>
                                    <input type="date" class="form-control @error('date_evenement') is-invalid @enderror" id="date_evenement" name="date_evenement" value="{{ old('date_evenement') }}" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    @error('date_evenement')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="heure_evenement" class="form-label">Heure *</label>
                                    <input type="time" class="form-control @error('heure_evenement') is-invalid @enderror" id="heure_evenement" name="heure_evenement" value="{{ old('heure_evenement') }}" required>
                                    @error('heure_evenement')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="adresse" class="form-label">Adresse *</label>
                            <input type="text" class="form-control @error('adresse') is-invalid @enderror" id="adresse" name="adresse" value="{{ old('adresse') }}" required>
                            <small class="form-help">Précisez l'adresse complète du lieu de l'événement</small>
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="places_disponibles" class="form-label">Nombre de places disponibles *</label>
                            <input type="number" class="form-control @error('places_disponibles') is-invalid @enderror" id="places_disponibles" name="places_disponibles" value="{{ old('places_disponibles', 20) }}" min="1" required>
                            @error('places_disponibles')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="image" class="form-label">Image de l'événement</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                                <label class="custom-file-label" for="image">Choisir une image</label>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-help">Format recommandé : JPEG, PNG ou GIF, max 2MB</small>
                            
                            <div class="image-preview" id="imagePreview">
                                <div class="image-preview-placeholder">
                                    <i class="fas fa-image fa-3x mb-2"></i>
                                    <p>L'aperçu de l'image apparaîtra ici</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <a href="{{ route('evenements.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left mr-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Créer l'événement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Conseils et astuces -->
        <div class="col-lg-4">
            <div class="guidelines-card">
                <h3>Conseils pour créer un événement réussi</h3>
                <ul class="guidelines-list">
                    <li>Choisissez un titre clair et descriptif</li>
                    <li>Détaillez le programme de l'événement</li>
                    <li>Précisez qui peut participer</li>
                    <li>Ajoutez une image attrayante</li>
                    <li>Indiquez l'adresse exacte</li>
                </ul>
            </div>
            
            <div class="guidelines-card">
                <h3>Visibilité et audience</h3>
                <p>Votre événement sera visible pour tous les membres de la communauté. Seuls les utilisateurs connectés pourront s'inscrire pour y participer.</p>
                <p>En tant qu'organisateur, vous pourrez :</p>
                <ul class="guidelines-list">
                    <li>Suivre les inscriptions</li>
                    <li>Modifier les détails de l'événement</li>
                    <li>Contacter les participants</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Fonction pour prévisualiser l'image
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function (e) {
                preview.innerHTML = '<img src="' + e.target.result + '" alt="Aperçu" />';
            };
            
            reader.readAsDataURL(input.files[0]);
            
            // Mise à jour du nom du fichier
            const fileName = input.files[0].name;
            const label = input.nextElementSibling;
            label.textContent = fileName;
        }
    }
    
    // Mettre à jour l'étiquette du champ de fichier
    document.querySelector('.custom-file-input').addEventListener('change', function (e) {
        const fileName = e.target.files[0].name;
        const label = e.target.nextElementSibling;
        label.textContent = fileName;
    });
</script>
@endsection
