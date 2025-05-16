@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2 class="mb-4">Publications récentes</h2>
            
            @foreach($publications as $publication)
            <div class="post-card mb-4">
                <div class="post-header d-flex align-items-center mb-3">
                    <div class="post-avatar">
                        @if($publication->est_anonyme)
                            <i class="fas fa-user-secret"></i>
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div>
                    <div class="post-meta ms-3">
                        <h5 class="mb-0">
                            @if($publication->est_anonyme)
                                Anonyme
                            @else
                                {{ $publication->user->name }}
                            @endif
                        </h5>
                        <small class="text-muted">
                            {{ $publication->date_publication->diffForHumans() }}
                            · {{ ucfirst($publication->categorie) }}
                        </small>
                    </div>
                </div>
                
                <h4 class="post-title mb-3">{{ $publication->titre }}</h4>
                <div class="post-content mb-3">
                    {{ $publication->contenu }}
                </div>
                
                @if($publication->media)
                <div class="post-media mb-3">
                    @if(Str::endsWith($publication->media, ['.jpg', '.jpeg', '.png', '.gif']))
                        <img src="{{ Storage::url($publication->media) }}" class="img-fluid rounded" alt="Media">
                    @elseif(Str::endsWith($publication->media, ['.mp4']))
                        <video class="w-100 rounded" controls>
                            <source src="{{ Storage::url($publication->media) }}" type="video/mp4">
                            Votre navigateur ne supporte pas la lecture de vidéos.
                        </video>
                    @endif
                </div>
                @endif
                
                <div class="post-footer d-flex justify-content-between align-items-center">
                    <div class="post-actions">
                        <button class="btn btn-light me-2">
                            <i class="far fa-heart me-1"></i>
                            Soutenir
                        </button>
                        <button class="btn btn-light">
                            <i class="far fa-comment me-1"></i>
                            Commenter
                        </button>
                    </div>
                    @if(!$publication->est_anonyme && Auth::id() === $publication->user_id)
                    <div class="post-options dropdown">
                        <button class="btn btn-light" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Modifier</a></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash-alt me-2"></i>Supprimer</a></li>
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            
            <div class="d-flex justify-content-center">
                {{ $publications->links() }}
            </div>
        </div>
    </div>
</div>

<style>
.post-card {
    background: var(--white);
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.post-avatar {
    width: 45px;
    height: 45px;
    border-radius: 15px;
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.post-title {
    font-weight: 600;
    color: var(--text-color);
}

.post-content {
    font-size: 1rem;
    line-height: 1.6;
    color: var(--text-color);
}

.post-media img,
.post-media video {
    border-radius: 15px;
    width: 100%;
    max-height: 400px;
    object-fit: cover;
}

.post-actions .btn {
    border-radius: 12px;
    padding: 8px 15px;
    color: var(--text-color);
    transition: all 0.3s ease;
}

.post-actions .btn:hover {
    background-color: var(--secondary-color);
    transform: translateY(-2px);
}

.post-options .btn {
    width: 35px;
    height: 35px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endsection
