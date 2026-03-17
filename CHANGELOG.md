# Changelog

All notable changes to `local_courseprogresslite` are documented in this file.

## [1.0.9 Lite] - 2026-03-16

### Fixed

- Removed the unnecessary `MOODLE_INTERNAL` guard from `lib.php` and wrapped the long header-text assignment to satisfy Moodle Code Checker warnings.

## [1.0.8 Lite] - 2026-03-16

### Changed

- Unified Lite file headers, license metadata, author details, and public documentation wording with the standard already used in Course Progress Pro.
- Normalized the AMD build header style to match the Pro package conventions.

## [1.0.7 Lite] - 2026-03-16

### Fixed

- Fixed the GitHub Actions workflow to pass the plugin path to all `moodle-plugin-ci` commands.
- Removed the unresolved merge-conflict state that had broken `version.php` in the GitHub repository copy.

## [1.0.6 Lite] - 2026-03-16

### Fixed

- Reworked Lite to remove log-based activity detection and use Moodle completion tracking as the only progress source.
- Replaced string-built HTML in the AMD source with Mustache rendering through `core/templates`.
- Removed manual `$PAGE->requires->css()` loading for plugin `styles.css`.
- Added Moodle boilerplate and explicit metadata to the remaining source files flagged by plugin review.
- Refreshed the AMD build artifact and added `amd/build/progress.min.js.map`.

### Changed

- Simplified Lite configuration to the settings that still apply to the Lite edition.
- Cleaned the distribution package for Moodle plugin directory submission.
