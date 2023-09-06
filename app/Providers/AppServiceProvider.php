<?php

namespace App\Providers;

use App\Contracts\Auth\AuthServiceInterface;
use App\Contracts\Department\DepartmentRepositoryInterface;
use App\Contracts\Department\DepartmentServiceInterface;
use App\Contracts\Employee\EmployeeRepositoryInterface;
use App\Contracts\Employee\EmployeeServiceInterface;
use App\Contracts\OrganizationProject\OrganizationProjectRepositoryInterface;
use App\Contracts\OrganizationProject\OrganizationProjectServiceInterface;
use App\Contracts\User\UserRepositoryInterface;
use App\Contracts\User\UserServiceInterface;
use App\Repositories\DepartmentRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\OrganizationProjectRepository;
use App\Repositories\UserRepository;
use App\Services\Activity\OrganizationProjectService;
use App\Services\AuthService;
use App\Services\Management\DepartmentService;
use App\Services\Management\EmployeeService;
use App\Services\Management\UserService;
use App\Support\Helper\FileHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);

        $this->app->bind(AuthServiceInterface::class, AuthService::class);

        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(DepartmentServiceInterface::class, DepartmentService::class);

        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(EmployeeServiceInterface::class, EmployeeService::class);

        $this->app->bind(OrganizationProjectRepositoryInterface::class, OrganizationProjectRepository::class);
        $this->app->bind(OrganizationProjectServiceInterface::class, OrganizationProjectService::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(FileHelper::getDirectories(__DIR__ . '/../../database/migrations'));
        Model::preventLazyLoading(!app()->isProduction());
    }
}
