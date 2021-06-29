<?php


namespace local_aaviewreports;
use local_aaviewreports\provider;


class trainee extends provider
{
    protected $request_url = '/aareport/webservice/restful/server.php/local_aareports_search_users';

    protected function reformatData($data){
        return array('report' => 'general','search'=>$data);
    }

    public function getTrainee(){
        return json_encode($this->items);
    }
}