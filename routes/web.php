<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\AdminController;
=======
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\CommunauteController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\HomeController;
>>>>>>> 0dc3f44163489ed095f93683950b12f073bda4bb

// Route pour la page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('welcome');

// Routes pour les publications
Route::post('/publications', [PublicationController::class, 'store'])->name('publications.store');
Route::post('/publications/store', [PublicationController::class, 'store'])->name('publications.save');
Route::get('/publications', [PublicationController::class, 'index'])->name('publications.index');

// Routes pour les commentaires
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{commentaire}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Routes pour les réactions
Route::match(['get', 'post'], '/reactions', [ReactionController::class, 'store'])->name('reactions.store');
Route::delete('/reactions/{reaction}', [ReactionController::class, 'destroy'])->name('reactions.destroy');

// Route pour la page home (tableau de bord des victimes)
<<<<<<< HEAD
Route::get('/home', function (\Illuminate\Http\Request $request) {
    // Vérifier si l'utilisateur est connecté via les cookies
    if (isset($_COOKIE['is_logged_in']) && $_COOKIE['is_logged_in'] === 'true') {
        // Copier les données des cookies vers la session Laravel pour les rendre disponibles dans la vue
        session([
            'user_id' => $_COOKIE['user_id'] ?? null,
            'user_email' => $_COOKIE['user_email'] ?? null,
            'user_name' => $_COOKIE['user_name'] ?? null,
            'user_type' => $_COOKIE['user_type'] ?? null,
            'is_logged_in' => true
        ]);

        // Vérifier le type d'utilisateur
        if (isset($_COOKIE['user_type']) && $_COOKIE['user_type'] !== 'victime') {
            // Rediriger vers le tableau de bord approprié
            if ($_COOKIE['user_type'] === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($_COOKIE['user_type'] === 'organisation') {
                return redirect('/organisation/dashboard');
            }
        }

        // Afficher la page home avec les données de session
        return view('home');
    }

    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    return redirect('/direct-login.php');
})->name('home');
=======
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Routes pour le profil utilisateur
Route::get('/profile', [\App\Http\Controllers\UserController::class, 'profile'])->name('profile');
Route::post('/profile/update', [\App\Http\Controllers\UserController::class, 'update'])->name('profile.update');

// Routes pour la messagerie
Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
Route::get('/messages/{id}', [\App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
Route::post('/messages/conversation', [\App\Http\Controllers\MessageController::class, 'storeConversation'])->name('messages.store.conversation');
Route::post('/messages/groupe', [\App\Http\Controllers\MessageController::class, 'storeGroupe'])->name('messages.store.groupe');
Route::post('/messages/{conversationId}/message', [\App\Http\Controllers\MessageController::class, 'storeMessage'])->name('messages.store.message');
Route::post('/messages/{conversationId}/membres', [\App\Http\Controllers\MessageController::class, 'addMembres'])->name('messages.add.membres');
Route::get('/messages/{conversationId}/leave', [\App\Http\Controllers\MessageController::class, 'leaveConversation'])->name('messages.leave');

// Routes des ressources
Route::get('/ressources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/ressources/categorie/{id}', [ResourceController::class, 'category'])->name('resources.category');
Route::get('/ressources/{id}', [ResourceController::class, 'show'])->name('resources.show');
Route::get('/ressources/telecharger/{id}', [ResourceController::class, 'download'])->name('resources.download');
Route::get('/ressources/creer', [ResourceController::class, 'create'])->name('resources.create');
Route::post('/ressources', [ResourceController::class, 'store'])->name('resources.store');
Route::get('/ressources/recherche', [ResourceController::class, 'search'])->name('resources.search');

// Routes de la communauté
Route::get('/communaute', [CommunauteController::class, 'index'])->name('communaute.index');
Route::get('/communaute/creer', [CommunauteController::class, 'create'])->name('communaute.create');
Route::post('/communaute', [CommunauteController::class, 'store'])->name('communaute.store');
Route::get('/communaute/{id}', [CommunauteController::class, 'show'])->name('communaute.show');
Route::get('/communaute/{id}/modifier', [CommunauteController::class, 'edit'])->name('communaute.edit');
Route::put('/communaute/{id}', [CommunauteController::class, 'update'])->name('communaute.update');
Route::delete('/communaute/{id}', [CommunauteController::class, 'destroy'])->name('communaute.destroy');
Route::post('/communaute/{post_id}/commentaire', [CommunauteController::class, 'storeComment'])->name('communaute.comment.store');
Route::delete('/commentaire/{id}', [CommunauteController::class, 'destroyComment'])->name('communaute.comment.destroy');
Route::post('/communaute/{post_id}/like', [CommunauteController::class, 'toggleLike'])->name('communaute.like.toggle');
Route::get('/communaute/categorie/{categorie_id}', [CommunauteController::class, 'filterByCategory'])->name('communaute.category');
Route::get('/communaute/recherche', [CommunauteController::class, 'search'])->name('communaute.search');

// Routes pour les événements
Route::get('/evenements', [EvenementController::class, 'index'])->name('evenements.index');
Route::get('/evenements/creer', [EvenementController::class, 'create'])->name('evenements.create');
Route::post('/evenements', [EvenementController::class, 'store'])->name('evenements.store');
Route::get('/evenements/{id}', [EvenementController::class, 'show'])->name('evenements.show');
Route::get('/evenements/{id}/modifier', [EvenementController::class, 'edit'])->name('evenements.edit');
Route::put('/evenements/{id}', [EvenementController::class, 'update'])->name('evenements.update');
Route::delete('/evenements/{id}', [EvenementController::class, 'destroy'])->name('evenements.destroy');
Route::get('/evenements/{id}/participer', [EvenementController::class, 'participer'])->name('evenements.participer');
Route::get('/evenements/{id}/annuler', [EvenementController::class, 'annuler'])->name('evenements.annuler');
Route::get('/evenements/a-venir', [EvenementController::class, 'aVenir'])->name('evenements.a-venir');
Route::get('/evenements/passes', [EvenementController::class, 'passes'])->name('evenements.passes');
Route::get('/evenements/mes-evenements', [EvenementController::class, 'mesEvenements'])->name('evenements.mes-evenements');
Route::get('/evenements/recherche', [EvenementController::class, 'recherche'])->name('evenements.recherche');

// Routes pour les paramètres
Route::get('/parametres', [\App\Http\Controllers\ParametresController::class, 'index'])->name('parametres.index');
Route::post('/parametres/profile', [\App\Http\Controllers\ParametresController::class, 'updateProfile'])->name('parametres.updateProfile');
Route::post('/parametres/password', [\App\Http\Controllers\ParametresController::class, 'updatePassword'])->name('parametres.updatePassword');
Route::post('/parametres/notifications', [\App\Http\Controllers\ParametresController::class, 'updateNotifications'])->name('parametres.updateNotifications');
Route::post('/parametres/privacy', [\App\Http\Controllers\ParametresController::class, 'updatePrivacy'])->name('parametres.updatePrivacy');
Route::post('/parametres/delete-account', [\App\Http\Controllers\ParametresController::class, 'deleteAccount'])->name('parametres.deleteAccount');

// Route de déconnexion
Route::get('/logout', function() {
    // Supprimer les cookies d'authentification
    setcookie('is_logged_in', '', time() - 3600, '/');
    setcookie('user_id', '', time() - 3600, '/');
    setcookie('user_email', '', time() - 3600, '/');
    setcookie('user_name', '', time() - 3600, '/');
    setcookie('user_type', '', time() - 3600, '/');
    
    // Vider la session
    session()->flush();
    
    // Rediriger vers la page d'accueil
    return redirect('/')->with('message', 'Vous avez été déconnecté avec succès');
})->name('logout');
>>>>>>> 0dc3f44163489ed095f93683950b12f073bda4bb

// Routes pour le tableau de bord admin
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
        // Vérifier si l'utilisateur est connecté en tant qu'admin
        if (isset($_COOKIE['is_logged_in']) && $_COOKIE['is_logged_in'] === 'true' && isset($_COOKIE['user_type']) && $_COOKIE['user_type'] === 'admin') {
            // Copier les données des cookies vers la session Laravel
            session([
                'user_id' => $_COOKIE['user_id'] ?? null,
                'user_email' => $_COOKIE['user_email'] ?? null,
                'user_name' => $_COOKIE['user_name'] ?? null,
                'user_type' => $_COOKIE['user_type'] ?? null,
                'is_logged_in' => true
            ]);

            // Récupérer les organisations pour le tableau de bord
            try {
                $pdo = new PDO("mysql:host=db;dbname=poesam;charset=utf8mb4", "root", "rootpass", [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);

                $stmt = $pdo->prepare("SELECT o.*, u.email, u.created_at as date_creation FROM organisations o JOIN users u ON o.id_user = u.id ORDER BY o.created_at DESC");
                $stmt->execute();
                $organisations = $stmt->fetchAll();

                return view('admin.dashboard', ['organisations' => $organisations]);
            } catch (\Exception $e) {
                return view('admin.dashboard', ['organisations' => [], 'error' => $e->getMessage()]);
            }
        }

        // Si l'utilisateur n'est pas connecté en tant qu'admin, rediriger vers la page de connexion
        return redirect('/direct-login.php');
    })->name('admin.dashboard');
<<<<<<< HEAD

=======
    
    // Route pour la page de statistiques
    Route::get('/statistiques', function () {
        // Vérifier si l'utilisateur est connecté en tant qu'admin
        if (isset($_COOKIE['is_logged_in']) && $_COOKIE['is_logged_in'] === 'true' && isset($_COOKIE['user_type']) && $_COOKIE['user_type'] === 'admin') {
            // Copier les données des cookies vers la session Laravel
            session([
                'user_id' => $_COOKIE['user_id'] ?? null,
                'user_email' => $_COOKIE['user_email'] ?? null,
                'user_name' => $_COOKIE['user_name'] ?? null,
                'user_type' => $_COOKIE['user_type'] ?? null,
                'is_logged_in' => true
            ]);
            
            return view('admin.statistiques');
        }
        
        // Si l'utilisateur n'est pas connecté en tant qu'admin, rediriger vers la page de connexion
        return redirect('/direct-login.php');
    })->name('admin.statistiques');
    
>>>>>>> 0dc3f44163489ed095f93683950b12f073bda4bb
    // Routes pour la gestion des organisations avec le contrôleur
    Route::get('/create-organisation', 'App\Http\Controllers\Admin\OrganisationController@create')->name('admin.create-organisation');
    Route::post('/create-organisation', 'App\Http\Controllers\Admin\OrganisationController@store');
    Route::get('/organisations', 'App\Http\Controllers\Admin\OrganisationController@index')->name('admin.organisations');
    Route::get('/show-organisation/{id}', 'App\Http\Controllers\Admin\OrganisationController@show')->name('admin.show-organisation');
    Route::get('/edit-organisation/{id}', 'App\Http\Controllers\Admin\OrganisationController@edit')->name('admin.edit-organisation');
    Route::match(['get', 'post'], '/update-organisation/{id}', 'App\Http\Controllers\Admin\OrganisationController@update')->name('admin.update-organisation');
    Route::get('/delete-organisation/{id}', 'App\Http\Controllers\Admin\OrganisationController@destroy')->name('admin.delete-organisation');
});

