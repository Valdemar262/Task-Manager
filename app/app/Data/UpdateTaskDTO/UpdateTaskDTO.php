<?php

namespace App\Data\UpdateTaskDTO;

use App\Data\BaseDTO\BaseDTO;

class UpdateTaskDTO extends BaseDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public string $state,
    ) {
        parent::__construct();
    }
}
