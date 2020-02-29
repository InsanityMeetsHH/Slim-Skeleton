<?php
namespace App\Entity;

use App\Utility\GeneralUtility;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends \App\MappedSuperclass\Base {
    
    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $name;
    
    /**
     * Encoded password
     * 
     * @ORM\Column(type="string", options={"comment": "Encoded password"})
     */
    private $pass;
    
    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="users")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
     */
    private $role;
    
    /**
     * 1 if 2FA is enabled
     * 
     * @ORM\Column(type="boolean", name="two_factor", options={"comment": "1 if 2FA is enabled"})
     */
    private $twoFactor = FALSE;
    
    /**
     * Secret for 2FA validation and authenticator app
     * 
     * @ORM\Column(type="string", name="two_factor_secret", options={"comment": "Secret for 2FA validation and authenticator app"})
     */
    private $twoFactorSecret = '';
    
    /**
     * One User has many RecoveryCodes.
     * 
     * @ORM\OneToMany(targetEntity="RecoveryCode", mappedBy="user", cascade={"persist", "remove"})
     */
    private $recoveryCodes;

    public function __construct() {
        $this->recoveryCodes = new ArrayCollection();
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
     * Get $pass
     * 
     * @return string
     */
    public function getPass() {
        return $this->pass;
    }
    
    /**
     * Set $pass
     * 
     * @param string $pass
     */
    public function setPass($pass) {
        $this->pass = GeneralUtility::encryptPassword($pass);
        
        return $this;
    }
    
    /**
     * Get $role
     * 
     * @return Role
     */
    public function getRole() {
        return $this->role;
    }
    
    /**
     * Set $role
     * 
     * @param Role $role
     */
    public function setRole($role) {
        $this->role = $role;
        
        return $this;
    }
    
    /**
     * Set $twoFactor
     * 
     * @param boolean $twoFactor
     */
    public function setTwoFactor($twoFactor) {
        $this->twoFactor = $twoFactor;
        
        return $this;
    }
    
    /**
     * Has $twoFactor
     * 
     * @return boolean
     */
    public function hasTwoFactor() {
        return $this->twoFactor;
    }

    /**
     * Get $twoFactorSecret
     * 
     * @return string
     */
    public function getTwoFactorSecret() {
        return $this->twoFactorSecret;
    }
    
    /**
     * Set $twoFactorSecret
     * 
     * @param string $twoFactorSecret
     */
    public function setTwoFactorSecret($twoFactorSecret) {
        $this->twoFactorSecret = $twoFactorSecret;
        
        return $this;
    }

    /**
     * Get $recoveryCodes
     * 
     * @return ArrayCollection
     */
    public function getRecoveryCodes() {
        return $this->recoveryCodes;
    }
}