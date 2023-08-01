<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->string('guard_name')->default('api')->change();
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('guard_name')->default('api')->change();
        });
    }
};
