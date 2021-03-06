<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfferStatut
 *
 * @ORM\Table(name="offer_statut")
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\OfferStatutRepository")
 */
class OfferStatut
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Statut", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="statut_id", referencedColumnName="id", nullable=false)
     */
    private $statutId;
    
    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Offer", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="offer_id", referencedColumnName="id", nullable=false)
     */
    private $offerId;
    
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set statutId
     *
     * @param integer $statutId
     *
     * @return OfferStatut
     */
    public function setStatutId($statutId)
    {
        $this->statutId = $statutId;

        return $this;
    }

    /**
     * Get statutId
     *
     * @return int
     */
    public function getStatutId()
    {
        return $this->statutId;
    }   
    
    /**
     * Set offerId
     *
     * @param integer $offerId
     *
     * @return OfferCity
     */
    public function setOfferId($offerId)
    {
        $this->offerId = $offerId;

        return $this;
    }

    /**
     * Get offerId
     *
     * @return int
     */
    public function getOfferId()
    {
        return $this->offerId;
    }
    
}
