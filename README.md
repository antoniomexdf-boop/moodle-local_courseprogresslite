# Course Progress Lite (`local_courseprogresslite`)

Lite edition of Course Progress for Moodle.

Current release: `1.0.14 Lite` (`2026031701`)

## Repository

- GitHub: https://github.com/antoniomexdf-boop/moodle-local_courseprogresslite

## Edition Identity

- Repository name: `moodle-local_courseprogresslite`
- Moodle plugin folder: `courseprogresslite`
- Moodle component: `local_courseprogresslite`

## Author and Contact

- Author: Jesus Antonio Jimenez Avina
- Email: antoniomexdf@gmail.com

## Features

- Simple course progress bar for course pages.
- Progress percentage based on Moodle completion tracking only.
- Optional numeric percentage display.
- Optional activity summary with completed and remaining counts.
- Configurable header text.
- Global enable or disable setting.
- Lightweight frontend rendered with a Mustache template.
- GitHub Actions workflow configured for `moodle-plugin-ci` with the plugin path passed explicitly.

## Student Experience

- Students see only the progress bar widget.
- Lite does not include the pending-actions button, pending timeline, or completed-actions counters from Pro.
- Activities without Moodle completion tracking do not affect the percentage.
- The activity summary can show how many completion-enabled activities are completed and how many remain.

## Installation

1. Copy folder `courseprogresslite` to `local/courseprogresslite`.
2. Go to `Site administration > Notifications`.
3. Complete upgrade.
4. Purge Moodle caches.

## Documentation

- User manual (EN): `MANUAL_EN.md`
- Changelog: `CHANGELOG.md`

## Language Packs

- The plugin package ships with English strings only, following Moodle plugin directory guidance.
- Additional translations should be contributed through Moodle translation infrastructure after approval.

## Screenshots

1. Plugin configuration page with the Lite settings.
![Lite plugin settings](screenshots/courseprogresslite_01.png)

2. Student-facing Lite progress bar inside a course page.
![Lite progress widget](screenshots/courseprogresslite_02.png)

## License

GNU GPL v3 or later.
