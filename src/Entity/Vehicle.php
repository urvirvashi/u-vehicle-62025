<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['vehicle:read', 'maker:read', 'vehicleTechDetail:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 125)]
    #[Groups(['vehicle:read', 'maker:read', 'vehicleTechDetail:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    #[Groups(['vehicle:read'])]
    private ?Maker $maker = null;

    #[ORM\OneToOne(mappedBy: 'vehicle', cascade: ['persist', 'remove'], targetEntity: VehicleTechnicalDetail::class)]
    #[Groups(['vehicle:read', 'vehicleTechDetail:read'])]
    private ?VehicleTechnicalDetail $vehicleTech = null;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getMaker(): ?Maker
    {
        return $this->maker;
    }

    public function setMaker(?Maker $maker): static
    {
        $this->maker = $maker;

        return $this;
    }

    public function getVehicleTech(): ?VehicleTechnicalDetail
    {
        return $this->vehicleTech;
    }

    public function setVehicleTech(VehicleTechnicalDetail $vehicleTech): static
    {
        // set the owning side of the relation if necessary
        if ($vehicleTech->getVehicle() !== $this) {
            $vehicleTech->setVehicle($this);
        }

        $this->vehicleTech = $vehicleTech;

        return $this;
    }
}
