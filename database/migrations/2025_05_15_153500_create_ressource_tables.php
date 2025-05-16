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
        Schema::create('ressource_categorie', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('ressource', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type'); // document, link, video, etc.
            $table->string('resource_url')->nullable(); // Pour les liens
            $table->string('file_path')->nullable(); // Pour les fichiers uploadés
            $table->string('thumbnail')->nullable(); // Image d'aperçu
            $table->boolean('is_approved')->default(true);
            $table->integer('downloads')->default(0);
            $table->integer('views')->default(0);
            $table->timestamps();
        });

        Schema::create('ressource_categorie_ressource', function (Blueprint $table) {
            $table->foreignId('ressource_id')->constrained('ressource')->onDelete('cascade');
            $table->foreignId('ressource_categorie_id')->constrained('ressource_categorie')->onDelete('cascade');
            $table->primary(['ressource_id', 'ressource_categorie_id']);
        });

        // Créer quelques catégories par défaut
        DB::table('ressource_categorie')->insert([
            [
                'name' => 'Documents juridiques',
                'icon' => 'fas fa-gavel',
                'description' => 'Documents juridiques liés aux droits des femmes',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Guides et tutoriels',
                'icon' => 'fas fa-book',
                'description' => 'Guides pratiques et tutoriels',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vidéos éducatives',
                'icon' => 'fas fa-video',
                'description' => 'Vidéos de sensibilisation et de formation',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Articles',
                'icon' => 'fas fa-newspaper',
                'description' => 'Articles et publications',
                'sort_order' => 4,
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
        Schema::dropIfExists('ressource_categorie_ressource');
        Schema::dropIfExists('ressource');
        Schema::dropIfExists('ressource_categorie');
    }
};
