<?php


namespace local_aaviewreports;


class pagination
{
    protected $totalRecords; //Количество всех записей
    protected $totalPages; // Количество страниц
    protected $currentPage; // Текущая страница
    protected $perPage; // Записей на странице
    protected $maxPerPage; // Максимальное колич запией на странице

    public function __construct($params)
    {
        if (!empty($params)) {
            $this->totalRecords = $params->totalRecords;
            $this->totalPages = $params->totalPages;
            $this->currentPage = $params->currentPage;
            $this->perPage = $params->perPage;
            $this->maxPerPage = $params->maxPerPage;
        }

    }

    public function showPagination()
    {
        $html = '';
        $html .= $this->renderTotalRecords();
        $html .= $this->renderPagination();
        $html .= $this->renderBoxPerPages();
        return $html;
    }

    protected function renderTotalRecords($label = 'Total Records', $tag = "strong", $class = 'total-records')
    {
        $totalRecords = '';

        if (isset($this->totalRecords)) {
            $attrs = ['class' => $class];
            $totalRecords .= \html_writer::start_tag('div', $attrs);
            $totalRecords .= $label . ': <' . $tag . '>' . $this->totalRecords . '</' . $tag . '>';
            $totalRecords .= \html_writer::end_tag('div');
        }
        return $totalRecords;
    }

    protected function renderPagination($id = '', $class = 'pagination__aaviewreports', $class_item = 'page-item')
    {

        $page = $this->currentPage;
        $count_pages = $this->totalPages;
        $prev = null; // ссылка НАЗАД
        $next = null; // ссылка ВПЕРЕД
        $startpage = null; // ссылка В НАЧАЛО
        $endpage = null; // ссылка В КОНЕЦ
        $page2left = null; // вторая страница слева
        $page1left = null; // первая страница слева
        $page2right = null; // вторая страница справа
        $page1right = null; // первая страница справа

        $html = '';
        $attrs_conteiner = array();
        $attrs_conteiner['class'] = $class;
        if (!empty($id)) {
            $attrs_conteiner['id'] = $id;
        }

        $html .= \html_writer::start_tag('div', $attrs_conteiner);


        if ($page > 1) {
            $prev = "<div class='{$class_item}' data-page=" . ($page - 1) . ">Prev</div>";
        }
        if ($page < $count_pages) {
            $next = "<div class='{$class_item}' data-page=" . ($page + 1) . ">Next</div>";
        }
        if ($page > 3) {
            $startpage = "<div class='{$class_item}' data-page='1'>Start</div>";
        }
        if ($page < ($count_pages - 2)) { // End page
            $endpage = "<div class='{$class_item}' data-page='{$count_pages}'>$count_pages</div>";
        }
        if ($page - 2 > 0) {
            $page2left = "<div class='{$class_item}' data-page=" . ($page - 2) . ">" . ($page - 2) . "</div>";
        }
        if ($page - 1 > 0) {
            $page1left = "<div class='{$class_item}' data-page=" . ($page - 1) . ">" . ($page - 1) . "</div>";
        }
        if ($page + 1 <= $count_pages) {
            $page1right = "<div class='{$class_item}' data-page=" . ($page + 1) . ">" . ($page + 1) . "</div>";
        }
        if ($page + 2 <= $count_pages) {
            $page2right = "<div class='{$class_item}' data-page=" . ($page + 2) . ">" . ($page + 2) . "</div>";
        }

        $html .= $startpage . $prev . $page2left . $page1left . '<div class="' . $class_item . ' active" data-page="'. ($page) . '">' . $page . '</div>' . $page1right . $page2right . $next . $endpage;

        $html .= \html_writer::end_tag('div');

        return $html;
    }

    protected function renderBoxPerPages($id = '', $class = 'pagination__boxperpage', $selected = null)
    {
        $html = '';
        $attrs_container = array();
        if (!empty($id)) {
            $attrs_container['id'] = $id;
        }
        $attrs_container['class'] = $class;
        $html .= \html_writer::start_tag('div', $attrs_container);

        foreach ([25, 50, 100] as $perpagevalue) {

            if ($this->perPage == $perpagevalue) {
                $selected = $perpagevalue;
            }
            $options[$perpagevalue] = $perpagevalue;
        }

        $html .= \html_writer::label('Show', null);
        $html .= \html_writer::select($options, 'perpage', $selected, false, ['class' => 'chosen-select']);

        $html .= \html_writer::end_tag('div');
        return $html;
    }
}