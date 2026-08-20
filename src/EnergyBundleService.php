<?php

namespace aintreallydown\EnergyBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EnergyBundleService extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
    }
}
