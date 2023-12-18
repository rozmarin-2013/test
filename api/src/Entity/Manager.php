<?php

namespace App\Entity;

use App\Repository\ManagerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ManagerRepository::class)]
class Manager
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\OneToMany(mappedBy: 'manager', targetEntity: Order::class)]
    private Collection $manager;

    public function __construct()
    {
        $this->manager = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getManager(): Collection
    {
        return $this->manager;
    }

    public function addManager(Order $manager): static
    {
        if (!$this->manager->contains($manager)) {
            $this->manager->add($manager);
            $manager->setManager($this);
        }

        return $this;
    }

    public function removeManager(Order $manager): static
    {
        if ($this->manager->removeElement($manager)) {
            // set the owning side to null (unless already changed)
            if ($manager->getManager() === $this) {
                $manager->setManager(null);
            }
        }

        return $this;
    }

}
