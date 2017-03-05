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

class UserRegistrationType extends AbstractType
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
             ->add('firstname', TextType::class, array(
                'label' => 'form.firstname',
                'translation_domain' => 'messages',
                 'attr' => array(
                     'class' => 'form-control input-lg',
                     'tabindex' => '1'
                 ),
                'required' => false
            ))
            ->add('lastname', TextType::class, array(
                'label' => 'form.lastname',
                'attr' => array(
                    'class' => 'form-control input-lg',
                    'tabindex' => '2'
                ),
                'translation_domain' => 'messages',
                'required' => false
            ))
            ->add('username', TextType::class, array(
                'label' => 'form.username',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control input-lg',
                    'tabindex' => '3'
                ),
                'translation_domain' => 'messages',
                'constraints' => array(
                    new NotBlank(),
                    new Length($this->translator, array('min' => 3, 'max' => 64)),
                    new AlphaNumericUsername()
                )

            ))
            ->add('email', EmailType::class, array(
                'label' => 'form.email',
                'attr' => array(
                    'class' => 'form-control input-lg',
                    'tabindex' => '4'
                ),
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
                'first_options' => array('attr' => array(
                    'class' => 'form-control input-lg',
                    'tabindex' => '5'
                )),
                'second_options' => array('attr' => array(
                    'class' => 'form-control input-lg',
                    'tabindex' => '6'
                )),
            ))
            ->add('register', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-primary btn-block btn-lg',
                    'tabindex' => '7'),
                'label' => 'form.register',
                'translation_domain' => 'messages'
        ));

    }

    // todo kideríteni ez miért kell bele
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

    //ez lesz a prefix a form egyes mezőinek a nevénél pl
    public function getBlockPrefix()
    {
        return 'user_registration';
    }
}