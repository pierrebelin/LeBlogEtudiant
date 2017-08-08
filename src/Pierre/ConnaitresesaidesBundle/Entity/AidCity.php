<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AidCity
 *
 * @ORM\Table(name="aid_city")
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\AidCityRepository")
 */
class AidCity
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
     * Set cityId
     *
     * @param integer $cityId
     *
     * @return AidCity
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
