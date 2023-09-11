<?php

namespace App\Models\Activity;

use App\Dto\OrganizationProject\OrganizationProjectChangeLogItemDto;
use App\Dto\OrganizationProject\OrganizationProjectInfoDto;
use App\Dto\OrganizationProject\OrganizationProjectListItemDto;
use App\Enums\OrganizationProject\OrganizationProjectStatusEnum;
use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * App\Models\Activity\OrganizationProject
 *
 * @property int $id
 * @property int $number Номер в календаре
 * @property string $name Наименование проекта
 * @property string $description Описание
 * @property OrganizationProjectStatusEnum $status Статус
 * @property Carbon $start_date Дата начала проекта
 * @property Carbon $end_date Дата окончания проекта
 * @property array $dates Другие временные точки
 * @property string $metrics Ключевые критерии
 * @property int $planned_coverage Ожидаемый охват
 * @property int $actual_coverage Фактический охват
 * @property int $responsible_user_id Ответственный пользователь
 * @property int $curator_user_id Куратор проекта
 * @property int $organizer_user_id Организатор
 * @property array $change_logs Логи изменений проекта
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|OrganizationProject newModelQuery()
 * @method static Builder|OrganizationProject newQuery()
 * @method static Builder|OrganizationProject query()
 * @mixin Eloquent
 */
class OrganizationProject extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => OrganizationProjectStatusEnum::class,
        'start_date' => 'date',
        'end_date' => 'date',
        'dates' => 'array',
        'change_logs' => 'array'
    ];

    public function scopeSearchFilter(Builder $query, ?string $search): Builder
    {
        if (is_null($search)) {
            return $query;
        }
        $search = Str::lower($search);
        return $query->where(DB::raw('LOWER(name)'), 'like', "%$search%");
    }

    public function scopeStatusFilter(Builder $query, ?OrganizationProjectStatusEnum $status): Builder
    {
        if (is_null($status)) {
            return $query;
        }

        return $query->where('status', '=', $status->value);
    }

    public function scopeStartDateFilter(Builder $query, ?Carbon $startDate): Builder
    {
        if (is_null($startDate)) {
            return $query;
        }

        return $query->where('start_date', '>=', $startDate);
    }

    public function scopeEndDateFilter(Builder $query, ?Carbon $endDate): Builder
    {
        if (is_null($endDate)) {
            return $query;
        }

        return $query->where('end_date', '<=', $endDate);
    }

    public function moderatorUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderator_user_id');
    }

    public function responsibleUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    public function curatorUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'curator_user_id');
    }

    public function organizerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_user_id');
    }

    public function toListItemDto(): OrganizationProjectListItemDto
    {
        return new OrganizationProjectListItemDto(
            id: $this->id,
            number: $this->number,
            status: $this->status,
            name: $this->name,
            description: $this->description,
            startDate: $this->start_date,
            endDate: $this->end_date,
            dates: $this->dates,
            responsibleUserId: $this->responsible_user_id,
            responsibleUserName: $this->responsibleUser->name,
            curatorUserId: $this->curator_user_id,
            curatorUserName: $this->curatorUser->name,
            organizerUserId: $this->organizer_user_id,
            organizerUserName: $this->organizerUser->name,
            moderatorUserId: $this->moderator_user_id,
            moderatorUserName: $this->moderatorUser?->name,
        );
    }

    public function toInfo(): OrganizationProjectInfoDto
    {
        return new OrganizationProjectInfoDto(
            id: $this->id,
            number: $this->number,
            status: $this->status,
            name: $this->name,
            description: $this->description,
            startDate: $this->start_date,
            endDate: $this->end_date,
            dates: $this->dates,
            metrics: $this->metrics,
            plannedCoverage: $this->planned_coverage,
            actualCoverage: $this->actual_coverage,
            responsibleUserId: $this->responsible_user_id,
            responsibleUserName: $this->responsibleUser->name,
            curatorUserId: $this->curator_user_id,
            curatorUserName: $this->curatorUser->name,
            organizerUserId: $this->organizer_user_id,
            organizerUserName: $this->organizerUser->name,
            moderatorUserId: $this->moderator_user_id,
            moderatorUserName: $this->moderatorUser?->name,
            changeLogs: $this->change_logs,
        );
    }

    public function logChange(OrganizationProjectChangeLogItemDto $changeLogItem): void
    {
        $logs = $this->change_logs;
        $logs[] = $changeLogItem->toArray();
        $this->change_logs = $logs;
    }
}
