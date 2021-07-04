<?php


namespace local_aaviewreports;

use local_aaviewreports\provider;


class filters extends provider
{
    protected $additionalColumns;

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->additionalColumns = $this->items->additionalcolumns;
    }

    public function renderItems()
    {
        $html = '';
        if (!empty($this->items) && isset($this->items->filters)) {
            ob_start();
            ?>
            <div class="aaviewreport__wrap">
                <?php $filters = $this->items->filters;
                $count = 0;
                foreach ($filters as $filter) {

                    $attr_multiple = $filter->multiple ? 'multiple="multiple"' : '';
                    $attr_name = $filter->multiple ? "name='{$filter->name}[]'" : "name='{$filter->name}'";
                    $attr_class = $filter->multiple ? 'class="filter-multiple js-states form-control"' : 'class="filter-single js-states form-control"';
                    $attrs = $attr_class . ' ' . $attr_multiple . ' ' . $attr_name;
                    $selected_options = array();
                    if (!empty($filter->selected)) {
                        $selected_options = explode(',', $filter->selected);
                    }
                    ?>
                    <label for="<?php echo $filter->name ?>">
                        <?php echo ucwords($filter->name) ?>
                        <select id="<?php echo $filter->name ?>" data-placeholder="<?php echo $filter->placeholder ?>" <?php echo $attrs ?>
                                id="id_label_single<?php echo $count ?>">
                            <?php foreach ($filter->options as $option): ?>
                                <?php $selected = '';
                                if (in_array($option->id, $selected_options)): ?>
                                    <?php $selected = 'selected' ?>
                                <?php endif; ?>
                                <option value="<?php echo $option->id ?>"<?php echo $selected ?>><?php echo $option->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <?php $count++;
                }
                ?>
            </div>
            <?php
            $html = ob_get_contents();
            ob_end_clean();
        }
        return $html;
    }

    public function renderAdditionalColumns($class_group = 'group-line')
    {

        $html = '';
        if (!empty($this->additionalColumns)) {
            $rows = $this->additionalColumns;
            foreach ($rows as $row) {
                $html .= \html_writer::start_tag('div', ['class' => $class_group]);
                $html .= \html_writer::tag('span', $row->title);
                if (!empty($row->columns)) {
                    $columns = $row->columns;
                    $html .= \html_writer::start_div('items');
                    foreach ($columns as $column) {
                        $checked = !empty($column->selected) ? true : false;
                        $html .= \html_writer::start_div('item-check');
                        $html .= \html_writer::checkbox($column->name, 1, $checked,$column->title,['id' => 'checkbox_'.$column->name]);
                        $html .= \html_writer::end_div();
                    }
                    $html .= \html_writer::end_div();
                }
                $html .= \html_writer::end_tag('div');
            }
//            echo '<pre>';
//            print_r($this->additionalColumns);
//            echo '</pre>';
//            exit();
        }
        return $html;
    }
}