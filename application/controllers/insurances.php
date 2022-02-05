<?php

class Insurances extends Application {
    var $tbl_insurance = 'tbl_insurances';
    var $tbl_branches = 'tbl_insurance_branches';
    var $tbl_directors = 'tbl_insurance_directors';
    var $tbl_managers = 'tbl_insurance_managers';
    var $p_delete = FALSE;
    var $p_edit = FALSE;
    var $p_add = FALSE;
    var $p_directors = FALSE;
    var $p_directors_add = FALSE;
    var $p_directors_edit = FALSE;
    var $p_directors_delete = FALSE;
    var $p_branches = FALSE;
    var $p_branches_add = FALSE;
    var $p_branches_edit = FALSE;
    var $p_branches_delete = FALSE;
    var $p_executive = FALSE;
    var $p_executive_add = FALSE;
    var $p_executive_edit = FALSE;
    var $p_executive_delete = FALSE;
    var $page_denied = '';

    public function __construct() {

        parent::__construct();
        $this->ag_auth->restrict('insurances'); // restrict this controller to admins only
        $this->load->model(array('Administrator', 'Item', 'Address', 'Insurance', 'Company'));
        $this->data['Ctitle'] = 'Industry - Insurance Companies';

        $this->p_add = $this->ag_auth->check_privilege(11, 'add');
        $this->p_delete = $this->ag_auth->check_privilege(12, 'delete');
        $this->p_edit = $this->ag_auth->check_privilege(12, 'edit');

        $this->p_directors = $this->ag_auth->check_privilege(12, 'directors');
        $this->p_directors_add = $this->ag_auth->check_privilege(12, 'directors_add');
        $this->p_directors_edit = $this->ag_auth->check_privilege(12, 'directors_edit');
        $this->p_directors_delete = $this->ag_auth->check_privilege(12, 'directors_delete');

        $this->p_branches = $this->ag_auth->check_privilege(12, 'branches');
        $this->p_branches_add = $this->ag_auth->check_privilege(12, 'branches_add');
        $this->p_branches_edit = $this->ag_auth->check_privilege(12, 'branches_edit');
        $this->p_branches_delete = $this->ag_auth->check_privilege(12, 'branches_delete');

        $this->p_executive = $this->ag_auth->check_privilege(12, 'executive');
        $this->p_executive_add = $this->ag_auth->check_privilege(12, 'executive_add');
        $this->p_executive_edit = $this->ag_auth->check_privilege(12, 'executive_edit');
        $this->p_executive_delete = $this->ag_auth->check_privilege(12, 'executive_delete');
		
		 $this->data['p_changing'] =$this->p_changing = $this->ag_auth->check_privilege(12, 'changing');

        $this->data['p_delete'] = $this->p_delete;
        $this->data['p_edit'] = $this->p_edit;
        $this->data['p_add'] = $this->p_add;

        $this->data['p_directors'] = $this->p_directors;
        $this->data['p_directors_add'] = $this->p_directors_add;
        $this->data['p_directors_edit'] = $this->p_directors_edit;
        $this->data['p_directors_delete'] = $this->p_directors_delete;

        $this->data['p_branches'] = $this->p_branches;
        $this->data['p_branches_add'] = $this->p_branches_add;
        $this->data['p_branches_edit'] = $this->p_branches_edit;
        $this->data['p_branches_delete'] = $this->p_branches_delete;

        $this->data['p_executive'] = $this->p_executive;
        $this->data['p_executive_add'] = $this->p_executive_add;
        $this->data['p_executive_edit'] = $this->p_executive_edit;
        $this->data['p_executive_delete'] = $this->p_executive_delete;
    }
	public function changing_company()
	{
		if($this->p_changing)
		{
		$old_company=$this->input->post('old_company');
		$new_company=$this->input->post('new_company');
		if($old_company=='' or $new_company==''){
			$this->session->set_userdata(array('admin_message'=>'Old and new companies are required'));
		}
		else{
		$companies=$this->Administrator->update('tbl_insurances_company',array('insurance_id'=>$new_company),array('insurance_id'=>$old_company));
		
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully<br>'.$companies.' companies'));
		}
			redirect('insurances');					
		
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}

    public function convertlocation() {
        $query = $this->Insurance->GetInsurances('', 0, 0);
        foreach($query as $row) {
            $array = array(
                    'x_location' => $this->Administrator->Degree2Decimal($row->x_location),
                    'y_location' => $this->Administrator->Degree2Decimal($row->y_location),
                    'x_old' => $row->x_location,
                    'y_old' => $row->y_location,
            );
            $this->Administrator->edit('tbl_insurances', $array, $row->id);
        }
    }

    public function remove($id) {
        $this->Administrator->edit('tbl_insurances', array('adv_pic' => ''), $id);
        $this->session->set_userdata(array('admin_message' => 'Image Deleted'));
        redirect('insurances/details/'.$id);
    }

    public function editimage() {
        if(isset($_POST)) {
            $id = $this->input->post('editimageid');
            $array = $this->Administrator->do_upload('uploads/', 'adimage');

            if($array['target_path'] != "") {
                $path = $array['target_path'];
                $this->Administrator->edit('tbl_insurances', array('adv_pic' => $path), $id);
            }
            $msg = $array['error'];
            $this->session->set_userdata(array('admin_message' => $msg));
            redirect('insurances/details/'.$id);
        }
    }

    public function change_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $this->Administrator->edit('tbl_insurances', array('online' => $status), $id);
        if($status == 1)
            echo '<a href="javascript:;" onclick="change_status('.$id.',0)"><span class="label label-success">Online</span></a>';
        else
            echo '<a href="javascript:;" onclick="change_status('.$id.',1)"><span class="label">Offline</span></a>';
    }

    public function DisplayItem() {
        $item_id = $_POST['id'];
        $items = $this->Item->GetItemById($item_id);
        if(count($items) > 0) {

            echo $items['label_ar'].'<br><hr />'.$items['label_en'];
        }
    }

