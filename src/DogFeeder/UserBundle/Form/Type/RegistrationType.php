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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\Container;

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
        $builder->add('username', TextType::class, array(
            'constraints' => array(
                new Length($this->translator, array('min' => 3, 'max' => 64)),
                new NotBlank(),
                new OnlyAlphaNumeric()
            )

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