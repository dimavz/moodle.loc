<?php
require_once(__DIR__ . '/../../config.php');

if (isset($_REQUEST['data_filters'])) {
    $filters = new \local_aaviewreports\filters($_REQUEST['data_filters']);
    $filtersHtml = $filters->renderItems();
    $checkboxesHtml = $filters->renderAdditionalColumns();
    echo json_encode(['filters' => $filtersHtml, 'checkboxes' =>$checkboxesHtml]);
    exit;
}

if (isset($_REQUEST['clear_filters'])) {
    $table = new \local_aaviewreports\table();
    $filters = new \local_aaviewreports\filters();
    $tableHtml = $table->renderItems();
    $filtersHtml = $filters->renderItems();
    $checkboxesHtml = $filters->renderAdditionalColumns();
    echo json_encode(['table' => $tableHtml, 'filters' => $filtersHtml, 'checkboxes' => $checkboxesHtml]);
    exit;
}

if (isset($_REQUEST['data_table'])) {
    $table = new \local_aaviewreports\table($_REQUEST['data_table']);
    $tableHtml = $table->renderItems();
    echo json_encode(['table' => $tableHtml]);
//    exit;
}

if (isset($_REQUEST['data_trainee'])) {
    $trainee = new \local_aaviewreports\trainee($_REQUEST['data_trainee']);
    echo $trainee->getTrainee();
//    exit;
}
exit;