<?php
namespace App\MappedSuperclass;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
class Base {
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $deleted = 0;
    
    /**
     * @ORM\Column(type="datetime", name="updated_at")
     */
    protected $updatedAt;
    
    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt = null;
    
    /**
     * Get $id
     * 
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Is $deleted
     * 
     * @return boolean
     */
    public function isDeleted() {
        return $this->deleted;
    }
    
    /**
     * Set $deleted
     * 
     * @param boolean $deleted
     */
    public function setDeleted($deleted) {
        $this->deleted = $deleted;
        
        return $this;
    }

    /**
     * Get $updatedAt
     * 
     * @return \DateTime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }
    
    /**
     * Set $updatedAt
     * 
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
        
        return $this;
    }

    /**
     * Get $createdAt
     * 
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }
    
    /**
     * Set $createdAt
     * 
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        
        return $this;
    }
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps() {
        $this->setUpdatedAt(new \DateTime("now", new \DateTimeZone("UTC")));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime("now", new \DateTimeZone("UTC")));
        }
    }
    
    /**
     * Get array copy of object
     *
     * @return array
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }
}
