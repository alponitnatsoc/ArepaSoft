<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 29/09/16
 * Time: 10:27 PM
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Course;
use AppBundle\Entity\Faculty;
use AppBundle\Entity\FacultyHasCourses;
use AppBundle\Entity\FacultyHasStudents;
use AppBundle\Entity\FacultyHasTeachers;
use AppBundle\Entity\Person;
use AppBundle\Entity\Student;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadStudentData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * ╔═══════════════════════════════════════════════════════════════╗
     * ║ Function load                                                 ║
     * ║ Creates data in the database entities from excel object.      ║
     * ║ ------------------------------------------------------------- ║
     * ║ Función load                                                  ║
     * ║ Crea los datos en las entidades de la base de datos desde un  ║
     * ║ objeto de excel.                                              ║
     * ╠═══════════════════════════════════════════════════════════════╣
     * ║  @param ObjectManager $manager                                ║
     * ╚═══════════════════════════════════════════════════════════════╝
     */
    public function load(ObjectManager $manager)
    {
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);
        echo "  > Memory usage before: " . (memory_get_usage()/1048576) . " MB" . PHP_EOL;
        $dir = "web/uploads/Files/Students";
        foreach (scandir($dir) as $file) {
            if ('.' === $file || '..' === $file || '.DS_Store' === $file) continue;
            $inputFileType = \PHPExcel_IOFactory::identify($dir . '/' . $file);
            echo '  > loading [3] '.$file.PHP_EOL;
            if($inputFileType!='CSV'){
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                /** @var \PHPExcel $obj */
                $obj = $objReader->load($dir . '/' . $file);
                echo "  > loading [3] Students". PHP_EOL;
                /** @var \PHPExcel_Worksheet $worksheet */
                foreach ($obj->getWorksheetIterator() as $worksheet){
                    $rowCount = 1;
                    /** @var \PHPExcel_Worksheet_Row $row */
                    foreach ($worksheet->getRowIterator() as $row){
                        if($rowCount>2){
                            /** @var Faculty $faculty */
                            $faculty = $manager->getRepository("AppBundle:Faculty")->findOneBy(array('facultyCode'=>'DPT-ISIST'));
                            if($faculty){
                                /** @var Person $person */
                                $person = $manager->getRepository("AppBundle:Person")->findOneBy(array('document'=>$worksheet->getCellByColumnAndRow(5,$rowCount)));
                                if(!$person){
                                    $person = new Person();
                                    $person->setDocument($worksheet->getCellByColumnAndRow(5, $rowCount)->getValue());
                                    $person->setFirstName($worksheet->getCellByColumnAndRow(6, $rowCount)->getValue());
                                    if($worksheet->getCellByColumnAndRow(7, $rowCount)->getValue()){
                                        $person->setSecondName($worksheet->getCellByColumnAndRow(7, $rowCount)->getValue());
                                    }
                                    $person->setLastName1($worksheet->getCellByColumnAndRow(8, $rowCount)->getValue());
                                    if($worksheet->getCellByColumnAndRow(9, $rowCount)->getValue()){
                                        $person->setLastName2($worksheet->getCellByColumnAndRow(9, $rowCount)->getValue());
                                    }
                                    $person->setDocumentType($worksheet->getCellByColumnAndRow(4, $rowCount)->getValue());
                                    $person->setPhone($worksheet->getCellByColumnAndRow(13, $rowCount)->getValue());
                                    $person->setEmail($worksheet->getCellByColumnAndRow(14, $rowCount)->getValue());
                                    $person->setGender($worksheet->getCellByColumnAndRow(16, $rowCount)->getValue());
                                    $person->setPeopleSoftUserName(explode('@',$worksheet->getCellByColumnAndRow(14, $rowCount)->getValue())[0]);
                                    $manager->persist($person);
                                    $manager->flush();
                                }
                                $student = $manager->getRepository("AppBundle:Student")->findOneBy(array('studentCode' => $worksheet->getCellByColumnAndRow(0, $rowCount)->getValue()));
                                if(!$student){
                                    $student = new Student();
                                    $student->setStudentCode($worksheet->getCellByColumnAndRow(0, $rowCount)->getValue());
                                    $student->setPersonPerson($person);
                                    $person->setStudent($student);
                                    $manager->persist($student);
                                    $manager->persist($person);
                                    $manager->flush();
                                }
                                $facultyHasStudent = $manager->getRepository("AppBundle:FacultyHasStudents")->findOneBy(array('facultyFaculty'=>$faculty,'studentStudent'=>$student));
                                if(!$facultyHasStudent){
                                    $facultyHasStudent = new FacultyHasStudents();
                                    $facultyHasStudent->setFacultyFaculty($faculty);
                                    $facultyHasStudent->setStudentStudent($student);
                                    $student->addStudentHasFaculty($facultyHasStudent);
                                    $faculty->addFacultyHasStudent($facultyHasStudent);
                                    $manager->persist($facultyHasStudent);
                                    $manager->flush();
                                }
                            }
                            $manager->clear();
                        }
                        if($rowCount%2000==0){
                            echo "  > loading [5] Students..".$rowCount. PHP_EOL;
                        }
                        $rowCount++;
                    }
                }
            }
        }
        echo "  > Memory usage after: " . (memory_get_usage()/1048576) . " MB" . PHP_EOL;
    }

    public function getOrder()
    {
        return 5;
    }
}
?> 