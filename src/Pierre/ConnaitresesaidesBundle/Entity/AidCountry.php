<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;


/**
 * AidCountry
 *
 * @ORM\Table(name="aid_country", uniqueConstraints={@UniqueConstraint(name="aidcountryunique", columns={"country_id", "aid_id"})})
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\AidCountryRepository")
 */
class AidCountry
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
     * @ORM\ManyToOne(targetEntity="Aid", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="aid_id", referencedColumnName="id", nullable=false)
     */
    private $aidId;   
    
    
    
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
     * @return AidCountry
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
     * Set aidId
     *
     * @param integer $aidId
     *
     * @return AidStatut
     */
    public function setAidId($aidId)
    {
        $this->aidId = $aidId;

        return $this;
    }

    /**
     * Get aidId
     *
     * @return int
     */
    public function getAidId()
    {
        return $this->aidId;
    }       
}
