<?php

namespace App\Enum;

enum UserRoleEnum: string
{
    case ADMIN = 'admin';
    case CHECKER = 'checker';
    case TECHNICAL_ADMIN = 'technical-admin';
    case GAS_OPERATOR = 'gas-operator';
}
