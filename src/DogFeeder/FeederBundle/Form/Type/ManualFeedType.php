<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.24.
 * Time: 21:39
 */

namespace DogFeeder\FeederBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ManualFeedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', ChoiceType::class, array(
                'choices' => array(
                    '200' => 200,
                    '100' => 100,
                    '50' => 50
                )
            ))
             ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-default'),
                'label' => 'feed',
                'translation_domain' => 'messages'
    ));
    }
}