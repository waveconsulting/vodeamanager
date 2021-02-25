<?php

namespace Vodeamanager\Core\Utilities\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExceptionService
{
    /**
     * Handler logging exception to log
     *
     * @param $e
     * @return void
     */
    public function log($e) {
        $messages = [
            'timestamp' => Carbon::now()->toDateString(),
        ];

        if (method_exists($e, 'getFile')) {
            $messages['file'] = $e->getFile();
        }

        if (method_exists($e, 'getLine')) {
            $messages['line'] = $e->getLine();
        }

        if (method_exists($e, 'getMessage')) {
            $messages['message'] = $e->getMessage();
        }

        if (Auth::check()) {
            $messages['auth'] = Auth::id();
        }

        Log::error(json_encode($messages));
    }

    /**
     * Handler response from exception and save to log
     *
     * @param $e
     * @return JsonResponse
     */
    public function responseJson($e) {
        \Vodeamanager\Core\Utilities\Facades\ExceptionService::log($e);

        $statusCode = $e->status ?? $e->getCode();
        if (!in_array($statusCode, [400, 401, 404, 422])) {
            $statusCode = 500;
        }

        return response()->json([
            'error' => true,
            'message' => $e->getMessage()
        ], (int) $statusCode);
    }

    /**
     * Handler response from exception and save to log
     *
     * @param $e
     * @return RedirectResponse
     */
    public function response($e) {
        \Vodeamanager\Core\Utilities\Facades\ExceptionService::log($e);

        return redirect()->back()->withErrors([
            'message' => $e->getMessage()
        ]);
    }
}
