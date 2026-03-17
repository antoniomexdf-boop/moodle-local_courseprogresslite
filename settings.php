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
 * Settings for local_courseprogresslite.
 *
 * @package   local_courseprogresslite
 * @copyright 2026 Jesus Antonio Jimenez Avina <antoniomexdf@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
=======
>>>>>>> 11d3c600c46a4ce34975e255d5b2bb8faceb3151

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_courseprogresslite', get_string('pluginname', 'local_courseprogresslite'));
    $ADMIN->add('localplugins', $settings);

    $settings->add(new admin_setting_heading(
        'local_courseprogresslite/general',
        get_string('settingsgeneral', 'local_courseprogresslite'),
        ''
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_courseprogresslite/enabled',
        get_string('settingsenabled', 'local_courseprogresslite'),
        get_string('settingsenabled_desc', 'local_courseprogresslite'),
        1
    ));

    $settings->add(new admin_setting_configcheckbox(
<<<<<<< HEAD
=======
        'local_courseprogresslite/countresources',
        get_string('settingscountresources', 'local_courseprogresslite'),
        get_string('settingscountresources_desc', 'local_courseprogresslite'),
        1
    ));

    $settings->add(new admin_setting_configselect(
        'local_courseprogresslite/quizmode',
        get_string('settingsquizmode', 'local_courseprogresslite'),
        get_string('settingsquizmode_desc', 'local_courseprogresslite'),
        'questions',
        [
            'questions' => get_string('settingsquizmode_questions', 'local_courseprogresslite'),
            'activity' => get_string('settingsquizmode_activity', 'local_courseprogresslite'),
        ]
    ));

    $settings->add(new admin_setting_configcheckbox(
>>>>>>> 11d3c600c46a4ce34975e255d5b2bb8faceb3151
        'local_courseprogresslite/showpercentage',
        get_string('settingsshowpercentage', 'local_courseprogresslite'),
        get_string('settingsshowpercentage_desc', 'local_courseprogresslite'),
        1
    ));

    $settings->add(new admin_setting_configtext(
        'local_courseprogresslite/headertext',
        get_string('settingsheadertext', 'local_courseprogresslite'),
        get_string('settingsheadertext_desc', 'local_courseprogresslite'),
        get_string('progresslabel', 'local_courseprogresslite'),
        PARAM_TEXT
    ));
<<<<<<< HEAD
=======

>>>>>>> 11d3c600c46a4ce34975e255d5b2bb8faceb3151
}
