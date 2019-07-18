<?php

namespace Rinjax\LaraImpersonator\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Rinjax\LaraImpersonator\Managers\ImpersonatorManager;

class ImpersonatorController extends Controller
{
    /**
     * Manager class to process logic
     * @var ImpersonatorManager
     */
    protected $Manager;

    /**
     * ImpersonatorController constructor.
     */
    public function __construct()
    {
     $this->Manager = new ImpersonatorManager();
    }
    /**
     * Set the impersonation flag in the session and the id of the user to be impersonated
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function impersonate(Request $request, $id)
    {
        if(!$this->Manager->allReadyImpersonating() && $this->Manager->canDoImpersonating($request, $id)) {

            $this->Manager->setImpersonating($id);
        }

        $this->Manager->flashMessagesToSession();

        return $this->Manager->returnUrl();
    }

    /**
     * Clear the impersonation flag from the session to stop impersonating.
     * @return mixed
     */
    public function clear()
    {
       return $this->Manager->clear()->returnUrl();
    }
}