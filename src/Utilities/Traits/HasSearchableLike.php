<?php

namespace Vodeamanager\Core\Utilities\Traits;

trait HasSearchableLike
{
    protected $searchableLikeColumn = [];

    public function getSearchableColumn(): array
    {
        return $this->searchableLikeColumn;
    }
}