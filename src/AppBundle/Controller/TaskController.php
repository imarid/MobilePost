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
        // TODO: This is provisory implementation, needs rewrite by whoever
        // was selected to do that
        $doctrine = $this->getDoctrine();
        $task = new \AppBundle\Entity\Task();
        $task->setPostman($doctrine->getRepository('AppBundle:Postman')->find($request->request->get('postman')));
        $task->setParcelOrder($doctrine->getRepository('AppBundle:ParcelOrder')->find($request->request->get('parcelOrder')));
        $em = $doctrine->getManager();
        $em->persist($task);
        $em->flush();
        $view = $this->view(true, 200);
        return $this->handleView($view);
    }
}
