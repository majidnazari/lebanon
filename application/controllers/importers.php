<?php

class Importers extends Application {
    var $p_delete = FALSE;
    var $p_edit = FALSE;
    var $p_add = FALSE;
    var $p_view = FALSE;
    var $p_foreign_companies = FALSE;
    var $page_denied = '';

    public function __construct() {

        parent::__construct();
        $this->ag_auth->restrict('imports'); // restrict this controller to admins only
        $this->load->model(array('Administrator', 'Item', 'Address', 'Importer', 'Company'));
        $this->data['Ctitle'] = 'Industry - Importers';
        $this->p_view = $this->ag_auth->check_privilege(14, 'view');
        $this->p_delete = $this->ag_auth->check_privilege(14, 'delete');
        $this->p_edit = $this->ag_auth->check_privilege(14, 'edit');
        $this->p_foreign_companies = $this->ag_auth->check_privilege(14, 'foreign_companies');
        $this->p_add = $this->ag_auth->check_privilege(16, 'add');
        $this->data['p_delete'] = $this->p_delete;
        $this->data['p_edit'] = $this->p_edit;
        $this->data['p_add'] = $this->p_add;
        $this->data['p_view'] = $this->p_view;
        $this->data['p_foreign_companies'] = $this->p_foreign_companies;
		
		 $this->data['p_activities'] = $this->p_activities = $this->ag_auth->check_privilege(74, 'view');
         $this->data['p_delete_activity'] = $this->p_delete_activity = $this->ag_auth->check_privilege(74, 'delete');
         $this->data['p_edit_activity'] = $this->p_edit_activity = $this->ag_auth->check_privilege(74, 'edit');
         $this->data['p_add_activity'] = $this->p_add_activity = $this->ag_auth->check_privilege(74, 'add');
    }

    public function convertlocation() {
        die;
        $query = $this->Importer->GetImporters('', 0, 0);
        foreach($query as $row) {
            $array = array(
                    'x_location' => $this->Administrator->Degree2Decimal($row->x_location),
                    'y_location' => $this->Administrator->Degree2Decimal($row->y_location),
                    'x_old' => $row->x_location,
                    'y_old' => $row->y_location,
            );
            $this->Administrator->edit('tbl_importers', $array, $row->id);
        }
    }

    public function remove($id) {
        $this->Administrator->edit('tbl_importers', array('adv_pic' => ''), $id);
        $this->session->set_userdata(array('admin_message' => 'Image Deleted'));
        redirect('importers/details/'.$id);
    }

    public function editimage() {
        if(isset($_POST)) {
            $id = $this->input->post('editimageid');
            $array = $this->Administrator->do_upload('uploads/', 'adimage');

            if($array['target_path'] != "") {
                $path = $array['target_path'];
                $this->Administrator->edit('tbl_importers', array('adv_pic' => $path), $id);
            }
            $msg = $array['error'];
            $this->session->set_userdata(array('admin_message' => $msg));
            redirect('importers/details/'.$id);
        }
    }

    public function change_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $this->Administrator->edit('tbl_importers', array('online' => $status), $id);
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
        $areas = $this->Importer->GetAreaByDistrict('online', $dist_id);
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

