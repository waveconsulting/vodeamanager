<?php

namespace Vodeamanager\Core\Utilities\Services;

use Illuminate\Support\Facades\Log;

class ExceptionService
{
    public static function log(\Exception $e) {
        Log::error(json_encode([
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'message' => $e->getMessage(),
            'timestamp' => now()->toDateTime(),
        ]));
    }
}
