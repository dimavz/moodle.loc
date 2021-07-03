<?php
require_once(__DIR__ . '/../../config.php');
include_once(__DIR__ . '/libs/xlsx_writer/xlsxwriter.class.php');

use local_aaviewreports\table;

//$dataFilters = required_param('data-exel', 0, PARAM_RAW);
//echo '<pre>';
//print_r($dataFilters);
//echo '</pre>';
//exit();

//$writer = new XLSXWriter();

if (!empty($_REQUEST['data-exel'])) {
    $data = json_decode($_REQUEST['data-exel']);
    $table = new table($data);

    $table->downloadExelFile();
}
//echo '<pre>';
//print_r($items);
//echo '</pre>';
