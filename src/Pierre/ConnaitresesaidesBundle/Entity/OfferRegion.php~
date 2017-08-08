<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfferRegion
 *
 * @ORM\Table(name="offer_region")
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\OfferRegionRepository")
 */
class OfferRegion
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
     * @ORM\ManyToOne(targetEntity="Region", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id", nullable=false)
     */
    private $regionId;
    
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
     * Set regionId
     *
     * @param integer $regionId
     *
     * @return AdvantageRegion
     */
    public function setRegionId($regionId)
    {
        $this->regionId = $regionId;

        return $this;
    }

    /**
     * Get regionId
     *
     * @return int
     */
    public function getRegionId()
    {
        return $this->regionId;
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
