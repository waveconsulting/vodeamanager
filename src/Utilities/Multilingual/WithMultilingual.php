<?php

namespace Vodeamanager\Core\Utilities\Multilingual;

trait WithMultilingual
{
    /**
     * @return array
     */
    public function getMultilingualAttributes() : array
    {
        return $this->multilingualAttributes ?? [];
    }

    /**
     * @return array
     */
    public function getCasts()
    {
        $attributes = array_reduce($this->getMultilingualAttributes(), function ($result, $item) {
            $result[$item] = 'array';
            return $result;
        }, []);

        return array_merge(parent::getCasts(), $attributes);
    }
}
