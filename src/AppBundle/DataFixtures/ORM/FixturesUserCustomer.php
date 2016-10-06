<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\User\Customer;

class FixturesUserCustomer extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        //  Create admin user1
        $userCustom1 = new Customer();
        $userCustom1->setUsername('customer1');        
        $userCustom1->setEnabled(true);
        $userCustom1->setEmail('custom1@gmail.com');
        $userCustom1->setPlainPassword('test');
        $userCustom1->setRoles(array('ROLE_CUSTOMER'));
        $userCustom1->setFirstName('Gisèle');
        $userCustom1->setLastName('Agassounon');
        $userCustom1->setPhone('96610110');
        $userCustom1->setProfil('1');
        $em->persist($userCustom1);
        $em->flush();
        $this->addReference('userCustom1', $userCustom1);
        
    }

    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}
