<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Library callbacks for local_courseprogresslite.
 *
 * @package   local_courseprogresslite
 * @copyright 2026 Jesus Antonio Jimenez Avina <antoniomexdf@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Gets a plugin setting with fallback.
 *
 * @param string $name Setting name.
 * @param mixed $default Default value.
 * @return mixed
 */
function local_courseprogresslite_get_setting(string $name, $default) {
    $value = get_config('local_courseprogresslite', $name);
    if ($value === false || $value === null || $value === '') {
        return $default;
    }

    return $value;
}

/**
 * Returns whether the plugin should render on the current page.
 *
 * @return bool
 */
function local_courseprogresslite_should_render(): bool {
    global $PAGE, $USER;

    if (!(int)local_courseprogresslite_get_setting('enabled', 1)) {
        return false;
    }

    if (empty($PAGE->course) || empty($PAGE->course->id) || (int)$PAGE->course->id === SITEID) {
        return false;
    }

    if (empty($USER->id) || isguestuser()) {
        return false;
    }

    return true;
}

/**
 * Builds the progress snapshot for the current user.
 *
 * Lite uses Moodle completion tracking only. Activities without completion
 * tracking do not contribute to the percentage.
 *
 * @param stdClass $course Course record.
 * @param int $userid User id.
 * @return array<string,int>
 */
function local_courseprogresslite_get_snapshot(stdClass $course, int $userid): array {
    require_once(__DIR__ . '/../../lib/completionlib.php');

    $modinfo = get_fast_modinfo($course);
    $completioninfo = new completion_info($course);
    $completedunits = 0;
    $totalunits = 0;

    foreach ($modinfo->get_cms() as $cm) {
        if (!local_courseprogresslite_should_count_cm($cm, $completioninfo)) {
            continue;
        }

        $totalunits++;
        if (local_courseprogresslite_is_cm_completed($cm, $userid, $completioninfo)) {
            $completedunits++;
        }
    }

    $percentage = 0;
    if ($totalunits > 0) {
        $percentage = (int)round(($completedunits / $totalunits) * 100);
    }

    return [
        'completedunits' => $completedunits,
        'totalunits' => $totalunits,
        'remainingunits' => max(0, $totalunits - $completedunits),
        'percentage' => max(0, min(100, $percentage)),
    ];
}

/**
 * Determines whether a module should be counted toward progress.
 *
 * @param cm_info $cm Course module information.
 * @param completion_info $completioninfo Course completion helper.
 * @return bool
 */
function local_courseprogresslite_should_count_cm(cm_info $cm, completion_info $completioninfo): bool {
    if (!$cm->visible) {
        return false;
    }

    return $completioninfo->is_enabled($cm) != COMPLETION_TRACKING_NONE;
}

/**
 * Determines whether a counted course module is completed for the user.
 *
 * @param cm_info $cm Course module information.
 * @param int $userid User id.
 * @param completion_info $completioninfo Course completion helper.
 * @return bool
 */
function local_courseprogresslite_is_cm_completed(
    cm_info $cm,
    int $userid,
    completion_info $completioninfo
): bool {
    $data = $completioninfo->get_data($cm, true, $userid);

    return !empty($data->completionstate) && (int)$data->completionstate !== COMPLETION_INCOMPLETE;
}

/**
 * Queue required assets.
 *
 * @param stdClass $course Course record.
 * @return void
 */
function local_courseprogresslite_bootstrap(stdClass $course): void {
    global $PAGE, $USER;

    static $loaded = false;
    if ($loaded || empty($USER->id) || isguestuser() || !(int)local_courseprogresslite_get_setting('enabled', 1)) {
        return;
    }
    $loaded = true;

    $snapshot = local_courseprogresslite_get_snapshot($course, (int)$USER->id);
    $showpercentage = (int)local_courseprogresslite_get_setting('showpercentage', 1);
    $showactivitysummary = (int)local_courseprogresslite_get_setting('showactivitysummary', 1);
    $headertext = (string)local_courseprogresslite_get_setting(
        'headertext',
        get_string('progresslabel', 'local_courseprogresslite')
    );
    $summarydata = (object) [
        'completed' => $snapshot['completedunits'],
        'total' => $snapshot['totalunits'],
    ];

    $PAGE->requires->js_call_amd('local_courseprogresslite/progress', 'init', [[
        'label' => $headertext,
        'value' => $snapshot['percentage'],
        'maxlabel' => '100%',
        'showpercentage' => $showpercentage,
        'showactivitysummary' => $showactivitysummary,
        'activitysummary' => get_string('activitysummary', 'local_courseprogresslite', $summarydata),
        'remainingactivities' => get_string(
            'remainingactivities',
            'local_courseprogresslite',
            $snapshot['remainingunits']
        ),
        'progressbarlabel' => get_string(
            'progressbarlabel',
            'local_courseprogresslite',
            $snapshot['percentage']
        ),
    ]]);
}

/**
 * Render progress container at top of body.
 *
 * @return string
 */
function local_courseprogresslite_before_standard_top_of_body_html(): string {
    global $PAGE;

    if (!local_courseprogresslite_should_render()) {
        return '';
    }

    local_courseprogresslite_bootstrap($PAGE->course);

    return '<div id="local-courseprogresslite" class="local-courseprogresslite" aria-live="polite"></div>';
}

/**
 * Fallback hook to always load assets in course pages.
 *
 * @param global_navigation $navigation Navigation object.
 * @param stdClass $course Course record.
 * @param context_course $context Course context.
 * @return void
 */
function local_courseprogresslite_extend_navigation_course($navigation, $course, $context): void {
    if (empty($course->id) || (int)$course->id === SITEID || !(int)local_courseprogresslite_get_setting('enabled', 1)) {
        return;
    }

    local_courseprogresslite_bootstrap($course);
}
