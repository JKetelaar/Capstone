<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(normalizationContext={"groups"={"all"}})
 * @ApiFilter(SearchFilter::class, properties={"area": "exact"})
 * @ORM\Entity(repositoryClass="App\Repository\TableRepository")
 */
class BookingTable
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
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"all"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Area", inversedBy="tables")
     *
     * @Groups({"all"})
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AIReport", mappedBy="bookingTable", orphanRemoval=true)
     */
    private $aiReports;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     *
     * @Groups({"all"})
     */
    private $occupied;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->aiReports = new ArrayCollection();

        $this->occupied = false;
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

    /**
     * @return Collection|AIReport[]
     */
    public function getAiReports(): Collection
    {
        return $this->aiReports;
    }

    public function addAiReport(AIReport $aiReport): self
    {
        if (!$this->aiReports->contains($aiReport)) {
            $this->aiReports[] = $aiReport;
            $aiReport->setBookingTable($this);
        }

        return $this;
    }

    public function removeAiReport(AIReport $aiReport): self
    {
        if ($this->aiReports->contains($aiReport)) {
            $this->aiReports->removeElement($aiReport);
            // set the owning side to null (unless already changed)
            if ($aiReport->getBookingTable() === $this) {
                $aiReport->setBookingTable(null);
            }
        }

        return $this;
    }

    /**
     * @Groups({"all"})
     *
     * @return bool
     */
    public function isUnknown()
    {
        /** @var Reservation $reservation */
        if (count($this->reservations) === 0) {
            return true;
        }

        if ($this->isOccupied()) {
            $count = 0;
            foreach ($this->reservations as $reservation) {
                if ($reservation->getCheckoutDate() !== null && $reservation->getUser() === null) {
                    return true;
                }
                if ($reservation->getCheckoutDate() !== null) {
                    $count++;
                }
            }

            if ($count === count($this->reservations)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isOccupied(): bool
    {
        return $this->occupied;
    }

    /**
     * @param bool $occupied
     */
    public function setOccupied(bool $occupied): void
    {
        $this->occupied = $occupied;
    }
}
