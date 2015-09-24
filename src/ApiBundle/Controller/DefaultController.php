<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference,
    Symfony\Component\Routing\Exception\ResourceNotFoundException,
    Symfony\Component\Validator\ValidatorInterface;
use FOS\RestBundle\View\View,
    FOS\RestBundle\View\ViewHandler,
    FOS\RestBundle\View\RouteRedirectView;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends FOSRestController {

    public function getDernierajoutAction() {


        $data = $this->container->get('film_service')->ApiFindMymovies();
        $serializer = $this->container->get('serializer');
        $serializedEntity = $serializer->serialize($data, 'json');
        return new Response($serializedEntity, 200);
    }

    public function getFindallmoviesAction() {

        $data = $this->container->get('filmAll_service')->ApiFindAllmovies();
        $serializer = $this->container->get('serializer');
        $serializedEntity = $serializer->serialize($data, 'json');

        return new Response($serializedEntity, 200);
    }

    public function getFindallwishlistmoviesAction() {

        $data = $this->container->get('filmAll_service')->ApiFindAllWhistmovies();
        $serializer = $this->container->get('serializer');
        $serializedEntity = $serializer->serialize($data, 'json');

        return new Response($serializedEntity, 200);
    }

    public function postWishlistmoviesAction(\Symfony\Component\HttpFoundation\Request $request) {
        
        $data = $this->container->get('film_service_ajouter')->AjouterWithlistMovies();

        $serializer = $this->container->get('serializer');
        if ($data) {
            $dataResponse = "Ce film est déja dans votre wishlist";
        } else {
            $dataResponse = "Ce film a été ajouté dans votre wishlist";
        }
        $serializedEntity = $serializer->serialize($dataResponse, 'json');
        return new Response($serializedEntity, 200);
    }

    public function postAjoutermoviesAction(\Symfony\Component\HttpFoundation\Request $request) {

        $data = $this->container->get('film_service_ajouter')->AjouterMovies();

        $serializer = $this->container->get('serializer');
        if ($data) {
            $dataResponse = "Ce film est déja dans vos favoris";
        } else {
            $dataResponse = "Ce film a été ajouté dans vos favoris";
        }
        $serializedEntity = $serializer->serialize($dataResponse, 'json');
        return new Response($serializedEntity, 200);
    }

    public function getDetailsmoviesAction($id) {

        $data = $this->container->get('film_service_details')->ApiDetailsmovies();
        $serializer = $this->container->get('serializer');
        $serializedEntity = $serializer->serialize($data, 'json');
        return new Response($serializedEntity, 200);
    }

}
