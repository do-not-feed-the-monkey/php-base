<?php

declare(strict_types=1);

namespace App\Shared;

use Symfony\Component\Uid\Uuid;

interface UuidGeneratorInterface
{
    public function generate(): Uuid;
}
