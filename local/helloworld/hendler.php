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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

require_once(__DIR__ . '/../../config.php');
defined('MOODLE_INTERNAL') || die;
require_login(); // Проверяем, является ли пользователь зарегестрированным

// Проверяем, является ли пользователь гостем. Если да, то генерируем ошибку
// Гостям закрываем доступ к скрипту
if (isguestuser()){
    print_error('noguest');
}



$form_url = new moodle_url('/local/helloworld/index.php');
$home_url = new moodle_url('/');

$name = optional_param('name', '', PARAM_NOTAGS);
//$name = optional_param('name', '', PARAM_RAW);
$name = s($name); // s()- Это оболочка для родного PHP htmlspecialchars(). Его следует использовать для простых текстов, где мы не хотим интерпретировать какой-либо HTML.
//$sesskey = optional_param('sesskey', '',PARAM_RAW);

$great = empty($name) ? "Hello world!" : "Hello, " . $name;

//echo html_writer::link($url, get_string('name'));

if (!empty($name)) {
    require_sesskey(); // Проверяем ключ сессии.
    // Делайте все, что вам нужно, например удаление данных из БД $DB->delete_records (...) и т.д.
    $table = 'local_helloworld';
    $dataobject = new stdClass();
    $dataobject->name = $name;
    try {
        $transaction = $DB->start_delegated_transaction();

        $new_id = $DB->insert_record($table, $dataobject);
        if (!empty($new_id)) {
            $data = new stdClass();
            $data->datetime = time();
            $data->greet_id = $new_id;
            $DB->insert_record($table . '_date', $data);
        }
        $transaction->allow_commit();
    } catch (Exception $e) {
        $transaction->rollback($e);
    }
}
$PAGE->set_url(new moodle_url('/local/helloworld/hendler.php'));
$PAGE->set_context(context_system::instance());
//$PAGE->set_context(context_coursecat::instance(1));
$PAGE->set_pagelayout('standard');
$PAGE->set_title($great);
$PAGE->set_heading(get_string('pluginname', 'local_helloworld'));
$PAGE->navigation->add(get_string('pluginname', 'local_helloworld'), new moodle_url('/local/helloworld/hendler.php'));
echo $OUTPUT->header();

?>

    <h1><?php echo $great ?></h1>
    <p><a href="<?php echo $home_url ?>">Home</a></p>
    <p><a href="<?php echo $form_url ?>">Plugin Main Page</a></p>
<?php
$sql = "SELECT u.id,u.name,d.datetime FROM {local_helloworld} u JOIN {local_helloworld_date} d ON d.greet_id = u.id GROUP BY d.datetime";

$records = $DB->get_records_sql($sql);

if (!empty($records)) {
    ?>
    <table>
        <tr>
            <th>User Name</th>
            <th>Date</th>
        </tr>
        <?php foreach ($records as $record): ?>
            <tr>
                <td><?php echo $record->name ?></td>
                <td><?php echo userdate($record->datetime, get_string('strftimerecentfull', 'core_langconfig'));  ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php

}
echo $OUTPUT->footer();




