<?php

require_once(__DIR__ . '/../../config.php');
defined('MOODLE_INTERNAL') || die;

$form_url = new \moodle_url('/local/helloworld/index.php');
$home_url = new \moodle_url('/');

$name = optional_param('name', '',PARAM_NOTAGS);
//$sesskey = optional_param('sesskey', '',PARAM_RAW);

$great = empty($name)?"Hello world!":"Hello, ".$name;

//echo html_writer::link($url, get_string('name'));

if (!empty($name)) {
    require_sesskey(); // Проверяем ключ сессии
    // Делайте все, что вам нужно, например $DB->delete_records (...) и т.д.
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1><?php echo $great ?></h1>
<p><a href="<?php echo $home_url ?>">Home</a></p>
<p><a href="<?php echo $form_url ?>">Hello World Main Page</a></p>
</body>
</html>




