<?php



namespace Pri301\Blog\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsValidPostPart extends Constraint
{
    public string $message = 'The part of post "{{ value }}" is not valid. Valid parts: {{ choices }}';
}
