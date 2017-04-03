<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfferCity
 *
 * @ORM\Table(name="offer_city")
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\OfferCityRepository")
 */
class OfferCity
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
     * @ORM\ManyToOne(targetEntity="City", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=false)
     */
    private $cityId;
       
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
     * Set cityId
     *
     * @param integer $cityId
     *
     * @return OfferCity
     */
    public function setCityId($cityId)
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * Get cityId
     *
     * @return int
     */
    public function getCityId()
    {
        return $this->cityId;
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
