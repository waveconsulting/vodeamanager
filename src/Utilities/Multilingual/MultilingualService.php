<?php

namespace Vodeamanager\Core\Utilities\Multilingual;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MultilingualService
{
    /**
     * @param Request $request
     * @param Multilingual $repository
     * @return void
     */
    public static function transformRequest(Request &$request, Multilingual $repository) : void
    {
        $appends = [];

        $currentValues = $repository->toArray();
        $multilingualAttributes = $repository->getMultilingualAttributes();
        foreach ($multilingualAttributes as $multilingualAttribute) {
            $value = $currentValues[$multilingualAttribute] ?? [];
            $value[static::getCurrentLanguage()] = $request->get($multilingualAttribute);
            $appends[$multilingualAttribute] = $value;
        }

        $request->merge($appends);
    }


    /**
     * @param array $array
     * @param Multilingual $repository
     * @return void
     */
    public static function transformArray(&$array, Multilingual $repository) : void
    {
        $currentValues = $repository->toArray();
        $multilingualAttributes = $repository->getMultilingualAttributes();
        foreach ($multilingualAttributes as $multilingualAttribute) {
            $value = $currentValues[$multilingualAttribute] ?? [];
            $value[static::getCurrentLanguage()] = Arr::get($array, $multilingualAttribute);
            $array[$multilingualAttribute] = $value;
        }
    }

    public static function getCurrentLanguage()
    {
        return app()->getLocale();
    }
}
