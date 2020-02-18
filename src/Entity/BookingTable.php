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
     * @ORM\OneToMany(targetEntity="App\Entity\Chair", mappedBy="ChairTable", orphanRemoval=true)
     */
    private $chairs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="tableBooking")
     */
    private $bookings;

    public function __construct()
    {
        $this->chairs = new ArrayCollection();
        $this->bookings = new ArrayCollection();
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
     * @return Collection|Chair[]
     */
    public function getChairs(): Collection
    {
        return $this->chairs;
    }

    public function addChair(Chair $chair): self
    {
        if (!$this->chairs->contains($chair)) {
            $this->chairs[] = $chair;
            $chair->setChairTable($this);
        }

        return $this;
    }

    public function removeChair(Chair $chair): self
    {
        if ($this->chairs->contains($chair)) {
            $this->chairs->removeElement($chair);
            // set the owning side to null (unless already changed)
            if ($chair->getChairTable() === $this) {
                $chair->setChairTable(null);
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
}
