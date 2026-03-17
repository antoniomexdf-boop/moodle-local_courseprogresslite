# Changelog

All notable changes to `local_courseprogresslite` are documented in this file.

## [1.0.14 Lite] - 2026-03-17

### Fixed

- Removed the invalid `-m` option from the `phpcs` workflow step.
- Kept the CI commands aligned to the installed plugin path under `./moodle/local/courseprogresslite`.

## [1.0.13 Lite] - 2026-03-17

### Changed

- Published a fresh Lite release iteration after the latest screenshot, AMD, and documentation updates so the package version advances cleanly beyond the previously used `1.0.12 Lite` tag.

## [1.0.12 Lite] - 2026-03-16

### Changed

- Added an optional activity summary below the Lite progress bar to show completed and remaining completion-enabled activities.
- Added an admin setting to enable or disable the new activity summary.
- Refreshed the AMD source, build artifact, and sourcemap to support the new summary fields.
