<?php

declare(strict_types=1);

use Contao\CoreBundle\DataContainer\PaletteManipulator;

/*
 * A checkbox reveals the ratio field (sub-palette); both are added to the core
 * "element_group" content element and stored as real columns.
 */

$GLOBALS['TL_DCA']['tl_content']['fields']['gridRatioActive'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50 clr', 'submitOnChange' => true],
    'sql' => ['type' => 'boolean', 'default' => false],
];

$GLOBALS['TL_DCA']['tl_content']['fields']['gridRatio'] = [
    'label' => ['', ''],
    'exclude' => true,
    'inputType' => 'gridRatio',
    'eval' => ['tl_class' => 'clr'],
    'sql' => ['type' => 'string', 'length' => 255, 'default' => ''],
];

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'gridRatioActive';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['gridRatioActive'] = 'gridRatio';

// addLegend is idempotent: an existing "grid_legend" is reused, otherwise created.
PaletteManipulator::create()
    ->addLegend('grid_legend', 'type_legend', PaletteManipulator::POSITION_AFTER)
    ->addField('gridRatioActive', 'grid_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('element_group', 'tl_content')
;
