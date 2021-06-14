<?php
require(__DIR__ . '/../../config.php');
defined('MOODLE_INTERNAL') || die;

$url = new \moodle_url('/local/helloworld/hendler.php'); // Формируем ссылку для обработчика формы

//get_string('editingquiz', 'mod_quiz');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hello World</title>
</head>
<body>
<h1>Hello World</h1>
<p>What is your name?</p>
<form action="<?php echo $url ?>">
    <input type="text" name="name" placeholder="Enter you name">
    <input type="submit" name="btn" value="<?php echo get_string('submit') ?>">
    <input type="hidden" name="sesskey" value="<?php echo sesskey() // Передаём ключ сессии для безопасности скрипта ?>">
</form>
</body>
</html>