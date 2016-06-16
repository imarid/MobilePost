<?php

namespace AppBundle\Controller;

use AppBundle\Exception\InvalidFormException;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends FOSRestController
{
    public function postTaskAction(Request $request)
    {
        try {
            $new = $this->container
                ->get('pai_rest.task.form')
                ->post($request->request->all());
            //$routeOptions = array(
            //    'id' => $new->getId(),
            //    '_format' => $request->get('_format')
            //);
            //$view = $this->routeRedirectView('api_1_get_parcelorder', $routeOptions);
            $view = $this->view($new, 200);
        }
        catch (InvalidFormException $exception)
        {
            $view = $this->view(array('form' => $exception->getForm()), 400);
        }
        return $this->handleView($view);
    }
}
