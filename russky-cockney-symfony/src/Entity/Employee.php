<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private ?string $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fio = null;

    #[ORM\Column(length: 255)]
    private ?string $specialization = null;

    #[ORM\Column(length: 255)]
    private ?string $department = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $role = null;

    #[ORM\OneToMany(targetEntity: EquipmentCopy::class, mappedBy: "employee")]
    private Collection $equipmentCopies;

    /**
     * @var Collection<int, Workspace>
     */
    #[ORM\OneToMany(targetEntity: Workspace::class, mappedBy: 'employee')]
    private Collection $workspaces;

    /**
     * @var Collection<int, Request>
     */
    #[ORM\OneToMany(targetEntity: Request::class, mappedBy: 'employee')]
    private Collection $requests;

    #[ORM\OneToMany(targetEntity: Request::class, mappedBy: 'specialist')]
    private Collection $claim;

    #[ORM\ManyToOne(inversedBy: "employees")]
    private ?Office $office = null;

    public function __construct()
    {
        $this->workspaces = new ArrayCollection();
        $this->requests = new ArrayCollection();
        $this->equipmentCopies = new ArrayCollection();
    }

    public function getEquipmentCopies(): Collection
    {
        return $this->equipmentCopies;
    }

    public function setEquipmentCopies(Collection $equipmentCopies): Employee
    {
        $this->equipmentCopies = $equipmentCopies;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): Employee
    {
        $this->id = $id;
        return $this;
    }

    public function getFio(): ?string
    {
        return $this->fio;
    }

    public function setFio(string $fio): static
    {
        $this->fio = $fio;

        return $this;
    }

    public function getSpecialization(): ?string
    {
        return $this->specialization;
    }

    public function setSpecialization(string $specialization): static
    {
        $this->specialization = $specialization;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(string $department): static
    {
        $this->department = $department;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Employee
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return Collection<int, Workspace>
     */
    public function getWorkspaces(): Collection
    {
        return $this->workspaces;
    }

    public function addWorkspace(Workspace $workspace): static
    {
        if (!$this->workspaces->contains($workspace)) {
            $this->workspaces->add($workspace);
            $workspace->setEmployee($this);
        }

        return $this;
    }

    public function removeWorkspace(Workspace $workspace): static
    {
        if ($this->workspaces->removeElement($workspace)) {
            // set the owning side to null (unless already changed)
            if ($workspace->getEmployee() === $this) {
                $workspace->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Request>
     */
    public function getRequests(): Collection
    {
        return $this->requests;
    }

    public function addRequest(Request $request): static
    {
        if (!$this->requests->contains($request)) {
            $this->requests->add($request);
            $request->setEmployee($this);
        }

        return $this;
    }

    public function removeRequest(Request $request): static
    {
        if ($this->requests->removeElement($request)) {
            // set the owning side to null (unless already changed)
            if ($request->getEmployee() === $this) {
                $request->setEmployee(null);
            }
        }

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): Employee
    {
        $this->role = $role;
        return $this;
    }

    public function getOffice(): ?Office
    {
        return $this->office;
    }

    public function setOffice(?Office $office): Employee
    {
        $this->office = $office;
        return $this;
    }

    public function getClaim(): Collection
    {
        return $this->claim;
    }

    public function setClaim(Collection $claim): Employee
    {
        $this->claim = $claim;
        return $this;
    }
}
