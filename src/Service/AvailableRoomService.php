<?php
/**
 * @author JKetelaar
 */

namespace App\Service;

use App\Entity\Room;
use App\Repository\RoomRepository;

class AvailableRoomService
{
    /**
     * @var RoomRepository
     */
    private $roomRepository;

    /**
     * AvailableRoomService constructor.
     * @param RoomRepository $roomRepository
     */
    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    /**
     * @param int $floorId
     * @param \DateTimeInterface $startDate
     * @param \DateTimeInterface $endDate
     * @return Room[]
     */
    public function getAvailableRoomsForFloor(int $floorId, \DateTimeInterface $startDate, \DateTimeInterface $endDate)
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
     * @param $bookingStart \DateTimeInterface
     * @param $bookingEnd \DateTimeInterface
     * @param $startDate \DateTimeInterface
     * @param $endDate \DateTimeInterface
     * @return bool
     */
    private function isFree($bookingStart, $bookingEnd, $startDate, $endDate)
    {
        if ($bookingStart > $startDate && $bookingEnd < $endDate) { #-> Check time is in between start and end time
            return false;
        } elseif (($bookingStart > $startDate && $bookingStart < $endDate) || ($bookingEnd > $startDate && $bookingEnd < $endDate)) { #-> Check start or end time is in between start and end time
            return false;
        } elseif ($bookingStart == $startDate || $bookingEnd == $endDate) { #-> Check start or end time is at the border of start and end time
            return false;
        } elseif ($startDate > $bookingStart && $endDate < $bookingEnd) { #-> start and end time is in between  the check start and end time.
            return false;
        } else {
            return true;
        }
    }
}
