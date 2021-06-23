<?php
defined('MOODLE_INTERNAL') || die();
require_login();

if ($hassiteconfig) {
    $ADMIN->add('localplugins', new admin_category('local_aaviewreports_settings', new lang_string('pluginname', 'local_aaviewreports')));
    $settingspage = new admin_settingpage('managelocalaaviewreports', new lang_string('pluginname', 'local_aaviewreports'));

    if ($ADMIN->fulltree) {
        $url = new admin_setting_configtext(
            'local_aaviewreports/url',
            new lang_string('url', 'local_aaviewreports'),
            new lang_string('url_desc', 'local_aaviewreports'),
            '',PARAM_URL, 60);
        $token = new admin_setting_configtext('local_aaviewreports/token', get_string('token', 'local_aaviewreports'),
            get_string('token_desc', 'local_aaviewreports'), '',PARAM_TEXT,60);
        $settingspage->add($url);
        $settingspage->add($token);
    }
    $ADMIN->add('localplugins', $settingspage);
}
