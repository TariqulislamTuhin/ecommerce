<?php

namespace App\Enum;

enum Permission: string
{
    case ADMIN       = "ADMIN";
    case TEACHER     = "TEACHER";
    case STUDENT     = "STUDENT";
    case SUPER_ADMIN = "SUPER_ADMIN";
}
