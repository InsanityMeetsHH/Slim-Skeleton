<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="role")
 */
class Role
{
    
    /**
     * One Role has many Users.
     * 
     * @ORM\OneToMany(targetEntity="User", mappedBy="role")
     */
    private $users;
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    
    /**
     * Get $id
     * 
     * @return int
     */
    function getId() {
        return $this->id;
    }

    /**
     * Get $name
     * 
     * @return string
     */
    function getName() {
        return $this->name;
    }
    
    /**
     * Set $name
     * 
     * @param string $name
     */
    function setName($name) {
        $this->name = $name;
    }

    /**
     * Get $users
     * 
     * @return ArrayCollection
     */
    function getUsers() {
        return $this->users;
    }
    
    /**
     * Get array copy of object
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function __construct() {
        $this->users = new ArrayCollection();
    }
}