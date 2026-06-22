<?php

declare(strict_types=1);

namespace DigitaleDinge\GridRatioWidgetBundle\EventListener;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Symfony\Component\Asset\Packages;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * Loads the back-end widget assets.
 */
#[AsEventListener]
readonly class BackendAssetsListener
{
    private const PACKAGE = 'digitale_dinge_grid_ratio_widget';

    public function __construct(
        private ScopeMatcher $scopeMatcher,
        private Packages $package,
    ) {
    }

    public function __invoke(RequestEvent $event): void
    {
        if (!$this->scopeMatcher->isBackendMainRequest($event)) {
            return;
        }

        $GLOBALS['TL_CSS'][] = $this->package->getUrl('grid-ratio-widget.css', self::PACKAGE);
        $GLOBALS['TL_JAVASCRIPT'][] = $this->package->getUrl('grid-ratio-widget.js', self::PACKAGE);
    }
}
