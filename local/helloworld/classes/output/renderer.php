<?php

namespace local_helloworld\output;

defined('MOODLE_INTERNAL') || die;

use core_renderer;

class renderer extends core_renderer
{
    public function heading($text, $level = 2, $classes = null, $id = null)
    {
        $html ='Переопределён в helloworld/classes/output/render.php';
        $html .= parent::heading($text, $level, $classes, $id); // TODO: Change the autogenerated stub
        return $html;
    }

}