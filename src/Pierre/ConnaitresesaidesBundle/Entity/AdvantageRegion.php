<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;


/**
 * AdvantageRegion
 *
 * @ORM\Table(name="advantage_region", uniqueConstraints={@UniqueConstraint(name="avantageregionunique", columns={"region_id", "advantage_id"})})
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\AdvantageRegionRepository")
 */
class AdvantageRegion
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
     * Set advantageId
     *
     * @param integer $advantageId
     *
     * @return AdvantageRegion
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
