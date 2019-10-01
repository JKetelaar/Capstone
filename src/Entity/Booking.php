<?php

namespace App\Entity;

use App\Entity\Booking\SuggestedTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="bookings")
     */
    private $room;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Table", inversedBy="bookings")
     */
    private $tableBooking;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="invites")
     */
    private $invitees;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking\SuggestedTime", mappedBy="booking", orphanRemoval=true)
     */
    private $suggestedTimes;

    public function __construct()
    {
        $this->invitees = new ArrayCollection();
        $this->suggestedTimes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getTableBooking(): ?Table
    {
        return $this->tableBooking;
    }

    public function setTableBooking(?Table $tableBooking): self
    {
        $this->tableBooking = $tableBooking;

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
     * @return Collection|User[]
     */
    public function getInvitees(): Collection
    {
        return $this->invitees;
    }

    public function addInvitee(User $invitee): self
    {
        if (!$this->invitees->contains($invitee)) {
            $this->invitees[] = $invitee;
        }

        return $this;
    }

    public function removeInvitee(User $invitee): self
    {
        if ($this->invitees->contains($invitee)) {
            $this->invitees->removeElement($invitee);
        }

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return Collection|SuggestedTime[]
     */
    public function getSuggestedTimes(): Collection
    {
        return $this->suggestedTimes;
    }

    public function addSuggestedTime(SuggestedTime $suggestedTime): self
    {
        if (!$this->suggestedTimes->contains($suggestedTime)) {
            $this->suggestedTimes[] = $suggestedTime;
            $suggestedTime->setBooking($this);
        }

        return $this;
    }

    public function removeSuggestedTime(SuggestedTime $suggestedTime): self
    {
        if ($this->suggestedTimes->contains($suggestedTime)) {
            $this->suggestedTimes->removeElement($suggestedTime);
            // set the owning side to null (unless already changed)
            if ($suggestedTime->getBooking() === $this) {
                $suggestedTime->setBooking(null);
            }
        }

        return $this;
    }
}
