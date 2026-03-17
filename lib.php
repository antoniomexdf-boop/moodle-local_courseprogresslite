<?php
// This file is part of Moodle - http://moodle.org/
<<<<<<< HEAD
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
=======
>>>>>>> 11d3c600c46a4ce34975e255d5b2bb8faceb3151

defined('MOODLE_INTERNAL') || die();

/**
 * Gets a plugin setting with fallback.
 *
<<<<<<< HEAD
 * @param string $name Setting name.
 * @param mixed $default Default value.
=======
 * @param string $name
 * @param mixed $default
>>>>>>> 11d3c600c46a4ce34975e255d5b2bb8faceb3151
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
<<<<<<< HEAD
 * Lite uses Moodle completion tracking only. Activities without completion
 * tracking do not contribute to the percentage.
 *
 * @param stdClass $course Course record.
 * @param int $userid User id.
 * @return array<string,int>
=======
 * @param stdClass $course
 * @param int $userid
 * @return array
>>>>>>> 11d3c600c46a4ce34975e255d5b2bb8faceb3151
 */
function local_courseprogresslite_get_snapshot(stdClass $course, int $userid): array {
    require_once(__DIR__ . '/../../lib/completionlib.php');

    $modinfo = get_fast_modinfo($course);
    $completioninfo = new completion_info($course);
<<<<<<< HEAD
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
=======
    $viewedcmids = local_courseprogresslite_get_viewed_cmids((int)$course->id, $userid);
    $settings = [
        'countresources' => (int)local_courseprogresslite_get_setting('countresources', 1),
        'quizmode' => (string)local_courseprogresslite_get_setting('quizmode', 'questions'),
    ];

    $completedunits = 0;
    $totalunits = 0;
    foreach ($modinfo->get_cms() as $cm) {
        if (!local_courseprogresslite_should_count_cm($cm, $settings)) {
            continue;
        }

        $progress = local_courseprogresslite_get_cm_progress($cm, $userid, $completioninfo, $viewedcmids, $settings);
        $completedunits += $progress['completedunits'];
        $totalunits += $progress['totalunits'];
>>>>>>> 11d3c600c46a4ce34975e255d5b2bb8faceb3151
    }

    $percentage = 0;
    if ($totalunits > 0) {
        $percentage = (int)round(($completedunits / $totalunits) * 100);
    }

    return [
        'completedunits' => $completedunits,
        'totalunits' => $totalunits,
        'percentage' => max(0, min(100, $percentage)),
    ];
}

/**
<<<<<<< HEAD
 * Determines whether a module should be counted toward progress.
 *
 * @param cm_info $cm Course module information.
 * @param completion_info $completioninfo Course completion helper.
 * @return bool
 */
