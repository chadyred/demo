<?php

namespace florian\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class florianUserBundle extends Bundle
{
     public function getParent() {
        return 'FOSUserBundle';
    }
}
