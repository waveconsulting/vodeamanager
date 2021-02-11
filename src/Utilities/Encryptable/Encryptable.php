<?php

namespace Vodeamanager\Core\Utilities\Encryptable;

/**
 * @property array $encryptableAttributes
 */
interface Encryptable
{
    /**
     * Get encryptable attributes
     *
     * @return array
     */
    public function getEncryptableAttributes();

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key);

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setAttribute($key, $value);

    /**
     * Convert the model's attributes to an array.
     *
     * @return array
     */
    public function attributesToArray();
}
