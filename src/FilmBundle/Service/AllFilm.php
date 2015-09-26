<?php

namespace FilmBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class AllFilm {

    protected $em;
    protected $id;

    public function __construct(EntityManager $em, SecurityContext $context) {

        $this->em = $em;
        $this->context = $context;
        $this->user = $this->context->getToken()->getUser();
    }

    public function FindAllmovies() {


        $mymovies = $this->em->getRepository('FilmBundle:Moviesfavorite')->FindAllmovies($this->user->getid());
        $ch = array();
        $responses = array();
        $mh = curl_multi_init();
        foreach ($mymovies as $key => $value) {
            $ch[$key] = curl_init("http://api.themoviedb.org/3/movie/" . $value->getIdmovies() . "?api_key=c7eb74475a1e3d62a7ab838d184bf0a7&language=fr");
            curl_setopt($ch[$key], CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($mh, $ch[$key]);
        }

        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);
        foreach ($mymovies as $key => $value) {
                        

            $data = curl_multi_getcontent($ch[$key]);
           
            $responses[$key] = json_decode($data);
           
        }

        curl_multi_close($mh);
        return $responses;
    }

    public function FindAllWhistmovies() {


        $mymovies = $this->em->getRepository('FilmBundle:WishList')->FindAllmovies($this->user->getid());
        $ch = array();
        $responses = array();
        $mh = curl_multi_init();
        foreach ($mymovies as $key => $value) {
            $ch[$key] = curl_init("http://api.themoviedb.org/3/movie/" . $value->getIdmovies() . "?api_key=c7eb74475a1e3d62a7ab838d184bf0a7&language=fr");
            curl_setopt($ch[$key], CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($mh, $ch[$key]);
        }

        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);
        foreach ($mymovies as $key => $value) {
    
            $data = curl_multi_getcontent($ch[$key]);
            $responses[$key] = json_decode($data);
        }

        curl_multi_close($mh);
        return $responses;
    }

    public function ApiFindAllWhistmovies() {


        $mymovies = $this->em->getRepository('FilmBundle:WishList')->FindAllmovies($this->user->getid());
        $ch = array();
        $responses = array();
        $mh = curl_multi_init();
        foreach ($mymovies as $key => $value) {
            $ch[$key] = curl_init("http://api.themoviedb.org/3/movie/" . $value->getIdmovies() . "?api_key=c7eb74475a1e3d62a7ab838d184bf0a7");
            curl_setopt($ch[$key], CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($mh, $ch[$key]);
        }

        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);
        foreach ($mymovies as $key => $value) {
            $data = curl_multi_getcontent($ch[$key]);
            $responses[$key] = $data;
        }

        curl_multi_close($mh);
        return $responses;
    }

    public function ApiFindAllmovies() {


        $mymovies = $this->em->getRepository('FilmBundle:Moviesfavorite')->FindAllmovies($this->user->getid());
        $ch = array();
        $responses = array();
        $mh = curl_multi_init();
        foreach ($mymovies as $key => $value) {
            $ch[$key] = curl_init("http://api.themoviedb.org/3/movie/" . $value->getIdmovies() . "?api_key=c7eb74475a1e3d62a7ab838d184bf0a7");
            curl_setopt($ch[$key], CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($mh, $ch[$key]);
        }

        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);
        foreach ($mymovies as $key => $value) {
            $data = curl_multi_getcontent($ch[$key]);
            $responses[$key] = $data;
        }

        curl_multi_close($mh);
        return $responses;
    }

    public function RechercheMovies() {
        print_r(1);
    }

}
