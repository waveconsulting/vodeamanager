<?php

namespace Vodeamanager\Core\Utilities\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;

class HasManySyncable extends HasMany
{
    public function sync($data, $checkFillAble = true, $deleting = true)
    {
        $changes = [
            'created' => [],
            'deleted' => [],
            'updated' => [],
        ];

        $relatedKeyName = $this->related->getKeyName();
        $tobeDeleteIds = array_column($data, $relatedKeyName);
        $toBeDeletes = (clone $this->newQuery())
            ->whereNotIn(
                $relatedKeyName,
                array_column($data, $relatedKeyName)
            )
            ->get();

        foreach ($toBeDeletes as $toBeDelete) {
            $changes['deleted'][] = $toBeDelete->$relatedKeyName;
            $toBeDelete->delete();
        }

        foreach ($data as $item) {
            if ($checkFillAble) {
                $updatedData = Arr::only($item, $this->getRelated()->getFillable());
            } else {
                $updatedData = $item;
            }

            $keyValue = $item[$relatedKeyName] ?? null;

            if (empty($keyValue)) {
                $item = (clone $this->newQuery())->create($updatedData);
                $changes['created'][] = $item->$relatedKeyName;
            } else {
                $item = (clone $this->newQuery())->updateOrCreate([
                    $relatedKeyName => $item[$relatedKeyName]
                ], $updatedData);
            }

            if ($item->$relatedKeyName == $keyValue) {
                $changes['updated'][] = $keyValue;
            } else {
                $changes['created'][] = $item->$relatedKeyName;
            }
        }
    }


    /**
     * Cast the given keys to integers if they are numeric and string otherwise.
     *
     * @param  array  $keys
     * @return array
     */
    protected function castKeys(array $keys)
    {
        return (array) array_map(function ($v) {
            return $this->castKey($v);
        }, $keys);
    }

    /**
     * Cast the given key to an integer if it is numeric.
     *
     * @param  mixed  $key
     * @return mixed
     */
    protected function castKey($key)
    {
        return is_numeric($key) ? (int) $key : (string) $key;
    }
}
