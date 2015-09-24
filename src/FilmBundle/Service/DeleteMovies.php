<?php

namespace FilmBundle\Service;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Doctrine\ORM\EntityManager;

/**
 * Description of DeleteMovies
 *
 * @author jrbebel
 */
class DeleteMovies {

    protected $request;
    protected $em;

    public function __construct(EntityManager $em,\Symfony\Component\HttpFoundation\RequestStack $request ) {
        $this->em = $em;
        $this->request = $request;
    }

    public function deletemoviesfavorite() {
        $param = $this->request->getCurrentRequest()->get('idmovies');
        $mymovies = $this->em->getRepository('FilmBundle:Moviesfavorite')->findOneBy(array('idmovies' => $param));
        $this->em->remove($mymovies);
        $this->em->flush();
    }

}
