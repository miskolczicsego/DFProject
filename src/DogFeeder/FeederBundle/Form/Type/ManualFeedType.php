<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.24.
 * Time: 21:39
 */

namespace DogFeeder\FeederBundle\Form\Type;


use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ManualFeedType extends AbstractType
{
    private $securityToken;

    public function __construct(TokenStorage $securityToken)
    {
        $this->securityToken = $securityToken;
    }

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
            ->add('feeder', EntityType::class, array(
                'class' => 'DogFeeder\FeederBundle\Entity\Feeder',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('f')
                              ->where('f.user=:id')
                              ->setParameter('id', $this->securityToken->getToken()->getUser()->getId())
                        ;
                }
            ))
             ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-default'),
                'label' => 'feed',
                'translation_domain' => 'messages'
    ));
    }
}