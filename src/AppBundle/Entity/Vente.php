<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Vente
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\VenteRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Vente
{

    /**
     * @var int
     *
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;
    
    /**
     * @var lieu Lieu ou se trouve le produit.
     * 
     * @ORM\Column(type="string")
     */
    private $lieu;
    
    
    /**
     * @var dateCreation la date de creation vente.
     * 
     *
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;
    

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
     * @ORM\Column(type="string")
     */
    private $uniteMesure;
    
    /**
     * @var dateLimit date de limite
     * 
     *
     * @ORM\Column(type="date")
     */
    private $dateLimit;
    
    /**
     * @var prixUnit prix unitaire
     * 
     *
     * @ORM\Column(type="integer")
     */
    private $prixUnit;
    
    /**
     * @var description detail complementaire
     * 
     *
     * @ORM\Column(type="text")
     */
    private $description;
    

    
    /**
     * @var Product
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Product", cascade={"persist"})
     */
    private $product;
    
    /**
     * @var User\User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\User", inversedBy="ventes")
     */
    private $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\City")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     * @Assert\Type("AppBundle\Entity\City")
     * @Assert\NotNull()
     */
    protected $city;
    
    

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName")
     * 
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     *
     * @var string
     */
    private $productCategroy;
    
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Product
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Product
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
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
     * Set lieu
     *
     * @param string $lieu
     * @return Vente
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string 
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set poids
     *
     * @param integer $poids
     * @return Vente
     */
    public function setPoids($poids)
    {
        $this->poids = $poids;

        return $this;
    }

    /**
     * Get poids
     *
     * @return integer 
     */
    public function getPoids()
    {
        return $this->poids;
    }
    
    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return Vente
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
     * @return Vente
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
     * Set dateLimit
     *
     * @ORM\PrePersist
     */
    public function setDateLimit()
    {
        $this->dateLimit = new \DateTime();
        $this->dateLimit->add(new \DateInterval('P5D'));
    }

    /**
     * Get dateLimit
     *
     * @return \DateTime 
     */
    public function getDateLimit()
    {
        return $this->dateLimit;
    }

    /**
     * Set prixUnit
     *
     * @param integer $prixUnit
     * @return Vente
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
     * @return Vente
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
     * Set product
     *
     * @param \AppBundle\Entity\Product $product
     * @return Vente
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
     * @return Vente
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
     * Set updatedAt
     *
     * @ORM\PreUpdate
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set city
     *
     * @param \AppBundle\Entity\City $city
     *
     * @return Vente
     */
    public function setCity(\AppBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \AppBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }
    
    static public function getLuceneIndex()
    {
        if (file_exists($index = self::getLuceneIndexFile())) {
            return \Zend_Search_Lucene::open($index);
        }
 
        return \Zend_Search_Lucene::create($index);
    }
 
    static public function getLuceneIndexFile()
    {
        return __DIR__.'/../../../web/data/vente.index';
    }
    
    
    /**
     * Set createdAt
     **
     * @ORM\PostPersist
     * @ORM\PostUpdate
     */
    public function updateLuceneIndex()
    {
        $index = self::getLuceneIndex();

        // remove existing entries
        foreach ($index->find('pk:'.$this->getId()) as $hit)
        {
          $index->delete($hit->id);
        }
 
        // don't index expired and non-activated jobs
//        if ($this->isExpired() || !$this->getIsActivated())
//        {
//          return;
//        }
 
        $doc = new \Zend_Search_Lucene_Document();
 
        // store job primary key to identify it in the search results
        $doc->addField(\Zend_Search_Lucene_Field::Keyword('pk', $this->getId()));
 
        // index job fields
        $doc->addField(\Zend_Search_Lucene_Field::UnStored('product', $this->getProduct(), 'utf-8'));
        $doc->addField(\Zend_Search_Lucene_Field::UnStored('lieu', $this->getLieu(), 'utf-8'));

        // add job to the index
        $index->addDocument($doc);
        $index->commit();
    }
    
    
    /**
     * Set createdAt
     **
     * @ORM\PostRemove
     */
    public function deleteLuceneIndex()
    {
        $index = self::getLuceneIndex();
 
        foreach ($index->find('pk:'.$this->getId()) as $hit) {
            $index->delete($hit->id);
        }
    }

    /**
     * Set productCategroy
     *
     * @param string $productCategroy
     *
     * @return Vente
     */
    public function setProductCategroy($productCategroy)
    {
        $this->productCategroy = $productCategroy;

        return $this;
    }

    /**
     * Get productCategroy
     *
     * @return string
     */
    public function getProductCategroy()
    {
        return $this->productCategroy;
    }
}
