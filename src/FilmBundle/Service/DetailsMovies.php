<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace FilmBundle\Service;

use Doctrine\ORM\EntityManager;

class DetailsMovies {

    protected $request;
    protected $em;

    public function __construct(\Symfony\Component\HttpFoundation\RequestStack $request, EntityManager $em) {
        $this->em = $em;
        $this->request = $request;
    }

    public function Detailsmovies() {

        $response = array();
        $id = $this->request->getCurrentRequest()->get('id');

        $ch_1 = curl_init("http://api.themoviedb.org/3/movie/" . $id . "?api_key=c7eb74475a1e3d62a7ab838d184bf0a7&language=fr");
        $ch_2 = curl_init("http://api.themoviedb.org/3/movie/" . $id . "/videos?api_key=c7eb74475a1e3d62a7ab838d184bf0a7&language=fr");
        curl_setopt($ch_1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_2, CURLOPT_RETURNTRANSFER, true);

        // build the multi-curl handle, adding both $ch
        $mh = curl_multi_init();
        curl_multi_add_handle($mh, $ch_1);
        curl_multi_add_handle($mh, $ch_2);

        // execute all queries simultaneously, and continue when all are complete
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);
        //  $result = json_decode($data);
        // all of our requests are done, we can now access the results
        $data_1 = curl_multi_getcontent($ch_1);
        $data_2 = curl_multi_getcontent($ch_2);
        $ispresent = $this->Dejavu($id);
        $response["ispresent"] = $ispresent;
        $response[] = json_decode($data_1);
        $response[] = json_decode($data_2)->results;


        return $response;
    }
  public function ApiDetailsmovies() {

        $response = array();
        $id = $this->request->getCurrentRequest()->get('id');

        $ch_1 = curl_init("http://api.themoviedb.org/3/movie/" . $id . "?api_key=c7eb74475a1e3d62a7ab838d184bf0a7&language=fr");
        $ch_2 = curl_init("http://api.themoviedb.org/3/movie/" . $id . "/videos?api_key=c7eb74475a1e3d62a7ab838d184bf0a7&language=fr");
        curl_setopt($ch_1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_2, CURLOPT_RETURNTRANSFER, true);

        // build the multi-curl handle, adding both $ch
        $mh = curl_multi_init();
        curl_multi_add_handle($mh, $ch_1);
        curl_multi_add_handle($mh, $ch_2);

        // execute all queries simultaneously, and continue when all are complete
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);
        //  $result = json_decode($data);
        // all of our requests are done, we can now access the results
        $data_1 = curl_multi_getcontent($ch_1);
        $data_2 = curl_multi_getcontent($ch_2);
        $ispresent = $this->Dejavu($id);
        $whishlist =  $this->Wishlist($id);
        $response["ispresent"] = $ispresent;
        $response["wishlist"] =$whishlist;
        $response[] = $data_1;
        $response[] = $data_2;


        return $response;
    }
    public function Dejavu($param) {

        $mymovies = $this->em->getRepository('FilmBundle:Moviesfavorite')->findOneBy(array('idmovies' => $param));

        if ($mymovies instanceof \FilmBundle\Entity\Moviesfavorite) {

            return true;
        } else {
           // return false;
        }
    }
   public function Wishlist($param) {

        $mymovies = $this->em->getRepository('FilmBundle:WishList')->findOneBy(array('idmovies' => $param));

        if ($mymovies instanceof \FilmBundle\Entity\WishList) {

            return true;
        } else {
         //   return false;
        }
    }
}
