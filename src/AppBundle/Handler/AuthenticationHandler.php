<?php

namespace AppBundle\Handler;

use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

/**
 * Description of AuthenticationHandler
 *
 * @author Wiktor Pikosz <wiktor12348@gmail.com>
 */
class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface {

    private $serializer;

    public function __construct(SerializerInterface $serializer) {
        $this->serializer = $serializer;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
        //print_r($token);
        $result = array(
            'success' => true,
            'user' => $token->getUser()
        );
        $response = new Response($this->serializer->serialize($result, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
        $result = array('success' => false, 'message' => $exception->getMessage());
        $response = new Response($this->serializer->serialize($result, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
