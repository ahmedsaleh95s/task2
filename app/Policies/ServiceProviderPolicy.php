<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\Admin;
use App\Models\ServiceProvider;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceProviderPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        return $user->hasRole('SuperAdmin');
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceProvider  $serviceProvider
     * @return mixed
     */
    public function view(User $user, ServiceProvider $serviceProvider)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceProvider  $serviceProvider
     * @return mixed
     */
    public function update(User $user, ServiceProvider $serviceProvider)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceProvider  $serviceProvider
     * @return mixed
     */
    public function delete(User $user, ServiceProvider $serviceProvider)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceProvider  $serviceProvider
     * @return mixed
     */
    public function restore(User $user, ServiceProvider $serviceProvider)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceProvider  $serviceProvider
     * @return mixed
     */
    public function forceDelete(User $user, ServiceProvider $serviceProvider)
    {
        //
    }
}
