<?php

namespace App\Enums\OrganizationProject;

enum OrganizationProjectStatusEnum: int
{
    case CANCEL = -1;
    case CREATE = 1;
    case MODERATION = 2;
    case APPROVE = 3;
    case FINISH = 4;
}
