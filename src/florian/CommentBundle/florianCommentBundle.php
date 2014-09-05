<?php

namespace florian\CommentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class florianCommentBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSCommentBundle';
    }
}
