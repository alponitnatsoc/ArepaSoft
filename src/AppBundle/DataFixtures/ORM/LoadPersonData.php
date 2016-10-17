<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 29/09/16
 * Time: 10:27 PM
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Person;

class LoadPersonData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $person = new Person();
        $person->setFirstName('Administrator');
        $manager->persist($person);
        $manager->flush();

        $this->addReference('admin-person', $person);
    }

    public function getOrder()
    {
        return 1;
    }
}
?> 