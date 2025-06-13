<?php

namespace App\Data\AllTasksDTO;

use App\Data\BaseDTO\BaseDTO;
use Illuminate\Database\Eloquent\Collection;

class AllTasksDTO extends BaseDTO
{
    public function __construct(
        public Collection $allTasks,
    ) {
        parent::__construct();
    }
}
