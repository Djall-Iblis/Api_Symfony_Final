<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PromotionRepository::class)]
class Promotion extends \App\Entity\SupportWorker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['promotion_find_all', 'promotion_find_one',
        'student_find_one', 'student_post',
        'student_put'])]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['promotion_find_all', 'promotion_find_one'])]
    private $dateOfRelease;

    #[ORM\OneToMany(mappedBy: 'idPromotion', targetEntity: Student::class)]
    private $students;

    #[ORM\OneToMany(mappedBy: 'idPromotion', targetEntity: Subject::class)]
    private $subjects;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->subjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDateOfRelease(): ?string
    {
        return $this->dateOfRelease;
    }

    public function setDateOfRelease(string $dateOfRelease): self
    {
        $this->dateOfRelease = $dateOfRelease;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->setIdPromotion($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getIdPromotion() === $this) {
                $student->setIdPromotion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Subject>
     */
    public function getSubjects(): Collection
    {
        return $this->subjects;
    }

    public function addSubject(Subject $subject): self
    {
        if (!$this->subjects->contains($subject)) {
            $this->subjects[] = $subject;
            $subject->setIdPromotion($this);
        }

        return $this;
    }

    public function removeSubject(Subject $subject): self
    {
        if ($this->subjects->removeElement($subject)) {
            // set the owning side to null (unless already changed)
            if ($subject->getIdPromotion() === $this) {
                $subject->setIdPromotion(null);
            }
        }

        return $this;
    }
}
