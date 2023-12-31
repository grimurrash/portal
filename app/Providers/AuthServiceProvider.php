<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Activity\OrganizationProject;
use App\Models\Management\Department;
use App\Models\Management\Employee;
use App\Models\User;
use App\Policies\DepartmentPolicy;
use App\Policies\EmployeePolicy;
use App\Policies\OrganizationProjectPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Department::class => DepartmentPolicy::class,
        Employee::class => EmployeePolicy::class,
        User::class => UserPolicy::class,
        OrganizationProject::class => OrganizationProjectPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
