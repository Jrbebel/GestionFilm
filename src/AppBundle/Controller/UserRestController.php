<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Response;

class UserRestController extends Controller {

    /**
     * 
     * @param type $username
     * 
     * @View(serializerGroups={"Default","Me","Details"})
     */
    public function getUserAction() {
        $username = "jrbebel";
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('username' => $username));


        return $user;
    }

    protected function checkUserPassword($user, $password) {
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        if (!$encoder) {
            return false;
        }

        return $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
    }

    /**
     * 
     * @View(serializerGroups={"Default","Me","Details"})
     */
    public function getMeAction() {


        return $this->getUser();
    }

    /**
     * Shortcut to throw a AccessDeniedException($message) if the user is not authenticated
     * @param String $message The message to display (default:'warn.user.notAuthenticated')
     */
    protected function forwardIfNotAuthenticated($message = 'warn.user.notAuthenticated') {
        if (!is_object($this->getUser())) {
            throw new AccessDeniedException($message);
        }
    }

    /*
     * @View(serializerGroups={"Default","Me","Details"})
     */

    public function postUserAction() {

        $request = $this->getRequest();
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $email = $request->request->get('email');
        $verification = $request->request->get('verification');
        $um = $this->container->get('fos_user.user_manager');


        /*         * On verifie si l'username est deja existant */
        $userFindUsername = $um->findUserByUsername($username);

        if ($userFindUsername instanceof \AppBundle\Entity\User) {

            throw new AccessDeniedException("Username déja existant");
        }
        /*         * ********On verifie si l'adresse mail est deja presente dans la BDD********** */


        $userFind = $um->findUserByEmail($email);

        if ($userFind instanceof \AppBundle\Entity\User) {

            throw new AccessDeniedHttpException("Votre email est déja associé à un compte");
        }
        $user = new \AppBundle\Entity\User();

        /*         * **On verifie si les deux mots de passe sont identitiques*** */

        if ($password != $verification) {
            throw new AccessDeniedHttpException("Les deux champs de mot de passe ne coresspondent pas");
        }

        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        $passwordResult = $encoder->encodePassword($password, $user->getSalt());
        $user->setPassword($passwordResult);

        /*         * ****On cree l'utilisateur ******* */

        $user->setUsername($username);
        $user->setUsernameCanonical($username);
        $user->setEmail($email);
        $user->setEmailCanonical($email);
        $user->setEnabled(true);
        $user->setLocked(false);
        $user->setExpired(false);
        $user->setCredentialsExpired(false);

        $em = $this->get('doctrine')->getEntityManager();
        $em->persist($user);
        $em->flush();

        return array('status' => 'Utilisateur crée', 'code' => '200');
    }

    protected function getUserExistAction($id) {

        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findById($id);
        return $user;
    }

    /*
     * @View(serializerGroups={"Default","Me","Details"})
     */

    public function postAjoutmoviesAction() {

        $request = $this->getRequest();
        $idMovies = $request->request->get('idMovies');
        $idUser = $request->request->get('idUser');
        $message = "je n existe pas ";
        /** On fait une verification sur l utilisateur * */
        if ($this->getUserExistAction($idUser) instanceof \AppBundle\Entity\User) {
            throw new AccessDeniedException($message);
        }
        if ($this->getDoctrine()->getRepository('AppBundle:Moviesfavorite')->findBy(array('idmovies'=>$idMovies))){
        
        $serializer = $this->container->get('serializer');
        $serializedEntity = $serializer->serialize( "Ce film à déja été ajouter", 'json');
        return new Response($serializedEntity, 200);
        
        
        }else{
        
        $moviefavorite = new \AppBundle\Entity\Moviesfavorite();
        $moviefavorite->setIduser($idUser);
        $moviefavorite->setIdmovies($idMovies);
        $moviefavorite->setDateVu(new \DateTime('now'));
        $em = $this->get('doctrine')->getEntityManager();
        $em->persist($moviefavorite);
        $em->flush();
        
        $serializer = $this->container->get('serializer');
        $serializedEntity = $serializer->serialize( "Film ajouté avec succès", 'json');
        return new Response($serializedEntity, 200);
    
        }
    }

    /*
     * @View(serializerGroups={"Default","Me","Details"})
     */

    public function getMymoviesAction($idUser) {

        $request = $this->getRequest();

        $mymovies = $this->getDoctrine()->getRepository('AppBundle:Moviesfavorite')->FindMymovies($idUser);
//        $response = new Response();
//        $response->setContent(json_encode(array($mymovies)));
//        $response->setStatusCode(200);
//        $response->headers->set('Content-Type', 'application/json');
//
//        $response->prepare($request);
//
//        $response->send(); 

     $responses = array();

     foreach ($mymovies as $key=>$value) {

            $ch = curl_init("http://api.themoviedb.org/3/movie/".$value->getIdmovies()."?api_key=c7eb74475a1e3d62a7ab838d184bf0a7");
          //  curl_setopt($ch, CURLOPT_URL, "http://api.themoviedb.org/3/movie/630?api_key=c7eb74475a1e3d62a7ab838d184bf0a7");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Accept: application/json"
            ));

            $responses[$key]  = curl_exec($ch);

            curl_close($ch);
     }
//           $response = new Response();
//        $response->setContent(json_encode($response, JSON_FORCE_OBJECT));
//        $response->setStatusCode(200);
//        $response->headers->set('Content-Type', 'application/json');
//
//        $response->prepare($request);
//
//        $response->send();
   
        $serializer = $this->container->get('serializer');
        $serializedEntity = $serializer->serialize( $responses, 'json');
        return new Response($serializedEntity, 200);
 
    }

}
