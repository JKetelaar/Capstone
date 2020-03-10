<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\User\UserRole;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(routePrefix="/v2", normalizationContext={"groups"={"all"}})
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
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
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $salt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User\UserRole", mappedBy="users")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="user", orphanRemoval=true)
     */
    private $bookings;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Booking", mappedBy="invitees")
     */
    private $invites;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="user", orphanRemoval=true)
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Logs", mappedBy="user")
     */
    private $logs;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->invites = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->logs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt(): ?string
    {
        return $this->salt;
    }

    public function setSalt(string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @return Collection|UserRole[]
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(UserRole $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
            $role->addUser($this);
        }

        return $this;
    }

    public function removeRole(UserRole $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
            $role->removeUser($this);
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
            $booking->setUser($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getUser() === $this) {
                $booking->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getInvites(): Collection
    {
        return $this->invites;
    }

    public function addInvite(Booking $invite): self
    {
        if (!$this->invites->contains($invite)) {
            $this->invites[] = $invite;
            $invite->addInvitee($this);
        }

        return $this;
    }

    public function removeInvite(Booking $invite): self
    {
        if ($this->invites->contains($invite)) {
            $this->invites->removeElement($invite);
            $invite->removeInvitee($this);
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
            $reservation->setUser($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getUser() === $this) {
                $reservation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Logs[]
     */
    public function getLogs(): Collection
    {
        return $this->logs;
    }

    public function addLog(Logs $log): self
    {
        if (!$this->logs->contains($log)) {
            $this->logs[] = $log;
            $log->setUser($this);
        }

        return $this;
    }

    public function removeLog(Logs $log): self
    {
        if ($this->logs->contains($log)) {
            $this->logs->removeElement($log);
            // set the owning side to null (unless already changed)
            if ($log->getUser() === $this) {
                $log->setUser(null);
            }
        }

        return $this;
    }
}
