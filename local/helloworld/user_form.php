<?php

//require_once(__DIR__ . '/../../config.php');
//defined('MOODLE_INTERNAL') || die;

// включаем helloworld_form.php
require_once(__DIR__ . '/classes/helloworld_form.php');

// Создание экземпляра simplehtml_form
$mform = new helloworld_form();

// Обработка и отображение формы выполняется здесь
if ($mform->is_cancelled()) {
    // Обработка операции отмены формы, если в форме присутствует кнопка отмены
} else if ($fromform = $mform->get_data()) {
    // В этом случае вы обрабатываете проверенные данные. $ mform-> get_data () возвращает данные, размещенные в форме.
} else {
    // эта ветвь выполняется, если форма отправлена, но данные не проверяются и форма должна быть повторно отображена
    // или при первом отображении формы.

    // Устанавливаем данные по умолчанию (если есть)
//    $mform->set_data($toform) ;
    // отображает форму
    $mform->display();
}
