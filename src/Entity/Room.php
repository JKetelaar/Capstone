<?php

namespace App\Entity;

use App\Entity\Room\Amenity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoomRepository")
 */
class Room
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Floor", inversedBy="rooms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $floor;

    /**
     * @ORM\OneToMany(targetEntity="BookingTable", mappedBy="room")
     */
    private $tables;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="room")
     */
    private $bookings;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Room\Amenity", inversedBy="rooms")
     */
    private $amenities;

    public function __construct()
    {
        $this->tables = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->amenities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFloor(): ?Floor
    {
        return $this->floor;
    }

    public function setFloor(?Floor $floor): self
    {
        $this->floor = $floor;

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
            $table->setRoom($this);
        }

        return $this;
    }

    public function removeTable(BookingTable $table): self
    {
        if ($this->tables->contains($table)) {
            $this->tables->removeElement($table);
            // set the owning side to null (unless already changed)
            if ($table->getRoom() === $this) {
                $table->setRoom(null);
            }
        }

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
            $booking->setRoom($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getRoom() === $this) {
                $booking->setRoom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Amenity[]
     */
    public function getAmenities(): Collection
    {
        return $this->amenities;
    }

    public function addAmenity(Amenity $amenity): self
    {
        if (!$this->amenities->contains($amenity)) {
            $this->amenities[] = $amenity;
        }

        return $this;
    }

    public function removeAmenity(Amenity $amenity): self
    {
        if ($this->amenities->contains($amenity)) {
            $this->amenities->removeElement($amenity);
        }

        return $this;
    }
}
