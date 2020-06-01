<?php

namespace App\Command;

use App\Entity\AIReport;
use App\Entity\BookingTable;
use App\Entity\Reservation;
use App\Repository\TableRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FlexTablesDetectCommand extends Command
{
    protected static $defaultName = 'flex:tables:detect';

    /**
     * @var TableRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var Swift_Mailer
     */
    private $mailer;

    public function __construct(
        TableRepository $repository,
        EntityManagerInterface $manager,
        Swift_Mailer $mailer,
        string $name = null
    ) {
        parent::__construct($name);

        $this->repository = $repository;
        $this->manager = $manager;
        $this->mailer = $mailer;
    }

    protected function configure()
    {
        $this
            ->setDescription('Detects the availibity of all tables');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach ($this->repository->findAll() as $table) {
            $hasDate = false;
            foreach ($table->getReservations() as $reservation) {
                if ($reservation->getCheckoutDate() === null) {
                    $diff = (new DateTime())->diff($reservation->getCheckinDate());
                    if ($diff->d > 0) {
                        $reservation->setCheckoutDate(new DateTime());
                    } elseif ($diff->h > 16) {
                        $reservation->setCheckoutDate(new DateTime());
                    }
                    $hasDate = false;
                    break;
                } else {
                    $hasDate = true;
                }
            }
            if ($hasDate) {
                $table->setOccupied(false);
            }

            $occupied = $table->isOccupied();
            $table = $this->isOccupied($table);

            if ($table->getId() !== 6) {
                continue;
            }

            if ($occupied != $table->isOccupied()) {
                $report = new AIReport();

                $ignoreReport = false;
                if ($table->isOccupied()) {
                    $report->setAction('Person detected on camera. Table marked as occupied.');
                } else {
                    $found = false;
                    foreach ($table->getReservations() as $reservation) {
                        if ($reservation->getUser() !== null && $reservation->getCheckoutDate() === null) {
                            if ($reservation->getEmailedAt() === null) {
                                $report->setAction(
                                    'Nobody detected on camera. Requested user to report their activity.'
                                );
                                $table->setOccupied($occupied);
                                $this->sendEmail($reservation);
                                $reservation->setEmailedAt(new DateTime());
                                $this->manager->persist($reservation);
                            } elseif ((new DateTime())->diff($reservation->getEmailedAt())->i > 15) {
                                $report->setAction(
                                    'Nobody detected on camera. User did not respond to request. Table marked as available.'
                                );
                                $reservation->setCheckoutDate(new DateTime());
                                $this->manager->persist($reservation);
                            } else {
                                $ignoreReport = true;
                                $table->setOccupied($occupied);
                            }

                            $found = true;
                        }
                    }

                    if (!$found) {
                        $report->setAction('Nobody detected on camera. Table marked as available.');
                    }
                }

                $report->setBookingTable($table);
                if (!$ignoreReport) {
                    $this->manager->persist($report);
                }
            }

            $this->manager->persist($table);
        }
        $this->manager->flush();

        return 0;
    }

    private function isOccupied(BookingTable $table)
    {
        switch ($table->getId()) {
            case 1:
            case 5:
            case 7:
                $table->setOccupied(true);
                break;
            default:
                $table->setOccupied(false);
                break;
        }

        return $table;
    }

    private function sendEmail(Reservation $reservation)
    {
        $email = (new Swift_Message())
            ->addFrom('flexplacer@uwlax.edu')
            ->addTo($reservation->getUser()->getEmail())
            ->setSubject('Are you still here?')
            ->setBody(
                '<html>
        <body>
		<p>Dear user,</p>
		<p>You have marked yourself as checked-in at table <b>'.$reservation->getBookingTable()->getName(
                ).'</b> in building <b>'.$reservation->getBookingTable()->getArea()->getFloor()->getBuilding()->getName(
                ).'</b>.<br/>
		Though you seem not te be occupying the table.<br/>Therefore you are receiving this email to mark your activity.
		</p>
		<p>
		If you will be back soon, please <a href="http://capstone.jketelaar.nl/delay/' . $reservation->getId() . '">here</a> and the table will be marked occupied for the next 15 minutes.
</p>
		<p>
		If you have left, please <a href="http://capstone.jketelaar.nl/check-out/' . $reservation->getId() . '">click</a> here and mark the table as available.
</p>
<p>Thank you,<br/>Flexplacer - UWLAX</p>
				</body>
			</html>',
                'text/html'
            );

        $this->mailer->send($email);
    }
}
