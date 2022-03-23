<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastName;

    #[ORM\Column(type: 'integer')]
    private $age;

    #[ORM\Column(type: 'string', length: 255)]
    private $dateOfArrival;

    #[ORM\ManyToOne(targetEntity: Promotion::class, inversedBy: 'students')]
    #[ORM\JoinColumn(nullable: false)]
    private $idPromotion;

    #[ORM\OneToMany(mappedBy: 'idStudent', targetEntity: Grade::class)]
    private $grades;

    public function __construct()
    {
        $this->grades = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getDateOfArrival(): ?string
    {
        return $this->dateOfArrival;
    }

    public function setDateOfArrival(string $dateOfArrival): self
    {
        $this->dateOfArrival = $dateOfArrival;

        return $this;
    }

    public function getIdPromotion(): ?Promotion
    {
        return $this->idPromotion;
    }

    public function setIdPromotion(?Promotion $idPromotion): self
    {
        $this->idPromotion = $idPromotion;

        return $this;
    }

    /**
     * @return Collection<int, Grade>
     */
    public function getGrades(): Collection
    {
        return $this->grades;
    }

    public function addGrade(Grade $grade): self
    {
        if (!$this->grades->contains($grade)) {
            $this->grades[] = $grade;
            $grade->setIdStudent($this);
        }

        return $this;
    }

    public function removeGrade(Grade $grade): self
    {
        if ($this->grades->removeElement($grade)) {
            // set the owning side to null (unless already changed)
            if ($grade->getIdStudent() === $this) {
                $grade->setIdStudent(null);
            }
        }

        return $this;
    }
}
