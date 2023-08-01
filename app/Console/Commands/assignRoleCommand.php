<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class assignRoleCommand extends Command
{
    protected $signature = 'permissions:assign-role { email : Электронная почта } { role : Роль}';

    protected $description = 'Назначить роль пользователю';

    public function handle(): void
    {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();

        if (is_null($user)) {
            $this->error('Пользователь не найден!');
        }

        $role = $this->argument('role');

        $user->assignRole($role);

        $this->info('Роль выдана!');
    }
}
