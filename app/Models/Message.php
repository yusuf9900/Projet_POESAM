<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'conversation_id',
        'user_id',
        'contenu',
        'fichier_attaché',
        'est_lu'
    ];
    
    /**
     * Récupérer l'utilisateur qui a envoyé le message
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Récupérer la conversation à laquelle appartient le message
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
    
    /**
     * Marquer le message comme lu
     */
    public function marquerCommeLu()
    {
        $this->est_lu = true;
        $this->save();
        
        return $this;
    }
}
