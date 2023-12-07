<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\LevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LevelRepository::class)]
#[ApiResource(
    operations: [
        new Get()
    ],
    normalizationContext: ['groups' => ['level:read']]
)]
class Level
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['level:read', 'workApplication:read'])]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['level:read', 'workApplication:read'])]
    private ?float $minSalary = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['level:read', 'workApplication:read'])]
    private ?float $maxSalary = null;

    #[ORM\OneToMany(mappedBy: 'level', targetEntity: WorkAplication::class)]
    #[Groups(['level:read'])]
    private Collection $workAplications;

    public function __construct()
    {
        $this->workAplications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getMinSalary(): ?float
    {
        return $this->minSalary;
    }

    public function setMinSalary(?float $minSalary): static
    {
        $this->minSalary = $minSalary;

        return $this;
    }

    public function getMaxSalary(): ?float
    {
        return $this->maxSalary;
    }

    public function setMaxSalary(?float $maxSalary): static
    {
        $this->maxSalary = $maxSalary;

        return $this;
    }

    /**
     * @return Collection<int, WorkAplication>
     */
    public function getWorkAplications(): Collection
    {
        return $this->workAplications;
    }

    public function addWorkAplication(WorkAplication $workAplication): static
    {
        if (!$this->workAplications->contains($workAplication)) {
            $this->workAplications->add($workAplication);
            $workAplication->setLevel($this);
        }

        return $this;
    }

    public function removeWorkAplication(WorkAplication $workAplication): static
    {
        if ($this->workAplications->removeElement($workAplication)) {
            // set the owning side to null (unless already changed)
            if ($workAplication->getLevel() === $this) {
                $workAplication->setLevel(null);
            }
        }

        return $this;
    }
}
