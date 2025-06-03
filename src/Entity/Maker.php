<?php

namespace App\Entity;

use App\Repository\MakerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MakerRepository::class)]
class Maker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['maker:read', 'vehicle:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 125)]
    #[Groups(['maker:read', 'vehicle:read'])]
    private ?string $name = null;

    /**
     * @var Collection<int, Vehicle>
     */
    #[Groups(['maker:read'])]
    #[ORM\OneToMany(targetEntity: Vehicle::class, mappedBy: 'maker')]
    private Collection $vehicles;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
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
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): static
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles->add($vehicle);
            $vehicle->setMaker($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): static
    {
        if ($this->vehicles->removeElement($vehicle)) {
            // set the owning side to null (unless already changed)
            if ($vehicle->getMaker() === $this) {
                $vehicle->setMaker(null);
            }
        }

        return $this;
    }
}
