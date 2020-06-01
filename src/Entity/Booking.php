<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Entity\Booking\SuggestedTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(normalizationContext={"groups"={"all"}}, attributes={"order"={"id": "DESC"}})
 * @ApiFilter(SearchFilter::class, properties={"user": "exact"})
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="bookings")
     *
     * @Groups({"all"})
     */
    private $room;

    /**
     * @ORM\ManyToOne(targetEntity="BookingTable", inversedBy="bookings")
     *
     * @Groups({"all"})
     */
    private $tableBooking;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"all"})
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="invites")
     *
     * @Groups({"all"})
     */
    private $invitees;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups({"all"})
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups({"all"})
     */
    private $endDate;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups({"all"})
     */
    private $creationDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking\SuggestedTime", mappedBy="booking", orphanRemoval=true)
     *
     * @Groups({"all"})
     */
    private $suggestedTimes;

    public function __construct()
    {
        $this->invitees = new ArrayCollection();
        $this->suggestedTimes = new ArrayCollection();

        $this->creationDate = new \DateTime();
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

    public function getTableBooking(): ?BookingTable
    {
        return $this->tableBooking;
    }

    public function setTableBooking(?BookingTable $tableBooking): self
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate($endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return string
     *
     * @Groups("all")
     */
    public function getWebStartDate()
    {
        return $this->startDate->format('M/d/Y H:i');
    }

    /**
     * @return string
     *
     * @Groups("all")
     */
    public function getWebEndDate()
    {
        return $this->endDate->format('M/d/Y H:i');
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
