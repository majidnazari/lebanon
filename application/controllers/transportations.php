<?php

class Transportations extends Application {
    var $tbl_transport = 'tbl_transport';
    var $tbl_services = 'tbl_transport_services';
    var $tbl_directors = 'tbl_insurance_directors';
    var $tbl_managers = 'tbl_insurance_managers';
    var $p_delete = FALSE;
    var $p_edit = FALSE;
    var $p_add = FALSE;
    var $p_view = FALSE;
    var $p_edit_branch = FALSE;
    var $p_add_branch = FALSE;
    var $p_delete_branch = FALSE;
    var $p_view_branch = FALSE;
    var $p_edit_port = FALSE;
    var $p_add_port = FALSE;
    var $p_delete_port = FALSE;
    var $p_view_port = FALSE;
    var $page_denied = '';

    public function __construct() {

        parent::__construct();
        $this->ag_auth->restrict('transportations'); // restrict this controller to admins only
        $this->load->model(array('Administrator', 'Item', 'Address', 'Transport', 'Company'));
        $this->data['Ctitle'] = 'Industry : Transportations ';

        $this->data['p_delete'] = $this->p_delete = $this->ag_auth->check_privilege(18, 'delete');
        $this->data['p_edit'] = $this->p_edit = $this->ag_auth->check_privilege(18, 'edit');
        $this->data['p_add'] = $this->p_add = $this->ag_auth->check_privilege(19, 'add');
        $this->data['p_view'] = $this->p_view = $this->ag_auth->check_privilege(18, 'view');

        $this->data['p_edit_branch'] = $this->p_edit_branch = $this->ag_auth->check_privilege(18, 'branch_edit');
        $this->data['p_add_branch'] = $this->p_add_branch = $this->ag_auth->check_privilege(18, 'branch_add');
        $this->data['p_delete_branch'] = $this->p_delete_branch = $this->ag_auth->check_privilege(18, 'branch_delete');
        $this->data['p_view_branch'] = $this->p_view_branch = $this->ag_auth->check_privilege(18, 'branch_view');

        $this->data['p_edit_port'] = $this->p_edit_port = $this->ag_auth->check_privilege(18, 'ports_edit');
        $this->data['p_add_port'] = $this->p_add_port = $this->ag_auth->check_privilege(18, 'ports_add');
        $this->data['p_delete_port'] = $this->p_delete_port = $this->ag_auth->check_privilege(18, 'ports_delete');
        $this->data['p_view_port'] = $this->p_view_port = $this->ag_auth->check_privilege(18, 'ports_view');
    }

    public function convertlocation() {
		die;
        $query = $this->Transport->GetTransportations('', 0, 0);
        foreach($query as $row) {
            $array = array(
                    'x_location' => $this->Administrator->Degree2Decimal($row->x_location),
                    'y_location' => $this->Administrator->Degree2Decimal($row->y_location),
                    'x_old' => $row->x_location,
                    'y_old' => $row->y_location,
            );
            $this->Administrator->edit('tbl_transport', $array, $row->id);
        }
    }

    public function remove($id) {
        $this->Administrator->edit('tbl_transport', array('adv_pic' => ''), $id);
        $this->session->set_userdata(array('admin_message' => 'Image Deleted'));
        redirect('transportations/details/'.$id);
    }

    public function editimage() {
        if(isset($_POST)) {
            $id = $this->input->post('editimageid');
            $array = $this->Administrator->do_upload('uploads/', 'adimage');

            if($array['target_path'] != "") {
                $path = $array['target_path'];
                $this->Administrator->edit('tbl_transport', array('adv_pic' => $path), $id);
            }
            $msg = $array['error'];
            $this->session->set_userdata(array('admin_message' => $msg));
            redirect('transportations/details/'.$id);
        }
    }

    public function editports() {
        $name_ar = $this->input->post('namear');
        $name_en = $this->input->post('nameen');
        $id = $this->input->post('id');
        $data = array('name_ar' => $name_ar, 'name_en' => $name_en, 'update_time' => date('Y-m-d H:i:s'));
        $this->Administrator->edit('tbl_transport_ports', $data, $id);
    }

    public function services() {

    }

