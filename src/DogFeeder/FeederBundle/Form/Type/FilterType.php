<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.03.18.
 * Time: 20:06
 */

namespace DogFeeder\FeederBundle\Form\Type;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use DogFeeder\FeederBundle\Entity\Feeder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\SecurityContext;

class FilterType extends AbstractType
{
    private $securityToken;

    private $translator;

    public function __construct(TokenStorage $securityToken, Translator $translator)
    {
        $this->securityToken = $securityToken;
        $this->translator = $translator;

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('feeder', EntityType::class, array(
                'class' => 'DogFeeder\FeederBundle\Entity\Feeder',
                'empty_value' => 'Mind',
                'label' => 'feeder_filter',
                'translation_domain' => 'messages',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('f')
                        ->where('f.user=:id')
                        ->setParameter('id', $this->securityToken->getToken()->getUser()->getId())
                        ;
                }
            ));
    }

}