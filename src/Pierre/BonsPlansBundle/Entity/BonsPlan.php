<?php

namespace Pierre\BonsPlansBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Blog
 *
 * @ORM\Table(name="bonsplan")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Pierre\BonsPlansBundle\Repository\BonsPlanRepository")
 */
class BonsPlan {

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
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=16384)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="text", length=1024)
     */
    private $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, unique=true)
     */
    private $link;

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
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="BonsPlanComment", mappedBy="bonsplan")
     */
    protected $comments;

    public function addComment(BonsPlanComment $comment) {
        $this->comments[] = $comment;
    }

    public function getComments() {
        return $this->comments;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Blog
     */
    public function setTitle($title) {
        $this->title = $title;
        $this->setSlug($this->title);
        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set bonsplan
     *
     * @param string $content
     *
     * @return Content
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get bonsplan
     *
     * @return string
     */
    public function getContent($length = null) {
        if (false === is_null($length) && $length > 0) {
            return substr($this->content, 0, $length);
        } else {
            return $this->content;
        }
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Blog
     */
    public function setlogo($logo) {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getlogo() {
        return $this->logo;
    }


    /**
     * Set link
     *
     * @param text $link
     *
     * @return BonsPlan
     */
    public function setLink($link) {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return text
     */
    public function getLink() {
        return $this->link;
    }
    /**
     * Set created
     *
     * @param datetime $created
     *
     * @return Blog
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
     * @return Blog
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

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Blog
     */
    public function setSlug($slug) {
        $this->slug = $slug;
        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug() {
        return $this->slug;
    }

    public function __construct() {
        $this->comments = new ArrayCollection();
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }


    public function setUpdatedValue() {
        $this->setUpdated(new \DateTime());
    }

    public function __toString() {
        return $this->getTitle();
    }

    public function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv')) {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }


    /**
     * Remove comment
     *
     * @param \Pierre\BlogBundle\Entity\Comment $comment
     */
    public function removeComment(\Pierre\BlogBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }
}
