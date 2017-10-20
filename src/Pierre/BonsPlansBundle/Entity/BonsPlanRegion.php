<?php

namespace Pierre\BonsPlansBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BonsPlanRegion
 *
 * @ORM\Table(name="bonsplan_region")
 * @ORM\Entity(repositoryClass="Pierre\BonsPlansBundle\Repository\BonsPlanRegionRepository")
 */
class BonsPlanRegion
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
     * @ORM\ManyToOne(targetEntity="Pierre\ConnaitresesaidesBundle\Entity\Region", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id", nullable=false)
     */
    private $regionId;

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
     * Set regionId
     *
     * @param integer $regionId
     *
     * @return BonsPlanRegion
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
     * Set bonplanId
     *
     * @param integer $bonplanId
     *
     * @return BonsPlanRegion
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

