<?php

declare(strict_types=1);

namespace App\Model;

class Avatar extends Model
{
    use TraitInstance;

    protected $tableName = APP_TABLE_PREFIX . 'etud';
}