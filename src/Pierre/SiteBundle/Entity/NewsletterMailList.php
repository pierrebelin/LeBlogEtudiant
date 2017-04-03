<?php

namespace Pierre\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NewsletterMailList
 *
 * @ORM\Table(name="newsletter_mail_list")
 * @ORM\Entity(repositoryClass="Pierre\SiteBundle\Repository\NewsletterMailListRepository")
 */
class NewsletterMailList
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
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, unique=true)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;


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
     * Set mail
     *
     * @param string $mail
     *
     * @return NewsletterMailList
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set nom
     *
     * @param integer $nom
     *
     * @return NewsletterMailList
     */
    public function setCityId($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getCityId()
    {
        return $this->nom;
    }
}
