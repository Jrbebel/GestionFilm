<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\DoctrineListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Friend;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Description of CreationAnnonce
 *
 * @author jrbebel
 */
class FriendEvt {

    protected $request;
    protected $em;

    public function __construct(\Symfony\Component\HttpFoundation\RequestStack $request, ContainerInterface $container, \Swift_Mailer $mailer,TokenStorageInterface $token_storage) {

        $this->mailer = $mailer;
        $this->request = $request;
        $this->container = $container; 
 $this->token_storage = $token_storage;
    }

    public function postPersist(LifecycleEventArgs $args) {

        $entity = $args->getEntity();
        if ($entity instanceof Friend) {


            $entityManager = $args->getEntityManager();

            $this->envoieMail($entity);


            return;
        }
    }

    public function envoieMail($entity) {
        //var_dump($entity->getFriends()->getEmail());
        //var_dump($entity->getUser()->getEmail());
        if($entity->getUser() == $this->token_storage->getToken()->getUser()) {
            $message = \Swift_Message::newInstance()
                    ->setSubject('Demande d\'amis')
                    ->setFrom($this->token_storage->getToken()->getUser()->getEmail())
                    ->setTo($entity->getFriends()->getEmail())
                    ->setBody($this->container->get('templating')->render('AppBundle:Amis:emailconfirmation.html.twig',array('User'=>$entity->getUser())) )
            ->setContentType('text/html');

            $this->mailer->send($message);
        }
    }

}
