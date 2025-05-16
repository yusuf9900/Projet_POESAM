<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'posts';
    
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'contenu',
        'image',
        'statut',
        'user_id',
        'categorie_id',
    ];
    
    /**
     * Relation avec l'utilisateur qui a créé le post
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Relation avec la catégorie du post
     */
    public function categorie()
    {
        return $this->belongsTo(CategoriePost::class, 'categorie_id');
    }
    
    /**
     * Relation avec les commentaires du post
     */
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }
    
    /**
     * Relation avec les likes du post
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
    /**
     * Vérifier si un utilisateur a liké ce post
     */
    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
    
    /**
     * Obtenir le nombre de likes
     */
    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
    
    /**
     * Obtenir le nombre de commentaires
     */
    public function getCommentsCountAttribute()
    {
        return $this->commentaires()->count();
    }
}
