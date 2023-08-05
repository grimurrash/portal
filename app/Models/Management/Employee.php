<?php

namespace App\Models\Management;

use App\Dto\Employee\EmployeeListItemDto;
use App\Dto\Employee\EmployeeOptionItemDto;
use App\Dto\Employee\ImportEmployeeDto;
use App\Enums\Employee\GenderEnum;
use App\Models\User;
use Database\Factories\Management\EmployeeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * App\Models\Employee
 *
 * @property int $id
 * @property int $export_number № в таблице экспорта
 * @property int|null $user_id ID пользователя
 * @property string $full_name ФИО
 * @property int $department_id Отдел
 * @property string $work_position Должность
 * @property Carbon $date_of_birth Дата рождения
 * @property GenderEnum $gender Пол
 * @property string|null $phone Личный номер телефона
 * @property string|null $work_email Рабочая электронная почта в домене edu.mos.ru
 * @property string|null $work_phone Внутренний добавочный номер телефона
 * @property string|null $work_address Адрес СП, где находится основное место исполнения трудовых функций работника
 * @property string|null $work_room_number № кабинета
 * @property string|null $education_level Уровень образования
 * @property string|null $academic_degree Ученая степень
 * @property Carbon|null $work_start_date Дата принятия на работу
 * @property Carbon|null $work_end_date Дата увольнения
 * @property Carbon|null $last_refresher_course_date Дата последнего прохождения курсов повышения квалификации
 * @property Carbon|null $last_professional_retraining_date Дата последнего прохождения профессиональной переподготовки
 * @property Carbon|null $certified_for_compliance_with_position_held_date Аттестован на соответствие занимаемой должности
 * @property Carbon|null $certified_for_position_of_teacher_date Аттестован на должность педагога с присвоением квалификационной категории
 * @property Carbon|null $certified_for_position_of_head_of_the_donm_date Аттестован на должность руководителя ОО ДОНМ
 * @property Carbon|null $validity_period_of_certification_from_date Срок действия аттестации от
 * @property Carbon|null $validity_period_of_certification_to_date Срок действия аттестации до
 * @property Carbon|null $advanced_training_courses_for_founders_representatives_date Успешно пройдены Курсы повышения квалификации для Представителей Учредителя
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

    protected $guarded = ['id'];
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

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeSearchFilter(Builder $query, string|null $search): Builder
    {
        if (is_null($search)) {
            return $query;
        }
        $search = Str::lower($search);
        return $query->where(DB::raw('LOWER(full_name)'), 'like', "%$search%");
    }

    public function scopeDepartmentIdFilter(Builder $query, int|null $departmentId): Builder
    {
        if (is_null($departmentId)) {
            return $query;
        }
        return $query->where('department_id', $departmentId);
    }

    public function scopeGenderFilter(Builder $query, GenderEnum|null $gender): Builder
    {
        if (is_null($gender)) {
            return $query;
        }
        return $query->where('gender', $gender);
    }

    public function scopeIsFoundersRepresentativeFilter(Builder $query, bool|null $isFoundersRepresentative): Builder
    {
        if (is_null($isFoundersRepresentative)) {
            return $query;
        }
        return $query->whereNull(
            'advanced_training_courses_for_founders_representatives_date',
            not: $isFoundersRepresentative
        );
    }

    public function scopeAgeFromFilter(Builder $query, int|null $ageFrom): Builder
    {
        if (is_null($ageFrom)) {
            return $query;
        }
        return $query->where('date_of_birth', '<=', Carbon::now()->subYears($ageFrom));
    }

    public function scopeAgeToFilter(Builder $query, int|null $ageTo): Builder
    {
        if (is_null($ageTo)) {
            return $query;
        }
        return $query->where('date_of_birth', '>=', Carbon::now()->subYears($ageTo));
    }

    public function scopeEducationLevelFilter(Builder $query, string|null $educationLevel): Builder
    {
        if (is_null($educationLevel)) {
            return $query;
        }
        $educationLevel = Str::lower($educationLevel);
        return $query->where(DB::raw('LOWER(education_level)'), 'like', "%$educationLevel%");
    }


    public function toImportDto(): ImportEmployeeDto
    {
        return new ImportEmployeeDto(
            exportNumber: $this->export_number,
            fullName: $this->full_name,
            departmentId: $this->department_id,
            phone: $this->phone,
            workEmail: $this->work_email,
            workPhone: $this->work_phone,
            workAddress: $this->work_address,
            workRoomNumber: $this->work_room_number,
            workPosition: $this->work_position,
            dateOfBirth: $this->date_of_birth,
            gender: $this->gender,
            educationLevel: $this->education_level,
            academicDegree: $this->academic_degree,
            workStartDate: $this->work_start_date,
            workEndDate: $this->work_end_date,
            lastRefresherCourseDate: $this->last_refresher_course_date,
            lastProfessionalRetrainingDate: $this->last_professional_retraining_date,
            certifiedForComplianceWithPositionHeldDate: $this->certified_for_compliance_with_position_held_date,
            certifiedForPositionOfTeacherDate: $this->certified_for_position_of_teacher_date,
            certifiedForPositionOfHeadOfTheDonmDate: $this->certified_for_position_of_head_of_the_donm_date,
            validityPeriodOfCertificationFromDate: $this->validity_period_of_certification_from_date,
            validityPeriodOfCertificationToDate: $this->validity_period_of_certification_to_date,
            advancedTrainingCoursesForFoundersRepresentativesDate: $this->advanced_training_courses_for_founders_representatives_date,
            representativeOfFounderInTheDonm: $this->representative_of_founder_in_the_donm,
            organizationToWhichFoundersRepresentativeIsDelegated: $this->organization_to_which_founders_representative_is_delegated,
        );
    }

    public function toOptionItemDto(): EmployeeOptionItemDto
    {
        return new EmployeeOptionItemDto(
            id: $this->id,
            name: $this->full_name
        );
    }

    public function toListItemDto(): EmployeeListItemDto
    {
        return new EmployeeListItemDto(
            id: $this->id,
            exportNumber: $this->export_number,
            fullName: $this->full_name,
            departmentId: $this->department_id,
            departmentName: $this->department->name,
            phone: $this->phone,
            workEmail: $this->work_email,
            workPhone: $this->work_phone,
            workAddress: $this->work_address,
            workRoomNumber: $this->work_room_number,
            workPosition: $this->work_position,
            dateOfBirth: $this->date_of_birth,
            gender: $this->gender,
            workStartDate: $this->work_start_date,
            workEndDate: $this->work_end_date,
        );
    }
}
