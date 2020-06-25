<?php

namespace Vodeamanager\Core\Entities;

use Illuminate\Support\Facades\Storage;
use Vodeamanager\Core\Rules\ValidInConstant;
use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class FileLog extends BaseEntity
{
    protected $fillable = [
        'name',
        'encoded_name',
        'size',
        'extension',
        'path',
        'disk',
    ];

    protected $validationRules = [
        'path' => 'required|string',
    ];

    public function getUrlAttribute()
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function setValidationRules(array $request = [], $id = null)
    {
        $this->validationRules['disk'] = [
            'required',
            new ValidInConstant(array_keys(config('filesystems.disks', []))),
        ];

        $fileRules = ['required'];

        $mimes = @$request['mimes'] ?? [];
        if (!empty($mimes)) {
            $fileRules[] = 'mimes:' . (is_array($mimes) ? implode($mimes,',') : $mimes);
        }

        if ($maxSize = @$request['max_size']) {
            $fileRules[] = 'max:' . $maxSize;
        }

        $this->validationRules['file'] = $fileRules;

        return $this;
    }

}
