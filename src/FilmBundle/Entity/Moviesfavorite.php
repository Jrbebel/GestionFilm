<?php

namespace FilmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
/**
 * Moviesfavorite
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FilmBundle\Entity\MoviesfavoriteRepository")
 */
class Moviesfavorite {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     * @Expose
     * @ORM\Column(name="idmovies", type="integer")
     * 
     * 
     */
    private $idmovies;

    /**
     * @var integer
     * @Expose
     * @ORM\Column(name="iduser", type="integer")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User")
     * 
     */
    private $iduser;

        /**
     * @var date
     * @Expose
     * @ORM\Column(name="dateVu", type="date")
     * 
     * 
     */
    private $dateVu;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set iduser
     *
     * @param integer $iduser
     * @return Moviesfavorite
     */
    public function setIduser($iduser) {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return integer 
     */
    public function getIduser() {
        return $this->iduser;
    }

    /**
     * Set idmovies
     *
     * @param integer $idmovies
     * @return Moviesfavorite
     */
    public function setIdmovies($idmovies) {
        $this->idmovies = $idmovies;

        return $this;
    }

    /**
     * Get idmovies
     *
     * @return integer 
     */
    public function getIdmovies() {
        return $this->idmovies;
    }


    /**
     * Set dateVu
     *
     * @param \DateTime $dateVu
     * @return Moviesfavorite
     */
    public function setDateVu($dateVu)
    {
        $this->dateVu = $dateVu;

        return $this;
    }

    /**
     * Get dateVu
     *
     * @return \DateTime 
     */
    public function getDateVu()
    {
        return $this->dateVu;
    }
}
