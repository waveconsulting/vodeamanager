<?php

namespace Vodeamanager\Core\Utilities\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class FileService
{
    /**
     * File service for handle store to storage
     *
     * @param Request $request
     * @param string $key
     * @param string $disk
     * @param string $path
     *
     * @return array
     */
    public function store(Request $request, string $key, string $disk, string $path) {
        try {
            $uploaded = [];

            if ($request->hasFile($key)) {
                $files = $request->file($key);
                if (!is_array($files)) {
                    $files = [$files];
                }

                foreach ($files as $file) {
                    $fileName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $encodedName = Carbon::now()->format('Y_m_d_his_') . Str::random();
                    if ($extension) {
                        $encodedName .= '.' . $extension;
                    }

                    array_push($uploaded, (object) [
                        'name' => $fileName,
                        'encoded_name' => $encodedName,
                        'size' => $file->getSize(),
                        'extension' => $extension,
                        'path' => $file->storeAs($path,$encodedName,['disk' => $disk]),
                        'disk' => $disk,
                    ]);
                }
            }

            return $uploaded;
        } catch (\Exception $e) {
            \Vodeamanager\Core\Utilities\Facades\ExceptionService::log($e);

            return [];
        }
    }
}
