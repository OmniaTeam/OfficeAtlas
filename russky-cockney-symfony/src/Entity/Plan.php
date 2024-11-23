<?php

namespace App\Entity;

use App\Repository\PlanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanRepository::class)]
class Plan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'plans')]
    private ?Cabinet $cabinet = null;

    #[ORM\ManyToOne(inversedBy: 'plans')]
    private ?Workspace $workspace = null;

    #[ORM\ManyToOne(inversedBy: 'plans')]
    private ?MapScheme $mapScheme = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $locX = null;

    #[ORM\Column]
    private ?int $locY = null;

    #[ORM\Column]
    private ?int $height = null;

    #[ORM\Column]
    private ?int $width = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCabinet(): ?Cabinet
    {
        return $this->cabinet;
    }

    public function setCabinet(?Cabinet $cabinet): static
    {
        $this->cabinet = $cabinet;

        return $this;
    }

    public function getWorkspace(): ?Workspace
    {
        return $this->workspace;
    }

    public function setWorkspace(?Workspace $workspace): static
    {
        $this->workspace = $workspace;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getLocX(): ?int
    {
        return $this->locX;
    }

    public function setLocX(int $locX): static
    {
        $this->locX = $locX;

        return $this;
    }

    public function getLocY(): ?int
    {
        return $this->locY;
    }

    public function setLocY(int $locY): static
    {
        $this->locY = $locY;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getMapScheme(): ?MapScheme
    {
        return $this->mapScheme;
    }

    public function setMapScheme(?MapScheme $mapScheme): Plan
    {
        $this->mapScheme = $mapScheme;
        return $this;
    }
}
