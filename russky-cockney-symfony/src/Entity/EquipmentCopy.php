<?php

namespace App\Entity;

use App\Repository\EquipmentCopyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentCopyRepository::class)]
class EquipmentCopy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $model = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $serialnum = null;

    #[ORM\Column(length: 255)]
    private ?string $quality = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datebuy = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'equipmentCopies')]
    private ?Employee $employee = null;

    #[ORM\OneToMany(targetEntity: EquipmentCopy::class, mappedBy: 'equipmentCopy')]
    private Collection $requests;

    #[ORM\ManyToOne(inversedBy: 'equipmentCopies')]
    private ?Office $office = null;

    public function __construct()
    {
        $this->requests = new ArrayCollection();
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): EquipmentCopy
    {
        $this->employee = $employee;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSerialnum(): ?string
    {
        return $this->serialnum;
    }

    public function setSerialnum(string $serialnum): static
    {
        $this->serialnum = $serialnum;

        return $this;
    }

    public function getQuality(): ?string
    {
        return $this->quality;
    }

    public function setQuality(string $quality): static
    {
        $this->quality = $quality;

        return $this;
    }

    public function getDatebuy(): ?\DateTimeInterface
    {
        return $this->datebuy;
    }

    public function setDatebuy(?\DateTimeInterface $datebuy): static
    {
        $this->datebuy = $datebuy;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): EquipmentCopy
    {
        $this->name = $name;
        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): EquipmentCopy
    {
        $this->model = $model;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): EquipmentCopy
    {
        $this->type = $type;
        return $this;
    }

    public function getRequests(): Collection
    {
        return $this->requests;
    }

    public function setRequests(Collection $requests): EquipmentCopy
    {
        $this->requests = $requests;
        return $this;
    }

    public function getOffice(): ?Office
    {
        return $this->office;
    }

    public function setOffice(?Office $office): EquipmentCopy
    {
        $this->office = $office;
        return $this;
    }
}
