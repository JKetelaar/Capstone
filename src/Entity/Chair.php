<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ChairRepository")
 */
class Chair
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="BookingTable", inversedBy="chairs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ChairTable;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChairTable(): ?BookingTable
    {
        return $this->ChairTable;
    }

    public function setChairTable(?BookingTable $ChairTable): self
    {
        $this->ChairTable = $ChairTable;

        return $this;
    }
}
