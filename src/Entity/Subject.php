<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
class Subject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['SW_find_all', 'SW_find_one', 'subject_find_all'])]
    private $name;

    #[ORM\Column(type: 'date')]
    #[Groups(['subject_find_all'])]
    private $dateOfStart;

    #[ORM\Column(type: 'date')]
    #[Groups(['subject_find_all'])]
    private $dateOfEnd;

    #[ORM\ManyToOne(targetEntity: SupportWorker::class, inversedBy: 'subjects')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['subject_find_all'])]
    private $idSupportWorker;

    #[ORM\ManyToOne(targetEntity: Promotion::class, inversedBy: 'subjects')]
    #[ORM\JoinColumn(nullable: false)]
//    #[Groups(['subject_find_all'])]
    private $idPromotion;

    #[ORM\OneToMany(mappedBy: 'idSubject', targetEntity: Grade::class)]
    private $grades;

    public function __construct()
    {
        $this->grades = new ArrayCollection();
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

    public function getDateOfStart(): ?\DateTimeInterface
    {
        return $this->dateOfStart;
    }

    public function setDateOfStart(\DateTimeInterface $dateOfStart): self
    {
        $this->dateOfStart = $dateOfStart;

        return $this;
    }

    public function getDateOfEnd(): ?\DateTimeInterface
    {
        return $this->dateOfEnd;
    }

    public function setDateOfEnd(\DateTimeInterface $dateOfEnd): self
    {
        $this->dateOfEnd = $dateOfEnd;

        return $this;
    }

    public function getIdSupportWorker(): ?SupportWorker
    {
        return $this->idSupportWorker;
    }

    public function setIdSupportWorker(?SupportWorker $idSupportWorker): self
    {
        $this->idSupportWorker = $idSupportWorker;

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
            $grade->setIdSubject($this);
        }

        return $this;
    }

    public function removeGrade(Grade $grade): self
    {
        if ($this->grades->removeElement($grade)) {
            // set the owning side to null (unless already changed)
            if ($grade->getIdSubject() === $this) {
                $grade->setIdSubject(null);
            }
        }

        return $this;
    }
}
