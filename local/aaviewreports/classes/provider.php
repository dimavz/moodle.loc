<?php


namespace local_aaviewreports;


abstract class provider
{
    protected $service_url;
    protected $request_url = '/aareport/webservice/restful/server.php/local_aareports_get_report_filter';
    protected $url;
    protected $token;
    protected $data;
    protected $items;

    public function __construct($data = array())
    {
        $this->service_url = get_config('local_aaviewreports', 'url');
        if (!empty($this->service_url)) {
            $this->url = $this->service_url . $this->request_url;
        }
        $this->token = get_config('local_aaviewreports', 'token');
        $this->items = $this->getItems($data);
    }

    public function getItems($data = array())
    {
        $this->data = $data;
        $items = null;
        if (!empty($this->url) && !empty($this->token)) {
            $curl = curl_init();

            if (empty($this->data)) {
                $this->data = array('report' => 'general');
            } else {
                // $this->data = array('report' => 'general', 'filters[0][name]' => 'company', 'filters[0][selected]' => '133, 125');
                $this->data = $this->reformatData($data);
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
                    'Content-Type: multipart/form-data',
                    "Authorization: {$this->token}",
                    'Accept: application/json'
                ),
            ));

            $items = curl_exec($curl);

            curl_close($curl);

            $items = json_decode($items);
        }
        return $items;
    }

    public function renderItems()
    {
        $html = '';
        return $html;
    }

    private function reformatData($data)
    {
        $newdata = array();
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
                            foreach ($filter as $i => $z) {
                                $str_filter = '';
                                $str_filter .= $str_index;
                                if (is_array($z)) {
                                    $str_filter .= "[{$i}]=>";
                                    $count = 0;
                                    foreach ($z as $num) {
                                        if ($count) {
                                            $str_filter .= "," . $num;
                                        } else {
                                            $str_filter .= $num;
                                            $count++;
                                        }

                                    }
                                    $newdata[] = $str_filter;

                                } else {
                                    $str_filter .= "[{$i}]=>{$z}";
                                    $newdata[] = $str_filter;
                                }
                            }
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