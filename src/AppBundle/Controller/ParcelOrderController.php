<?php

namespace AppBundle\Controller;

use AppBundle\Exception\InvalidFormException;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ParcelOrderController extends FOSRestController
{
    public function getParcelordersAction(){
        $data = $this->getDoctrine()->getRepository('AppBundle\Entity\ParcelOrder')->findAll();
        $view = $this->view($data, 200);
        return $this->handleView($view);
    }
    public function getParcelordersUnassignedAction(){
        $data = $this->getDoctrine()->getRepository('AppBundle\Entity\ParcelOrder')->findAllUnassigned();
        $view = $this->view($data, 200);
        return $this->handleView($view);
    }
	public function putParcelAction(Request $request, $id)
	{
		try
		{
			$parcel = $this->getDoctrine()->getRepository('AppBundle\Entity\ParcelOrder')
			->find($id);

			if (!$parcel) {
				$statusCode = Response::HTTP_CREATED;
				$parcel = $this->container->get('pai_rest.parcelorder.form')
				->post($request->request->all());
			}
			else {
				$statusCode = Response::HTTP_NO_CONTENT;
				$parcel = $this->container->get('pai_rest.parcelorder.form')
				->put($parcel,$request->request->all());
			}
			$routeOptions = array(
				'id' => $parcel->getId(),
				'_format' => $request->get('_format')
			);
			return $this->routeRedirectView('api_1_get_parcel',$routeOptions,$statusCode);
		}
		catch (InvalidFormException $exception)
		{
			return $exception->getForm();
		}
	}
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
        
        public function getListAction()
        {
            $list=$this->getDoctrine()->getRepository("AppBundle:ParcelOrder")->findAll();
            return $this->render("AppBundle:ParcelOrder/list.html.twig",array("list"=>$list));
        }
}
