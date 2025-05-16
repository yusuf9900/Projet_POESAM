<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;
    
    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'ressources';

    protected $fillable = [
        'user_id',
        'organisation_id',
        'titre',
        'description',
        'contenu',
        'lien',
        'type_ressource'
    ];
    
    // Map les attributs pour conserver la compatibilité avec le contrôleur
    public function getTitleAttribute()
    {
        return $this->titre;
    }
    
    public function getTypeAttribute()
    {
        return $this->type_ressource;
    }
    
    public function getResourceUrlAttribute()
    {
        return $this->lien;
    }

    /**
     * Relation avec l'utilisateur qui a créé la ressource
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'organisation
     */
    public function organisation()
    {
        return $this->belongsTo(\App\Models\Organisation::class);
    }
}
