<?php

return [
    /*
    |----------------------------------------------------------------
    | Define Route Middleware
    |----------------------------------------------------------------
    |
    | Define what middlewares will be applied to the routes for setting and clearing impersonation. Needs 'web' for the
    | session.
    |
    */
    'route_middleware' => ['web'],


   /*
   |----------------------------------------------------------------
   | Register Routes
   |----------------------------------------------------------------
   |
   | If false, the routes for setting and clearing impersonation wont be registered with the laravel framework. However,
   | the middleware that actions the impersonating will still run. Useful for multi instance setup of laravel where you
   | might want the routes active in the admin instance only.
   |
   */
    'register_routes' => false,


    /*
    |----------------------------------------------------------------
    | Set Everyone to impersonate
    |----------------------------------------------------------------
    |
    | if set to true, everyone will have the ability to impersonate. If set false, your user model must implement the
    | UserImpersonator interface and whatever logic you define for the functions will be used.
    |
    */
    'everyone_can_impersonate' => false,


    /*
    |----------------------------------------------------------------
    | Set Everyone to be impersonated
    |----------------------------------------------------------------
    |
    | If set true everyone will be able to be impersonated, including admin accounts.  If set false, your user model must
    | implement the UserImpersonator interface and whatever logic you define for the functions will be used.
    |
    */
    'everyone_can_be_impersonated' => false,


    /*
    |----------------------------------------------------------------
    | Define User model class
    |----------------------------------------------------------------
    |
    | set the class that the app uses for the User model
    |
    */
    'user_model' => 'App\User',


    /*
     |---------------------------------------------------------------
     | Define the return path once impersonating
     |---------------------------------------------------------------
     | After successfully setting impersonating another user, the path to redirect back to as the new user. Also used once
     | impersonating is cleared. This needs to be the route name. If left default, the request will be directed back to
     | where it came from.
     |
     */
    'return_path' => 'default',

    /*
     |---------------------------------------------------------------
     | Flash session messages
     |---------------------------------------------------------------
     | If set true, success and error messages will be flashed into the session
     |
     */
    'session_messages' => true,
];