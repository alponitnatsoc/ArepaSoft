<?php

namespace AppBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RegistrationController extends BaseController
{
    public function registerAction(Request $request)
    {
        //Redirecting if user is already logged
        $authChecker = $this->container->get("security.authorization_checker");
        $router = $this->container->get("router");

        if($authChecker->isGranted('ROLE_ADMIN')){
            return new RedirectResponse($router->generate("admin_dashboard"),307);
        }
        return parent::registerAction($request); // TODO: Change the autogenerated stub
    }
}
