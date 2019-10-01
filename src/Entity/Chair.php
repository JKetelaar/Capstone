<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Table", inversedBy="chairs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ChairTable;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChairTable(): ?Table
    {
        return $this->ChairTable;
    }

    public function setChairTable(?Table $ChairTable): self
    {
        $this->ChairTable = $ChairTable;

        return $this;
    }
}
