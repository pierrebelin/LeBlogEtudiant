<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * AidStatut
 *
 * @ORM\Table(name="aid_statut", uniqueConstraints={@UniqueConstraint(name="aidstatutunique", columns={"statut_id", "aid_id"})})
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\AidStatutRepository")
 */
class AidStatut
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
     * @ORM\ManyToOne(targetEntity="Statut", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="statut_id", referencedColumnName="id", nullable=false)
     */
    private $statutId;
    
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
     * Set statutId
     *
     * @param integer $statutId
     *
     * @return AidStatut
     */
    public function setStatutId($statutId)
    {
        $this->statutId = $statutId;

        return $this;
    }

    /**
     * Get statutId
     *
     * @return int
     */
    public function getStatutId()
    {
        return $this->statutId;
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
