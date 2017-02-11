<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.11.
 * Time: 15:54
 */

namespace DogFeeder\UserBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class AlphaNumericPassword extends Constraint
{
    public $message = 'password_alphanumeric';

    public function validatedBy()
    {
        return 'DogFeeder\UserBundle\Form\Validator\Constraints\OnlyAlphaNumericValidator';
    }
}

