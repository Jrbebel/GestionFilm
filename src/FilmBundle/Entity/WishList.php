<?php

namespace FilmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WishList
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FilmBundle\Entity\WishListRepository")
 */
class WishList
{
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
     * @ORM\Column(name="idmovies", type="integer")
     * 
     * 
     */
    private $idmovies;

    /**
     * @var integer
     * @ORM\Column(name="iduser", type="integer")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User")
     * 
     */
    private $iduser;
        /**
     * @var date
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idmovies
     *
     * @param integer $idmovies
     * @return WishList
     */
    public function setIdmovies($idmovies)
    {
        $this->idmovies = $idmovies;

        return $this;
    }

    /**
     * Get idmovies
     *
     * @return integer 
     */
    public function getIdmovies()
    {
        return $this->idmovies;
    }

    /**
     * Set iduser
     *
     * @param integer $iduser
     * @return WishList
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return integer 
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * Set dateVu
     *
     * @param \DateTime $dateVu
     * @return WishList
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
