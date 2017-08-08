<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdvantageStatut
 *
 * @ORM\Table(name="advantage_statut")
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\AdvantageStatutRepository")
 */
class AdvantageStatut
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
     * Set statutId
     *
     * @param integer $statutId
     *
     * @return AdvantageStatut
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
