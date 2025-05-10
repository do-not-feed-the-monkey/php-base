<?php

declare(strict_types=1);

namespace App\Controller\Command\UploadNews;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class UploadNewsRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('array')]
        #[Assert\All([
            new Assert\Type(type: UploadNewsRequestItem::class),
        ])]
        #[Assert\Valid]
        /** @var UploadNewsRequestItem[] */
        public array $news
    ) {
    }
}
