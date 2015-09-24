<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class AmisController extends Controller {

    /**
     * @Route("Amis/",name="index_friend")
     * @Template("AppBundle:Amis:search.html.twig")
     */
    public function indexAction() {

        $criteria = array('friends' => $this->getUser()->getId(), 'confirmation' => 1);
        $amis = $this->getDoctrine()->getManager()->getRepository('AppBundle:Friend')->findBy($criteria);
        $criteriaconf = array('friends' => $this->getUser()->getId(), 'confirmation' => 0, 'demande' => 0);
        $amisconfirmation = $this->getDoctrine()->getManager()->getRepository('AppBundle:Friend')->findBy($criteriaconf);
        return array('User' => $amis, 'Amisconf' => $amisconfirmation);
    }

    /**
     * @Route("Amis/Search",name="search_friend")
     * @Template("AppBundle:Amis:search.html.twig")
     */
    public function ChercheramisAction(\Symfony\Component\HttpFoundation\Request $Request) {



        if ($Request->isXmlHttpRequest()) {

            $array = $this->container->get('friend')->MyFriendsearch();
            $serializer = $this->container->get('serializer');
            $serializedEntity = $serializer->serialize($array, 'json');

            return new Response($serializedEntity, 200);
        }
    }

    /**
     * @Route("Amis/Ajout",name="ajout_friend")
     * @Template("AppBundle:Amis:search.html.twig")
     */
    public function AjouteramisAction(\Symfony\Component\HttpFoundation\Request $Request) {

        $this->container->get('friend')->AjouterFriend();

        return $this->redirect($this->generateUrl('index_friend'));
    }

    /**
     * @Route("Amis/AjoutConfirm",name="ajoutconfirm_friend")
     * @Template("AppBundle:Amis:search.html.twig")
     */
    public function AjouterconfirmamisAction(\Symfony\Component\HttpFoundation\Request $Request) {

        $this->container->get('friend')->AjouterconfirmationFriend();

        return $this->redirect($this->generateUrl('index_friend'));
    }

    /**
     * @Route("Amis/Delete",name="delete_friend")
     * @Template("AppBundle:Amis:search.html.twig")
     */
    public function DeleteamisAction(\Symfony\Component\HttpFoundation\Request $Request) {

        $this->container->get('friend')->SupprimerFriend();

        return $this->redirect($this->generateUrl('index_friend'));
    }

    /**
     * @Route("Amis/count",name="count_friend")
     * @Template("AppBundle:Amis:count.html.twig")
     */
    public function NbreFriendAction() {

        $nbreFriendAttente = $this->container->get('friend')->NbreFriendattente();

        return array('NbreFriendattente' => $nbreFriendAttente);
    }

    /**
     * @Route("Amis/test",name="test")
     * @Template("AppBundle:Amis:emailconfirmation.html.twig")
     */
    public function TestAction() {

          $criteria = array('friends' => $this->getUser()->getId(), 'confirmation' => 1);
        $amis = $this->getDoctrine()->getManager()->getRepository('AppBundle:Friend')->findBy($criteria);
        $criteriaconf = array('friends' => $this->getUser()->getId(), 'confirmation' => 0, 'demande' => 0);
        $amisconfirmation = $this->getDoctrine()->getManager()->getRepository('AppBundle:Friend')->findOneBy($criteria);
        \Doctrine\Common\Util\Debug::dump($amisconfirmation);
        return array('User' => $this->getUser());
    }
}
