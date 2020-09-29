<?php

namespace Vodeamanager\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vodeamanager\Core\Utilities\Traits\DefaultFormRequest;

class NumberSettingUpdateRequest extends FormRequest
{
    use DefaultFormRequest;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $this->entityNamespace = 'Vodeamanager\\Core\\Models\\';

        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }
}
