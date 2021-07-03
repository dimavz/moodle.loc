<?php


namespace local_aaviewreports;

use local_aaviewreports\provider;
use local_aaviewreports\pagination;


class table extends provider
{
    protected $request_url = 'local_aareports_get_report_data';
    protected $response;
    protected $paginationParams;
    public $pagination;

    public function getItems($data = array())
    {
        $response = parent::getItems($data);
        if (!empty($response)) {
            $this->response = $response;
            $this->paginationParams = $response->pagination;
            $pagination = new pagination($this->paginationParams);
            $this->pagination = $pagination;

            return $response->table;
        }
        return $response;

    }

    public function renderItems()
    {
        $html = '';
        if (!empty($this->pagination)) {
            $html .= $this->pagination->showPagination();
        }
        $html .= parent::renderItems();

        $html .= $this->renderTable();
        return $html;
    }

    public function renderTable($tag_table = 'table', $tag_row = 'tr', $tag_cell_header = 'th', $tag_cell_body = 'td')
    {
        $html = '';
        if (!empty($this->items)) {
            $html .= \html_writer::start_tag($tag_table);
            $header = null;
            $body = null;
            if (!empty($this->items->header)) {
                $header = $this->items->header;
            }
            if (!empty($this->items->body)) {
                $body = $this->items->body;
            }

            if (!empty($header->rows)) {
                $rows = $header->rows;
                foreach ($rows as $k => $row) {
                    $html .= \html_writer::start_tag($tag_row);
                    if (!empty($row->cells)) {
                        $cells = $row->cells;
                        foreach ($cells as $i => $cell) {
                            $attrs = array();
                            if (!empty($cell->class)) {
                                $attrs['class'] = $cell->class;
                            }
                            if (!empty($cell->attributes)) {
                                $attributes = $cell->attributes;
                                foreach ($attributes as $attribute) {
                                    $attrs[$attribute->name] = $attribute->value;
                                }
                            }
                            $html .= \html_writer::start_tag($tag_cell_header, $attrs);
                            $html .= $cell->data;
                            $html .= \html_writer::end_tag($tag_cell_header);
                        }
                    }
                    $html .= \html_writer::end_tag($tag_row);
                }
            }

            if (!empty($body->rows)) {
                $rows = $body->rows;
                foreach ($rows as $k => $row) {
                    $html .= \html_writer::start_tag($tag_row);
                    if (!empty($row->cells)) {
                        $cells = $row->cells;
                        foreach ($cells as $cell) {
                            $attrs = array();
                            if (!empty($cell->class)) {
                                $attrs['class'] = $cell->class;
                            }
                            if (!empty($cell->attributes)) {
                                $attributes = $cell->attributes;
                                foreach ($attributes as $attribute) {
                                    $attrs[$attribute->name] = $attribute->value;
                                }
                            }
                            $html .= \html_writer::start_tag($tag_cell_body, $attrs);
                            $html .= $cell->data;
                            $html .= \html_writer::end_tag($tag_cell_body);
                        }
                    }
                    $html .= \html_writer::end_tag($tag_row);
                }
            }
            $html .= \html_writer::end_tag('table');
        }
        return $html;
    }

    public function renderRawTable()
    {
        ob_start();
        echo '<pre>';
        print_r($this->items);
        print_r($this->pagination);
        echo '</pre>';
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    public function getLastItems()
    {
        $items = null;
        if (!empty($this->items)) {
            $items = $this->items;
        }
        return $items;
    }

    public function downloadExelFile(){

       if(!class_exists('XLSXWriter')){

           include_once(__DIR__ . '/../libs/xlsx_writer/xlsxwriter.class.php');
       }
        $writer = new \XLSXWriter();

        if (!empty($this->items)) {
            $header = null;
            $body = null;
            if (!empty($this->items->header)) {
                $header = $this->items->header;
            }
            if (!empty($this->items->body)) {
                $body = $this->items->body;
            }

            if (!empty($header->rows)) {
                $rows = $header->rows;
                foreach ($rows as $k => $row) {
                    if (!empty($row->cells)) {
                        $cells = $row->cells;
                        $header_cells = array();
                        foreach ($cells as $i => $cell) {
                            array_push($header_cells,$cell->data);
                        }
                        $writer->writeSheetHeader('Sheet1', $header_cells);
                    }
                }
            }

            if (!empty($body->rows)) {
                $rows = $body->rows;
                foreach ($rows as $k => $row) {
                    if (!empty($row->cells)) {
                        $cells = $row->cells;
                        $body_cells =array();
                        foreach ($cells as $cell) {
                            array_push($body_cells,$cell->data);
                        }
                        $writer->writeSheetRow('Sheet1', $body_cells);
                    }
                }
            }

            $file = 'xlsx-colls.xlsx';
            $writer->writeToFile($file);
//            $writer->writeToStdOut();

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            // читаем файл и отправляем его пользователю
            readfile($file);
            exit;
        }
    }

}