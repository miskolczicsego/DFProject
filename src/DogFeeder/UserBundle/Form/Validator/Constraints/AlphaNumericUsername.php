<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.04.
 * Time: 21:26
 */

namespace DogFeeder\UserBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class AlphaNumericUsername extends Constraint
{
    public $message = 'username_alphanumeric';

    public function validatedBy()
    {
        return 'DogFeeder\UserBundle\Form\Validator\Constraints\OnlyAlphaNumericValidator';
    }
}

