<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Category;

class FixturesCategory extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {

        $category1 = new Category();
        $category1->setName('Céréale');        
        $em->persist($category1);
        
        $category2 = new Category();
        $category2->setName('Fruit'); 
        $em->persist($category2);

        $category3 = new Category();
        $category3->setName('Légume'); 
        $em->persist($category3);
        
        $em->flush();
        $this->addReference('category1', $category1);
        $this->addReference('category2', $category2);
        $this->addReference('category3', $category3);
    }

    public function getOrder()
    {
        return 4; // the order in which fixtures will be loaded
    }
}
