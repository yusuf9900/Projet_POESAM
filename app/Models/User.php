<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Conversation;
use App\Models\Message;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'bio',
        'avatar',
        'notification_email',
        'notification_evenements',
        'notification_messages',
        'notification_communaute',
        'profil_public',
        'masquer_activite',
        'masquer_participation',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'notification_email' => 'boolean',
            'notification_evenements' => 'boolean',
            'notification_messages' => 'boolean',
            'notification_communaute' => 'boolean',
            'profil_public' => 'boolean',
            'masquer_activite' => 'boolean',
            'masquer_participation' => 'boolean',
        ];
    }
    
    /**
     * Récupérer toutes les conversations de l'utilisateur
     */
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_user')
                    ->withPivot('est_administrateur', 'dernier_accès')
                    ->withTimestamps();
    }
    
    /**
     * Récupérer tous les messages envoyés par l'utilisateur
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
