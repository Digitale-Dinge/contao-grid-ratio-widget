<?php

declare(strict_types=1);

namespace DigitaleDinge\GridRatioWidgetBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use DigitaleDinge\GridRatioWidgetBundle\DigitaleDingeGridRatioWidgetBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            (new BundleConfig(DigitaleDingeGridRatioWidgetBundle::class))
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
