<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.04.
 * Time: 21:26
 */

namespace DogFeeder\UserBundle\Form\Validator\Constraints;


use DogFeeder\UserBundle\Form\Validator\OnlyAlphaNumericValidator;
use Symfony\Component\Validator\Constraint;

class OnlyAlphaNumeric extends Constraint
{
    public $message = 'only_alphanumeric';

}