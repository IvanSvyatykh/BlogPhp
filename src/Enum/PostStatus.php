<?php

namespace Pri301\Blog\Enum;

enum PostStatus: string

{
    case Published = 'published';
    case Pending = 'pending';
    case Rejected = 'rejected';
}
