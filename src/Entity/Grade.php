<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GradeRepository::class)]
class Grade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $grade;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'grades')]
    #[ORM\JoinColumn(nullable: false)]
    private $idStudent;

    #[ORM\ManyToOne(targetEntity: Subject::class, inversedBy: 'grades')]
    #[ORM\JoinColumn(nullable: false)]
    private $idSubject;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrade(): ?int
    {
        return $this->grade;
    }

    public function setGrade(?int $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getIdStudent(): ?Student
    {
        return $this->idStudent;
    }

    public function setIdStudent(?Student $idStudent): self
    {
        $this->idStudent = $idStudent;

        return $this;
    }

    public function getIdSubject(): ?Subject
    {
        return $this->idSubject;
    }

    public function setIdSubject(?Subject $idSubject): self
    {
        $this->idSubject = $idSubject;

        return $this;
    }
}
