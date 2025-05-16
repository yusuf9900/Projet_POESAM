<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Champs de profil
            $table->string('phone')->nullable()->after('email');
            $table->text('bio')->nullable()->after('phone');
            $table->string('avatar')->nullable()->after('bio');
            
            // Champs de notification
            $table->boolean('notification_email')->default(true)->after('avatar');
            $table->boolean('notification_evenements')->default(true)->after('notification_email');
            $table->boolean('notification_messages')->default(true)->after('notification_evenements');
            $table->boolean('notification_communaute')->default(true)->after('notification_messages');
            
            // Champs de confidentialité
            $table->boolean('profil_public')->default(true)->after('notification_communaute');
            $table->boolean('masquer_activite')->default(false)->after('profil_public');
            $table->boolean('masquer_participation')->default(false)->after('masquer_activite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'bio',
                'avatar',
                'notification_email',
                'notification_evenements',
                'notification_messages',
                'notification_communaute',
                'profil_public',
                'masquer_activite',
                'masquer_participation'
            ]);
        });
    }
};
