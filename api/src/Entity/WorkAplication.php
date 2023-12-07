<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\WorkAplicationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\Link;

#[ORM\Entity(repositoryClass: WorkAplicationRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Post()
    ],
    normalizationContext: [
        'groups' => ['workApplication:read'],
    ],
    denormalizationContext: [
        'groups' => ['workApplication:write'],
    ],
    paginationItemsPerPage: 15
)]
#[ApiResource(
    description: 'Get applications by status',
    uriTemplate: '/users/workApplications/{status}',
    operations: [new GetCollection(
        uriVariables: 'status'
    )],
    normalizationContext: [
        'groups' => ['workApplication:read'],
    ],
)]
#[ApiFilter(OrderFilter::class)]
class WorkAplication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['workApplication:read', 'workApplication:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['workApplication:read', 'workApplication:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['workApplication:read', 'workApplication:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['workApplication:read', 'workApplication:write'])]
    #[Assert\NotBlank]
    #[Assert\Regex(
        '/[0-9]{9}/',
        message:  'The telephone must have nine digits.',
    ),
    ]
    #[Assert\Type(
        type: 'numeric',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    private ?int $telephone = null;

    #[ORM\Column]
    #[Groups(['workApplication:read', 'workApplication:write'])]
    #[Assert\NotBlank]
    #[Assert\Type(
        type: 'float',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    #[Assert\GreaterThan(
        value: 0,
    )]
    #[Assert\LessThanOrEqual(
        value: 100000,
    )]
    private ?float $salary = null;

    #[ORM\ManyToOne(inversedBy: 'workAplications')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['workApplication:read'])]
    private ?Level $level = null;

    #[ORM\ManyToOne(inversedBy: 'workAplications')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    #[Groups(['workApplication:read', 'workApplication:write'])]
    private ?Position $position = null;

    #[ORM\Column(type: "string", enumType: Status::class)]
    #[Groups(['workApplication:read'])]
    #[ApiFilter(SearchFilter::class, strategy: 'extra')]
    private Status|null $status = null;

    public function __construct()
    {
        $this->status = Status::new;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): static
    {
        $this->salary = $salary;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    #[ORM\PrePersist]
    public function setLevelValue(): void
    {
       dd(444);
    }

    public function setLevel(?Level $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getPosition(): ?Position
    {
        return $this->position;
    }

    public function setPosition(?Position $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): static
    {
        $this->status = $status;

        return $this;
    }
}
