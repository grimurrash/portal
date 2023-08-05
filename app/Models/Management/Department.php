<?php

namespace App\Models\Management;

use App\Dto\Department\DepartmentListItemDto;
use App\Dto\Department\DepartmentOptionItemDto;
use Database\Factories\Management\DepartmentFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * App\Models\Department
 *
 * @property int $id
 * @property string $name Наименование отдела
 * @property int|null $parent_department_id Родительский отдел
 * @property int|null $head_employee_id Руководитель отдела
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static DepartmentFactory factory($count = null, $state = [])
 * @method static Builder|Department newModelQuery()
 * @method static Builder|Department newQuery()
 * @method static Builder|Department query()
 * @method static Builder|Department whereCreatedAt($value)
 * @method static Builder|Department whereHeadEmployeeId($value)
 * @method static Builder|Department whereId($value)
 * @method static Builder|Department whereName($value)
 * @method static Builder|Department whereParentDepartmentId($value)
 * @method static Builder|Department whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Department extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeSearchFilter(Builder $query, string|null $search): Builder
    {
        if (is_null($search)) {
            return $query;
        }
        $search = Str::lower($search);
        return $query->where(DB::raw('LOWER(name)'), 'like', "%$search%");
    }

    public function scopeParentDepartmentIdFilter(Builder $query, int|null $parentDepartmentId): Builder
    {
        if (is_null($parentDepartmentId)) {
            return $query;
        }
        return $query->where('parent_department_id', $parentDepartmentId);
    }

    public function parentDepartment(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_department_id');
    }

    public function childrenDepartments(): HasMany
    {
        return $this->hasMany(self::class, 'parent_department_id');
    }

    public function headEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'head_employee_id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'department_id');
    }

    public function toListItemDto(): DepartmentListItemDto
    {
        return new DepartmentListItemDto(
            id: $this->id,
            name: $this->name,
            parentDepartmentId: $this->parent_department_id,
            parentDepartmentName: $this->parentDepartment?->name,
            headEmployeeId: $this->head_employee_id,
            headEmployeeFullName: $this->headEmployee?->full_name,
            employeeCount: $this->employees_count,
        );
    }

    public function toOptionItemDto(): DepartmentOptionItemDto
    {
        return new DepartmentOptionItemDto(
            id: $this->id,
            name: $this->name,
        );
    }
}
