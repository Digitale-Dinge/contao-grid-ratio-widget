<?php

declare(strict_types=1);

namespace DigitaleDinge\GridRatioWidgetBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class GridRatioExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('grid_ratio_cols', [GridRatioRuntime::class, 'cols']),
        ];
    }
}
