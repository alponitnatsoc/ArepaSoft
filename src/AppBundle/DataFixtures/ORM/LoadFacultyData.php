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
use AppBundle\Entity\Faculty;

class LoadFacultyData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $faculty = new Faculty();
        $faculty->setFacultyCode('DPT-ISIST');
        $faculty->setName('Departamento Ingeniería de Sistemas');
        $manager->persist($faculty);
        $manager->flush();

        $this->addReference('isist-faculty', $faculty);
    }

    public function getOrder()
    {
        return 1;
    }
}
?> 