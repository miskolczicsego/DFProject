<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.03.05.
 * Time: 6:40
 */

namespace DogFeeder\ConfigBundle\Form\Validator\Constraints;


use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class OnlyNumericValidator extends ConstraintValidator
{
    /**
     * @var Translator
     */
    public $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if (!preg_match('/^[[:digit:]]+$/', $value, $matches)) {
            $this->context->buildViolation($this->translator->trans($constraint->message))
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}