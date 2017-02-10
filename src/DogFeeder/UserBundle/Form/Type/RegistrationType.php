<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.04.
 * Time: 12:32
 */

namespace DogFeeder\UserBundle\Form\Type;

use DogFeeder\UserBundle\Form\Validator\Constraints\Length;
use DogFeeder\UserBundle\Form\Validator\Constraints\NotBlank;
use DogFeeder\UserBundle\Form\Validator\Constraints\OnlyAlphaNumeric;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationType extends AbstractType
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
            ->add('username', TextType::class, array(
                'label' => 'form.username',
                'translation_domain' => 'messages',
                'constraints' => array(
                new Length($this->translator, array('min' => 3, 'max' => 64)),
                new NotBlank(),
                new OnlyAlphaNumeric()
            )
        ))
            ->add('registrate', SubmitType::class, array(
                'attr' => array('class' => 'save'),
                'label' => 'form.registrate',
                'translation_domain' => 'messages'
        ));

    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'user_registration';
    }
}