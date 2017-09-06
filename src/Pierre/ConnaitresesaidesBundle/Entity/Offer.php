<?php

namespace Pierre\ConnaitresesaidesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offer
 *
 * @ORM\Table(name="offer")
 * @ORM\Entity(repositoryClass="Pierre\ConnaitresesaidesBundle\Repository\OfferRepository")
 */
class Offer {

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
     * @var date
     *
     * @ORM\Column(name="name", type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    private $dateBegin;

    /**
     * @var date
     *
     * @ORM\Column(name="name", type="datetime")
     */
    private $dateEnd;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="OfferType")
     * @ORM\JoinColumn(name="offertype_id", referencedColumnName="id", nullable=false)
     */
    private $offerTypeID;

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
     * @return Offer
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
     * Set dateBegin
     *
     * @param datetime $dateBegin
     *
     * @return Offer
     */
    public function setDateBegin($dateBegin) {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    /**
     * Get dateBegin
     *
     * @return datetime
     */
    public function getDateBegin() {
        return $this->dateBegin;
    }

    /**
     * Set dateEnd
     *
     * @param datetime $dateEnd
     *
     * @return Offer
     */
    public function setDateEnd($dateEnd) {
        $this->dateBegin = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return datetime
     */
    public function getDateEnd() {
        return $this->dateEnd;
    }


    /**
     * Set offerTypeID
     *
     * @param string $offerTypeID
     *
     * @return Offer
     */
    public function setOfferTypeID($offerTypeID) {
        $this->offerTypeID = $offerTypeID;

        return $this;
    }

    /**
     * Get offerTypeID
     *
     * @return string
     */
    public function getOfferTypeID() {
        return $this->offerTypeID;
    }



    /**
     * Set dateDebut
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
