<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(normalizationContext={"groups"={"all"}}, attributes={"order"={"id": "DESC"}})
 * @ORM\Entity(repositoryClass="App\Repository\AIReportRepository")
 */
class AIReport
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
     * @ORM\Column(type="datetime")
     *
     * @Groups({"all"})
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BookingTable", inversedBy="aiReports")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"all"})
     */
    private $bookingTable;

    /**
     * @ORM\Column(type="text")
     *
     * @Groups({"all"})
     */
    private $action;

    /**
     * AIReport constructor.
     */
    public function __construct()
    {
        $this->date = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     *
     * @Groups("all")
     */
    public function getWebDate()
    {
        return $this->date->format('M/d/Y H:i');
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getBookingTable(): ?BookingTable
    {
        return $this->bookingTable;
    }

    public function setBookingTable(?BookingTable $bookingTable): self
    {
        $this->bookingTable = $bookingTable;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }
}
