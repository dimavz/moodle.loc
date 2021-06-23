<?php
require_once(__DIR__ . '/../../config.php');
defined('MOODLE_INTERNAL') || die;

use local_aaviewreports\filters;

$PAGE->set_url(new moodle_url('/local/aaviewreports/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title('AA View Reports');
$PAGE->set_heading('Reports');
$PAGE->navigation->add(get_string('pluginname', 'local_aaviewreports'), new moodle_url('/local/aaviewreports/index.php'));

// Add Script to page
$urlCustomSelectJS = new \moodle_url('/local/aaviewreports/js/custom_select2.js');
$urlSelectJS = new \moodle_url('/local/aaviewreports/js/select2.min.js');
$urlRequestJS = new \moodle_url('/local/aaviewreports/js/data_request.js');
$urlSelectCSS = new \moodle_url('/local/aaviewreports/css/select2.min.css');
$urlMainCSS = new \moodle_url('/local/aaviewreports/css/main.css');

$PAGE->requires->jquery();
$PAGE->requires->js($urlSelectJS,true);
$PAGE->requires->js($urlRequestJS,true);
$PAGE->requires->js($urlCustomSelectJS);
$PAGE->requires->css($urlSelectCSS);
$PAGE->requires->css($urlMainCSS);

$baseurl = $CFG->wwwroot;

$filters = new filters();
echo $OUTPUT->header();
?>
<script>
    const config_ajax = {
        wwwroot: '<?php echo $baseurl?>',
        settings: {
            type: 'POST',
            // dataType: 'json',
            dataType: 'html',
        }
    }
</script>

<?php
echo $filters->renderHtml();
//echo '<pre>';
//print_r($filters->getFilters());
//echo '</pre>';
////exit();

echo $OUTPUT->footer();
