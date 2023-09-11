<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('organization_projects', function (Blueprint $table) {
            $table->foreignId('moderator_user_id')
                ->comment('Модератор')
                ->nullable()
                ->references('id')
                ->on('users');
        });
    }

    public function down(): void
    {
        Schema::table('organization_projects', function (Blueprint $table) {
            $table->dropColumn('moderator_user_id');
        });
    }
};
