<?php

namespace App\Modules\Uploads\Enums;

enum UploadVisibility: string
{
    case Public = 'public';
    case Private = 'private';
}
