<?php

namespace App\Data\CreateTaskDTO;

use App\Data\BaseDTO\BaseDTO;

class CreateTaskDTO extends BaseDTO
{
    public function __construct(
        public string $title,
        public string $description,
        public string $state,
    ) {
        parent::__construct();
    }
}
