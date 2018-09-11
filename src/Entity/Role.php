<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="role")
 */
class Role extends \App\MappedSuperclass\Base
{
    
    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $name;
    
    /**
     * One Role has many Users.
     * 
     * @ORM\OneToMany(targetEntity="User", mappedBy="role")
     */
    private $users;

    public function __construct() {
        $this->users = new ArrayCollection();
    }

    /**
     * Get $name
     * 
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Set $name
     * 
     * @param string $name
     */
    public function setName($name) {
        $this->name = strtolower($name);
        
        return $this;
    }

    /**
     * Get $users
     * 
     * @return ArrayCollection
     */
    public function getUsers() {
        return $this->users;
    }
}