# Changelog

All notable changes to `local_courseprogresslite` are documented in this file.

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

## [1.0.5 Lite] - 2026-03-16

### Changed

- Accepted the latest AMD rebuild, refreshed release metadata, and prepared a clean GitHub/Moodle distribution package for Course Progress Lite.

## [1.0.4 Lite] - 2026-03-08

### Fixed

- Restored `Header text` setting in admin configuration.
- `Enable plugin` now blocks rendering consistently across hooks.
