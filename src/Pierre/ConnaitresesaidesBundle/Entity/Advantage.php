<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Advantage
 *
 * @ORM\Table(name="advantage")
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\AdvantageRepository")
 */
class Advantage {

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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="organism", type="string", length=255)
     */
    private $organism;

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
     * @ORM\Column(name="price", type="string", length=255)
     */
    private $price;

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
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=1023)
     */
    private $logo;

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
     * @return Advantage
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
     * Set organism
     *
     * @param string $organism
     *
     * @return Advantage
     */
    public function setOrganism($organism) {
        $this->organism = $organism;

        return $this;
    }

    /**
     * Get organism
     *
     * @return string
     */
    public function getOrganism() {
        return $this->organism;
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
     * @return Advantage
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
     * @return Advantage
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
     * @return Advantage
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
     * @return Advantage
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
     * Set price
     *
     * @param string $price
     *
     * @return Advantage
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Advantage
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
     * @return Advantage
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
     * Set logo
     *
     * @param string $logo
     *
     * @return Aid
     */
    public function setLogo($logo) {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo() {
        return $this->logo;
    }
}