    public function change_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $this->Administrator->edit($this->tbl_transport, array('online' => $status), $id);
        if($status == 1)
            echo '<a href="javascript:;" onclick="change_status('.$id.',0)"><span class="label label-success">Online</span></a>';
        else
            echo '<a href="javascript:;" onclick="change_status('.$id.',1)"><span class="label">Offline</span></a>';
    }

    public function GetDistricts() {
        echo '<script>
        $(document).ready(function() {
			$("#district_id").select2();
        });
    </script>';
        $jsdis = 'id="district_id" onchange="getarea(this.value)"';
        $gov_id = $_POST['id'];
        $districts = $this->Address->GetDistrictByGov('online', $gov_id);
        if(count($districts) > 0) {
            $array_districts[''] = 'All';
            foreach($districts as $district) {
                $array_districts[$district->id] = $district->label_ar.' ('.$district->label_en.')';
            }
        }
        else {
            $array_districts[''] = 'No Data Found';
        }
        echo form_dropdown('district_id', $array_districts, '', $jsdis);
    }

    public function GetArea() {
        echo '<script>
        $(document).ready(function() {
			$("#area_id").select2();
        });
    </script>';
        $dist_id = $_POST['id'];
        $areas = $this->Transport->GetAreaByDistrict('online', $dist_id);
        if(count($areas) > 0) {
            $array_area[''] = 'All';
            foreach($areas as $area) {
                $array_area[$area->id] = $area->label_ar.' - '.$area->label_en.' ('.$area->total.')';
            }
        }
        else {
            $array_area[''] = 'No Data Found';
        }
        echo form_dropdown('area_id', $array_area,'',' id="area_id"');
    }

    public function GetDataSection1() {
        $sector_id = $_POST['id'];
        $section_id = $_POST['section_id'];
        $sections = $this->Item->GetSectionsBySectorId('online', $sector_id);
        if(count($sections) > 0) {
            foreach($sections as $section) {
                $array_section[$section->id] = $section->label_ar;
            }
        }
        else {
            $array_section[''] = 'No Data Found';
        }
        echo form_dropdown('section', $array_section, $section_id);
    }

    private function erase($id) {
        $query = $this->Transport->GetTransportationById($id);
        $history = array('action' => 'delete', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $query['name_ar'], 'type' => 'transportation', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
        $hId = $this->General->save('logs', $history);

        $branches = $this->Transport->GetBranches($id);
        $history_branches = array('logs_id' => $hId, 'action' => 'delete', 'item_id' => $id, 'type' => 'transportation_branches', 'details' => json_encode($branches), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
        $this->General->save('logs', $history_branches);

        $line_represented = $this->Transport->GetTransportLineRepresented($id);
        $line_represented_history = array('logs_id' => $hId, 'action' => 'delete', 'item_id' => $id, 'type' => 'transportation_line_represented', 'details' => json_encode($line_represented), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
        $this->General->save('logs', $line_represented_history);

        $ports = $this->Transport->GetTransportPorts($id);
        $ports_history = array('logs_id' => $hId, 'action' => 'delete', 'item_id' => $id, 'type' => 'transportation_ports', 'details' => json_encode($ports), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
        $this->General->save('logs', $ports_history);

        $this->General->delete('tbl_transport_branches', array('transport_id' => $id));
        $this->General->delete('tbl_transport_line_represented', array('transport_id' => $id));
        $this->General->delete('tbl_transport_ports', array('transport_id' => $id));
        $this->General->delete('tbl_transport', array('id' => $id));
    }

    public function delete() {
        $get = $this->uri->ruri_to_assoc();
        if((int)$get['id'] > 0) {
            switch($get['p']) {
                case 'transportation':
                    $this->erase($get['id']);
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('transportations/'.$get['st']);
                    break;

                case 'ports':
                    $this->General->delete('tbl_transport_ports', array('id' => $get['id']));
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('transportations/ports/'.$get['transportation']);
                    break;

                case 'banks':
                    $this->General->delete($this->company_banks, array('id' => $get['id']));
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('companies/banks/'.$get['cid']);
                    break;
                case 'insurance':
                    $this->General->delete($this->company_insurance, array('id' => $get['id']));
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('companies/insurances/'.$get['cid']);
                    break;

                case 'exports':
                    $this->General->delete($this->company_markets, array('id' => $get['id']));
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('companies/exports/'.$get['cid']);
                    break;

                case 'power':
                    $this->General->delete($this->company_power, array('id' => $get['id']));
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('companies/power/'.$get['cid']);
                    break;
            }
        }
    }

    public function delete_checked() {
        $delete_array = $this->input->post('checkbox1');
        //var_dump()
        if(empty($delete_array)) {
            $this->session->set_userdata(array('admin_message' => 'No Item Checked'));

            //if(isset($this->input->post('p')))
            //redirect($_SEREVER['']);
            // No items checked
        }
        else {
            //if(isset($this->input->post('p')))
            switch($this->input->post('p')) {
                case 'transportation':
                    foreach($delete_array as $d_id) {
                        $this->General->delete($this->tbl_transport, array('id' => $d_id));
                    }
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('transportations/'.$get['st']);

                    break;

                case 'sector':
                    foreach($delete_array as $d_id) {
                        $this->General->delete($this->sector, array('id' => $d_id));
                    }
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('parameters/items/sector/'.$get['st']);
                    break;

                case 'section':
                    foreach($delete_array as $d_id) {
                        $this->General->delete($this->section, array('id' => $d_id));
                    }
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('parameters/items/section/'.$get['st']);
                    break;
                case 'chapter':
                    foreach($delete_array as $d_id) {
                        $this->General->delete($this->chapter, array('id' => $d_id));
                    }
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('parameters/items/chapter/'.$get['st']);
                    break;

                case 'position':
                    foreach($delete_array as $d_id) {
                        $this->General->delete($this->position, array('id' => $d_id));
                    }
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('parameters/items/position/'.$get['st']);

                    break;
            }
        }
    }
    public function printed_search()
    {
        $id=$this->input->get('id');
        $name=$this->input->get('name');
        $phone=$this->input->get('phone');
        $gov=$this->input->get('gov');
        $district_id=$this->input->get('district_id');
        $area_id=$this->input->get('area_id');
        $status=$this->input->get('status');
        $query = $this->Transport->SearchTransportations($id, $name, $phone, $status, $gov, $district_id,$area_id, 0, 0);
        foreach($query as $row) {
            $this->view($row->id);

        }
    }
    public function index($row = 0) {
        $this->data['search'] = TRUE;
        if($this->p_view) {
            if(isset($_GET['search'])) {
                $limit = 20;
                $row = $this->input->get('per_page');
                $govID = $this->input->get('gov');
                $districtID = $this->input->get('district_id');
                $areaID = $this->input->get('area_id');
                $status = $this->input->get('status');
                $id = $this->input->get('id');
                $name = $this->input->get('name');
                $phone = $this->input->get('phone');

                $query = $this->Transport->SearchTransportations($id, $name, $phone, $status, $govID, $districtID,$areaID, $row, $limit);
                //var_dump($query);
                $total_row = count($this->Transport->SearchTransportations($id, $name, $phone, $status, $govID, $districtID,$areaID, 0, 0));
                $config['base_url'] = base_url().'transportations?gov='.$govID.'&district_id='.$districtID.'&area_id='.$areaID.'&status='.$status.'&search=Search';

                $config['enable_query_strings'] = TRUE;
                $config['page_query_string'] = TRUE;
            }
            elseif(isset($_GET['clear'])) {
                redirect('transportations/');
            }
            else {
                $limit = 20;
                $govID = 0;
                $districtID = 0;
                $status = '';
                $config['base_url'] = base_url().'transportations/index';
                //$config['uri_segment'] = 12;
                $query = $this->Transport->GetTransportations('', $row, $limit);

                $total_row = count($this->Transport->GetTransportations('', 0, 0));

                $this->pagination->initialize($config);
            }

            $this->data['govID'] = $govID;
            $this->data['districtID'] = $districtID;
            $this->data['areaID'] = @$areaID;
            $this->data['status'] = $status;
            $this->data['id'] = @$id;
            $this->data['name'] = @$name;
            $this->data['phone'] = @$phone;

            $config['total_rows'] = $total_row;
            $config['per_page'] = $limit;

            $config['num_links'] = 6;


            $this->pagination->initialize($config);
            $this->data['query'] = $query;
            $this->data['total_row'] = $total_row;

            $this->data['links'] = $this->pagination->create_links();
            $this->data['st'] = $this->uri->segment(4);
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Transportation');
            $this->data['title'] = $this->data['Ctitle']." - Transportation - الشحن والنقل";
            $this->data['subtitle'] = "Transportation - الشحن والنقل";
            $this->data['districts'] = $this->Address->GetDistrictByGov('online', $this->data['govID']);
            $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
            $this->data['areas'] = $this->Transport->GetAreaByDistrict('online', @$districtID);
            $this->template->load('_template', 'transportation/index', $this->data);
        }
    }
    public function listview() {
        if($this->p_view) {
            $gov = $this->input->get('gov');
            $district_id = $this->input->get('district_id');
            $area_id = $this->input->get('area_id');
            $status = $this->input->get('status');
            $id = $this->input->get('id');
            $name = $this->input->get('name');
            $phone = $this->input->get('phone');
            $this->data['query'] = $this->Transport->SearchTransportations($id, $name, $phone, $status, $gov, $district_id,$area_id, 0, 0);
            $this->data['title'] = $this->data['Ctitle']." - Companies - الشركات";
            $this->data['subtitle'] = "Companies - الشركات";
            $this->load->view('transportation/listview', $this->data);
        }
    }
    public function reservations($row = 0) {
        $limit = 20;
        $this->data['search'] = FALSE;
        if($this->p_view) {
            $config['base_url'] = base_url().'transportations/reservations';
            $query = $this->Transport->GetTransportsS(1, '', $row, $limit);
            $total_row = count($this->Transport->GetTransportsS(1, '', 0, 0));
            $this->pagination->initialize($config);
            $config['total_rows'] = $total_row;
            $config['per_page'] = $limit;
            $config['num_links'] = 6;
            $this->pagination->initialize($config);
            $this->data['query'] = $query;
            $this->data['total_row'] = $total_row;
            $this->data['links'] = $this->pagination->create_links();
            $this->data['st'] = $this->uri->segment(4);
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Transportation');
            $this->data['title'] = $this->data['Ctitle']." - Transportation - الشحن والنقل";
            $this->data['subtitle'] = "شركات النقل الحاجزة نسخة";
            $this->template->load('_template', 'transportation/index', $this->data);
        }
    }

    public function advertising($row = 0) {
        $limit = 20;
        $this->data['search'] = FALSE;
        if($this->p_view) {
            $config['base_url'] = base_url().'transportations/advertising';
            $query = $this->Transport->GetTransportsS('', 1, $row, $limit);
            $total_row = count($this->Transport->GetTransportsS('', 1, 0, 0));
            $this->pagination->initialize($config);
            $config['total_rows'] = $total_row;
            $config['per_page'] = $limit;
            $config['num_links'] = 6;
            $this->pagination->initialize($config);
            $this->data['query'] = $query;
            $this->data['total_row'] = $total_row;
            $this->data['links'] = $this->pagination->create_links();
            $this->data['st'] = $this->uri->segment(4);
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Transportation');
            $this->data['title'] = $this->data['Ctitle']." - Transportation - الشحن والنقل";
            $this->data['subtitle'] = "شركات النقل   المعلنة";
            $this->template->load('_template', 'transportation/index', $this->data);
        }
    }

    public function search($row = 0) {
        /* 	$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'delete');
          $p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'edit');
          $p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,16,'add');
         */


        if(isset($_GET['search'])) {
            $limit = 100;
            $row = $this->input->get('per_page');
            $id = $this->input->get('id');
            $name = $this->input->get('name');
            $activity = $this->input->get('activity');
            $phone = $this->input->get('phone');
            //$this->data['govID']=$this->input->get('status');
            //	$this->data['description']=$this->input->get('description');
            //	$config['base_url']=base_url().'parameters/items/subhead?code=03.03&description=&status=online&search=search';
            $query = $this->Company->AdvancedSearchCompanies($id, $name, $activity, $phone, $row, $limit);
            $total_row = count($this->Company->AdvancedSearchCompanies($id, $name, $activity, $phone, 0, 0));
            $config['base_url'] = base_url().'impoters?id='.$id.'&name='.$name.'&activity='.$activity.'&phone='.$phone.'&search=Search';
            //	$trows=$this->Item->GetSubHeading('',$row,0);
            //$config['total_rows']=count($this->data['query']);
            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
        }
        elseif(isset($_GET['clear'])) {
            redirect('companies/');
        }
        else {
            $limit = 20;
            $id = '';
            $name = '';
            $activity = '';
            $phone = '';
            $config['base_url'] = base_url().'companies/index';
            //$config['uri_segment'] = 12;
            $query = array();

            $total_row = 0;

            $this->pagination->initialize($config);
        }

        $this->data['id'] = $id;
        $this->data['name'] = $name;
        $this->data['activity'] = $activity;
        $this->data['phone'] = $phone;



        $config['total_rows'] = $total_row;
        $config['per_page'] = $limit;

        $config['num_links'] = 6;


        $this->pagination->initialize($config);
        $this->data['query'] = $query;
        $this->data['total_row'] = $total_row;

        $this->data['links'] = $this->pagination->create_links();
        $this->data['st'] = $this->uri->segment(4);
        $this->data['p_delete'] = TRUE;
        $this->data['p_edit'] = TRUE;
        $this->data['p_add'] = TRUE;
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Companies');
        $this->data['title'] = $this->data['Ctitle']." - Companies - الشركات";
        ;
        $this->data['subtitle'] = "Companies - الشركات";
        //$this->data['sectors']=$this->Item->GetSector('online',0,0);
        //$this->data['sections']=$this->Item->GetSection('online',0,0);
        //$this->data['districts']=$this->Address->GetDistrictByGov('online',$this->data['govID']);
        //$this->data['governorates']=$this->Address->GetGovernorate('online',0,0);
        $this->template->load('_template', 'company/companies_search', $this->data);
    }


    public function export($id)
    {

        $filename = "transport-" . $id . ".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');


        $query = $this->Transport->GetTransportationById($id);
        $ids = explode(',', $query['services']);
        $this->data['query'] = $query;
        $this->data['governorates'] = $this->Address->GetGovernorateById($query['governorate_id']);
        $this->data['districts'] = $this->Address->GetDistrictById($query['district_id']);
        $this->data['area'] = $this->Address->GetAreaById($query['area_id']);
        $this->data['services'] = $this->Transport->GetServicesByIds($ids);

        $this->data['salesman'] = $this->General->GetSalesManById($query['sales_man_id']);
        $this->data['position'] = $this->Item->GetPositionById($query['position_id']);
        $this->data['ports'] = $this->Transport->GetTransportPorts($id);
        $this->data['represented'] = $this->Transport->GetTransportLineRepresented($id);
        $this->data['id'] = $id;
        $this->data['license'] = $this->Company->GetLicenseSourceById($query['license_source_id']);
        if($query['services'] != '') {
            $array_services = explode(',', $query['services']);
        }
        else {
            $array_services = array();
        }
        $this->data['activities'] = $this->Transport->GetTransportServices('online');
        $this->data['activities_data'] = $array_services;


        $this->load->view('transportation/application_view', $this->data);

    }
    public function details($id) {
        if($this->p_view) {
            $query = $this->Transport->GetTransportationById($id);
            $ids = explode(',', $query['services']);
            $this->data['query'] = $query;

            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Transportation');
            $this->data['title'] = $this->data['Ctitle']." - Transportation - قطاع الشحن والنقل";
            $this->data['subtitle'] = "Transportation -  قطاع الشحن والنقل";
            $this->data['governorates'] = $this->Address->GetGovernorateById($query['governorate_id']);
            $this->data['districts'] = $this->Address->GetDistrictById($query['district_id']);
            $this->data['area'] = $this->Address->GetAreaById($query['area_id']);
            $this->data['services'] = $this->Transport->GetServicesByIds($ids);
            $this->data['salesman'] = $this->Company->GetSalesMan($query['sales_man_id']);
            $this->data['ports'] = $this->Transport->GetTransportPorts($id);
            $this->data['represented'] = $this->Transport->GetTransportLineRepresented($id);
            $this->data['id'] = $id;
            $this->data['license'] = $this->Company->GetLicenseSourceById($query['license_source_id']);
            if($query['services'] != '') {
                $array_services = explode(',', $query['services']);
            }
            else {
                $array_services = array();
            }
            $this->data['activities'] = $this->Transport->GetTransportServices('online');
            $this->data['activities_data'] = $array_services;
            $this->data['position'] = $this->Item->GetPositionById($query['position_id']);

            $this->template->load('_template', 'transportation/details', $this->data);
        }
        else {
            redirect($this->page_denied);
        }
    }

    public function view($id) {
        if($this->p_view) {
            $query = $this->Transport->GetTransportationById($id);
            $ids = explode(',', $query['services']);
            $this->data['query'] = $query;

            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['title'] = $query['name_en']." - ".$query['name_ar'];

            $this->data['subtitle'] = "Transportation -  قطاع الشحن والنقل";

            $this->data['governorates'] = $this->Address->GetGovernorateById($query['governorate_id']);
            $this->data['districts'] = $this->Address->GetDistrictById($query['district_id']);
            $this->data['area'] = $this->Address->GetAreaById($query['area_id']);
            $this->data['services'] = $this->Transport->GetTransportServices();

            $this->data['salesman'] = $this->General->GetSalesManById($query['sales_man_id']);
            $this->data['ports'] = $this->Transport->GetTransportPorts($id);
            $this->data['represented'] = $this->Transport->GetTransportLineRepresented($id);
            $this->data['position'] = $this->Item->GetPositionById($query['position_id']);
            $this->data['license'] = $this->Company->GetLicenseSourceById($query['license_source_id']);

            $this->load->view('transportation/view', $this->data);
        }
        else {
            redirect($this->page_denied);
        }
    }

    public function printall() {
        $ids = $this->input->post('checkbox1');

        foreach($ids as $id) {
            $this->view($id);
        }
    }

    public function branch_create($id, $item_id = '') {


        $query = $this->Transport->GetTransportationById($id);
        $this->data['branches'] = $this->Transport->GetBranches($id);
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Transportations', 'transportations');
        $this->breadcrumb->add_crumb($query['name_en'], 'transportations/details/'.$id);
        $this->breadcrumb->add_crumb('الشركات الاجنبية التي تمثلها في لبنان', 'transportations/branches/'.$id);
        $this->breadcrumb->add_crumb('Create New');

        $this->form_validation->set_rules('name_en', 'name_en', 'required');
        $this->form_validation->set_rules('name_ar', 'name_ar', 'required');
        $this->form_validation->set_rules('phone', 'phone', 'trim');
        $this->form_validation->set_rules('country_id', 'country_id', 'trim');
        $this->form_validation->set_rules('email', 'email', 'trim');
        $this->form_validation->set_rules('website', 'website', 'trim');

        if($this->form_validation->run()) {

            $data = array(
                    'name_ar' => $this->form_validation->set_value('name_ar'),
                    'name_en' => $this->form_validation->set_value('name_en'),
                    'phone' => $this->form_validation->set_value('phone'),
                    'country_id' => $this->form_validation->set_value('country_id'),
                    'email' => $this->form_validation->set_value('email'),
                    'website' => $this->form_validation->set_value('website'),
                    'transport_id' => $id,
                    'create_time' => date('Y-m-d H:i:s'),
                    'update_time' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('id'),
            );

            if($bid = $this->General->save('tbl_transport_branches', $data)) {
                $data['id'] = $bid;
                $history = array('action' => 'add', 'logs_id' => 0, 'item_id' => $bid, 'item_title' => $query['name_ar'], 'type' => 'transportation_branches', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);
                $this->session->set_userdata(array('admin_message' => 'Transport branch Added successfully'));
                redirect('transportations/branches/'.$id);
            }
            else {
                $this->session->set_userdata(array('admin_message' => 'Error'));
                redirect('transportations/create-branch/'.$id);
            }
        }


        $this->data['id'] = $id;
        $this->data['query'] = $query;
        $this->data['row'] = array();

        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->data['countries'] = $this->Address->GetCountries('online', 0, 0);
        $this->data['subtitle'] = 'Add New ';
        $this->data['title'] = $this->data['Ctitle']." - Companies - الشركات";
        $this->template->load('_template', 'transportation/branch_form', $this->data);
    }

    public function branches($id, $item_id = '') {
        if($this->p_view_branch) {
            $query = $this->Transport->GetTransportationById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Transportations Companies', 'transportations');
            $this->breadcrumb->add_crumb($query['name_en'], 'transportations/details/'.$id);
            $this->breadcrumb->add_crumb('الشركات الاجنبية التي تمثلها في لبنان', 'transportations/branches/'.$id);

            $this->data['query'] = $query;


            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['branches'] = $this->Transport->GetBranches($id);
            $this->data['title'] = $this->data['Ctitle']." - Companies - الشركات الاجنبية التي تمثلها في لبنان";
            $this->data['id'] = $id;
            $this->template->load('_template', 'transportation/branches', $this->data);
        }
        else {
            redirect($this->page_denied);
        }
    }

    public function branch_edit($id, $item) {


        $query = $this->Transport->GetTransportationById($id);
        $this->data['branches'] = $branches = $this->Transport->GetBranches($id);
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Transportations', 'transportations');
        $this->breadcrumb->add_crumb($query['name_en'], 'transportations/details/'.$id);
        $this->breadcrumb->add_crumb('الشركات الاجنبية التي تمثلها في لبنان', 'transportations/branches/'.$id);
        $this->breadcrumb->add_crumb('Edit');

        $this->form_validation->set_rules('name_en', 'name_en', 'required');
        $this->form_validation->set_rules('name_ar', 'name_ar', 'required');
        $this->form_validation->set_rules('phone', 'phone', 'trim');
        $this->form_validation->set_rules('country_id', 'country_id', 'trim');
        $this->form_validation->set_rules('email', 'email', 'trim');
        $this->form_validation->set_rules('website', 'website', 'trim');

        if($this->form_validation->run()) {

            $data = array(
                    'name_ar' => $this->form_validation->set_value('name_ar'),
                    'name_en' => $this->form_validation->set_value('name_en'),
                    'phone' => $this->form_validation->set_value('phone'),
                    'country_id' => $this->form_validation->set_value('country_id'),
                    'email' => $this->form_validation->set_value('email'),
                    'website' => $this->form_validation->set_value('website'),
                    'transport_id' => $id,
                    'update_time' => date('Y-m-d H:i:s'),
            );

            if($this->Administrator->edit('tbl_transport_branches', $data, $item)) {
                $data['id'] = $item;
                $newdata = $this->Administrator->affected_fields($branches, $data);
                $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $item, 'item_title' => $query['name_ar'], 'type' => 'transportation_branches', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);
                $this->session->set_userdata(array('admin_message' => 'Transport branch Updated successfully'));
                redirect('transportations/branches/'.$id);
            }
            else {
                $this->session->set_userdata(array('admin_message' => 'Error'));
                redirect('transportations/branch-edit/'.$id.'/'.$item);
            }
        }


        $this->data['id'] = $id;
        $this->data['query'] = $query;
        $row = $this->Transport->GetBranchById($item);
        $this->data['row'] = $row;

        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->data['countries'] = $this->Address->GetCountries('online', 0, 0);
        //$area=$this->Address->GetAreaById($row['area_id']);
        //var_dump($area);
        //$this->data['governorates']=$this->Address->GetGovernorate('online',0,0);
        //$this->data['districts']=$this->Address->GetDistrictByGov('online',@$area['governorate_id']);
        //$this->data['areas']=$this->Address->GetAreaByDistrict('online',@$area['district_id']);


        $this->data['subtitle'] = 'Update ';
        $this->data['title'] = $this->data['Ctitle']." - Companies - الشركات";
        $this->template->load('_template', 'transportation/branch_form', $this->data);
    }

    public function create() {
        $this->data['nave'] = FALSE;
        //$this->data['p_edit']=TRUE;
        //$this->data['p_add']=TRUE;
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Transportation', 'transportations');
        $this->breadcrumb->add_crumb('Add New Transportation');

        $this->form_validation->set_rules('name_ar', 'company name in arabic', 'required');

        if($this->form_validation->run()) {
            /*
              $array=$this->Administrator->do_upload('uploads/');

              if($array['target_path']!=""){
              $path=$array['target_path'];
              }
              else{
              $path='';
              }
             */
            $activities_array = $this->input->post('activities');
            if(is_array($activities_array) and count($activities_array)>0)
            {
              $activities = implode(',', $activities_array);
   
            }
            else{
                 $activities = '';

            }
           
            //$msg=$array['error'];
            $status = $this->input->post('status');
            if($status == '') {
                $status = 0;
            }
            /*
              $x1 = $this->input->post('x1');
              $x2 = $this->input->post('x2');
              $x3 = $this->input->post('x3');
              $x = $x1.'°'.$x2."'".$x3.'"';

              $y1 = $this->input->post('y1');
              $y2 = $this->input->post('y2');
              $y3 = $this->input->post('y3');
              $y = $y1.'°'.$y2."'".$y3.'"';

             */

            $data = array(
                    'name_en' => $this->input->post('name_en'),
                    'name_ar' => $this->input->post('name_ar'),
                    'owner_ar' => $this->input->post('owner_ar'),
                    'owner_en' => $this->input->post('owner_en'),
                    'area_id' => $this->input->post('area_id'),
                    'street_en' => $this->input->post('street_en'),
                    'street_ar' => $this->input->post('street_ar'),
                    'bldg_en' => $this->input->post('bldg_en'),
                    'bldg_ar' => $this->input->post('bldg_ar'),
                    'phone' => $this->input->post('phone'),
                    'fax' => $this->input->post('fax'),
                    'pobox_ar' => $this->input->post('pobox_ar'),
                    'pobox_en' => $this->input->post('pobox_en'),
                    'email' => $this->input->post('email'),
                    'website' => $this->input->post('website'),
                    'est_date' => $this->input->post('est_date'),
                    'governorate_id' => $this->input->post('governorate_id'),
                    'district_id' => $this->input->post('district_id'),
                    'x_location' => $this->input->post('x_location'),
                    'y_location' => $this->input->post('y_location'),
                    //'x_decimal' => $this->input->post('x_decimal'),
                    //'y_decimal' => $this->input->post('y_decimal'),
                    'sales_man_id' => $this->input->post('sales_man_id'),
                    'cr_ar' => $this->input->post('cr_ar'),
                    'cr_en' => $this->input->post('cr_en'),
                    'member_local' => $this->input->post('member_local'),
                    'member_overseas' => $this->input->post('member_overseas'),
                    'maritime' => $this->input->post('maritime'),
                    'airline' => $this->input->post('airline'),
                    'service_landline' => $this->input->post('service_landline'),
                    'service_maritime' => $this->input->post('service_maritime'),
                    'service_airline' => $this->input->post('service_airline'),
                    'copy_reservation' => $this->input->post('copy_res'),
                    'is_adv' => $this->input->post('is_adv'),
                    'adv_pic' => $this->input->post('adv_pic'),
                    'services' => $activities,
                    'app_refill_date' => valid_date($this->input->post('app_refill_date')),
                    'res_person_ar' => $this->input->post('res_person_ar'),
                    'res_person_en' => $this->input->post('res_person_en'),
                    'position_id' => $this->input->post('position_id'),
                    'trade_license' => $this->input->post('trade_license'),
                    'license_source_id' => $this->input->post('license_source_id'),
                    'ref' => $this->input->post('ref'),
                    'personal_notes' => $this->input->post('personal_notes'),
                    'address2_ar' => $this->input->post('address2_ar'),
                    'address2_en' => $this->input->post('address2_en'),
                    'create_time' => date('Y-m-d H:i:s'),
                    'update_time' => date('Y-m-d H:i:s'),
                    'online' => $status,
                    'user_id' => $this->session->userdata('id'),
            );

            if($id = $this->General->save($this->tbl_transport, $data)) {
                $history = array('action' => 'add', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $data['name_ar'], 'type' => 'transportation', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);
                $this->session->set_userdata(array('admin_message' => 'Importer Added successfully'));
                redirect('transportations/details/'.$id);
            }
            else {
                $this->session->set_userdata(array('admin_message' => 'Error'));
                redirect('transportations/create');
            }
        }
        /*         * ********************General Info*********************** */
        $this->data['c_id'] = '';
        $this->data['name_ar'] = '';
        $this->data['name_en'] = '';
        $this->data['owner_ar'] = '';
        $this->data['owner_en'] = '';
        $this->data['cr_ar'] = '';
        $this->data['cr_en'] = '';
        $this->data['est_date'] = '';
        $this->data['activities_data'] = array();

        $this->data['personal_notes'] = '';

        /*         * ********************Address*********************** */
        $this->data['governorate_id'] = 0;
        $this->data['district_id'] = 0;
        $this->data['area_id'] = 0;
        $this->data['street_ar'] = '';
        $this->data['street_en'] = '';
        $this->data['bldg_ar'] = '';
        $this->data['bldg_en'] = '';
        $this->data['fax'] = '';
        $this->data['phone'] = '';
        $this->data['pobox_ar'] = '';
        $this->data['pobox_en'] = '';
        $this->data['email'] = '';
        $this->data['website'] = '';
        $this->data['x_location'] = '';
        $this->data['y_location'] = '';
        /*         * ***********************End Address***************** */
        $this->data['service_landline'] = 0;
        $this->data['service_maritime'] = 0;
        $this->data['service_airline'] = 0;
        $this->data['maritime'] = '';
        $this->data['airline'] = '';
        $this->data['member_local'] = 0;
        $this->data['member_overseas'] = 0;
        $this->data['member_local_ar'] = '';
        $this->data['member_local_en'] = '';
        $this->data['member_overseas_ar'] = '';
        $this->data['member_overseas_en	'] = '';
        /*         * ***********************Molhak***************** */
        $this->data['res_person_ar'] = '';
        $this->data['res_person_en'] = '';
        $this->data['sales_man_id'] = 0;
        $this->data['status'] = 1;
        $this->data['is_adv'] = 0;
        $this->data['adv_pic'] = '';
        $this->data['copy_res'] = 0;
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['districts'] = array();
        $this->data['areas'] = array();

        $this->data['activities'] = $this->Transport->GetTransportServices('online');

        $this->data['sales'] = $this->Company->GetSalesMen();
        $this->data['positions'] = $this->Company->GetPositions();
        $this->data['license_sources'] = $this->Company->GetLicenseSources();

        $this->data['subtitle'] = 'Add New Transportation';
        $this->data['title'] = $this->data['Ctitle']."- Add New Transportation";
        $this->template->load('_template', 'transportation/_form', $this->data);
    }

    public function edit($id) {
        if($this->p_edit) {
            $row = $this->Transport->GetTransportationById($id);
            $this->data['nave'] = TRUE;
            //$this->data['p_edit']=TRUE;
            //$this->data['p_add']=TRUE;
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Transportation', 'transportations');
            $this->breadcrumb->add_crumb($row['name_ar'], 'transportations/details/'.$id);
            $this->breadcrumb->add_crumb('Edit Transportation');

            $this->form_validation->set_rules('name_ar', 'company name in arabic', 'required');

            if($this->form_validation->run()) {
                /*
                  $array=$this->Administrator->do_upload('uploads/');

                  if($array['target_path']!=""){
                  $path=$array['target_path'];
                  }
                  else{
                  $path=$this->input->post('adv_pic');
                  }
                 */
                $activities_array = $this->input->post('activities');
                $activities = implode(',', $activities_array);

                //$msg=$array['error'];
                $status = $this->input->post('status');
                if($status == '') {
                    $status = 0;
                }
                /*
                  $x1 = $this->input->post('x1');
                  $x2 = $this->input->post('x2');
                  $x3 = $this->input->post('x3');
                  $x = $x1.'°'.$x2."'".$x3.'"';

                  $y1 = $this->input->post('y1');
                  $y2 = $this->input->post('y2');
                  $y3 = $this->input->post('y3');
                  $y = $y1.'°'.$y2."'".$y3.'"';

                 */
                $data = array(
                        'name_en' => $this->input->post('name_en'),
                        'name_ar' => $this->input->post('name_ar'),
                        'owner_ar' => $this->input->post('owner_ar'),
                        'owner_en' => $this->input->post('owner_en'),
                        'area_id' => $this->input->post('area_id'),
                        'street_en' => $this->input->post('street_en'),
                        'street_ar' => $this->input->post('street_ar'),
                        'bldg_en' => $this->input->post('bldg_en'),
                        'bldg_ar' => $this->input->post('bldg_ar'),
                        'phone' => $this->input->post('phone'),
                        'fax' => $this->input->post('fax'),
                        'pobox_ar' => $this->input->post('pobox_ar'),
                        'pobox_en' => $this->input->post('pobox_en'),
                        'email' => $this->input->post('email'),
                        'website' => $this->input->post('website'),
                        'est_date' => $this->input->post('est_date'),
                        'governorate_id' => $this->input->post('governorate_id'),
                        'district_id' => $this->input->post('district_id'),
                        'x_location' => $this->input->post('x_location'),
                        'y_location' => $this->input->post('y_location'),
                        //'x_decimal' => $this->input->post('x_decimal'),
                        //'y_decimal' => $this->input->post('y_decimal'),
                        'sales_man_id' => $this->input->post('sales_man_id'),
                        'cr_ar' => $this->input->post('cr_ar'),
                        'cr_en' => $this->input->post('cr_en'),
                        'member_local' => $this->input->post('member_local'),
                        'member_overseas' => $this->input->post('member_overseas'),
                        'maritime' => $this->input->post('maritime'),
                        'airline' => $this->input->post('airline'),
                        'service_landline' => $this->input->post('service_landline'),
                        'service_maritime' => $this->input->post('service_maritime'),
                        'service_airline' => $this->input->post('service_airline'),
                        'copy_reservation' => $this->input->post('copy_res'),
                        'is_adv' => $this->input->post('is_adv'),
                        'adv_pic' => $this->input->post('adv_pic'),
                        'services' => $activities,
                        'app_refill_date' => $this->input->post('app_refill_date'),
                        'res_person_ar' => $this->input->post('res_person_ar'),
                        'res_person_en' => $this->input->post('res_person_en'),
                        'position_id' => $this->input->post('position_id'),
                        'trade_license' => $this->input->post('trade_license'),
                        'license_source_id' => $this->input->post('license_source_id'),
                        'ref' => $this->input->post('ref'),
                        'personal_notes' => $this->input->post('personal_notes'),
                        'address2_ar' => $this->input->post('address2_ar'),
                        'address2_en' => $this->input->post('address2_en'),
                        'update_time' => date('Y-m-d H:i:s'),
                        'online' => $status,
                        'user_id' => $this->session->userdata('id'),
                );

                if($id = $this->Administrator->edit($this->tbl_transport, $data, $id)) {
                    $newdata = $this->Administrator->affected_fields($row, $data);
                    $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $row['name_ar'], 'type' => 'transportation', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history);
                    $this->session->set_userdata(array('admin_message' => 'Added successfully'));
                    redirect('transportations/details/'.$id);
                }
                else {
                    $this->session->set_userdata(array('admin_message' => 'Error'));
                    redirect('transportations/edit/'.$id);
                }
            }
            /*             * ********************General Info*********************** */
            $this->data['id'] = $id;
            $this->data['c_id'] = $id;
            $this->data['name_ar'] = $row['name_ar'];
            $this->data['name_en'] = $row['name_en'];
            $this->data['owner_ar'] = $row['owner_ar'];
            $this->data['owner_en'] = $row['owner_en'];
            $this->data['cr_ar'] = $row['cr_ar'];
            $this->data['cr_en'] = $row['cr_en'];
            $this->data['est_date'] = $row['est_date'];
            $this->data['services_data'] = explode(',', $row['services']);

            $this->data['personal_notes'] = $row['personal_notes'];

            /*             * ********************Address*********************** */
            $this->data['governorate_id'] = $row['governorate_id'];
            $this->data['district_id'] = $row['district_id'];
            $this->data['area_id'] = $row['area_id'];
            $this->data['street_ar'] = $row['street_ar'];
            $this->data['street_en'] = $row['street_en'];
            $this->data['bldg_ar'] = $row['bldg_ar'];
            $this->data['bldg_en'] = $row['bldg_en'];
            $this->data['fax'] = $row['fax'];
            $this->data['phone'] = $row['phone'];
            $this->data['pobox_ar'] = $row['pobox_ar'];
            $this->data['pobox_en'] = $row['pobox_en'];
            $this->data['email'] = $row['email'];
            $this->data['website'] = $row['website'];
            $this->data['x_location'] = $row['x_location'];
            $this->data['y_location'] = $row['y_location'];
            /*             * ***********************End Address***************** */
            $this->data['service_landline'] = $row['service_landline'];
            $this->data['service_maritime'] = $row['service_maritime'];
            $this->data['service_airline'] = $row['service_airline'];
            $this->data['maritime'] = $row['maritime'];
            $this->data['airline'] = $row['airline'];
            $this->data['member_local'] = $row['member_local'];
            $this->data['member_overseas'] = $row['member_overseas'];
            $this->data['member_local_ar'] = $row['member_local_ar'];
            $this->data['member_local_en'] = $row['member_local_en'];
            $this->data['member_overseas_ar'] = $row['member_overseas_ar'];
            $this->data['member_overseas_en	'] = $row['member_overseas_en'];
            /*             * ***********************Molhak***************** */
            $this->data['res_person_ar'] = $row['res_person_ar'];
            $this->data['res_person_en'] = $row['res_person_en'];
            $this->data['position_id'] = $row['position_id'];

            $this->data['trade_license'] = $row['trade_license'];
            $this->data['license_source_id'] = $row['license_source_id'];

            $this->data['sales_man_id'] = $row['sales_man_id'];
            $this->data['status'] = $row['online'];
            $this->data['is_adv'] = $row['is_adv'];
            $this->data['adv_pic'] = $row['adv_pic'];
            $this->data['copy_res'] = $row['copy_reservation'];
            $this->data['app_refill_date'] = $row['app_refill_date'];

            $this->data['address2_ar'] = $row['address2_ar'];
            $this->data['address2_en'] = $row['address2_en'];
            $this->data['ref'] = $row['ref'];
           // $this->data['x_decimal'] = $row['x_decimal'];
           // $this->data['y_decimal'] = $row['y_decimal'];

            $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
            $this->data['districts'] = $this->Address->GetDistrictByGov('online', $row['governorate_id']);
            $this->data['areas'] = $this->Address->GetAreaByDistrict('online', $row['district_id']);

            if($row['services'] != '') {
                $array_services = explode(',', $row['services']);
            }
            else {
                $array_services = array();
            }
            $this->data['activities'] = $this->Transport->GetTransportServices('online');
            $this->data['activities_data'] = $array_services;
            $this->data['sales'] = $this->Company->GetSalesMen();
            $this->data['positions'] = $this->Company->GetPositions();
            $this->data['license_sources'] = $this->Company->GetLicenseSources();

            $this->data['subtitle'] = 'Edit Transportation';
            $this->data['title'] = $this->data['Ctitle']."- Edit Transportation";
            $this->template->load('_template', 'transportation/_form', $this->data);
        }
    }

    public function ports($id) {
        if($this->p_view_port) {
            $query = $this->Transport->GetTransportationById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Transportations', 'transportations');
            $this->breadcrumb->add_crumb($query['name_en'], 'transportations/details/'.$id);
            $this->breadcrumb->add_crumb('المرافئ التي تقصدها البواخر');
            $this->form_validation->set_rules('name_ar', 'name in arabic', 'required');
            $this->form_validation->set_rules('name_en', 'name in english', 'required');

            if($this->form_validation->run()) {

                $data = array(
                        'transport_id' => $id,
                        'name_ar' => $this->input->post('name_ar'),
                        'name_en' => $this->input->post('name_en'),
                        'create_time' => date('Y-m-d H:i:s'),
                        'update_time' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('id'),
                );

                if($bid = $this->General->save('tbl_transport_ports', $data)) {
                    $data['id'] = $bid;
                    $history = array('action' => 'add', 'logs_id' => 0, 'item_id' => $bid, 'item_title' => $query['name_ar'], 'type' => 'transportation_ports', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history);
                    $this->session->set_userdata(array('admin_message' => 'Added successfully'));
                }
                else {
                    $this->session->set_userdata(array('admin_message' => 'Error'));
                }
                redirect('transportations/ports/'.$id);
            }
            /*             * ********************General Info*********************** */
            $this->data['id'] = $id;
            $this->data['c_id'] = '';
            $this->data['name_ar'] = '';
            $this->data['name_en'] = '';


            $this->data['query'] = $query;

            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['title'] = $query['name_en']." - ".$query['name_ar'];
            $this->data['subtitle'] = $query['name_en']." - ".$query['name_ar'];
            $this->data['ports'] = $this->Transport->GetTransportPorts($id);
            $this->template->load('_template', 'transportation/ports', $this->data);
        }
        else {
            redirect('transportations');
        }
    }

    public function sponsors($id) {

        /* 	$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'delete');
          $p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'edit');
          $p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,16,'add');
         */
        $query = $this->Company->GetCompanyById($id);
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Companies', 'companies');
        $this->breadcrumb->add_crumb($query['name_en'], 'companies/details/'.$id);
        $this->breadcrumb->add_crumb('Sponsors', 'companies/sponsors/'.$id);

        $this->data['c_id'] = $id;
        $this->data['query'] = $query;

        $this->data['p_delete'] = TRUE;
        $this->data['p_edit'] = TRUE;
        $this->data['p_add'] = TRUE;
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->data['items'] = $this->Company->GetCompanySponsors('online');
        $this->data['title'] = $this->data['Ctitle']." - Companies - الشركات";
        $this->data['subtitle'] = "Sponsors";
        $this->template->load('_template', 'company/sponsors', $this->data);
    }

}
?>