<?php

namespace AppBundle\Controller;

use AppBundle\Exception\InvalidFormException;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReceiverController extends FOSRestController
{
	
    // Get all orders.
    public function getReceiversAction() {
        $orders = $this->getDoctrine()->getRepository('AppBundle:ParcelOrder')->findAll();
		foreach($order as $orders)
	{
		$receivers[]=$order->getReceiver();
	}
        $view = $this->view($receivers, 200);
        return $this->handleView($view);
    }
	
	
}
