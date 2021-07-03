<?php


namespace local_aaviewreports;


abstract class provider
{
    protected $service_url;
    protected $rest_url = '/webservice/restful/server.php/';
    protected $request_url = 'local_aareports_get_report_filter';
    protected $url;
    protected $token;
    protected $data;
    protected $items;
    protected $contentType = 'multipart/form-data';

    public function __construct($data = array())
    {
        $this->service_url = get_config('local_aaviewreports', 'url');
        if (!empty($this->service_url) && !empty($this->rest_url)) {
            $this->url = $this->service_url . $this->rest_url . $this->request_url;
        }
        $this->token = get_config('local_aaviewreports', 'token');
        $this->items = $this->getItems($data);
    }

    public function getItems($data = array())
    {
        $this->data = $data;
        $items = null;
        if (!empty($this->url) && !empty($this->token)) {

            if (empty($this->data)) {
                $this->data = array('report' => 'general');
            } else {
                // $this->data = array('report' => 'general', 'filters[0][name]' => 'company', 'filters[0][selected]' => '133, 125');
                $this->data = $this->reformatData($data);
            }

            $items = $this->getResponse($this->url,$this->token,$this->data);

        }
        return $items;
    }

    protected function setContentType($contentType){
        $this->contentType = $contentType;
    }

    private function getResponse($url,$token,$data){

        if($this->contentType == 'application/x-www-form-urlencoded' ){
            if(is_array($data)){
                $data = http_build_query($data);
                $data = str_replace('&amp;','&',$data);
            }
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: {$this->contentType}",
                "Authorization: {$token}",
                'Accept: application/json'
            ),
        ));

        $items = curl_exec($curl);

        curl_close($curl);

        $items = json_decode($items);

        return $items;
    }

    public function renderItems()
    {
        $html = '';
        return $html;
    }

    protected function reformatData($data)
    {
        $newdata = array();
        $data = (array) $data;
        if (is_array($data)) {
            foreach ($data as $key => $item) {
                if ($key == 'report') {
                    $newdata[] = "{$key}=>{$item}";
                    continue;
                }
                if (is_array($item) && $key == 'filters') {
                    $str = "";
                    $str = $key; // filters
                    foreach ($item as $k => $filter) {
                        $str_index = '';
                        $str_index .= $str . "[{$k}]";
                        if (is_array($filter)) {
                            foreach ($filter as $filter_key => $filter_value) {
                                $str_filter = '';
                                $str_filter .= $str_index;
                                if (is_array($filter_value)) {
                                    $str_filter .= "[{$filter_key}]=>";
                                    $count = 0;
                                    foreach ($filter_value as $num) {
                                        if ($count) {
                                            $str_filter .= "," . $num;
                                        } else {
                                            $str_filter .= $num;
                                            $count++;
                                        }

                                    }
                                    $newdata[] = $str_filter;

                                } else {
                                    $str_filter .= "[{$filter_key}]=>{$filter_value}";
                                    $newdata[] = $str_filter;
                                }
                            }
                        }
                    }
                }
                if(is_array($item)&& $key =='checkboxes' ){
                    $count_checboxes = 0;
                    foreach ($item as $cb_key => $checkbox) {
                        if(is_array($checkbox)){
                            foreach($checkbox as $cb_k=>$cb_val){
                                if ($cb_k == 'name') {
                                    $newdata[] = "additionalcolumns[{$count_checboxes}][name] =>{$cb_val}";
                                }
                                if ($cb_k == 'selected') {
                                    $newdata[] = "additionalcolumns[{$count_checboxes}][selected] =>1";
                                }
                            }
                        }
                        $count_checboxes++;
                    }
                }
                if (is_array($item) && $key == 'pagination') {
                    foreach ($item as $pkey => $pval) {
                        if ($pkey == 'page') {
                            $newdata[] = "pagination[currentPage]=>{$pval}";
                        }
                        if ($pkey == 'perpage') {
                            $newdata[] = "pagination[perPage]=>{$pval}";
                        }
                    }
                }
            }
        }
        $reformat = array();
        foreach ($newdata as $item) {
            $parts = explode('=>', $item);
            $reformat[$parts[0]] = $parts[1];
        }
        return $reformat;
    }
}