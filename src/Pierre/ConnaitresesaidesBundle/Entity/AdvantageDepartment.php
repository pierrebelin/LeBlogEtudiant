<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * AdvantageDepartment
 *
 * @ORM\Table(name="advantage_department", uniqueConstraints={@UniqueConstraint(name="avantagedepartmentunique", columns={"department_id", "advantage_id"})})
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\AdvantageDepartmentRepository")
 */
class AdvantageDepartment
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
     * Set departmentId
     *
     * @param integer $departmentId
     *
     * @return AdvantageDepartment
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
     * Set advantageId
     *
     * @param integer $advantageId
     *
     * @return AdvantageDepartment
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
