<?php

namespace App\Models;

use Database\Factories\DepartmentFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
}
