<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.18.
 * Time: 16:43
 */

namespace DogFeeder\UserBundle\Form\Type;

use DogFeeder\UserBundle\Entity\User;
use DogFeeder\UserBundle\Form\Validator\Constraints\Length;
use DogFeeder\UserBundle\Form\Validator\Constraints\AlphaNumericUsername;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
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
                'attr' => array(
                    'class' => 'form-control input-lg',
                    'tabindex' => '1'
                ),
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
                'attr' => array(
                    'class' => 'form-control input-lg',
                    'tabindex' => '2'
                ),
                'required' => false
            ))
            ->add('lastname', TextType::class, array(
                'label' => 'form.lastname',
                'translation_domain' => 'messages',
                'attr' => array(
                    'class' => 'form-control input-lg',
                    'tabindex' => '3'
                ),
                'required' => false
            ))
            ->add('email', EmailType::class, array(
                'label' => 'form.email',
                'translation_domain' => 'messages',
                'attr' => array(
                    'class' => 'form-control input-lg',
                    'tabindex' => '4'
                ),
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
                'first_options'  => array('label' => 'form.password', 'attr' => array(
                    'placeholder' => 'form.password',
                    'class' => 'form-control input-lg',
                    'tabindex' => '5'
                )),
                'second_options' => array('label' => 'form.repeatpassword', 'attr' => array(
                    'placeholder' => 'form.repeatpassword',
                    'class' => 'form-control input-lg',
                    'tabindex' => '6'
                )),
                'translation_domain' => 'messages',

            ))
            ->add('save', SubmitType::class, array(
                'label' => 'save',
                'attr' => array(
                    'class' => 'form-control input-lg',
                    'tabindex' => '7'
                ),
                'translation_domain' => 'messages'
            ))
            ->add('cancel', ButtonType::class, array(
                'label' => 'cancel',
                'attr' => array(
                    'onclick' => 'window.location.href="/"',
                    'class' => 'form-control input-lg',
                    'tabindex' => '8'
                ),
                'translation_domain' => 'messages'
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

    //todo pontosan mire használjuk???
    public function getBlockPrefix()
    {
        return 'user_profile';
    }
}