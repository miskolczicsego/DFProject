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
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeederType extends AbstractType
{
    /**
     * @var Translator
     */
    public $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'name',
                'attr' => array('class' => 'form-control'),
                'translation_domain' => 'messages'
            ))
            ->add('numberOfFeedPerDay', ChoiceType::class, array(
                'label' => 'numberOfFeedPerDay',
                'attr' => array('class' => 'form-control'),
                'choices' => array('0', '1', '2', '3', '4', '5'),
                'empty_value' => '------ Válassz -------',
                'translation_domain' => 'messages'
            ))
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-primary'),
                'label' => 'save',
                'translation_domain' => 'messages'
            ));
    }

    public function getBlockPrefix()
    {
        return 'feeder';
    }

}