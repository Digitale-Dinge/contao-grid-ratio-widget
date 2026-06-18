<?php

declare(strict_types=1);

namespace DigitaleDinge\GridRatioWidgetBundle\Widget;

use Contao\System;
use Contao\Widget;

class GridRatio extends Widget
{
    /**
     * Submit user input
     * @var boolean
     */
    protected $blnSubmitInput = true;

    /**
     * Add a for attribute
     * @var boolean
     */
    protected $blnForAttribute = true;

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'be_widget';

    public function generate(): string
    {
        return System::getContainer()->get('twig')->render('@Contao/backend/widget/grid_ratio.html.twig', [
            'id' => $this->strId,
            'class' => $this->strClass,
            'name' => $this->strName,
            'value' => $this->varValue,
            'attributes' => $this->getAttributes(),
        ]);
    }
}
