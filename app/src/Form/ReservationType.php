<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Terrain;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_reservation_debut', DateTimeType::class, [
                'label' => 'Date de début',
                'widget' => 'single_text',
            ])
            ->add('date_reservation_fin', DateTimeType::class, [
                'label' => 'Date de fin',
                'widget' => 'single_text',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email', // ou autre champ comme 'nom'
                'label' => 'Utilisateur',
            ])
            ->add('terrain', EntityType::class, [
                'class' => Terrain::class,
                'choice_label' => 'referenceTerrain', // à adapter selon ta propriété
                'label' => 'Terrain',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}