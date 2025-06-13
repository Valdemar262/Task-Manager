<?php

namespace App\Data\GroupedTasksDTO;

use App\Data\BaseDTO\BaseDTO;
use Illuminate\Database\Eloquent\Collection;

class GroupedTasksDTO extends BaseDTO
{
    public function __construct(
        public Collection $todo,
        public Collection $inProgress,
        public Collection $completed,
    ) {
        parent::__construct();
    }
}
