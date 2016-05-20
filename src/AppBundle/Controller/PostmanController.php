<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PostmanController extends FOSRestController
{
    public function getPostmansAction()
    {
        $data = $this->getDoctrine()->getRepository('AppBundle\Entity\Postman')->findAll();
        $view = $this->view($data, 200);
        return $this->handleView($view);
    }
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function getAddpostmanAction()
    {
        $postman=new \AppBundle\Entity\Postman();
        $form=$this->createForm("AppBundle\Form\PostmanType",$postman);
        return $this->render("AppBundle:Postman\add.html.twig",array("form"=>$form->createView()));
    }
    
    public function postAddpostmanAction(Request $request)
    {
        $postman=new \AppBundle\Entity\Postman();
        $form=$this->createForm("AppBundle\Form\PostmanType",$postman);
        $form->handleRequest($request);
        if ($form->isValid())
        {
         $em = $this->getDoctrine()->getManager();
         $em->persist($postman);
         $em->flush();
        }
        return $this->render("AppBundle:Postman\add.html.twig",array("form"=>$form->createView()));
    }
}
