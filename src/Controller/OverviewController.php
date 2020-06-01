<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\BookingTable;
use App\Entity\Reservation;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class OverviewController extends AbstractController
{
    /**
     * @Route("/overview", name="overview")
     */
    public function overview()
    {
        $doctrine = $this->getDoctrine();

//        $currentUser = $this->getUser();
//        if ($currentUser === null) {
//            throw new AccessDeniedHttpException('You are required to be logged in to access this page');
//        }

        $bookings = $doctrine->getRepository(Booking::class)->findAll();
        $users = $doctrine->getRepository(User::class)->findAll();
        $reservations = 0;

        /** @var Reservation $reservation */
        foreach ($this->getDoctrine()->getRepository(Reservation::class)->findAll() as $reservation) {
            if ($reservation->getCheckoutDate() === null) {
                $reservations++;
            }
        }

        $freeTables = 0;
        foreach ($this->getDoctrine()->getRepository(BookingTable::class)->findAll() as $table) {
            if (!$table->isOccupied()) {
                $freeTables++;
            }
        }

        return new JsonResponse(
            [
                'bookings' => count($bookings),
                'users' => count($users),
                'checkins' => $reservations,
                'free_tables' => $freeTables,
                'last_booking' => $bookings[count($bookings) - 1]->getStartDate(),
            ]
        );
    }
}
