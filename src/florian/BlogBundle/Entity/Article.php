<?php

namespace florian\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use florian\UserBundle\Entity;

//Namespace qui va nous permettre d'appeler la classe Annotation, qui va nous permettre de créer nos slugs
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="florian\BlogBundle\Entity\ArticleRepository")
 */
class Article
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     *  Par syllogisme il sera ausi unique
     * @ORM\Column(name="titre", type="string", length=255, unique=true)
     */
    private $titre;
    
    /**
    * @var string qui va contenir le titre séparer par des tiret qui va permettre de créé des Slug, c'est-à-dire des URL unique
    * qui possèderont des mot clair, ce qui permettra à google de mieux nous référencer
    *
    * @Gedmo\Slug(fields={"titre"})
    * @ORM\Column(name="slugTitre", length=128, unique=true)
    */
    private $slugTitre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    //Attribut qui va retenir la date en cours lorsque l'on intervient sur un article
    /**
    * @var \DateTime
    *
    * @ORM\Column(name="dateEdition", type="datetime")
    */
    private $dateEdition;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(name="publication", type="boolean")
     */
    private $publication;
    
    /**
     * @var ImageArticle
     * 
     * @ORM\OneToOne(targetEntity="florian\BlogBundle\Entity\ImageArticle", cascade={"persist", "remove"})
     */
    private $imageArticle;
    
    /**
    * @ORM\ManyToOne(targetEntity="florian\UserBundle\Entity\User", inversedBy="articles")
    */
    private $user;
    
    public function __construct()
    {
        $this->dateCreation = new \DateTime();
        //Un article n'est pas publié par défaut
        $this->publication = false;
        //Date de maintenant pour construire notre objet. Cependant il sera modifier par un évènement sur écoute
        //lié à une fonction de callback 'updateDateEdition()'
        $this->dateEdition = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Article
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }


    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Article
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Article
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set publication
     *
     * @param boolean $publication 
    * @return Article
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return boolean 
     */
    public function getPublication()
    {
        return $this->publication;
    }
    
    /*------------------------
       Mthode de ma classe Article
       -------------------------------*/

    /**
    * Méthode de callbacks qui à chacune des mise à jour va modifier la date de notre entité lors de sa modification
    *
    * @ORM\PreUpdate
    */
    public function updateDateEdition()
    {
        $this->setDateEdition(new \Datetime());
    }

    /**
     * Set slugTitre
     *
     * @param string $slugTitre
     *
     * @return Article
     */
    public function setSlugTitre($slugTitre)
    {
        $this->slugTitre = $slugTitre;

        return $this;
    }

    /**
     * Get slugTitre
     *
     * @return string
     */
    public function getSlugTitre()
    {
        return $this->slugTitre;
    }

    /**
     * Set dateEdition
     *
     * @param \DateTime $dateEdition
     * @ORM\PreUpdate()
     * @return Article
     */
    public function setDateEdition(\DateTime $dateEdition)
    { 
        $this->dateEdition = $dateEdition;

        return $this;
    }

    /**
     * Get dateEdition
     *
     * @return \DateTime
     */
    public function getDateEdition()
    {
        return $this->dateEdition;
    }

    /**
     * Set user
     *
     * @param \florian\UserBundle\Entity\User $user
     *
     * @return Article
     */
    public function setUser(\florian\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \florian\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set image
     *
     * @param \florian\BlogBundle\Entity\ImageArticle $image
     *
     * Une image n'est pas obligatoire
     * 
     * @return Article
     */
    public function setImageArticle(\florian\BlogBundle\Entity\ImageArticle $image = null)
    {
        $this->imageArticle = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \florian\BlogBundle\Entity\ImageArticle
     */
    public function getImageArticle()
    {
        return $this->imageArticle;
    }
}
