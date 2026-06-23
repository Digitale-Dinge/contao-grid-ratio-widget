<?php

declare(strict_types=1);

use Contao\CoreBundle\DataContainer\PaletteManipulator;

$GLOBALS['TL_DCA']['tl_content']['fields']['gridRatioActive'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50 clr', 'submitOnChange' => true],
];

$GLOBALS['TL_DCA']['tl_content']['fields']['gridRatio'] = [
    'label' => ['', ''],
    'exclude' => true,
    'inputType' => 'gridRatio',
    'eval' => ['tl_class' => 'clr'],
];

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'gridRatioActive';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['gridRatioActive'] = 'gridRatio';

PaletteManipulator::create()
    ->addLegend('grid_legend', 'type_legend', PaletteManipulator::POSITION_AFTER)
    ->addField('gridRatioActive', 'grid_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('element_group', 'tl_content')
;
