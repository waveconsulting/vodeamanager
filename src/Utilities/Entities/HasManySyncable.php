<?php


namespace Smoothsystem\Core\Utilities\Entities;


use Illuminate\Database\Eloquent\Relations\HasMany;

class HasManySyncable extends HasMany
{
    public function sync($data, $deleting = true)
    {
        $changes = [
            'created' => [], 'deleted' => [], 'updated' => [],
        ];

        $relatedKeyName = $this->related->getKeyName();

        $current = $this->newQuery()->pluck(
            $relatedKeyName
        )->all();

        $updateRows = [];
        $newRows = [];
        foreach ($data as $row) {
            if (isset($row[$relatedKeyName]) && !empty($row[$relatedKeyName]) && in_array($row[$relatedKeyName], $current)) {
                $id = $row[$relatedKeyName];
                $updateRows[$id] = $row;
            } else {
                $newRows[] = $row;
            }
        }

        $updateIds = array_keys($updateRows);
        $deleteIds = [];
        foreach ($current as $currentId) {
            if (!in_array($currentId, $updateIds)) {
                $deleteIds[] = $currentId;
            }
        }

        if ($deleting && count($deleteIds) > 0) {
            $this->getRelated()->destroy($deleteIds);

            $changes['deleted'] = $this->castKeys($deleteIds);
        }

        foreach ($updateRows as $id => $row) {
            $this->getRelated()->where($relatedKeyName, $id)
                ->update($row);
        }

        $changes['updated'] = $this->castKeys($updateIds);

        $newIds = [];
        foreach ($newRows as $row) {
            $newModel = $this->create($row);
            $newIds[] = $newModel->$relatedKeyName;
        }

        $changes['created'][] = $this->castKeys($newIds);

        return $changes;
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