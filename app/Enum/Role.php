<?php

namespace App\Enum;

enum Role: string
{
    case ADMIN       = "ADMIN";
    case TEACHER     = "TEACHER";
    case STUDENT     = "STUDENT";
    case SUPER_ADMIN = "SUPER_ADMIN";
}
