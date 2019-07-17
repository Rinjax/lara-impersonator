<?php

/*
 * The User model needs to implement this interface. You are then free to define how your application validates if users
 * can impersonate, and if they can be impersonated. For instance, you may wish to add bool columns to your users table,
 * or you may want to use permissions/roles based system.
 */

namespace Rinjax\LaraImpersonator\Interfaces;

interface UserImpersonation
{
    /**
     * Function to check that the user model can (is allowed to) impersonate another user. (Probably dont want everyone to have this ability)
     * @return mixed
     */
    public function canImpersonate();

    /**
     * Function to check if a user is allowed to be impersonated. (you might not want your admin accounts to be impersonated)
     * @return mixed
     */
    public function canBeImpersonated();

}