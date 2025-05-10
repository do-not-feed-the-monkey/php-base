<?php

declare(strict_types=1);

namespace App\Controller\Query\GetEvent;

use App\Entity\News;

interface GetEventResponseNewsFactoryInterface
{
    public function create(News $news): GetEventResponseNewsItem;
}
