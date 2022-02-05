<?php

class Sales extends Application
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
        $this->ag_auth->restrict('sales'); // restrict this controller to admins only
        $this->load->model(array('Administrator', 'Item', 'Address', 'Company', 'Bank', 'Insurance', 'Parameter','Task','Deliverym','Salesm'));
        $this->data['Ctitle'] = 'Industry';
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');

        $this->p_add = $this->ag_auth->check_privilege(115, 'add');
        $this->p_edit = $this->ag_auth->check_privilege(112, 'edit');
        $this->p_view = $this->ag_auth->check_privilege(112, 'view');
        $this->p_delete = $this->ag_auth->check_privilege(112, 'delete');
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
        $salesman=$this->input->post('id');
        $salesman_array=array(array('salesman'=>$salesman,'area'=>array()));
        $category=$this->input->post('category');
        switch($category)
        {
            case 'general':
                $query=$this->Deliverym->GetCompaniesBySalesman($gov='',$district='',$area_id='',$salesman_array);
                echo count($query);

                break;
            case 'direct':

                break;

        }

    }
    public function GetArea()
    {

        $dist_id = $this->input->post('id');
        $category= $this->input->post('category');
        $gov= $this->input->post('gov');
        $array_category=explode(',',$category);

        if ($this->input->post('area_id')) {
            $area_id = $this->input->post('area_id');
        } else {
            $area_id = 0;
        }
        $array_category=array('company');
        $this->data['query']=$areas = $this->Salesm->GetAreaByDistrictID($gov,$dist_id,$array_category);

        //$this->load->view('delivery/_multi_select_area',$this->data);
        echo '<script type="text/javascript" src="'.base_url().'js/plugins/jquery/jquery-1.9.1.min.js"></script>
<script>
$(function () {
$("#checkAll").change(function(){
    var status = $(this).is(":checked") ? true : false;
    $(".check_area").prop("checked",status);
    var total=0;
    $(".check_area:checked").each( function() {
    total += Number($(this).attr("data-count"));
        
    });
    $("#TotalArea").html("Total Companies : "+total);
});
$(".check_area").change(function() {
var total=0;
    $(".check_area:checked").each( function() {
    total += Number($(this).attr("data-count"));
        
    });
    $("#TotalArea").html("Total Companies : "+total);
});
    })
</script>';

        echo '<div id="TotalArea" style="color: red; font-weight: bold; clear: both"></div>Check All : '.form_checkbox(array('name'=>'area_ids[]','id'=>'checkAll')).'<br><table class="table">';
        if (count($areas) > 0) {
            $i=0;
            echo '<tr>';
            foreach ($areas as $area) {


                if($i==5)
                {
                  echo '</tr><tr>';
                  $i=0;
                }
                echo '<td>'.form_checkbox(array('name'=>'area_ids[]','value'=>$area->id,'class'=>'check_area','data-count'=>$area->TotalCompanies)).'</td>';
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
                    if($this->p_delete){
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
                    if($this->p_delete){
                        $query=$this->Salesm->GetSalesTaskById($id);
                        $history=array('action'=>'delete','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['name'],'type'=>'delivery','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
                        $this->General->delete('sales',array('id'=>$id));
                        $this->General->delete('sales_items',array('sales_id'=>$id));
                        $this->General->delete('sales_schedules',array('sales_id'=>$id));
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

private function InsertGeneralDelivery($sales_man_id,$delivery_id,$status)
{
    $salesman_array=array(array('salesman'=>$sales_man_id,'area'=>array()));
    $query=$this->Deliverym->GetCompaniesBySalesman('','','',$salesman_array);
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
    private function InsertSalesArea($array_area,$sales_id,$status)
    {
        $query=$this->Salesm->GetCompaniesByAreaIds($array_area);
        if(count($query)>0)
        {
            foreach($query as $row)
            {
                $data=array(
                    'sales_id'=>$sales_id,
                    'item_id'=>$row->id,
                    'item_type'=>'company',
                    'status'=>$status,
                    'create_time' => $this->datetime,
                    'update_time' => $this->datetime,
                    'user_id' => $this->session->userdata('id'),
                );
                $this->General->save('sales_items',$data);
            }
        }
        return count($query);
    }
    private function InsertSalesCompanies($array_companies,$sales_id,$status)
    {

            for($i=0;$i<count($array_companies);$i++)
            {
                $data=array(
                    'sales_id'=>$sales_id,
                    'item_id'=>$array_companies[$i],
                    'item_type'=>'company',
                    'status'=>$status,
                    'create_time' => $this->datetime,
                    'update_time' => $this->datetime,
                    'user_id' => $this->session->userdata('id'),
                );
                $this->General->save('sales_items',$data);
            }

        return count($array_companies);
    }
    public function index($row = 0)
    {
        if($this->input->get('clear'))
        {
            redirect('sales');
        }
        $get_array=array();
        $limit = 10;
        $row = $this->input->get('per_page');
        $config['base_url'] = '?search=';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;

        $this->data['sales_id']=$sales_id=$this->input->get('sales_id');
        $this->data['salesman']=$salesman=$this->input->get('salesman');
        $this->data['company_id']=$company_id=$this->input->get('company_id');
        $this->data['status']=$status=$this->input->get('status');
        $query = $this->Salesm->GetSalesTasks($sales_id,$salesman,$company_id,$status,$row,$limit);

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
        $this->breadcrumb->add_crumb('Sales');
        $this->breadcrumb->add_crumb('Sales','sales');
        $this->data['title'] = $this->data['Ctitle'] . " Sales Tasks";
        $this->data['subtitle'] = " Sales Tasks";

        /*$this->data['legal_forms'] = $this->Magazine->GetLegalForms('active');
        $this->data['labels'] = $this->Magazine->GetLabels();
        $this->data['countries'] = $this->Magazine->GetCountries();
        $this->data['salesmen'] = $this->Magazine->GetSalesmen(); */

        $this->data['districts'] = $this->Address->GetDistrictByGov('online', @$get_array['governorate_id']);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', 0);
        $this->data['sales'] = $this->Company->GetSalesMen();
        $this->template->load('_template', 'sales/index', $this->data);
    }
    public function create() {
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Sales', 'sales');
        $this->breadcrumb->add_crumb('Add New');

        $this->form_validation->set_rules($this->RulesConfig);

        if($this->form_validation->run()) {
            $total=0;
            $data=array(
                'salesman_id' => $this->input->post('sales_man_id'),
                'version_id' => $this->input->post('version_id'),
                'category' => $this->input->post('category'),
                'status' => $this->input->post('status'),
                'total' => $total,
                'create_time' => $this->datetime,
                'update_time' => $this->datetime,
                'user_id' => $this->session->userdata('id'),
            );
            $sales_id=$this->General->save('sales',$data);
            if($sales_id>0)
            {
                $data_schedule=array(
                    'sales_id' => $sales_id,
                    'start_date' => $this->input->post('start_date'),
                    'end_date' => $this->input->post('due_date'),
                    'status' => 'pending',
                    'create_time' => $this->datetime,
                    'update_time' => $this->datetime,
                    'user_id' => $this->session->userdata('id'),
                );
                $this->General->save('sales_schedules',$data_schedule);


                  if($this->input->post('type')=='area') {
                      $array_area=$this->input->post('area_ids');
                      $total=$this->InsertSalesArea($array_area,$sales_id,$this->input->post('status'));
                  }
                  elseif($this->input->post('type')=='company')
                  {
                      $array_companies=$this->input->post('company_ids');
                      $total=$this->InsertSalesCompanies($array_companies,$sales_id,$this->input->post('status'));
                  }


                $this->Administrator->edit('sales',array('total'=>$total),$sales_id);
                $this->session->set_userdata(array('done_message' => $total.' Sales task(s) Added Successfully'));
            }
            else{
                $this->session->set_userdata(array('error_message' => 'Error'));
            }
            redirect('sales/listview/'.$sales_id);
        }

        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['districts'] = array();
        $this->data['areas'] = array();
        $this->data['sales'] = $this->Administrator->GetSalesMen();
        $this->data['array_companies']=array();
        $this->data['subtitle'] = 'Add Sales Task';
        $this->data['title'] = $this->data['Ctitle']."- Add  Sales Task";
        $this->template->load('_template', 'sales/sales_form', $this->data);
    }
    public function update()
    {
        if($this->p_edit)
        {
            
            if($this->input->post('save'))
            {
                $array=$this->input->post();
               
                $this->Salesm->UpdateSalesTasks($array);
                if($array['status']=='done')
                {
                    $xdelivery=$this->Deliverym->GetDeliveryTaskById($array['delivery_id']);
                    echo $xdelivery['salesman_id'].'<br>';
                    echo $array['delivery_man'].'<br>';
                   
                    if(@$array['delivery_id']=='' or $xdelivery['salesman_id']!=$array['delivery_man'])
                    {
                         $array_d=array(
                            'salesman_id'=>$array['delivery_man'],
                                'type'=>'guide',
                                'category'=>'general',
                                'total'=>1,
                                'delivery_data'=>$array['item_id'],
                                'status'=>$array['delivery_status'],
                                'create_time' => $this->datetime,
                                'update_time' => $this->datetime,
                                'user_id' => $this->session->userdata('id'),
                            );
                           $delivery_id=  $this->General->save('delivery',$array_d);
                           $action='add';
                           if($xdelivery['salesman_id']!=$array['delivery_man'])
                           {
                               $this->Administrator->delete('delivery_items',array('item_id'=>$array['item_id'],'delivery_id'=>$array['delivery_id']));
                           }
                    }
                    else{

                       $delivery_id=$array['delivery_id'];
                       $action='edit';
                    }
                    $delivery=$this->Deliverym->GetDeliveryTaskById($delivery_id);
                        
                   
                    
                    if(count($delivery)>0)
                    {
                       $array_delivery=array(
                                'delivery_id'=>$delivery_id,
                                'item_id'=>$array['item_id'],
                                'item_type'=>$array['item_type'],
                                'delivery_man_id'=>$array['delivery_man'],
                                'receiver_name'=>$array['receiver_name'],
                                'receiver_date'=>($array['receiver_date']!='') ? $array['receiver_date']: '0000-00-00 00:00:00',
                                'copy_quantity'=>$array['copy_quantity'],
                                'status'=>$array['delivery_status'],
                                'paid_status'=>$array['paid_status'],
                                'notes'=>$array['delivery_notes'],
                                'create_time' => $this->datetime,
                                'update_time' => $this->datetime,
                                'user_id' => $this->session->userdata('id'),
                    );
                    if($action=='add')
                    {
                        $this->General->save('delivery_items',$array_delivery);
                       
                    }
                    else{
                        unset($array_delivery['create_time']);
                        $this->Administrator->update('delivery_items',$array_delivery,array('item_id'=>$array['item_id'],'delivery_id'=>$delivery_id));
                    }
                $this->session->set_userdata(array('done_message' => ' Sales Task Updated Successfully<br>'.$msg_delivery));
                    }
                $this->session->set_userdata(array('error_message' => 'Error'.$msg_delivery));
                
            }
            
            }
        }
        else{
           $this->session->set_userdata(array('error_message' => 'Access Denied')); 
        }
        
        
        redirect($this->agent->referrer());

    }
    public function items($id,$status='')
    {
        if($this->input->get('clear'))
        {
            redirect('sales/items/'.$id.'/'.$status);
        }
        $get_array=array();
        $this->data['search'] = TRUE;
        $limit = 10;
        $row = $this->input->get('per_page');
        $config['base_url'] = '?search=';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $company_id=$this->input->get('company_id');
        $query = $this->Salesm->GetCompanies($id,$status,$row,$limit,$company_id);

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
        $this->breadcrumb->add_crumb('Sales');
        $this->breadcrumb->add_crumb('Sales','sales/items/'.$id);
        $this->data['title'] = $this->data['Ctitle'] ."Sales List : ".$id;;
        $this->data['subtitle'] = "Sales List : ".$id;

       /* $this->data['legal_forms'] = $this->Magazine->GetLegalForms('active');
        $this->data['labels'] = $this->Magazine->GetLabels();
        $this->data['countries'] = $this->Magazine->GetCountries();
        $this->data['salesmen'] = $this->Magazine->GetSalesmen();
 */
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', @$get_array['governorate_id']);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', 0);
        $this->data['sales'] = $this->Company->GetSalesMen();

        $this->template->load('_template', 'sales/items', $this->data);
    }
    public function listview($id,$status='')
    {
        $this->data['id']=$id;
        $this->data['status']=$status;
        $this->data['sales'] =$this->Salesm->GetSalesTaskById($id);
        $query = $this->Salesm->GetCompanies($id,$status, 0, 0);
        $this->data['query'] =$query['rows'];
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";
        $this->data['subtitle'] = "Companies - الشركات";
        $this->load->view('sales/listview', $this->data);
    }
    public function detailsview($id,$status='')
    {
        $query=$this->Salesm->GetCompanies($id,$status,0,0);
        foreach ($query['rows'] as $row)
        {
            $this->view($row->id);
        }
    }
    public function pages($id,$status='')
    {
        $companies=$this->Salesm->GetCompanies($id,$status,0,0,'');
        foreach ($companies['rows'] as $row)
        {
            $query = $this->Task->GetCompanyPagesById($row->id);
            $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";;
            $this->data['subtitle'] = "";
             $this->data['query'] = $query;
             $this->load->view('company/pages', $this->data);
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