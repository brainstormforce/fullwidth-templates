# Fullwidth Page Templates

## Project Overview

Fullwidth Page Templates is a WordPress plugin by Brainstorm Force. Create full-width landing pages with any theme using page builder templates.

- **Version:** 1.2.0
- **Text Domain:** fullwidth-templates
- **Main File:** fullwidth-page-template.php
- **Requires:** WordPress, PHP 5.6+

## Tech Stack

- **Language:** PHP
- **Platform:** WordPress
- **Build:** Grunt (i18n, readme conversion)
- **Coding Standards:** PHPCS with WordPress standards

## Commands

```bash
# Install dependencies
npm install
composer install

# Build (i18n + readme)
npx grunt

# Generate translations
npx grunt i18n

# Convert readme.txt to README.md
npx grunt readme

# Run PHPCS
./vendor/bin/phpcs .
```

## Architecture

This is a WordPress plugin following standard WordPress patterns:
- Entry point: `fullwidth-page-template.php`
- Constants defined for version, file path, base, dir, and URI
- Classes loaded via `after_setup_theme` or `plugins_loaded` hook
- Follows WordPress Coding Standards (WPCS)

## Conventions

- Use WordPress hooks (`add_action`, `add_filter`) for extensibility
- Prefix all functions and classes to avoid conflicts
- Use `fullwidth-templates` text domain for all translatable strings
- Escape all output (`esc_html`, `esc_attr`, `esc_url`, `wp_kses`)
- Sanitize all input (`sanitize_text_field`, `absint`, etc.)
- Use nonces for form submissions and AJAX requests
- Follow WordPress PHP coding standards
