<?php

namespace App\System\Notifiers;

use Illuminate\Support\Collection;

abstract class BaseNotifier
{
    abstract public function notify(null|array|Collection $data = null): void;
}
