<?php

namespace App\Http\Enums;

enum ServiceOrderStatusEnum: string
{
    case OPEN = 'Aberta';
    case IN_PROGRESS = 'Em andamento';
    case COMPLETED = 'Finalizada';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
