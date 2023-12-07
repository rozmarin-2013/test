<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\PositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PositionRepository::class)]
#[ApiResource(
    operations: [
        new Get()
    ],
    normalizationContext: ['groups' => ['position:read']]
)]

class Position
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['position:read', 'workApplication:read'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'position', targetEntity: WorkAplication::class, orphanRemoval: true)]
    #[Groups(['position:read'])]
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
            $workAplication->setPosition($this);
        }

        return $this;
    }

    public function removeWorkAplication(WorkAplication $workAplication): static
    {
        if ($this->workAplications->removeElement($workAplication)) {
            // set the owning side to null (unless already changed)
            if ($workAplication->getPosition() === $this) {
                $workAplication->setPosition(null);
            }
        }

        return $this;
    }
}
