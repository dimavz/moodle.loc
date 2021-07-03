<?php
$start = microtime(true);
set_include_path( get_include_path().PATH_SEPARATOR."..");
include_once("xlsxwriter.class.php");

$chars = "abcdefghijklmnopqrstuvwxyz0123456789 ";
$s = '';
for($j=0; $j<16192;$j++)
    $s.= $chars[rand()%36];


$writer = new XLSXWriter();
$writer->writeSheetHeader('Sheet1',
    array('c1'=>'string',
        'c2'=>'string',
        'c3'=>'string',
        'c4'=>'string',
        'c5'=>'string',
        'c6'=>'string',
        'c7'=>'string',
        'c8'=>'string',
        'c9'=>'string',
        'c10'=>'string',
        'c11'=>'string',
        'c12'=>'string',
        'c13'=>'string',
        'c14'=>'string',
        'c15'=>'string',
    ) );//optional
for($i=0; $i<40000; $i++)
{
    $s1 = substr($s, rand()%1000, rand()%5+5);
    $s2 = substr($s, rand()%2000, rand()%5+5);
    $s3 = substr($s, rand()%3000, rand()%5+5);
    $s4 = substr($s, rand()%4000, rand()%5+5);
    $s5 = substr($s, rand()%5000, rand()%5+5);
    $s6 = substr($s, rand()%6000, rand()%5+5);
    $s7 = substr($s, rand()%7000, rand()%5+5);
    $s8 = substr($s, rand()%8000, rand()%5+5);
    $s9 = substr($s, rand()%9000, rand()%5+5);
    $s10 = substr($s, rand()%10000, rand()%5+5);
    $s11 = substr($s, rand()%11000, rand()%5+5);
    $s12 = substr($s, rand()%12000, rand()%5+5);
    $s13 = substr($s, rand()%13000, rand()%5+5);
    $s14 = substr($s, rand()%14000, rand()%5+5);
    $s15 = substr($s, rand()%15000, rand()%5+5);
    $writer->writeSheetRow('Sheet1', array($s1, $s2, $s3, $s4,$s5,$s6,$s7,$s8,$s9,$s10,$s11,$s12,$s13.$s14,$s15) );
}
$writer->writeToFile('xlsx-strings-40k-15col.xlsx');
echo '#'.floor((memory_get_peak_usage())/1024/1024)."MB"."\n";
echo '<br>===============================================================';
echo 'Время выполнения скрипта: ' . (microtime(true) - $start) . ' sec.';

