<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.03.05.
 * Time: 6:50
 */

namespace DogFeeder\ConfigBundle\Form\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class NumericStatLimit extends Constraint
{
    public $message = 'statlimit_numeric';

    public function validatedBy()
    {
        return 'DogFeeder\ConfigBundle\Form\Validator\Constraints\OnlyNumericValidator';
    }
}