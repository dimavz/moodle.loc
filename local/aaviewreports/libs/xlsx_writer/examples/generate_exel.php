<?php

set_include_path(get_include_path() . PATH_SEPARATOR . "..");
include_once("xlsxwriter.class.php");

generateExel(10, 40000);

function generateExel($num_cells, $num_rows)
{
    $start = microtime(true);
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789 ";
    $s = '';
    for ($n = 0; $n < 16192; $n++)
        $s .= $chars[rand() % 36];

    $writer = new XLSXWriter();

    $headers = array();

    for ($i = 0; $i <= $num_cells; $i++) {
        $headers['c' . ($i + 1)] = 'string';
    }

    $writer->writeSheetHeader('Sheet1', $headers);

    for ($i = 0; $i <= $num_rows; $i++) {
        $data = array();
        for($j=0;$j<= count($headers);$j++){
            $val = substr($s, rand() % (1000*($j+1)), rand() % 5 + 5);
            array_push($data,$val);
        }
        $writer->writeSheetRow('Sheet1', $data);
    }
    $writer->writeToFile('xlsx-colls-' . $num_cells . '-rows-' . $num_rows . '.xlsx');
    echo '#' . floor((memory_get_peak_usage()) / 1024 / 1024) . "MB" . "\n";
    echo '<br>===============================================================';
    echo 'Время выполнения скрипта: ' . (microtime(true) - $start) . ' sec.';
}