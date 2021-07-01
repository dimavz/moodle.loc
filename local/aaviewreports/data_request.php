<?php
require_once(__DIR__ . '/../../config.php');
//defined('MOODLE_INTERNAL') || die;

//$dataset = optional_param('dataset', '', PARAM_RAW);

if($_REQUEST['data_filters'])
{
    $filters = new \local_aaviewreports\filters($_REQUEST['data_filters']);
    echo json_encode(['filters'=>$filters->renderItems(),'checkboxes' =>$filters->renderAdditionalColumns()]);
}

if($_REQUEST['clear_filters'])
{
    $filters = new \local_aaviewreports\filters();
    echo json_encode(['filters'=>$filters->renderItems()]);
}

if($_REQUEST['data_table'])
{
    $table = new \local_aaviewreports\table($_REQUEST['data_table']);
    echo json_encode(['table'=>$table->renderItems()]);
}

if($_REQUEST['data_trainee'])
{
    $trainee = new \local_aaviewreports\trainee($_REQUEST['data_trainee']);
    echo $trainee->getTrainee();
}
exit;