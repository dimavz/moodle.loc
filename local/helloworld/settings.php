<?php
// This file is part of Moodle - https://moodle.org/
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
 * Adds admin settings for the plugin.
 *
 * @package     local_helloworld
 * @category    admin
 * @copyright   2020 Your Name <email@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $ADMIN->add('localplugins', new admin_category('local_helloworld_settings', new lang_string('pluginname', 'local_helloworld')));
    $settingspage = new admin_settingpage('managelocalhelloworld', new lang_string('manage', 'local_helloworld'));

    if ($ADMIN->fulltree) {
        $setting = new admin_setting_configcheckbox(
            'local_helloworld/showinnavigation',
            new lang_string('showinnavigation', 'local_helloworld'),
            new lang_string('showinnavigation_desc', 'local_helloworld'),
            1
        );
        $setting->set_advanced_flag_options(admin_setting_flag::ENABLED, true);
        $setting->set_locked_flag_options(admin_setting_flag :: ENABLED, false);
        $settingspage->add($setting);
    }
    $ADMIN->add('localplugins', new admin_category('helloworld_settings',
        get_string('pluginname', 'local_helloworld')));
    $ADMIN->add('helloworld_settings', $settingspage);
    $ADMIN->add('helloworld_settings', new admin_externalpage('pagesettings', get_string('externalpage', 'local_helloworld'),
        $CFG->wwwroot . '/local/helloworld/pagesettings.php'));
}
