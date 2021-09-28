<?php

require_once('../../config.php');
defined('MOODLE_INTERNAL') || die;

$PAGE->set_url(new moodle_url('/local/testdb/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title('Мой тестовый плагин для Базы Данных');
$PAGE->set_heading('Плагин для тестов Базы Данных!');
//$PAGE->navigation->add(get_string('pluginname', 'local_testdb'),new moodle_url('/local/testdb/index.php'));
// Стандартный вывод
echo $OUTPUT->header();

global $DB;

$query = 'SELECT
mdl_user.username,
mdl_user.firstname,
mdl_user.lastname,
mdl_role.`name` as role
FROM
mdl_user
INNER JOIN mdl_role_assignments ON mdl_role_assignments.userid = mdl_user.id
INNER JOIN mdl_role ON mdl_role_assignments.roleid = mdl_role.id
INNER JOIN mdl_role_capabilities ON mdl_role_capabilities.roleid = mdl_role.id
INNER JOIN mdl_capabilities ON mdl_role_capabilities.capability = mdl_capabilities.`name`';


$query2 = 'SELECT
       count(*)
FROM
mdl_user
INNER JOIN mdl_role_assignments ON mdl_role_assignments.userid = mdl_user.id
INNER JOIN mdl_role ON mdl_role_assignments.roleid = mdl_role.id
INNER JOIN mdl_role_capabilities ON mdl_role_capabilities.roleid = mdl_role.id
INNER JOIN mdl_capabilities ON mdl_role_capabilities.capability = mdl_capabilities.`name`
WHERE 1';

//$user_roles = $DB->get_records_sql($query);
//echo '<pre>';
//print_r($user_roles);
//echo '</pre>';

//$rs = $DB->get_recordset_sql($query);
////$rs = $DB->get_recordset_sql($query,array(),0,200);
//if ($rs->valid()) {
//    // Набор записей содержит несколько записей.
//    foreach ($rs as $record) {
//        // Делайте с этой записью все, что хотите
////        echo '<pre>';
////        print_r($record);
////        echo '</pre>';
//    }
//}
//$rs->close();

//echo '<pre>';
//print_r($rs);
//echo '</pre>';

$count_user_roles = $DB->count_records_sql($query2);

$per = 500000;

$num = ceil($count_user_roles / $per);
//echo '<pre>';
//print_r($count_user_roles);
//echo '</pre>';
//exit();

//$dbmanager = $DB->get_manager();
//echo '<pre>';
//print_r($dbmanager);
//echo '</pre>';
//$dbmanager->drop_table('local_helloworld');
//$dbmanager->reset_sequence('local_helloworld');

try {
    $transaction = $DB->start_delegated_transaction();
    $DB->delete_records('local_helloworld');
    $DB->execute('ALTER TABLE {local_helloworld} AUTO_INCREMENT = 1');
    $transaction->allow_commit();
} catch (Exception $e) {
    $transaction->rollback($e);
    echo '<pre>';
    print_r($e->getMessage());
    echo '</pre>';
}






echo $OUTPUT->footer();