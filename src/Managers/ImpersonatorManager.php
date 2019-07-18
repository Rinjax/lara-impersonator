<?php

namespace Rinjax\LaraImpersonator\Managers;

use Illuminate\Http\Request;

class ImpersonatorManager
{
    /**
     * Setting from the impersonator config file
     * @var
     */
    protected $settings;

    /**
     * Array of error messages when validating if the impersonation can be done.
     * @var array
     */
    protected $errors = [];

    /**
     * Array of success messages if impersonation is successful
     * @var array
     */
    protected $success = [];


    public function __construct()
    {
        $this->settings = config('impersonator');
    }

    /**
     * Check to see if the session is already impersonating a user
     * @return bool
     */
    public function allReadyImpersonating()
    {
        if(session()->has('impersonate')){

            $this->addErrorMessage('You are already impersonating');

            return true;
        }else{
            return false;
        }
    }

    /**
     * Check if the request is valid for implementing the impersonation
     * @param Request $request
     * @param $id
     * @return bool
     */
    public function canDoImpersonating(Request $request, $id)
    {
        if($this->settings['everyone_can_impersonate'] && $this->settings['everyone_can_be_impersonated']) return true;

        return ($this->checkImpersonatee($id) && $this->checkImpersonator($request));

    }

    /**
     * Check if the requesting user has the ability to impersonate another user.
     * @param Request $request
     * @return bool
     */
    public function checkImpersonator(Request $request)
    {
        if($this->settings['everyone_can_impersonate']) return true;


        if($request->user()->canImpersonate()){
            return true;

        }else{
            $this->addErrorMessage('You dont have the ability to impersonate other users');

            return false;
        }
    }

    /**
     * Check if the user to be impersonated, is allowed to be impersonated
     * @param $target_user_id
     * @return bool
     */
    public function checkImpersonatee($target_user_id)
    {
        if($this->settings['everyone_can_be_impersonated']) return true;

        $targetUser = $this->getImpersonateTargetUser($target_user_id);

        if($targetUser && $targetUser->canBeImpersonated()) return true;

        if($targetUser) $this->addErrorMessage('The user ' . $targetUser->name . ' cannot be impersonated');

        return false;

    }

    /**
     * Set the session to impersonate and other user.
     * @param $target_user_id
     * @return $this
     */
    public function setImpersonating($target_user_id)
    {
        session()->put('impersonate', $target_user_id);

        $this->addSuccessMessage('Impersonation successful');

        return $this;
    }

    /**
     * Clear the impersonation from the session.
     * @return mixed
     */
    public function clear()
    {
        session()->forget('impersonate');

        session()->flash('success', 'Returned to your normal account');

        return $this;
    }

    /**
     * Retrieve the targeted user to be impersonated.
     * @param $target_user_id
     * @return mixed
     */
    public function getImpersonateTargetUser($target_user_id)
    {
        $targetUser =  $this->settings['user_model']::find($target_user_id);

        if(!$targetUser){
            $this->addErrorMessage('The user Id:' . $target_user_id . ' could not be found!');
        }

        return $targetUser;
    }

    /**
     * Flash the error and success messages into the session, depending on if the config setting is true or false.
     * @return $this
     */
    public function flashMessagesToSession()
    {
        if($this->settings['session_messages']){
            if(!empty($this->errors)) session()->flash('error', implode(', ',$this->errors));

            if(!empty($this->success)) session()->flash('success', implode(', ',$this->success));
        }

        return $this;
    }

    /**
     * Return the url to be directed to, after setting or clearing the impersonating ability.
     * @return mixed
     */
    public function returnUrl()
    {
        if($this->settings['return_path'] == 'default'){
            return back();
        }else{
            return redirect()->route($this->settings['return_path']);
        }
    }

    /**
     * Push error messages to the errors array.
     * @param $message
     */
    protected function addErrorMessage($message)
    {
        array_push($this->errors, $message);
    }

    /**
     * Push success message to the success array.
     * @param $message
     */
    protected function addSuccessMessage($message)
    {
        array_push($this->success, $message);
    }
}