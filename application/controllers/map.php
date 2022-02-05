<?php
if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class map extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('Item', 'Address', 'Company', 'Bank', 'Insurance', 'Log', 'Importer', 'Transport'));
    }

    public function company($id) {
        $this->data['query'] = $query = $this->Company->GetCompanyById($id);
        $this->data['title'] = $query['name_ar'];
        $this->load->view('map', $this->data);
    }
public function banks($id) {
        $this->data['query'] = $query = $this->Bank->GetBankById($id);
        $this->data['title'] = $query['name_ar'];
        $this->data['query']['x_decimal'] = $query['x_location'];
        $this->data['query']['y_decimal'] = $query['y_location'];
        $this->load->view('map', $this->data);
    }
    public function importers($id) {
        $this->data['query'] = $query = $this->Importer->GetImporterById($id);
        $this->data['title'] = $query['name_ar'];
        $this->data['query']['x_decimal'] = $query['x_location'];
        $this->data['query']['y_decimal'] = $query['y_location'];
        $this->load->view('map', $this->data);
    }

    public function insurance($id) {
        $this->data['query'] = $query = $this->Insurance->GetInsuranceById($id);
        $this->data['title'] = $query['name_ar'];
        $this->data['query']['x_decimal'] = $query['x_location'];
        $this->data['query']['y_decimal'] = $query['y_location'];
        $this->load->view('map', $this->data);
    }

    public function transport($id) {
        $this->data['query'] = $query = $this->Transport->GetTransportationById($id);
        $this->data['title'] = $query['name_ar'];
        $this->data['query']['x_decimal'] = $query['x_location'];
        $this->data['query']['y_decimal'] = $query['y_location'];
        $this->load->view('map', $this->data);
    }

    public function logs($type, $id) {
        $row = $this->Log->GetCompanyById($id);
        $this->data['query'] = $query = json_decode($row['details'], TRUE);
        $this->data['title'] = $query['name_ar'];
        $this->load->view('map', $this->data);
    }

}