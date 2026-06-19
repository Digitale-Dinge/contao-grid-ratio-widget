<h1 align="center">Contao Grid Ratio Widget</h1>
<p align="center">
    <a href="https://github.com/Digitale-Dinge/contao-grid-ratio-widget"><img src="https://img.shields.io/github/v/release/Digitale-Dinge/contao-grid-ratio-widget" alt="github version"/></a>
    <a href="https://packagist.org/packages/digitaledinge/contao-grid-ratio-widget"><img src="https://img.shields.io/packagist/dt/digitaledinge/contao-grid-ratio-widget?color=f47c00" alt="amount of downloads"/></a>
    <a href="https://packagist.org/packages/digitaledinge/contao-grid-ratio-widget"><img src="https://img.shields.io/packagist/dependency-v/digitaledinge/contao-grid-ratio-widget/php?color=474A8A" alt="minimum php version"></a>
</p>

## Description

Adds a backend widget to define uneven grid column ratios for element groups.
The editor sets a column count (2–4) and drags a ruler to split the width; the
value is stored as a ready-to-use `fr` list (e.g. `4fr 8fr`) and rendered as the
inline custom property `--grid-cols` on the group wrapper.

The widget is **framework-independent** (no Tailwind) and **self-contained**:
just installing the bundle adds the field to the core `element_group` content
element and ships the matching frontend grid CSS.

## How it works

- **Backend:** an "Erweitertes Spaltenset" checkbox reveals the ratio field
  (sub-palette). The ruler snaps to twelfths, so 2/3/4 columns can be split
  evenly and in exact thirds/quarters. Percentages are shown; `fr` is stored.
- **Frontend:** the bundle wraps the nested elements in `<div class="grid-ratio"
  style="--grid-cols: 4fr 8fr">` and ships `grid-ratio` CSS
  (`grid-template-columns: var(--grid-cols)`, stacked on mobile).

## Installation

```
composer require digitaledinge/contao-grid-ratio-widget
```

After installing, run the database update (the bundle adds the `gridRatio` and
`gridRatioActive` columns to `tl_content`). Nothing else is required.

## Using it on a custom field / wrapper

To apply a stored value to your own element, add the inline style with the
shipped Twig function and reuse the `--grid-cols` variable in your CSS:

```twig
{% set attributes = attributes.addStyle('--grid-cols: ' ~ grid_ratio_cols(data.gridRatio|default)) %}
```

```css
@media (width >= 768px) {
    .your-wrapper { grid-template-columns: var(--grid-cols); }
}
```
