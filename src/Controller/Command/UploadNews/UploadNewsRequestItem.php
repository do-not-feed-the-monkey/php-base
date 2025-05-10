<?php

declare(strict_types=1);

namespace App\Controller\Command\UploadNews;

use Symfony\Component\Validator\Constraints as Assert;

class UploadNewsRequestItem
{
    public function __construct(
        #[Assert\NotBlank]
        public string $content,
        public ?string $title,
        #[Assert\DateTime]
        public string $publishedAt,
    ) {
    }
}
