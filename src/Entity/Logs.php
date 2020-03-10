<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(normalizationContext={"groups"={"all"}}, attributes={"order"={"id": "DESC"}})
 * @ORM\Entity(repositoryClass="App\Repository\LogsRepository")
 */
class Logs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({"all"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     *
     * @Groups({"all"})
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"all"})
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="logs")
     */
    private $user;

    /**
     * Logs constructor.
     */
    public function __construct()
    {
        $this->time = date('H:i');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time): void
    {
        $this->time = $time;
    }
}
