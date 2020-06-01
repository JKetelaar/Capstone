<?php

namespace App\Controller;

use App\Entity\BookingTable;
use App\Entity\Reservation;
use App\Entity\User;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CheckinController
 * @package App\Controller
 * @Route("/tables")
 */
class CheckinController extends AbstractController
{
    /**
     * @Route("/checkin", name="checkin")
     */
    public function index(Request $request)
    {
        $id = $request->get('id');
        $user = $request->get('user');
        $table = $this->getDoctrine()->getRepository(BookingTable::class)->find($id);
        if ($table !== null) {
            $checkin = new Reservation();
            $checkin->setBookingTable($table);
            $checkin->setUser($this->getDoctrine()->getRepository(User::class)->find($user));
            $checkin->setCheckinDate(new DateTime());

            $table->setOccupied(true);
            $this->getDoctrine()->getManager()->persist($table);
            $this->getDoctrine()->getManager()->persist($checkin);
            $this->getDoctrine()->getManager()->flush();
        }

        return new Response();
    }

    /**
     * @Route("/checkout", name="checkout")
     */
    public function checkout(Request $request)
    {
        $user = $request->get('user');
        $this->getDoctrine()->getRepository(User::class)->find($user);
        $has = $this->getDoctrine()->getRepository(Reservation::class)->findOneBy(
            ['user' => $user, 'checkoutDate' => null]
        );

        if ($has !== null) {
            $has->setCheckoutDate(new DateTime());
            /** @var BookingTable $table */
            $table = $has->getBookingTable();
            $table->setOccupied(false);

            $this->getDoctrine()->getManager()->persist($has);
            $this->getDoctrine()->getManager()->persist($table);
            $this->getDoctrine()->getManager()->flush();
        }

        return new JsonResponse(['result' => 'Checked-out']);
    }

    /**
     * @Route("/has_checkin", name="has_checkin")
     */
    public function hasCheckin(Request $request)
    {
        $user = $request->get('user');
        $this->getDoctrine()->getRepository(User::class)->find($user);
        $has = $this->getDoctrine()->getRepository(Reservation::class)->findOneBy(
            ['user' => $user, 'checkoutDate' => null]
        );

        return new JsonResponse(['result' => $has !== null]);
    }
}
