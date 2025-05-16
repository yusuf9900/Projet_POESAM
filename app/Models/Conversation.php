<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Message;

class Conversation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'titre',
        'est_groupe'
    ];
    
    /**
     * Récupérer tous les utilisateurs de cette conversation
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_user')
                    ->withPivot('est_administrateur', 'dernier_accès')
                    ->withTimestamps();
    }
    
    /**
     * Récupérer tous les messages de la conversation
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }
    
    /**
     * Récupérer le dernier message de la conversation
     */
    public function dernierMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }
    
    /**
     * Vérifier si un utilisateur est membre de la conversation
     */
    public function estMembre($userId)
    {
        return $this->users()->where('user_id', $userId)->exists();
    }
    
    /**
     * Récupérer le nombre de messages non lus pour un utilisateur
     */
    public function messagesNonLus($userId)
    {
        return $this->messages()
                    ->where('user_id', '!=', $userId)
                    ->where('est_lu', false)
                    ->count();
    }
}
