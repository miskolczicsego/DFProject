<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.04.
 * Time: 12:32
 */

namespace DogFeeder\UserBundle\Form\Type;

use DogFeeder\UserBundle\Entity\User;
use DogFeeder\UserBundle\Form\Validator\Constraints\Length;
use DogFeeder\UserBundle\Form\Validator\Constraints\AlphaNumericUsername;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

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
                'required' => false,
                'translation_domain' => 'messages',
                'constraints' => array(
                    new NotBlank(),
                    new Length($this->translator, array('min' => 3, 'max' => 64)),
                    new AlphaNumericUsername()
                )

        ))
             ->add('firstname', TextType::class, array(
                'label' => 'form.firstname',
                'translation_domain' => 'messages',
                'required' => false
            ))
            ->add('lastname', TextType::class, array(
                'label' => 'form.lastname',
                'translation_domain' => 'messages',
                'required' => false
            ))
            ->add('email', EmailType::class, array(
                'label' => 'form.email',
                'translation_domain' => 'messages',
                'required' => false,
                'constraints' => array(
                    new NotBlank()
                )
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'constraints' => array(
                    new NotBlank(),
                    new Length($this->translator, array('min' => 3, 'max' => 20))
                ),
                'invalid_message' => 'form.error_message',
                'required' => false,
                'options' => array('attr' => array('class' => 'password-field')),
                'first_options'  => array('label' => 'form.password', 'attr' => array('placeholder' => 'form.password')),
                'second_options' => array('label' => 'form.repeatpassword', 'attr' => array('placeholder' => 'form.repeatpassword')),
                'translation_domain' => 'messages',

            ))
            ->add('register', SubmitType::class, array(
                'attr' => array('class' => 'save'),
                'label' => 'form.register',
                'translation_domain' => 'messages'
        ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'user_registration';
    }
}