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

The widget is **framework-independent** (e.g. no Tailwind) and **self-contained**:
Installing the bundle adds the field to the `element_group` content element and ships the matching frontend grid CSS.

## How it works

- **Backend:** an "Erweitertes Spaltenset" checkbox reveals the ratio field
  (sub-palette). The ruler snaps to twelfths, so 2/3/4 columns can be split
  evenly and in exact thirds/quarters. Percentages are shown; `fr` is stored.
- **Frontend:** the bundle wraps the nested elements in `<div class="grid-ratio"
  style="--grid-cols: 4fr 8fr">` and ships `grid-ratio` CSS
  (`grid-template-columns: var(--grid-cols)`, stacked on mobile).

## Installation

```bash
composer require digitaledinge/contao-grid-ratio-widget
```

## Customization

The grid-ratio behavior is split into overridable Twig blocks, so you can switch parts off or reuse them elsewhere.

### Resets

```twig
{# @Contao/content_element/element_group.html.twig #}

{% extends '@Contao/content_element/element_group.html.twig' %}

{# Reset the grid_ratio_attributes as they are embedded within _content_wrapper #}
{% block grid_ratio_wrapper_attributes %}{% endblock %}

{# Removing the styles within head #}
{% block grid_ratio_css %}{% endblock %}
```

### Using within your template

To apply a stored value to your own element, add the attributes that will inject the `--grid-cols` variable in your CSS:


```twig
{% extends '@Contao/content_element/_base.html.twig' %}
{% use '@Contao/grid/grid_ratio_attributes.html.twig' %}

{# Adding attributes #}
{% set own_attributes = attrs().mergeWith(block('grid_ratio_attributes')) %}

{# Adding styles #}
{% add 'grid-ratio' to head %}
    <style>
        @media (width >= 768px) {
            .grid-ratio {
                display: grid;
                grid-template-columns: var(--grid-cols, 1fr);
            }
        }
    </style>
{% endadd %}
```
