<?php

namespace App\Models;

use App\Enums\Employee\GenderEnum;
use Database\Factories\EmployeeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Employee
 *
 * @property int $id
 * @property int $export_number № в таблице экспорта
 * @property int|null $user_id ID пользователя
 * @property string $full_name ФИО
 * @property int $department_id Отдел
 * @property string $work_position Должность
 * @property string $date_of_birth Дата рождения
 * @property string $gender Пол
 * @property string|null $phone Личный номер телефона
 * @property string|null $work_email Рабочая электронная почта в домене edu.mos.ru
 * @property string|null $work_phone Внутренний добавочный номер телефона
 * @property string|null $work_address Адрес СП, где находится основное место исполнения трудовых функций работника
 * @property string|null $work_room_number № кабинета
 * @property string|null $education_level Уровень образования
 * @property string|null $academic_degree Ученая степень
 * @property string|null $work_start_date Дата принятия на работу
 * @property string|null $work_end_date Дата увольнения
 * @property string|null $last_refresher_course_date Дата последнего прохождения курсов повышения квалификации
 * @property string|null $last_professional_retraining_date Дата последнего прохождения профессиональной переподготовки
 * @property string|null $certified_for_compliance_with_position_held_date Аттестован на соответствие занимаемой должности
 * @property string|null $certified_for_position_of_teacher_date Аттестован на должность педагога с присвоением квалификационной категории
 * @property string|null $certified_for_position_of_head_of_the_donm_date Аттестован на должность руководителя ОО ДОНМ
 * @property string|null $validity_period_of_certification_from_date Срок действия аттестации от
 * @property string|null $validity_period_of_certification_to_date Срок действия аттестации до
 * @property string|null $advanced_training_courses_for_founders_representatives_date Успешно пройдены Курсы повышения квалификации для Представителей Учредителя
 * @property string|null $representative_of_founder_in_the_donm Представитель Учредителя в ОО ДОНМ
 * @property string|null $organization_to_which_founders_representative_is_delegated ОО, в которую делегирован Представитель Учредителя
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static EmployeeFactory factory($count = null, $state = [])
 * @method static Builder|Employee newModelQuery()
 * @method static Builder|Employee newQuery()
 * @method static Builder|Employee query()
 * @method static Builder|Employee whereAcademicDegree($value)
 * @method static Builder|Employee whereAdvancedTrainingCoursesForFoundersRepresentativesDate($value)
 * @method static Builder|Employee whereCertifiedForComplianceWithPositionHeldDate($value)
 * @method static Builder|Employee whereCertifiedForPositionOfHeadOfTheDonmDate($value)
 * @method static Builder|Employee whereCertifiedForPositionOfTeacher($value)
 * @method static Builder|Employee whereCreatedAt($value)
 * @method static Builder|Employee whereDateOfBirth($value)
 * @method static Builder|Employee whereDepartmentId($value)
 * @method static Builder|Employee whereEducationLevel($value)
 * @method static Builder|Employee whereExportNumber($value)
 * @method static Builder|Employee whereFullName($value)
 * @method static Builder|Employee whereGender($value)
 * @method static Builder|Employee whereId($value)
 * @method static Builder|Employee whereLastProfessionalRetrainingDate($value)
 * @method static Builder|Employee whereLastRefresherCourseDate($value)
 * @method static Builder|Employee whereOrganizationToWhichFoundersRepresentativeIsDelegated($value)
 * @method static Builder|Employee wherePhone($value)
 * @method static Builder|Employee whereRepresentativeOfFounderInTheDonm($value)
 * @method static Builder|Employee whereUpdatedAt($value)
 * @method static Builder|Employee whereUserId($value)
 * @method static Builder|Employee whereValidityPeriodOfCertificationFromDate($value)
 * @method static Builder|Employee whereValidityPeriodOfCertificationToDate($value)
 * @method static Builder|Employee whereWorkAddress($value)
 * @method static Builder|Employee whereWorkEmail($value)
 * @method static Builder|Employee whereWorkEndDate($value)
 * @method static Builder|Employee whereWorkPhone($value)
 * @method static Builder|Employee whereWorkPosition($value)
 * @method static Builder|Employee whereWorkRoomNumber($value)
 * @method static Builder|Employee whereWorkStartDate($value)
 * @mixin Eloquent
 */
class Employee extends Model
{
    use HasFactory;

    protected $casts = [
        'gender' => GenderEnum::class,
        'date_of_birth' => 'datetime',
        'advanced_training_courses_for_founders_representatives_date' => 'datetime',
        'certified_for_compliance_with_position_held_date' => 'datetime',
        'certified_for_position_of_head_of_the_donm_date' => 'datetime',
        'certified_for_position_of_teacher_date' => 'datetime',
        'last_professional_retraining_date' => 'datetime',
        'last_refresher_course_date' => 'datetime',
        'validity_period_of_certification_from_date' => 'datetime',
        'validity_period_of_certification_to_date' => 'datetime',
        'work_end_date' => 'datetime',
        'work_start_date' => 'datetime'
    ];
}
