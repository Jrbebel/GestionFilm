<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AjouterMovies
 *
 * @author jrbebel
 */

namespace FilmBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class AjouterMovies {

    protected $request;
    protected $em;

    public function __construct(\Symfony\Component\HttpFoundation\RequestStack $request, EntityManager $em, SecurityContext $context) {
        $this->request = $request;
        $this->em = $em;
        $this->context = $context;
        $this->user = $this->context->getToken()->getUser();
    }

    public function AjouterMovies() {
 
        $idMovies = $this->request->getCurrentRequest()->get('idMovies');
        $session = $this->request->getCurrentRequest()->getSession();
       // $type= $this->request->getCurrentRequest()->get('wishlist');
        $type= $this->request->getCurrentRequest()->get('type');

   
        if ($this->isAjouter($idMovies)) {
             $session->getFlashBag()->add('info', 'Ce film a été déja vu');
            return false;
        }
        $moviefavorite = new \FilmBundle\Entity\Moviesfavorite();
        $moviefavorite->setIduser($this->user->getid());
        $moviefavorite->setIdmovies($idMovies);
        $moviefavorite->setDateVu(new \DateTime('now'));
        if($type == 2 ){
            $mymovieswishlist = $this->em->getRepository('FilmBundle:WishList')->findOneBy(array('idmovies' => $idMovies));
            $this->em->remove($mymovieswishlist);
        }
        $this->em->persist($moviefavorite);
        $this->em->flush();
    }
    
    public function AjouterWithlistMovies(){
        
        $idMovies = $this->request->getCurrentRequest()->get('idMovies');
        $session = $this->request->getCurrentRequest()->getSession();


       
        if ($this->isAjouter($idMovies)) {
             $session->getFlashBag()->add('info', 'Ce film a été à votre liste de souhait');
            return false;
        }
        $moviefavorite = new \FilmBundle\Entity\WishList();
        $moviefavorite->setIduser($this->user->getid());
        $moviefavorite->setIdmovies($idMovies);
        $moviefavorite->setDateVu(new \DateTime('now'));
        $this->em->persist($moviefavorite);
        $this->em->flush(); 
    }

    public function isAjouter($param) {

        $mymovies = $this->em->getRepository('FilmBundle:Moviesfavorite')->findOneBy(array('idmovies' => $param));

        if ($mymovies instanceof \FilmBundle\Entity\Moviesfavorite) {

            return true;
        }
    }

}
