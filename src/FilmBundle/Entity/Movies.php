<?php

namespace FilmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movies
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FilmBundle\Entity\MoviesRepository")
 */
class Movies
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
     * @var string
     *
     * @ORM\Column(name="Titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="Genre", type="string", length=255)
     */
    private $genre;

    /**
     * @var string
     *
     * @ORM\Column(name="Company", type="string", length=255)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255)
     */
    private $pays;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datesortie", type="date")
     */
    private $datesortie;

    /**
     * @var string
     *
     * @ORM\Column(name="resume", type="string", length=255)
     */
    private $resume;


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
     * Set titre
     *
     * @param string $titre
     *
     * @return Movies
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set genre
     *
     * @param string $genre
     *
     * @return Movies
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set company
     *
     * @param string $company
     *
     * @return Movies
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Movies
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set datesortie
     *
     * @param \DateTime $datesortie
     *
     * @return Movies
     */
    public function setDatesortie($datesortie)
    {
        $this->datesortie = $datesortie;

        return $this;
    }

    /**
     * Get datesortie
     *
     * @return \DateTime
     */
    public function getDatesortie()
    {
        return $this->datesortie;
    }

    /**
     * Set resume
     *
     * @param string $resume
     *
     * @return Movies
     */
    public function setResume($resume)
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return string
     */
    public function getResume()
    {
        return $this->resume;
    }
}

