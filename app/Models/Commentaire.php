<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $table = 'commentaires';
    
    protected $fillable = [
        'contenu',
        'date_commentaire',
        'publication_id',
        'user_id'
    ];

    public function publication()
    {
        return $this->belongsTo(Publication::class, 'publication_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Relation avec les réactions pour ce commentaire
     */
    public function reactions()
    {
        return $this->hasMany(Reaction::class, 'commentaire_id');
    }
    
    // Note: La table n'a pas de support pour les réponses hiérarchiques aux commentaires
}
