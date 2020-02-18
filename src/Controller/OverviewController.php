<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
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

        return new JsonResponse(
            [
                'bookings' => count($bookings),
                'users' => count($users),
                'last_booking' => $bookings[count($bookings) - 1]->getStartDate(),
            ]
        );
    }
}
