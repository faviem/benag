<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * A person (alive, dead, undead, or fictional).
 *
 * @see http://schema.org/Person Documentation on Schema.org
 *
 *
 * @ORM\Entity
 * @ORM\Table("User")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", length=15, type="string")
 * @ORM\DiscriminatorMap(
 *     {
 *     "user"="AppBundle\Entity\User\User",
 *     "admin"="AppBundle\Entity\User\Admin",
 *     "customer"="AppBundle\Entity\User\Customer",
 *     "farmer"="AppBundle\Entity\User\Farmer"
 *     }
 * )
 */ 

class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;
    /**
     * @var string The username of the author.
     *
     * @Groups({"user_read", "user_write"})
     * 
     * @Assert\Length(min="6")
     */
    protected $username;

    /**
     * @var string The email of the user.
     *
     * @Groups({"user_read", "user_write"})
     */
    protected $email;

    /**
     * @var string Plain password. Used for model validation. Must not be persisted.
     *
     * @Groups({"user_write"})
     */
    protected $plainPassword;

    /**
     * @var boolean Shows that the user is enabled
     *
     * @Groups({"user_read", "user_write"})
     */
    protected $enabled;

    /**
     * @var array Array, role(s) of the user
     *
     * @Groups({"user_read", "user_write"})
     */
    protected $roles;
    
    /**
     * @var string
     *
     * @ORM\Column(name="user_firstName", type="string", length=45, nullable=false)
     * @Assert\Length(min="2")
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="user_lastName", type="string", length=45, nullable=false)
     * @Assert\Length(min="2")
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="user_phone", type="string", length=45, nullable=false)
     */
    private $phone;
    /**
     * @var \DateTime Date of birth.
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date
     */
    private $birthDate;

    /**
     * @var string Gender of the person.
     *
     * @ORM\Column(nullable=true)
     * @Assert\Type(type="string")
     */
    private $gender;
    
    /**
     * @var string 
     *
     * @ORM\Column(nullable=false)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     */
    private $profil;
    
    /**
     * @var string The avatar.
     *
     * @ORM\Column(nullable=true)
     * @Assert\Type(type="string")
     */
    private $avatar;

    /**
     * @var ventes[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vente", mappedBy="user", cascade={"persist"})
     */
    private $ventes;
    
    
    /**
     * @var commandes[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commande", mappedBy="user", cascade={"persist"})
     */
    private $commandes;
    
    
    public function __construct()
    {
        parent::__construct();
        $this->commandes = new ArrayCollection();
        $this->ventes = new ArrayCollection();
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime 
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return User
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
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Add ventes
     *
     * @param \AppBundle\Entity\Vente $ventes
     * @return User
     */
    public function addVente(\AppBundle\Entity\Vente $ventes)
    {
        $this->ventes[] = $ventes;

        return $this;
    }

    /**
     * Remove ventes
     *
     * @param \AppBundle\Entity\Vente $ventes
     */
    public function removeVente(\AppBundle\Entity\Vente $ventes)
    {
        $this->ventes->removeElement($ventes);
    }

    /**
     * Get ventes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVentes()
    {
        return $this->ventes;
    }

    /**
     * Add commandes
     *
     * @param \AppBundle\Entity\Commande $commandes
     * @return User
     */
    public function addCommande(\AppBundle\Entity\Commande $commandes)
    {
        $this->commandes[] = $commandes;

        return $this;
    }

    /**
     * Remove commandes
     *
     * @param \AppBundle\Entity\Commande $commandes
     */
    public function removeCommande(\AppBundle\Entity\Commande $commandes)
    {
        $this->commandes->removeElement($commandes);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommandes()
    {
        return $this->commandes;
    }
    
//    static function getRoleNames()
//    {
//        $pathToSecurity = __DIR__ . '/../../../..' . '/app/config/security.yml';
//        $yaml = new Parser();
//        $rolesArray = $yaml->parse(file_get_contents($pathToSecurity));
//        $arrayKeys = array();
//        foreach ($rolesArray['security']['role_hierarchy'] as $key => $value)
//        {
//            //never allow assigning super admin
//            if ($key != 'ROLE_SUPER_ADMIN')
//                $arrayKeys[$key] = User::convertRoleToLabel($key);
//            //skip values that are arrays --- roles with multiple sub-roles
//            if (!is_array($value))
//                if ($value != 'ROLE_SUPER_ADMIN')
//                    $arrayKeys[$value] = User::convertRoleToLabel($value);
//        }
//        //sort for display purposes
//        asort($arrayKeys);
//        return $arrayKeys;
//    }
//
//    static private function convertRoleToLabel($role)
//    {
//        $roleDisplay = str_replace('ROLE_', '', $role);
//        $roleDisplay = str_replace('_', ' ', $roleDisplay);
//        return ucwords(strtolower($roleDisplay));
//    }

    /**
     * Set profil
     *
     * @param string $profil
     *
     * @return User
     */
    public function setProfil($profil)
    {
        $this->profil = $profil;

        return $this;
    }

    /**
     * Get profil
     *
     * @return string
     */
    public function getProfil()
    {
        return $this->profil;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }
}
