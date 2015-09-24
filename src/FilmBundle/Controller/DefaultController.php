<?php

namespace FilmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    /**
     * @Route("/Film",name="Filmotheque")
     * @Template("FilmBundle:Default:dernierAjout.html.twig")
     */
    public function dernierAjoutAction() {

        $nbreFriendAttente = $this->container->get('friend')->NbreFriendattente();
        $data = $this->container->get('film_service')->FindMymovies();

        return array("responses" => $data, 'NbreFriendattente' => $nbreFriendAttente);
    }

    /**
     * @Route("/FilmAll_Whislist",name="Filmotheque_All_Wishlist")
     * @Template("FilmBundle:Default:AllFilmWishtlist.html.twig")
     */
    public function AllwishtMovies() {

        $data = $this->container->get('filmAll_service')->FindAllWhistmovies();

        return array("responses" => $data, 'type' => 2);
    }

    /**
     * @Route("/FilmAll",name="Filmotheque_All")
     * @Template("FilmBundle:Default:AllFilm.html.twig")
     */
    public function AllMovies() {

        $data = $this->container->get('filmAll_service')->FindAllmovies();

        return array("responses" => $data, 'type' => 1);
    }

    /**
     * @Route("/Film_recherche",name="Filmotheque_Recherche")
     * @Template()
     */
    public function recherchefilmAction() {

        $data = $this->container->get('film_service_recherche')->MyRecherche();

        return array("responses" => $data);
    }

    /**
     * @Route("/Film_details",name="Filmotheque_Details")
     * @Template()
     */
    Public function DetailsMoviesAction(\Symfony\Component\HttpFoundation\Request $request) {

        $type = $request->get('type');
        $data = $this->container->get('film_service_details')->Detailsmovies();

        return(array('response' => $data[0], 'trailer' => $data[1], 'ispresent' => $data["ispresent"], 'type' => $type));
    }

    /**
     * @Route("/Film_ajouter",name="Filmotheque_Ajouter")
     * @Template()
     */
    public function AjouterMoviesAction(\Symfony\Component\HttpFoundation\Request $request) {

        $data = $this->container->get('film_service_ajouter')->AjouterMovies();

        return(array('response' => $data));
    }

    /**
     * @Route("/Film_ajouter_wishlist",name="Filmotheque_Ajouter_wishlist")
     * @Template()
     */
    public function AjouterMoviesWishlistAction() {

        $data = $this->container->get('film_service_ajouter')->AjouterWithlistMovies();

        return(array('response' => $data));
    }

    /**
     * @Route("/Film_delete",name="Filmotheque_delete_favoris")
     * @Template("FilmBundle:Default:AllFilm.html.twig")
     */
    public function DeleteMoviesfavoriesAction() {

        $data = $this->container->get('film_delete')->deletemoviesfavorite();
        return $this->redirect($this->generateUrl('Filmotheque'));
    }

}
