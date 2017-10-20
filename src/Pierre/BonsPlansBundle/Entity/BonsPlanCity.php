<?php

namespace Pierre\BonsPlansBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BonsPlanCity
 *
 * @ORM\Table(name="bonsplan_city")
 * @ORM\Entity(repositoryClass="Pierre\BonsPlansBundle\Repository\BonsPlanCityRepository")
 */
class BonsPlanCity
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
     * @ORM\ManyToOne(targetEntity="Pierre\ConnaitresesaidesBundle\Entity\City", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=false)
     */
    private $cityId;


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
     * Set cityId
     *
     * @param integer $cityId
     *
     * @return BonPlanCity
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
     * Set bonplanId
     *
     * @param integer $bonplanId
     *
     * @return BonPlanCity
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

