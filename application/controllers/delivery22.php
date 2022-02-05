<?php

class Delivery extends Application
{
    var $company = 'tbl_company';
    var $company_heading = 'tbl_company_heading';
    var $company_banks = 'tbl_banks_company';
    var $company_insurance = 'tbl_insurances_company';
    var $company_markets = 'tbl_markets_company';
    var $position = 'tbl_positions';
    var $company_power = 'tbl_power_company';
    var $p_delete = FALSE;
    var $p_edit = FALSE;
    var $p_add = FALSE;
    var $p_production = FALSE;
    var $p_export = FALSE;
    var $p_insurance = FALSE;
    var $p_banks = FALSE;
    var $p_power = FALSE;
    var $p_app = FALSE;
    var $p_statement = FALSE;
    var $page_denied = '';

    public function __construct()
    {

        parent::__construct();
        $this->ag_auth->restrict('delivery'); // restrict this controller to admins only
        $this->load->model(array('Administrator', 'Item', 'Address', 'Company', 'Bank', 'Insurance', 'Parameter','Task','Deliverym'));
        $this->data['Ctitle'] = 'Industry';
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');

        $this->p_delivery_add = $this->ag_auth->check_privilege(114, 'add');
        $this->p_delivery_edit = $this->ag_auth->check_privilege(115, 'edit');
        $this->p_delivery_view = $this->ag_auth->check_privilege(115, 'view');
        $this->p_delivery_delete = $this->ag_auth->check_privilege(115, 'delete');
        $this->RulesConfig = array(
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


    }

    public function GetSalesmanCompanies()
    {
        $salesman_array=array();
        $salesman=$this->input->post('id');
        $salesmen_all=$this->input->post('salesmen');
        $salesmen_all_array=explode(',',$salesmen_all);
        if(!in_array($salesman,$salesmen_all_array))
        {
            array_push($salesmen_all_array,$salesman);
        }
        for($i=0;$i<count($salesmen_all_array);$i++)
        {
            if($salesmen_all_array[$i]>0){
                array_push($salesman_array,array('salesman'=>$salesmen_all_array[$i],'area'=>array()));
            }
        }

        $category=$this->input->post('category');
        switch($category)
        {
            case 'general':
                $x=0;
                $query=$this->Deliverym->GetCompaniesBySalesman($gov='',$district='',$area_id='',$salesman_array);
                foreach($query as $row)
                {
                    if($salesman==$row->delivery_by or $row->delivery_by=='')
                    {
                        $x++;
                    }

                }

                echo $x;

                break;
            case 'direct':

                break;

        }

    }
    public function GetArea()
    {
        $salesman_array=array();
        $salesman=$this->input->post('sales_man');
        $salesmen_all=$this->input->post('salesmen');
        $salesmen_all_array=explode(',',$salesmen_all);
        if(!in_array($salesman,$salesmen_all_array))
        {
            array_push($salesmen_all_array,$salesman);
        }
        for($i=0;$i<count($salesmen_all_array);$i++)
        {
            if($salesmen_all_array[$i]>0){
                array_push($salesman_array,array('salesman'=>$salesmen_all_array[$i],'area'=>array()));
            }
        }

        $dist_id = $this->input->post('id');
        $gov = $this->input->post('gov');
        if ($this->input->post('area_id')) {
            $area_id = $this->input->post('area_id');
        } else {
            $area_id = 0;
        }
        $this->data['query']=$areas = $this->Deliverym->GetAreaByDistrictID($gov,$dist_id,$salesman_array);
        //$this->load->view('delivery/_multi_select_area',$this->data);

        echo '<table class="table">';
        if (count($areas) > 0) {
            $i=0;
            echo '<tr>';
            foreach ($areas as $area) {


                if($i==5)
                {
                    echo '</tr><tr>';
                    $i=0;
                }
                echo '<td>'.form_checkbox(array('name'=>'area_ids[]','value'=>$area->id)).'</td>';
                echo '<td nowrap style="direction: rtl">'.$area->label_ar.'('.$area->TotalCompanies.' )</td>';
                $i++;
                //$array_area[$area->id] = $area->label_ar . ' -' . $area->label_en.' ('.$area->TotalCompanies.' )';
            }
            echo '</tr>';
        }
        echo '</table>';






    }
    public function delete($id,$type)
    {
        if((int)$id > 0){
            switch($type)
            {
                case 'items':
                    if($this->p_delivery_delete){
                        $query=$this->Deliverym->GetActivityById($id);
                        $history=array('action'=>'delete','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['id'],'type'=>'delivery_items','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
                        // $h_id=$this->General->save('logs',$history);
                        $this->General->delete('delivery_items',array('id'=>$id));
                        $this->session->set_userdata(array('admin_message'=>'Deleted'));
                        redirect($this->agent->referrer());
                    }
                    else{
                        $this->session->set_userdata(array('admin_message'=>'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;
                case 'delivery':
                    if($this->p_delivery_delete){
                        $query=$this->Deliverym->GetSourceById($id);
                        $history=array('action'=>'delete','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['name'],'type'=>'delivery','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
                        // $h_id=$this->General->save('logs',$history);
                        $this->General->delete('delivery',array('id'=>$id));
                        $this->session->set_userdata(array('admin_message'=>'Deleted'));
                        redirect($this->agent->referrer());
                    }
                    else{
                        $this->session->set_userdata(array('admin_message'=>'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;

            }
        }
        redirect($this->agent->referrer());
    }

    private function InsertGeneralDelivery($sales_id,$sales_man_id,$delivery_id,$status,$area_array=array())
    {

        $query=$this->Deliverym->GetCompaniesBySalesman('','',$area_array,$sales_man_id);
        if(count($query)>0)
        {
            foreach($query as $row)
            {
                $x=0;
                if($row->delivery>0){
                    $status='done';
                }
                else{
                    $status='pending';
                }
                if($sales_id==$row->delivery_by or $row->delivery==0)
                {
                    $x=1;
                }
                else
                {
                    $x=0;
                }
                if($x>0){
                $data=array(
                    'delivery_id'=>$delivery_id,
                    'item_id'=>$row->id,
                    'item_type'=>'company',
                    'receiver_name'=>$row->receiver_name,
                    'receiver_date'=>$row->delivery_date,
                    'status'=>$status,
                    'create_time' => $this->datetime,
                    'update_time' => $this->datetime,
                    'user_id' => $this->session->userdata('id'),
                );
                $this->General->save('delivery_items',$data);
                }

            }
        }
        return count($query);
    }
    private function InsertDirectDeliveryArea($array_area,$delivery_id,$status)
    {
        $query=$this->Deliverym->GetCompaniesByAreaIds($array_area);
        if(count($query)>0)
        {
            foreach($query as $row)
            {
                $data=array(
                    'delivery_id'=>$delivery_id,
                    'item_id'=>$row->id,
                    'item_type'=>'company',
                    'status'=>$status,
                    'create_time' => $this->datetime,
                    'update_time' => $this->datetime,
                    'user_id' => $this->session->userdata('id'),
                );
                $this->General->save('delivery_items',$data);
            }
        }
        return count($query);
    }
    private function InsertDirectDeliveryCompanies($array_companies,$delivery_id,$status)
    {

        for($i=0;$i<count($array_companies);$i++)
        {
            $data=array(
                'delivery_id'=>$delivery_id,
                'item_id'=>$array_companies[$i],
                'item_type'=>'company',
                'status'=>$status,
                'create_time' => $this->datetime,
                'update_time' => $this->datetime,
                'user_id' => $this->session->userdata('id'),
            );
            $this->General->save('delivery_items',$data);
        }

        return count($array_companies);
    }
    public function index($row = 0)
    {
        $get_array=array();
        $this->data['search'] = TRUE;
        $limit = 10;
        $row = $this->input->get('per_page');
        $config['base_url'] = 'delivery?search=';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;

        $this->data['delivery_id']=$delivery_id=$this->input->get('delivery_id');
        $this->data['salesman']=$salesman=$this->input->get('salesman');
        $this->data['company_id']=$company_id=$this->input->get('company_id');
        $this->data['status']=$status=$this->input->get('status');
        $query = $this->Deliverym->GetDeliveryTasks($delivery_id,$salesman,$company_id,$status,$row,$limit);

        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $this->data['total_row'] =$config['total_rows'] = $query['total'];
        $config['per_page'] = $limit;

        $config['num_links'] = 6;


        $this->pagination->initialize($config);
        $this->data['query'] = $query['rows'];

        $this->data['links'] = $this->pagination->create_links();
        $this->data['st'] = $this->uri->segment(4);

        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Delivery');
        $this->breadcrumb->add_crumb('Delivery','delivery');
        $this->data['title'] = $this->data['Ctitle'] . " Delivery Tasks";
        $this->data['subtitle'] = "Delivery Tasks - ADV / COPY";

        /*$this->data['legal_forms'] = $this->Magazine->GetLegalForms('active');
        $this->data['labels'] = $this->Magazine->GetLabels();
        $this->data['countries'] = $this->Magazine->GetCountries();
        $this->data['salesmen'] = $this->Magazine->GetSalesmen(); */

        $this->data['districts'] = $this->Address->GetDistrictByGov('online', @$get_array['governorate_id']);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', 0);
        $this->data['sales'] = $this->Company->GetSalesMen();
        $this->template->load('_template', 'delivery/index', $this->data);
    }
    public function create() {
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Delivery', 'delivery');
        $this->breadcrumb->add_crumb('Add New');

        $this->form_validation->set_rules($this->RulesConfig);

        if($this->form_validation->run()) {
            $total=0;
            $salesman_array=array();
            $salesmen_all_array=$this->input->post('sales_men');

            $salesman=$this->input->post('sales_man_id');
            if(!in_array($salesman,$salesmen_all_array))
            {
                array_push($salesmen_all_array,$salesman);
            }

            for($i=0;$i<count($salesmen_all_array);$i++)
            {
                if($salesmen_all_array[$i]>0){
                    array_push($salesman_array,array('salesman'=>$salesmen_all_array[$i],'area'=>array()));
                }
            }
            $data=array(
                'salesman_id' => $this->input->post('sales_man_id'),
                'type' => $this->input->post('delivery_type'),
                'category' => $this->input->post('category'),
                'status' => $this->input->post('status'),
                'total' => $total,
                'delivery_data'=>implode(',',$salesmen_all_array),
                'create_time' => $this->datetime,
                'update_time' => $this->datetime,
                'user_id' => $this->session->userdata('id'),
            );
            $area_ids=array();
            $delivery_id=$this->General->save('delivery',$data);
            if($delivery_id>0)
            {

                $data_schedule=array(
                    'delivery_id' => $delivery_id,
                    'start_date' => $this->input->post('start_date'),
                    'end_date' => $this->input->post('due_date'),
                    'status' => 'pending',

                    'create_time' => $this->datetime,
                    'update_time' => $this->datetime,
                    'user_id' => $this->session->userdata('id'),
                );
                $this->General->save('delivery_schedules',$data_schedule);
                $area_ids=$this->input->post('area_ids');


                    $total=$this->InsertGeneralDelivery($salesman,$salesman_array,$delivery_id,$this->input->post('status'),$area_ids);

                /*if($this->input->post('category')=='direct')
                {
                    if($this->input->post('type')=='area') {
                        $array_area=$this->input->post('area_ids');
                        $total=$this->InsertDirectDeliveryArea($array_area,$delivery_id,$this->input->post('status'));
                    }
                    elseif($this->input->post('type')=='company')
                    {
                        $array_companies=$this->input->post('company_ids');
                        $total=$this->InsertDirectDeliveryCompanies($array_companies,$delivery_id,$this->input->post('status'));
                    }

                } */
                $this->Administrator->edit('delivery',array('total'=>$total),$delivery_id);
                $this->session->set_userdata(array('done_message' => $total.' Delivery task(s) Added Successfully'));
            }
            else{
                $this->session->set_userdata(array('error_message' => 'Error'));
            }
            redirect('delivery/listview/'.$delivery_id);
        }

        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['districts'] = array();
        $this->data['areas'] = array();
        $this->data['sales'] = $this->Administrator->GetSalesMen();
        $this->data['array_companies']=array();
        $this->data['subtitle'] = 'Add Delivery Task';
        $this->data['title'] = $this->data['Ctitle']."- Add  Delivery Task";
        $this->template->load('_template', 'delivery/delivery_form', $this->data);
    }
    public function items($id,$status='')
    {
        $get_array=array();
        $this->data['search'] = TRUE;
        $limit = 10;
        $row = $this->input->get('per_page');
        $config['base_url'] = '';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;


        $query = $this->Deliverym->GetCompanies($id, $status,$row, $limit);

        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $this->data['total_row'] =$config['total_rows'] = $query['total'];
        $config['per_page'] = $limit;

        $config['num_links'] = 6;


        $this->pagination->initialize($config);
        $this->data['query'] = $query['rows'];

        $this->data['links'] = $this->pagination->create_links();
        $this->data['st'] = $this->uri->segment(4);

        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Delivery');
        $this->breadcrumb->add_crumb('Delivery','delivery/items/'.$id);
        $this->data['title'] = $this->data['Ctitle'] ."Delivery List : ".$id;;
        $this->data['subtitle'] = "Delivery List : ".$id;

        /* $this->data['legal_forms'] = $this->Magazine->GetLegalForms('active');
         $this->data['labels'] = $this->Magazine->GetLabels();
         $this->data['countries'] = $this->Magazine->GetCountries();
         $this->data['salesmen'] = $this->Magazine->GetSalesmen();
  */
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', @$get_array['governorate_id']);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', 0);
        $this->data['sales'] = $this->Company->GetSalesMen();

        $this->template->load('_template', 'delivery/items', $this->data);
    }
    public function listview($id,$status='')
    {
        $this->data['id']=$id;
        $this->data['status']=$status;
        $this->data['delivery'] = $this->Deliverym->GetDeliveryTasksById($id,'','',$status);
        $query = $this->Deliverym->GetCompanies($id,$status, 0, 0);
        $this->data['query'] =$query['rows'];
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";
        $this->data['subtitle'] = "Companies - الشركات";
        $this->load->view('delivery/listview', $this->data);
    }
    public function detailsview($id,$status='')
    {
        $query=$this->Deliverym->GetCompanies($id,$status,0,0);
        foreach ($query['rows'] as $row)
        {
            $this->view($row->id);
        }
    }
    public function view($id)
    {

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
}

?>