<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDO;
use Exception;

class OrganisationController extends Controller
{
    /**
     * Connexion à la base de données
     */

    private function connectDB()
    {
        return new PDO("mysql:host=db;dbname=poesam;charset=utf8mb4", "root", "rootpass", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }

    /**
     * Vérifier si l'utilisateur est connecté en tant qu'admin
     */
    private function checkAdminAuth()
    {
        if (
            !isset($_COOKIE['is_logged_in']) || $_COOKIE['is_logged_in'] !== 'true' ||
            !isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'admin'
        ) {
            return false;
        }

        // Définir les variables de session pour la barre de navigation
        session([
            'is_logged_in' => true,
            'user_type' => 'admin',
            'user_name' => $_COOKIE['user_name'] ?? 'Administrateur',
            'user_email' => $_COOKIE['user_email'] ?? 'admin@example.com'
        ]);

        return true;
    }

    /**
     * Afficher le formulaire de création d'une organisation
     */
    public function create()
    {
        if (!$this->checkAdminAuth()) {
            return redirect('/direct-login.php');
        }

        return view('admin.create-organisation');
    }

    /**
     * Traiter le formulaire de création d'organisation
     */
    public function store(Request $request)
    {
        if (!$this->checkAdminAuth()) {
            return redirect('/direct-login.php');
        }

        // Rediriger vers le script PHP qui traite la création d'organisation
        return redirect('/admin/create-organisation.php');
    }

    /**
     * Afficher la liste des organisations
     */
    public function index()
    {
        if (!$this->checkAdminAuth()) {
            return redirect('/login');
        }

        try {
            $pdo = $this->connectDB();

            // Requête pour récupérer les organisations avec les informations utilisateur
            $stmt = $pdo->prepare("SELECT o.*, u.email, u.created_at as date_creation FROM organisations o JOIN users u ON o.id_user = u.id ORDER BY o.created_at DESC");
            $stmt->execute();
            $organisations = $stmt->fetchAll();

            return view('admin.organisations', ['organisations' => $organisations]);
        } catch (Exception $e) {
            return redirect('/admin/dashboard')->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    /**
     * Afficher les détails d'une organisation
     */
    public function show($id)
    {
        if (!$this->checkAdminAuth()) {
            return redirect('/login');
        }

        try {
            $pdo = $this->connectDB();

            // Récupérer les détails de l'organisation
            $stmt = $pdo->prepare("SELECT o.*, u.email, u.created_at as date_creation FROM organisations o JOIN users u ON o.id_user = u.id WHERE o.id = ?");
            $stmt->execute([$id]);
            $organisation = $stmt->fetch();

            if (!$organisation) {
                return redirect('/admin/organisations')->with('error', 'Organisation non trouvée.');
            }

            return view('admin.show-organisation', ['organisation' => $organisation]);
        } catch (Exception $e) {
            return redirect('/admin/organisations')->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    /**
     * Afficher le formulaire de modification d'une organisation
     */
    public function edit($id)
    {
        if (!$this->checkAdminAuth()) {
            return redirect('/login');
        }

        try {
            $pdo = $this->connectDB();

            // Récupérer les détails de l'organisation
            $stmt = $pdo->prepare("SELECT o.*, u.email, u.created_at as date_creation FROM organisations o JOIN users u ON o.id_user = u.id WHERE o.id = ?");
            $stmt->execute([$id]);
            $organisation = $stmt->fetch();

            if (!$organisation) {
                return redirect('/admin/organisations')->with('error', 'Organisation non trouvée.');
            }

            return view('admin.edit-organisation', ['organisation' => $organisation]);
        } catch (Exception $e) {
            return redirect('/admin/organisations')->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    /**
     * Mettre à jour une organisation
     */
    public function update(Request $request, $id)
    {
        if (!$this->checkAdminAuth()) {
            return redirect('/login');
        }

        try {
            $pdo = $this->connectDB();

            // Récupérer l'ID de l'utilisateur associé à l'organisation
            $stmt = $pdo->prepare("SELECT id_user FROM organisations WHERE id = ?");
            $stmt->execute([$id]);
            $organisation = $stmt->fetch();

            if (!$organisation) {
                return redirect('/admin/organisations')->with('error', 'Organisation non trouvée.');
            }

            // Vérifier si c'est une mise à jour d'un seul champ via GET
            if ($request->has('field') && $request->has('value')) {
                $field = $request->field;
                $value = $request->value;

                // Mettre à jour le champ spécifique
                switch ($field) {
                    case 'nom_organisation':
                    case 'type_organisation':
                    case 'telephone_organisation':
                    case 'adresse_organisation':
                        $stmt = $pdo->prepare("UPDATE organisations SET $field = ? WHERE id = ?");
                        $stmt->execute([$value, $id]);
                        break;
                    case 'email':
                        $stmt = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
                        $stmt->execute([$value, $organisation['id_user']]);
                        break;
                    case 'password':
                        if (!empty($value)) {
                            $hashedPassword = password_hash($value, PASSWORD_DEFAULT);
                            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                            $stmt->execute([$hashedPassword, $organisation['id_user']]);
                        }
                        break;
                    default:
                        return redirect()->back()->with('error', 'Champ invalide.');
                }

                return redirect('/admin/show-organisation/' . $id)->with('success', 'Champ mis à jour avec succès.');
            }

            // Si ce n'est pas une mise à jour d'un seul champ, c'est une mise à jour complète
            // Mettre à jour les informations de l'organisation
            $stmt = $pdo->prepare("UPDATE organisations SET nom_organisation = ?, type_organisation = ?, telephone_organisation = ?, adresse_organisation = ? WHERE id = ?");
            $stmt->execute([
                $request->nom_organisation,
                $request->type_organisation,
                $request->telephone_organisation,
                $request->adresse_organisation,
                $id
            ]);

            // Mettre à jour l'email de l'utilisateur associé
            $stmt = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
            $stmt->execute([$request->email, $organisation['id_user']]);

            // Mettre à jour le mot de passe si fourni
            if ($request->filled('password')) {
                $hashedPassword = password_hash($request->password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->execute([$hashedPassword, $organisation['id_user']]);
            }

            return redirect('/admin/show-organisation/' . $id)->with('success', 'Organisation mise à jour avec succès.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Supprimer une organisation
     */
    public function destroy($id)
    {
        if (!$this->checkAdminAuth()) {
            return redirect('/login');
        }

        try {
            $pdo = $this->connectDB();

            // Récupérer l'ID de l'utilisateur associé à l'organisation
            $stmt = $pdo->prepare("SELECT id_user, nom_organisation FROM organisations WHERE id = ?");
            $stmt->execute([$id]);
            $organisation = $stmt->fetch();

            if (!$organisation) {
                return redirect('/admin/organisations')->with('error', 'Organisation non trouvée.');
            }

            // Démarrer une transaction
            $pdo->beginTransaction();

            // Supprimer l'organisation
            $stmt = $pdo->prepare("DELETE FROM organisations WHERE id = ?");
            $stmt->execute([$id]);

            // Supprimer l'utilisateur associé
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$organisation['id_user']]);

            // Valider la transaction
            $pdo->commit();

            return redirect('/admin/organisations')->with('success', 'L\'organisation "' . $organisation['nom_organisation'] . '" a été supprimée avec succès.');
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            return redirect('/admin/organisations')->with('error', 'Une erreur est survenue lors de la suppression : ' . $e->getMessage());
        }
    }
}
