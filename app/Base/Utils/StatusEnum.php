<?php

namespace App\Base\Utils;

enum StatusEnum: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