    public function addproduct() {
        $id = $_POST['id'];
        $companyid = $_POST['companyid'];
        $production = $this->Item->GetItemById($id);
        $data = array(
                'company_id' => $companyid,
                'heading_id' => $id,
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => date('Y-m-d H:i:s'),
                'user_id' => $this->session->userdata('id'),
        );

        if($this->General->save($this->company_heading, $data)) {
            echo '<div class="alert alert-success" id="success">'.$production['hs_code_print'].' Production Added</div>';
        }
    }

    public function SearchProduction() {
        $code = $_POST['code'];
        $description = $_POST['description'];

        $items = $this->Company->SearchProductions($code, $description);
        $this->data['items'] = $items;
        $this->data['companyid'] = $_POST['companyid'];
        $this->load->view('company/production_list', $this->data);
    }

    public function DisplayBank() {
        $item_id = $_POST['id'];
        $items = $this->Bank->GetBankById($item_id);
        if(count($items) > 0) {

            echo $items['name_ar'].'<br><hr />'.$items['name_en'];
        }
    }

    public function DisplayInsurance() {
        $item_id = $_POST['id'];
        $items = $this->Insurance->GetInsuranceById($item_id);
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
        $areas = $this->Insurance->GetAreaByDistrict('online', $dist_id);
        if(count($areas) > 0) {
            $array_area[''] = 'All';
            foreach($areas as $area) {
                $array_area[$area->id] = $area->label_ar.' - '.$area->label_en.' ('.$area->total.')';
            }
        }
        else {
            $array_area[''] = 'No Data Found';
        }
        echo form_dropdown('area_id', $array_area,' id="area_id"');
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
            switch($get['p']) {
                case 'insurance':
                    if($this->p_delete) {
                        $query = $this->Insurance->GetInsuranceById($get['id']);
                        $history = array('action' => 'delete', 'logs_id' => 0, 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'insurance', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $h_id = $this->General->save('logs', $history);

                        $branches = $this->Insurance->GetInsuranceBranches($get['id']);
                        $history_branches = array('logs_id' => $h_id, 'action' => 'delete', 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'insurance_branches', 'details' => json_encode($branches), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history_branches);

                        $directors = $this->Insurance->GetInsuranceDirectors($get['id']);
                        $history_directors = array('logs_id' => $h_id, 'action' => 'delete', 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'insurance_directors', 'details' => json_encode($directors), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history_directors);

                        $managers = $this->Insurance->GetInsuranceExecutives($get['id']);
                        $history_managers = array('logs_id' => $h_id, 'action' => 'delete', 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'insurance_managers', 'details' => json_encode($managers), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history_managers);


                        $this->General->delete('tbl_insurances', array('id' => $get['id']));
                        $this->General->delete('tbl_insurance_branches', array('insurance_id' => $get['id']));
                        $this->General->delete('tbl_insurance_directors', array('insurance_id' => $get['id']));
                        $this->General->delete('tbl_insurance_managers', array('insurance_id' => $get['id']));

                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('insurances');
                    }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;

                case 'branch':
                    if($this->p_branches_delete) {
                        $query = $this->Insurance->GetInsuranceBranchById($get['id']);
                        $history = array('logs_id' => 0, 'action' => 'delete', 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'insurance_branches', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history);

                        $this->General->delete('tbl_insurance_branches', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('insurances/branches/'.$get['iid']);
                    }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;
                case 'director':
                    if($this->p_directors_delete) {
                        $query = $this->Insurance->GetInsuranceDirectorById($get['id']);
                        $history = array('logs_id' => 0, 'action' => 'delete', 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'insurance_directors', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history);

                        $this->General->delete('tbl_insurance_directors', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('insurances/directors/'.$get['iid']);
                    }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;
                case 'executive':
                    if($this->p_executive_delete) {
                        $query = $this->Insurance->GetInsuranceExecutiveById($get['id']);

                        $history = array('logs_id' => 0, 'action' => 'delete', 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'insurance_managers', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history);

                        $this->General->delete('tbl_insurance_managers', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('insurances/executive/'.$get['iid']);
                    }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
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
            $iid = $this->input->post('iid');
            //if(isset($this->input->post('p')))
            switch($this->input->post('p')) {
                case 'insurance':
                    foreach($delete_array as $d_id) {
                        $query = $this->Insurance->GetInsuranceById($d_id);
                        $history = array('action' => 'delete', 'logs_id' => 0, 'item_id' => $d_id, 'item_title' => $query['name_ar'], 'type' => 'insurance', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $h_id = $this->General->save('logs', $history);

                        $branches = $this->Insurance->GetInsuranceBranches($d_id);
                        $history_branches = array('logs_id' => $h_id, 'action' => 'delete', 'item_id' => $d_id, 'item_title' => $query['name_ar'], 'type' => 'insurance_branches', 'details' => json_encode($branches), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history_branches);

                        $directors = $this->Insurance->GetInsuranceDirectors($d_id);
                        $history_directors = array('logs_id' => $h_id, 'action' => 'delete', 'item_id' => $d_id, 'item_title' => $query['name_ar'], 'type' => 'insurance_directors', 'details' => json_encode($directors), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history_directors);

                        $managers = $this->Insurance->GetInsuranceExecutives($d_id);
                        $history_managers = array('logs_id' => $h_id, 'action' => 'delete', 'item_id' => $d_id, 'item_title' => $query['name_ar'], 'type' => 'insurance_managers', 'details' => json_encode($managers), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history_managers);


                        $this->General->delete('tbl_insurances', array('id' => $d_id));
                        $this->General->delete('tbl_insurance_branches', array('insurance_id' => $d_id));
                        $this->General->delete('tbl_insurance_directors', array('insurance_id' => $d_id));
                        $this->General->delete('tbl_insurance_managers', array('insurance_id' => $d_id));
                    }
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('insurances');

                    break;
                case 'branch':
                    if($this->p_branches_delete) {
                        $ins_id = $this->input->post('ins_id');
                        foreach($delete_array as $d_id) {
                            $query = $this->Insurance->GetInsuranceBranchById($d_id);
                            $history = array('logs_id' => 0, 'action' => 'delete', 'item_id' => $d_id, 'item_title' => $query['name_ar'], 'type' => 'insurance_branches', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                            $this->General->save('logs', $history);
                            $this->General->delete('tbl_insurance_branches', array('id' => $d_id));
                        }
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('insurances/branches/'.$ins_id);
                    }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;
                case 'director':
                    if($this->p_directors_delete) {
                        $ins_id = $this->input->post('ins_id');
                        foreach($delete_array as $d_id) {
                            $query = $this->Insurance->GetInsuranceDirectorById($d_id);
                            $history = array('logs_id' => 0, 'action' => 'delete', 'item_id' => $d_id, 'item_title' => $query['name_ar'], 'type' => 'insurance_directors', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                            $this->General->save('logs', $history);

                            $this->General->delete('tbl_insurance_directors', array('id' => $d_id));
                        }
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('insurances/directors/'.$ins_id);
                    }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;
                case 'executive':
                    if($this->p_executive_delete) {
                        foreach($delete_array as $d_id) {
                            $query = $this->Insurance->GetInsuranceExecutiveById($d_id);

                            $history = array('logs_id' => 0, 'action' => 'delete', 'item_id' => $d_id, 'item_title' => $query['name_ar'], 'type' => 'insurance_managers', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                            $this->General->save('logs', $history);

                            $this->General->delete('tbl_insurance_managers', array('id' => $d_id));
                        }
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('insurances/executive/'.$iid);
                    }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;
            }
        }
    }

    public function printi() {
        $_array = $this->input->post('checkbox1');
        //var_dump()
        if(empty($delete_array)) {
            $this->session->set_userdata(array('admin_message' => 'No Item Checked'));

            //if(isset($this->input->post('p')))
            //redirect($_SEREVER['']);
            // No items checked
        }
        else {
            echo 'function printpage(url)
{

  child = window.open(url, "", "height=1px, width=1px");  //Open the child in a tiny window.
  window.focus();  //Hide the child as soon as it is opened.
  child.print();  //Print the child.
  child.close();  //Immediately close the child.
}
printpage();
</script>

 ';


            //if(isset($this->input->post('p')))
        }
    }

    public function index($row = 0) {
        $this->data['search'] = TRUE;
        //echo '<pre>'; var_dump($this->session->userdata('permissions')); echo '</pre>';
        $p_delete = $this->ag_auth->check_privilege(12, 'delete');
        $p_edit = $this->ag_auth->check_privilege(12, 'edit');
        $p_add = $this->ag_auth->check_privilege(11, 'add');

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
            $query = $this->Insurance->SearchInsurances($id, $name, $phone, $status, $govID, $districtID,$areaID, $row, $limit);
            //var_dump($query);
            $total_row = count($this->Insurance->SearchInsurances($id, $name, $phone, $status, $govID, $districtID,$areaID, 0, 0));
            $config['base_url'] = base_url().'insurances?id='.$id.'&name='.$name.'&phone='.$phone.'&gov='.$govID.'&district_id='.$districtID.'area_id='.$areaID.'&status='.$status.'&search=Search';

            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
        }
        elseif(isset($_GET['clear'])) {
            redirect('insurances/');
        }
        else {
            $limit = 20;
            $govID = 0;
            $districtID = 0;
            $status = '';
            $config['base_url'] = base_url().'insurances/index';
            //$config['uri_segment'] = 12;
            $query = $this->Insurance->GetInsurances('', $row, $limit);

            $total_row = count($this->Insurance->GetInsurances('', 0, 0));

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
        $this->breadcrumb->add_crumb('Inusrance');
        $this->data['title'] = $this->data['Ctitle']." - Inusrance - شركات التأمين";
        $this->data['subtitle'] = "Inusrance - شركات التأمين";
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', $this->data['govID']);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
		$this->data['query1'] = $query1 = $this->Insurance->GetInsurances('', 0, 0);
        $this->data['areas'] = $this->Insurance->GetAreaByDistrict('online', @$districtID);
        $this->template->load('_template', 'insurance/index', $this->data);
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
        $query = $this->Insurance->SearchInsurances($id, $name, $phone, $status, $gov, $district_id,$area_id, 0, 0);
        foreach($query as $row) {
            $this->view($row->id);

        }
    }
    public function reservations($row = 0) {
        $limit = 20;
        $this->data['search'] = FALSE;
        //echo '<pre>'; var_dump($this->session->userdata('permissions')); echo '</pre>';
        $p_delete = $this->ag_auth->check_privilege(12, 'delete');
        $p_edit = $this->ag_auth->check_privilege(12, 'edit');
        $p_add = $this->ag_auth->check_privilege(11, 'add');
        $config['base_url'] = base_url().'insurances/reservations';
        //$config['uri_segment'] = 12;
        $query = $this->Insurance->GetInsurancesS(1, '', $row, $limit);
        $total_row = count($this->Insurance->GetInsurancesS(1, '', 0, 0));
        $this->pagination->initialize($config);
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
        $this->breadcrumb->add_crumb('Inusrance');
        $this->data['title'] = $this->data['Ctitle']." - Inusrance - شركات التأمين";
        $this->data['subtitle'] = "شركات  التأمين الحاجزة نسخة";
        $this->template->load('_template', 'insurance/index', $this->data);
    }

    public function advertising($row = 0) {
        $limit = 20;
        $this->data['search'] = FALSE;
        //echo '<pre>'; var_dump($this->session->userdata('permissions')); echo '</pre>';
        $p_delete = $this->ag_auth->check_privilege(12, 'delete');
        $p_edit = $this->ag_auth->check_privilege(12, 'edit');
        $p_add = $this->ag_auth->check_privilege(11, 'add');
        $config['base_url'] = base_url().'insurances/advertising';
        //$config['uri_segment'] = 12;
        $query = $this->Insurance->GetInsurancesS('', 1, $row, $limit);
        $total_row = count($this->Insurance->GetInsurancesS('', 1, 0, 0));
        $this->pagination->initialize($config);
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
        $this->breadcrumb->add_crumb('Inusrance');
        $this->data['title'] = $this->data['Ctitle']." - Inusrance - شركات التأمين";
        $this->data['subtitle'] = "شركات التأمين المعلنة";
        $this->template->load('_template', 'insurance/index', $this->data);
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
            $config['base_url'] = base_url().'companies?id='.$id.'&name='.$name.'&activity='.$activity.'&phone='.$phone.'&search=Search';
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

    public function listview() {
        /* 	$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'delete');
          $p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'edit');
          $p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,16,'add');
         */
       $id=$this->input->get('id');
        $name=$this->input->get('name');
        $phone=$this->input->get('phone');
        $gov=$this->input->get('gov');
        $district_id=$this->input->get('district_id');
        $area_id=$this->input->get('area_id');
        $status=$this->input->get('status');
        $this->data['query'] = $this->Insurance->SearchInsurances($id, $name, $phone, $status, $gov, $district_id,$area_id, 0, 0);
        $this->data['title'] = $this->data['Ctitle']." - Companies - الشركات";
        ;
        $this->data['subtitle'] = "Companies - الشركات";
        $this->load->view('insurance/listview', $this->data);
    }

    public function details($id) {
        $query = $this->Insurance->GetInsuranceById($id);
        $ids = explode(',', $query['activities']);
        $this->data['query'] = $query;

        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Insurance');
        $this->data['title'] = $this->data['Ctitle']." - Companies - الشركات";
        ;
        $this->data['subtitle'] = "Companies - الشركات";
        $this->data['governorates'] = $this->Address->GetGovernorateById($query['governorate_id']);
        $this->data['districts'] = $this->Address->GetDistrictById($query['district_id']);
        $this->data['area'] = $this->Address->GetAreaById($query['area_id']);
        $this->data['directors'] = $this->Address->GetAreaById($query['area_id']);
        $this->data['activities'] = $this->Insurance->GetActivitiesByIds($ids);
        $this->data['id'] = $id;
        $this->data['salesman'] = $this->General->GetSalesManById($query['sales_man_id']);
        $this->template->load('_template', 'insurance/details', $this->data);
    }
    public function export($id)
    {

        $filename = "insurance-" . $id . ".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');


        $query = $this->Insurance->GetInsuranceById($id);
        $ids = explode(',', $query['activities']);
        $this->data['query'] = $query;
        $this->data['governorates'] = $this->Address->GetGovernorateById($query['governorate_id']);
        $this->data['districts'] = $this->Address->GetDistrictById($query['district_id']);
        $this->data['area'] = $this->Address->GetAreaById($query['area_id']);
        $this->data['activities'] = $this->Insurance->GetActivitiesByIds($ids);

        $this->data['salesman'] = $this->General->GetSalesManById($query['sales_man_id']);
        $this->data['position'] = $this->Item->GetPositionById($query['position_id']);
        $this->data['directors'] = $this->Insurance->GetInsuranceDirectors($id);
        $this->data['executives'] = $this->Insurance->GetInsuranceExecutives($id);
        $this->data['branches'] = $this->Insurance->GetInsuranceBranches($id);

        $this->load->view('insurance/application_view', $this->data);

    }
    public function view($id) {

        $query = $this->Insurance->GetInsuranceById($id);
        $ids = explode(',', $query['activities']);
        $this->data['query'] = $query;
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->data['title'] = $query['name_en']." - ".$query['name_ar'];
        $this->data['subtitle'] = "Companies - الشركات";
        $this->data['governorates'] = $this->Address->GetGovernorateById($query['governorate_id']);
        $this->data['districts'] = $this->Address->GetDistrictById($query['district_id']);
        $this->data['area'] = $this->Address->GetAreaById($query['area_id']);
        $this->data['directors'] = $this->Address->GetAreaById($query['area_id']);
        $this->data['activities'] = $this->Insurance->GetActivitiesByIds($ids);
        $this->data['id'] = $id;
        $this->data['salesman'] = $this->General->GetSalesManById($query['sales_man_id']);
        $this->data['directors'] = $this->Insurance->GetInsuranceDirectors($id);
        $this->data['executives'] = $this->Insurance->GetInsuranceExecutives($id);
        $this->data['branches'] = $this->Insurance->GetInsuranceBranches($id);
		$this->data['position'] = $this->Item->GetPositionById($query['position_id']);
        $this->load->view('insurance/view', $this->data);
    }

    public function printall() {
        $ids = $this->input->post('checkbox1');

        foreach($ids as $id) {
            $this->view($id);
        }
    }

    public function directors($id) {
        if($this->p_directors) {

            $query = $this->Insurance->GetInsuranceDirectors($id);
            $insurance = $this->Insurance->GetInsuranceById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Insurance Companies', 'inusrances');
            $this->breadcrumb->add_crumb($insurance['name_en'], 'insurances/details/'.$id);
            $this->breadcrumb->add_crumb('Board of Directors');
            $this->data['subtitle'] = 'Board of Directors';
            $this->data['query'] = $query;
            $this->data['insurance'] = $insurance;
            $this->data['id'] = $id;
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['title'] = $this->data['Ctitle']." | ".$insurance['name_ar']." | Board of Directors";
            $this->template->load('_template', 'insurance/directors', $this->data);
        }
        else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function create_director() {
        if($this->p_directors_add) {
            $insurance_id = $this->input->post('insurance_id');
            $name_ar = $this->input->post('name_ar');
            $name_en = $this->input->post('name_en');

            $data = array(
                    'insurance_id' => $insurance_id,
                    'name_ar' => $name_ar,
                    'name_en' => $name_en,
                    'create_time' => date('Y-m-d H:i:s'),
                    'update_time' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('id'),
            );
            $row = $this->Insurance->GetInsuranceDirectorById($id);
            if($id = $this->General->save('tbl_insurance_directors', $data)) {
                $data['id'] = $id;
                $history = array('logs_id' => 0, 'action' => 'add', 'item_id' => $id, 'item_title' => $data['name_ar'], 'type' => 'insurance_directors', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);

                $this->session->set_userdata(array('admin_message' => 'Add Successfully'));
                redirect('insurances/directors/'.$insurance_id);
            }
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function edit_director($id) {
        if($this->p_directors_edit) {
            $name_ar = $this->input->post('name_ar'.$id);
            $name_en = $this->input->post('name_en'.$id);
            $insurance_id = $this->input->post('insurance_id');

            $data = array(
                    'name_ar' => $name_ar,
                    'name_en' => $name_en,
                    'update_time' => date('Y-m-d H:i:s'),
            );
            $row = $this->Insurance->GetInsuranceDirectorById($id);
            if($this->Administrator->edit('tbl_insurance_directors', $data, $id)) {
                $newdata = $this->Administrator->affected_fields($row, $data);
                $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $row['name_ar'], 'type' => 'insurance_directors', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);

                $this->session->set_userdata(array('admin_message' => 'Updated Successfully'));

                redirect('insurances/directors/'.$insurance_id);
            }
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function executive($id) {
        if($this->p_executive) {

            $query = $this->Insurance->GetInsuranceExecutives($id);
            $insurance = $this->Insurance->GetInsuranceById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Insurance Companies', 'inusrances');
            $this->breadcrumb->add_crumb($insurance['name_en'], 'insurances/details/'.$id);
            $this->breadcrumb->add_crumb('Executive Management');
            $this->data['subtitle'] = 'General Management';
            $this->data['query'] = $query;
            $this->data['insurance'] = $insurance;
            $this->data['id'] = $id;
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['title'] = $this->data['Ctitle']." | ".$insurance['name_ar']." | General Management";
            $this->template->load('_template', 'insurance/executive', $this->data);
        }
        else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function create_executive() {
        if($this->p_executive_add) {
            $insurance_id = $this->input->post('insurance_id');
            $name_ar = $this->input->post('name_ar');
            $name_en = $this->input->post('name_en');

            $data = array(
                    'insurance_id' => $insurance_id,
                    'name_ar' => $name_ar,
                    'name_en' => $name_en,
                    'create_time' => date('Y-m-d H:i:s'),
                    'update_time' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('id'),
            );

            if($id = $this->General->save('tbl_insurance_managers', $data)) {
                $data['id'] = $id;
                $history = array('logs_id' => 0, 'action' => 'add', 'item_id' => $id, 'item_title' => $data['name_ar'], 'type' => 'insurance_managers', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);

                $this->session->set_userdata(array('admin_message' => 'Add Successfully'));
                redirect('insurances/executive/'.$insurance_id);
            }
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function edit_executive($id) {
        if($this->p_executive_edit) {
            $name_ar = $this->input->post('name_ar'.$id);
            $name_en = $this->input->post('name_en'.$id);
            $insurance_id = $this->input->post('insurance_id');

            $data = array(
                    'name_ar' => $name_ar,
                    'name_en' => $name_en,
                    'update_time' => date('Y-m-d H:i:s'),
            );
            $row = $this->Insurance->GetInsuranceExecutiveById($id);
            if($this->Administrator->edit('tbl_insurance_managers', $data, $id)) {
                $newdata = $this->Administrator->affected_fields($row, $data);
                $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $row['name_ar'], 'type' => 'insurance_managers', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);

                $this->session->set_userdata(array('admin_message' => 'Updated Successfully'));

                redirect('insurances/executive/'.$insurance_id);
            }
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function standing() {

        $order_array = $this->input->post('ids');
        $ins = $this->input->post('ins_id');
        //var_dump($order_array);
        //die;
        for($i = 0; $i < count($order_array); $i++) {
            $this->Administrator->edit('tbl_insurance_managers', array('ordering' => $i + 1), $order_array[$i]);
        }
        redirect('insurances/executive/'.$ins);
    }

    public function standing_directors() {

        $order_array = $this->input->post('ids');
        $ins = $this->input->post('ins_id');
        //var_dump($order_array);
        //die;
        for($i = 0; $i < count($order_array); $i++) {
            $this->Administrator->edit('tbl_insurance_directors', array('ordering' => $i + 1), $order_array[$i]);
        }
        redirect('insurances/directors/'.$ins);
    }

    public function branches($id, $item_id = '') {
        if($this->p_branches) {
            $query = $this->Insurance->GetInsuranceById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Insurance Companies', 'insurances');
            $this->breadcrumb->add_crumb($query['name_en'], 'insurances/details/'.$id);
            $this->breadcrumb->add_crumb('Branches', 'insurances/branches/'.$id);
            $this->data['query'] = $query;
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['branches'] = $this->Insurance->GetInsuranceBranches($id);
            $this->data['title'] = $this->data['Ctitle']." - Insurance Companies - الشركات";
            $this->data['id'] = $id;
            $this->template->load('_template', 'insurance/branches', $this->data);
        }
    }

    public function branch_create($id) {
        if($this->p_branches_add) {
            $query = $this->Insurance->GetInsuranceById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Insurance Companies', 'insurances');
            $this->breadcrumb->add_crumb($query['name_en'], 'insurances/details/'.$id);
            $this->breadcrumb->add_crumb('Add New Branches', 'insurances/branch-create/'.$id);
            $this->data['query'] = $query;

            $this->form_validation->set_rules('name_ar', 'Arabic Name ', 'required');
            $this->form_validation->set_rules('name_en', 'English Name ', 'required');

            if($this->form_validation->run()) {

                $data = array(
                        'insurance_id' => $id,
                        'name_ar' => $this->input->post('name_ar'),
                        'name_en' => $this->input->post('name_en'),
                        'area_id' => $this->input->post('area_id'),
                        'street_ar' => $this->input->post('street_ar'),
                        'street_en' => $this->input->post('street_en'),
                        'bldg_ar' => $this->input->post('bldg_ar'),
                        'bldg_en' => $this->input->post('bldg_en'),
                        'phone' => $this->input->post('phone'),
                        'fax' => $this->input->post('fax'),
                        'pobox_ar' => $this->input->post('pobox_ar'),
                        'pobox_en' => $this->input->post('pobox_en'),
                        'email' => $this->input->post('email'),
                        'website' => $this->input->post('website'),
                        'beside_en' => $this->input->post('beside_en'),
                        'beside_ar' => $this->input->post('beside_ar'),
                        'create_time' => date('Y-m-d H:i:s'),
                        'update_time' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('id'),
                );

                if($bid = $this->General->save('tbl_insurance_branches', $data)) {
                    $data['id'] = $bid;
                    $history = array('logs_id' => 0, 'action' => 'add', 'item_id' => $bid, 'item_title' => $data['name_ar'], 'type' => 'insurance_branches', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history);

                    $this->session->set_userdata(array('admin_message' => 'Branch Added successfully'));
                    redirect('insurances/branches/'.$id);
                }
                else {
                    $this->session->set_userdata(array('admin_message' => 'Error'));
                    redirect('insurances/branches/'.$id);
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

            $this->data['governorate_id'] = '';
            $this->data['district_id'] = '';

            $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
            $this->data['districts'] = array();
            $this->data['areas'] = array();

            $this->data['subtitle'] = 'Add New Insurance Branch';
            $this->data['title'] = $this->data['Ctitle']."- Add New Insurance Branch";
            $this->template->load('_template', 'insurance/branch_form', $this->data);
        }
        else {
            redirect($this->page_denied);
        }
    }

    public function branch_edit($id) {
        if($this->p_branches_edit) {
            $row = $this->Insurance->GetInsuranceBranchById($id);
            $query = $this->Insurance->GetInsuranceById($row['insurance_id']);

            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Insurance Companies', 'insurances');
            $this->breadcrumb->add_crumb($query['name_en'], 'insurances/details/'.$id);
            $this->breadcrumb->add_crumb('Edit Branch', 'insurances/branch-edit/'.$id);
            $this->data['query'] = $query;

            $this->form_validation->set_rules('name_ar', 'Arabic Name ', 'required');
            $this->form_validation->set_rules('name_en', 'English Name ', 'required');

            if($this->form_validation->run()) {
                $insurance_id = $this->input->post('insurance_id');
                $data = array(
                        'name_ar' => $this->input->post('name_ar'),
                        'name_en' => $this->input->post('name_en'),
                        'area_id' => $this->input->post('area_id'),
                        'street_ar' => $this->input->post('street_ar'),
                        'street_en' => $this->input->post('street_en'),
                        'bldg_ar' => $this->input->post('bldg_ar'),
                        'bldg_en' => $this->input->post('bldg_en'),
                        'phone' => $this->input->post('phone'),
                        'fax' => $this->input->post('fax'),
                        'pobox_ar' => $this->input->post('pobox_ar'),
                        'pobox_en' => $this->input->post('pobox_en'),
                        'email' => $this->input->post('email'),
                        'website' => $this->input->post('website'),
                        'beside_en' => $this->input->post('beside_en'),
                        'beside_ar' => $this->input->post('beside_ar'),
                        'update_time' => date('Y-m-d H:i:s'),
                );

                if($this->Administrator->edit('tbl_insurance_branches', $data, $id)) {

                    $newdata = $this->Administrator->affected_fields($row, $data);
                    $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $row['name_ar'], 'type' => 'insurance_branches', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history);


                    $this->session->set_userdata(array('admin_message' => 'Branch Updated successfully'));
                    redirect('insurances/branches/'.$insurance_id);
                }
                else {
                    $this->session->set_userdata(array('admin_message' => 'Error'));
                    redirect('insurances/branches/'.$insurance_id);
                }
            }
            /*             * ********************General Info*********************** */
            $this->data['id'] = $row['insurance_id'];
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
            $this->data['website'] = $row['website'];

            $this->data['governorate_id'] = $row['governorate_id'];
            $this->data['district_id'] = $row['district_id'];

            $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
            $this->data['districts'] = $this->Address->GetDistrictByGov('online', $row['governorate_id']);
            $this->data['areas'] = $this->Address->GetAreaByDistrict('online', $row['district_id']);

            $this->data['subtitle'] = 'Edit Insurance Branch';
            $this->data['title'] = $this->data['Ctitle']."- Edit Insurance Branch";
            $this->template->load('_template', 'insurance/branch_form', $this->data);
        }
        else {
            redirect($this->page_denied);
        }
    }

    public function branch_details($id) {
        if($this->p_branches) {
            $row = $this->Insurance->GetInsuranceBranchById($id);
            $query = $this->Insurance->GetInsuranceById($row['insurance_id']);

            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Insurance Companies', 'insurances');
            $this->breadcrumb->add_crumb($query['name_en'], 'insurances/details/'.$id);
            $this->breadcrumb->add_crumb('Branch', 'insurances/branches/'.$id);
            $this->breadcrumb->add_crumb($row['name_en']);
            $this->data['query'] = $query;
            $this->data['row'] = $row;
            /*             * ********************General Info*********************** */
            $this->data['id'] = $row['insurance_id'];
            $this->data['subtitle'] = $row['name_en'];
            $this->data['title'] = $this->data['Ctitle']."- ".$query['name_en'].' - '.$row['name_en'];
            $this->template->load('_template', 'insurance/branch_details', $this->data);
        }
        else {
            redirect($this->page_denied);
        }
    }

    public function create() {
        $this->data['nave'] = FALSE;
        //$this->data['p_edit']=TRUE;
        //$this->data['p_add']=TRUE;
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Insurance Companies', 'insurances');
        $this->breadcrumb->add_crumb('Add New Insurance Company');

        $this->form_validation->set_rules('name_ar', 'company name in arabic', 'required');

        if($this->form_validation->run()) {
            /*
              $array=$this->Administrator->do_upload('uploads/');

              if($array['target_path']!=""){
              $path=$array['target_path'];
              }
              else{
              $path=$this->input->post('logo');
              }
             */
            $activities_array = $this->input->post('activities');
            if(is_array($activities_array))
            {
            $activities = implode(',', $activities_array);
            }
            else{
               $activities= $activities_array;
            }

            //$msg=$array['error'];
            $status = $this->input->post('status');
            if($status == '') {
                $status = 'online';
            }
            $x1 = $this->input->post('x1');
            $x2 = $this->input->post('x2');
            $x3 = $this->input->post('x3');
            $x = $x1.'°'.$x2."'".$x3.'"';

            $y1 = $this->input->post('y1');
            $y2 = $this->input->post('y2');
            $y3 = $this->input->post('y3');
            $y = $y1.'°'.$y2."'".$y3.'"';

            $data = array(
                    'name_en' => $this->input->post('name_en'),
                    'name_ar' => $this->input->post('name_ar'),
                    'ins_number' => $this->input->post('ins_number'),
                    'ins_ecoo_no' => $this->input->post('ins_ecoo_no'),
                    'manager_ar' => $this->input->post('manager_ar'),
                    'manager_en' => $this->input->post('manager_en'),
                    'chairman_ar' => $this->input->post('chairman_ar'),
                    'chairman_en' => $this->input->post('chairman_en'),
                    'trade_license' => $this->input->post('trade_license'),
                    'license_source_id' => $this->input->post('license_source_id'),
//				'cr_ar'=> $this->input->post('cr_ar'),
//				'cr_en'=> $this->input->post('cr_en'),
                    'capital' => is_float($this->input->post('capital'))?$this->input->post('capital'):0,
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
                    'governorate_id' => $this->input->post('governorate_id'),
                    'district_id' => $this->input->post('district_id'),
                    'x_location' => $this->input->post('x_location'),
                    'y_location' => $this->input->post('y_location'),
                    'sales_man_id' => $this->input->post('sales_man_id'),
                    'beside_en' => $this->input->post('beside_en'),
                    'beside_ar' => $this->input->post('beside_ar'),
                    'copy_res' => $this->input->post('copy_res'),
                    'is_adv' => $this->input->post('is_adv'),
                    'adv_pic' => $this->input->post('adv_pic'),
                    'activities' => $activities,
                    'activity_other_ar' => $this->input->post('activity_other_ar'),
                    'activity_other_en' => $this->input->post('activity_other_en'),
                    'entry_date' => valid_date($this->input->post('entry_date')),
                    'rep_person_ar' => $this->input->post('rep_person_ar'),
                    'rep_person_en' => $this->input->post('rep_person_en'),
                    'position_id' => $this->input->post('position_id'),
                    'ref' => $this->input->post('ref'),
                    'personal_notes' => $this->input->post('personal_notes'),
                    'display_directory' => $this->input->post('display_directory'),
                    'directory_interested' => $this->input->post('directory_interested'),
                    'display_exhibition' => $this->input->post('display_exhibition'),
                    'exhibition_interested' => $this->input->post('exhibition_interested'),
                    'address2_ar' => $this->input->post('address2_ar'),
                    'address2_en' => $this->input->post('address2_en'),
                    'online' => $this->input->post('online'),
                    'create_time' => date('Y-m-d H:i:s'),
                    'update_time' => date('Y-m-d H:i:s'),
                    'status' => $status,
                    'user_id' => $this->session->userdata('id'),
            );

            if($id = $this->General->save($this->tbl_insurance, $data)) {
                $this->session->set_userdata(array('admin_message' => 'Insurance Company Added successfully'));
                redirect('insurances/details/'.$id);
            }
            else {
                $this->session->set_userdata(array('admin_message' => 'Error'));
                redirect('insurances/create');
            }
        }
        /*         * ********************General Info*********************** */
        $this->data['c_id'] = '';
        $this->data['name_ar'] = '';
        $this->data['name_en'] = '';
        $this->data['cr_ar'] = '';
        $this->data['cr_en'] = '';
        $this->data['capital'] = '';
        $this->data['ins_number'] = '';
        $this->data['ins_ecoo_no'] = '';
        $this->data['manager_ar'] = '';
        $this->data['manager_en'] = '';
        $this->data['chairman_ar'] = '';
        $this->data['chairman_en'] = '';
        $this->data['trade_license'] = '';
        $this->data['license_source_id'] = '';


        $this->data['activities_data'] = array();
        $this->data['activity_other_ar'] = '';
        $this->data['activity_other_en'] = '';

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

        /*         * ***********************Molhak***************** */
        $this->data['rep_person_ar'] = '';
        $this->data['rep_person_en'] = '';
        $this->data['position_id'] = '';
        $this->data['sales_man_id'] = 0;
        $this->data['online'] = 1;
        $this->data['is_adv'] = 0;
        $this->data['adv_pic'] = '';
        $this->data['copy_res'] = 0;
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['districts'] = array();
        $this->data['areas'] = array();

        $this->data['display_directory'] = '';
        $this->data['directory_interested'] = '';
        $this->data['display_exhibition'] = '';
        $this->data['exhibition_interested'] = '';

        $this->data['activities'] = $this->Insurance->GetInsuranceActivities('online');
        $this->data['sales'] = $this->Company->GetSalesMen();
        $this->data['license_sources'] = $this->Company->GetLicenseSources();
        $this->data['positions'] = $this->Company->GetPositions();

        $this->data['subtitle'] = 'Add New Insurance Company';
        $this->data['title'] = $this->data['Ctitle']."- Add New Insurance Company";
        $this->template->load('_template', 'insurance/insurance_form', $this->data);
    }

    public function edit($id) {
        $this->data['nave'] = TRUE;
        $row = $this->Insurance->GetInsuranceById($id);
        $this->data['query'] = $row;
        $this->data['id'] = $id;
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Insurance Companies', 'insurances');
        $this->breadcrumb->add_crumb($row['name_en'], 'insurances/details/'.$id);
        $this->breadcrumb->add_crumb('Edit Insurance Company');

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
            if(is_array($activities_array))
            {
            $activities = implode(',', $activities_array);
            }
            else{
               $activities= $activities_array;
            }
           
            //$msg=$array['error'];
            $status = $this->input->post('status');
            if($status == '') {
                $status = 'online';
            }

            $x1 = $this->input->post('x1');
            $x2 = $this->input->post('x2');
            $x3 = $this->input->post('x3');
            $x = $x1.'°'.$x2."'".$x3.'"';

            $y1 = $this->input->post('y1');
            $y2 = $this->input->post('y2');
            $y3 = $this->input->post('y3');
            $y = $y1.'°'.$y2."'".$y3.'"';

            $data = array(
                    'name_en' => $this->input->post('name_en'),
                    'name_ar' => $this->input->post('name_ar'),
                    'ins_number' => $this->input->post('ins_number'),
                    'ins_ecoo_no' => $this->input->post('ins_ecoo_no'),
                    'manager_ar' => $this->input->post('manager_ar'),
                    'manager_en' => $this->input->post('manager_en'),
                    'chairman_ar' => $this->input->post('chairman_ar'),
                    'chairman_en' => $this->input->post('chairman_en'),
                    'trade_license' => $this->input->post('trade_license'),
                    'license_source_id' => $this->input->post('license_source_id'),
                    //'cr_ar'=> $this->input->post('cr_ar'),
                    //'cr_en'=> $this->input->post('cr_en'),
                    'capital' => $this->input->post('capital'),
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
                    'governorate_id' => $this->input->post('governorate_id'),
                    'district_id' => $this->input->post('district_id'),
                    'x_location' => $this->input->post('x_location'),
                    'y_location' => $this->input->post('y_location'),
                    'sales_man_id' => $this->input->post('sales_man_id'),
                    'beside_en' => $this->input->post('beside_en'),
                    'beside_ar' => $this->input->post('beside_ar'),
                    'copy_res' => $this->input->post('copy_res'),
                    'is_adv' => $this->input->post('is_adv'),
                    'adv_pic' => $this->input->post('adv_pic'),
                    'activities' => $activities,
                    'activity_other_ar' => $this->input->post('activity_other_ar'),
                    'activity_other_en' => $this->input->post('activity_other_en'),
                    'entry_date' =>valid_date($this->input->post('entry_date')),
                    'rep_person_ar' => $this->input->post('rep_person_ar'),
                    'rep_person_en' => $this->input->post('rep_person_en'),
                    'position_id' => $this->input->post('position_id'),
                    'ref' => $this->input->post('ref'),
                    'personal_notes' => $this->input->post('personal_notes'),
                    'display_directory' => $this->input->post('display_directory'),
                    'directory_interested' => $this->input->post('directory_interested'),
                    'display_exhibition' => $this->input->post('display_exhibition'),
                    'exhibition_interested' => $this->input->post('exhibition_interested'),
                    'address2_ar' => $this->input->post('address2_ar'),
                    'address2_en' => $this->input->post('address2_en'),
                    'update_time' => date('Y-m-d H:i:s'),
                    //'status' => $status,
                    'user_id' => $this->session->userdata('id'),
            );

            if($this->Administrator->edit($this->tbl_insurance, $data, $id)) {
                $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $row['name_ar'], 'type' => 'insurance', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);

                $this->session->set_userdata(array('admin_message' => 'Insurance Company Updated successfully'));
                redirect('insurances/details/'.$id);
            }
            else {
                $this->session->set_userdata(array('admin_message' => 'Error'));
                redirect('insurances/edit/'.$id);
            }
        }
        $this->data['c_id'] = $row['id'];
        $this->data['name_ar'] = $row['name_ar'];
        $this->data['name_en'] = $row['name_en'];
        $this->data['cr_ar'] = $row['cr_ar'];
        $this->data['cr_en'] = $row['cr_en'];
        $this->data['capital'] = $row['capital'];
        $this->data['ins_number'] = $row['ins_number'];
        $this->data['ins_ecoo_no'] = $row['ins_ecoo_no'];
        $this->data['manager_ar'] = $row['manager_ar'];
        $this->data['manager_en'] = $row['manager_en'];
        $this->data['chairman_ar'] = $row['chairman_ar'];
        $this->data['chairman_en'] = $row['chairman_en'];

        $this->data['trade_license'] = $row['trade_license'];
        $this->data['license_source_id'] = $row['license_source_id'];

        $activities_data = explode(',', $row['activities']);
        $this->data['activities_data'] = $activities_data;
        $this->data['activity_other_ar'] = $row['activity_other_ar'];
        $this->data['activity_other_en'] = $row['activity_other_en'];

        $this->data['personal_notes'] = $row['personal_notes'];

        /*         * ********************Address*********************** */
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
        /*         * ***********************End Address***************** */

        /*         * ***********************Molhak***************** */
        $this->data['rep_person_ar'] = $row['rep_person_ar'];
        $this->data['rep_person_en'] = $row['rep_person_en'];
        $this->data['position_id'] = $row['position_id'];

        $this->data['sales_man_id'] = $row['sales_man_id'];
        $this->data['status'] = $row['status'];
        $this->data['is_adv'] = $row['is_adv'];
        $this->data['adv_pic'] = $row['adv_pic'];
        $this->data['copy_res'] = $row['copy_res'];
        $this->data['online'] = $row['online'];

        $this->data['display_directory'] = $row['display_directory'];
        $this->data['directory_interested'] = $row['directory_interested'];
        $this->data['display_exhibition'] = $row['display_exhibition'];
        $this->data['exhibition_interested'] = $row['exhibition_interested'];
        $this->data['address2_ar'] = $row['address2_ar'];
        $this->data['address2_en'] = $row['address2_en'];
        $this->data['ref'] = $row['ref'];

        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', $row['governorate_id']);
        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', $row['district_id']);

        $this->data['activities'] = $this->Insurance->GetInsuranceActivities('online');
        $this->data['sales'] = $this->Company->GetSalesMen();

        $this->data['license_sources'] = $this->Company->GetLicenseSources();
        $this->data['positions'] = $this->Company->GetPositions();

        $this->data['subtitle'] = 'Add New Insurance Company';
        $this->data['title'] = $this->data['Ctitle']."- Add New Insurance Company";
        $this->template->load('_template', 'insurance/insurance_form', $this->data);
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
	public function others()
	{
		header('Content-Type: text/html; charset=utf-8');
		$query = $this->Insurance->GetOthersInsurance();
		echo '<h3>'.count($query).'</font>';
		echo '<table border="1" style="border:1px solid #000;">';
		echo '<tr><td>ID</td><td>Company</td><td>Activity in arabic</td><td>Activity in english</td></tr>';
		foreach($query as $row){
			echo '<tr><td>'.$row->id.'</td><td>'.$row->name_ar.'</td><td>'.$row->activity_other_ar.'</td><td>'.$row->activity_other_en.'</td></tr>';
			
			}
		echo '</table>';
		}

}
?>