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
            array_push($salesman_array,array('salesman'=>$salesman,'area'=>array()));
        }
        var_dump($salesman_array);
        die;
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
        $areas = $this->Deliverym->GetAreaByDistrictID('',$dist_id);
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
                echo '<td>'.form_checkbox(array('name'=>'area_id[]','value'=>$area->id)).'</td>';
                echo '<td nowrap style="direction: rtl">'.$area->label_ar.'('.$area->TotalCompanies.' )</td>';
                $i++;
                //$array_area[$area->id] = $area->label_ar . ' -' . $area->label_en.' ('.$area->TotalCompanies.' )';
            }
            echo '</tr>';
        }
        echo '</table>';

     //   echo form_multiselect('area_id[]', $array_area, $area_id, ' id="area_id" class="search-select"');
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
    public function GetCountriesJson()
    {
        $query=$this->Magazine->GetAllGeo();
        echo json_encode($query);
    }
    public function GetGovernoratesJson($id)
    {
        $query=$this->Magazine->GetAllGovernorateByCountry($id);
        echo json_encode($query);
    }
    public function GetDistrictJson($id)
    {
        $query=$this->Magazine->GetDistrictJsonByGovernorate($id);
        echo json_encode($query);
    }
    public function GetAreaJson($id)
    {
        $query=$this->Magazine->GetAreaJsonByDistrict($id);
        echo json_encode($query);
    }
    public function GetActivities()
    {
        $query=$this->Magazine->GetActivities('active');
        echo json_encode($query);
    }
    public function GetSources()
    {
        $query=$this->Magazine->GetSources('active');
        echo json_encode($query);
    }

    public function index($row = 0)
    {
        $get_array=array();
        $this->data['search'] = TRUE;
        $limit = 10;
        $row = $this->input->get('per_page');
        $config['base_url'] = '';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;


        $query = $this->Magazine->GetCompanies(array(), $row, $limit);

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
        $this->breadcrumb->add_crumb('Magazines');
        $this->breadcrumb->add_crumb('Companies','magazines/companies');
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";
        $this->data['subtitle'] = "Companies - الشركات";

        $this->data['legal_forms'] = $this->Magazine->GetLegalForms('active');
        $this->data['labels'] = $this->Magazine->GetLabels();
        $this->data['countries'] = $this->Magazine->GetCountries();
        $this->data['salesmen'] = $this->Magazine->GetSalesmen();

        $this->data['districts'] = $this->Address->GetDistrictByGov('online', @$get_array['governorate_id']);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', 0);
        $this->data['sales'] = $this->Company->GetSalesMen();
        $this->template->load('_template', 'magazines/companies', $this->data);
    }
    public function create() {
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Delivery', 'delivery');
        $this->breadcrumb->add_crumb('Add New');

        $this->form_validation->set_rules($this->RulesConfig);

        if($this->form_validation->run()) {
            $i=0;
            $data_types=$this->input->post('data_types');
            $data=array(
                'salesman_id' => $this->input->post('sales_man_id'),
                'type' => $this->input->post('delivery_type'),
                'category' => $this->input->post('category'),
                'status' => $this->input->post('status'),
                'total' => $company['district_id'],
                'create_time' => $this->datetime,
                'update_time' => $this->datetime,
                'user_id' => $this->session->userdata('id'),
            );
            $delivery_id=$this->General->save('delivery',$data);
            if($this->input->post('type')=='company'){

                $companies=$this->input->post('company_ids');
                $Total=count($companies);
                if(count($companies)>0){
                    for($x=0;$x<count($companies);$x++){
                        $company=$this->Company->GetCompanyById($companies[$x]);
                        if(count($company)>0) {
                            $data_task = array(
                                'delivery_id' => $delivery_id,
                                'item_id' => $companies[$x],
                                'item_type' => 'company',
                                'status' => $this->input->post('status'),
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




                $companies = $this->Company->GetTaskCompanies('', '', '', '', 'all', $this->input->post('governorate_id'), $this->input->post('district_id'), $this->input->post('area_id'), 0, 0, $data_types,$this->input->post('sales_man_id'));

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
                            'area_id'=>$this->input->post('area_id'),
                            'sales_man_id'=>$this->input->post('sales_man_id'),
                            'year'=>$this->input->post('year'),
                            'start_date'=>$this->input->post('start_date'),
                            'due_date'=>$this->input->post('due_date'),
                            'comments'=>$this->input->post('comments'),
                            'status'=>$this->input->post('status'),
                            'payment_status'=>$this->input->post('payment_status'),
                            'category' => $this->input->post('category'),
                            'is_adv' => $is_adv,
                            'copy_res' => $copy_res,
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
                $companies = $this->Task->GetTaskCompanies('', '', '', '', 'all', '', '', '', 0, 0, $data_types,$this->input->post('sales_man_id'));

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
                            'area_id'=>$this->input->post('area_id'),
                            'sales_man_id'=>$this->input->post('sales_man_id'),
                            'year'=>$this->input->post('year'),
                            'start_date'=>$this->input->post('start_date'),
                            'due_date'=>$this->input->post('due_date'),
                            'comments'=>$this->input->post('comments'),
                            'status'=>$this->input->post('status'),
                            'payment_status'=>$this->input->post('payment_status'),
                            'category' => $this->input->post('category'),
                            'is_adv' => $is_adv,
                            'copy_res' => $copy_res,
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

        $this->data['subtitle'] = 'Add Delivery Task';
        $this->data['title'] = $this->data['Ctitle']."- Add  Delivery Task";
        $this->template->load('_template', 'delivery/delivery_form', $this->data);

    }
}

?>