<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends FOSRestController
{
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function getMeAction(){
	$data = $this->get('security.token_storage')->getToken()->getUser();
        //$data = $this->getDoctrine()->getRepository('AppBundle\Entity\ParcelOrder')->findAll();
        $view = $this->view($data, 200);
        return $this->handleView($view);
    }
	
    // by Kamil Rodzik
    public function getPostmantasksAction($postmanId){
        $taskRepository = $this->getDoctrine()->getRepository('AppBundle:Task');
        $tasks = $taskRepository->findByPostman($postmanId);
        $view = $this->view($tasks, 200);
        return $this->handleView($view);
    }
}
