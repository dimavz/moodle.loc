<?php
require_once(__DIR__ . '/../../config.php');
defined('MOODLE_INTERNAL') || die;

require_login(null, false);

use local_aaviewreports\filters;
use local_aaviewreports\table;

$PAGE->set_url(new moodle_url('/local/aaviewreports/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title('AA View Reports');
$PAGE->set_heading('Reports');
$PAGE->add_body_class('aaviewreports');
$PAGE->navigation->add(get_string('pluginname', 'local_aaviewreports'), new moodle_url('/local/aaviewreports/index.php'));

// Add CSS to page
$urlChosenCSS = new \moodle_url('/local/aaviewreports/css/chosen.css');
$urlMainCSS = new \moodle_url('/local/aaviewreports/css/main.css');

// Add Script to page
$PAGE->requires->jquery();
$PAGE->requires->js_call_amd("local_aaviewreports/certificationreport", 'init');
$PAGE->requires->js_call_amd("local_aaviewreports/chosen");
// Add CSS to page
$PAGE->requires->css(new moodle_url('https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'));
$PAGE->requires->css($urlChosenCSS);
$PAGE->requires->css($urlMainCSS);

$baseurl = $CFG->wwwroot;

$filters = new filters();
$table = new table();

$urlDownload = new \moodle_url('/local/aaviewreports/exel_download.php');

echo $OUTPUT->header();
?>
    <script>
        const configAjax = {
            wwwroot: '<?php echo $baseurl?>',
        }
    </script>
    <div class="aaviewreports_wrap">
    <form id="form-filters" action="<?php echo $urlDownload ?>" method="post">
        <div id="filters_aaviewreports">

            <?php
            echo $filters->renderItems();
            ?>
    </div>
        <div class="filters_buttons">
        <div class="additional-columns">
            <div id="ac-title" class="ac-title">Additional columns<span class="arrow-down"></span></div>
            <div class="list-columns">
                <?php echo $filters->renderAdditionalColumns(); ?>
            </div>
        </div>
        <div class="btns-left">
            <div class="top-btns">
                <div class="btn-reset" id="clear-filters">
                    <span class="icon-close"></span>
                    <span>Clear all filters</span>
                </div>
                <button id="apply-filters" class="btn btn-apply">Apply filters</button>
            </div>
            <div class="download_button">
                <button type="submit" id="download-exel" class="btn btn-download">Download</button>
            </div>
        </div>
    </div>
        <input type="hidden" name='data-exel' value="">
    </form>
    <div class="loader__wrap">
        <div id="loader"></div>
    </div>
<?php
echo \html_writer::start_tag('div', ['id' => 'table_aaviewreports']);
echo $table->renderItems();
echo \html_writer::end_tag('div');
?>
    </div>
<?php
//echo $table->renderRawTable();
echo $OUTPUT->footer();
