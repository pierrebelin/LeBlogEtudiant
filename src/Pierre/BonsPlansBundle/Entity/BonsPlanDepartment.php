<?php

namespace Pierre\BonsPlansBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BonPlanDepartment
 *
 * @ORM\Table(name="bonsplan_department")
 * @ORM\Entity(repositoryClass="Pierre\BonsPlansBundle\Repository\BonsPlanDepartmentRepository")
 */
class BonsPlanDepartment
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
     * @ORM\ManyToOne(targetEntity="Pierre\ConnaitresesaidesBundle\Entity\Department", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id", nullable=false)
     */
    private $departmentId;

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
     * Set departmentId
     *
     * @param integer $departmentId
     *
     * @return BonPlanDepartment
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
     * Set bonplanId
     *
     * @param integer $bonplanId
     *
     * @return BonPlanDepartment
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

