<?php

namespace Pierre\BonsPlansBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BonsPlanCountry
 *
 * @ORM\Table(name="bonsplan_country")
 * @ORM\Entity(repositoryClass="Pierre\BonsPlansBundle\Repository\BonPlanCountryRepository")
 */
class BonsPlanCountry
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
     * @ORM\ManyToOne(targetEntity="Pierre\ConnaitresesaidesBundle\Entity\Country", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=false)
     */
    private $countryId;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="BonsPlan", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="bonplan_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $bonplanId;


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
     * @return BonPlanCountry
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
     * Set bonplanId
     *
     * @param integer $bonplanId
     *
     * @return BonPlanCountry
     */
    public function setBonplanId($bonplanId)
    {
        $this->bonplanId = $bonplanId;

        return $this;
    }

    /**
     * Get bonplanId
     *
     * @return int
     */
    public function getBonplanId()
    {
        return $this->bonplanId;
    }
}

