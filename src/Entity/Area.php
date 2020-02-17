<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\AreaRepository")
 */
class Area
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Floor", inversedBy="areas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $floor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="BookingTable", mappedBy="area")
     */
    private $tables;

    public function __construct()
    {
        $this->tables = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFloor(): ?Floor
    {
        return $this->floor;
    }

    public function setFloor(?Floor $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|BookingTable[]
     */
    public function getTables(): Collection
    {
        return $this->tables;
    }

    public function addTable(BookingTable $table): self
    {
        if (!$this->tables->contains($table)) {
            $this->tables[] = $table;
            $table->setArea($this);
        }

        return $this;
    }

    public function removeTable(BookingTable $table): self
    {
        if ($this->tables->contains($table)) {
            $this->tables->removeElement($table);
            // set the owning side to null (unless already changed)
            if ($table->getArea() === $this) {
                $table->setArea(null);
            }
        }

        return $this;
    }
}
