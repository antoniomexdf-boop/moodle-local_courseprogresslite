# Changelog

All notable changes to `local_courseprogresslite` are documented in this file.

## [1.0.13 Lite] - 2026-03-17

### Changed

- Published a fresh Lite release iteration after the latest screenshot, AMD, and documentation updates so the package version advances cleanly beyond the previously used `1.0.12 Lite` tag.

## [1.0.12 Lite] - 2026-03-16

### Changed

- Added an optional activity summary below the Lite progress bar to show completed and remaining completion-enabled activities.
- Added an admin setting to enable or disable the new activity summary.
- Refreshed the AMD source, build artifact, and sourcemap to support the new summary fields.

## [1.0.11 Lite] - 2026-03-16

### Fixed

- Added a complete example context to the Lite Mustache template so `moodle-plugin-ci mustache` can validate the rendered markup without empty `aria-valuenow` and inline width values.

## [1.0.10 Lite] - 2026-03-16

### Fixed

- Updated the GitHub Actions workflow so `moodle-plugin-ci` checks run against the installed plugin path inside `./moodle`, which avoids Mustache basename errors and Grunt backup issues on the repository checkout.
