<?php

namespace florian\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//On va utiliser la classe UploadedFile afin de pouvoir étendre nos type à celui des fichier média, en l'occurence
//ici nos images.
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ImageArticle
 *
 * @ORM\Table(name="image_article")
 * @ORM\Entity(repositoryClass="florian\BlogBundle\Entity\ImageArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ImageArticle
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
     * @var text
     *
     * @ORM\Column(name="url", type="text")
     */
    private $url;

    /**
     * @var text
     *
     * @ORM\Column(name="alt", type="text")
     */
    private $alt;

    /**
    * @var string
    *
    * @ORM\Column(name="extension", type="text")
    */
    private $extension;

                          /*******************
                            Upload Image
                            *******************/
    // On ne met pas d'annotation parce que cette attribut ne sera pas persisté. Il va servir pour notre formulaire et aussi
    //pour hydrater nos deux attribut $url et $alt
    private $file;

    //Cette attribut va guarder temporairement le nom. Il sera utilise pour mes évènement doctrine de cycle de vie
    private $tempFilename;

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
     * Set url
     *
     * @param string $url
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set file
     *
     * @param UploadedFile $file
     * @return Image
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        //S'il n'y a pas de fichier pour cette entité
        if($this->getUrl() != null)
        {
            //On sauvegarde son nom via celui de l'url qui est le nom du fichier parce que ce dernier sera modifier par la suite
            $this->setTempFilename($this->getUrl());

            //On réinitialise les valeur d nos attributs Url et Alt
            $this->setUrl(null);
            $this->setAlt(null);
            $this->setExtension(null);
        }

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
    * Set tempFilename
    *
    * @return Image
    */
    public function setTempFilename($tempFilename)
    {
        $this->tempFilename = $tempFilename;

        return $this;
    }

    /**
    * Get tempFilename
    *
    * @return string
    */
    public function getTempFilename()
    {
        return $this->tempFilename;
    }

     /**
     * Set extension
     *
     * @param string $extension
     * @return Image
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate()
    */
    public function preUpload()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif)
        if ($this->getFile() == null)
        {
            return;
        }

        //Je concatène le nom et l'extension
        $nomFichier = $this->getFile()->getClientOriginalName();
        $extensionFichier = $this->getFile()->getClientOriginalExtension();

        // On va recupérer l'extension du fichier
        $this->setExtension($extensionFichier);

        //On va générer le texte alt de notre balise "<img/>"
        $this->setAlt($nomFichier);

        if($this->getFile() != null)
        {
            //L'ULR sera un identifiant aléatoire et unique
            $idAleatoire = sha1(uniqid(mt_rand(), true));
            $this->setUrl($idAleatoire . '.' . $this->getExtension());
        }


    }

    /**
    *
    * @ORM\PostPersist()
    * @ORM\PostUpdate()
    */
    public function upload()
    {

        // Si jamais il n'y a pas de fichier (champ facultatif)
        if ($this->getFile() == null)
        {
            return;
        }


        //On déplace notre fichier où ont le désire dans le premier paramêtre, et on le renomme dans le second paramêtre
        //Rappel : $url contient un id aléatoire et unique. Si une erreur survient, celle ci sera lié à la non
        //persistence de celle-ci en base de données
        $this->getFile()->move($this->getUploadRootDir(), $this->getUrl());

        //Si on a un nom de fichier temporaire, c'est qu'un fichier existe
        if($this->getTempFilename() != null)
        {
            //On récupère l'ancien nom pour le concaténer avec le chemin relatif racine vers web/uploads/img
            //getUrl contient toujours l'ancienne url
            $ancienFichier= $this->getUploadRootDir().'/'. $this->getTempFilename();

            //Si le fichier existe on le supprime
            if(file_exists($ancienFichier))
            {
                unlink($ancienFichier);
            }

            //On vide le fichier temporaire
            $this->setTempFilename(null);
        }
    }

    /**
    * @ORM\PreRemove()
    */
    public function preRemoveUpload()
    {
        //On va sauvegarder le chemin et le nom du fichier avant suppression
        $this->setTempFilename($this->getUploadDir().'/'.$this->getUrl());
    }

    /**
    * @ORM\PostRemove()
    */
    public function removeUpload()
    {
        //Ici on a plus accès au nom du fichier, on va alors utiliser le nom du fichier enregistré dans notre tempFileName
        if(file_exists($this->getTempFilename()))
        {
            //On supprime le fichier
            unlink($this->getTempFilename());
        }
    }

    public function getUploadDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur
        return 'uploads/images/article/' . $this->getId();
    }

    public function getUploadRootDir()
    {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
    * webPath
    *
    * Cette fonction va nous permettre de récupérer le chemin vers notre fichier
    *
    * @return chemin de notre fichier de manière relative
    */
    public function getWebPath()
    {
        return $this->getUploadDir() . '/' . $this->getUrl();
    }
}