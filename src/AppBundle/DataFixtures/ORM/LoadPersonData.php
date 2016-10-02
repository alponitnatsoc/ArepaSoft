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
        $person->setFirstName('Andrés');
        $person->setSecondName('Felipe');
        $person->setLastName1('Ramírez');
        $person->setLastName2('Bonilla');
        $person->setDocument('1020772509');
        $person->setDocumentType('CC');
        $manager->persist($person);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
?> 