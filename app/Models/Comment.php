<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenu',
        'user_id',
        'publication_id',
        'parent_id', // Pour les réponses aux commentaires
        'est_anonyme'
    ];

    protected $casts = [
        'est_anonyme' => 'boolean',
        'created_at' => 'datetime'
    ];
    
    // Relation avec l'utilisateur qui a commenté
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relation avec la publication
    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }
    
    // Relation avec le commentaire parent (pour les réponses)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
    
    // Relation avec les réponses à ce commentaire
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
