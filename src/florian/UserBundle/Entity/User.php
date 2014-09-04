<?php

namespace florian\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Customer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="florian\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
   /**
    * @var articles
    *
    * Ici on va créé la relation OneToMany (Many: article to One user) : un utilisateur disparait; ses article aussi.
    * Si un article est supprimé de sa liste, la classe propriétaire sera orpheline, on supprime alors son entité liée
    * 
    * @ORM\OneToMany(targetEntity="florian\BlogBundle\Entity\Article", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=true)
    */
    protected $articles;

    public function __construct() {
        parent::__construct();
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = array('ROLE_UTILISATEUR');
    }

    public function __toString() {
        return $this->getLogin();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Add article
     *
     * @param \florian\BlogBundle\Entity\Article $article
     *
     * @return User
     */
    public function addArticle(\florian\BlogBundle\Entity\Article $article)
    {
        $this->articles[] = $article;
        $article->setUser($this);

        return $this;
    }

    /**
     * Remove article
     *
     * @param \florian\BlogBundle\Entity\Article $article
     */
    public function removeArticle(\florian\BlogBundle\Entity\Article $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }
}
