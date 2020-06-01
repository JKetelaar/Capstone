<?php
/**
 * @author JKetelaar
 */

namespace App\Controller;

use App\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @Route("/delay/{reservation}")
     * @param Reservation $reservation
     * @return Response
     */
    public function delay(Reservation $reservation)
    {
        return new Response("Thank you for marking your occupation!");
    }

    /**
     * @Route("/check-out/{reservation}")
     * @param Reservation $reservation
     * @return Response
     */
    public function checkout(Reservation $reservation)
    {
        if ($reservation->getCheckoutDate() !== null) {
            return new Response("This reservation is already marked as checked-out.");
        }

        $reservation->setCheckoutDate(new \DateTime());
        $table = $reservation->getBookingTable();
        $table->setOccupied(false);

        $this->getDoctrine()->getManager()->persist($reservation);
        $this->getDoctrine()->getManager()->persist($table);
        $this->getDoctrine()->getManager()->flush();

        return new Response("Thank you for marking your occupation. You are now checked-out.");
    }
}
