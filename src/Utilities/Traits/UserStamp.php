<?php

namespace Smoothsystem\Core\Utilities\Traits;

use Smoothsystem\Core\Utilities\UserStampScope;

trait UserStamp
{
    /**
     * Whether we're currently maintaing userstamps.
     *
     * @param bool
     */
    protected $userStamping = true;

    /**
     * Boot the userstamps trait for a model.
     *
     * @return void
     */
    public static function bootUserStamp()
    {
        static::addGlobalScope(new UserStampScope);

        static::registerListeners();
    }

    /**
     * Register events we need to listen for.
     *
     * @return void
     */
    public static function registerListeners()
    {
        static::creating('Smoothsystem\Core\Listeners\Creating@handle');
        static::updating('Smoothsystem\Core\Listeners\Updating@handle');

        if (static::usingSoftDeletes()) {
            static::deleting('Smoothsystem\Core\Listeners\Deleting@handle');
            static::restoring('Smoothsystem\Core\Listeners\Restoring@handle');
        }
    }

    /**
     * Has the model loaded the SoftDeletes trait.
     *
     * @return bool
     */
    public static function usingSoftDeletes()
    {
        static $usingSoftDeletes;

        if (is_null($usingSoftDeletes)) {
            return $usingSoftDeletes = in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive(get_called_class()));
        }

        return $usingSoftDeletes;
    }

    /**
     * Get the user that created the model.
     */
    public function creator()
    {
        return $this->belongsTo(config('smoothsystem.models.user'), $this->getCreatedByColumn());
    }

    /**
     * Get the user that edited the model.
     */
    public function editor()
    {
        return $this->belongsTo(config('smoothsystem.models.user'), $this->getUpdatedByColumn());
    }

    /**
     * Get the user that deleted the model.
     */
    public function destroyer()
    {
        return $this->belongsTo(config('smoothsystem.models.user'), $this->getDeletedByColumn());
    }

    /**
     * Get the name of the "created by" column.
     *
     * @return string
     */
    public function getCreatedByColumn()
    {
        return defined('static::CREATED_BY') && ! is_null(static::CREATED_BY) ? static::CREATED_BY : 'created_by';
    }

    /**
     * Get the name of the "updated by" column.
     *
     * @return string
     */
    public function getUpdatedByColumn()
    {
        return defined('static::UPDATED_BY') && ! is_null(static::UPDATED_BY) ? static::UPDATED_BY : 'updated_by';
    }

    /**
     * Get the name of the "deleted by" column.
     *
     * @return string
     */
    public function getDeletedByColumn()
    {
        return defined('static::DELETED_BY') && ! is_null(static::DELETED_BY) ? static::DELETED_BY : 'deleted_by';
    }

    /**
     * Check if we're maintaing Userstamps on the model.
     *
     * @return bool
     */
    public function isUserStamping()
    {
        return $this->userStamping;
    }

    /**
     * Stop maintaining Userstamps on the model.
     *
     * @return void
     */
    public function stopUserStamping()
    {
        $this->userStamping = false;
    }

    /**
     * Start maintaining Userstamps on the model.
     *
     * @return void
     */
    public function startUserStamping()
    {
        $this->userStamping = true;
    }
}
