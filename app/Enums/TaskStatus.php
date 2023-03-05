<?php

namespace App\Enums;

enum TaskStatus: int
{
    case COMPLETE = 1;
    case INCOMPLETE = 0;
}
