<?php
namespace AppBundle\EventListener;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener
{
    
    /**
     * 
     * @param AuthenticationSuccessEvent $event
     * 
    */
    
public function onAuthenticationSuccessResponse( AuthenticationSuccessEvent $event)
{
    $data = $event->getData();
    $user = $event->getUser();

    if (!$user instanceof UserInterface) {
        return;
    }

    // $data['token'] contains the JWT

    $data['data'] = array(
        'roles' => $user->getId(),
    );

    $event->setData($data);
}

}