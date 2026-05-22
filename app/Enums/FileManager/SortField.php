<?php

namespace App\Enums\FileManager;

enum SortField: string
{
    case Name = 'name';
    case Size = 'size';
    case Date = 'date';
    case Type = 'type';
}