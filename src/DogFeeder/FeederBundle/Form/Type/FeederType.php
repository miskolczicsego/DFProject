<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.26.
 * Time: 14:27
 */

namespace DogFeeder\FeederBundle\Form\Type;

use DogFeeder\ScheduleBundle\Entity\Schedule;
use DogFeeder\ScheduleBundle\ScheduleBundle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeederType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('numberOfFeedPerDay', ChoiceType::class, array(
                'choices' => array('0', '1', '2', '3', '4', '5'),
                'empty_value' => '------ Válassz -------',
            ))
            ->add('save', SubmitType::class);
    }

    public function getBlockPrefix()
    {
        return 'feeder';
    }

}