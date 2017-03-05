<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.03.05.
 * Time: 6:33
 */

namespace DogFeeder\ConfigBundle\Form\Type;

use DogFeeder\ConfigBundle\Entity\Config;
use DogFeeder\ConfigBundle\Form\Validator\Constraints\NumericStatLimit;
use DogFeeder\UserBundle\Form\Validator\Constraints\NotBlank;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ConfigType extends AbstractType
{
    /**
     * @var Translator
     */
    public $translator;

    public function __construct(Translator $translator)
    {
//        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('stat_limit', TextType::class, array(
                'label' => 'stat_display_limit',
                'required' => false,
                'translation_domain' => 'messages',
                'constraints' => array(
                    new NumericStatLimit($this->translator),
                    new NotBlank()
                ),
            ));
    }

    public function getBlockPrefix()
    {
        return 'configs';
    }
}