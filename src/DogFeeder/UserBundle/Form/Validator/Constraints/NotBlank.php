<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.11.
 * Time: 15:25
 */

namespace DogFeeder\UserBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraints\NotBlank as BaseNotBlank;

class NotBlank extends BaseNotBlank
{
    public $message = 'form.not_blank';

    public function validatedBy()
    {
        return 'Symfony\Component\Validator\Constraints\NotBlankValidator';
    }

}