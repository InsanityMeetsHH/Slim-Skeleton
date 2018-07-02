<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="recovery_code")
 */
class RecoveryCode extends \App\MappedSuperclass\Base
{
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="recoveryCodes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    
    /**
     * @ORM\Column(type="string")
     */
    private $code;
    
    /**
     * Get $user
     * 
     * @return User
     */
    public function getUser() {
        return $this->user;
    }
    
    /**
     * Set $user
     * 
     * @param User $user
     */
    public function setUser($user) {
        $this->user = $user;
        
        return $this;
    }

    /**
     * Get $code
     * 
     * @return string
     */
    public function getCode() {
        return $this->code;
    }
    
    /**
     * Set $code
     * 
     * @param string $code
     */
    public function setCode($code) {
        $this->code = $code;
        
        return $this;
    }
}