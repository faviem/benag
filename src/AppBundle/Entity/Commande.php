<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Commande
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Commande
{

    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var dateCreation la date de commande.
     * 
     *
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;
    
    /**
     * @ORM\Column(type="datetime", nullable = true)
     *
     * @var \DateTime
     */
    private $dateMiseAjour;
    /**
     * @var quantite
     * 
     *
     * @ORM\Column(type="integer")
     */
    
    private $quantite;

    /**
     * @var uniteMesure Unite de mesure
     * 
     *
     * @ORM\Column(type="integer", nullable = true)
     */
    private $uniteMesure;
    
    /**
     * @var prixUnit prix unitaire
     * 
     *
     * @ORM\Column(type="integer",nullable = true)
     */
    private $prixUnit;
    
    /**
     * @var description detail complementaire
     * 
     *
     * @ORM\Column(type="text", nullable = true)
     */
    private $description;

    /**
     * @var permanent boolean. Approvisionnement permanent
     * @ORM\Column(name="commande_permanent", type="boolean", options={"default" : false})
     */
    private $permanent = false;
    
    /**
     * @var brouillon boolean. 
     * @ORM\Column(name="commande_brouillon", type="boolean", options={"default" : false})
     */
    private $brouillon = false;
    
    /**
     * @var soumis boolean. commande soumise
     * @ORM\Column(name="commande_soumis", type="boolean", options={"default" : false})
     */
    private $soumis = false;
    
    /**
     * @var accepte boolean. commande accepte
     * @ORM\Column(name="commande_accepte", type="boolean", options={"default" : false})
     */
    private $accepte = false;
    
    /**
     * @var annule boolean. commande annule
     * @ORM\Column(name="commande_annule", type="boolean", options={"default" : false})
     */
    private $annule = false;
    
    /**
     * @var livre boolean. commande livre
     * @ORM\Column(name="commande_livre", type="boolean", options={"default" : false})
     */
    private $livre = false;

    /**
     * @var Product
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Product")
     */
    private $product;
    
    /**
     * @var User\User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\User", inversedBy="commandes")
     */
    private $user;

    public function __construct()
    {
        
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
     * Set createdAt
     **
     * @ORM\PrePersist
     */
    public function setDateCreation()
    {
        $this->dateCreation = new \DateTime();
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
     * Set dateMiseAjour
     *
     * @ORM\PreUpdate
     */
    public function setUpdatedAt()
    {
        $this->dateMiseAjour = new \DateTime();
    }

    /**
     * Get dateMiseAjour
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->dateMiseAjour;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return Commande
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set uniteMesure
     *
     * @param integer $uniteMesure
     * @return Commande
     */
    public function setUniteMesure($uniteMesure)
    {
        $this->uniteMesure = $uniteMesure;

        return $this;
    }

    /**
     * Get uniteMesure
     *
     * @return integer 
     */
    public function getUniteMesure()
    {
        return $this->uniteMesure;
    }

    /**
     * Set prixUnit
     *
     * @param integer $prixUnit
     * @return Commande
     */
    public function setPrixUnit($prixUnit)
    {
        $this->prixUnit = $prixUnit;

        return $this;
    }

    /**
     * Get prixUnit
     *
     * @return integer 
     */
    public function getPrixUnit()
    {
        return $this->prixUnit;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Commande
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set permanent
     *
     * @param boolean $permanent
     * @return Commande
     */
    public function setPermanent($permanent)
    {
        $this->permanent = $permanent;

        return $this;
    }

    /**
     * Get permanent
     *
     * @return boolean 
     */
    public function getPermanent()
    {
        return $this->permanent;
    }

    /**
     * Set brouillon
     *
     * @param boolean $brouillon
     * @return Commande
     */
    public function setBrouillon($brouillon)
    {
        $this->brouillon = $brouillon;

        return $this;
    }

    /**
     * Get brouillon
     *
     * @return boolean 
     */
    public function getBrouillon()
    {
        return $this->brouillon;
    }

    /**
     * Set soumis
     *
     * @param boolean $soumis
     * @return Commande
     */
    public function setSoumis($soumis)
    {
        $this->soumis = $soumis;

        return $this;
    }

    /**
     * Get soumis
     *
     * @return boolean 
     */
    public function getSoumis()
    {
        return $this->soumis;
    }

    /**
     * Set accepte
     *
     * @param boolean $accepte
     * @return Commande
     */
    public function setAccepte($accepte)
    {
        $this->accepte = $accepte;

        return $this;
    }

    /**
     * Get accepte
     *
     * @return boolean 
     */
    public function getAccepte()
    {
        return $this->accepte;
    }

    /**
     * Set annule
     *
     * @param boolean $annule
     * @return Commande
     */
    public function setAnnule($annule)
    {
        $this->annule = $annule;

        return $this;
    }

    /**
     * Get annule
     *
     * @return boolean 
     */
    public function getAnnule()
    {
        return $this->annule;
    }

    /**
     * Set livre
     *
     * @param boolean $livre
     * @return Commande
     */
    public function setLivre($livre)
    {
        $this->livre = $livre;

        return $this;
    }

    /**
     * Get livre
     *
     * @return boolean 
     */
    public function getLivre()
    {
        return $this->livre;
    }



    /**
     * Set product
     *
     * @param \AppBundle\Entity\Product $product
     * @return Commande
     */
    public function setProduct(\AppBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User\User $user
     * @return Commande
     */
    public function setUser(\AppBundle\Entity\User\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set dateMiseAjour
     *
     * @param \DateTime $dateMiseAjour
     *
     * @return Commande
     */
    public function setDateMiseAjour($dateMiseAjour)
    {
        $this->dateMiseAjour = $dateMiseAjour;

        return $this;
    }

    /**
     * Get dateMiseAjour
     *
     * @return \DateTime
     */
    public function getDateMiseAjour()
    {
        return $this->dateMiseAjour;
    }
}
