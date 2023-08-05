<?php

namespace App\Enums\Employee;

enum GenderEnum: string
{
    case MALE = 'male';
    case FEMALE = 'female';

    public static function selfByImportString(string $gender): self {
        return match ($gender) {
            'Женский' => self::FEMALE,
            default => self::MALE
        };
    }
}
