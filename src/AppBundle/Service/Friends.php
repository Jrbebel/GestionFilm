<?php

namespace AppBundle\Service;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Doctrine\ORM\EntityManager;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Description of Friends
 *
 * @author jrbebel
 */
class Friends {

    protected $request;
    protected $em;

    public function __construct(\Symfony\Component\HttpFoundation\RequestStack $request, EntityManager $em, SecurityContext $context) {

        $this->request = $request;
        $this->em = $em;
        $this->context = $context;
        $this->user = $this->context->getToken()->getUser();
    }

    public function MyFriendsearch() {

        $term = $this->request->getCurrentRequest()->get('friend');
        $array = $this->em->getRepository('AppBundle:User')->searchFriend($term);
        return $array;
    }

    public function AjouterFriend() {

        $id = $this->request->getCurrentRequest()->get('id');
    
        $friend = $this->em->getRepository('AppBundle:User')->find($id);

        $amis = new \AppBundle\Entity\Friend();
        $amis1 = new \AppBundle\Entity\Friend();

        $amis->setUser($this->user);
        $amis->setFriends($friend);
        $amis->setDemande(false);
        $amis->setConfirmation(false);

        $amis1->setUser($friend);
        $amis1->setFriends($this->user);
        $amis1->setDemande(true);
        $amis1->setConfirmation(false);

        $this->em->persist($amis1);
        $this->em->persist($amis);
        $this->em->flush();
    }

    public function AjouterconfirmationFriend() {

        $id = $this->request->getCurrentRequest()->get('id');

        $friend = $this->em->getRepository('AppBundle:User')->find($id);

        $criteria = array('user' => $friend, 'friends' => $this->user);
        $criteria2 = array('user' => $this->user, 'friends' => $friend);

        $Friends = $this->em->getRepository('AppBundle:Friend')->findOneBy($criteria);
        $Friends1 = $this->em->getRepository('AppBundle:Friend')->findOneBy($criteria2);


        $Friends->setConfirmation(true);
        $Friends1->setConfirmation(true);
        $this->em->persist($Friends);
        $this->em->flush();
    }

    public function SupprimerFriend() {

        $id = $this->request->getCurrentRequest()->get('id');

        $friend = $this->em->getRepository('AppBundle:User')->find($id);

        $criteria = array('user' => $friend, 'friends' => $this->user);
        $criteria2 = array('user' => $this->user, 'friends' => $friend);

        $Friends = $this->em->getRepository('AppBundle:Friend')->findOneBy($criteria);
        $Friends1 = $this->em->getRepository('AppBundle:Friend')->findOneBy($criteria2);
        \Doctrine\Common\Util\Debug::dump($Friends1);

        $this->em->remove($Friends);
        $this->em->remove($Friends1);

        $this->em->flush();
    }

    public function NbreFriendattente() {
        $criteria = array('friends' => $this->user->getId(), 'confirmation' => 0);
        $amis = $this->em->getRepository('AppBundle:Friend')->findBy($criteria);
        $count = count($amis);
        return $count;
    }

}
