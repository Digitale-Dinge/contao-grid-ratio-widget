<?php

declare(strict_types=1);

use Contao\CoreBundle\DataContainer\PaletteManipulator;

/*
 * Self-contained wiring so the widget works in ANY project by just installing
 * the bundle: a checkbox reveals the ratio field (sub-palette), and both are
 * added to the core "element_group" content element. Stored as real columns.
 */

$GLOBALS['TL_DCA']['tl_content']['fields']['gridRatioActive'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50 clr', 'submitOnChange' => true],
    'sql' => ['type' => 'boolean', 'default' => false],
];

$GLOBALS['TL_DCA']['tl_content']['fields']['gridRatio'] = [
    'exclude' => true,
    'inputType' => 'gridRatio',
    'eval' => ['tl_class' => 'w50 clr'],
    'sql' => ['type' => 'string', 'length' => 255, 'default' => ''],
];

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'gridRatioActive';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['gridRatioActive'] = 'gridRatio';

// Add the toggle to the element group. addLegend is idempotent: if a "grid_legend"
// already exists (e.g. provided by KISS) it is reused, otherwise it is created.
PaletteManipulator::create()
    ->addLegend('grid_legend', 'type_legend', PaletteManipulator::POSITION_AFTER)
    ->addField('gridRatioActive', 'grid_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('element_group', 'tl_content')
;
