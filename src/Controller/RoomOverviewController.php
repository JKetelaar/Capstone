<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Logs;
use App\Entity\Room;
use App\Entity\User;
use DateTime;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BookRoomController
 * @package App\Controller
 * @Route("/booking")
 */
class RoomOverviewController extends AbstractFOSRestController
{
    /**
     * @Route("/book", name="book_room", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function book(Request $request)
    {
        $doctrine = $this->getDoctrine();

        $date = $request->get('date');
        $startTime = $request->get('startTime');
        $endTime = $request->get('endTime');

        $startDate = new DateTime($date);
        $startDate->setTime($startTime['hour'], $startTime['minute']);

        $endDate = new DateTime($date);
        $endDate->setTime($endTime['hour'], $endTime['minute']);

        $room = $request->get('room');
        $users = [];
        $repository = $doctrine->getRepository(User::class);
        foreach ($request->get('invitees') as $invite) {
            $user = $repository->findOneBy(['email' => $invite]);
            if ($user !== null) {
                $users[] = $user;
            }
        }

        $booking = new Booking();
        $booking->setRoom($doctrine->getRepository(Room::class)->findOneBy(['id' => $room]));
        $booking->setStartDate($startDate);
        $booking->setEndDate($endDate);
        $booking->setUser($doctrine->getRepository(User::class)->find($request->get('user')));

        $doctrine->getManager()->persist($booking);

        $log = new Logs();
        $log->setDescription(
            'Room '.$booking->getRoom()->getName().' on Floor '.$booking->getRoom()->getFloor()->getFloor(
            ).' in Building '.$booking->getRoom()->getFloor()->getBuilding()->getName(
            ).' booked for '.$startDate->format('H').'-'.$endDate->format('H')
        );
        $doctrine->getManager()->persist($log);

        $doctrine->getManager()->flush();

        return $this->handleView($this->view($booking));
    }

    /**
     * @Route("/overview", name="overview_room", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function overview(Request $request)
    {
        $doctrine = $this->getDoctrine();

        $date = $request->get('date');
        $startTime = $request->get('startTime');
        $endTime = $request->get('endTime');

        $startDate = new DateTime($date);
        $startDate->setTime($startTime['hour'], $startTime['minute']);

        $endDate = new DateTime($date);
        $endDate->setTime($endTime['hour'], $endTime['minute']);

        $room = $doctrine->getRepository(Room::class)->find($request->get('room'));
        $invitees = $request->get('invitees');

        $overview = [
            'building' => $room->getFloor()->getBuilding()->getName(),
            'floor' => $room->getFloor()->getFloor(),
            'room' => $room->getName(),
            'amenities' => $room->getAmenities(),
            'invitees' => $invitees,
            'start_date' => $startDate->format('m/d/Y H:i'),
            'end_date' => $endDate->format('m/d/Y H:i'),
        ];

        return $this->handleView($this->view($overview));
    }
}
