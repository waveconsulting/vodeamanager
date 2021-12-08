<?php

namespace Vodeamanager\Core\Contracts;

interface WithSearchableLike
{
    /**
     * @return array
     */
    public function getSearchableColumn(): array;
}