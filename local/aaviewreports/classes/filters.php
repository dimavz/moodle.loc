<?php


namespace local_aaviewreports;


class filters
{
    protected $service_url;
    protected $request_url;
    protected $url;
    protected $token;
    protected $filters;
    protected $data;

    public function __construct($data = array())
    {
        $this->service_url = get_config('local_aaviewreports', 'url');
        $this->request_url = '/aareport/webservice/restful/server.php/local_aareports_get_report_filter';
        if (!empty($this->service_url)) {
            $this->url = $this->service_url . $this->request_url;
        }
        $this->token = get_config('local_aaviewreports', 'token');
        $this->filters = $this->getFilters($data);
    }

    public function getFilters($data = array())
    {
        $this->data = $data;
        $filters = null;
        if (!empty($this->url) && !empty($this->token)) {
            $curl = curl_init();

            if (empty($this->data)) {
                $this->data = array('report' => 'general');
            } else {
//                $this->data = $this->reformatData($data);
                $this->data = array('report' => 'general', 'filters[0][name]' => 'company', 'filters[0][selected]' => '133, 125');
            }

            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $this->data,
                CURLOPT_HTTPHEADER => array(
//                    'Content-Type: x-www-form-urlencoded',
                    "Authorization: {$this->token}",
                    'Accept: application/json'
                ),
            ));

            $filters = curl_exec($curl);

            curl_close($curl);

            $filters = json_decode($filters);
        }
        return $filters;
    }

    public function renderHtml()
    {
        $html = '';
        if (!empty($this->filters) && isset($this->filters->filters)) {
            ob_start();
            ?>
            <div class="aaviewreport__wrap">
                <?php $filters = $this->filters->filters;
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
                    <label for="id_label_single<?php echo $count ?>">
                        <?php echo ucwords($filter->name) . ':' ?>
                        <select id="<?php echo $filter->name ?>" <?php echo $attrs ?>
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

    private function reformatData($olddata, $newdata = array())
    {
        if (is_array($olddata)) {
            foreach ($olddata as $key => $item) {
                if (is_array($item)) {
                    $str = "{$key}";
                    $str .= $this->reformatData($item, $newdata);
                    $newdata[] = $str;
                } else {
                    $newdata[] = "{$key} => {$item}";
                }
            }
        }
        return $newdata;
    }
}