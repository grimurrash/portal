<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Наименование отдела');
            $table->unsignedBigInteger('parent_department_id')
                ->comment('Родительский отдел')
                ->nullable();
            $table->unsignedBigInteger('head_employee_id')
                ->comment('Руководитель отдела')
                ->nullable();
            $table->timestamps();

            $table->foreign('parent_department_id')->references('id')->on('departments');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
