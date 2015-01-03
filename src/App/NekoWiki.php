<?php

namespace App;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NekoWiki extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}
