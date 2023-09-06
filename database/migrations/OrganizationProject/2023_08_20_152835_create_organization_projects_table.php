<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('organization_projects', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->comment('Номер в календаре');
            $table->string('name')->comment('Наименование проекта');
            $table->text('description')->comment('Описание');

            $table->integer('status')->default(1)->comment('Статус');

            $table->date('start_date')->comment('Дата начала проекта');
            $table->date('end_date')->comment('Дата окончания проекта');
            $table->jsonb('dates')->comment('Другие временные точки');

            $table->text('metrics')->comment('Ключевые критерии');
            $table->integer('planned_coverage')->default(0)->comment('Ожидаемый охват');
            $table->integer('actual_coverage')->default(0)->comment('Фактический охват');

            $table->foreignId('responsible_user_id')
                ->comment('Ответственный пользователь')
                ->references('id')
                ->on('users');
            $table->foreignId('curator_user_id')
                ->comment('Куратор проекта')
                ->references('id')
                ->on('users');
            $table->foreignId('organizer_user_id')
                ->comment('Организатор')
                ->references('id')
                ->on('users');

            $table->jsonb('change_logs')->comment('Логи изменений проекта');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_projects');
    }
};
