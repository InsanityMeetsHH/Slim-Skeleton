<?php
namespace App\Entity;

use App\Utility\GeneralUtility;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    
    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="users")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    private $role = 2;
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $name;
    
    /**
     * @ORM\Column(type="string")
     */
    private $pass;
    
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
     * Get $pass
     * 
     * @return string
     */
    function getPass() {
        return $this->pass;
    }
    
    /**
     * Set $pass
     * 
     * @param string $pass
     */
    function setPass($pass) {
        $this->pass = GeneralUtility::encryptPassword($pass);
    }
    
    /**
     * Get $role
     * 
     * @return Role
     */
    function getRole() {
        return $this->role;
    }
    
    /**
     * Set $role
     * 
     * @param Role $role
     */
    function setRole($role) {
        $this->role = $role;
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
}