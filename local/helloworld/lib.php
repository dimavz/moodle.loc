<?php

/**
 * Insert a link to index.php on the site front page navigation menu.
 *
 * @param navigation_node $frontpage Node representing the front page in the navigation tree.
 */

function local_helloworld_extend_navigation_frontpage(navigation_node $frontpage)
{
    $frontpage->add(
        get_string('pluginname', 'local_helloworld'),
        new moodle_url('/local/helloworld/index.php'),
        $frontpage::TYPE_CUSTOM,null,null,new pix_icon('t/feedback', '')
    );
}

function local_helloworld_extend_settings_navigation(settings_navigation $nav, context $context){
//    echo '<pre>';
//    print_r($nav);
//    echo '</pre>';
//    exit();
}

function local_helloworld_extend_navigation_user_settings(navigation_node $parentnode, stdClass $user, context_user $context, stdClass $course, context_course $coursecontext){
    $parentnode->add(get_string('pluginname', 'local_helloworld'),
        new moodle_url('/local/helloworld/index.php'),
        $parentnode::TYPE_CUSTOM,null,null,new pix_icon('t/feedback', ''));
}


/**
 * Add link to index.php into navigation drawer.
 *
 * @param global_navigation $root Node representing the global navigation tree.
 */
function local_helloworld_extend_navigation(global_navigation $root) {

    // Получаем настройку, которая создаётся в файле settings.php плагина и храниться в БД
    // Данная настройка доступна для редактирования через интерфейс администратора
    $showinnavigation = get_config('local_helloworld','showinnavigation');

    if($showinnavigation){
        $node = navigation_node::create(
            get_string('sayhello', 'local_helloworld'),
            new moodle_url('/local/helloworld/index.php'),
            navigation_node::TYPE_CUSTOM,
            null,
            null,
            new pix_icon('t/message', '')
        );
        $node->showinflatnavigation = true;

        $root->add_node($node);
    }

}