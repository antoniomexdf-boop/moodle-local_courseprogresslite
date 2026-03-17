# Changelog

All notable changes to `local_courseprogresslite` are documented in this file.

## [1.0.11 Lite] - 2026-03-16

### Fixed

- Added a complete example context to the Lite Mustache template so `moodle-plugin-ci mustache` can validate the rendered markup without empty `aria-valuenow` and inline width values.

## [1.0.10 Lite] - 2026-03-16

### Fixed

- Updated the GitHub Actions workflow so `moodle-plugin-ci` checks run against the installed plugin path inside `./moodle`, which avoids Mustache basename errors and Grunt backup issues on the repository checkout.

## [1.0.9 Lite] - 2026-03-16

### Fixed

- Removed the unnecessary `MOODLE_INTERNAL` guard from `lib.php` and wrapped the long header-text assignment to satisfy Moodle Code Checker warnings.

## [1.0.8 Lite] - 2026-03-16

### Changed

- Unified Lite file headers, license metadata, author details, and public documentation wording with the standard already used in Course Progress Pro.
- Normalized the AMD build header style to match the Pro package conventions.