    public function delete() {
        $get = $this->uri->ruri_to_assoc();
        if((int)$get['id'] > 0) {
            switch($get['p']) {
                case 'importer':
                    if($this->p_delete) {
                        $query = $this->Importer->GetImporterById($get['id']);
                        $history = array('action' => 'delete', 'logs_id' => 0, 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'importer', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $h_id = $this->General->save('logs', $history);

                        $foreign = $this->Importer->GetForeignCompanies($get['id']);
                        $history_foreign = array('logs_id' => $h_id, 'action' => 'delete', 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'importer_foreigns', 'details' => json_encode($foreign), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history_foreign);

                        $this->General->delete('tbl_importer_foreign_companies', array('importer_id' => $get['id']));
                        $this->General->delete('tbl_importers', array('id' => $get['id']));

                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('importers');
                    }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;

                case 'foreign':
                    if($this->p_foreign_companies) {
                        $query = $this->Importer->GetForeignCompanyById($get['id']);
                        $history = array('action' => 'delete', 'logs_id' => 0, 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'importer_foreigns', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $h_id = $this->General->save('logs', $history);

                        $this->General->delete('tbl_importer_foreign_companies', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('importers/details/'.$get['imp']);
                    }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;
					 case 'activity':
                    if($this->p_delete_activity) {
                        $query = $this->Importer->GetActivityById($get['id']);
                        $history = array('action' => 'delete', 'logs_id' => 0, 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'importer_activity', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $h_id = $this->General->save('logs', $history);

                        $this->General->delete('tbl_importer_activities', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('importers/activities/');
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
            //if(isset($this->input->post('p')))
            switch($this->input->post('p')) {
                case 'company':
                    foreach($delete_array as $d_id) {
                        $this->General->delete($this->company, array('id' => $d_id));
                    }
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('companies/'.$get['st']);

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
  public function activities() {
        if($this->p_activities) {
       		$this->data['query'] = $query=$this->Importer->GetImporterActivities('online');
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Importers','importers');
            $this->breadcrumb->add_crumb('Importer Activities');
            $this->data['subtitle'] = 'Importer Activities';
            $this->data['query'] = $query;
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['title'] = $this->data['Ctitle']." | Importer Activities";
            $this->template->load('_template', 'importer/activities', $this->data);
        }
        else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function activity_add() {
        if($this->p_add_activity) {
            $label_ar = $this->input->post('label_ar');
            $label_en = $this->input->post('label_en');
			$status = $this->input->post('status');

            $data = array(
                    'label_ar' => $label_ar,
                    'label_en' => $label_en,
					'status' => $status,
                    'create_time' => date('Y-m-d H:i:s'),
                    'update_time' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('id'),
            );

            if($id = $this->General->save('tbl_importer_activities', $data)) {
                $history = array('action' => 'add', 'logs_id' => 0, 'type' => 'importer_activity', 'details' => json_encode($data), 'item_id' => $id, 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);
                $this->session->set_userdata(array('admin_message' => 'Add Successfully'));
                redirect('importers/activities/');
            }
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function activity_edit() {
        if($this->p_edit_activity) {
            $label_ar = $this->input->post('label_ar');
            $label_en = $this->input->post('label_en');
            $id = $this->input->post('id');
			$status = $this->input->post('status');

            $data = array(
                    'label_ar' => $label_ar,
                    'label_en' => $label_en,
					'status' => $status,
                    'update_time' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('id'),
            );
            $query = $this->Importer->GetActivityById($id);
            if($this->Administrator->edit('tbl_importer_activities', $data, $id)) {
                $newdata = $this->Administrator->affected_fields($query, $data);
                $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $query['label_ar'], 'type' => 'importer_activity', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $LID = $this->General->save('logs', $history);
                $this->session->set_userdata(array('admin_message' => 'Updated Successfully'));

               redirect('importers/activities/');
            }
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
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

                $query = $this->Importer->SearchImporters($id, $name, $phone, $status, $govID, $districtID,$areaID, $row, $limit);
                //var_dump($query);
                $total_row = count($this->Importer->SearchImporters($id, $name, $phone, $status, $govID, $districtID,$areaID, 0, 0));
                $config['base_url'] = base_url().'importers?id='.$id.'&name='.$name.'&phone='.$phone.'&gov='.$govID.'&district_id='.$districtID.'&area_id='.$areaID.'&status='.$status.'&search=Search';

                $config['enable_query_strings'] = TRUE;
                $config['page_query_string'] = TRUE;
            }
            elseif(isset($_GET['clear'])) {
                redirect('importers/');
            }
            else {
                $limit = 20;
                $govID = 0;
                $districtID = 0;
                $status = '';
                $config['base_url'] = base_url().'importers/index';
                //$config['uri_segment'] = 12;
                $query = $this->Importer->GetImporters('', $row, $limit);

                $total_row = count($this->Importer->GetImporters('', 0, 0));

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
            $this->breadcrumb->add_crumb('Importers');
            $this->data['title'] = $this->data['Ctitle']." - Importers - المستوردون";
            $this->data['subtitle'] = "Importers - المستوردون";
            $this->data['districts'] = $this->Address->GetDistrictByGov('online', $this->data['govID']);
            $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
            $this->data['areas'] = $this->Importer->GetAreaByDistrict('online', @$districtID);
            $this->template->load('_template', 'importer/index', $this->data);
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
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
        $query = $this->Importer->SearchImporters($id, $name, $phone, $status, $gov, $district_id,$area_id, 0, 0);
        foreach($query as $row) {
            $this->view($row->id);

        }
    }
    public function listview() {
        $id=$this->input->get('id');
        $name=$this->input->get('name');
        $phone=$this->input->get('phone');
        $gov=$this->input->get('gov');
        $district_id=$this->input->get('district_id');
        $area_id=$this->input->get('area_id');
        $status=$this->input->get('status');
        $this->data['query'] = $this->Importer->SearchImporters($id, $name, $phone, $status, $gov, $district_id,$area_id, 0, 0);
        $this->data['title'] = $this->data['Ctitle']." - Companies - الشركات";
        ;
        $this->data['subtitle'] = "Companies - الشركات";
        $this->load->view('importer/listview', $this->data);
    }
    public function reservations($row = 0) {
        $this->data['search'] = FALSE;
        if($this->p_view) {

            $limit = 20;
            $config['base_url'] = base_url().'importers/reservations';
            //$config['uri_segment'] = 12;
            $query = $this->Importer->GetImportersS(1, '', $row, $limit);
            $total_row = count($this->Importer->GetImportersS(1, '', 0, 0));
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
            $this->breadcrumb->add_crumb('Importers');
            $this->data['title'] = $this->data['Ctitle']." - Importers - المستوردون";
            $this->data['subtitle'] = "شركات الاستيراد الحاجزة نسخة";
            $this->template->load('_template', 'importer/index', $this->data);
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function advertising($row = 0) {
        $this->data['search'] = FALSE;
        if($this->p_view) {

            $limit = 20;
            $config['base_url'] = base_url().'importers/advertising';
            //$config['uri_segment'] = 12;
            $query = $this->Importer->GetImportersS('', 1, $row, $limit);
            $total_row = count($this->Importer->GetImportersS('', 1, 0, 0));
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
            $this->breadcrumb->add_crumb('Importers');
            $this->data['title'] = $this->data['Ctitle']." - Importers - المستوردون";
            $this->data['subtitle'] = "شركات الاستيراد المعلنين";
            $this->template->load('_template', 'importer/index', $this->data);
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function search($row = 0) {

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

        $filename = "importer-" . $id . ".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');


        $query = $this->Importer->GetImporterById($id);
        $ids = explode(',', $query['activities']);
        $this->data['query'] = $query;
        $this->data['governorates'] = $this->Address->GetGovernorateById($query['governorate_id']);
        $this->data['districts'] = $this->Address->GetDistrictById($query['district_id']);
        $this->data['area'] = $this->Address->GetAreaById($query['area_id']);
        $this->data['activities'] = $this->Importer->GetActivitiesByIds($ids);

        $this->data['salesman'] = $this->General->GetSalesManById($query['sales_man_id']);
        $this->data['position'] = $this->Item->GetPositionById($query['position_id']);
        $this->data['fcompanies'] = $this->Importer->GetForeignCompanies($id);

        $this->load->view('importer/application_view', $this->data);

    }
    public function details($id) {
        if($this->p_view) {
            $query = $this->Importer->GetImporterById($id);
            $ids = explode(',', $query['activities']);
            $this->data['query'] = $query;
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Importer');
            $this->data['title'] = $this->data['Ctitle']." - Importer - المستوردون";
            ;
            $this->data['subtitle'] = "Importers - المستوردون";
            $this->data['governorates'] = $this->Address->GetGovernorateById($query['governorate_id']);
            $this->data['districts'] = $this->Address->GetDistrictById($query['district_id']);
            $this->data['area'] = $this->Address->GetAreaById($query['area_id']);
            $this->data['activities'] = $this->Importer->GetActivitiesByIds($ids);
            $this->data['salesman'] = $this->Company->GetSalesMan($query['sales_man_id']);
            $this->data['fcompanies'] = $this->Importer->GetForeignCompanies($id);
            $this->data['id'] = $id;
            $this->data['position'] = $this->Item->GetPositionById($query['position_id']);
            $this->template->load('_template', 'importer/details', $this->data);
        }
        else {
            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect($this->page_denied);
        }
    }

    public function view($id) {
        $query = $this->Importer->GetImporterById($id);
        $this->data['query'] = $query;
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->data['title'] = $query['name_en']." - ".$query['name_ar'];
        $this->data['subtitle'] = "Companies - الشركات";
        $this->data['activities'] = $this->Importer->GetImporterActivities();
        $this->data['governorates'] = $this->Address->GetGovernorateById($query['governorate_id']);
        $this->data['districts'] = $this->Address->GetDistrictById($query['district_id']);
        $this->data['area'] = $this->Address->GetAreaById($query['area_id']);
        $this->data['salesman'] = $this->General->GetSalesManById($query['sales_man_id']);
        $this->data['fcompanies'] = $this->Importer->GetForeignCompanies($id);
        $this->data['position'] = $this->Item->GetPositionById($query['position_id']);
        $this->load->view('importer/view', $this->data);
    }

    public function printall() {
        $ids = $this->input->post('checkbox1');

        foreach($ids as $id) {
            $this->view($id);
        }
    }

    public function foreign_companies($id) {
        $query = $this->Importer->GetImporterById($id);
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Importers', 'importers');
        $this->breadcrumb->add_crumb($query['name_en'], 'importers/details/'.$id);
        $this->breadcrumb->add_crumb('Foreign Companies Represented in Lebanon');
        $this->breadcrumb->add_crumb('Add New');

        $this->form_validation->set_rules('name_ar', 'name_ar', 'required');
        $this->form_validation->set_rules('name_en', 'name_en', 'required');
        $this->form_validation->set_rules('address_ar', 'address_ar', 'trim');
        $this->form_validation->set_rules('address_en', 'address_en', 'trim');
        $this->form_validation->set_rules('items_ar', 'items_ar', 'trim');
        $this->form_validation->set_rules('items_en', 'items_en', 'trim');
        $this->form_validation->set_rules('trade_mark_ar', 'trade_mark_ar', 'trim');
        $this->form_validation->set_rules('trade_mark_en', 'trade_mark_en', 'trim');

        if($this->form_validation->run()) {

            $data = array(
                    'importer_id' => $id,
                    'name_ar' => $this->form_validation->set_value('name_ar'),
                    'name_en' => $this->form_validation->set_value('name_en'),
                    'address_ar' => $this->form_validation->set_value('address_ar'),
                    'address_en' => $this->form_validation->set_value('address_en'),
                    'items_ar' => $this->form_validation->set_value('items_ar'),
                    'items_en' => $this->form_validation->set_value('items_en'),
                    'trade_mark_ar' => $this->form_validation->set_value('trade_mark_ar'),
                    'trade_mark_en' => $this->form_validation->set_value('trade_mark_en'),
                    'create_time' => date('Y-m-d H:i:s'),
                    'update_time' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('id'),
            );

            if($nid = $this->General->save('tbl_importer_foreign_companies', $data)) {
                $history = array('action' => 'add', 'logs_id' => 0, 'item_id' => $nid, 'item_title' => $data['name_ar'], 'type' => 'importer_foreigns', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);
                $this->session->set_userdata(array('admin_message' => 'Prodduction Added successfully'));
                redirect('importers/foreign-companies/'.$id);
            }
            else {
                $this->session->set_userdata(array('admin_message' => 'Error'));
                redirect('importers/foreign-companies/'.$id);
            }
        }
        $this->data['id'] = $id;

        $this->data['subtitle'] = 'Add New ';
        $this->data['title'] = $this->data['Ctitle']."- Add New";
        $this->data['fcompanies'] = $this->Importer->GetForeignCompanies($id);
        $this->template->load('_template', 'importer/foreign_companies_form', $this->data);
    }

    public function update($fid, $id) {
        $query = $this->Importer->GetImporterById($id);
        $row = $this->Importer->GetForeignCompanyById($fid);
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Importers', 'importers');
        $this->breadcrumb->add_crumb($query['name_en'], 'importers/details/'.$id);
        $this->breadcrumb->add_crumb('Foreign Companies Represented in Lebanon');
        $this->breadcrumb->add_crumb('Edit');

        $this->form_validation->set_rules('name_ar', 'name_ar', 'required');
        $this->form_validation->set_rules('name_en', 'name_en', 'required');
        $this->form_validation->set_rules('address_ar', 'address_ar', 'trim');
        $this->form_validation->set_rules('address_en', 'address_en', 'trim');
        $this->form_validation->set_rules('items_ar', 'items_ar', 'trim');
        $this->form_validation->set_rules('items_en', 'items_en', 'trim');
        $this->form_validation->set_rules('trade_mark_ar', 'trade_mark_ar', 'trim');
        $this->form_validation->set_rules('trade_mark_en', 'trade_mark_en', 'trim');

        if($this->form_validation->run()) {

            $data = array(
                    'importer_id' => $id,
                    'name_ar' => $this->form_validation->set_value('name_ar'),
                    'name_en' => $this->form_validation->set_value('name_en'),
                    'address_ar' => $this->form_validation->set_value('address_ar'),
                    'address_en' => $this->form_validation->set_value('address_en'),
                    'items_ar' => $this->form_validation->set_value('items_ar'),
                    'items_en' => $this->form_validation->set_value('items_en'),
                    'trade_mark_ar' => $this->form_validation->set_value('trade_mark_ar'),
                    'trade_mark_en' => $this->form_validation->set_value('trade_mark_en'),
                    'update_time' => date('Y-m-d H:i:s'),
            );

            if($nid = $this->Administrator->edit('tbl_importer_foreign_companies', $data, $fid)) {
                $data['id'] = $fid;
                $newdata = $this->Administrator->affected_fields($row, $data);
                $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $row['name_ar'], 'type' => 'importer_foreigns', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);
                $this->session->set_userdata(array('admin_message' => 'Updated successfully'));
                redirect('importers/foreign-companies/'.$id);
            }
            else {
                $this->session->set_userdata(array('admin_message' => 'Error'));
                redirect('importers/foreign-companies/'.$id);
            }
        }
        $this->data['id'] = $id;
        $this->data['name_ar'] = $row['name_ar'];
        $this->data['name_en'] = $row['name_en'];
        $this->data['address_ar'] = $row['address_ar'];
        $this->data['address_en'] = $row['address_en'];
        $this->data['items_ar'] = $row['items_ar'];
        $this->data['items_en'] = $row['items_en'];
        $this->data['trade_mark_ar'] = $row['trade_mark_ar'];
        $this->data['trade_mark_en'] = $row['trade_mark_en'];

        $this->data['subtitle'] = 'Edit ';
        $this->data['title'] = $this->data['Ctitle']."- Edit";
		$this->data['fcompanies'] = $this->Importer->GetForeignCompanies($id);
        $this->template->load('_template', 'importer/foreign_companies_form', $this->data);
    }

    public function create() {
        $this->data['nave'] = FALSE;
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Importers', 'importers');
        $this->breadcrumb->add_crumb('Add New Importer');

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
            $activities = implode(',', $activities_array);

            //$msg=$array['error'];
            $status = $this->input->post('status');
            if($status == '') {
                $status = 1;
            }
            /*
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
                    'address2_ar' => $this->input->post('address2_ar'),
                    'address2_en' => $this->input->post('address2_en'),
                    'email' => $this->input->post('email'),
                    'website' => $this->input->post('website'),
                    'governorate_id' => $this->input->post('governorate_id'),
                    'district_id' => $this->input->post('district_id'),
                    'x_location' => $this->input->post('x_location'),
                    'y_location' => $this->input->post('y_location'),
                    'sales_man_id' => $this->input->post('sales_man_id'),
                    'beside_en' => $this->input->post('beside_en'),
                    'beside_ar' => $this->input->post('beside_ar'),
                    'copy_reservation' => $this->input->post('copy_res'),
                    'is_adv' => $this->input->post('is_adv'),
                    'adv_pic' => $this->input->post('adv_pic'),
                    'activities' => $activities,
                    'app_refill_date' => valid_date($this->input->post('app_refill_date')),
                    'activity_other_en' => $this->input->post('activity_other_en'),
                    'activity_other_ar' => $this->input->post('activity_other_ar'),
                    'res_person_ar' => $this->input->post('res_person_ar'),
                    'res_person_en' => $this->input->post('res_person_en'),
                    'position_id' => $this->input->post('position_id'),
                    'ref' => $this->input->post('ref'),
                    'personal_notes' => $this->input->post('personal_notes'),
                    'display_directory' => ($this->input->post('display_directory') != false) ? 1 : 0,
                    'directory_interested' => $this->input->post('directory_interested'),
                    'display_exhibition' => ($this->input->post('display_exhibition') != false) ? 1 : 0,
                    'exhibition_interested' => $this->input->post('exhibition_interested'),
                    'create_time' => date('Y-m-d H:i:s'),
                    'update_time' => date('Y-m-d H:i:s'),
                    'online' => $status,
                    'user_id' => $this->session->userdata('id'),
            );

            if($id = $this->General->save('tbl_importers', $data)) {
                $history = array('action' => 'add', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $data['name_ar'], 'type' => 'importer', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);
                $this->session->set_userdata(array('admin_message' => 'Importer Added successfully'));
                redirect('importers/details/'.$id);
            }
            else {
                $this->session->set_userdata(array('admin_message' => 'Error'));
                redirect('importers/create');
            }
        }
        /*         * ********************General Info*********************** */
        $this->data['c_id'] = '';
        $this->data['name_ar'] = '';
        $this->data['name_en'] = '';
        $this->data['owner_ar'] = '';
        $this->data['owner_en'] = '';
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

        /*         * ***********************Molhak***************** */
        $this->data['res_person_ar'] = '';
        $this->data['res_person_en'] = '';
        $this->data['sales_man_id'] = 0;
        $this->data['status'] = 1;
        $this->data['is_adv'] = 0;
        $this->data['adv_pic'] = '';
        $this->data['copy_res'] = 0;
        $this->data['app_refill_date'] = '';
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['districts'] = array();
        $this->data['areas'] = array();

        $this->data['activities'] = $this->Importer->GetImporterActivities('online');

        $this->data['sales'] = $this->Company->GetSalesMen();
        $this->data['positions'] = $this->Company->GetPositions();

        $this->data['subtitle'] = 'Add New Importer';
        $this->data['title'] = $this->data['Ctitle']."- Add New Importer";
        $this->template->load('_template', 'importer/importer_form', $this->data);
    }

    public function edit($id) {
        $this->data['nave'] = TRUE;

        $row = $this->Importer->GetImporterById($id);
        $this->data['query'] = $row;
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Importers', 'importers');
        $this->breadcrumb->add_crumb($row['name_en'], 'importers/details/'.$id);
        $this->breadcrumb->add_crumb('Edit Importer');

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
            /*
              $x1=$this->input->post('x1');
              $x2=$this->input->post('x2');
              $x3=$this->input->post('x3');
              $x=$x1.'°'.$x2."'".$x3.'"';

              $y1=$this->input->post('y1');
              $y2=$this->input->post('y2');
              $y3=$this->input->post('y3');
              $y=$y1.'°'.$y2."'".$y3.'"';
             */
            $activities_array = $this->input->post('activities');
            $activities = implode(',', $activities_array);
            //	$msg=$array['error'];
            $status = $this->input->post('status') ?  $this->input->post('status') : 0;
           

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
                    'governorate_id' => $this->input->post('governorate_id'),
                    'district_id' => $this->input->post('district_id'),
                    'x_location' => $this->input->post('x_location'),
                    'y_location' => $this->input->post('y_location'),
                    'sales_man_id' => $this->input->post('sales_man_id'),
                    'beside_en' => $this->input->post('beside_en'),
                    'beside_ar' => $this->input->post('beside_ar'),
                    'copy_reservation' => $this->input->post('copy_res'),
                    'is_adv' => $this->input->post('is_adv'),
                    'adv_pic' => $this->input->post('adv_pic'),
                    'activities' => $activities,
                    'activity_other_en' => $this->input->post('activity_other_en'),
                    'activity_other_ar' => $this->input->post('activity_other_ar'),
                    'app_refill_date' => valid_date($this->input->post('app_refill_date')),
                    'res_person_ar' => $this->input->post('res_person_ar'),
                    'res_person_en' => $this->input->post('res_person_en'),
                    'position_id' => $this->input->post('position_id'),
                    'ref' => $this->input->post('ref'),
                    'personal_notes' => $this->input->post('personal_notes'),
                    'display_directory' => ($this->input->post('display_directory') != false) ? 1 : 0,
                    'directory_interested' => $this->input->post('directory_interested'),
                    'display_exhibition' => ($this->input->post('display_exhibition') != false) ? 1 : 0,
                    'exhibition_interested' => $this->input->post('exhibition_interested'),
                    'address2_ar' => $this->input->post('address2_ar'),
                    'address2_en' => $this->input->post('address2_en'),
                    'update_time' => date('Y-m-d H:i:s'),
                    'online' => $status,
                    'user_id' => $this->session->userdata('id'),
            );

            if($this->Administrator->edit('tbl_importers', $data, $id)) {
                $newdata = $this->Administrator->affected_fields($row, $data);
                $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $row['name_ar'], 'type' => 'importer', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);
                $this->session->set_userdata(array('admin_message' => 'Importer Updated successfully'));
                redirect('importers/details/'.$id);
            }
            else {
                $this->session->set_userdata(array('admin_message' => 'Error'));
                redirect('importers/edit/'.$id);
            }
        }
        $this->data['c_id'] = $row['id'];
        $this->data['id'] = $row['id'];
        $this->data['name_ar'] = $row['name_ar'];
        $this->data['name_en'] = $row['name_en'];
        $this->data['owner_ar'] = $row['owner_ar'];
        $this->data['owner_en'] = $row['owner_en'];

        $activities_data = explode(',', $row['activities']);
        $this->data['activities_data'] = $activities_data;

        $this->data['personal_notes'] = $row['personal_notes'];

        $this->data['activity_other_en'] = $row['activity_other_en'];
        $this->data['activity_other_ar'] = $row['activity_other_ar'];
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
        $this->data['res_person_ar'] = $row['res_person_ar'];
        $this->data['res_person_en'] = $row['res_person_en'];
        $this->data['position_id'] = $row['position_id'];

        $this->data['sales_man_id'] = $row['sales_man_id'];
        $this->data['status'] = $row['online'];
        $this->data['is_adv'] = $row['is_adv'];
        $this->data['adv_pic'] = $row['adv_pic'];
        $this->data['copy_res'] = $row['copy_reservation'];

        $this->data['app_refill_date'] = $row['app_refill_date'];

        $this->data['address2_ar'] = $row['address2_ar'];
        $this->data['address2_en'] = $row['address2_en'];
        $this->data['ref'] = $row['ref'];

        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', $row['governorate_id']);
        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', $row['district_id']);

        $this->data['activities'] = $this->Importer->GetImporterActivities('online');
        $this->data['sales'] = $this->Company->GetSalesMen();
        $this->data['positions'] = $this->Company->GetPositions();

        $this->data['subtitle'] = 'Edit Importer';
        $this->data['title'] = $this->data['Ctitle']."- Edit Importer";
        $this->template->load('_template', 'importer/importer_form', $this->data);
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

    public function matching() {
        die;
        $query = $this->Importer->GetImporters('', 0, 0);

        foreach($query as $row) {
            $activities = '';
            for($i = 1; $i <= 6; $i++) {
                $act = 'imp_activity_'.$i;
                if($row->$act == 1) {
                    $activities.=$i.',';
                }
            }
            $this->Administrator->edit('tbl_importers', array('activities' => rtrim($activities, ',')), $row->id);
            echo $row->id.' Activities : '.rtrim($activities, ',').'<br>';
        }
    }
	public function others()
	{
		header('Content-Type: text/html; charset=utf-8');
		$query = $this->Importer->GetOthersImporters();
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