<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="role")
 */
class Role extends \App\MappedSuperclass\LowerCaseUniqueName
{
    
    /**
     * One Role has many Users.
     * 
     * @ORM\OneToMany(targetEntity="User", mappedBy="role")
     */
    private $users;

    /**
     * Get $users
     * 
     * @return ArrayCollection
     */
    public function getUsers() {
        return $this->users;
    }

    public function __construct() {
        $this->users = new ArrayCollection();
    }
}