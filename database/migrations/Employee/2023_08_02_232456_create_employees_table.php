<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->integer('export_number')
                ->comment('№ в таблице экспорта');
            $table->string('full_name')
                ->comment('ФИО');
            $table->unsignedBigInteger('department_id')
                ->comment('Отдел');
            $table->string('phone')
                ->comment('Личный номер телефона')
                ->nullable();
            $table->string('work_email')
                ->comment('Рабочая электронная почта в домене edu.mos.ru')
                ->nullable();
            $table->string('work_phone')
                ->comment('Внутренний добавочный номер телефона')
                ->nullable();
            $table->string('work_address')
                ->comment('Адрес СП, где находится основное место исполнения трудовых функций работника')
                ->nullable();
            $table->string('work_room_number', 10)
                ->comment('№ кабинета')
                ->nullable();
            $table->string('work_position')
                ->comment('Должность');
            $table->date('date_of_birth')
                ->comment('Дата рождения');
            $table->string('gender', 10)
                ->comment('Пол');
            $table->string('education_level')
                ->comment('Уровень образования')
                ->nullable();
            $table->string('academic_degree')
                ->comment('Ученая степень')
                ->nullable();
            $table->date('work_start_date')
                ->comment('Дата принятия на работу')
                ->nullable();
            $table->date('work_end_date')
                ->comment('Дата увольнения')
                ->nullable();
            $table->date('last_refresher_course_date')
                ->comment('Дата последнего прохождения курсов повышения квалификации')
                ->nullable();
            $table->date('last_professional_retraining_date')
                ->comment('Дата последнего прохождения профессиональной переподготовки')
                ->nullable();
            $table->date('certified_for_compliance_with_position_held_date')
                ->comment('Аттестован на соответствие занимаемой должности')
                ->nullable();
            $table->date('certified_for_position_of_teacher_date')
                ->comment('Аттестован на должность педагога с присвоением квалификационной категории')
                ->nullable();
            $table->date('certified_for_position_of_head_of_the_donm_date')
                ->comment('Аттестован на должность руководителя ОО ДОНМ')
                ->nullable();
            $table->date('validity_period_of_certification_from_date')
                ->comment('Срок действия аттестации от')
                ->nullable();
            $table->date('validity_period_of_certification_to_date')
                ->comment('Срок действия аттестации до')
                ->nullable();
            $table->date('advanced_training_courses_for_founders_representatives_date')
                ->comment('Успешно пройдены Курсы повышения квалификации для Представителей Учредителя')
                ->nullable();
            $table->string('representative_of_founder_in_the_donm')
                ->comment('Представитель Учредителя в ОО ДОНМ')
                ->nullable();
            $table->string('organization_to_which_founders_representative_is_delegated')
                ->comment('ОО, в которую делегирован Представитель Учредителя')
                ->nullable();

            $table->timestamps();

            $table->unsignedBigInteger('user_id')
                ->comment('ID пользователя')
                ->nullable();

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('department_id')->on('departments')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
