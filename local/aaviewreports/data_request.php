<?php
require_once(__DIR__ . '/../../config.php');
//defined('MOODLE_INTERNAL') || die;

//$dataset = optional_param('dataset', '', PARAM_RAW);

if($_REQUEST['data_filters'])
{
    $filters = new \local_aaviewreports\filters($_REQUEST['data_filters']);
    echo $filters->renderItems();
}

if($_REQUEST['clear_filters'])
{
    $filters = new \local_aaviewreports\filters();
    echo $filters->renderItems();
}

if($_REQUEST['datatable'])
{
    $table = new \local_aaviewreports\table($_REQUEST['datatable']);
    echo $table->renderItems();
}

if($_REQUEST['data_trainee'])
{
    $trainee = new \local_aaviewreports\trainee($_REQUEST['data_trainee']);
    echo $trainee->getTrainee();
}
exit;