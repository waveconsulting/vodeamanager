<?php

namespace Vodeamanager\Core\Utilities\Multilingual;

/**
 * @property array $multilingualAttributes
 */
interface Multilingual
{
    /**
     * Get multilingual attributes
     *
     * @return array
     */
    public function getMultilingualAttributes();

    /**
     * Add multilanguage attribute to casts
     *
     * @return array
     */
    public function getCasts();
}
