<?php

namespace Pierre\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MailList
 *
 * @ORM\Table(name="mail_list")
 * @ORM\Entity(repositoryClass="Pierre\SiteBundle\Repository\MailListRepository")
 */
class MailList
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
     * @return MailList
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

}
