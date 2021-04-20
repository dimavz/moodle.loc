<?php
require_once(__DIR__ . '/../../config.php');
defined('MOODLE_INTERNAL') || die;

$url = new \moodle_url('/local/helloworld/hendler.php'); // Формируем ссылку для обработчика формы

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
<p>What is your name?</p>
<form action="<?php echo $url ?>">
    <input type="text" name="name" placeholder="Enter you name">
    <input type="submit" name="btn" value="Send">
    <input type="hidden" name="sesskey" value="<?php echo sesskey() // Передаём ключ сессии для безопасности скрипта ?>">
</form>
</body>
</html>