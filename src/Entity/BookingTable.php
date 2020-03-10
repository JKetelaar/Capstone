<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ApiFilter(SearchFilter::class, properties={"area": "exact"})
 * @ORM\Entity(repositoryClass="App\Repository\TableRepository")
 */
class BookingTable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Area", inversedBy="tables")
     */
    private $area;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="tableBooking")
     */
    private $bookings;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $mapLocation = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="bookingTable", orphanRemoval=true)
     */
    private $reservations;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArea(): ?Area
    {
        return $this->area;
    }

    public function setArea(?Area $area): self
    {
        $this->area = $area;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setTableBooking($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getTableBooking() === $this) {
                $booking->setTableBooking(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getMapLocation(): ?array
    {
        return $this->mapLocation;
    }

    public function setMapLocation(?array $mapLocation): self
    {
        $this->mapLocation = $mapLocation;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setBookingTable($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getBookingTable() === $this) {
                $reservation->setBookingTable(null);
            }
        }

        return $this;
    }
}
