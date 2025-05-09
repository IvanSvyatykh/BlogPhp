<?php
namespace Pri301\Blog\Validator\Constraints;

use Pri301\Blog\Enums\PostPart;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class IsValidPostPartValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IsValidPostPart) {
            throw new UnexpectedTypeException($constraint, IsValidPostPart::class);
        }

        if ($value === null || $value === '') {
            return;
        }

        $validValues = array_map(fn(PostPart $case) => $case->value, PostPart::cases());

        if (!in_array($value, $validValues, true)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->setParameter('{{ choices }}', implode(', ', $validValues))
                ->addViolation();
        }
    }
}