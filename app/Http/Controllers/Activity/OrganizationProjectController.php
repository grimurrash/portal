<?php

namespace App\Http\Controllers\Activity;

use App\Contracts\OrganizationProject\OrganizationProjectServiceInterface;
use App\Dto\OrganizationProject\CreateOrganizationProjectDto;
use App\Dto\OrganizationProject\OrganizationProjectChangeLogItemDto;
use App\Dto\OrganizationProject\OrganizationProjectEventDto;
use App\Dto\OrganizationProject\OrganizationProjectListFilterDto;
use App\Enums\OrganizationProject\OrganizationProjectStatusEnum;
use App\Enums\SortOrderEnum;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\OrganizationProject\CreateOrganizationProjectRequest;
use App\Http\Requests\Activity\OrganizationProject\GetOrganizationProjectListRequest;
use App\Http\Requests\Activity\OrganizationProject\ModerateOrganizationProjectRequest;
use App\Http\Resources\Activity\OrganizationProject\OrganizationProjectEventResource;
use App\Http\Resources\Activity\OrganizationProject\OrganizationProjectInfoResource;
use App\Http\Resources\PaginateResource;
use App\Models\Activity\OrganizationProject;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class OrganizationProjectController extends Controller
{
    public function __construct(
        private readonly OrganizationProjectServiceInterface $organizationProjectService,
    )
    {
    }

    public function moderateList(GetOrganizationProjectListRequest $request): JsonResponse
    {
        $this->authorize('viewModerate', OrganizationProject::class);

        $filter = new OrganizationProjectListFilterDto(
            userId: Auth::id(),
            search: $request->get('search'),
            startDate: $request->date('start_date'),
            endDate: $request->date('end_date'),
            status: OrganizationProjectStatusEnum::MODERATION,
            perPage: $request->get('per_page', 10),
            page: $request->get('page', 1),
            sortColumn: $request->get('sort_column', 'id'),
            sortOrder: SortOrderEnum::from($request->get('sort_order', SortOrderEnum::DESC->value))
        );

        $list = $this->organizationProjectService->moderationList($filter);

        return response()->json(PaginateResource::make($list));
    }


    public function mainList(GetOrganizationProjectListRequest $request): JsonResponse
    {
        $this->authorize('viewList', OrganizationProject::class);

        $filter = new OrganizationProjectListFilterDto(
            userId: Auth::id(),
            search: $request->get('search'),
            startDate: $request->date('start_date'),
            endDate: $request->date('end_date'),
            status: $request->enum('status', OrganizationProjectStatusEnum::class),
            perPage: $request->get('per_page', 10),
            page: $request->get('page', 1),
            sortColumn: $request->get('sort_column', 'id'),
            sortOrder: SortOrderEnum::from($request->get('sort_order', SortOrderEnum::DESC->value))
        );

        $list = $this->organizationProjectService->list($filter);

        return response()->json(PaginateResource::make($list));
    }

    public function generalList(GetOrganizationProjectListRequest $request): JsonResponse
    {
        $this->authorize('viewGeneralList', OrganizationProject::class);

        $filter = new OrganizationProjectListFilterDto(
            userId: Auth::id(),
            search: $request->get('search'),
            startDate: $request->date('start_date'),
            endDate: $request->date('end_date'),
            status: $request->enum('status', OrganizationProjectStatusEnum::class),
            perPage: $request->get('per_page', 10),
            page: $request->get('page', 1),
            sortColumn: $request->get('sort_column', 'id'),
            sortOrder: SortOrderEnum::from($request->get('sort_order', SortOrderEnum::DESC->value))
        );

        $list = $this->organizationProjectService->generalList($filter);

        return response()->json(PaginateResource::make($list));
    }

    public function create(CreateOrganizationProjectRequest $request): JsonResponse
    {
        $this->authorize('create', OrganizationProject::class);

        $this->organizationProjectService->create(
            new CreateOrganizationProjectDto(
                number: $request->get('number'),
                name: $request->get('name'),
                description: $request->get('description'),
                startDate: $request->date('start_date'),
                endDate: $request->date('end_date'),
                dates: $request->get('dates', []),
                metrics: $request->get('metrics'),
                plannedCoverage: $request->get('planned_coverage'),
                actualCoverage: $request->get('actual_coverage'),
                responsibleUserId: $request->get('responsible_user_id'),
                curatorUserId: $request->get('curator_user_id'),
                organizerUserId: Auth::id()
            )
        );

        return response()->json();
    }

    public function sendForModeration(OrganizationProject $organizationProject): JsonResponse
    {
        $this->authorize('postForModeration', $organizationProject);

        /** @var User $user */
        $user = Auth::user();

        // TODO: Переместить потом в repository
        $organizationProject->status = OrganizationProjectStatusEnum::MODERATION;
        $organizationProject->logChange(
            new OrganizationProjectChangeLogItemDto(
                name: 'Отправка на модерацию',
                userId: $user->id,
                userName: $user->name,
                datetime: Carbon::now()
            )
        );
        $organizationProject->save();

        return response()->json();
    }

    /**
     * @throws BadRequestException
     */
    public function moderate(
        OrganizationProject                $organizationProject,
        ModerateOrganizationProjectRequest $request
    ): JsonResponse
    {
        $this->authorize('moderate', $organizationProject);

        /** @var User $user */
        $user = Auth::user();

        // TODO: Переместить потом в repository
        try {
            $organizationProject->logChange(new OrganizationProjectChangeLogItemDto(
                name: 'Редактирование при модерации',
                userId: $user->id,
                userName: $user->name,
                datetime: Carbon::now(),
                description: 'Изменение'
            ));
            OrganizationProject::query()
                ->where('id', $organizationProject->id)
                ->update([
                    'number' => $request->get('number'),
                    'name' => $request->get('name'),
                    'description' => $request->get('description'),
                    'start_date' => $request->date('start_date'),
                    'end_date' => $request->date('end_date'),
                    'dates' => $request->get('dates'),
                    'metrics' => $request->get('metrics'),
                    'planned_coverage' => $request->get('planned_coverage'),
                    'actual_coverage' => $request->get('actual_coverage'),
                    'responsible_user_id' => $request->get('responsible_user_id'),
                    'curator_user_id' => $request->get('curator_user_id'),
                    'organizer_user_id' => $request->get('curator_user_id'),
                    'change_logs' => $organizationProject->change_logs,
                ]);
        } catch (Throwable $exception) {
            throw new BadRequestException('Ошибка при модерации проекта', previous: $exception);
        }

        return response()->json();
    }

    public function approve(OrganizationProject $organizationProject): JsonResponse
    {
        $this->authorize('moderate', $organizationProject);

        /** @var User $user */
        $user = Auth::user();

        // TODO: Переместить потом в repository
        $organizationProject->status = OrganizationProjectStatusEnum::APPROVE;
        $organizationProject->logChange(
            new OrganizationProjectChangeLogItemDto(
                name: 'Прошел модерацию',
                userId: $user->id,
                userName: $user->name,
                datetime: Carbon::now()
            )
        );
        $organizationProject->save();

        return response()->json();
    }

    public function show(OrganizationProject $organizationProject): JsonResponse
    {
        $project = $organizationProject->toInfo();

        return response()->json(OrganizationProjectInfoResource::make($project));
    }

    public function calendar(Request $request): JsonResponse
    {
        $projects = OrganizationProject::all();

        $events = [];

        foreach ($projects as $project) {
            $events[] = new OrganizationProjectEventDto(
                id: 'p_' . $project->id,
                title: $project->name,
                startDate: $project->start_date->toDateString(),
                endDate: $project->end_date->toDateString(),
                projectId: $project->id,
                projectName: $project->name,
            );

            foreach ($project->dates as $index => $date) {
                $events[] = new OrganizationProjectEventDto(
                    id: 'p_' . $project->id . '_' . $index,
                    title: $date['name'],
                    startDate: $date['date'],
                    endDate: $date['date'],
                    projectId: $project->id,
                    projectName: $project->name,
                );
            }
        }

        return response()->json(OrganizationProjectEventResource::collection($events));
    }
}
