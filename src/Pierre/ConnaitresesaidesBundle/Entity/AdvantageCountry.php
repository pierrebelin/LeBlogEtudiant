<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;


/**
 * AdvantageCountry
 *
 * @ORM\Table(name="advantage_country", uniqueConstraints={@UniqueConstraint(name="avantagecountryunique", columns={"country_id", "advantage_id"})})
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\AdvantageCountryRepository")
 */
class AdvantageCountry
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
     * @ORM\ManyToOne(targetEntity="Advantage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="advantage_id", referencedColumnName="id", nullable=false)
     */
    private $advantageId;   
    
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
     * @return AdvantageCountry
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
     * Set advantageId
     *
     * @param integer $advantageId
     *
     * @return AdvantageCity
     */
    public function setAdvantageId($advantageId)
    {
        $this->advantageId = $advantageId;

        return $this;
    }

    /**
     * Get advantageId
     *
     * @return int
     */
    public function getAdvantageId()
    {
        return $this->advantageId;
    }
}
