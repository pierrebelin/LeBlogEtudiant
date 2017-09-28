<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;


/**
 * AidRegion
 *
 * @ORM\Table(name="aid_region", uniqueConstraints={@UniqueConstraint(name="aidcregionunique", columns={"region_id", "aid_id"})})
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\AidRegionRepository")
 */
class AidRegion
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
     * @ORM\ManyToOne(targetEntity="Aid", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="aid_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
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
