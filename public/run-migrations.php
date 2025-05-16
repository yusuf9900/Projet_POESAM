<?php

// Fichier pour exécuter les migrations depuis le navigateur
// À supprimer après utilisation pour des raisons de sécurité

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Exécuter les migrations
$output = '';
try {
    $output = $kernel->call('migrate', [
        '--force' => true,
    ]);
    echo "<h2>Migrations exécutées avec succès!</h2>";
    echo "<pre>{$output}</pre>";
} catch (Exception $e) {
    echo "<h2>Erreur lors de l'exécution des migrations:</h2>";
    echo "<pre>{$e->getMessage()}</pre>";
}

echo "<p><a href='/parametres'>Retour à la page des paramètres</a></p>";
