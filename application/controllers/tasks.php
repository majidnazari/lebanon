<?php

class Tasks extends Application {
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
        $this->load->model(array('Administrator', 'Item', 'Address', 'Company', 'Task','Parameter'));
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

        $this->TasksConfig = array(
            array('field' => 'list_id', 'label' => 'List', 'rules' => 'trim'),
            array('field' => 'ref', 'label' => 'Ref', 'rules' => 'trim'),
            array('field' => 'company_id', 'label' => 'Company', 'rules' => 'trim'),
            array('field' => 'governorate_id', 'label' => 'Governorate', 'rules' => 'trim'),
            array('field' => 'district_id', 'label' => 'District', 'rules' => 'trim'),
            array('field' => 'area_id', 'label' => 'Area', 'rules' => 'trim'),
            array('field' => 'sales_man_id', 'label' => 'Sales man', 'rules' => 'required'),
            array('field' => 'year', 'label' => 'Year', 'rules' => 'trim'),
            array('field' => 'start_date', 'label' => 'Start date', 'rules' => 'required'),
            array('field' => 'due_date', 'label' => 'Due date', 'rules' => 'required'),
            array('field' => 'comments', 'label' => 'Comments', 'rules' => 'trim'),
            array('field' => 'status', 'label' => 'Status','rules' => 'trim'),
            array('field' => 'payment_status', 'label' => 'Payment status','rules' => 'trim'),
            array('field' => 'cost', 'label' => 'Cost','rules' => 'trim'),
        );
        $this->data['array_employees'] = $this->array_employees = array(
            '' => 'اختر',
            '1 - 10' => '1 - 10',
            '10 - 20' => '10 - 20',
            '20 - 30' => '20 - 30',
            '30 - 40' => '30 - 40',
            '40 - 50' => '40 - 50',
            '50 - 100' => '50 - 100',
            '100 - 200' => '100 - 200',

        );

    }
    private function DataArray($table, $data, $validation, $action, $data_id)
    {

        $array_result = array('update_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
        foreach ($validation as $key => $value) {
            $key1 = $value['field'];
            if (array_key_exists($key1, $data)) {
                $array_result[$key1] = $data[$key1];
            }

        }
        if ($action == 'add') {
            $array_result['create_time'] = $this->datetime;
            $id = $this->General->save($table, $array_result);
        } else {
            $id = $this->Administrator->edit($table, $array_result, $data_id);
        }
        return array('id' => $id, 'data' => $array_result);

    }
    public function GetCompanies()
    {
        $data = array();
        $query = $this->input->get('geocode');
        $q = $query['term'];
        $sql = $this->Task->GetCompaniesByKeyword($q);
        foreach ($sql as $row) {
            array_push($data, array('id' => $row->id, 'text' => $row->name_ar.' ('.$row->id.')'));
        }
        echo json_encode($data);
    }


    public function delete($id,$type) {
        if((int)$id > 0) {
            switch($type) {
                case 'company':
                    $this->General->delete('tbl_tasks', array('id' => $id));
                    $this->General->delete('tbl_task_logs', array('task_id' => $id));
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect($this->agent->referrer());
                    break;

            }
        }
    }
    public function delete_list($id,$type) {
        if((int)$id > 0) {
            switch($type) {
                case 'company':
                    $this->General->delete('tbl_tasks', array('id' => $id));
                    $this->General->delete('tbl_task_logs', array('task_id' => $id));
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect($this->agent->referrer());
                    break;

            }
        }
    }
    public function delete_all_list($id,$sales_man_id) {
        if((int)$id > 0) {
           
                    $this->General->delete('tbl_tasks', array('list_id' => $id,'sales_man_id'=>$sales_man_id));
                  //  $this->General->delete('tbl_task_logs', array('task_id' => $id));
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect($this->agent->referrer());
     

            
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
    public function print_all()
    { 
        $ref = $this->input->get('ref');
        $company_id = $this->input->get('company');
        $governorate_id = $this->input->get('governorate');
        $district_id = $this->input->get('district_id');
        $area_id = $this->input->get('area_id');
        $list = $this->input->get('list');
        $sales_man = $this->input->get('sales_man');
        $year = $this->input->get('year');
        $from_start = $this->input->get('from_start');
        $to_start = $this->input->get('to_start');
        $from_due = $this->input->get('from_due');
        $to_due = $this->input->get('to_due');
        $status = $this->input->get('status');
        $category = $this->input->get('category');
        $all = $this->Task->GetTasks(@$ref,@$company_id, @$governorate_id, @$district_id, @$area_id, @$list, @$sales_man, @$year, @$from_start,@$to_start, @$from_due, @$to_due,@$status,@$category, 0, 0,'');
        $query=$all['results'];
//var_dump($query);

        foreach($query as $row)
        {
            $this->view($row->company_id,$row->list_id);
        }


    }
    public function print_all_acc()
    {
        $company_id = $this->input->get('company');
        $governorate_id = $this->input->get('governorate');
        $district_id = $this->input->get('district_id');
        $area_id = $this->input->get('area_id');
        $list = $this->input->get('list');
        $sales_man = $this->input->get('sales_man');
        $year = $this->input->get('year');
        $from_start = $this->input->get('from_start');
        $to_start = $this->input->get('to_start');
        $from_due = $this->input->get('from_due');
        $to_due = $this->input->get('to_due');
        $status = $this->input->get('status');
        $category = $this->input->get('category');
        $companyID = $this->input->get('company_id');
        $query = $this->Task->GetAccCompaniesDetails($sales_man,$governorate_id,$district_id,$area_id,$status);
        //$query = $all['results'];
        foreach($query as $row)
        {
            $this->view($row->company_id,$list);
        }

    }
    public function exports() {

        // filename for download
        $filename = "exports-".time().".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
     //   header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        echo '<style type="text/css">
				tr, td, table, tr{
					border:1px solid #D0D0D0;
				}
				.yellow{
						background:#FF0 !important;
					}
					.bold{
						font-weight:bold !important;
					}
				</style>   ';
        $ref = $this->input->get('ref');
        $company_id = $this->input->get('company');
        $governorate_id = $this->input->get('governorate');
        $district_id = $this->input->get('district_id');
        $area_id = $this->input->get('area_id');
        $list = $this->input->get('list');
        $sales_man = $this->input->get('sales_man');
        $year = $this->input->get('year');
        $from_start = $this->input->get('from_start');
        $to_start = $this->input->get('to_start');
        $from_due = $this->input->get('from_due');
        $to_due = $this->input->get('to_due');
        $status = $this->input->get('status');
        $category = $this->input->get('category');
        $all = $this->Task->GetTasks(@$ref,@$company_id, @$governorate_id, @$district_id, @$area_id, @$list, @$sales_man, @$year, @$from_start,@$to_start, @$from_due, @$to_due,@$status,@$category, 0, 0);
        $query=$all['results'];


        echo '<table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                               <th>Company ID</th>
                                <th style="text-align:center"  width="10%">Company</th>
                                <th style="text-align:center"  width="15%">Sales Man </th>
                                <th style="text-align:center"  width="5%">List</th>
                                <th style="text-align:center" width="10%">Mohafaza </th>
                                <th style="text-align:center" width="10%">Kazaa</th>
                                <th style="text-align:center" width="10%">Area</th>
                                <th style="text-align:center"  width="10%">Start Date</th>
                                <th style="text-align:center" width="5%">Due Date</th>
                                <th style="text-align:center" width="5%">Delivery Date</th>
                                <th style="text-align:center" width="5%"> Status</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach($query as $row) {
                echo '<tr>
                                    <td style="text-align:right;">'.$row->company_id.'</td>
                                    <td style="direction:rtl !important; text-align:right !important;">'.$row->company_ar.'</td>
                                     <td>'.$row->sales_man_ar.'</td>
                                    <td>'.$row->list_id.'</td>
                                    <td>'.$row->governorate_ar.'</td>
                                    <td>'.$row->district_ar.'</td>
                                    <td>'.$row->area_ar.'</td>
                                    <td style="text-align:right;">'.$row->start_date.'</td>
                                    <td style="text-align:right;">'.$row->due_date.'</td>
                                   <td style="text-align:right;">'.$row->delivery_date.'</td>
                                   <td style="text-align:right;">'.$row->status.'</td>
                                </tr>';
            }

        echo '</tbody>';

        echo '</table>';

        //return $filename;
       // exit;
    }
    public function view($id,$task_id)
    {
        if($task_id!=''){
        $array_print=array(
            'task_id'=>$task_id,
            'category'=>'printed',
            'create_time' => $this->datetime,
            'update_time' => $this->datetime,
            'user_id' => $this->session->userdata('id')
        );
        $this->General->save('tbl_task_logs',$array_print);
        }
        $query = $this->Company->GetCompanyById($id);
        $this->data['query'] = $query;


        $this->data['title'] = $query['name_en'] . " - " . $query['name_ar'];
        $this->data['subtitle'] = "Companies - الشركات";
        $this->data['sectors'] = $this->Item->GetSector('online', 0, 0);
        $this->data['sections'] = $this->Item->GetSection('online', 0, 0);
        $this->data['governorates'] = $this->Address->GetGovernorateById($query['governorate_id']);
        $this->data['districts'] = $this->Address->GetDistrictById($query['district_id']);
        $this->data['area'] = $this->Address->GetAreaById($query['area_id']);
        $this->data['items'] = $this->Company->GetProductionInfo($id);
        $this->data['banks'] = $this->Company->GetCompanyBanks($id);
        $this->data['markets'] = $this->Company->GetCompanyMarkets($id);
        $this->data['insurances'] = $this->Company->GetCompanyInsurances($id);
        $this->data['sponsors'] = $this->Company->GetCompanySponsors('online');
        $this->data['powers'] = $this->Company->GetCompanyElectricPowers($id);
        $this->data['company_types'] = $this->Company->GetCompanyTypes('online');

        $this->data['industrial_room'] = $this->Company->GetIndustrialRoomById($query['iro_code']);
        $this->data['industrial_group'] = $this->Company->GetIndustrialGroupById($query['igr_code']);
        $this->data['economical_assembly'] = $this->Company->GetEconomicalAssemblyById($query['eas_code']);

        $this->data['salesman'] = $this->General->GetSalesManById($query['sales_man_id']);
        $this->data['position'] = $this->Item->GetPositionById($query['position_id']);

        $this->data['license'] = $this->Company->GetLicenseSourceById($query['license_source_id']);


        $this->load->view('company/view', $this->data);
    }
    public function update_status($id)
    {
        $status=$this->input->post('status'.$id);
        $delivery_date=date("Y-m-d");
        if($this->input->post('delivery_date')!="")
            $delivery_date=$this->input->post('delivery_date'.$id);

        $note=$this->input->post('note'.$id);
        $array=array('status'=>$status,'delivery_date'=>$delivery_date);
        $this->Administrator->edit('tbl_tasks',$array,$id);
        if($status=='done')
        {
            $note.='<br>Delivery Date : '. $delivery_date;
        }
        $data_logs=array(
            'task_id'=>$id,
            'category'=>'other',
            'note'=>$note,
            'create_time' => $this->datetime,
            'update_time' => $this->datetime,
            'user_id' => $this->session->userdata('id')
        );
        $this->General->save('tbl_task_logs',$data_logs);
        $this->session->set_userdata(array('done_message' =>' Task Updated Successfully'));
        redirect($this->agent->referrer());
    }
    public function update_selected_status()
    {
        $ids=$this->input->post('checkbox1');
        $status=$this->input->post('status_all');
        $delivery_date=$this->input->post('delivery_date_all');
        $note=$this->input->post('note_all');
        for($i=0;$i<count($ids);$i++)
        {
            $this->Administrator->edit('tbl_tasks',array('status'=>$status,'delivery_date'=>$delivery_date,'comments'=>$note,'update_time' => $this->datetime),$ids[$i]);
            if($status=='done')
            {
                $note.='<br>Delivery Date : '. $delivery_date;
            }
            $data_logs=array(
                'task_id'=>$ids[$i],
                'category'=>'other',
                'note'=>$note,
                'create_time' => $this->datetime,
                'update_time' => $this->datetime,
                'user_id' => $this->session->userdata('id')
            );
            $this->General->save('tbl_task_logs',$data_logs);
        }
        $this->session->set_userdata(array('done_message' =>' Task(s) Updated Successfully'));
        redirect($this->agent->referrer());
    }
    public function update_task_status($company_id)
    {
        $status='done';
        $delivery_date=date('Y-m-d');
        $note='';
        $note.='<br>Delivery Date : '. $delivery_date;
        $task=$this->Task->GetTaskByCompanyId($company_id);

        $this->Administrator->update('tbl_tasks',array('status'=>$status,'delivery_date'=>$delivery_date,'comments'=>$note,'update_time' => $this->datetime),array('company_id'=>$company_id));
        $this->Administrator->update('tbl_company',array('update_info' => ($status == 'done') ? 1 : 0,'update_time' => $this->datetime),array('id'=>$company_id));

        $data_logs=array(
            'task_id'=>$task['id'],
            'category'=>'other',
            'note'=>$note,
            'create_time' => $this->datetime,
            'update_time' => $this->datetime,
            'user_id' => $this->session->userdata('id')
        );
        $this->General->save('tbl_task_logs',$data_logs);

        $this->session->set_userdata(array('done_message' =>' Task Updated Successfully'));
        redirect('companies');
    }
    public function update_company_status()
    {
        $status='done';

        $all=$this->Task->GetTasks('', '', '', '', '', '', '', '', '', '', '', '', $status,'', 0, 0);
        $tasks=$all['results'];
      //  var_dump($tasks);
        foreach($tasks as $task){
            echo $task->company_id.'<br>';
            $this->Administrator->update('tbl_company',array('update_info' =>  1,'update_time' => $this->datetime),array('id'=>$task->company_id));
        }

       //


    }
    public function lists($row = 0) {
        $limit=20;
        $row = $this->input->get('per_page');
        if($this->input->get('search')) {
            $ref = $this->input->get('ref');
            $company_id = $this->input->get('company');
            $governorate_id = $this->input->get('governorate');
            $district_id = $this->input->get('district_id');
            $area_id = $this->input->get('area_id');
            $list = $this->input->get('list');
            $sales_man = $this->input->get('sales_man');
            $year = $this->input->get('year');
            $from_start = $this->input->get('from_start');
            $to_start = $this->input->get('to_start');
            $from_due = $this->input->get('from_due');
            $to_due = $this->input->get('to_due');
            $status = $this->input->get('status');
            $category = $this->input->get('category');

        }
        $all = $this->Task->GetListTasks(@$ref,@$company_id, @$governorate_id, @$district_id, @$area_id, @$list, @$sales_man, @$year, @$from_start,@$to_start, @$from_due, @$to_due,@$status,@$category, 0, 0);
        $query=$all['results'];
        $config['base_url'] = base_url().'tasks?ref='.@$ref.'&company='.@$company_id.'&governorate='.@$governorate_id.'&district='.@$district_id.'&area='.@$area_id.'&list='.@$list.'&sales_man='.@$sales_man.'&year='.@$year.'&from_start='.@$from_start.'&to_start='.@$to_start.'&from_due='.@$from_due.'&to_due='.@$to_due.'&status='.@$status.'&category='.@$category.'&search=Search';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $total_row=$all['num_results'];
        $array_companies=array();
        if(@$company_id!=''){
            $company=$this->Company->GetCompanyById($company_id);
            $array_companies=array($company_id=>'('.$company_id.') '.@$company['name_ar']);
        }
        $this->data['array_companies']=$array_companies;

        $this->data['company'] = @$company_id;
        $this->data['ref'] = @$ref;
        $this->data['governorate'] = @$governorate_id;
        $this->data['district'] = @$district_id;
        $this->data['area'] = @$area_id;
        $this->data['list'] = @$list;
        $this->data['sales_man'] = @$sales_man;
        $this->data['year'] = @$year;
        $this->data['from_start'] = @$from_start;
        $this->data['to_start'] = @$to_start;
        $this->data['from_due'] = @$from_due;
        $this->data['to_due'] = @$to_due;
        $this->data['status'] = @$status;
        $this->data['category']=@$category;

        $config['total_rows'] = $total_row;
        $config['per_page'] = $limit;
        $config['num_links'] = 6;
        $this->pagination->initialize($config);
        $this->data['query'] = @$query;
        $this->data['total_row'] = $total_row;
        $this->data['links'] = $this->pagination->create_links();
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Tasks','tasks');
        $this->breadcrumb->add_crumb('Lists');
        $this->data['title'] = $this->data['Ctitle']." - Lists";
        $this->data['subtitle'] = "Lists";
        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', @$district_id);
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', @$governorate_id);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['sales'] = $this->Administrator->GetSalesMen();

        $this->template->load('_template', 'tasks/lists', $this->data);


    }
    public  function updatestatus()
    {
        $all = $this->Task->GetCompaniesUpdated('', '', '', 0, 0);
        $query=$all['results'];

        foreach ($query as $row)
        {
           // echo $row->id.'<br>';
           $this->Administrator->update('tbl_tasks',array('status'=>'done'),array('company_id'=>$row->id));
        }
    }
    public function listview($list_id,$salesman,$status='')
    { 
        $this->data['list_id']=$list_id; 
        $this->data['salesman']=$salesman;
        $this->data['status']=$status;
       
        $all = $this->Task->GetCompaniesLists('', '', '', '', '', $list_id, $salesman, '', '', '', '', '', $status,'', 0, 0);
       
        $this->data['query'] =$all['results'];
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";
        $this->data['subtitle'] = "Companies - الشركات";
//$this->load->view('tasks/print_list', $this->data);
    $this->load->view('tasks/listview', $this->data);
    }
    public function export_companies() {
        // filename for download
        $filename = "companies".time().".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;

        echo '<style type="text/css">
tr, td, table, tr{
	border:1px solid #D0D0D0;
}
.yellow{
						background:#FF0 !important;
					}
</style>   ';
        $company_id = $this->input->get('company');
        $governorate_id = $this->input->get('governorate');
        $district_id = $this->input->get('district_id');
        $area_id = $this->input->get('area_id');
        $list = $this->input->get('list');
        $sales_man = $this->input->get('sales_man');
        $year = $this->input->get('year');
        $from_start = $this->input->get('from_start');
        $to_start = $this->input->get('to_start');
        $from_due = $this->input->get('from_due');
        $to_due = $this->input->get('to_due');
        $status = $this->input->get('status');
        $category = $this->input->get('category');
        $companyID = $this->input->get('company_id');
        $all = $this->Task->GetCompaniesUpdated(@$governorate_id, @$district_id, @$area_id, 0, 0);
        $query = $all['results'];

        echo '<table cellpadding="0" cellspacing="0" style="border:1px solid; background:none !important" width="100%" class="table">
                        <thead>
                            <tr>
								<th>Code</th>
								<th>Name AR</th>
								<th>Name EN</th>
								<th>OWNER NAME AR?</th>
								<th>OWNER NAME EN</th>
								 <th>Activity AR</th>
                                 <th>Activity EN</th>
                                 <th>Mohafaza AR</th>
                                 <th>Mohafaza EN</th>
								 <th>Kazaa AR</th>
								 <th>Kazaa EN</th>
                                 <th>Are AR</th>
                                <th>Area EN</th>
								<th>Street AR</th>
								<th>Street EN</th>
								<th>Phone</th>
								<th>Fax</th>
								<th>POBOX AR</th>
								<th>POBOX EN</th>
								<th>Website</th>
								<th>Email</th>
								<th>X Location</th>
								<th>Y Location</th>
								<th>Advertised</th>
								<th>Copy Reservation</th>
								<th>Responsable AR</th>
								<th>Responsable EN</th>
								<th>Sector AR</th>
								<th>Sector EN</th>
								<th>Exporter?</th>
								<th>Is Closed?</th>
								<th>Closed Date</th>
								<th>Number of Labour</th>
								<th>Wezara ID</th>
								<th>Comments</th>
								<th>Error In Address</th>

                              </tr>
                        </thead>
                        <tbody>';
        foreach($query as $row) {
            echo ' <tr>
									<td>'.$row->id.'</td>
									<td>'.$row->name_ar.'</td>
									<td>'.$row->name_en.'</td>
									<td>'.$row->owner_name.'</td>
									<td>'.$row->owner_name_en.'</td>
									<td>'.$row->activity_ar.'</td>
									<td>'.$row->activity_en.'</td>
									<td>'.$row->governorate_ar.'</td>
									<td>'.$row->governorate_en.'</td>
									<td>'.$row->district_ar.'</td>
									<td>'.$row->district_en.'</td>
									<td>'.$row->area_ar.'</td>
									<td>'.$row->area_en.'</td>
									<td>'.$row->street_ar.'</td>
									<td>'.$row->street_en.'</td>
									<td>'.$row->phone.'</td>
									<td>'.$row->fax.'</td>
									<td>'.$row->pobox_ar.'</td>
									<td>'.$row->pobox_en.'</td>
									<td>'.$row->website.'</td>
									<td>'.$row->email.'</td>
									<td>'.$row->x_decimal.'</td>
									<td>'.$row->y_decimal.'</td>
									<td>'.$row->is_adv.'</td>
									<td>'.$row->copy_res.'</td>
									<td>'.$row->rep_person_ar.'</td>
									<td>'.$row->rep_person_en.'</td>
									<td>'.$row->sector_ar.'</td>
									<td>'.$row->sector_en.'</td>
									<td>'.$row->is_exporter.'</td>
									<td>'.(($row->is_closed==1)? 'yes' : '').'</td>
									<td>'.$row->closed_date.'</td>
									<td>'.$row->employees_number.'</td>
									<td>'.$row->ministry_id.'</td>
									<td>'.$row->personal_notes.'</td>
                                    <td>'.(($row->error_address==1)? 'yes' : '').'</td>
								</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        //exit;
    }
    public function companies($row = 0) {
        $limit=20;

        $row = $this->input->get('per_page');
        if($this->input->get('search')) {
            $ref = $this->input->get('ref');
            $company_id = $this->input->get('company');
            $governorate_id = $this->input->get('governorate');
            $district_id = $this->input->get('district_id');
            $area_id = $this->input->get('area_id');
            $list = $this->input->get('list');
            $sales_man = $this->input->get('sales_man');
            $year = $this->input->get('year');
            $from_start = $this->input->get('from_start');
            $to_start = $this->input->get('to_start');
            $from_due = $this->input->get('from_due');
            $to_due = $this->input->get('to_due');
            $status = $this->input->get('status');
            $category = $this->input->get('category');
            $companyID = $this->input->get('company_id');

        }

        $all = $this->Task->GetCompaniesUpdated(@$governorate_id, @$district_id, @$area_id, $row, $limit);

        $query=$all['results'];
        $config['base_url'] = base_url().'tasks/companies?governorate='.@$governorate_id.'&district='.@$district_id.'&area='.@$area_id.'&search=Search';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $total_row=$all['num_results'];
        $this->data['company'] = @$company_id;
        $this->data['ref'] = @$ref;
        $this->data['governorate'] = @$governorate_id;
        $this->data['district'] = @$district_id;
        $this->data['area'] = @$area_id;
        $this->data['list'] = @$list;
        $this->data['sales_man'] = @$sales_man;
        $this->data['year'] = @$year;
        $this->data['from_start'] = @$from_start;
        $this->data['to_start'] = @$to_start;
        $this->data['from_due'] = @$from_due;
        $this->data['to_due'] = @$to_due;
        $this->data['status'] = @$status;
        $this->data['category']=@$category;
        $this->data['array_companies']=array();

        $config['total_rows'] = $total_row;
        $config['per_page'] = $limit;
        $config['num_links'] = 6;
        $this->pagination->initialize($config);
        $this->data['query'] = @$query;
        $this->data['total_row'] = $total_row;
        $this->data['links'] = $this->pagination->create_links();
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Tasks');
        $this->data['title'] = $this->data['Ctitle']." - Tasks";
        $this->data['subtitle'] = " الشركات الممسوحة";

        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', @$district_id);
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', @$governorate_id);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['sales'] = $this->Administrator->GetSalesMen();

        $this->template->load('_template', 'tasks/companies', $this->data);
    }
    public function GetArea()
    {
        echo '
            <style type="text/css">
    #area_id{
        width:100% !important;
    }


</style>
            <script>
        $(document).ready(function() {
            $("#area_id").select2();
        });
    </script>';
        $dist_id = $this->input->post('id');
        if ($this->input->post('area_id')) {
            $area_id = $this->input->post('area_id');
        } else {
            $area_id = 0;
        }
        $areas = $this->Task->GetAreaByDistrictID('online', $dist_id,$this->input->post('sales_man_id'),$this->input->post('data_type'));
       
        $total=0;
        if (count($areas) > 0) {
            
            foreach ($areas as $area) {
                $array_area[$area->id] = $area->label_ar . ' -' . $area->label_en.' ('.$area->CompanyNbr.' )';
                $total=$total+$area->CompanyNbr;
            }
            $array_area[''] = 'All ('.$total.')';
        } else {
            $array_area[0] = 'No Data Found';
        }

        echo form_dropdown('area_id', $array_area, $area_id, ' id="area_id" class="search-select"');
    }
    public function index($row = 0) {
        $limit=20;

        $row = $this->input->get('per_page');
        if($this->input->get('search')) {
            $ref = $this->input->get('ref');
            $company_name = $this->input->get('company_name');
            $governorate_id = $this->input->get('governorate_id');
            $district_id = $this->input->get('district_id');
            $area_id = $this->input->get('area_id');
            $list = $this->input->get('list');
            $sales_man = $this->input->get('sales_man');
            $year = $this->input->get('year');
            $from_start = $this->input->get('from_start');
            $to_start = $this->input->get('to_start');
            $from_due = $this->input->get('from_due');
            $to_due = $this->input->get('to_due');
            $status = $this->input->get('status');
            $category = $this->input->get('category');
            $company_id = $this->input->get('company_id');

        }
//die( $governorate_id);
        $all = $this->Task->GetTasks(@$ref,@$company_id, @$governorate_id, @$district_id, @$area_id, @$list, @$sales_man, @$year, @$from_start,@$to_start, @$from_due, @$to_due,@$status,@$category, $row, $limit,@$company_name);

        $query=$all['results'];
        $config['base_url'] = base_url().'tasks?ref='.@$ref.'&company_name='.@$company_name.'&governorate_id='.@$governorate_id.'&district_id='.@$district_id.'&area_id='.@$area_id.'&list='.@$list.'&sales_man='.@$sales_man.'&year='.@$year.'&from_start='.@$from_start.'&to_start='.@$to_start.'&from_due='.@$from_due.'&to_due='.@$to_due.'&status='.@$status.'&category='.@$category.'&company_id='.@$company_id.'&search=Search';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $total_row=$all['num_results'];
        $array_companies=array();
        if(@$company_id!=''){
            $company=$this->Company->GetCompanyById($company_id);
            $array_companies=array($company_id=>'('.$company_id.') '.@$company['name_ar']);
        }
        $this->data['array_companies']=$array_companies;

        $this->data['company_name'] = @$company_name;
        $this->data['company_id'] = @$company_id;
        $this->data['ref'] = @$ref;
        $this->data['governorate_id'] = @$governorate_id;
        $this->data['district_id'] = @$district_id;
        $this->data['area_id'] = @$area_id;
        $this->data['list'] = @$list;
        $this->data['sales_man'] = @$sales_man;
        $this->data['year'] = @$year;
        $this->data['from_start'] = @$from_start;
        $this->data['to_start'] = @$to_start;
        $this->data['from_due'] = @$from_due;
        $this->data['to_due'] = @$to_due;
        $this->data['status'] = @$status;
        $this->data['category']=@$category;


        $config['total_rows'] = $total_row;
        $config['per_page'] = $limit;
        $config['num_links'] = 6;
        $this->pagination->initialize($config);
        $this->data['query'] = @$query;
        $this->data['total_row'] = $total_row;
        $this->data['links'] = $this->pagination->create_links();
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Tasks');
        $this->data['title'] = $this->data['Ctitle']." - Tasks";
        $this->data['subtitle'] = "Tasks";

        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', @$district_id);
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', @$governorate_id);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
       
        $this->data['sales'] = $this->Administrator->GetSalesMen();

        $this->template->load('_template', 'tasks/tasks', $this->data);
    }
    public function statistics($row = 0) {
        $limit=200;

        $row = $this->input->get('per_page');
        if($this->input->get('search')) {
            $ref = $this->input->get('ref');
            $company_id = $this->input->get('company');
            $governorate_id = $this->input->get('governorate');
            $district_id = $this->input->get('district_id');
            $area_id = $this->input->get('area_id');
            $list = $this->input->get('list');
            $sales_man = $this->input->get('sales_man');
            $year = $this->input->get('year');
            $from_start = $this->input->get('from_start');
            $to_start = $this->input->get('to_start');
            $from_due = $this->input->get('from_due');
            $to_due = $this->input->get('to_due');
            $status = $this->input->get('status');
            $category = $this->input->get('category');
            $companyID = $this->input->get('company_id');

        }

        $all = $this->Task->GetCompaniesStatistics(@$governorate_id, @$district_id, @$area_id, @$year, $row, $limit);

        $query=$all['results'];
        $config['base_url'] = base_url().'tasks?ref='.@$ref.'&company='.@$company_id.'&governorate='.@$governorate_id.'&district='.@$district_id.'&area='.@$area_id.'&list='.@$list.'&sales_man='.@$sales_man.'&year='.@$year.'&from_start='.@$from_start.'&to_start='.@$to_start.'&from_due='.@$from_due.'&to_due='.@$to_due.'&status='.@$status.'&category='.@$category.'&company_id='.@$companyID.'&search=Search';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $total_row=$all['num_results'];
        $this->data['company'] = @$company_id;
        $this->data['ref'] = @$ref;
        $this->data['governorate'] = @$governorate_id;
        $this->data['district'] = @$district_id;
        $this->data['area'] = @$area_id;
        $this->data['list'] = @$list;
        $this->data['sales_man'] = @$sales_man;
        $this->data['year'] = @$year;
        $this->data['from_start'] = @$from_start;
        $this->data['to_start'] = @$to_start;
        $this->data['from_due'] = @$from_due;
        $this->data['to_due'] = @$to_due;
        $this->data['status'] = @$status;
        $this->data['category']=@$category;
        $this->data['array_companies']=array();

        $config['total_rows'] = $total_row;
        $config['per_page'] = $limit;
        $config['num_links'] = 6;
        $this->pagination->initialize($config);
        $this->data['query'] = @$query;
        $this->data['total_row'] = $total_row;
        $this->data['links'] = $this->pagination->create_links();
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Tasks');
        $this->data['title'] = $this->data['Ctitle']." - مشروع المسح";
        $this->data['subtitle'] = "مشروع المسح";

        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', @$district_id);
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', @$governorate_id);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['sales'] = $this->Administrator->GetSalesMen();

        $this->template->load('_template', 'tasks/statistics', $this->data);
    }
    public function statistics_export() {

        // filename for download
        $filename = "statistics-export-".time().".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        echo '<style type="text/css">
				tr, td, table, tr{
					border:1px solid #D0D0D0;
				}
				.yellow{
						background:#FF0 !important;
					}
					.bold{
						font-weight:bold !important;
					}
				</style>   ';
        $all = $this->Task->GetCompaniesStatistics('', '', '', '', 0, 0);
        $query = $all['results'];
        // $query=$all['results'];
        // $total_row = $all['num_results'];

        echo '<table cellpadding="0" cellspacing="0" width="100%" class="table">
                        
                        <tbody>';
        $temp_gov='';
        $temp_district='';
        foreach($query as $row) {
            $sql=$this->Task->GetGeoTasks($row->governorate_id, $row->district_id, $row->id, '', '', date('Y'), '', '', '', '', '', 0, 0);
            $sql1=$this->Task->GetCountCompaniesStatisticsByGovernorate($row->governorate_id,'','');
            $result=$sql['results'];
            $gov_nbr=count($sql1);
            if($temp_gov!=$row->governorate_ar)
            {
                $temp_gov=$row->governorate_ar;
                echo '<tr><td colspan="6" style="text-align: center"><h3>المحافظة - '.$temp_gov.' : '.$gov_nbr.'</h3></td></tr>';


            }
            if($temp_district!=$row->district_ar)
            {
                $temp_district=$row->district_ar;
                $sql2=$this->Task->GetCountCompaniesStatisticsByGovernorate($row->governorate_id,$row->district_id,'');
                $district_nbr=count($sql2);
                echo '<tr><td colspan="6" style="text-align: center"><h5>القضاء - '.$temp_district.' : '.$district_nbr.'</h5></td></tr>';
                echo '<tr>
                            <th style="text-align:center"  width="15%">البلدة</th>
                            <th style="text-align:center"  width="15%">عدد الشركات</th>
                            <th style="text-align:center"  width="15%">مسح</th>
                            <th style="text-align:center" width="15%">قيد المسح </th>
                            <th style="text-align:center" width="10%">تم</th>
                            <th style="text-align:center" width="30%">اسم المندوب</th>
                        </tr>';


            }


            echo ' <tr>
                                    <td style="text-align:center">'.$row->label_ar.'</td>
                                    <td style="text-align:center">'.@$row->all_count.'</td>
                                    <td style="text-align:center">'.@$result[0]->all_count.'</td>
                                    <td style="text-align:center">'.@$result[0]->pending_count.'</td>
                                    <td style="text-align:center">'.@$result[0]->done_count.'</td>
                                    <td></td>
                                </tr>
';

        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }
    public function statistics_print() {

        // filename for download
        header('Content-type: text/html; charset=UTF-8');
        echo '<style type="text/css">
				tr, td, table, tr{
					border:1px solid #D0D0D0;
					border-collapse: collapse;
				}
				.yellow{
						background:#FF0 !important;
					}
					.bold{
						font-weight:bold !important;
					}
				</style>   ';
        $all = $this->Task->GetCompaniesStatistics('', '', '', '', 0, 0);
        $query = $all['results'];
        $total=0;
        foreach($query as $row)
        {
            $total=$total+$row->all_count;
        }
        // $query=$all['results'];
        // $total_row = $all['num_results'];

        echo '
<table cellpadding="0" style="direction:rtl" align="center" cellspacing="0" width="900" class="table">
                        <thead><tr><th colspan="6"><img src="'.base_url().'img/company-header.jpg" width="100%" /></th> </tr></thead>
                        <tbody>';
        echo '<tr><td colspan="6" style="text-align: center"><h3>عدد المصانع : '.$total.'</h3></td></tr>';
        $temp_gov='';
        $temp_district='';
        foreach($query as $row) {
            $sql=$this->Task->GetGeoTasks($row->governorate_id, $row->district_id, $row->id, '', '', date('Y'), '', '', '', '', '', 0, 0);
            $sql1=$this->Task->GetCountCompaniesStatisticsByGovernorate($row->governorate_id,'','');
            $result=$sql['results'];
            $gov_nbr=count($sql1);
            if($temp_gov!=$row->governorate_ar)
            {
                $temp_gov=$row->governorate_ar;
                echo '<tr><td colspan="6" style="text-align: center"><h3>المحافظة - '.$temp_gov.' : '.$gov_nbr.'</h3></td></tr>';


            }
            if($temp_district!=$row->district_ar)
            {
                $temp_district=$row->district_ar;
                $sql2=$this->Task->GetCountCompaniesStatisticsByGovernorate($row->governorate_id,$row->district_id,'');
                $district_nbr=count($sql2);
                echo '<tr><td colspan="6" style="text-align: center"><h5>القضاء - '.$temp_district.' : '.$district_nbr.'</h5></td></tr>';
                echo '<tr>
                            <th style="text-align:center"  width="15%">البلدة</th>
                            <th style="text-align:center"  width="15%">عدد الشركات</th>
                            <th style="text-align:center"  width="15%">مسح</th>
                            <th style="text-align:center" width="15%">قيد المسح </th>
                            <th style="text-align:center" width="10%">تم</th>
                            <th style="text-align:center" width="30%">اسم المندوب</th>
                        </tr>';


            }


            echo ' <tr>
                                    <td style="text-align:center">'.$row->label_ar.'</td>
                                    <td style="text-align:center">'.@$row->all_count.'</td>
                                    <td style="text-align:center">'.@$result[0]->all_count.'</td>
                                    <td style="text-align:center">'.@$result[0]->pending_count.'</td>
                                    <td style="text-align:center">'.@$result[0]->done_count.'</td>
                                    <td></td>
                                </tr>
';

        }
        echo '</tbody>';

        echo '</table>';

    }

    public function geo($row = 0) {
        $limit=20;
        $row = $this->input->get('per_page');
        if($this->input->get('search')) {
            $governorate_id = $this->input->get('governorate');
            $district_id = $this->input->get('district_id');
            $area_id = $this->input->get('area_id');
            $list = $this->input->get('list');
            $sales_man = $this->input->get('sales_man');
            $year = $this->input->get('year');
            $from_start = $this->input->get('from_start');
            $to_start = $this->input->get('to_start');
            $from_due = $this->input->get('from_due');
            $to_due = $this->input->get('to_due');

        }

        $all = $this->Task->GetGeoTasks(@$governorate_id, @$district_id, @$area_id, @$list, @$sales_man, @$year, @$from_start,@$to_start, @$from_due, @$to_due,@$status, $row, $limit);
        $query=$all['results'];
        $config['base_url'] = base_url().'geo?governorate='.@$governorate_id.'&district='.@$district_id.'&area='.@$area_id.'&list='.@$list.'&sales_man='.@$sales_man.'&year='.@$year.'&from_start='.@$from_start.'&to_start='.@$to_start.'&from_due='.@$from_due.'&to_due='.@$to_due.'&status='.@$status.'&search=Search';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $total_row=@$all['num_result'];

        $this->data['governorate'] = @$governorate_id;
        $this->data['district'] = @$district_id;
        $this->data['area'] = @$area_id;
        $this->data['list'] = @$list;
        $this->data['sales_man'] = @$sales_man;
        $this->data['year'] = @$year;
        $this->data['from_start'] = @$from_start;
        $this->data['to_start'] = @$to_start;
        $this->data['from_due'] = @$from_due;
        $this->data['to_due'] = @$to_due;
        $this->data['status'] = @$status;

        $config['total_rows'] = @$total_row;
        $config['per_page'] = $limit;
        $config['num_links'] = 6;
        $this->pagination->initialize($config);
        $this->data['query'] = @$query;
        $this->data['total_row'] = $total_row;
        $this->data['links'] = $this->pagination->create_links();
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Tasks');
        $this->data['title'] = $this->data['Ctitle']." - Geo Tasks";
        $this->data['subtitle'] = "Geo Tasks";
        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', @$district_id);
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', @$governorate_id);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['sales'] = $this->Administrator->GetSalesMen();

        $this->template->load('_template', 'tasks/geo', $this->data);
    }

    public function districts($row = 0) {
        $limit=20;
        $row = $this->input->get('per_page');
        if($this->input->get('search')) {
            $governorate_id = $this->input->get('governorate');
            $district_id = $this->input->get('district_id');
            $list = $this->input->get('list');
            $sales_man = $this->input->get('sales_man');
            $year = $this->input->get('year');
            $from_start = $this->input->get('from_start');
            $to_start = $this->input->get('to_start');
            $from_due = $this->input->get('from_due');
            $to_due = $this->input->get('to_due');

        }
        $all = $this->Task->GetDistrictsTasks(@$governorate_id, @$district_id, @$list, @$sales_man, @$year, @$from_start,@$to_start, @$from_due, @$to_due,@$status, $row, $limit);
        $query=$all['results'];
        $config['base_url'] = base_url().'districts?governorate='.@$governorate_id.'&district='.@$district_id.'&list='.@$list.'&sales_man='.@$sales_man.'&year='.@$year.'&from_start='.@$from_start.'&to_start='.@$to_start.'&from_due='.@$from_due.'&to_due='.@$to_due.'&status='.@$status.'&search=Search';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $total_row=@$all['num_result'];

        $this->data['governorate'] = @$governorate_id;
        $this->data['district'] = @$district_id;
        $this->data['list'] = @$list;
        $this->data['sales_man'] = @$sales_man;
        $this->data['year'] = @$year;
        $this->data['from_start'] = @$from_start;
        $this->data['to_start'] = @$to_start;
        $this->data['from_due'] = @$from_due;
        $this->data['to_due'] = @$to_due;
        $this->data['status'] = @$status;

        $config['total_rows'] = @$total_row;
        $config['per_page'] = $limit;
        $config['num_links'] = 6;
        $this->pagination->initialize($config);
        $this->data['query'] = @$query;
        $this->data['total_row'] = $total_row;
        $this->data['links'] = $this->pagination->create_links();
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Tasks');
        $this->data['title'] = $this->data['Ctitle']." - Kazaa Tasks";
        $this->data['subtitle'] = "Kazaa Tasks";
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', @$governorate_id);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['sales'] = $this->Administrator->GetSalesMen();

        $this->template->load('_template', 'tasks/districts', $this->data);
    }
    public function district_view($status,$district_id)
    {
        $query = $this->Task->GetDistrictsTaskCompanies(@$district_id,@$status);
        foreach($query as $row)
        {
           $this->view($row->id,$row->task_id); 
        }
    }
        
    
     public function sales_list()
    {
        //id='.$sales_man.'&start_date='.@$start_date.'&due_date='.@$due_date.'&delivery_date='.@$delivery_date.'&status='.@$status.'&search=Search'
        $this->data['sales_man']=$sales_man=$this->input->get('id');
        $this->data['start_date']=$from_start=$this->input->get('start_date');
        $this->data['due_date']=$due_date=$this->input->get('due_date');
        $this->data['delivery_date']=$delivery_date=$this->input->get('delivery_date');
        $this->data['status']=$status=$this->input->get('status');
        
                $list = $this->input->get('list');
            $year = $this->input->get('year');

           

        $all = $this->Task->GetSalesTasks(@$list, @$sales_man, @$year, @$from_start,@$to_start, @$from_due, @$to_due,@$status, 0, 0);
       // $all = $this->Task->GetSalesTasks('', @$sales_man, @$year, '','', '', '',@$status, 0, 0);
        $this->data['query'] =$query=$all['results'];
        $this->data['total_companies']=count($this->Company->GetCompanies('', 0, 0));
        $this->data['closed_companies']=count($this->Company->GetClosedCompanies(1, 0, 0));
        $this->data['error_companies']=count($this->Company->GetErrorAddressesCompanies(1, 0, 0));

        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";;
        $this->data['subtitle'] = "Companies - الشركات";
        $this->load->view('tasks/sales_listview', $this->data);


    }
    public function sales_list1()
    {
        //id='.$sales_man.'&start_date='.@$start_date.'&due_date='.@$due_date.'&delivery_date='.@$delivery_date.'&status='.@$status.'&search=Search'
        $this->data['sales_man']=$sales_man=$this->input->get('id');
        $this->data['start_date']=$start_date=$this->input->get('start_date');
        $this->data['due_date']=$due_date=$this->input->get('due_date');
        $this->data['delivery_date']=$delivery_date=$this->input->get('delivery_date');
        $this->data['status']=$status=$this->input->get('status');
        $all = $this->Task->GetSalesTasks(@$list, @$sales_man, @$year, @$from_start,@$to_start, @$from_due, @$to_due,@$status, $row, $limit);
        $all = $this->Task->GetSalesTasks('', @$sales_man, date('Y'), '','', '', '',@$status, 0, 0);
        $this->data['query'] =$query=$all['results'];
        $this->data['total_companies']=count($this->Company->GetCompanies('', 0, 0));

        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";;
        $this->data['subtitle'] = "Companies - الشركات";
        $this->load->view('tasks/sales_listview', $this->data);


    }
    public function GetDistricts()
    {
        echo '<style type="text/css">
    #district_id{
        width:100% !important;
    }


</style>
<script>
        $(document).ready(function() {
            $("#districtgovid").select2();
        });
    </script>';
        $jsdis = 'id="districtgovid" class="search-select" required="required"';
        $gov_id = $_POST['id'];
        $districts = $this->Address->GetDistrictByGov('online', $gov_id);
        if (count($districts) > 0) {
            $array_districts[''] = 'All';
            foreach ($districts as $district) {
                $array_districts[$district->id] = $district->label_ar . ' (' . $district->label_en . ')';
            }
        } else {
            $array_districts[''] = 'No Data Found';
        }
        echo form_dropdown('district_id', $array_districts, '', $jsdis);
    }
        public function reports($row = 0) {
        $limit=20;
        $row = $this->input->get('per_page');
        
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
         $config['per_page'] = $limit;
        $config['num_links'] = 6;
        
        
        
        if($this->input->get('search')) {
            
            $governorate_id = $this->input->get('governorate');
            $district_id = $this->input->get('district_id');
            $area_id = $this->input->get('area_id');
            
            $list = $this->input->get('list');
            $sales_man = $this->input->get('salesman');
            $year = $this->input->get('year');
            $from_start = $this->input->get('from_start');
            $to_start = $this->input->get('to_start');
            $from_due = $this->input->get('from_due');
            $to_due = $this->input->get('to_due');
            
            $this->data['governorate_id'] = @$governorate_id;
            $this->data['district_id'] = @$district_id;
            $this->data['area_id'] = @$area_id;
            
            switch ($this->input->get('type')) {
                case 'salesman':
                    $this->data['title'] = $this->data['Ctitle']." - Sales Men Tasks";
                    $this->data['subtitle'] = "Sales Men Tasks";
                    $all = $this->Task->GetSalesTasks(@$list, @$sales_man, @$year, @$from_start,@$to_start, @$from_due, @$to_due,@$status, $row, $limit);
                    $query=$all['results'];
                    $config['base_url'] = base_url().'sales?list='.@$list.'&salesman='.@$sales_man.'&year='.@$year.'&from_start='.@$from_start.'&to_start='.@$to_start.'&from_due='.@$from_due.'&to_due='.@$to_due.'&status='.@$status.'&search=Search';

                    $total_row=@$all['num_results'];
                    $this->data['total_row'] =$config['total_rows'] = @$total_row;
                    $this->pagination->initialize($config);
                    $this->data['query'] = @$query;
                    $this->data['links'] = $this->pagination->create_links();
                    $this->data['salesman'] = @$sales_man;
                    
                    $display=$this->load->view('tasks/_report_salesmen.php',$this->data,TRUE);
                    
                    break;
                case 'area':
                    $this->data['title'] = $this->data['Ctitle']." - Area Tasks";
                    $this->data['subtitle'] = "Area Tasks";
                    
                     $all = $this->Task->GetAreaTasks(@$area_id, @$district_id, @$governorate_id, @$sales_man, $row, $limit);
                    $query=$all['results'];
                    $config['base_url'] = base_url().'tasks/reports?type=area&governorate='.@$governorate_id.'&district_id='.@$district_id.'&area_id='.@$area_id.'&search=Search';

                    $total_row=@$all['num_results'];
                    $this->data['total_row'] =$config['total_rows'] = @$total_row;
                    $this->pagination->initialize($config);
                    $this->data['query'] = @$query;
                    $this->data['links'] = $this->pagination->create_links();

                    $display=$this->load->view('tasks/_report_area.php',$this->data,TRUE);
                    break;
                case 'district':
                    $this->data['title'] = $this->data['Ctitle']." - District Tasks";
                    $this->data['subtitle'] = "District Tasks";
                    
                    $all = $this->Task->GetDistrictTasks(@$district_id, @$governorate_id, $sales_man, $row, $limit);
                    $query=$all['results'];
                    $config['base_url'] = base_url().'tasks/reports?type=district&governorate='.@$governorate_id.'&district_id='.@$district_id.'&search=Search';
                    $config['enable_query_strings'] = TRUE;
                    $config['page_query_string'] = TRUE;
                    $total_row=@$all['num_results'];
                    $this->data['total_row'] =$config['total_rows'] = @$total_row;
                    $this->pagination->initialize($config);
                    $this->data['query'] = @$query;
                    $this->data['links'] = $this->pagination->create_links();
        
                    $display=$this->load->view('tasks/_report_district.php',$this->data,TRUE);
                    break;
            }

        }
        $this->data['display_view']=@$display;
        $this->data['salesman'] = @$sales_man;
        
        
        

        $this->data['list'] = @$list;
        
        $this->data['year'] = @$year;
        $this->data['from_start'] = @$from_start;
        $this->data['to_start'] = @$to_start;
        $this->data['from_due'] = @$from_due;
        $this->data['to_due'] = @$to_due;
        $this->data['status'] = @$status;

        
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Tasks');
        
        $this->data['sales'] = $this->Administrator->GetSalesMen();
         $this->data['areas'] = $this->Address->GetAreaByDistrict('online', @$district_id);
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', @$governorate_id);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        
        $this->data['title'] = $this->data['Ctitle'] . " - التقارير";;
        $this->data['subtitle'] = "التقارير";
        $this->data['type']=$this->input->get('type');

        $this->template->load('_template', 'tasks/reports', $this->data);
    }
    
    public function area_grid()
    {
        $this->data['title'] = $this->data['Ctitle']." - Area Tasks";
        $this->data['subtitle'] = "Area Tasks";
        $area_id=$this->input->get('area_id');
        $status=$this->input->get('status');
        $query=$this->Task->GetGeoTasksByAreaId($area_id,$status, 0, 0);
        $this->data['query']=$query['results'];
        $this->data['area_id']=$area_id;
        $this->data['status']=$status;
        $this->data['area_name'] = $this->Address->GetAreaById($area_id);
        $this->load->view('tasks/area_grid',$this->data);
    }
    public function sales($row = 0) {
        $limit=20;
        $row = $this->input->get('per_page');
        if($this->input->get('search')) {
            $list = $this->input->get('list');
            $sales_man = $this->input->get('id');
            $year = $this->input->get('year');
            $from_start = $this->input->get('from_start');
            $to_start = $this->input->get('to_start');
            $from_due = $this->input->get('from_due');
            $to_due = $this->input->get('to_due');

        }
        $all = $this->Task->GetSalesTasks(@$list, @$sales_man, @$year, @$from_start,@$to_start, @$from_due, @$to_due,@$status, $row, $limit);
        $query=$all['results'];
        $config['base_url'] = base_url().'sales?list='.@$list.'&id='.@$sales_man.'&year='.@$year.'&from_start='.@$from_start.'&to_start='.@$to_start.'&from_due='.@$from_due.'&to_due='.@$to_due.'&status='.@$status.'&search=Search';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $total_row=@$all['num_result'];

        $this->data['list'] = @$list;
        $this->data['sales_man'] = @$sales_man;
        $this->data['year'] = @$year;
        $this->data['from_start'] = @$from_start;
        $this->data['to_start'] = @$to_start;
        $this->data['from_due'] = @$from_due;
        $this->data['to_due'] = @$to_due;
        $this->data['status'] = @$status;

        $this->data['total_row'] =$config['total_rows'] = @$total_row;
        $config['per_page'] = $limit;
        $config['num_links'] = 6;
        $this->pagination->initialize($config);
        $this->data['query'] = @$query;
        $this->data['links'] = $this->pagination->create_links();
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Tasks');
        $this->data['title'] = $this->data['Ctitle']." - Sales Men Tasks";
        $this->data['subtitle'] = "Sales Men Tasks";
      //  $this->data['districts'] = $this->Address->GetDistrictByGov('online', @$governorate_id);
       // $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['sales'] = $this->Administrator->GetSalesMen();

        $this->template->load('_template', 'tasks/sales', $this->data);
    }
    public function print_list()
    {
        $area_id=$this->input->get('area_id');
        $salesman=$this->input->get('sales_man');
        $status=$this->input->get('status');
        $district_id = $this->input->get('district_id');
        $governorate_id = $this->input->get('governorate_id');

        $this->data['status']=$status;
        $this->data['query']=$query= $this->Task->GetTasks('', '', $governorate_id, $district_id, $area_id, '', $salesman, '', '', '', '', '', $status,'', 0, 0);
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";;
        $this->data['subtitle'] = "Companies - الشركات";
        $this->load->view('tasks/print_list', $this->data);
    }
    public function area_list()
    {
        $area_id=$this->input->get('area_id');
        $salesman=$this->input->get('sales_man');
        $status=$this->input->get('status');
        $district_id = $this->input->get('district_id');
        $governorate_id = $this->input->get('governorate_id');

        $this->data['status']=$status;
        $this->data['query']=$query= $this->Task->GetTasks('', '', $governorate_id, $district_id, $area_id, '', $salesman, '', '', '', '', '', $status,'', 0, 0);
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";;
        $this->data['subtitle'] = "Companies - الشركات";
        $this->load->view('tasks/area_list', $this->data);
    }
    public function district_list()
    {
        $salesman=$this->input->get('sales_man');
        $status=$this->input->get('status');
        $district_id = $this->input->get('district_id');
        $governorate_id = $this->input->get('governorate_id');

        $this->data['status']=$status;
        $this->data['query']=$query= $this->Task->GetTasks('', '', $governorate_id, $district_id, @$area_id, '', $salesman, '', '', '', '', '', $status,'', 0, 0);
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";;
        $this->data['subtitle'] = "Companies - الشركات";
        $this->load->view('tasks/district_list', $this->data);
    }
    
    public function print_details()
    {
        $area_id=$this->input->get('area_id');
        $salesman=$this->input->get('sales_man');
        $status=$this->input->get('status');
        $district_id = $this->input->get('district_id');
        $governorate_id = $this->input->get('governorate_id');

        $this->data['status']=$status;
        $this->data['query']=$query= $this->Task->GetTasks('', '', $governorate_id, $district_id, $area_id, '', $salesman, '', '', '', '', '', $status,'', 0, 0);
       if(count($query['results'])>0){
        foreach($query['results'] as $row){
            $this->view($row->company_id, '');
        }
       }
       else{
           echo 'No Data Found';
       }
    }
    public function area_details()
    {
        $area_id=$this->input->get('area_id');
        $salesman=$this->input->get('sales_man');
        $status=$this->input->get('status');
        $district_id = $this->input->get('district_id');
        $governorate_id = $this->input->get('governorate_id');

        $this->data['status']=$status;
        $this->data['query']=$query= $this->Task->GetTasks('', '', $governorate_id, $district_id, $area_id, '', $salesman, '', '', '', '', '', $status,'', 0, 0);
       if(count($query['results'])>0){
        foreach($query['results'] as $row){
            $this->view($row->company_id, '');
        }
       }
       else{
           echo 'No Data Found';
       }
    }
    public function print_list_acc()
    {
        $area_id=$this->input->get('area_id');
        $salesman=$this->input->get('salesman');
        $status=$this->input->get('status');
        $district_id = $this->input->get('district_id');
        $governorate_id = $this->input->get('governorate_id');

        $this->data['status']=$status;
        $this->data['query']=$query= $this->Task->GetAccCompaniesDetails($salesman,$governorate_id,$district_id,$area_id,$status);
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";
        $this->load->view('tasks/print_list_acc_salesman', $this->data);
    }
    public function area_list_acc()
    {
        $area_id=$this->input->get('area_id');
        $salesman=$this->input->get('salesman');
        $status=$this->input->get('status');
        $district_id = $this->input->get('district_id');
        $governorate_id = $this->input->get('governorate_id');

        $this->data['status']=$status;
        $this->data['query']=$query= $this->Task->GetAccCompaniesDetails($salesman,$governorate_id,$district_id,$area_id,$status);
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";
        $this->load->view('tasks/area_list_acc_salesman', $this->data);
    }
    public function district_list_acc()
    {
        $salesman=$this->input->get('salesman');
        $status=$this->input->get('status');
        $district_id = $this->input->get('district_id');
        $governorate_id = $this->input->get('governorate_id');

        $this->data['status']=$status;
        $this->data['query']=$query= $this->Task->GetAccCompaniesDetails($salesman,$governorate_id,$district_id,@$area_id,$status);
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";
        $this->load->view('tasks/district_list_acc', $this->data);
    }
    
    public function print_details_acc()
    {
        $area_id=$this->input->get('area_id');
        $salesman=$this->input->get('salesman');
        $status=$this->input->get('status');
        $district_id = $this->input->get('district_id');
        $governorate_id = $this->input->get('governorate_id');

        $this->data['status']=$status;
        $this->data['query']=$query= $this->Task->GetAccCompaniesDetails($salesman,$governorate_id,$district_id,$area_id,$status);
         foreach($query as $row)
        {
            $this->view($row->company_id,'');
        }
    }
    
    public function putlist($id)
    {
        die;
        $all=$this->Task->GetTasks('', '', '', '', '', '', $id, '', '', '', '', '', '','', 0, 0);
        $query=$all['results'];
        $i=0;
        $temp_area_id='';
       // echo $all['num_results'];
       // die;
        foreach($query as $row)
        {
            $list=$i;
            if($row->area_id!=$temp_area_id){
                $temp_area_id=$row->area_id;
                $i++;
            }
           // echo 'List '.$list.' - ';
            echo 'list : '.$i.' - area : '.$row->area_id.' - Company : '.$row->company_id.'<br>';
            $data=array('list_id'=>$i);
            $this->Administrator->edit('tbl_tasks',$data,$row->id);

        }
    }
    public function update()
    {
        $query=$this->Task->GetOldTasks();

        echo count($query);


die;

         foreach($query as $row)
        {
          $data=array(
            'list_id'=>$row->id,
            'company_id'=>$row->item_id,
            'governorate_id'=>$row->governorate_id,
            'district_id'=>$row->district_id,
            'area_id'=>$row->area_id,
            'sales_man_id'=>$row->salesman_id,
            'year'=>date('Y'),
            'start_date'=>$row->start_date,
            'due_date'=>$row->end_date,
            'comments'=>$row->comments,
            'status'=>'pending',
            'payment_status'=>'pending',
            'category'=>'scanning',
            'create_time'=>$row->create_time,
            'update_time'=>$row->update_time,
            'user_id'=>$row->user_id,
        );
       $this->General->save('tbl_tasks',$data);
        // echo
        }
    }
    public function update_list()
    {
        $query=$this->Task->GetListsTasks();
        echo '<pre>';
        var_dump($query);
    }
    public function sales_details($status,$sales_man_id) {
        $limit=20;
        $year=date('Y');
        $row = $this->input->get('per_page');
        if($this->input->get('search')) {
            $list = $this->input->get('list');
            $sales_man = $this->input->get('id');
            $from_start = $this->input->get('from_start');
            $to_start = $this->input->get('to_start');
            $from_due = $this->input->get('from_due');
            $to_due = $this->input->get('to_due');
            $year=$this->input->get('year');

        }

        $all = $this->Task->GetTasks('', '', '', '', '', '', $sales_man_id, $year,@$from_start, @$to_start, @$from_due, @$to_due, $status, $row, $limit);
        $query=$all['results'];
        $config['base_url'] = base_url().'sales?list='.@$list.'&id='.@$sales_man.'&year='.@$year.'&from_start='.@$from_start.'&to_start='.@$to_start.'&from_due='.@$from_due.'&to_due='.@$to_due.'&status='.@$status.'&search=Search';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $total_row=@$all['num_result'];

        $this->data['list'] = @$list;
        $this->data['sales_man'] = @$sales_man;
        $this->data['year'] = @$year;
        $this->data['from_start'] = @$from_start;
        $this->data['to_start'] = @$to_start;
        $this->data['from_due'] = @$from_due;
        $this->data['to_due'] = @$to_due;
        $this->data['status'] = @$status;

        $this->data['total_row'] =$config['total_rows'] = @$total_row;
        $config['per_page'] = $limit;
        $config['num_links'] = 6;
        $this->pagination->initialize($config);
        $this->data['query'] = @$query;
        $this->data['links'] = $this->pagination->create_links();
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Tasks');
        $this->data['title'] = $this->data['Ctitle']." - Sales Men Tasks";
        $this->data['subtitle'] = "Sales Men Tasks";
        //  $this->data['districts'] = $this->Address->GetDistrictByGov('online', @$governorate_id);
        // $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['sales'] = $this->Administrator->GetSalesMen();

        $this->template->load('_template', 'tasks/sales_details', $this->data);
    }

    public function details() {
        $list=$this->input->get('list');
        $salesman=$this->input->get('salesman');
        $status=$this->input->get('status');
        $limit=20;
        $row = $this->input->get('per_page');
        if($this->input->get('search')) {
            $company_id = $this->input->get('company');
            $year = $this->input->get('year');
            $from_start = $this->input->get('from_start');
            $to_start = $this->input->get('to_start');
            $from_due = $this->input->get('from_due');
            $to_due = $this->input->get('to_due');
            $category = $this->input->get('category');

        }
        $all = $this->Task->GetTasks('',@$company_id,'', '', '', @$list, @$salesman, @$year, @$from_start,@$to_start, @$from_due, @$to_due,@$status,@$category, $row, $limit);
        $query=$all['results'];
        $config['base_url'] = base_url().'tasks/details?company='.@$company_id.'&list='.@$list.'&salesman='.@$salesman.'&year='.@$year.'&from_start='.@$from_start.'&to_start='.@$to_start.'&from_due='.@$from_due.'&to_due='.@$to_due.'&status='.@$status.'&category='.@$category.'&search=Search';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $total_row=$all['num_results'];
        $this->data['company'] = @$company_id;

        $this->data['list'] = @$list;
        $this->data['sales_man'] = @$salesman;
        $this->data['year'] = @$year;
        $this->data['from_start'] = @$from_start;
        $this->data['to_start'] = @$to_start;
        $this->data['from_due'] = @$from_due;
        $this->data['to_due'] = @$to_due;
        $this->data['status'] = @$status;
        $this->data['category']=@$category;
        $this->data['array_companies']=array();

        $config['total_rows'] = $total_row;
        $config['per_page'] = $limit;
        $config['num_links'] = 6;
        $this->pagination->initialize($config);
        $this->data['query'] = @$query;
        $this->data['total_row'] = $total_row;
        $this->data['links'] = $this->pagination->create_links();
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Tasks');
        $this->data['title'] = $this->data['Ctitle']." - Tasks";
        $this->data['subtitle'] = "List Number : ".$list;
        $this->data['sales'] = $this->Administrator->GetSalesMen();

        $this->template->load('_template', 'tasks/tasks_details', $this->data);
    }
    public function acc() {
        $area_id=$this->input->get('area_id');
        $salesman=$this->input->get('salesman');
        $status=$this->input->get('status');
        $limit=20;
        $row = $this->input->get('per_page');
            $district_id = $this->input->get('district_id');
            $governorate_id = $this->input->get('governorate_id');
        

        $this->data['query']=$query= $this->Task->GetAccCompaniesDetails($salesman,$governorate_id,$district_id,$area_id,$status);
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Tasks');
        $this->data['title'] = $this->data['Ctitle']." - Tasks";
        $this->data['subtitle'] = "Acc : ".$status;
        $this->data['sales'] = $this->Administrator->GetSalesMen();

        $this->template->load('_template', 'tasks/acc', $this->data);
    }
    public function showPendingTask() { 
       
        $area_id=$this->input->get('area_id');
        $salesman=$this->input->get('salesman');
        $status=$this->input->get('status');
        $limit=20;
        $row = $this->input->get('per_page');
            $district_id = $this->input->get('district_id');
            $governorate_id = $this->input->get('governorate_id');

        
        $this->data['query']=$query= $this->Task->GetPendingCompaniesDetails($salesman,$governorate_id,$district_id,$area_id,$status);
       
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Tasks');
        $this->data['title'] = $this->data['Ctitle']." - Tasks";
        $this->data['subtitle'] = "Status : ".$status;
        $this->data['sales'] = $this->Administrator->GetSalesMen();
        $this->template->load('_template', 'tasks/showPendingTask', $this->data);
        //$this->template->load('_template', 'tasks', $this->data);
    }
    public function GetDistrictsBySalesman()
    {
        $salesman=$this->input->post('id');
        $status='pending';
        $query=$this->Task->GetDistrictsBySalesman($salesman,$status);
        echo '<script>
        $(document).ready(function() {
			$("#district_id").select2();
        });
    </script>';
        $array=array();
        foreach($query as $row)
        {
            $array[$row->id]=$row->label_ar.' - '.$row->governorate_ar.' ('.$row->total.' )';
        }
        echo form_dropdown('district_id',$array,'','id="district_id"');
    }
    public function task_district_update()
    {
        $salesman=$this->input->post('salesman');
        $old_salesman=$this->input->post('old_salesman');
        $district_id=$this->input->post('district_id');
        $status='pending';

        $query=$this->Task->GetAreaBySalesman($old_salesman,$district_id,$status);

        foreach($query as $row)
        {
            $listquery=$this->Task->GetMaxList($salesman);
            $list_id= $listquery['list_id']+1;
            $data_task = array(
                'list_id' => $list_id,
                'sales_man_id' => $salesman,
                'update_time' => $this->datetime,
                'user_id' => $this->session->userdata('id'),
            );
            $where = array(
                'district_id' => $this->input->post('district_id'),
                'area_id' => $row->id,
                'sales_man_id' => $old_salesman,
                'status' => 'pending',
            );

            $this->Administrator->update('tbl_tasks', $data_task, $where);
        }



        $this->session->set_userdata(array('done_message' =>' task(s) updated Successfully'));
        redirect($this->agent->referrer());
    }
    public function GetTaskDetails()
    {
        
    }
    public function task_update()
    {
       
        $salesman=$this->input->post('salesman');
        $old_list=$this->input->post('old_list');        
        $query=$this->Task->GetMaxList($salesman);        
        $list_id= $query['list_id']+1;
        $all = $this->Task->GetTasks('',@$company_id,'', '', '', $old_list, $this->input->post('old_sales'), @$year, @$from_start,@$to_start, @$from_due, @$to_due,'pending',@$category, 0, 0);
       // var_dump($all['results']);  die();
        $rows=$all['results'];
        // foreach($rows as $row)
        // {
        //        // echo $row->company_id . "<br>";
        //        //$company_ids[]=$row->company_id;
        //        $data_company=array(
        //         'sales_man_id' => $salesman,
        //         'update_time' => $this->datetime,
        //         'user_id' => $this->session->userdata('id'), 
        //        );
        //        $where_company = array(
        //         'id' => $row->company_id,
        //     );
        //     $ids=$this->Administrator->update('tbl_company', $data_company, $where_company);

        // }
       // $company_string_ids=implode(',',$company_ids);
        foreach($rows as $row)
        {
            $data_company=array(
                'sales_man_id' => $salesman,
                'update_time' => $this->datetime,
                'user_id' => $this->session->userdata('id'), 
               );
               $where_company = array(
                'id' => $row->company_id,
            );
            $ids=$this->Administrator->update('tbl_company', $data_company, $where_company);

            $data_client_status=array(
                'client_id' => $row->company_id,
                'client_type' => 'company' ,
                'start_date' => $this->datetime,
                'end_date' => $this->datetime,
                'sales_man_id' => $salesman ,
                'status_type' => 'show_items',
                'status' => 'active',
                'create_time' => $this->datetime ,
                'update_time' => $this->datetime ,
                'user_id' => $this->session->userdata('id') 
            );
            $ids=$this->Administrator->save('clients_status', $data_client_status);


           $data_task = array(
            'list_id' => $list_id,
            'sales_man_id' => $salesman,
            'update_time' => $this->datetime,
            'user_id' => $this->session->userdata('id'),
        ); 
        $where = array(
            'id' => $row->id,
        );
       
         // var_dump($where_company);
       // die("kk");  
        $ids=$this->Administrator->update('tbl_tasks', $data_task, $where);
        
       
        }
        /*
        $data_task = array(
            'list_id' => $list_id,
            'sales_man_id' => $salesman,
            'update_time' => $this->datetime,
            'user_id' => $this->session->userdata('id'),
        );
        $where = array(
            'governorate_id' => $this->input->post('governorate_id'),
            'district_id' => $this->input->post('district_id'),
            'area_id' => $this->input->post('area_id'),
            'sales_man_id' => $this->input->post('old_sales'),
            'status' => 'pending',
        );
*/
        
        $this->session->set_userdata(array('done_message' =>' task(s) updated Successfully'));
        redirect($this->agent->referrer());
    }
    public function lis_acc()
    {
        $area_id=$this->input->get('area_id');
        $salesman=$this->input->get('salesman');
        $status=$this->input->get('status');
        $district_id = $this->input->get('district_id');
        $governorate_id = $this->input->get('governorate_id');

        $this->data['status']=$status;
        $this->data['query']=$query= $this->Task->GetAccCompaniesDetails($salesman,$governorate_id,$district_id,$area_id,$status);
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";;
        $this->data['subtitle'] = "Companies - الشركات";
        $this->load->view('tasks/list_acc', $this->data);
    }
    public function logs() {
        $limit=30;
        $row = $this->input->get('per_page');
        $id=$this->input->get('id');
        if($this->input->get('search'))
        {
            $from=$this->input->get('from');
            $to=$this->input->get('to');
            $category=$this->input->get('category');
        }
        $this->data['task']=$task=$this->Task->GetTaskById($id);
        $all=$this->Task->GetTaskLogs($id,@$from,@$to,@$category,$row,$limit);
        $query=$all['results'];
        $config['base_url'] = base_url().'logs?id='.@$id.'&from='.@$from.'&to='.@$to.'&category='.@$category.'&search=Search';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $total_row=@$all['num_results'];

        $this->data['from'] = @$from;
        $this->data['to'] = @$to;
        $this->data['catgeory'] = @$category;


        $this->data['total_row'] =$config['total_rows'] = @$total_row;
        $config['per_page'] = $limit;
        $config['num_links'] = 6;
        $this->pagination->initialize($config);
        $this->data['query'] = $query;
        $this->data['links'] = $this->pagination->create_links();
        $this->data['query'] = $query;
        $this->data['id'] = $id;
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Tasks', 'tasks');
        $this->breadcrumb->add_crumb('Task Logs', 'tasks/logs');
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');

        $this->data['title'] = $this->data['Ctitle']." - Task Logs";
        $this->data['subtitle'] = "Logs : ".$task['company_ar'].' List : '.$task['list_id'];
        $this->template->load('_template', 'tasks/logs', $this->data);
    }



public function GetLastList()
{
    $salesman_id=$this->input->post('id');
    $query=$this->Task->GetMaxList($salesman_id);
    echo $query['list_id']+1;
}
public function GetCountCompanies()
{
    $id=$this->input->post('id');
    $data_types=$this->input->post('data_type');
    $companies = $this->Task->GetTaskCompanies('', '', '', '', 'all', '', '', '', 0, 0, $data_types,'');
    echo count($companies);

}
    public function create() {  
        
      //  if($this->p_add) {
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Tasks', 'tasks');
            $this->breadcrumb->add_crumb('Add New Task');           
            $this->form_validation->set_rules($this->TasksConfig);
           
            if($this->form_validation->run()) { 
                $i=0;
                $data_types=$this->input->post('data_types');
                //$delivery_date= $this->input->post('delivery_date') ? $this->input->post('delivery_date') : "0000-00-00 00:00:00";
               
                $area_id=$this->input->post('area_id') > 0  ?$this->input->post('area_id') : 0 ; 
               
                $cost=$this->input->post('cost') > 0  ? $this->input->post('cost') : 0 ; 


                if($this->input->post('type')=='company'){
                    $companies=$this->input->post('company_ids');
                  
                    if(count($companies)>0){
                        for($x=0;$x<count($companies);$x++){
                       $company=$this->Company->GetCompanyById($companies[$x]);
                    if(count($company)>0) {
                        $data_task = array(
                            'list_id' => $this->input->post('list_id'),
                            'ref' => $this->input->post('ref'),
                            'company_id' => $companies[$x],
                            'governorate_id' => $company['governorate_id'],
                            'district_id' => $company['district_id'],
                            'area_id' => $company['area_id'],
                            'sales_man_id' => $this->input->post('sales_man_ids'),
                            'year' => $this->input->post('year'),
                            'start_date' => $this->input->post('start_date'),
                            'due_date' => $this->input->post('due_date'),
                            'comments' => $this->input->post('comments'),
                            'status' => $this->input->post('status'),
                           // 'delivery_date'=> $delivery_date,
                            'payment_status' => $this->input->post('payment_status'),
                            'cost' => $cost,
                            'category' => $this->input->post('category'),
                            'create_time' => $this->datetime,
                            'update_time' => $this->datetime,
                            'user_id' => $this->session->userdata('id'),
                        );
                        if($this->General->save('tbl_tasks', $data_task))
                        {
                            $i=1;
                        }
                        }
                    } 
                    }
                    
                }
                elseif($this->input->post('type')=='area'){
                    
                    
                 //  $this->input->post('sales_man_id')
                 $arr[]=$this->input->post('governorate_id');
                 $arr[]=$this->input->post('district_id');
                 $arr[]=$this->input->post('area_id');
                 $arr[]=$this->input->post('sales_man_id');
                 //var_dump($arr);die();
                    $companies = $this->Task->GetCompaniesArea($this->input->post('governorate_id'),$this->input->post('district_id'),$this->input->post('area_id'),$this->input->post('sales_man_id'));

                    if(count($companies)>0)
                    {
                      
                        foreach($companies as $company)
                        {
                            $data_task=array(
                                'list_id'=>$this->input->post('list_id'),
                                'ref'=>$this->input->post('ref'),
                                'company_id'=>$company->id,
                                'governorate_id'=>$this->input->post('governorate_id'),
                                'district_id'=>$this->input->post('district_id'),
                                'area_id'=> $area_id,
                                'sales_man_id'=>$this->input->post('sales_man_id'),
                                'year'=>$this->input->post('year'),
                                'start_date'=>$this->input->post('start_date'),
                                'due_date'=>$this->input->post('due_date'),
                                'comments'=>$this->input->post('comments'),
                                'status'=>$this->input->post('status'),
                               // 'delivery_date'=> $delivery_date,
                                'payment_status'=>$this->input->post('payment_status'),
                                'cost' => $cost,
                                'category' => $this->input->post('category'),
                                'is_adv' => isset($is_adv) ? $is_adv : 0,
                                'copy_res' => isset($copy_res) ? $copy_res : 0 ,
                                'create_time'=>$this->datetime,
                                'update_time' => $this->datetime,
                                'user_id' => $this->session->userdata('id'),
                            );
                            if($this->General->save('tbl_tasks',$data_task))
                            {
                                $i++;
                            }

                        }
                    }

                }
                elseif($this->input->post('type')=='all'){
                     $companies = $this->Task->GetTaskCompanies('', '', '', '', 'all', '', '', '', 0, 0, $data_types,'');
                   
                    if(count($companies)>0)
                    {
                        
                        foreach($companies as $company)
                        {
                            $data_task=array(
                                'list_id'=>$this->input->post('list_id'),
                                'ref'=>$this->input->post('ref'),
                                'company_id'=>$company->id,
                                'governorate_id'=>$this->input->post('governorate_id'),
                                'district_id'=>$this->input->post('district_id'),
                                'area_id'=>  $area_id,//$this->input->post('area_id'),
                                'sales_man_id'=>$this->input->post('sales_man_id'),
                                'year'=>$this->input->post('year'),
                                'start_date'=>$this->input->post('start_date'),
                                'due_date'=>$this->input->post('due_date'),
                                'comments'=>$this->input->post('comments'),
                                'status'=>$this->input->post('status'),
                                //'delivery_date'=> $delivery_date,
                                'payment_status'=>$this->input->post('payment_status'),
                                'cost' => $cost,
                                'category' => $this->input->post('category'),
                                'is_adv' => isset($is_adv) ? $is_adv : 0,
                                'copy_res' => isset($copy_res) ? $copy_res : 0 ,
                                'create_time'=>$this->datetime,
                                'update_time' => $this->datetime,
                                'user_id' => $this->session->userdata('id'),
                            );
                            if($this->General->save('tbl_tasks',$data_task))
                            {
                                $i++;
                            }

                        }
                    }   
                }
                if ($i>0) { 
                    $this->session->set_userdata(array('done_message' => $i.' task(s) Added Successfully'));

                } else {
                    $this->session->set_userdata(array('error_message' => 'Error'));
                }
                redirect('tasks');


            }
            
            $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
            $this->data['districts'] = array();
            $this->data['areas'] = array();
            $this->data['sales'] = $this->Administrator->GetSalesMen();
            $this->data['array_companies']=array();

            $this->data['subtitle'] = 'Add New Task';
            $this->data['title'] = $this->data['Ctitle']."- Add New Task";
            $this->template->load('_template', 'tasks/tasks_form', $this->data);

    }
    public function edit($id) {
        if($this->p_edit) {
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Tasks', 'tasks');
            $this->breadcrumb->add_crumb('Edit Task');

            $this->form_validation->set_rules($this->TasksConfig);

            if($this->form_validation->run()) {
                $data = $this->DataArray('tbl_tasks', $this->input->post(), $this->TasksConfig, 'edit', $id);
                if (@$data['id']) {
                    $this->session->set_userdata(array('done_message' => 'Updated Successfully'));

                } else {
                    $this->session->set_userdata(array('error_message' => 'Error'));
                }
                redirect('tasks');


            }
            $this->data['query']=$this->Task->GetTaskById($id);
            $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
            $this->data['districts'] = array();
            $this->data['areas'] = array();
            $this->data['sales'] = $this->Administrator->GetSalesMen();

            $this->data['subtitle'] = 'Edit Task';
            $this->data['title'] = $this->data['Ctitle']."- Edit Task";
            $this->template->load('_template', 'tasks/tasks_form', $this->data);
        }
        else {
            redirect('tasks');
        }
    }
    public function salesmen()
    {
      //  $this->data['query'] =$this->Task->GetMonthlyTasks();
      //  echo '<pre>';
      //  var_dump($this->data['query']);
      //  die;
        $this->data['salesmen']=$this->Task->GetSalesMen();
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";;
        $this->data['subtitle'] = "احصاءات المندوبين";
        $this->template->load('_template', 'tasks/salesmen_report', $this->data);
    }
    public function updatepage()
    {
       
       $company=$this->Task->GetCompaniesD(0,0);
     
       
        foreach($company as $row)
        {
             $query=$this->Task->GetPagingDataByNameAr($row->name_ar);
             $query_en=$this->Task->GetPagingDataByNameEn($row->name_en);
            $paging_ar='';
            $paging_en='';
            $paging_ar_array=array();
            $paging_en_array=array();
            if(count($query)>0 or count($query_en)>0)
            {
                foreach($query as $row_ar)
                {
                    array_push($paging_ar_array,$row_ar->column_7.' ');
                   
                }
                 foreach($query_en as $row_en)
                {
                    array_push($paging_en_array,$row_en->column_7.' ');
                }
                $data=array(
                    'company_id'=>$row->id,
                    'guide_edition'=>'10',
                    'guide_pages_ar'=>implode(',',$paging_ar_array),
                    'guide_pages_en'=>implode(',',$paging_en_array),
                    'create_time' => $this->datetime,
                    'update_time' => $this->datetime,
                    'user_id' => 1
                    );
                    $this->General->save('tbl_companies_guide_pages',$data);
            }
        }
    }

}
?>