function local_courseprogresslite_should_count_cm(cm_info $cm, completion_info $completioninfo): bool {
=======
 * Determines whether a module should be counted.
 *
 * @param cm_info $cm
 * @return bool
 */
function local_courseprogresslite_should_count_cm(cm_info $cm, array $settings): bool {
>>>>>>> 11d3c600c46a4ce34975e255d5b2bb8faceb3151
    if (!$cm->visible) {
        return false;
    }

<<<<<<< HEAD
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
function local_courseprogresslite_is_cm_completed(cm_info $cm, int $userid, completion_info $completioninfo): bool {
    $data = $completioninfo->get_data($cm, true, $userid);

    return !empty($data->completionstate) && (int)$data->completionstate !== COMPLETION_INCOMPLETE;
=======
    if (in_array($cm->modname, ['label', 'attendance'], true)) {
        return false;
    }

    if (in_array($cm->modname, ['resource', 'url', 'page', 'book', 'folder'], true) && empty($settings['countresources'])) {
        return false;
    }

    return true;
}

/**
 * Returns whether the module is not yet visible to the user due to availability.
 *
 * @param cm_info $cm
 * @return bool
 */
function local_courseprogresslite_is_pending_visibility(cm_info $cm): bool {
    return !$cm->uservisible;
}

/**
 * Gets progress units for one course module.
 *
 * @param cm_info $cm
 * @param int $userid
 * @param completion_info $completioninfo
 * @param array $viewedcmids
 * @return array
 */
function local_courseprogresslite_get_cm_progress(
    cm_info $cm,
    int $userid,
    completion_info $completioninfo,
    array $viewedcmids,
    array $settings
): array {
    if ($cm->modname === 'quiz' && ($settings['quizmode'] ?? 'questions') === 'questions') {
        return local_courseprogresslite_get_quiz_progress($cm, $userid);
    }

    $completed = !local_courseprogresslite_is_pending_visibility($cm) &&
        local_courseprogresslite_is_cm_completed($cm, $userid, $completioninfo, $viewedcmids);
    return [
        'completedunits' => $completed ? 1 : 0,
        'totalunits' => 1,
    ];
}

/**
 * Gets quiz progress using the question count as total units.
 *
 * @param cm_info $cm
 * @param int $userid
 * @return array
 */
function local_courseprogresslite_get_quiz_progress(cm_info $cm, int $userid): array {
    global $DB;

    $totalquestions = (int)$DB->count_records('quiz_slots', ['quizid' => (int)$cm->instance]);
    $totalunits = max(1, $totalquestions);
    $completedunits = 0;
    $name = format_string($cm->name ?: 'Quiz');

    if (local_courseprogresslite_is_pending_visibility($cm)) {
        return [
            'completedunits' => 0,
            'totalunits' => $totalunits,
        ];
    }

    $attempts = $DB->get_records(
        'quiz_attempts',
        ['quiz' => (int)$cm->instance, 'userid' => $userid],
        'timemodified DESC, attempt DESC',
        'id,uniqueid',
        0,
        1
    );
    $attempt = $attempts ? reset($attempts) : false;

    if ($attempt && !empty($attempt->uniqueid)) {
        $sql = "SELECT COUNT(DISTINCT qa.slot)
                  FROM {question_attempts} qa
                 WHERE qa.questionusageid = :usageid
                   AND qa.responsesummary IS NOT NULL
                   AND " . $DB->sql_compare_text('qa.responsesummary') . " <> :emptytext";
        $completedunits = (int)$DB->count_records_sql($sql, [
            'usageid' => (int)$attempt->uniqueid,
            'emptytext' => '',
        ]);
    }

    return [
        'completedunits' => max(0, min($totalunits, $completedunits)),
        'totalunits' => $totalunits,
    ];
}

/**
 * Determines whether a non-quiz course module can be treated as completed.
 *
 * @param cm_info $cm
 * @param int $userid
 * @param completion_info $completioninfo
 * @param array $viewedcmids
 * @return bool
 */
function local_courseprogresslite_is_cm_completed(
    cm_info $cm,
    int $userid,
    completion_info $completioninfo,
    array $viewedcmids
): bool {
    global $DB;

    if (local_courseprogresslite_is_pending_visibility($cm)) {
        return false;
    }

    if ($completioninfo->is_enabled($cm) != COMPLETION_TRACKING_NONE) {
        $data = $completioninfo->get_data($cm, true, $userid);
        if (!empty($data->completionstate) && (int)$data->completionstate !== COMPLETION_INCOMPLETE) {
            return true;
        }
    }

    switch ($cm->modname) {
        case 'assign':
            return $DB->record_exists_select(
                'assign_submission',
                'assignment = :assignment AND userid = :userid AND status = :status',
                ['assignment' => (int)$cm->instance, 'userid' => $userid, 'status' => 'submitted']
            );

        case 'choice':
            return $DB->record_exists('choice_answers', ['choiceid' => (int)$cm->instance, 'userid' => $userid]);

        case 'feedback':
            return $DB->record_exists('feedback_completed', ['feedback' => (int)$cm->instance, 'userid' => $userid]);

        case 'forum':
            return $DB->record_exists_sql(
                "SELECT 1
                   FROM {forum_posts} fp
                   JOIN {forum_discussions} fd ON fd.id = fp.discussion
                  WHERE fd.forum = :forumid
                    AND fp.userid = :userid",
                ['forumid' => (int)$cm->instance, 'userid' => $userid]
            );

        case 'glossary':
            return $DB->record_exists('glossary_entries', ['glossaryid' => (int)$cm->instance, 'userid' => $userid]);

        case 'lesson':
            return $DB->record_exists('lesson_attempts', ['lessonid' => (int)$cm->instance, 'userid' => $userid]);

        case 'data':
            return $DB->record_exists('data_records', ['dataid' => (int)$cm->instance, 'userid' => $userid]);

        case 'h5pactivity':
            return $DB->record_exists('h5pactivity_attempts', ['h5pactivityid' => (int)$cm->instance, 'userid' => $userid]);

        case 'scorm':
            return $DB->record_exists('scorm_scoes_track', ['scormid' => (int)$cm->instance, 'userid' => $userid]);

        case 'workshop':
            return $DB->record_exists('workshop_submissions', ['workshopid' => (int)$cm->instance, 'authorid' => $userid]);

        case 'resource':
        case 'url':
        case 'page':
        case 'book':
        case 'folder':
            return in_array((int)$cm->id, $viewedcmids, true);
    }

    return in_array((int)$cm->id, $viewedcmids, true);
}

/**
 * Gets course module ids viewed by the user from standard logs.
 *
 * @param int $courseid
 * @param int $userid
 * @return array
 */
function local_courseprogresslite_get_viewed_cmids(int $courseid, int $userid): array {
    global $DB;

    if (!$DB->get_manager()->table_exists('logstore_standard_log')) {
        return [];
    }

    $records = $DB->get_records_sql(
        "SELECT DISTINCT contextinstanceid
           FROM {logstore_standard_log}
          WHERE courseid = :courseid
            AND userid = :userid
            AND contextlevel = :contextlevel
            AND action = :action",
        [
            'courseid' => $courseid,
            'userid' => $userid,
            'contextlevel' => CONTEXT_MODULE,
            'action' => 'viewed',
        ]
    );

    return array_map('intval', array_keys($records));
>>>>>>> 11d3c600c46a4ce34975e255d5b2bb8faceb3151
}

/**
 * Queue required assets.
 *
<<<<<<< HEAD
 * @param stdClass $course Course record.
=======
 * @param stdClass $course
>>>>>>> 11d3c600c46a4ce34975e255d5b2bb8faceb3151
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
    $headertext = (string)local_courseprogresslite_get_setting('headertext', get_string('progresslabel', 'local_courseprogresslite'));

<<<<<<< HEAD
=======
    $PAGE->requires->css('/local/courseprogresslite/styles.css');
>>>>>>> 11d3c600c46a4ce34975e255d5b2bb8faceb3151
    $PAGE->requires->js_call_amd('local_courseprogresslite/progress', 'init', [[
        'label' => $headertext,
        'value' => $snapshot['percentage'],
        'maxlabel' => '100%',
        'showpercentage' => $showpercentage,
<<<<<<< HEAD
        'progressbarlabel' => get_string('progressbarlabel', 'local_courseprogresslite', $snapshot['percentage']),
=======
>>>>>>> 11d3c600c46a4ce34975e255d5b2bb8faceb3151
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

<<<<<<< HEAD
    return '<div id="local-courseprogresslite" class="local-courseprogresslite" aria-live="polite"></div>';
=======
    return '<div id="local-courseprogress" class="local-courseprogress" aria-live="polite"></div>';
>>>>>>> 11d3c600c46a4ce34975e255d5b2bb8faceb3151
}

/**
 * Fallback hook to always load assets in course pages.
 *
<<<<<<< HEAD
 * @param global_navigation $navigation Navigation object.
 * @param stdClass $course Course record.
 * @param context_course $context Course context.
=======
 * @param global_navigation $navigation
 * @param stdClass $course
 * @param context_course $context
>>>>>>> 11d3c600c46a4ce34975e255d5b2bb8faceb3151
 * @return void
 */
function local_courseprogresslite_extend_navigation_course($navigation, $course, $context): void {
    if (empty($course->id) || (int)$course->id === SITEID || !(int)local_courseprogresslite_get_setting('enabled', 1)) {
        return;
    }

    local_courseprogresslite_bootstrap($course);
}
