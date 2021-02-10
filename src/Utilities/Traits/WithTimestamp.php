<?php

namespace Vodeamanager\Core\Utilities\Traits;

trait WithTimestamp
{
    protected $withTimestamp = false;
    protected $timestampColumns = ['created_at', 'updated_at'];

    public function getWithTimestamp()
    {
        return $this->withTimestamp;
    }

    public function getTimestampColumns()
    {
        return $this->timestampColumns;
    }
}
