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
// along with Moodle.  If not, see https://www.gnu.org/licenses/.

/**
 * Provides the {@see xmldb_local_helloworld_upgrade()} function.
 *
 * @package     local_helloworld
 * @category    upgrade
 * @copyright   2020 Your Name <email@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Define upgrade steps to be performed to upgrade the plugin from the old version to the current one.
 *
 * @param int $oldversion Version number the plugin is being upgraded from.
 */
function xmldb_local_helloworld_upgrade($oldversion) {

    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2021061502) {
        // Define table local_helloworld_date to be created.
        $table = new xmldb_table('local_helloworld_date');

        // Adding fields to table local_helloworld_date.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('datetime', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('greet_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table local_helloworld_date.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('helloworld_id', XMLDB_KEY_FOREIGN, ['greet_id'], 'local_helloworld', ['id']);

        // Conditionally launch create table for local_helloworld_date.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Helloworld savepoint reached.
        upgrade_plugin_savepoint(true, 2021061502, 'local', 'helloworld');
    }

    return true;
}