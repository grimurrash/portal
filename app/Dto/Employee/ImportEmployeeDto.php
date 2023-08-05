<?php

namespace App\Dto\Employee;

use App\Enums\Employee\GenderEnum;
use Carbon\Carbon;

readonly class ImportEmployeeDto
{
    public function __construct(
        public int         $exportNumber,
        public string      $fullName,
        public int         $departmentId,
        public string|null $phone,
        public string|null $workEmail,
        public string|null $workPhone,
        public string|null $workAddress,
        public string|null $workRoomNumber,
        public string      $workPosition,
        public Carbon      $dateOfBirth,
        public GenderEnum  $gender,
        public string|null $educationLevel,
        public string|null $academicDegree,
        public Carbon|null $workStartDate,
        public Carbon|null $workEndDate,
        public Carbon|null $lastRefresherCourseDate,
        public Carbon|null $lastProfessionalRetrainingDate,
        public Carbon|null $certifiedForComplianceWithPositionHeldDate,
        public Carbon|null $certifiedForPositionOfTeacherDate,
        public Carbon|null $certifiedForPositionOfHeadOfTheDonmDate,
        public Carbon|null $validityPeriodOfCertificationFromDate,
        public Carbon|null $validityPeriodOfCertificationToDate,
        public Carbon|null $advancedTrainingCoursesForFoundersRepresentativesDate,
        public string|null $representativeOfFounderInTheDonm,
        public string|null $organizationToWhichFoundersRepresentativeIsDelegated,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'export_number' => $this->exportNumber,
            'full_name' => $this->fullName,
            'department_id' => $this->departmentId,
            'work_position' => $this->workPosition,
            'date_of_birth' => $this->dateOfBirth,
            'gender' => $this->gender->value,
            'phone' => $this->phone,
            'work_email' => $this->workEmail,
            'work_phone' => $this->workPhone,
            'work_address' => $this->workAddress,
            'work_room_number' => $this->workRoomNumber,
            'education_level' => $this->educationLevel,
            'academic_degree' => $this->academicDegree,
            'work_start_date' => $this->workStartDate,
            'work_end_date' => $this->workStartDate,
            'last_refresher_course_date' => $this->lastRefresherCourseDate,
            'last_professional_retraining_date' => $this->lastProfessionalRetrainingDate,
            'certified_for_compliance_with_position_held_date' => $this->certifiedForComplianceWithPositionHeldDate,
            'certified_for_position_of_teacher_date' => $this->certifiedForPositionOfTeacherDate,
            'certified_for_position_of_head_of_the_donm_date' => $this->certifiedForPositionOfHeadOfTheDonmDate,
            'validity_period_of_certification_from_date' => $this->validityPeriodOfCertificationFromDate,
            'validity_period_of_certification_to_date' => $this->validityPeriodOfCertificationToDate,
            'advanced_training_courses_for_founders_representatives_date' => $this->advancedTrainingCoursesForFoundersRepresentativesDate,
            'representative_of_founder_in_the_donm' => $this->representativeOfFounderInTheDonm,
            'organization_to_which_founders_representative_is_delegated' => $this->organizationToWhichFoundersRepresentativeIsDelegated,
        ];
    }

    public static function selfByArray(array $exportItem, int $departmentId): self
    {
        return new ImportEmployeeDto(
            exportNumber: $exportItem['A'],
            fullName: $exportItem['H'],
            departmentId: $departmentId,
            phone: null,
            workEmail: $exportItem['E'] ?? null,
            workPhone: $exportItem['D'] ?? null,
            workAddress: $exportItem['B'] ?? null,
            workRoomNumber: $exportItem['C'] ?? null,
            workPosition: $exportItem['G'] ?? null,
            dateOfBirth: isset($exportItem['I'])
                ? Carbon::createFromFormat('m/d/Y', $exportItem['I'])->startOfDay() : null,
            gender: GenderEnum::selfByImportString($exportItem['J']),
            educationLevel: $exportItem['K'] ?? null,
            academicDegree: $exportItem['L'] ?? null,
            workStartDate: isset($exportItem['O'])
                ? Carbon::createFromFormat('m/d/Y', $exportItem['O'])->startOfDay() : null,
            workEndDate: isset($exportItem['P'])
                ? Carbon::createFromFormat('m/d/Y', $exportItem['P'])->startOfDay() : null,
            lastRefresherCourseDate: isset($exportItem['M'])
                ? Carbon::createFromFormat('m/d/Y', $exportItem['M'])->startOfDay() : null,
            lastProfessionalRetrainingDate: isset($exportItem['N'])
                ? Carbon::createFromFormat('m/d/Y', $exportItem['N'])->startOfDay() : null,
            certifiedForComplianceWithPositionHeldDate: isset($exportItem['Q'])
                ? Carbon::createFromFormat('m/d/Y', $exportItem['Q'])->startOfDay() : null,
            certifiedForPositionOfTeacherDate: isset($exportItem['R'])
                ? Carbon::createFromFormat('m/d/Y', $exportItem['R'])->startOfDay() : null,
            certifiedForPositionOfHeadOfTheDonmDate: isset($exportItem['S'])
                ? Carbon::createFromFormat('m/d/Y', $exportItem['S'])->startOfDay() : null,
            validityPeriodOfCertificationFromDate: isset($exportItem['T'])
                ? Carbon::createFromFormat('m/d/Y', $exportItem['T'])->startOfDay() : null,
            validityPeriodOfCertificationToDate: isset($exportItem['U'])
                ? Carbon::createFromFormat('m/d/Y', $exportItem['U'])->startOfDay() : null,
            advancedTrainingCoursesForFoundersRepresentativesDate: isset($exportItem['V'])
                ? Carbon::createFromFormat('m/d/Y', $exportItem['V'])->startOfDay() : null,
            representativeOfFounderInTheDonm: $exportItem['W'] ?? null,
            organizationToWhichFoundersRepresentativeIsDelegated: $exportItem['X'] ?? null
        );
    }
}
