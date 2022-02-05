<?php

class Ajax extends Application
{
    public function __construct()
    {

        parent::__construct();
       // $this->ag_auth->restrict('companies'); // restrict this controller to admins only
        $this->load->model(array('Administrator', 'Item', 'Address', 'Company', 'Bank', 'Insurance', 'Parameter','Task'));
        $this->load->library(array('ajax_lib'));
       
    }
    public function saveItems()
    {
        
        $data=$this->input->post();
        $res=$this->ajax_lib->saveClientItems($data);
        echo $res;
    }
}
?>