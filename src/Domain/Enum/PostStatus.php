<?php

namespace Pri301\Blog\Domain\Enum;

enum PostStatus: string
{
    case Published = 'PUBLISHED';
    case Pending = 'PENDING';
    case Rejected = 'REJECTED';
}
