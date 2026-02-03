<img src="img/logo.svg" alt="Drupier Logo" width="250" />

# Drupier Demo

Drupier Demo is a simple, install-only module that ships with the Drupier theme to provide default content for demo and onboarding purposes. It is **not** intended for production use.

## What it does

- Creates a predefined **Main navigation** (`main`) menu structure with nested items.
- Adds a custom block plugin (`MarqueeExampleBlock`) and creates a block instance assigned to the `header_first` region.

## Important notes

- This module exists only to show placeholder content when the Drupier theme is installed.
- **Disable this module before starting real development.**
- You should also **uninstall it** once you no longer need the demo content.

## Uninstall cleanup

When uninstalled, the module removes:

- All menu items it created.
- The block instance it created (even if it was placed in a region).

## Disable and uninstall

Disable the module with Drush:

```bash
drush pm:uninstall drupier_demo -y
```

Remove it from codebase with Composer:

```bash
composer remove drupier_demo
```

## Location

`web/modules/custom/drupier_demo`
