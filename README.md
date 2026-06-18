<h1 align="center">Contao Grid Ratio Widget</h1>
<p align="center">
    <a href="https://github.com/Digitale-Dinge/contao-grid-ratio-widget"><img src="https://img.shields.io/github/v/release/Digitale-Dinge/contao-grid-ratio-widget" alt="github version"/></a>
    <a href="https://packagist.org/packages/digitaledinge/contao-grid-ratio-widget"><img src="https://img.shields.io/packagist/dt/digitaledinge/contao-grid-ratio-widget?color=f47c00" alt="amount of downloads"/></a>
    <a href="https://packagist.org/packages/digitaledinge/contao-grid-ratio-widget"><img src="https://img.shields.io/packagist/dependency-v/digitaledinge/contao-grid-ratio-widget/php?color=474A8A" alt="minimum php version"></a>
</p>

## Description

Adds a new backend widget that allows to manage grid-columns.

## ToDos

- Inject grid-cols into wrapper classes
- Adjust the JavaScript (MutationObserver) / Drop unnecessary hiding classes
- Apply second Input field to control amount of grid columns (e.g. 2, 3, 4)
- Use HTML within the Twig template when possible, no need to use JS to build the structure

## Installation

### Via composer

```
composer require digitaledinge/contao-grid-ratio-widget
```

## Configuration

Backend Widget

```php
$GLOBALS['TL_DCA']['tl_content']['fields']['gridRatio'] = [
    'exclude' => true,
    'inputType' => 'gridRatio',
    'eval' => [
        'tl_class' => 'w50 clr',
    ],
    'sql' => [
        'type' => 'string',
        'length' => '255',
        'notnull' => true,
    ],
];
```

Frontend CSS

```css
@media (width >= 768px) {
    .your-css-class-holding-grid-properties {
        grid-template-columns: var(--grid-cols);
    }
}
```
