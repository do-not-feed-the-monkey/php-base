<?php

declare(strict_types=1);

namespace App\Shared;

use Symfony\Component\Uid\Uuid;

class UuidGenerator implements UuidGeneratorInterface
{
    public function generate(): Uuid
    {
        return Uuid::v4();
    }
}
