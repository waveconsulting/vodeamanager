<?php

namespace Vodeamanager\Core\Utilities\Encryptable;

trait WithEncryptable
{
    public function getEncryptableAttributes()
    {
        return $this->encryptableAttributes ?? [];
    }

    /**
     * If the attribute is in the encryptable array
     * then decrypt it.
     *
     * @param  $key
     *
     * @return $value
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if (in_array($key, $this->getEncryptableAttributes()) && $value !== '') {
            $value = decrypt($value);
        }

        return $value;
    }
    /**
     * If the attribute is in the encryptable array
     * then encrypt it.
     *
     * @param $key
     * @param $value
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->getEncryptableAttributes())) {
            $value = encrypt($value);
        }
        return parent::setAttribute($key, $value);
    }
    /**
     * When need to make sure that we iterate through
     * all the keys.
     *
     * @return array
     */
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();
        foreach ($this->getEncryptableAttributes() as $key) {
            if (isset($attributes[$key])) {
                $attributes[$key] = decrypt($attributes[$key]);
            }
        }

        return $attributes;
    }
}
