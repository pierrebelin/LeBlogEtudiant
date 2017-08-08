<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfferCountry
 *
 * @ORM\Table(name="offer_country")
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\OfferCountryRepository")
 */
class OfferCountry
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
     * @ORM\ManyToOne(targetEntity="Country", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=false)
     */
    private $countryId;
    
    
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
     * Set countryId
     *
     * @param integer $countryId
     *
     * @return OfferCountry
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * Get countryId
     *
     * @return int
     */
    public function getCountryId()
    {
        return $this->countryId;
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
