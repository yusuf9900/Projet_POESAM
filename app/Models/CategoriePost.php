<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriePost extends Model
{
    use HasFactory;
    
    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'categories_posts';
    
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'description',
        'icone'
    ];
    
    /**
     * Relation avec les posts de cette catégorie
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'categorie_id');
    }
}
