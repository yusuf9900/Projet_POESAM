<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceCategory extends Model
{
    use HasFactory;
    
    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'ressource_categorie';

    protected $fillable = [
        'name',
        'icon',
        'description',
        'sort_order'
    ];

    /**
     * Relation avec les ressources
     */
    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'ressource_categorie_ressource', 'ressource_categorie_id', 'ressource_id');
    }
}
