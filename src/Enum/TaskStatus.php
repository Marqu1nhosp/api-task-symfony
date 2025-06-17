<?php

namespace App\Enum;

enum TaskStatus: string
{
    case INACTIVE = 'INACTIVE';
    case ACTIVE = 'ACTIVE';
    case IN_PROGRESS = 'IN_PROGRESS';
    case COMPLETED = 'COMPLETED';

    
}
