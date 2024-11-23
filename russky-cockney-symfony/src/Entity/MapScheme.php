<?php

namespace App\Entity;

use App\Repository\MapSchemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MapSchemeRepository::class)]
class MapScheme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\ManyToOne(inversedBy: 'mapSchemes')]
    private ?Office $office = null;

    #[ORM\OneToMany(targetEntity: Plan::class, mappedBy: 'mapScheme')]
    private Collection $plans;

    public function __construct()
    {
        $this->plans = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getOffice(): ?Office
    {
        return $this->office;
    }

    public function setOffice(?Office $office): static
    {
        $this->office = $office;

        return $this;
    }

    public function getPlans(): Collection
    {
        return $this->plans;
    }

    public function setPlans(Collection $plans): MapScheme
    {
        $this->plans = $plans;
        return $this;
    }
}
