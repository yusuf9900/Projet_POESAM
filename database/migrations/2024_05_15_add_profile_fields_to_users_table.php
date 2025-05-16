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
            $table->text('bio')->nullable()->after('email');
            $table->string('telephone')->nullable()->after('bio');
            $table->string('localisation')->nullable()->after('telephone');
            $table->string('avatar')->nullable()->after('localisation');
            $table->string('user_type')->default('user')->after('avatar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bio', 'telephone', 'localisation', 'avatar', 'user_type']);
        });
    }
};
