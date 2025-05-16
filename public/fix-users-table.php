<?php

// Script pour corriger la structure de la table users
// À supprimer après utilisation pour des raisons de sécurité

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

// Obtenir la connexion à la base de données
$db = $app->make('db');

// Vérifier la structure actuelle de la table users
try {
    echo "<h2>Structure actuelle de la table users</h2>";
    echo "<pre>";
    
    // Obtenir les noms des colonnes existantes
    $columns = $db->select("SHOW COLUMNS FROM users");
    $columnNames = array_map(function($column) {
        return $column->Field;
    }, $columns);
    
    echo "Colonnes existantes: " . implode(', ', $columnNames);
    echo "</pre>";
    
    // Colonnes nécessaires pour les paramètres
    $requiredColumns = [
        'phone' => "ALTER TABLE users ADD COLUMN phone VARCHAR(20) NULL AFTER email",
        'bio' => "ALTER TABLE users ADD COLUMN bio TEXT NULL AFTER phone",
        'avatar' => "ALTER TABLE users ADD COLUMN avatar VARCHAR(255) NULL AFTER bio",
        'notification_email' => "ALTER TABLE users ADD COLUMN notification_email BOOLEAN DEFAULT 1 AFTER avatar",
        'notification_evenements' => "ALTER TABLE users ADD COLUMN notification_evenements BOOLEAN DEFAULT 1 AFTER notification_email",
        'notification_messages' => "ALTER TABLE users ADD COLUMN notification_messages BOOLEAN DEFAULT 1 AFTER notification_evenements",
        'notification_communaute' => "ALTER TABLE users ADD COLUMN notification_communaute BOOLEAN DEFAULT 1 AFTER notification_messages",
        'profil_public' => "ALTER TABLE users ADD COLUMN profil_public BOOLEAN DEFAULT 1 AFTER notification_communaute",
        'masquer_activite' => "ALTER TABLE users ADD COLUMN masquer_activite BOOLEAN DEFAULT 0 AFTER profil_public",
        'masquer_participation' => "ALTER TABLE users ADD COLUMN masquer_participation BOOLEAN DEFAULT 0 AFTER masquer_activite"
    ];
    
    echo "<h2>Ajout des colonnes manquantes</h2>";
    echo "<pre>";
    
    // Ajouter chaque colonne manquante
    foreach ($requiredColumns as $column => $query) {
        if (!in_array($column, $columnNames)) {
            try {
                $db->statement($query);
                echo "Colonne '$column' ajoutée avec succès\n";
            } catch (\Exception $e) {
                echo "Erreur lors de l'ajout de la colonne '$column': " . $e->getMessage() . "\n";
            }
        } else {
            echo "La colonne '$column' existe déjà\n";
        }
    }
    
    echo "</pre>";
    
    // Vérifier la structure finale
    echo "<h2>Structure finale de la table users</h2>";
    echo "<pre>";
    
    $finalColumns = $db->select("SHOW COLUMNS FROM users");
    $finalColumnNames = array_map(function($column) {
        return $column->Field;
    }, $finalColumns);
    
    echo "Colonnes finales: " . implode(', ', $finalColumnNames);
    echo "</pre>";
    
} catch (\Exception $e) {
    echo "<h2>Erreur</h2>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}

echo "<p><a href='/parametres'>Retour à la page des paramètres</a></p>";
