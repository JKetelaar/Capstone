<?php
/**
 * @author JKetelaar
 */

namespace App\Service;

use App\Entity\Room;
use App\Repository\BuildingRepository;
use App\Repository\RoomRepository;
use DateTimeInterface;

class AvailableRoomService
{
    /**
     * @var RoomRepository
     */
    private $roomRepository;

    /**
     * @var BuildingRepository
     */
    private $buildingRepository;

    /**
     * AvailableRoomService constructor.
     * @param RoomRepository $roomRepository
     * @param BuildingRepository $buildingRepository
     */
    public function __construct(RoomRepository $roomRepository, BuildingRepository $buildingRepository)
    {
        $this->roomRepository = $roomRepository;
        $this->buildingRepository = $buildingRepository;
    }

    /**
     * @param int $floorId
     * @param DateTimeInterface $startDate
     * @param DateTimeInterface $endDate
     * @return Room[]
     */
    public function getAvailableRoomsForFloor(int $floorId, DateTimeInterface $startDate, DateTimeInterface $endDate)
    {
        $availableRooms = [];
        $rooms = $this->roomRepository->findBy(['floor' => $floorId]);
        foreach ($rooms as $room) {
            $bookings = $room->getBookings();
            $free = true;
            foreach ($bookings as $booking) {
                if (!$this->isFree($booking->getStartDate(), $booking->getEndDate(), $startDate, $endDate)) {
                    $free = false;
                    break;
                }
            }

            if ($free === true) {
                $availableRooms[] = $room;
            }
        }

        return $availableRooms;
    }

    /**
     * @param $bookingStart DateTimeInterface
     * @param $bookingEnd DateTimeInterface
     * @param $startDate DateTimeInterface
     * @param $endDate DateTimeInterface
     * @return bool
     * @noinspection PhpNonStrictObjectEqualityInspection
     */
    private function isFree($bookingStart, $bookingEnd, $startDate, $endDate)
    {
        // Check time is in between start and end time
        if ($bookingStart > $startDate && $bookingEnd < $endDate) {
            return false;
        }// Check start or end time is in between start and end time
        elseif (($bookingStart > $startDate && $bookingStart < $endDate) || ($bookingEnd > $startDate && $bookingEnd < $endDate)) {
            return false;
        } // Check start or end time is at the border of start and end time
        elseif ($bookingStart == $startDate || $bookingEnd == $endDate) {
            return false;
        } // Start and end time is in between the check start and end time.
        elseif ($startDate > $bookingStart && $endDate < $bookingEnd) {
            return false;
        } // No matching time, booking is free
        else {
            return true;
        }
    }

    public function getBookingsForDate(Room $room, DateTimeInterface $dateTime)
    {
        $bookings = [];
        foreach ($room->getBookings() as $booking) {
            if ($this->isDateBetweenDates($dateTime, clone $booking->getStartDate(), clone $booking->getEndDate())) {
                $bookings[] = [
                    'start' => $booking->getStartDate()->format('m/d/Y H:i'),
                    'end' => $booking->getEndDate()->format('m/d/Y H:i'),
                ];
            }
        }

        return $bookings;
    }

    private function isDateBetweenDates(
        DateTimeInterface $date,
        DateTimeInterface $startDate,
        DateTimeInterface $endDate
    ) {
        $startDate->setTime('0', '0');
        $endDate->setTime('23', '59');

        return $date > $startDate && $date < $endDate;
    }

    /**
     * @param int $buildingId
     * @param Room\Amenity[] $amenities
     * @return Room[]
     */
    public function getAvailableRoomsForBuilding(
        int $buildingId,
        array $amenities
    ) {
        $availableRooms = [];
        foreach ($this->buildingRepository->find($buildingId)->getFloors() as $floor) {
            foreach ($floor->getRooms() as $room) {
                if (count($amenities) > 0) {

                    $matches = 0;
                    foreach ($room->getAmenities() as $roomAmenity) {
                        foreach ($amenities as $amenity) {
                            if ($amenity->getId() === $roomAmenity->getId()) {
                                $matches++;
                                break 1;
                            }
                        }
                    }

                    if ($matches === count($amenities)) {
                        $availableRooms[] = $room;
                    }

                } else {
                    $availableRooms[] = $room;
                }
            }
        }

        return $availableRooms;
    }
}
