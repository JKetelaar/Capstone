<?php

namespace App\Controller;

use App\Entity\Room\Amenity;
use App\Service\AvailableRoomService;
use DateTime;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BookRoomController
 * @package App\Controller
 * @Route("/available")
 */
class AvailabilityController extends AbstractFOSRestController
{
    /**
     * @Route("/rooms", name="available_rooms", methods={"POST"})
     * @param Request $request
     * @param AvailableRoomService $roomService
     * @return Response
     * @throws Exception
     */
    public function availableRooms(Request $request, AvailableRoomService $roomService)
    {
        $floor = $request->get('floor');
        $date = $request->get('date');
        $startTime = $request->get('start_time');
        $endTime = $request->get('end_time');

        $startDate = new DateTime($date);
        $startDate->setTime($startTime['hour'], $startTime['minute']);

        $endDate = new DateTime($date);
        $endDate->setTime($endTime['hour'], $endTime['minute']);

        $rooms = $roomService->getAvailableRoomsForFloor($floor, $startDate, $endDate);

        return $this->handleView($this->view($rooms));
    }

    /**
     * @Route("/options", name="option_rooms", methods={"POST"})
     * @param Request $request
     * @param AvailableRoomService $roomService
     * @return Response
     * @throws Exception
     */
    public function optionRooms(Request $request, AvailableRoomService $roomService)
    {
        $building = $request->get('building');

        $date = $request->get('date');
        $startDate = new DateTime($date);

        $amenities = [];
        $repository = $this->getDoctrine()->getRepository(Amenity::class);
        foreach ($request->get('amenities') as $amenity) {
            $roomAmenity = $repository->findOneBy(['name' => $amenity]);
            if ($roomAmenity !== null) {
                $amenities[] = $roomAmenity;
            }
        }

        $output = [];
        $rooms = $roomService->getAvailableRoomsForBuilding($building, $amenities);

        foreach ($rooms as $room) {
            $output[] = [
                'id' => $room->getId(),
                'room' => $room->getName(),
                'building' => $room->getFloor()->getBuilding()->getName(),
                'floor' => $room->getFloor()->getFloor(),
                'amenities' => $room->getAmenities(),
                'bookings' => $roomService->getBookingsForDate($room, $startDate),
            ];
        }

        return $this->handleView($this->view($output));
    }
}
