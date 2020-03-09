<?php

namespace Vodeamanager\Core\Utilities\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExceptionService
{
    public static function log($e) {
        $messages = [
            'timestamp' => now()->toDateTime(),
        ];

        if (method_exists($e, 'getFile')) $messages['file'] = $e->getFile();

        if (method_exists($e, 'getLine')) $messages['line'] = $e->getLine();

        if (method_exists($e, 'getMessage')) $messages['message'] = $e->getMessage();

        if (Auth::check()) $messages['auth'] = Auth::id();

        Log::error(json_encode($messages));
    }
}
