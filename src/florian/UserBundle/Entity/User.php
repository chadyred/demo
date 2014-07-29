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

    public function __construct() {
        parent::__construct();
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

}
