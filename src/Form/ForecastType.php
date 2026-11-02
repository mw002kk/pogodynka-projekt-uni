<?php

namespace App\Form;

use App\Entity\Forecast;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForecastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'city',
                'label' => 'Miasto',
            ])
            ->add('date', DateTimeType::class, [
                'label' => 'Data',
                'widget' => 'single_text',
            ])
            ->add('temperature', NumberType::class, [
                'label' => 'Temperatura',
            ])
            ->add('humidity', NumberType::class, [
                'label' => 'Wilgotność',
            ])
            ->add('precipitation', NumberType::class, [
                'label' => 'Opady',
            ])
            ->add('windSpeed', NumberType::class, [
                'label' => 'Prędkość wiatru',
            ])
            ->add('windGustsSpeed', NumberType::class, [
                'label' => 'Porywy wiatru',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forecast::class,
        ]);
    }
}
