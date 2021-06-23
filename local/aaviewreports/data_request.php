<?php
require_once(__DIR__ . '/../../config.php');
//defined('MOODLE_INTERNAL') || die;

if($_REQUEST['dataset'])
{

    $filter = new \local_aaviewreports\filters($_REQUEST['dataset']);
//    echo json_encode($filter->getFilters());
    echo $filter->renderHtml();
}
exit;