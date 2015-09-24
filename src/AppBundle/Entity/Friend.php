<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Friend
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\FriendRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Friend {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $friends;

    /**
     * @ORM\Column( type="boolean")
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $confirmation;

    /**
     * @ORM\Column( type="boolean")
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $demande;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set friends
     *
     * @param \AppBundle\Entity\User $friends
     * @return Friend
     */
    public function setFriends(\AppBundle\Entity\User $friends) {
        $this->friends = $friends;

        return $this;
    }

    /**
     * Get friends
     *
     * @return \AppBundle\Entity\User 
     */
    public function getFriends() {
        return $this->friends;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Friend
     */
    public function setUser(\AppBundle\Entity\User $user) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set confirmation
     *
     * @param boolean $confirmation
     * @return Friend
     */
    public function setConfirmation($confirmation) {
        $this->confirmation = $confirmation;

        return $this;
    }

    /**
     * Get confirmation
     *
     * @return boolean 
     */
    public function getConfirmation() {
        return $this->confirmation;
    }


    /**
     * Set demande
     *
     * @param boolean $demande
     * @return Friend
     */
    public function setDemande($demande)
    {
        $this->demande = $demande;

        return $this;
    }

    /**
     * Get demande
     *
     * @return boolean 
     */
    public function getDemande()
    {
        return $this->demande;
    }
}
