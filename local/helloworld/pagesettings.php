<?php
require_once(__DIR__ . '/../../config.php');
defined('MOODLE_INTERNAL') || die;
//admin_externalpage_setup('pagesettings');
use local_helloworld\helloworld_form;

$PAGE->set_url(new moodle_url('/local/helloworld/pagessetings.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title($great);
$PAGE->set_heading(get_string('pluginname', 'local_helloworld'));
$PAGE->navigation->add(get_string('externalpage', 'local_helloworld'),$PAGE->url);

echo $OUTPUT->header();
$form = new helloworld_form();
$form->display();
echo $OUTPUT->footer();
