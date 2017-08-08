<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfferDepartment
 *
 * @ORM\Table(name="offer_department")
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\OfferDepartmentRepository")
 */
class OfferDepartment
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
     * @ORM\ManyToOne(targetEntity="Offer", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="offer_id", referencedColumnName="id", nullable=false)
     */
    private $offerId;
    
    
    
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
     * @return OfferDepartment
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
     * Set offerId
     *
     * @param integer $offerId
     *
     * @return OfferCity
     */
    public function setOfferId($offerId)
    {
        $this->offerId = $offerId;

        return $this;
    }

    /**
     * Get offerId
     *
     * @return int
     */
    public function getOfferId()
    {
        return $this->offerId;
    }
}
