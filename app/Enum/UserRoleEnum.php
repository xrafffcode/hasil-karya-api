<?php

namespace App\Enum;

use App\Traits\EnumHelper;

enum UserRoleEnum: string
{
    use EnumHelper;

    case ADMIN = 'admin';
    case CHECKER = 'checker';
    case TECHNICAL_ADMIN = 'technical-admin';
    case GAS_OPERATOR = 'gas-operator';
}
