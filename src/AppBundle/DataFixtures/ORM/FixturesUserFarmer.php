<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\User\Farmer;

class FixturesUserFarmer extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        //  Create admin user1
        $userFarm1 = new Farmer();
        $userFarm1->setUsername('userfarm1');        
        $userFarm1->setEnabled(true);
        $userFarm1->setEmail('farm1@gmail.com');
        $userFarm1->setPlainPassword('test');
        $userFarm1->setRoles(array('ROLE_FARMER'));
        $userFarm1->setFirstName('Eric');
        $userFarm1->setLastName('Adomou');
        $userFarm1->setPhone('97502447');
        $userFarm1->setProfil('2');
        $userFarm1->setNomEntreprise('Dyo agro');
        $userFarm1->setAdresse('Cotonou');
        $userFarm1->setTypeProfile('Grossise');
        $userFarm1->setDomaine('Produit laitier');
        $em->persist($userFarm1);
        $em->flush();
        $this->addReference('userFarm1', $userFarm1);
        
    }

    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}
