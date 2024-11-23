<?php

namespace App\Entity;

use App\Repository\OfficeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OfficeRepository::class)]
class Office
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column]
    private ?int $numberOfJobs = null;

    #[ORM\Column]
    private ?int $numberLevel = null;

    #[ORM\OneToMany(targetEntity: Employee::class, mappedBy: 'office')]
    private Collection $employees;

    /**
     * @var Collection<int, MapScheme>
     */
    #[ORM\OneToMany(targetEntity: MapScheme::class, mappedBy: 'office')]
    private Collection $mapSchemes;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->mapSchemes = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getNumberOfJobs(): ?int
    {
        return $this->numberOfJobs;
    }

    public function setNumberOfJobs(int $numberOfJobs): static
    {
        $this->numberOfJobs = $numberOfJobs;

        return $this;
    }

    public function getNumberLevel(): ?int
    {
        return $this->numberLevel;
    }

    public function setNumberLevel(int $numberLevel): static
    {
        $this->numberLevel = $numberLevel;

        return $this;
    }

    public function removeCabinet(Cabinet $cabinet): static
    {
        if ($this->cabinets->removeElement($cabinet)) {
            // set the owning side to null (unless already changed)
            if ($cabinet->getOffice() === $this) {
                $cabinet->setOffice(null);
            }
        }

        return $this;
    }

    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function setEmployees(Collection $employees): Office
    {
        $this->employees = $employees;
        return $this;
    }

    /**
     * @return Collection<int, MapScheme>
     */
    public function getMapSchemes(): Collection
    {
        return $this->mapSchemes;
    }

    public function addMapScheme(MapScheme $mapScheme): static
    {
        if (!$this->mapSchemes->contains($mapScheme)) {
            $this->mapSchemes->add($mapScheme);
            $mapScheme->setOffice($this);
        }

        return $this;
    }

    public function removeMapScheme(MapScheme $mapScheme): static
    {
        if ($this->mapSchemes->removeElement($mapScheme)) {
            // set the owning side to null (unless already changed)
            if ($mapScheme->getOffice() === $this) {
                $mapScheme->setOffice(null);
            }
        }

        return $this;
    }
}