// Routes pour le tableau de bord des organisations
Route::prefix('organisation')->group(function () {
    Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
        // Vérifier si l'utilisateur est connecté en tant qu'organisation
        if (isset($_COOKIE['is_logged_in']) && $_COOKIE['is_logged_in'] === 'true' && isset($_COOKIE['user_type']) && $_COOKIE['user_type'] === 'organisation') {
            // Copier les données des cookies vers la session Laravel
            session([
                'user_id' => $_COOKIE['user_id'] ?? null,
                'user_email' => $_COOKIE['user_email'] ?? null,
                'user_name' => $_COOKIE['user_name'] ?? null,
                'user_type' => $_COOKIE['user_type'] ?? null,
                'is_logged_in' => true
            ]);

            return view('organisation.dashboard');
        }

        // Si l'utilisateur n'est pas connecté en tant qu'organisation, rediriger vers la page de connexion
        return redirect('/direct-login.php');
    })->name('organisation.dashboard');
});

// Les routes pour le système d'authentification simplifié ont été supprimées car nous utilisons maintenant direct-login.php

// Route de redirection pour résoudre l'erreur 'Route [login] not defined'
Route::get('/login', function () {
    return redirect('/direct-login.php');
})->name('login');

// Routes de test pour déboguer les problèmes de formulaire
Route::get('/test-form', [\App\Http\Controllers\TestController::class, 'index'])->name('test.form');
Route::post('/test-submit', [\App\Http\Controllers\TestController::class, 'submit'])->name('test.submit');

// Les routes d'authentification Laravel ont été supprimées car nous utilisons maintenant direct-login.php et direct-register.php
