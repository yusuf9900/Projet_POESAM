<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Création de la table des catégories de posts
        Schema::create('categories_posts', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 50);
            $table->text('description')->nullable();
            $table->string('icone', 50)->nullable();
            $table->timestamps();
        });

        // Création de la table des posts
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 100);
            $table->text('contenu');
            $table->string('image')->nullable();
            $table->enum('statut', ['actif', 'inactif'])->default('actif');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('categorie_id')->constrained('categories_posts')->onDelete('cascade');
            $table->timestamps();
        });

        // Création de la table des commentaires pour les posts
        Schema::create('commentaires_posts', function (Blueprint $table) {
            $table->id();
            $table->text('contenu');
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('commentaires_posts')->onDelete('cascade');
            $table->timestamps();
        });

        // Création de la table des likes pour les posts
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            // Ajouter une contrainte unique pour éviter les doublons de likes
            $table->unique(['post_id', 'user_id']);
        });

        // Ajout de quelques catégories de base pour les posts
        DB::table('categories_posts')->insert([
            [
                'nom' => 'Discussions générales',
                'description' => 'Discussions générales sur tous sujets liés aux droits des femmes',
                'icone' => 'fas fa-comments',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Témoignages',
                'description' => 'Partagez vos témoignages et expériences',
                'icone' => 'fas fa-heart',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Conseils',
                'description' => 'Demander ou partager des conseils',
                'icone' => 'fas fa-lightbulb',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Annonces',
                'description' => 'Événements et annonces importantes',
                'icone' => 'fas fa-bullhorn',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
        Schema::dropIfExists('commentaires_posts');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('categories_posts');
    }
};
