<?php

namespace Vodeamanager\Core\Utilities\Traits;

trait WithSearchableLike
{
    protected $searchableLikeColumn = [];

    public function getSearchableColumn(): array
    {
        return $this->searchableLikeColumn;
    }
}