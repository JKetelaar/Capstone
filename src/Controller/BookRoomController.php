<?php

namespace App\Controller;

use App\Entity\Room;
use App\Service\AvailableRoomService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BookRoomController
 * @package App\Controller
 * @Route("/available")
 */
class BookRoomController extends AbstractFOSRestController
{
    /**
     * @Route("/rooms", name="available_rooms")
     * @throws \Exception
     */
    public function availableRooms(Request $request)
    {
        $floor = $request->get('floor');
        $date = $request->get('date');
        $startTime = $request->get('start_time');
        $endTime = $request->get('end_time');

        $startDate = new \DateTime($date);
        $startDate->setTime($startTime['hour'], $startTime['minute']);

        $endDate = new \DateTime($date);
        $endDate->setTime($endTime['hour'], $endTime['minute']);

        $a = new AvailableRoomService($this->getDoctrine()->getRepository(Room::class));
        $rooms = $a->getAvailableRoomsForFloor($floor, $startDate, $endDate);

        return $this->handleView($this->view($rooms));
    }
}
