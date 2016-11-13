<?php
/**
 * Created by PhpStorm.
 * User: erikaxu
 * Date: 14/09/16
 * Time: 12:22 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * Class ClassCourse
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="class_course",
 *     uniqueConstraints={
 *          @UniqueConstraint(
 *              name="codeClassUnique", columns={"class_code","active_period"}
 *          )
 *     })
 * @ORM\Entity
 */
class ClassCourse
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id_class",type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idclass;

    /**
     * @var string
     *
     * @ORM\Column(name="class_code", type="string", length=8, nullable=true)
     */
    private $classCode;

    /**
     * @var string
     *
     * @ORM\Column(name="active_period",type="string", length=7,nullable=true)
     */
    private $activePeriod;

    /**
     * @var Course
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Course", inversedBy="classes")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="course_id", referencedColumnName="id_course")
     * })
     */
    private $courseCourse;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TeacherDictatesClassCourse", mappedBy="classClass")
     */
    private $classHasTeacher;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\StudentAssistClass",mappedBy="classCourseClassCourse",cascade={"persist"})
     */
    private $classHasStudents;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Rubric", mappedBy="classCourseClassCourse", cascade={"persist"})
     */
    private $rubrics;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classHasTeacher = new \Doctrine\Common\Collections\ArrayCollection();
        $this->classHasStudents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rubrics = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get idclass
     *
     * @return integer
     */
    public function getIdclass()
    {
        return $this->idclass;
    }

    /**
     * Set classCode
     *
     * @param string $classCode
     *
     * @return ClassCourse
     */
    public function setClassCode($classCode)
    {
        $this->classCode = $classCode;

        return $this;
    }

    /**
     * Get classCode
     *
     * @return string
     */
    public function getClassCode()
    {
        return $this->classCode;
    }

    /**
     * Set activePeriod
     *
     * @param string $activePeriod
     *
     * @return ClassCourse
     */
    public function setActivePeriod($activePeriod)
    {
        $this->activePeriod = $activePeriod;

        return $this;
    }

    /**
     * Get activePeriod
     *
     * @return string
     */
    public function getActivePeriod()
    {
        return $this->activePeriod;
    }

    /**
     * Set courseCourse
     *
     * @param \AppBundle\Entity\Course $courseCourse
     *
     * @return ClassCourse
     */
    public function setCourseCourse(\AppBundle\Entity\Course $courseCourse = null)
    {
        $this->courseCourse = $courseCourse;

        return $this;
    }

    /**
     * Get courseCourse
     *
     * @return \AppBundle\Entity\Course
     */
    public function getCourseCourse()
    {
        return $this->courseCourse;
    }

    /**
     * Add classHasTeacher
     *
     * @param \AppBundle\Entity\TeacherDictatesClassCourse $classHasTeacher
     *
     * @return ClassCourse
     */
    public function addClassHasTeacher(\AppBundle\Entity\TeacherDictatesClassCourse $classHasTeacher)
    {
        $this->classHasTeacher[] = $classHasTeacher;

        return $this;
    }

    /**
     * Remove classHasTeacher
     *
     * @param \AppBundle\Entity\TeacherDictatesClassCourse $classHasTeacher
     */
    public function removeClassHasTeacher(\AppBundle\Entity\TeacherDictatesClassCourse $classHasTeacher)
    {
        $this->classHasTeacher->removeElement($classHasTeacher);
    }

    /**
     * Get classHasTeacher
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClassHasTeacher()
    {
        return $this->classHasTeacher;
    }

    /**
     * Add classHasStudent
     *
     * @param \AppBundle\Entity\StudentAssistClass $classHasStudent
     *
     * @return ClassCourse
     */
    public function addClassHasStudent(\AppBundle\Entity\StudentAssistClass $classHasStudent)
    {
        $this->classHasStudents[] = $classHasStudent;

        return $this;
    }

    /**
     * Remove classHasStudent
     *
     * @param \AppBundle\Entity\StudentAssistClass $classHasStudent
     */
    public function removeClassHasStudent(\AppBundle\Entity\StudentAssistClass $classHasStudent)
    {
        $this->classHasStudents->removeElement($classHasStudent);
    }

    /**
     * Get classHasStudents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClassHasStudents()
    {
        return $this->classHasStudents;
    }

    /**
     * Add rubric
     *
     * @param \AppBundle\Entity\Rubric $rubric
     *
     * @return ClassCourse
     */
    public function addRubric(\AppBundle\Entity\Rubric $rubric)
    {
        $this->rubrics[] = $rubric;

        return $this;
    }

    /**
     * Remove rubric
     *
     * @param \AppBundle\Entity\Rubric $rubric
     */
    public function removeRubric(\AppBundle\Entity\Rubric $rubric)
    {
        $this->rubrics->removeElement($rubric);
    }

    /**
     * Get rubrics
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRubrics()
    {
        return $this->rubrics;
    }
}
