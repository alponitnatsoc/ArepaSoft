<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 29/09/16
 * Time: 10:27 PM
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\FacultyHasCourses;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Course;

class LoadCourseData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /**
         * ╔═══════════════════════════════════════════════════════════════╗
         * ║ Reporte generado en el catalogo de consultas SAE              ║
         * ║ Modulo QA Catálogo y Programación                             ║
         * ║ División 1 Catálogo y Sylabus                                 ║
         * ║ Opcion 3 Componentes de asignatura                            ║
         * ║ Parametros de la consulta                                     ║
         * ║ Institucion académica  PUJAV                                  ║
         * ║ Grado Académico --                                            ║
         * ║ Org Académica DPT-ISIST                                       ║
         * ╚═══════════════════════════════════════════════════════════════╝
         *
         * El archivo generado debe guardarse en la carpeta web/uploads/Courses/Files con nombre courses
         */
        /** @var \PHPExcel $obj */
        $obj = \PHPExcel_IOFactory::load("web/uploads/Courses/Files/courses");
        $worksheet = $obj->getActiveSheet();
        $rowCount = 1;
        foreach ($worksheet->getRowIterator() as $row) {
            if($rowCount>2){

                /** @var \PHPExcel_Worksheet_ColumnCellIterator $cellIterator */
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(true); //to loop al cells change to false
                $cellCount = 1;
                /** @var  \PHPExcel_Cell $cell */
                foreach ($cellIterator as $cell) {
                    if (!is_null($cell)) {
                        switch ($cellCount){
                            case 1:
                                $academicGrade =$cell->getValue();
                                break;
                            case 4:
                                $code = $cell->getValue();
                                break;
                            case 5:
                                $name = $cell->getValue();
                                break;
                            case 9:
                               $component = $cell->getValue();
                                break;
                        }
                    }
                    $cellCount++;
                }
                if($manager->getRepository("AppBundle:Course")->findOneBy(array('courseCode'=>$code))!= null){
                    $tCourse = $manager->getRepository("AppBundle:Course")->findOneBy(array('courseCode'=>$code));
                    if($tCourse->getComponent()!= $component){
                        $tCourse->setComponent($tCourse->getComponent(). '-'.$component);
                        $manager->persist($tCourse);
                    }
                }else{
                    $course = new Course();
                    $courseHasFaculty = new FacultyHasCourses();
                    $courseHasFaculty->setCourseCourse($course);
                    $courseHasFaculty->setFacultyFaculty($this->getReference('isist-faculty'));
                    $manager->persist($courseHasFaculty);
                    $course->addCourseHasfaculty($courseHasFaculty);
                    $course->setCreatedAt(new \DateTime());
                    $course->setComponent($component);
                    $course->setCourseCode($code);
                    $course->setAcademicGrade($academicGrade);
                    $course->setNameCourse($name);
                    $manager->persist($course);
                    $manager->flush();
                }
            }
            $rowCount++;
        }



    }

    public function getOrder()
    {
        return 2;
    }
}
?> 