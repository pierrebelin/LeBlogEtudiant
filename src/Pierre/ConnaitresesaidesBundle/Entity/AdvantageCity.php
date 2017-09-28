<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * AdvantageCity
 *
 * @ORM\Table(name="advantage_city", uniqueConstraints={@UniqueConstraint(name="avantagecityunique", columns={"city_id", "advantage_id"})})
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\AdvantageCityRepository")
 */
class AdvantageCity
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
     * @ORM\ManyToOne(targetEntity="Advantage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="advantage_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
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
     * Set cityId
     *
     * @param integer $cityId
     *
     * @return AdvantageCity
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
