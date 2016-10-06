<?php

namespace web;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="Jack\AdvertBundle\Entity\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
  
    /**
     * @ORM\Column(type="string", length=255, name="filename")
     * @var string $filename
     */
    protected $filename;
    
    /**
     * @ORM\ManyToOne(targetEntity="Jack\TestBundle\Entity\Advert", inversedBy="images", cascade={"persist"})
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="image_advert_id", referencedColumnName="id")
     * })
     */
    protected $advert;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/documents';
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
     * Set filename
     *
     * @param string $filename
     * @return Image
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set advert
     *
     * @param \Jack\TestBundle\Entity\Advert $advert
     * @return Image
     */
    public function setAdvert(\Jack\TestBundle\Entity\Advert $advert = null)
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * Get advert
     *
     * @return \Jack\TestBundle\Entity\Advert 
     */
    public function getAdvert()
    {
        return $this->advert;
    }
}
