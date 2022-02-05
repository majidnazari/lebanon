<?php

class Banks extends Application {
    var $company = 'tbl_bank';
    var $bank_branch = 'tbl_bank_branch';
    var $p_delete = FALSE;
    var $p_edit = FALSE;
    var $p_add = FALSE;
    var $p_branches = FALSE;
    var $p_branch_add = FALSE;
    var $p_branch_edit = FALSE;
    var $p_branch_delete = FALSE;
    var $p_directors = FALSE;

    public function __construct() {
        parent::__construct();
        $this->ag_auth->restrict('banks'); // restrict this controller to admins only
        $this->load->model(array('Administrator', 'Item', 'Address', 'Company', 'Bank', 'Insurance'));
        $this->data['Ctitle'] = 'Industry';
        $this->p_delete = $this->ag_auth->check_privilege(8, 'delete');
        $this->p_edit = $this->ag_auth->check_privilege(8, 'edit');
        $this->p_branches = $this->ag_auth->check_privilege(8, 'branches');
        $this->p_branch_add = $this->ag_auth->check_privilege(8, 'branch_add');
        $this->p_branch_edit = $this->ag_auth->check_privilege(8, 'branch_edit');
        $this->p_branch_delete = $this->ag_auth->check_privilege(8, 'branch_delete');
        $this->p_directors = $this->ag_auth->check_privilege(8, 'directors');
        $this->p_add = $this->ag_auth->check_privilege(7, 'add');
		
		$this->data['p_changing'] =$this->p_changing = $this->ag_auth->check_privilege(8, 'changing');
		
        $this->data['p_delete'] = $this->p_delete;
        $this->data['p_edit'] = $this->p_edit;
        $this->data['p_add'] = $this->p_add;
        $this->data['p_branches'] = $this->p_branches;
        $this->data['p_branch_add'] = $this->p_branch_add;
        $this->data['p_branch_edit'] = $this->p_branch_edit;
        $this->data['p_branch_delete'] = $this->p_branch_delete;
        $this->data['p_directors'] = $this->p_directors;
    }
    public function export($id)
    {
        $filename = "bank-" . $id . ".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');


        $query = $this->Bank->GetBankById($id);
        $this->data['query'] = $query;
        $this->data['governorates'] = $this->Address->GetGovernorateById($query['governorate_id']);
        $this->data['districts'] = $this->Address->GetDistrictById($query['district_id']);
        $this->data['area'] = $this->Address->GetAreaById($query['area_id']);
        $this->data['items'] = $this->Company->GetProductionInfo($id);

        $this->data['salesman'] = $this->General->GetSalesManById($query['sales_man_id']);
        $this->data['position'] = $this->Item->GetPositionById($query['position_id']);
        $this->data['directors'] = $this->Bank->GetDirectors($id);
        $this->data['branches'] = $this->Bank->GetBranches('', $id);


        $this->load->view('banks/application_view', $this->data);

    }
public function changing_company()
	{
		if($this->p_changing)
		{
		$old_company=$this->input->post('old_company');
		$new_company=$this->input->post('new_company');
		if($old_company=='' or $new_company==''){
			$this->session->set_userdata(array('admin_message'=>'Old and new banks are required'));
		}
		else{
		$companies=$this->Administrator->update('tbl_banks_company',array('bank_id'=>$new_company),array('bank_id'=>$old_company));
		
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully<br>'.$companies.' companies'));
		}
			redirect('banks');					
		
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	
public function convertlocation() {
	die;
        $query = $this->Bank->GetBanks('', 0, 0);
        foreach($query as $row) {
            $array = array(
                    'x_location' => $this->Administrator->Degree2Decimal($row->x_location),
                    'y_location' => $this->Administrator->Degree2Decimal($row->y_location),
                    'x_old' => $row->x_location,
                    'y_old' => $row->y_location,
            );
			//var_dump($array);
            $this->Administrator->edit('tbl_bank', $array, $row->id);
        }
    }
    public function remove($id) {
        $this->Administrator->edit($this->company, array('adv_pic' => ''), $id);
        $this->session->set_userdata(array('admin_message' => 'Image Deleted'));
        redirect('banks/details/'.$id);
    }

    public function editimage() {
        if(isset($_POST)) {
            $id = $this->input->post('editimageid');
            $array = $this->Administrator->do_upload('uploads/', 'adimage');

            if($array['target_path'] != "") {
                $path = $array['target_path'];
                $this->Administrator->edit($this->company, array('adv_pic' => $path), $id);
            }
            $msg = $array['error'];
            $this->session->set_userdata(array('admin_message' => $msg));
            redirect('banks/details/'.$id);
        }
    }

    public function branch_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $this->Administrator->edit('tbl_bank_branch', array('status' => $status), $id);
        if($status == 'online')
            echo '<a href="javascript:;" onclick="change_status('.$id.',\'offline\')"><span class="label label-success">Online</span></a>';
        else
            echo '<a href="javascript:;" onclick="change_status('.$id.',\'online\')"><span class="label">Offline</span></a>';
    }

    public function DisplayItem() {
        $item_id = $_POST['id'];
        $items = $this->Item->GetItemById($item_id);
        if(count($items) > 0) {

            echo $items['label_ar'].'<br><hr />'.$items['label_en'];
        }
    }

    public function DisplayBank() {
        $item_id = $_POST['id'];
        $items = $this->Bank->GetBankById($item_id);
        if(count($items) > 0) {

            echo $items['name_ar'].'<br><hr />'.$items['name_en'];
        }
    }

    public function GetMarketByCountry() {
        echo '<script>
        $(document).ready(function() {
			$("#market_id").select2();
        });
    </script>';

        $market_option = 'id="market_id" style="width:300px"';

        $country_id = $_POST['id'];
        $markets = $this->Company->GetMarketByCountryId('online', $country_id);
        if(count($markets) > 0) {
            $array_markets[0] = 'All';
            foreach($markets as $market) {
                $array_markets[$market->id] = $market->title_ar.' ('.$market->title_en.' )';
            }
        }
        else {
            $array_markets[''] = 'No Data Found';
        }
        echo form_dropdown('market_id', $array_markets, '', $market_option);
    }

    public function GetDataSection() {
        $sector_id = $_POST['id'];
        $section_id = $_POST['section_id'];
        $sections = $this->Item->GetSectionsBySectorId('online', $sector_id);
        if(count($sections) > 0) {
            $array_section[0] = 'All';
            foreach($sections as $section) {
                $array_section[$section->id] = $section->label_ar;
            }
        }
        else {
            $array_section[''] = 'No Data Found';
        }
        echo form_dropdown('section', $array_section, $section_id);
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
        $areas = $this->Bank->GetAreaByDistrict('online', $dist_id);

        $area_js = 'id="area_id" ';
        if(count($areas) > 0) {
            $array_area[''] = 'All';
            foreach($areas as $area) {
                $array_area[$area->id] = $area->label_ar.' -'.$area->label_en.' ('.$area->total.')';
            }
        }
        else {
            $array_area[''] = 'No Data Found';
        }
        echo form_dropdown('area_id', $array_area, '', $area_js);
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

    public function delete() {
        $get = $this->uri->ruri_to_assoc();
        if((int)$get['id'] > 0) {
            switch($get['st']) {
                case 'banks':
                    $query = $this->Bank->GetBankById($get['id']);
                    $history = array('action' => 'delete', 'logs_id' => 0, 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'bank', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $h_id = $this->General->save('logs', $history);

                    $directors = $this->Bank->GetDirectors($get['id']);
                    $history_directors = array('logs_id' => $h_id, 'action' => 'delete', 'item_id' => $get['id'], 'type' => 'banks_directors', 'details' => json_encode($directors), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history_directors);

                    $branches = $this->Bank->GetBranches('', $get['id']);
                    $history_branches = array('logs_id' => $h_id, 'action' => 'delete', 'item_id' => $get['id'], 'type' => 'banks_branches', 'details' => json_encode($branches), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history_branches);

                    $this->General->delete('tbl_bank', array('id' => $get['id']));
                    $this->General->delete('tbl_bank_branch', array('bank_id' => $get['id']));
                    $this->General->delete('tbl_bank_director', array('bank_id' => $get['id']));
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('banks');
                    break;
                case 'director':
                    $directors = $this->Bank->GetDirectorById($get['id']);
                    $query = $this->Bank->GetBankById($get['bank']);
                    $history_directors = array('logs_id' => 0, 'action' => 'delete', 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'banks_directors', 'details' => json_encode($directors), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history_directors);
                    $this->General->delete('tbl_bank_director', array('id' => $get['id']));
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('banks/directors/'.$get['bank']);
                    break;
                case 'branches':
                    if($this->p_branch_delete) {
                        $branches = $this->Bank->GetBranchById($get['id']);
                        $query = $this->Bank->GetBankById($get['bank']);
                        $history_branches = array('logs_id' => 0, 'action' => 'delete', 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'banks_branches', 'details' => json_encode($branches), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history_branches);
                        $this->General->delete('tbl_bank_branch', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Permission Denied'));
                    }
                    redirect('banks/branches/'.$get['bank']);
                    break;
            }
        }
    }

    public function delete_checked() {
      
        $delete_array = $this->input->post('checkbox1');
        $st = $this->input->post('st');
        $p = $this->input->post('p');

        if(empty($delete_array)) {
            $this->session->set_userdata(array('admin_message' => 'No Item Checked'));
        }
        else {

            switch($p) {
                case 'banks':
                    foreach($delete_array as $d_id) {
                        $query = $this->Bank->GetBankById($d_id);
                        $history = array('action' => 'delete', 'details' => json_encode($query), 'create_time' => date('Y-m-d H:i:s'), 'user_id' => $this->session->userdata('id'));
                        $this->General->save('history_banks', $history);
                        $this->General->delete('tbl_bank', array('id' => $d_id));
                    }
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('banks');
                    break;
                case 'branches':
                    $bankid = $this->input->post('bank');
                    if($this->p_branch_delete) {
                        foreach($delete_array as $d_id) {
                            $this->General->delete('tbl_bank_branch', array('id' => $d_id));
                        }
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Permission Denied'));
                    }
                    redirect('banks/branches/'.$bankid);
                    break;
                case 'directors':
                    $bankid = $this->input->post('bank_id');
                  //  if($this->p_branch_delete) {
                        foreach($delete_array as $d_id) {
                            $this->General->delete('tbl_bank_director', array('id' => $d_id));
                        }
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                   /* }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Permission Denied'));
                    } */
                    redirect('banks/directors/'.$bankid);
                    break;
                case 'offline':
                    $this->General->delete($this->company, array('id' => $d_id));
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('banks');
                    break;
                case 'offline':
                    $this->General->delete($this->company, array('id' => $d_id));
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('banks');
                    break;
            }
        }
    }

    public function index($row = 0) {
        $this->data['search'] = TRUE;
        if(isset($_GET['search'])) {
            $limit = 20;
            $row = $this->input->get('per_page');
            $govID = $this->input->get('gov');
            $districtID = $this->input->get('district_id');
            $areaID = $this->input->get('area_id');
            $id = $this->input->get('id');
            $name = $this->input->get('name');
            $phone = $this->input->get('phone');
            $fax = $this->input->get('fax');
            $status = $this->input->get('status');
            $query = $this->Bank->SearchBanks($id, $name, $phone, $fax, $status, $govID, $districtID,$areaID, $row, $limit);
            $total_row = count($this->Bank->SearchBanks($id, $name, $phone, $fax, $status, $govID, $districtID,$areaID, 0, 0));
            $config['base_url'] = base_url().'banks?id='.$id.'&name='.$name.'&phone='.$phone.'&fax='.$fax.'&gov='.$govID.'&district_id='.$districtID.'&area_id='.$areaID.'&status='.$status.'&search=Search';
            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
        }
        elseif(isset($_GET['clear'])) {
            redirect('banks/');
        }
        else {
            $limit = 20;
            $govID = 0;
            $districtID = 0;
            $status = '';
            $id = '';
            $name = '';
            $phone = '';
            $fax = '';
            $config['base_url'] = base_url().'banks/index';
            //$config['uri_segment'] = 12;
            $query = $this->Bank->GetBanks('', $row, $limit);
            $total_row = count($this->Bank->GetBanks('', 0, 0));
            $this->pagination->initialize($config);
        }
        $this->data['govID'] = $govID;
        $this->data['districtID'] = $districtID;
        $this->data['areaID'] = @$areaID;
        $this->data['status'] = $status;
        $this->data['id'] = $id;
        $this->data['name'] = $name;
        $this->data['phone'] = $phone;
        $this->data['fax'] = $fax;
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
        $this->breadcrumb->add_crumb('Banks');
        $this->data['title'] = $this->data['Ctitle']." - Banks - البنوك";
        ;
        $this->data['subtitle'] = "Banks - البنوك";
        $this->data['sectors'] = $this->Item->GetSector('online', 0, 0);
        $this->data['sections'] = $this->Item->GetSection('online', 0, 0);
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', $this->data['govID']);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);

            $this->data['areas'] = $this->Bank->GetAreaByDistrict('online', @$districtID);
		$this->data['query1'] = $query1 = $this->Bank->GetBanks('', 0, 0);

        $this->template->load('_template', 'banks/banks', $this->data);
    }

    public function reservations($row = 0) {
        $this->data['search'] = FALSE;
        $limit = 20;
        $config['base_url'] = base_url().'banks/reservations';
        //$config['uri_segment'] = 12;
        $query = $this->Bank->GetBanksS(1, '', $row, $limit);
        $total_row = count($this->Bank->GetBanksS(1, '', 0, 0));
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
        $this->breadcrumb->add_crumb('Banks');
        $this->data['title'] = $this->data['Ctitle']." - Banks - البنوك";
        ;
        $this->data['subtitle'] = "البنوك الحاجزة نسخة";
        $this->template->load('_template', 'banks/banks', $this->data);
    }

    public function advertising($row = 0) {
        $this->data['search'] = FALSE;
        $limit = 20;
        $config['base_url'] = base_url().'banks/advertising';
        //$config['uri_segment'] = 12;
        $query = $this->Bank->GetBanksS('', 1, $row, $limit);
        $total_row = count($this->Bank->GetBanksS('', 1, 0, 0));
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
        $this->breadcrumb->add_crumb('Banks');
        $this->data['title'] = $this->data['Ctitle']." - Banks - البنوك";
        ;
        $this->data['subtitle'] = "البنوك المعلنة";
        $this->template->load('_template', 'banks/banks', $this->data);
    }

    public function archive($row = 0) {

        if(isset($_GET['search'])) {
            $limit = 100;
            $row = $this->input->get('per_page');
            $govID = $this->input->get('gov');
            $districtID = $this->input->get('district_id');
            $chapter = $this->input->get('chapter');
            $status = $this->input->get('status');
            $query = $this->Bank->SearchBanks($status, $govID, $districtID, $row, $limit);
            $total_row = count($this->Bank->SearchBanks($status, $govID, $districtID, 0, 0));
            $config['base_url'] = base_url().'banks?gov='.$govID.'&district_id='.$districtID.'&status='.$status.'&search=Search';
            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
        }
        elseif(isset($_GET['clear'])) {
            redirect('banks/archive');
        }
        else {
            $limit = 20;
            $govID = 0;
            $districtID = 0;
            $status = 'offline';
            $config['base_url'] = base_url().'banks/archive';
            //$config['uri_segment'] = 12;
            $query = $this->Bank->GetBanks('offline', $row, $limit);
            $total_row = count($this->Bank->GetBanks('offline', 0, 0));
            $this->pagination->initialize($config);
        }
        $this->data['govID'] = $govID;
        $this->data['districtID'] = $districtID;
        $this->data['status'] = $status;
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
        $this->breadcrumb->add_crumb('Banks');
        $this->data['title'] = $this->data['Ctitle']." - Banks - البنوك";
        ;
        $this->data['subtitle'] = "Banks - البنوك";
        $this->data['sectors'] = $this->Item->GetSector('offline', 0, 0);
        $this->data['sections'] = $this->Item->GetSection('offline', 0, 0);
        $this->data['districts'] = $this->Address->GetDistrictByGov('offline', $this->data['govID']);
        $this->data['governorates'] = $this->Address->GetGovernorate('offline', 0, 0);
        $this->template->load('_template', 'banks/banks', $this->data);
    }

public function listview() {
        /* 	$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'delete');
          $p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'edit');
          $p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,16,'add');
         */
       $id=$this->input->get('id');
    $name=$this->input->get('name');
    $phone=$this->input->get('phone');
    $fax=$this->input->get('fax');
    $gov=$this->input->get('gov');
    $district_id=$this->input->get('district_id');
    $area_id=$this->input->get('area_id');
    $status=$this->input->get('status');
    $this->data['query'] = $this->Bank->SearchBanks($id, $name, $phone, $fax, $status, $gov, $district_id,$area_id, 0, 0);
        $this->data['title'] = $this->data['Ctitle']." - Companies - الشركات";
        $this->data['subtitle'] = "Companies - الشركات";
        $this->load->view('banks/listview', $this->data);
    }
    public function listview1() {

        $gov = $this->input->get('gov');
        $district_id = $this->input->get('district_id');
        $status = $this->input->get('status');
        $this->data['query'] = $this->Bank->SearchBanks($status, $gov, $district_id, 0, 0);
        $this->data['title'] = $this->data['Ctitle']." - Banks - البنوك";
        ;
        $this->data['subtitle'] = "Banks - البنوك";
        $this->load->view('banks/listview', $this->data);
    }

    public function details($id) {
        $query = $this->Bank->GetBankById($id);
        $this->data['query'] = $query;
        $this->data['id'] = $id;
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Banks', 'banks');
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');

        $this->data['title'] = $this->data['Ctitle']." - Banks - البنوك";
        $this->data['subtitle'] = "Banks - البنوك";
        $this->data['sections'] = $this->Item->GetSection('online', 0, 0);
        $this->data['governorates'] = $this->Address->GetGovernorateById($query['governorate_id']);
        $this->data['districts'] = $this->Address->GetDistrictById($query['district_id']);
        $this->data['area'] = $this->Address->GetAreaById($query['area_id']);
        $this->data['directors'] = $this->Bank->GetDirectors($id);
        $this->data['branches'] = $this->Bank->GetBranches('', $id);
        $this->data['license'] = $this->Company->GetLicenseSourceById($query['license_source_id']);
        $this->data['salesman'] = $this->General->GetSalesManById($query['sales_man_id']);
        $this->template->load('_template', 'banks/details', $this->data);
    }

    public function view($id) { // PRINT

        $query = $this->Bank->GetBankById($id);
        $this->data['query'] = $query;

        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->data['title'] = $query['name_en']." - ".$query['name_ar'];
        $this->data['sectors'] = $this->Item->GetSector('online', 0, 0);
        $this->data['sections'] = $this->Item->GetSection('online', 0, 0);
        $this->data['governorates'] = $this->Address->GetGovernorateById($query['governorate_id']);
        $this->data['districts'] = $this->Address->GetDistrictById($query['district_id']);
        $this->data['area'] = $this->Address->GetAreaById($query['area_id']);
        $this->data['salesman'] = $this->General->GetSalesManById($query['sales_man_id']);
        $this->data['directors'] = $this->Bank->GetDirectors($id);
        $this->data['branches'] = $this->Bank->GetBranches('', $id);
		$this->data['position'] = $this->Item->GetPositionById($query['position_id']);
        $this->data['license'] = $this->Company->GetLicenseSourceById($query['license_source_id']);
        $this->load->view('banks/view', $this->data);
    }

    public function directors($id) { // PRINT
        if($this->p_directors) {
            $query = $this->Bank->GetBankById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Banks', 'banks');
            $this->breadcrumb->add_crumb($query['name_en'], 'banks/details/'.$id);
            $this->breadcrumb->add_crumb('Board Of Directors');
            $this->form_validation->set_rules('name_ar', 'name in arabic', 'required');
            $this->form_validation->set_rules('name_en', 'name in english', 'required');

            if($this->form_validation->run()) {

                $data = array(
                        'bank_id' => $id,
                        'name_ar' => $this->input->post('name_ar'),
                        'name_en' => $this->input->post('name_en'),
                        'ordering' => 1000,
                        'create_time' => date('Y-m-d H:i:s'),
                        'update_time' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('id'),
                );

                if($nid = $this->General->save('tbl_bank_director', $data)) {
                    $bank = $this->Bank->GetBankById($id);
                    unset($data['bank_id']);
                    unset($data['create_time']);
                    unset($data['update_time']);
                    unset($data['user_id']);
                    $history = array('action' => 'add', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $bank['name_ar'], 'type' => 'bank_director', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history);
                    $this->session->set_userdata(array('admin_message' => 'Added successfully'));
                }
                else {
                    $this->session->set_userdata(array('admin_message' => 'Error'));
                }
                redirect('banks/directors/'.$id);
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
            $this->data['directors'] = $this->Bank->GetDirectors($id);
            $this->template->load('_template', 'banks/directors', $this->data);
        }
        else {
            redirect('banks');
        }
    }

    public function standing() {
        $order_array = $this->input->post('ids');
        $bank = $this->input->post('bank_id');
        for($i = 0; $i < count($order_array); $i++) {
            $this->Administrator->edit('tbl_bank_director', array('ordering' => $i + 1), $order_array[$i]);
        }
        redirect('banks/directors/'.$bank);
    }

    public function editdirector() {
        $name_ar = $this->input->post('namear');
        $name_en = $this->input->post('nameen');
        $id = $this->input->post('id');
        $data = array('name_ar' => $name_ar, 'name_en' => $name_en, 'update_time' => date('Y-m-d H:i:s'));
        $query = $this->Bank->GetDirectorById($id);
        $bank = $this->Bank->GetBankById($query['bank_id']);
        $newdata = $this->Administrator->affected_fields($query, $data);
        $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $bank['id'], 'item_title' => $bank['name_ar'], 'type' => 'bank_director', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
        $this->General->save('logs', $history);
        $this->Administrator->edit('tbl_bank_director', $data, $id);
    }

    public function printall() {
        $ids = $this->input->post('checkbox1');

        foreach($ids as $id) {
            $this->view($id);

        }
    }
public function printed_search()
{
    $id=$this->input->get('id');
    $name=$this->input->get('name');
    $phone=$this->input->get('phone');
    $fax=$this->input->get('fax');
    $gov=$this->input->get('gov');
    $district_id=$this->input->get('district_id');
    $area_id=$this->input->get('area_id');
    $status=$this->input->get('status');
    $query = $this->Bank->SearchBanks($id, $name, $phone, $fax, $status, $gov, $district_id,$area_id, 0, 0);
    foreach($query as $row) {
        $this->view($row->id);

    }
}
    public function create() {
        $this->data['nave'] = FALSE;
        if($this->p_add) {
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Banks', 'banks');
            $this->breadcrumb->add_crumb('Add New Bank');
            $this->form_validation->set_rules('name_ar', 'bank name in arabic', 'required');

            if($this->form_validation->run()) {
                /*
                  $array=$this->Administrator->do_upload('uploads/');

                  if($array['target_path']!=""){
                  $path=$array['target_path'];
                  }
                  else{
                  $path=$this->input->post('logo');
                  }

                  $msg=$array['error'];

                  $x1=$this->input->post('x1');
                  $x2=$this->input->post('x2');
                  $x3=$this->input->post('x3');
                  $x=$x1.'°'.$x2."'".$x3.'"';

                  $y1=$this->input->post('y1');
                  $y2=$this->input->post('y2');
                  $y3=$this->input->post('y3');
                  $y=$y1.'°'.$y2."'".$y3.'"';
                 */
                $data = array(
                        'name_ar' => $this->input->post('name_ar'),
                        'name_en' => $this->input->post('name_en'),
                        'establish_date' => is_numeric($this->input->post('establish_date'))?$this->input->post('establish_date'):0,
                        'bnk_capital' => $this->input->post('bnk_capital'),
                        'list_number' => is_numeric($this->input->post('list_number'))?$this->input->post('list_number'):0,
                        'trade_license' => $this->input->post('trade_license'),
                        'license_source_id' => $this->input->post('license_source_id'),
                        'governorate_id' => $this->input->post('governorate_id'),
                        'district_id' => $this->input->post('district_id'),
                        'area_id' => $this->input->post('area_id'),
                        'street_ar' => $this->input->post('street_ar'),
                        'street_en' => $this->input->post('street_en'),
                        'bldg_ar' => $this->input->post('bldg_ar'),
                        'bldg_en' => $this->input->post('bldg_en'),
                        'fax' => $this->input->post('fax'),
                        'phone' => $this->input->post('phone'),
                        'pobox_ar' => $this->input->post('pobox_ar'),
                        'pobox_en' => $this->input->post('pobox_en'),
                        'email' => $this->input->post('email'),
                        'website' => $this->input->post('website'),
                        'x_location' => $this->input->post('x_location'),
                        'y_location' => $this->input->post('y_location'),
                        'sales_man_id' => $this->input->post('sales_man_id'),
                        'online' => $this->input->post('online'),
                        'bnk_capital' => $this->input->post('bnk_capital'),
                        'res_person_ar' => $this->input->post('res_person_ar'),
                        'res_person_en' => $this->input->post('res_person_en'),
                        'position_id' => $this->input->post('position_id'),
                        'beside_en' => $this->input->post('beside_en'),
                        'beside_ar' => $this->input->post('beside_ar'),
                        'copy_res' => $this->input->post('copy_res'),
                        'is_adv' => $this->input->post('is_adv'),
                        'adv_pic' => $this->input->post('adv_pic'),
                        'bnk_ref' => $this->input->post('bnk_ref'),
                        'app_refill_date' => valid_date($this->input->post('app_refill_date')),
                        'display_directory' => $this->input->post('display_directory'),
                        'directory_interested' => $this->input->post('directory_interested'),
                        'display_exhibition' => $this->input->post('display_exhibition'),
                        'exhibition_interested' => $this->input->post('exhibition_interested'),
                        'personal_notes' => $this->input->post('personal_notes'),
                        'address2_ar' => $this->input->post('address2_ar'),
                        'address2_en' => $this->input->post('address2_en'),
                        'create_time' => date('Y-m-d H:i:s'),
                        'update_time' => date('Y-m-d H:i:s'),
                        'status' => $this->input->post('status')=='1'?'online':'offline',
                        'user_id' => $this->session->userdata('id'),
                );

                if($id = $this->General->save($this->company, $data)) {
                    $history = array('action' => 'add', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $data['name_ar'], 'type' => 'bank', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history);
                    $this->session->set_userdata(array('admin_message' => 'Bank Added successfully'));
                    redirect('banks/details/'.$id);
                }
                else {
                    $this->session->set_userdata(array('admin_message' => 'Error'));
                    redirect('banks/create');
                }
            }
            /*             * ********************General Info*********************** */
            $this->data['c_id'] = '';
            $this->data['name_ar'] = '';
            $this->data['name_en'] = '';
            $this->data['establish_date'] = '';
            $this->data['list_number'] = '';
            $this->data['bnk_capital'] = '';
            /*             * ********************Address*********************** */
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
            $this->data['commercial_register_en'] = '';
            $this->data['commercial_register_ar'] = '';
            /*             * ***********************End Address***************** */
            $this->data['res_person_ar'] = '';
            $this->data['res_person_en'] = '';
            $this->data['position_id'] = 0;
            $this->data['sales_man_id'] = 0;
            $this->data['show_online'] = 1;
            $this->data['is_adv'] = 0;
            $this->data['adv_pic'] = '';
            $this->data['copy_res'] = 0;
            $this->data['app_refill_date'] = '';

            $this->data['display_directory'] = '';
            $this->data['directory_interested'] = '';
            $this->data['display_exhibition'] = '';
            $this->data['exhibition_interested'] = '';
            $this->data['personal_notes'] = '';

            $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
            $this->data['license_sources'] = $this->Company->GetLicenseSources();
            $this->data['districts'] = array();
            $this->data['areas'] = array();
            $this->data['sales'] = $this->Bank->GetSalesMen();
            $this->data['positions'] = $this->Company->GetPositions();

            $this->data['subtitle'] = 'Add New Bank';
            $this->data['title'] = $this->data['Ctitle']."- Add New Bank";
            $this->template->load('_template', 'banks/banks_form', $this->data);
        }
        else {
            redirect('banks');
        }
    }

    public function edit($id) {
        $this->data['nave'] = TRUE;
        if($this->p_edit) {

            $query = $this->Bank->GetBankById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Banks', 'banks');
            $this->breadcrumb->add_crumb($query['name_en'], 'banks/details/'.$id);
            $this->breadcrumb->add_crumb('Edit Bank');
            $this->form_validation->set_rules('name_ar', 'bank name in arabic', 'required');

            if($this->form_validation->run()) {
                if($this->input->post('is_adv')) {
                    $is_adv = $this->input->post('is_adv');
                }
                else {
                    $is_adv = 0;
                }
                /*
                  $array=$this->Administrator->do_upload('uploads/');
                  if($array['target_path']!=""){
                  $path=$array['target_path'];
                  }
                  else{
                  $path=$this->input->post('logo');
                  }

                  $msg=$array['error'];

                  $x1=$this->input->post('x1');
                  $x2=$this->input->post('x2');
                  $x3=$this->input->post('x3');
                  $x=$x1.'°'.$x2."'".$x3.'"';

                  $y1=$this->input->post('y1');
                  $y2=$this->input->post('y2');
                  $y3=$this->input->post('y3');
                  $y=$y1.'°'.$y2."'".$y3.'"';
                 */
                $data = array(
                        'name_ar' => $this->input->post('name_ar'),
                        'name_en' => $this->input->post('name_en'),
                        'establish_date' => $this->input->post('establish_date'),
                        'bnk_capital' => $this->input->post('bnk_capital'),
                        'list_number' => $this->input->post('list_number'),
                        'trade_license' => $this->input->post('trade_license'),
                        'license_source_id' => $this->input->post('license_source_id'),
                        'governorate_id' => $this->input->post('governorate_id'),
                        'district_id' => $this->input->post('district_id'),
                        'area_id' => $this->input->post('area_id'),
                        'street_ar' => $this->input->post('street_ar'),
                        'street_en' => $this->input->post('street_en'),
                        'bldg_ar' => $this->input->post('bldg_ar'),
                        'bldg_en' => $this->input->post('bldg_en'),
                        'fax' => $this->input->post('fax'),
                        'phone' => $this->input->post('phone'),
                        'pobox_ar' => $this->input->post('pobox_ar'),
                        'pobox_en' => $this->input->post('pobox_en'),
                        'email' => $this->input->post('email'),
                        'website' => $this->input->post('website'),
                        'x_location' => $this->input->post('x_location'),
                        'y_location' => $this->input->post('y_location'),
                        'sales_man_id' => $this->input->post('sales_man_id'),
                        'online' => $this->input->post('online'),
                        'bnk_capital' => $this->input->post('bnk_capital'),
                        'res_person_ar' => $this->input->post('res_person_ar'),
                        'res_person_en' => $this->input->post('res_person_en'),
                        'position_id' => $this->input->post('position_id'),
                        'beside_en' => $this->input->post('beside_en'),
                        'beside_ar' => $this->input->post('beside_ar'),
                        'copy_res' => $this->input->post('copy_res'),
                        'is_adv' => $is_adv,
                        'adv_pic' => $this->input->post('adv_pic'),
                        'bnk_ref' => $this->input->post('bnk_ref'),
                        'app_refill_date' => valid_date($this->input->post('app_refill_date')),
                        'display_directory' => $this->input->post('display_directory'),
                        'directory_interested' => $this->input->post('directory_interested'),
                        'display_exhibition' => $this->input->post('display_exhibition'),
                        'exhibition_interested' => $this->input->post('exhibition_interested'),
                        'personal_notes' => $this->input->post('personal_notes'),
                        'address2_ar' => $this->input->post('address2_ar'),
                        'address2_en' => $this->input->post('address2_en'),
                        'update_time' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('id'),
                );
                $bank = $this->Bank->GetBankById($id);
                if($this->Administrator->edit($this->company, $data, $id)) {

                    $newdata = $this->Administrator->affected_fields($bank, $data);
                    $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $bank['name_ar'], 'type' => 'bank', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history);
                    $this->session->set_userdata(array('admin_message' => 'Bank Updated successfully'));
                    redirect('banks/details/'.$id);
                }
                else {
                    $this->session->set_userdata(array('admin_message' => 'Error'));
                    redirect('banks/edit/'.$id);
                }
            }
            /*             * ********************General Info*********************** */
            $this->data['id'] = $id;
            $this->data['c_id'] = $id;
            $this->data['name_ar'] = $query['name_ar'];
            $this->data['name_en'] = $query['name_en'];
            $this->data['establish_date'] = $query['establish_date'];
            $this->data['bnk_capital'] = $query['bnk_capital'];
            $this->data['list_number'] = $query['list_number'];
            $this->data['trade_license'] = $query['trade_license'];
            $this->data['license_source_id'] = $query['license_source_id'];

            $this->data['commercial_register_en'] = $query['commercial_register_en'];
            $this->data['commercial_register_ar'] = $query['commercial_register_ar'];

            /*             * ********************Address*********************** */
            $this->data['governorate_id'] = $query['governorate_id'];
            $this->data['district_id'] = $query['district_id'];
            $this->data['area_id'] = $query['area_id'];
            $this->data['street_ar'] = $query['street_ar'];
            $this->data['street_en'] = $query['street_en'];
            $this->data['bldg_ar'] = $query['bldg_ar'];
            $this->data['bldg_en'] = $query['bldg_en'];
            $this->data['fax'] = $query['fax'];
            $this->data['show_online'] = $query['online'];
            $this->data['phone'] = $query['phone'];
            $this->data['pobox_ar'] = $query['pobox_ar'];
            $this->data['pobox_en'] = $query['pobox_en'];
            $this->data['email'] = $query['email'];
            $this->data['website'] = $query['website'];
            $this->data['x_location'] = $query['x_location'];
            $this->data['y_location'] = $query['y_location'];
            /*             * ***********************End Address***************** */
            $this->data['sales_man_id'] = $query['sales_man_id'];
            $this->data['res_person_ar'] = $query['res_person_ar'];
            $this->data['res_person_en'] = $query['res_person_en'];
            $this->data['position_id'] = $query['position_id'];
            $this->data['is_adv'] = $query['is_adv'];
            $this->data['adv_pic'] = $query['adv_pic'];
            $this->data['copy_res'] = $query['copy_res'];
            $this->data['app_refill_date'] = $query['app_refill_date'];

            $this->data['display_directory'] = $query['display_directory'];
            $this->data['directory_interested'] = $query['directory_interested'];
            $this->data['display_exhibition'] = $query['display_exhibition'];
            $this->data['exhibition_interested'] = $query['exhibition_interested'];
            $this->data['personal_notes'] = $query['personal_notes'];
            $this->data['address2_ar'] = $query['address2_ar'];
            $this->data['address2_en'] = $query['address2_en'];
            $this->data['bnk_ref'] = $query['bnk_ref'];
            $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
            $this->data['districts'] = $this->Address->GetDistrictByGov('online', $query['governorate_id']);
            $this->data['areas'] = $this->Address->GetAreaByDistrict('online', $query['district_id']);
            $this->data['license_sources'] = $this->Company->GetLicenseSources();
            $this->data['positions'] = $this->Company->GetPositions();

            $this->data['sales'] = $this->Bank->GetSalesMen();
            $this->data['subtitle'] = 'Edit Bank';
            $this->data['title'] = $this->data['Ctitle']."- Edit Bank";
            $this->template->load('_template', 'banks/banks_form', $this->data);
        }
        else {
            redirect('banks');
        }
    }

    public function branches($id) {

        if($this->p_branches) {
            $query = $this->Bank->GetBankById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Banks', 'banks');
            $this->breadcrumb->add_crumb($query['name_en'], 'banks/details/'.$id);
            $this->breadcrumb->add_crumb('Branches');
            $this->data['query'] = $query;
            $this->data['id'] = $id;
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['title'] = $query['name_en']." - ".$query['name_ar'];
            $this->data['subtitle'] = $query['name_en']." - ".$query['name_ar'];
            $this->data['branches'] = $this->Bank->GetBranches('', $id);
            $this->template->load('_template', 'banks/branches', $this->data);
        }
        else {
            redirect('banks');
        }
    }

    public function branch_details($id) {
        if($this->p_branches) {
            $row = $this->Bank->GetBranchById($id);
            $query = $this->Bank->GetBankById($row['bank_id']);

            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Banks', 'banks');
            $this->breadcrumb->add_crumb($query['name_en'], 'banks/details/'.$row['bank_id']);
            $this->breadcrumb->add_crumb('Branches', 'banks/branches/'.$row['bank_id']);
            $this->breadcrumb->add_crumb($row['name_en']);

            $this->data['id'] = $row['bank_id'];
            $this->data['name_ar'] = $row['name_ar'];
            $this->data['name_en'] = $row['name_en'];
            $this->data['area_id'] = $row['area_id'];
            $this->data['street_ar'] = $row['street_ar'];
            $this->data['street_en'] = $row['street_en'];
            $this->data['bldg_ar'] = $row['bldg_ar'];
            $this->data['bldg_en'] = $row['bldg_en'];
            $this->data['fax'] = $row['fax'];
            $this->data['phone'] = $row['phone'];
            $this->data['pobox_ar'] = $row['pobox_ar'];
            $this->data['pobox_en'] = $row['pobox_en'];
            $this->data['beside_ar'] = $row['beside_ar'];
            $this->data['beside_en'] = $row['beside_en'];
            $this->data['email'] = $row['email'];
            $this->data['website'] = $row['web_page'];
            $this->data['x_location'] = $row['x_location'];
            $this->data['y_location'] = $row['y_location'];

            $b_area = $this->Address->GetAreaById($row['area_id']);
            $b_district = $this->Address->GetDistrictById($b_area['district_id']);
            $b_gov = $this->Address->GetGovernorateById($b_district['governorate_id']);

            $this->data['governorate_id'] = $b_district['governorate_id'];
            $this->data['district_id'] = $b_area['district_id'];

            $this->data['governorates'] = $b_gov;
            $this->data['districts'] = $b_district;
            $this->data['areas'] = $b_area;
            $this->data['row'] = $row;
            $this->data['subtitle'] = $query['name_en'].' : '.$row['name_en'];
            $this->data['title'] = $this->data['Ctitle']."-  Branch : ".$row['name_en'];
            $this->template->load('_template', 'banks/branch_details', $this->data);
        }
        else {
            redirect('banks');
        }
    }

    public function branch_create($id) {
        if($this->p_branch_add) {
            $query = $this->Bank->GetBankById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Banks', 'banks');
            $this->breadcrumb->add_crumb($query['name_en'], 'banks/details/'.$id);
            $this->breadcrumb->add_crumb('Branches', 'banks/branches/'.$id);
            $this->breadcrumb->add_crumb('Add New Bank Branch');
            $this->form_validation->set_rules('name_ar', 'bank branche name in arabic', 'required');

            if($this->form_validation->run()) {
                $x1 = $this->input->post('x1');
                $x2 = $this->input->post('x2');
                $x3 = $this->input->post('x3');
                $x = $x1.'°'.$x2."'".$x3.'"';

                $y1 = $this->input->post('y1');
                $y2 = $this->input->post('y2');
                $y3 = $this->input->post('y3');
                $y = $y1.'°'.$y2."'".$y3.'"';

                $data = array(
                        'name_ar' => $this->input->post('name_ar'),
                        'name_en' => $this->input->post('name_en'),
                        'bank_id' => $id,
                        'area_id' => $this->input->post('area_id'),
                        'street_ar' => $this->input->post('street_ar'),
                        'street_en' => $this->input->post('street_en'),
                        'bldg_ar' => $this->input->post('bldg_ar'),
                        'bldg_en' => $this->input->post('bldg_en'),
                        'fax' => $this->input->post('fax'),
                        'phone' => $this->input->post('phone'),
                        'pobox_ar' => $this->input->post('pobox_ar'),
                        'pobox_en' => $this->input->post('pobox_en'),
                        'email' => $this->input->post('email'),
                        'web_page' => $this->input->post('website'),
                        'x_location' => $x,
                        'y_location' => $y,
                        'beside_en' => $this->input->post('beside_en'),
                        'beside_ar' => $this->input->post('beside_ar'),
                        'create_time' => date('Y-m-d H:i:s'),
                        'update_time' => date('Y-m-d H:i:s'),
                        'status' => 'online',
                        'user_id' => $this->session->userdata('id'),
                );

                if($branch_id = $this->General->save($this->bank_branch, $data)) {
                    $bank = $this->Bank->GetBankById($id);
                    $history = array('action' => 'add', 'logs_id' => 0, 'item_id' => $branch_id, 'item_title' => $bank['name_ar'], 'type' => 'bank_branch', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history);
                    $this->session->set_userdata(array('admin_message' => 'Branch Added successfully'));
                    redirect('banks/branches/'.$id);
                }
                else {
                    $this->session->set_userdata(array('admin_message' => 'Error'));
                    redirect('banks/branches/'.$id);
                }
            }
            /*             * ********************General Info*********************** */
            $this->data['id'] = $id;
            $this->data['name_ar'] = '';
            $this->data['name_en'] = '';
            $this->data['area_id'] = 0;
            $this->data['street_ar'] = '';
            $this->data['street_en'] = '';
            $this->data['bldg_ar'] = '';
            $this->data['bldg_en'] = '';
            $this->data['fax'] = '';
            $this->data['phone'] = '';
            $this->data['pobox_ar'] = '';
            $this->data['pobox_en'] = '';
            $this->data['beside_ar'] = '';
            $this->data['beside_en'] = '';
            $this->data['email'] = '';
            $this->data['website'] = '';
            $this->data['x_location'] = '';
            $this->data['y_location'] = '';

            $this->data['governorate_id'] = '';
            $this->data['district_id'] = '';

            $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
            $this->data['districts'] = array();
            $this->data['areas'] = array();

            $this->data['subtitle'] = 'Add New Bank Branch';
            $this->data['title'] = $this->data['Ctitle']."- Add New Bank Branch";
            $this->template->load('_template', 'banks/branch_form', $this->data);
        }
        else {
            redirect('banks');
        }
    }

    public function branch_edit($id) {
        if($this->p_branch_edit) {
            $row = $this->Bank->GetBranchById($id);
            $query = $this->Bank->GetBankById($row['bank_id']);

            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Banks', 'banks');
            $this->breadcrumb->add_crumb($query['name_en'], 'banks/details/'.$row['bank_id']);
            $this->breadcrumb->add_crumb('Branches', 'banks/branches/'.$row['bank_id']);
            $this->breadcrumb->add_crumb('Edit Branch : '.$row['name_en']);
            $this->form_validation->set_rules('name_ar', 'bank branche name in arabic', 'required');

            if($this->form_validation->run()) {

                $x1 = $this->input->post('x1');
                $x2 = $this->input->post('x2');
                $x3 = $this->input->post('x3');
                $x = $x1.'°'.$x2."'".$x3.'"';

                $y1 = $this->input->post('y1');
                $y2 = $this->input->post('y2');
                $y3 = $this->input->post('y3');
                $y = $y1.'°'.$y2."'".$y3.'"';

                $bank_id = $this->input->post('bank_id');
                $data = array(
                        'name_ar' => $this->input->post('name_ar'),
                        'name_en' => $this->input->post('name_en'),
                        'area_id' => $this->input->post('area_id'),
                        'street_ar' => $this->input->post('street_ar'),
                        'street_en' => $this->input->post('street_en'),
                        'bldg_ar' => $this->input->post('bldg_ar'),
                        'bldg_en' => $this->input->post('bldg_en'),
                        'fax' => $this->input->post('fax'),
                        'phone' => $this->input->post('phone'),
                        'pobox_ar' => $this->input->post('pobox_ar'),
                        'pobox_en' => $this->input->post('pobox_en'),
                        'email' => $this->input->post('email'),
                        'web_page' => $this->input->post('website'),
                        'x_location' => $x,
                        'y_location' => $y,
                        'beside_en' => $this->input->post('beside_en'),
                        'beside_ar' => $this->input->post('beside_ar'),
                        'update_time' => date('Y-m-d H:i:s'),
                        'status' => 'online',
                        'user_id' => $this->session->userdata('id'),
                );
                $query = $this->Bank->GetBranchById($id);
                if($this->Administrator->edit($this->bank_branch, $data, $id)) {

                    $bank = $this->Bank->GetBankById($bank_id);
                    $newdata = $this->Administrator->affected_fields($query, $data);
                    $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $bank['name_ar'].' - '.$this->input->post('name_ar'), 'type' => 'bank_branch', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history);

                    $this->session->set_userdata(array('admin_message' => 'Branch Updated successfully'));
                    redirect('banks/branches/'.$bank_id);
                }
                else {
                    $this->session->set_userdata(array('admin_message' => 'Error'));
                    redirect('banks/branches/'.$bank_id);
                }
            }
            /*             * ********************General Info*********************** */
            $this->data['id'] = $row['bank_id'];
            $this->data['name_ar'] = $row['name_ar'];
            $this->data['name_en'] = $row['name_en'];
            $this->data['area_id'] = $row['area_id'];
            $this->data['street_ar'] = $row['street_ar'];
            $this->data['street_en'] = $row['street_en'];
            $this->data['bldg_ar'] = $row['bldg_ar'];
            $this->data['bldg_en'] = $row['bldg_en'];
            $this->data['fax'] = $row['fax'];
            $this->data['phone'] = $row['phone'];
            $this->data['pobox_ar'] = $row['pobox_ar'];
            $this->data['pobox_en'] = $row['pobox_en'];
            $this->data['beside_ar'] = $row['beside_ar'];
            $this->data['beside_en'] = $row['beside_en'];
            $this->data['email'] = $row['email'];
            $this->data['website'] = $row['web_page'];
            $this->data['x_location'] = $row['x_location'];
            $this->data['y_location'] = $row['y_location'];

            $b_area = $this->Address->GetAreaById($row['area_id']);
            $b_district = $this->Address->GetDistrictById($b_area['district_id']);
            $b_gov = $this->Address->GetGovernorateById($b_district['governorate_id']);

            $this->data['governorate_id'] = $b_district['governorate_id'];
            $this->data['district_id'] = $b_area['district_id'];

            $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
            $this->data['districts'] = $this->Address->GetDistrictByGov('online', $b_district['governorate_id']);
            $this->data['areas'] = $this->Address->GetAreaByDistrict('online', $b_area['district_id']);

            $this->data['subtitle'] = 'Edit Branch';
            $this->data['title'] = $this->data['Ctitle']."- Edit Branch";
            $this->template->load('_template', 'banks/branch_form', $this->data);
        }
        else {
            redirect('banks');
        }
    }

}
?>