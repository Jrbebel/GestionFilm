<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace FilmBundle\DoctrineListener;

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
class FilmEvt {

    protected $request;
    protected $em;

    public function __construct(\Symfony\Component\HttpFoundation\RequestStack $request, ContainerInterface $container, \Swift_Mailer $mailer, TokenStorageInterface $token_storage) {

        $this->mailer = $mailer;
        $this->request = $request;
        $this->container = $container;
        $this->token_storage = $token_storage;
    }

    public function postPersist(LifecycleEventArgs $args) {

        $entity = $args->getEntity();
        if ($entity instanceof \FilmBundle\Entity\WishList) {


            $entityManager = $args->getEntityManager();
            $resultat=$entityManager->getRepository('AppBundle:Friend')->findBy(array('user'=>$this->token_storage->getToken()->getUser()));
            $this->envoieMail($resultat);


            return;
        }
    }

    public function envoieMail($entity) {

        foreach ($entity as $value) {
                  

             $message = \Swift_Message::newInstance()
                    ->setSubject('Ajout de film par votre amis')
                    ->setFrom($this->token_storage->getToken()->getUser()->getEmail())
                    ->setTo($value->getFriends()->getEmail())
                    ->setBody($this->container->get('templating')->render('FilmBundle:Email:notificationfilm.html.twig',array("entity"=>$value)))
                    ->setContentType('text/html');

            $this->mailer->send($message);
        }
           
       
    }

}
