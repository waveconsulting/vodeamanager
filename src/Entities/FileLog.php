<?php

namespace Vodeamanager\Core\Entities;

use Illuminate\Support\Facades\Storage;
use Vodeamanager\Core\Http\Resources\FileLogResource;
use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class FileLog extends BaseEntity
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->indexResource = $this->showResource = $this->selectResource = FileLogResource::class;
    }

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
            'in:' . implode(array_keys(config('filesystems.disks', [])), ',')
        ];

        $fileRules = ['required'];

        $mimes = arr_get($request, 'mimes', []);
        if (is_array($mimes) && !empty($mimes)) $fileRules[] = 'mimes:' . implode($mimes,',');

        $maxSize = arr_get($request, 'max_size', null);
        if ($maxSize) $fileRules[] = 'max:' . $maxSize;

        $this->validationRules['file'] = $fileRules;

        return $this;
    }

    public function setValidationMessages(array $request = [])
    {
        $this->validationMessages['disk.in'] = 'The selected :attribute must be in ' . implode(array_keys(config('filesystems.disks', [])), ', ');

        return $this;
    }

}
