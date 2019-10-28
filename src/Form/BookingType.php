<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\BookingTable;
use App\Entity\Room;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add(
                'room',
                EntityType::class,
                [
                    'class' => Room::class,
                    'required' => false,
                ]
            )
            ->add(
                'tableBooking',
                EntityType::class,
                [
                    'class' => BookingTable::class,
                    'required' => false,
                ]
            )
            ->add('user')
            ->add(
                'invitees',
                EntityType::class,
                [
                    'class' => User::class,
                    'multiple' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Booking::class,
            ]
        );
    }
}
