<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

abstract class AbstractService {
    protected function beginTransaction()
    {
        DB::beginTransaction();
    }
    protected function commitTransaction()
    {
        DB::commit();
    }
    protected function rollbackTransaction()
    {
        DB::rollBack();
    }
}
