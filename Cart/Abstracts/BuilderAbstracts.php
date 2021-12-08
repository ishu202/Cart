<?php

namespace Cart\Abstracts;

use Cart\Traits\ValidItem;
use Ramsey\Uuid\Uuid;

abstract class BuilderAbstracts
{
    use ValidItem;
    protected \stdClass $data;

    public function get_hash(): string
    {
        return Uuid::uuid4();
    }
}