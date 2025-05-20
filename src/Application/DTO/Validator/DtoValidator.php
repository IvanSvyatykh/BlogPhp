<?php

namespace Pri301\Blog\Application\DTO\Validator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DtoValidator
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(object $dto): array
    {
        $violations = $this->validator->validate($dto);

        $errors = [];
        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $errors;
    }
}