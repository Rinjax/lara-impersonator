<?php

namespace Rinjax\LaraImpersonator\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImpersonatorController extends Controller
{
    /**
     * Set the impersonation flag in the session and the id of the user to be impersonated
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function impersonate(Request $request, $id)
    {
        if(session()->has('impersonate')){

            session()->flash('error', 'You are already impersonating');

        }elseif($request->user()->canImpersonate()){

            session()->put('impersonate', $id);

            session()->flash('success', 'now in impersonating mode');

            return back();
        }
    }

    /**
     * Clear the impersonation flag from the session to stop impersonating.
     * @return mixed
     */
    public function clear()
    {
        session()->forget('impersonate');

        session()->put('success', 'Returned to your normal account');

        return back();
    }
}