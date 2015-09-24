<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace FilmBundle\Service;

class RechercheFilm {

    protected $request;

    public function __construct(\Symfony\Component\HttpFoundation\RequestStack $request) {

        $this->request = $request;
    }

    public function MyRecherche() {
        $film_search = $this->request->getCurrentRequest()->get('Search_movies');
        $chaine=$this->ChangeEspace($film_search);
      
        $ch = curl_init();
//sprint_r(//"http://api.themoviedb.org/3/search/movie?api_key=c7eb74475a1e3d62a7ab838d184bf0a7&query=".$film_search."&language=fr");
        //$ch = curl_init("http://api.themoviedb.org/3/search/movie?api_key=c7eb74475a1e3d62a7ab838d184bf0a7&query=".$film_search."&language=fr");
        curl_setopt($ch, CURLOPT_URL, 'http://api.themoviedb.org/3/search/movie?api_key=c7eb74475a1e3d62a7ab838d184bf0a7&query='.$chaine);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Accept: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response);
        if (is_object($result)) {

            return $result->results;
        } else {

            return "Aucune réponse à votre recherche";
        }
    }
    
    public function ChangeEspace($chaine){
        
        $chaineModifie=htmlentities(str_replace(" ","%20",$chaine));
        return $chaineModifie;
    }

}
