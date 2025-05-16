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
        Schema::table('users', function (Blueprint $table) {
            // Vérifier et ajouter chaque colonne individuellement
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'notification_email')) {
                $table->boolean('notification_email')->default(true);
            }
            
            if (!Schema::hasColumn('users', 'notification_evenements')) {
                $table->boolean('notification_evenements')->default(true);
            }
            
            if (!Schema::hasColumn('users', 'notification_messages')) {
                $table->boolean('notification_messages')->default(true);
            }
            
            if (!Schema::hasColumn('users', 'notification_communaute')) {
                $table->boolean('notification_communaute')->default(true);
            }
            
            if (!Schema::hasColumn('users', 'profil_public')) {
                $table->boolean('profil_public')->default(true);
            }
            
            if (!Schema::hasColumn('users', 'masquer_activite')) {
                $table->boolean('masquer_activite')->default(false);
            }
            
            if (!Schema::hasColumn('users', 'masquer_participation')) {
                $table->boolean('masquer_participation')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'phone',
                'notification_email',
                'notification_evenements',
                'notification_messages',
                'notification_communaute',
                'profil_public',
                'masquer_activite',
                'masquer_participation'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
