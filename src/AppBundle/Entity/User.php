<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $Prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $Nom;

    

  
    private $confirmation;
    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;
    // propriété utilisé temporairement pour la suppression
    private $filenameForRemove;

    public function getAbsolutePath() {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getWebPath() {
        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
    }

    protected function getUploadRootDir() {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        print_r(__DIR__);
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/profile';
    }

    public function upload() {
        print_r('je suis dans upload ');
        if (null === $this->file) {
            return;
        }
        $this->path = sha1(uniqid(mt_rand(), true)) . '.' . $this->file->guessExtension();
        // s'il y a une erreur lors du déplacement du fichier, une exception
        // va automatiquement être lancée par la méthode move(). Cela va empêcher
        // proprement l'entité d'être persistée dans la base de données si
        // erreur il y a
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    public function __construct() {

        $this->friends = new ArrayCollection();
        parent::__construct();
        // your own logic
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return User
     */
    public function setPath($path) {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Set Nom
     *
     * @param string $nom
     * @return User
     */
    public function setNom($nom) {
        $this->Nom = $nom;

        return $this;
    }

    /**
     * Get Nom
     *
     * @return string 
     */
    public function getNom() {
        return $this->Nom;
    }

    /**
     * Set Prenom
     *
     * @param string $prenom
     * @return User
     */
    public function setPrenom($prenom) {
        $this->Prenom = $prenom;

        return $this;
    }

    /**
     * Get Prenom
     *
     * @return string 
     */
    public function getPrenom() {
        return $this->Prenom;
    }

    /**
     * Add friends
     *
     * @param \AppBundle\Entity\User $friends
     * @return User
     */
    public function addFriend(\AppBundle\Entity\User $friends) {
        $this->friends[] = $friends;

        return $this;
    }

    /**
     * Remove friends
     *
     * @param \AppBundle\Entity\User $friends
     */
    public function removeFriend(\AppBundle\Entity\User $friends) {
        $this->friends->removeElement($friends);
    }

    /**
     * Get friends
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFriends() {
        return $this->friends;
    }

}
