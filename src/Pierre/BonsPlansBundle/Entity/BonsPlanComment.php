<?php

namespace Pierre\BonsPlansBundle\Entity;

/**
 * Description of Comment
 *
 * @author Pierre BELIN
 */
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Pierre\BonsPlansBundle\Repository\BonsPlanCommentRepository")
 * @ORM\Table(name="bonsplanscomment")
 * @ORM\HasLifecycleCallbacks()
 */
class BonsPlanComment {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $user;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\Column(type="string")
     */
    private $mail;

    /**
     * @ORM\ManyToOne(targetEntity="BonsPlan", inversedBy="comments")
     * @ORM\JoinColumn(name="bonsplan_id", referencedColumnName="id")
     */
    private $bonsplan;

    /**
     * @var datetime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var datetime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return Comment
     */
    public function setUser($user) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Comment
     */
    public function setMail($mail) {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return boolean
     */
    public function getMail() {
        return $this->mail;
    }

    /**
     * Set bonsplan
     *
     * @param string $bonsplan
     *
     * @return BonsPlanComment
     */
    public function setBonsPlan($bonsplan) {
        $this->bonsplan = $bonsplan;

        return $this;
    }

    /**
     * Get bonsplan
     *
     * @return BonsPlan
     */
    public function getBonsPlan() {
        return $this->bonsplan;
    }


        /**
     * Set comment
     *
     * @param datetime $comment
     *
     * @return Comment
     */
    public function setComment($comment) {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return comment
     */
    public function getComment() {
        return $this->comment;
    }



    /**
     * Set created
     *
     * @param datetime $created
     *
     * @return Comment
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return datetime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     *
     * @return Comment
     */
    public function setUpdated($updated) {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return datetime
     */
    public function getUpdated() {
        return $this->updated;
    }

    public function __construct() {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }

    public function setUpdatedValue() {
        $this->setUpdated(new \DateTime());
    }

}
