<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aid
 *
 * @ORM\Table(name="aid")
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\AidRepository")
 */
class Aid {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="agemin", type="integer", options={"default":0})
     */
    private $agemin;

    /**
     * @var int
     *
     * @ORM\Column(name="agemax", type="integer", options={"default":99})
     */
    private $agemax;

    /**
     * @var int
     *
     * @ORM\Column(name="salaryminpermonth", type="integer", options={"default":0})
     */
    private $salaryminpermonth;

    /**
     * @var int
     *
     * @ORM\Column(name="salarymaxpermonth", type="integer", options={"default":9999})
     */
    private $salarymaxpermonth;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="string", length=255)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=511, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=1023)
     */
    private $link;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Organism")
     * @ORM\JoinColumn(name="organism_id", referencedColumnName="id", nullable=false)
     */
    private $organismID;


    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Aid
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }


    /**
     * Set agemin
     *
     * @param integer $agemin
     *
     * @return Advantage
     */
    public function setAgemin($agemin) {
        $this->agemin = $agemin;

        return $this;
    }

    /**
     * Get agemin
     *
     * @return int
     */
    public function getAgemin() {
        return $this->agemin;
    }

    /**
     * Set agemax
     *
     * @param integer $agemax
     *
     * @return Aid
     */
    public function setAgemax($agemax) {
        $this->agemax = $agemax;

        return $this;
    }

    /**
     * Get agemax
     *
     * @return int
     */
    public function getAgemax() {
        return $this->agemax;
    }

    /**
     * Set salaryminpermonth
     *
     * @param integer $salaryminpermonth
     *
     * @return Aid
     */
    public function setSalaryminpermonth($salaryminpermonth) {
        $this->salaryminpermonth = $salaryminpermonth;

        return $this;
    }

    /**
     * Get salaryminpermonth
     *
     * @return int
     */
    public function getSalaryminpermonth() {
        return $this->salaryminpermonth;
    }

    /**
     * Set salarymaxpermonth
     *
     * @param integer $salarymaxpermonth
     *
     * @return Aid
     */
    public function setSalarymaxpermonth($salarymaxpermonth) {
        $this->salarymaxpermonth = $salarymaxpermonth;

        return $this;
    }

    /**
     * Get salarymaxpermonth
     *
     * @return int
     */
    public function getSalarymaxpermonth() {
        return $this->salarymaxpermonth;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return Aid
     */
    public function setAmount($amount) {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Aid
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Aid
     */
    public function setLink($link) {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink() {
        return $this->link;
    }

    /**
     * Set organismID
     *
     * @param string $organismId
     *
     * @return Aid
     */
    public function setOrganismID($organismId) {
        $this->organismID = $organismId;

        return $this;
    }

    /**
     * Get organismID
     *
     * @return string
     */
    public function getOrganismID() {
        return $this->organismID;
    }

}
