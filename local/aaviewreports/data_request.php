<?php
require_once(__DIR__ . '/../../config.php');
//defined('MOODLE_INTERNAL') || die;

//$dataset = optional_param('dataset', '', PARAM_RAW);

if($_REQUEST['dataset'])
{
    $filters = new \local_aaviewreports\filters($_REQUEST['dataset']);
    echo $filters->renderItems();
}

if($_REQUEST['clearfilters'])
{
    $filters = new \local_aaviewreports\filters();
    echo $filters->renderItems();
}

if($_REQUEST['datatable'])
{
    $table = new \local_aaviewreports\table($_REQUEST['datatable']);
    echo $table->renderItems();
}
exit;