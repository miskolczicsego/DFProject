<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.04.
 * Time: 19:41
 */

namespace DogFeeder\UserBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraints\NotBlank as BaseNotBlank;
use Symfony\Component\Validator\Constraint;

class NotBlank extends BaseNotBlank
{
    public $message = 'not_blank';
    public function validatedBy()
    {
        return 'Symfony\Component\Validator\Constraints\NotBlankValidator';
    }
}