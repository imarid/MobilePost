<?php

namespace AppBundle\Controller;

use AppBundle\Exception\InvalidFormException;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class ParcelOrderController extends FOSRestController 
{
    public function getParcelorderAction($id){
        $data = $this->getDoctrine()->getRepository('AppBundle\Entity\ParcelOrder')->findOneById($id);
        $view = $this->view($data, 200);
        return $this->handleView($view);
    }

    public function postParcelorderAction(Request $request)
    {
        try {
            $new = $this->container
                ->get('pai_rest.parcelorder.form')
                ->post($request->request->all());
            $routeOptions = array(
                'id' => $new->getId(),
                '_format' => $request->get('_format')
            );
            $view = $this->routeRedirectView('api_1_get_parcelorder', $routeOptions);
        }
        catch (InvalidFormException $exception)
        {
            $view = $this->view(array('form' => $exception->getForm()), 400);
        }
        return $this->handleView($view);
    }
	
	/**
	*deleteParcelorderAction - implemented by Och Tomasz
	*
	*/
	public function deleteParcelorderAction(Request $request, $id) 
	{ 
		var_dump($request);
		$parcel = $this->getDoctrine()->getRepository('PAIParcelBundle:Parcelorder')->find($id);
		if ($parcel)
		{
			$this->getDoctrine()->getRepository('PAIParcelBundle:Parcelorfer')->delete($parcel);
		}
		else
		{
			
			throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
		}	
	}
        
    public function getParcelorderAddAction(){
    //public function getAddAction(Request $request){
        $parcelOrder = new \AppBundle\Entity\ParcelOrder();
        $form = $this->createForm("AppBundle\Form\ParcelOrderType", $parcelOrder);
        
        return $this->render("AppBundle:ParcelOrder/add.html.twig", array('form'=>$form->createView()));
    }
    
    public function postParcelorderAddAction(Request $request){
    //public function postAddAction(Request $request){
        $parcelOrder = new \AppBundle\Entity\ParcelOrder();
        $form = $this->createForm("AppBundle\Form\ParcelOrderType", $parcelOrder);
        
        if($request->isMethod("POST")){
            $form->handleRequest($request);
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($parcelOrder);
                $em->flush();
                return new \Symfony\Component\HttpFoundation\RedirectResponse($this->generateUrl("api_1_get_parcelorder", array("id"=>$parcelOrder->getId(), "_format"=>"json")));
            }
        }
        
        return $this->render("AppBundle:ParcelOrder/add.html.twig", array('form'=>$form->createView()));
    }
}
