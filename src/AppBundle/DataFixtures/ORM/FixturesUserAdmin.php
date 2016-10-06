<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\User\Admin;

class FixturesUserAdmin extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        //  Create admin user1
        $user1 = new Admin();
        $user1->setUsername('admin');        
        $user1->setEnabled(true);
        $user1->setEmail('jtocson@gmail.com');
        $user1->setPlainPassword('adminpass');
        $user1->setRoles(array('ROLE_SUPER_ADMIN'));
        $user1->setFirstName('Jacques');
        $user1->setLastName('Adjahoungbo');
        $user1->setPhone('97502447');
        $user1->setProfil('admin');
        $em->persist($user1);
        $em->flush();
        $this->addReference('admin', $user1);
        
    }

    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}
