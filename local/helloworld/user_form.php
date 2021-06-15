<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

require(__DIR__ . '/../../config.php');
// defined('MOODLE_INTERNAL') || die;

// включаем helloworld_form.php
require_once(__DIR__ . '/classes/helloworld_form.php');

// Создание экземпляра simplehtml_form
$mform = new helloworld_form();

// Обработка и отображение формы выполняется здесь
if ($mform->is_cancelled()) {
    // Обработка операции отмены формы, если в форме присутствует кнопка отмены
} elseif ($fromform = $mform->get_data()) {
    // В этом случае вы обрабатываете проверенные данные. $ mform-> get_data () возвращает данные, размещенные в форме.
} else {
    // Эта ветвь выполняется, если форма отправлена, но данные не проверяются и форма должна быть повторно отображена
    // Или при первом отображении формы.

    // Устанавливаем данные по умолчанию (если есть)
//    $mform->set_data($toform) ;
    // Отображает форму
    $mform->display();
}
