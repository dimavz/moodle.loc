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

require_once('../../config.php');
defined('MOODLE_INTERNAL') || die;

$PAGE->set_url(new moodle_url('/local/helloworld/hendler.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title('Мой первый плагин');
$PAGE->set_heading('Plugin Hello World!');

//Подключаем скрипт к странице
//$js_url = new \moodle_url('/local/helloworld/js/main.js');
//$PAGE->requires->js($js_url);

//$context = $PAGE->context;

//echo '<pre>';
//print_r($context);
//echo '</pre>';
//exit();
// Переопределение стандартного вывода из classes/output/render.php
$output = $PAGE->get_renderer('local_helloworld');
//
echo $output->header();
//echo $output->test();

//echo $OUTPUT->header();

$url = new \moodle_url('/local/helloworld/hendler.php'); // Формируем ссылку для обработчика формы

?>
<h1>Hello World</h1>
<p>What is your name?</p>
<form action="<?php echo $PAGE->url ?>">
    <?php
    echo html_writer::tag('input', '', [
        'type' => 'text',
        'name' => 'name',
        'placeholder' => get_string('typeyourname', 'local_helloworld'),
    ]);

    echo html_writer::tag('input', '', [
        'type' => 'submit',
        'name' => 'btn',
        'value' => get_string('submit'),
    ]);

    echo html_writer::tag('input', '', [
        'type' => 'hidden',
        'name' => 'sesskey',
        'value' => sesskey(),
    ]);
    ?>
</form>
<?php
echo $OUTPUT->footer();
?>
