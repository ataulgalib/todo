<?php

namespace App\Observers;

use App\Models\Core\Role;

class RoleObserver
{
    /**
     * Handle the Role "created" event.
     *
     * @param  \App\Models\Core\Role  $role
     * @return void
     */
    public function created(Role $role)
    {
        if(hasCache(Role::ROLE_CACHE_KEY)){
            flushCache(Role::ROLE_CACHE_KEY);
            $role->cacheQuery();
        }
    }

    /**
     * Handle the Role "updated" event.
     *
     * @param  \App\Models\Core\Role  $role
     * @return void
     */
    public function updated(Role $role)
    {
        if(hasCache(Role::ROLE_CACHE_KEY)){
            flushCache(Role::ROLE_CACHE_KEY);
            $role->cacheQuery();
        }
    }

    /**
     * Handle the Role "deleted" event.
     *
     * @param  \App\Models\Core\Role  $role
     * @return void
     */
    public function deleted(Role $role)
    {
        if(hasCache(Role::ROLE_CACHE_KEY)){
            flushCache(Role::ROLE_CACHE_KEY);
            $role->cacheQuery();
        }
    }

    /**
     * Handle the Role "restored" event.
     *
     * @param  \App\Models\Core\Role  $role
     * @return void
     */
    public function restored(Role $role)
    {
        if(hasCache(Role::ROLE_CACHE_KEY)){
            flushCache(Role::ROLE_CACHE_KEY);
            $role->cacheQuery();
        }
    }

    /**
     * Handle the Role "force deleted" event.
     *
     * @param  \App\Models\Core\Role  $role
     * @return void
     */
    public function forceDeleted(Role $role)
    {
        if(hasCache(Role::ROLE_CACHE_KEY)){
            flushCache(Role::ROLE_CACHE_KEY);
            $role->cacheQuery();
        }
    }

}
