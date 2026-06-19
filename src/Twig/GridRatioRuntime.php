<?php

declare(strict_types=1);

namespace DigitaleDinge\GridRatioWidgetBundle\Twig;

use Twig\Extension\RuntimeExtensionInterface;

final class GridRatioRuntime implements RuntimeExtensionInterface
{
    /**
     * Sanitises a stored value into a safe "Nfr Nfr …" list usable in --grid-cols.
     * Returns '' if the value is empty or invalid.
     */
    public function cols(string|null $value): string
    {
        $tokens = preg_split('/\s+/', trim((string) $value)) ?: [];
        $valid = array_filter($tokens, static fn (string $token): bool => 1 === preg_match('/^\d+fr$/', $token));

        return implode(' ', $valid);
    }
}
