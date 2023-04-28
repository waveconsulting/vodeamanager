<?php

namespace Vodeamanager\Core\Utilities\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Vodeamanager\Core\Utilities\Constant;

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
     * @throws \Exception
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

                    if (!$this->isAllowedExtension($extension)){
                        throw new \Exception('Your file extension is blacklisted.');
                    }

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

            if (empty($uploaded)) {
                throw new \Exception('Whoops, Error in file when uploading to storage.');
            }

            return $uploaded;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Check if extension is allowed
     *
     * @param string $extension
     *
     * @return boolean
     */
    private function isAllowedExtension(string $extension): bool
    {
        return !in_array(
            $extension,
            array_merge(
                Constant::FILE_BLACKLIST_EXTENSION,
                array_map(function ($ext) {
                    return strtoupper($ext);
                },Constant::FILE_BLACKLIST_EXTENSION)
            )
        );
    }
}
