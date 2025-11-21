<?php

namespace App\Policies;


class PemasukanPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'pemasukan';
    }

}
