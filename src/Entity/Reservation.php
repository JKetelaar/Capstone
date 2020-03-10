<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BookingTable", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bookingTable;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $checkinDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $checkoutDate;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCheckinDate(): ?\DateTimeInterface
    {
        return $this->checkinDate;
    }

    public function setCheckinDate(\DateTimeInterface $checkinDate): self
    {
        $this->checkinDate = $checkinDate;

        return $this;
    }

    public function getCheckoutDate(): ?\DateTimeInterface
    {
        return $this->checkoutDate;
    }

    public function setCheckoutDate(?\DateTimeInterface $checkoutDate): self
    {
        $this->checkoutDate = $checkoutDate;

        return $this;
    }
}
