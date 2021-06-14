<?php
require(__DIR__ . '/../../config.php');
defined('MOODLE_INTERNAL') || die;

$now = time();
echo userdate($now);
echo '<br/>';
echo userdate(time(), get_string('strftimedaydate', 'core_langconfig'));
echo '<br/>';
$date = new DateTime("tomorrow", core_date::get_user_timezone_object());
$date->setTime(0, 0, 0);
echo userdate($date->getTimestamp(), get_string('strftimedatefullshort', 'core_langconfig'));
