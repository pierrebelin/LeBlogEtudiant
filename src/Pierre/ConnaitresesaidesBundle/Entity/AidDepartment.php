<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;


/**
 * AidDepartment
 *
 * @ORM\Table(name="aid_department", uniqueConstraints={@UniqueConstraint(name="aiddepartmentunique", columns={"department_id", "aid_id"})})
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\AidDepartmentRepository")
 */
class AidDepartment
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
     * @ORM\ManyToOne(targetEntity="Department", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id", nullable=false)
     */
    private $departmentId;
    
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
     * Set departmentId
     *
     * @param integer $departmentId
     *
     * @return AidDepartment
     */
    public function setDepartmentId($departmentId)
    {
        $this->departmentId = $departmentId;

        return $this;
    }

    /**
     * Get departmentId
     *
     * @return int
     */
    public function getDepartmentId()
    {
        return $this->departmentId;
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
