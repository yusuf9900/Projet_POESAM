<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $table = 'publications';
    
    protected $fillable = [
        'titre',
        'contenu',
        'date_publication',
        'est_anonyme',
        'categorie',
        'user_id'
    ];

    protected $casts = [
        'date_publication' => 'datetime',
        'est_anonyme' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relation avec les commentaires
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    // Relation avec les anciens commentaires (pour rétrocompatibilité)
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    // Relation avec les réactions
    public function reactions()
    {
        return $this->hasMany(Reaction::class, 'publication_id');
    }
}
