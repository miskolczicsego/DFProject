<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.04.
 * Time: 19:41
 */

namespace DogFeeder\UserBundle\Form\Validator\Constraints;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Validator\Constraints\Length as BaseLength;

class Length extends BaseLength
{
    public $minMessage = 'too_short_message';
    public $maxMessage = 'too_long_message';

    public function __construct(Translator $translator, $options)
    {
        parent::__construct($options);

        $this->minMessage = str_replace('[MIN]', $this->min, $translator->trans($this->minMessage));
        $this->maxMessage = str_replace('[MAX]', $this->max, $translator->trans($this->maxMessage));
    }

    public function validatedBy()
    {
        return 'Symfony\Component\Validator\Constraints\LengthValidator';
    }
}