<?php
// This file is part of Moodle - http://moodle.org/

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

}
