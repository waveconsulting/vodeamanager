<?php

namespace Vodeamanager\Core\Utilities\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class FileService
{
    public function store(Request $request, $key, $disk, $path) {
        if ($request->hasFile($key)) {
            $uploaded = [];

            try {
                $files = $request->file($key);
                if (is_array($files)) {
                    foreach (   $files as $file) {
                        $fileName = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $encodedName = Carbon::now()->format('Y_m_d_his_') . Str::random() . '.' . $extension;

                        $file->storeAs($path,$encodedName,['disk' => $disk]);

                        array_push($uploaded, (object) [
                            'real_name' => $fileName,
                            'encoded_name' => $encodedName,
                            'path' => "$path/$encodedName",
                            'disk' => $disk,
                        ]);
                    }
                } else {
                    $fileName = $files->getClientOriginalName();
                    $extension = $files->getClientOriginalExtension();
                    $encodedName = Carbon::now()->format('Y_m_d_his_') . Str::random() . '.' . $extension;

                    $files->storeAs($path,$encodedName,['disk' => $disk]);

                    array_push($uploaded, (object) [
                        'real_name' => $fileName,
                        'encoded_name' => $encodedName,
                        'path' => "$path/$encodedName",
                        'disk' => $disk,
                    ]);
                }

            } catch (\Exception $e) {
                \Vodeamanager\Core\Utilities\Facades\ExceptionService::log($e);
            }

            return $uploaded;
        }

        return [];
    }
}
