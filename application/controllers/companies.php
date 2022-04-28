<?php

class Companies extends Application
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
        $this->ag_auth->restrict('companies'); // restrict this controller to admins only
        $this->load->model(array('Administrator', 'Item', 'Address', 'Company', 'Bank', 'Insurance', 'Parameter','Task'));
        $this->data['Ctitle'] = 'Industry';
        $this->p_delete = $this->ag_auth->check_privilege(4, 'delete');
        $this->p_edit = $this->ag_auth->check_privilege(4, 'edit');
        $this->p_production = $this->ag_auth->check_privilege(4, 'production');
        $this->p_export = $this->ag_auth->check_privilege(4, 'export');
        $this->p_insurance = $this->ag_auth->check_privilege(4, 'insurance');
        $this->p_banks = $this->ag_auth->check_privilege(4, 'banks');
        $this->p_power = $this->ag_auth->check_privilege(4, 'power');
        $this->p_app = $this->ag_auth->check_privilege(4, 'app');
        $this->p_add = $this->ag_auth->check_privilege(3, 'add');
        
        $this->p_branches = $this->ag_auth->check_privilege(4, 'branches');
        $this->p_branch_add = $this->ag_auth->check_privilege(4, 'branch_add');
        $this->p_branch_edit = $this->ag_auth->check_privilege(4, 'branch_edit');
        $this->p_branch_delete = $this->ag_auth->check_privilege(4, 'branch_delete');

        $this->data['p_update_info'] = $this->p_update_info = $this->ag_auth->check_privilege(4, 'update_info');
        $this->data['p_acc'] = $this->p_acc = $this->ag_auth->check_privilege(4, 'acc');

        $this->data['p_delete'] = $this->p_delete;
        $this->data['p_edit'] = $this->p_edit;
        $this->data['p_add'] = $this->p_add;
        $this->data['p_production'] = $this->p_production;
        $this->data['p_export'] = $this->p_export;
        $this->data['p_insurance'] = $this->p_insurance;
        $this->data['p_banks'] = $this->p_banks;
        $this->data['p_power'] = $this->p_power;
        $this->data['p_app'] = $this->p_app;
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

    public function compare()
    {
        $array1 = array('x' => 'Lo', 'y' => 'FFF', 'z' => 'hhh');
        $array2 = array('x' => 'Lo', 'y' => 'nnn', 'z' => 'hhh');

        $newdata = $this->Administrator->affected_fields($array1, $array2);
        var_dump($newdata);
    }

    public function reset_advertisment()
    {
        $this->Administrator->edit_all($this->company, array('is_adv' => 0));
        $this->session->set_userdata(array('admin_message' => 'All Advertised has been reset'));
        redirect('companies');
    }

    public function reset_reservations()
    {
        $this->Administrator->edit_all($this->company, array('copy_res' => 0));
        $this->session->set_userdata(array('admin_message' => 'All Reserved Capy has been reset'));
        redirect('companies');
    }

    public function put_online()
    {
        $this->Administrator->edit_all($this->company, array('show_online' => 1));
        $this->session->set_userdata(array('admin_message' => 'All Companies has been Online'));
        redirect('companies');
    }

    public function put_offline()
    {
        $this->Administrator->edit_all($this->company, array('show_online' => 0));
        $this->session->set_userdata(array('admin_message' => 'All Companies has been Offline'));
        redirect('companies');
    }
 public function show_items($id,$status)
    {
        $this->Administrator->edit($this->company, array('show_items' => $status),$id);
        $this->session->set_userdata(array('admin_message' => 'Updated'));
        redirect($this->agent->referrer());
    }
    public function remove($id)
    {
        $this->Administrator->edit($this->company, array('adv_pic' => ''), $id);
        $this->session->set_userdata(array('admin_message' => 'Image Deleted'));
        redirect('companies/details/' . $id);
    }

    public function editimage()
    {
        if (isset($_POST)) {
            $id = $this->input->post('editimageid');
            $array = $this->Administrator->do_upload('uploads/', 'adimage');

            if ($array['target_path'] != "") {
                $path = $array['target_path'];
                $this->Administrator->edit($this->company, array('adv_pic' => $path), $id);
            }
            $msg = $array['error'];
            $this->session->set_userdata(array('admin_message' => $msg));
            redirect('companies/details/' . $id);
        }
    }

    public function DisplayItem()
    {
        $item_id = $_POST['id'];
        $items = $this->Item->GetItemById($item_id);
        if (count($items) > 0) {

            echo $items['label_ar'] . '<br><hr />' . $items['label_en'];
        }
    }

    public function addproduct()
    {
        $id = $_POST['id'];
        $companyid = $_POST['companyid'];
        $production = $this->Item->GetItemById($id);
        $data = array(
            'company_id' => $companyid,
            'heading_id' => $id,
            'create_time' => $this->datetime,
            'update_time' => $this->datetime,
            'user_id' => $this->session->userdata('id'),
        );

        if ($this->General->save($this->company_heading, $data)) {
            echo '<div class="alert alert-success" id="success">' . $production['hs_code_print'] . ' : ' . $production['description_ar'] . '  Added</div>';
        }
    }

    public function change_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $this->Administrator->edit($this->company, array('show_online' => $status), $id);
        if ($status == 1)
            echo '<a href="javascript:;" onclick="change_status(' . $id . ',0)"><span class="label label-success">Online</span></a>';
        else
            echo '<a href="javascript:;" onclick="change_status(' . $id . ',1)"><span class="label">Offline</span></a>';
    }

    public function SearchProduction()
    { 
        $heading_ids = array();
        $code = $_POST['code'];
        $description = $_POST['description'];
        $productions = $this->Company->GetProductionInfo($_POST['companyid']);
        foreach ($productions as $production) {
            array_push($heading_ids, $production->heading_id);
        }
        $items = $this->Company->SearchProductions($code, $description);
        $this->data['items'] = $items;
        $this->data['companyid'] = $_POST['companyid'];
        $this->data['productions'] = $productions;
        $this->data['HeadingIds'] = $heading_ids;
        $this->load->view('company/production_list', $this->data);
    }

    public function AddProductions()
    {
        $companyid = $this->input->post('companyid');
        $items_array = $this->input->post('checkbox1');
        $msg = '';
        for ($i = 0; $i < count($items_array); $i++) {
            $production = $this->Item->GetItemById($items_array[$i]);
            $data = array(
                'company_id' => $companyid,
                'heading_id' => $items_array[$i],
                'create_time' => $this->datetime,
                'update_time' => $this->datetime,
                'user_id' => $this->session->userdata('id'),
            );

            if ($nid = $this->General->save($this->company_heading, $data)) {
                $company = $this->Company->GetCompanyById($companyid);
                $row = $this->Company->GetProductionInfoById($nid);
                $details = array('HSCode' => $row['hscode'], 'Arabic Description' => $row['description_ar'], 'English Description' => $row['description_en']);
                $history = array('action' => 'add', 'logs_id' => 0, 'item_id' => $companyid, 'item_title' => $company['name_ar'], 'type' => 'company_heading', 'details' => json_encode($details), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);
            }
        }
        $this->session->set_userdata(array('admin_message' => 'Added'));
        redirect('companies/productions/' . $companyid);
    }

    public function DisplayBank()
    {
        $item_id = $_POST['id'];
        $items = $this->Bank->GetBankById($item_id);
        if (count($items) > 0) {

            echo $items['name_ar'] . '<br><hr />' . $items['name_en'];
        }
    }

    public function DisplayInsurance()
    {
        $item_id = $_POST['id'];
        $items = $this->Insurance->GetInsuranceById($item_id);
        if (count($items) > 0) {

            echo $items['name_ar'] . '<br><hr />' . $items['name_en'];
        }
    }

    public function GetMarketByCountry()
    {
        echo '<script>
        $(document).ready(function() {
			$("#market_id").select2();
        });
    </script>';

        $market_option = 'id="market_id" style="width:300px"';

        $country_id = $_POST['id'];
        $markets = $this->Company->GetMarketByCountryId('online', $country_id);
        if (count($markets) > 0) {
            $array_markets[0] = 'All';
            foreach ($markets as $market) {
                $array_markets[$market->id] = $market->title_ar . ' (' . $market->title_en . ' )';
            }
        } else {
            $array_markets[''] = 'No Data Found';
        }
        echo form_dropdown('market_id', $array_markets, '', $market_option);
    }

    public function GetDataSection()
    {
        $sector_id = $_POST['id'];
        $section_id = $_POST['section_id'];
        $sections = $this->Item->GetSectionsBySectorId('online', $sector_id);
        if (count($sections) > 0) {
            $array_section[0] = 'All';
            foreach ($sections as $section) {
                $array_section[$section->id] = $section->label_ar;
            }
        } else {
            $array_section[''] = 'No Data Found';
        }
        echo form_dropdown('section', $array_section, $section_id);
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
            $("#district_id").select2();
        });
    </script>';
        $jsdis = 'id="district_id" onchange="getarea(this.value)" class="search-select" required="required"';
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
        $areas = $this->Company->GetAreaByDistrictID('online', $dist_id);
        if (count($areas) > 0) {
            $array_area[''] = 'All';
            foreach ($areas as $area) {
                $array_area[$area->id] = $area->label_ar . ' -' . $area->label_en;
            }
        } else {
            $array_area[0] = 'No Data Found';
        }

        echo form_dropdown('area_id', $array_area, $area_id, ' id="area_id" class="search-select"');
    }

    public function GetDataSection1()
    {
        $sector_id = $_POST['id'];
        $section_id = $_POST['section_id'];
        $sections = $this->Item->GetSectionsBySectorId('online', $sector_id);
        if (count($sections) > 0) {
            foreach ($sections as $section) {
                $array_section[$section->id] = $section->label_ar;
            }
        } else {
            $array_section[''] = 'No Data Found';
        }
        echo form_dropdown('section', $array_section, $section_id);
    }

    public function delete()
    {
        $get = $this->uri->ruri_to_assoc();
        if ((int)$get['id'] > 0) {
            switch ($get['p']) {
                case 'ministry':

                    $query = $this->Company->GetMinistryCompanyById($get['id']);
                    $data = array(
                        'nbr_source' => $query['note'],
                        'type_source' => $query['type'],
                        'update_time' => $this->datetime,
                        'user_id' => $this->session->userdata('id'),
                    );
                    $this->Administrator->edit($this->company, $data, $get['cid']);
                    $history = array('action' => 'delete', 'logs_id' => 0, 'item_id' => $get['id'], 'item_title' => $query['name'], 'type' => 'company-ministry', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $h_id = $this->General->save('logs', $history);
                    $this->General->delete('ministry_industry', array('id' => $get['id']));
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect($this->agent->referrer());

                    break;
                case 'company':
                    if ($this->p_delete) {

                        $query = $this->Company->GetCompanyById($get['id']);
                        $history = array('action' => 'delete', 'logs_id' => 0, 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'company', 'details' => json_encode($query), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $h_id = $this->General->save('logs', $history);
                        //Electrical Power
                        $power = $this->Company->GetCompanyEPower($get['id']);
                        $history_power = array('logs_id' => $h_id, 'action' => 'delete', 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'power_company', 'details' => json_encode($power), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history_power);
                        $this->General->delete('tbl_power_company', array('company_id' => $get['id']));
                        //Production
                        $items = $this->Company->GetProductionInfo($get['id']);
                        $history_items = array('logs_id' => $h_id, 'action' => 'delete', 'details' => json_encode($items), 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'company_heading', 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history_items);
                        $this->General->delete('tbl_company_heading', array('company_id' => $get['id']));
                        //Insurance
                        $insurance = $this->Company->GetCompanyInsurances($get['id']);
                        $history_insurance = array('logs_id' => $h_id, 'action' => 'delete', 'details' => json_encode($insurance), 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'insurances_company', 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history_insurance);
                        $this->General->delete('tbl_insurances_company', array('company_id' => $get['id']));
                        //Banks
                        $banks = $this->Company->GetCompanyBanks($get['id']);
                        $history_banks = array('logs_id' => $h_id, 'action' => 'delete', 'details' => json_encode($banks), 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'banks_company', 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history_banks);
                        $this->General->delete('tbl_banks_company', array('company_id' => $get['id']));
                        //Export
                        $exports = $this->Company->GetCompanyMarkets($get['id']);
                        $history_exports = array('logs_id' => $h_id, 'action' => 'delete', 'details' => json_encode($exports), 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'markets_company', 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history_exports);
                        $this->General->delete('tbl_markets_company', array('company_id' => $get['id']));
                        //Statements
                        $statements = $this->Company->GetStatementsByCompanyId($get['id']);
                        $history_statements = array('logs_id' => $h_id, 'action' => 'delete', 'details' => json_encode($statements), 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'statements_company', 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history_statements);
                        $this->General->delete('tbl_companies_statements', array('company_id' => $get['id']));
                        //Applications
                        $app = $this->Company->GetApplicationsByCompany($get['id']);
                        $history_app = array('logs_id' => $h_id, 'action' => 'delete', 'details' => json_encode($app), 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'posting_companies', 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history_app);
                        $this->General->delete('posting_companies', array('company_id' => $get['id']));

                        //Delete Company
                        $this->General->delete('tbl_company', array('id' => $get['id']));
                        $this->General->delete('task_activities', array('item_id' => $get['id']));
                        $this->General->delete('tbl_company_branches', array('company_id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('companies');
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;

                case 'power':
                    if ($this->p_power) {
                        $query = $this->Company->GetCompanyElectricPowerById($get['id']);
                        $company = $this->Company->GetCompanyById($get['cid']);
                        $history = array('logs_id' => 0, 'action' => 'delete', 'details' => json_encode($query), 'item_id' => $get['id'], 'item_title' => $company['name_ar'], 'type' => 'power_company', 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history);
                        $this->General->delete('tbl_power_company', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('companies/power/' . $get['cid']);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;

                case 'items':
                    if ($this->p_production) {
                        $query = $this->Company->GetProductionInfoById($get['id']);
                        $company = $this->Company->GetCompanyById($get['cid']);
                        $details = array('HSCode' => $query['hscode'], 'title_ar' => $query['heading_ar'], 'title_en' => $query['heading_en']);
                        $history = array('logs_id' => 0, 'action' => 'delete', 'details' => json_encode($details), 'item_id' => $get['id'], 'item_title' => $company['name_ar'], 'type' => 'company_heading', 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history);
                        $this->General->delete('tbl_company_heading', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('companies/productions/' . $get['cid']);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;
                case 'insurance':
                    if ($this->p_insurance) {
                        $query = $this->Company->GetCompanyInsuranceById($get['id']);
                        $company = $this->Company->GetCompanyById($get['cid']);
                        $details = array('id' => $query['insurance_id'], 'name_ar' => $query['insurance_ar'], 'name_en' => $query['insurance_en']);
                        $history = array('logs_id' => 0, 'action' => 'delete', 'details' => json_encode($details), 'item_id' => $get['id'], 'item_title' => $company['name_ar'], 'type' => 'insurances_company', 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history);
                        $this->General->delete('tbl_insurances_company', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('companies/insurances/' . $get['cid']);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;

                case 'bank':
                    if ($this->p_banks) {
                        $query = $this->Company->GetCompanyBankById($get['id']);
                        $company = $this->Company->GetCompanyById($get['cid']);
                        $details = array('id' => $query['bank_id'], 'name_ar' => $query['bank_ar'], 'name_en' => $query['bank_en']);
                        $history = array('logs_id' => 0, 'action' => 'delete', 'details' => json_encode($details), 'item_id' => $get['id'], 'item_title' => $company['name_ar'], 'type' => 'banks_company', 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history);
                        $this->General->delete('tbl_banks_company', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('companies/banks/' . $get['cid']);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;
                case 'exports':
                    if ($this->p_export) {
                        $query = $this->Company->GetCompanyMarketsById($get['id']);
                        $company = $this->Company->GetCompanyById($get['cid']);
                        if ($query['item_type'] == 'country') {
                            $row = $this->Parameter->GetCountryById($query['market_id']);
                            $label_en = $row['label_en'];
                            $label_ar = $row['label_ar'];
                        } elseif ($query['item_type'] == 'region') {
                            $row = $this->Parameter->GetCompanyMarketById($query['market_id']);
                            $label_en = $row['label_en'];
                            $label_ar = $row['label_ar'];
                        }

                        $details = array('id' => $query['market_id'], 'name_ar' => $label_ar, 'name_en' => $label_en);
                        $history = array('logs_id' => 0, 'action' => 'delete', 'details' => json_encode($details), 'item_id' => $get['id'], 'item_title' => $company['name_ar'], 'type' => 'markets_company', 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history);
                        $this->General->delete('tbl_markets_company', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('companies/exports/' . $get['cid']);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;
                case 'statement':
                    if (TRUE) {
                        $query = $this->Company->GetStatementById($get['id']);
                        $company = $this->Company->GetCompanyById($get['cid']);
                        $history = array('logs_id' => 0, 'action' => 'delete', 'details' => json_encode($query), 'item_id' => $get['id'], 'item_title' => 'Company : ' . $company['name_ar'] . '<br>Statement : ' . $query['notes'], 'type' => 'statements_company', 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history);
                        $this->General->delete('tbl_companies_statements', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('companies/statement/' . $get['cid']);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;
                case 'app':
                    if ($this->p_app) {
                        $query = $this->Company->GetApplicationById($get['id']);
                        $history = array('logs_id' => 0, 'action' => 'delete', 'details' => json_encode($query), 'item_id' => $get['id'], 'type' => 'posting_companies', 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history);
                        $this->General->delete('posting_companies', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('companies/app/' . $get['cid']);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    break;
                    case 'branches':
                    if($this->p_branch_delete) {
                        $branches = $this->Company->GetBranchById($get['id']);
                        $query = $this->Company->GetCompanyById($get['company']);
                        $history_branches = array('logs_id' => 0, 'action' => 'delete', 'item_id' => $get['id'], 'item_title' => $query['name_ar'], 'type' => 'company_branches', 'details' => json_encode($branches), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history_branches);
                        $this->General->delete('tbl_company_branches', array('id' => $get['id']));
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    }
                    else {
                        $this->session->set_userdata(array('admin_message' => 'Permission Denied'));
                    }
                    redirect('companies/branches/'.$get['company']);
                    break;
            }
        }
    }

    public function delete_banks_checked()
    {

    }

    public function delete_checked($action = '')
    {

        $delete_array = $this->input->post('checkbox1');
        //var_dump()
        echo $this->input->post('p');
        echo $this->input->post('checkbox1');
        //die;
        if (empty($delete_array)) {
            $this->session->set_userdata(array('admin_message' => 'No Item Checked'));

            //if(isset($this->input->post('p')))
            redirect($_SERVER['HTTP_REFERER']);
            // No items checked
        } else {
            //if(isset($this->input->post('p')))
            switch ($this->input->post('p')) {
                case 'company':
                    if ($this->p_delete) {
                        foreach ($delete_array as $d_id) {
                            $this->General->delete($this->company, array('id' => $d_id));
                            $this->General->delete('task_activities', array('item_id' => $d_id));
                        }
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('companies/' . $get['st']);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect('companies');
                    }
                    break;

                case 'items':
                    $company_id = $this->input->post('company');
                    if ($this->p_production) {
                        foreach ($delete_array as $d_id) {
                            $query = $this->Company->GetProductionInfoById($d_id);
                            $company = $this->Company->GetCompanyById($company_id);
                            $details = array('HSCode' => $query['hscode'], 'title_ar' => $query['heading_ar'], 'title_en' => $query['heading_en']);
                            $history = array('logs_id' => 0, 'action' => 'delete', 'details' => json_encode($details), 'item_id' => $d_id, 'item_title' => $company['name_ar'], 'type' => 'company_heading', 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                            $this->General->save('logs', $history);
                            $this->General->delete('tbl_company_heading', array('id' => $d_id));
                            $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        }
                        $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        redirect('companies/productions/' . $company_id);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }

                    break;

                case 'section':
                    foreach ($delete_array as $d_id) {
                        $this->General->delete($this->section, array('id' => $d_id));
                    }
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('parameters/items/section/' . $get['st']);
                    break;
                case 'chapter':
                    foreach ($delete_array as $d_id) {
                        $this->General->delete($this->chapter, array('id' => $d_id));
                    }
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('parameters/items/chapter/' . $get['st']);
                    break;

                case 'position':
                    foreach ($delete_array as $d_id) {
                        $this->General->delete($this->position, array('id' => $d_id));
                    }
                    $this->session->set_userdata(array('admin_message' => 'Deleted'));
                    redirect('parameters/items/position/' . $get['st']);

                    break;
                case 'exports':
                    if ($this->p_export) {
                        $company_id = $this->input->post('company');
                        foreach ($delete_array as $d_id) {
                            $query = $this->Company->GetCompanyMarketsById($d_id);
                            $company = $this->Company->GetCompanyById($company_id);
                            if ($query['item_type'] == 'country') {
                                $row = $this->Parameter->GetCountryById($query['market_id']);
                                $label_en = $row['label_en'];
                                $label_ar = $row['label_ar'];
                            } elseif ($query['item_type'] == 'region') {
                                $row = $this->Parameter->GetCompanyMarketById($query['market_id']);
                                $label_en = $row['label_en'];
                                $label_ar = $row['label_ar'];
                            }

                            $details = array('id' => $query['market_id'], 'name_ar' => $label_ar, 'name_en' => $label_en);
                            $history = array('logs_id' => 0, 'action' => 'delete', 'details' => json_encode($details), 'item_id' => $d_id, 'item_title' => $company['name_ar'], 'type' => 'markets_company', 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                            $this->General->save('logs', $history);


                            $this->General->delete('tbl_markets_company', array('id' => $d_id));
                            $this->session->set_userdata(array('admin_message' => 'Deleted'));
                        }
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }
                    redirect('companies/exports/' . $this->input->post('company'));
                    break;
                case 'banks':

                    if ($this->p_banks) {

                        foreach ($delete_array as $d_id) {

                            $this->General->delete('tbl_banks_company', array('id' => $d_id));
                            $this->session->set_userdata(array('admin_message' => 'Deleted'));

                        }
                        redirect('companies/banks/' . $this->input->post('company'));
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }

                    break;
                case 'insurances':

                    if ($this->p_insurance) {

                        foreach ($delete_array as $d_id) {

                            $this->General->delete('tbl_insurances_company', array('id' => $d_id));
                            $this->session->set_userdata(array('admin_message' => 'Deleted'));

                        }
                        redirect('companies/insurances/' . $this->input->post('company'));
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Access Denied'));
                        redirect($this->page_denied);
                    }

                    break;
                    
            }
        }
    }

    public function index($row = 0)
    {
        $this->data['search'] = TRUE;
        if (isset($_GET['search'])) {
            $limit = 100;
            $row = $this->input->get('per_page');
            $govID = $this->input->get('gov');
            $districtID = $this->input->get('district_id');
            $chapter = $this->input->get('chapter');
            $status = $this->input->get('status');
            $id = $this->input->get('id');
            $ministry_id = $this->input->get('ministry_id');
            $name = $this->input->get('name');
            $CompanyOwner = $this->input->get('CompanyOwner');
            $activity = $this->input->get('activity');
            $phone = $this->input->get('phone');
            $whatsapp = $this->input->get('whatsapp');
            $areaID = $this->input->get('area_id');
            //$query=$this->Company->AdvancedSearchCompanies($id,$name,$activity,$phone,$row,$limit);
            //$total_row=count($this->Company->AdvancedSearchCompanies($id,$name,$activity,$phone,0,0));
            $config['base_url'] = base_url() . 'companies?id=' . $id . '&ministry_id=' . $ministry_id . '&name=' . $name .'&CompanyOwner=' . $CompanyOwner . '&activity=' . $activity . '&phone=' . $phone .'&whatsapp=' . $whatsapp . '&gov=' . $govID . '&district_id=' . $districtID . '&area_id=' . $areaID . '&status=' . $status . '&search=Search';
            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;


            $query = $this->Company->SearchCompanies($id, $name,$CompanyOwner, $activity, $phone,$whatsapp, $status, $govID, $districtID, $areaID, $row, $limit, FALSE, FALSE, $ministry_id);
            $total_row = count($this->Company->SearchCompanies($id, $name,$CompanyOwner, $activity, $phone,$whatsapp, $status, $govID, $districtID, $areaID, 0, 0, FALSE, FALSE, $ministry_id));

            //$config['base_url']=base_url().'companies?gov='.$govID.'&district_id='.$districtID.'&status='.$status.'&search=Search';
            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
        } elseif (isset($_GET['clear'])) {
            redirect('companies/');
        } else {
            $limit = 20;
            $govID = 0;
            $districtID = 0;
            $status = '';
            $config['base_url'] = base_url() . 'companies/index';
            //$config['uri_segment'] = 12;
            $query = $this->Company->GetCompanies('', $row, $limit);

            $total_row = count($this->Company->GetCompanies('', 0, 0));

            $this->pagination->initialize($config);
        }
        $this->data['govID'] = $govID;
        $this->data['districtID'] = $districtID;
        $this->data['areaID'] = @$areaID;
        $this->data['status'] = $status;
        $this->data['id'] = @$id;
        $this->data['ministry_id'] = @$ministry_id;
        $this->data['name'] = @$name;
        $this->data['CompanyOwner'] = @$CompanyOwner;
        $this->data['activity'] = @$activity;
        $this->data['phone'] = @$phone;
        $this->data['whatsapp'] = @$whatsapp;


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
        $this->breadcrumb->add_crumb('Companies');
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";;
        $this->data['subtitle'] = "Companies - الشركات";
        $this->data['sectors'] = $this->Item->GetSector('online', 0, 0);
        $this->data['sections'] = $this->Item->GetSection('online', 0, 0);
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', $this->data['govID']);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', $districtID);
        $this->data['sales'] = $this->Company->GetSalesMen();
        $this->template->load('_template', 'company/companies', $this->data);
    }

public function x($start)
{
    $query = $this->Company->GetSCompanies(',', 0, 0);
    echo '<table border="1">';
    foreach($query as $row)
    {
        $email_array= explode(",", $row->email);
        //$name_en=str_replace("  &  "," & ",$row->name_en);
        $this->Administrator->edit('tbl_company',array('email'=>@$email_array[0]),$row->id);
        echo '<tr><td>'.$row->id.'</td><td>'.$row->name_en.'</td><td>'.$row->email.'</td><td>'.@$name_en.'</td></tr>';
    }
    echo '</table>';
}
    public function reservations($row = 0)
    {

        $this->data['search'] = TRUE;
        if (isset($_GET['search'])) {
            $limit = 100;
            $row = $this->input->get('per_page');
            $govID = $this->input->get('gov');
            $districtID = $this->input->get('district_id');
            $chapter = $this->input->get('chapter');
            $status = $this->input->get('status');
            $id = $this->input->get('id');
            $name = $this->input->get('name');
            $activity = $this->input->get('activity');
            $phone = $this->input->get('phone');
            $whatsapp = $this->input->get('whatsapp');
            $areaID = $this->input->get('area_id');
            //$query=$this->Company->AdvancedSearchCompanies($id,$name,$activity,$phone,$row,$limit);
            //$total_row=count($this->Company->AdvancedSearchCompanies($id,$name,$activity,$phone,0,0));
            $config['base_url'] = base_url() . 'companies/reservations?id=' . $id . '&name=' . $name . '&activity=' . $activity . '&phone=' . $phone . '&gov=' . $govID . '&district_id=' . $districtID . '&area_id=' . $areaID . '&status=' . $status . '&search=Search';
            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;


            $query = $this->Company->SearchCompanies($id, $name, $activity, $phone, $whatsapp, $status, $govID, $districtID, $areaID, $row, $limit, 1);
            $total_row = count($this->Company->SearchCompanies($id, $name, $activity, $phone, $whatsapp, $status, $govID, $districtID, $areaID, 0, 0, 1));

            //$config['base_url']=base_url().'companies?gov='.$govID.'&district_id='.$districtID.'&status='.$status.'&search=Search';
            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
        } elseif (isset($_GET['clear'])) {
            redirect('companies/reservations/');
        } else {
            $limit = 20;
            $govID = 0;
            $districtID = 0;
            $status = '';
            $config['base_url'] = base_url() . 'companies/reservations';
            //$config['uri_segment'] = 12;
            $query = $this->Company->GetCompanies('', $row, $limit, 1);

            $total_row = count($this->Company->GetCompanies('', 0, 0, 1));

            $this->pagination->initialize($config);
        }

        $this->data['govID'] = $govID;
        $this->data['districtID'] = $districtID;
        $this->data['areaID'] = @$areaID;
        $this->data['status'] = $status;
        $this->data['id'] = @$id;
        $this->data['name'] = @$name;
        $this->data['activity'] = @$activity;
        $this->data['phone'] = @$phone;
        $this->data['whatsapp'] = @$whatsapp;


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
        $this->breadcrumb->add_crumb('Companies');
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";

        $this->data['subtitle'] = "الحاجزة نسخة - الشركات";
        $this->data['sectors'] = $this->Item->GetSector('online', 0, 0);
        $this->data['sections'] = $this->Item->GetSection('online', 0, 0);
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', $this->data['govID']);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', $districtID);
        $this->template->load('_template', 'company/companies', $this->data);
    }
public function logs($row = 0)
    {
        $limit = 20;
       $this->data['company'] = $company_id=$this->input->get('company');
       $this->data['from'] = $from=$this->input->get('from');
       $this->data['to'] = $to=$this->input->get('to');
       $this->data['user'] = $user=$this->input->get('user');
       $_url='';
        if($this->input->get())
        {
            $_url='?company='.$company_id.'&from='.$from.'&to='.$to.'&user='.$user;
        }
        $config['base_url'] = base_url() . 'companies/logs'.$_url;
        
        $query = $this->Company->GetUpdateInfoLogs($company_id,$from,$to,$user,$row, $limit);
        $total_row = $query['total'];
        $this->pagination->initialize($config);
        $config['total_rows'] = $total_row;
        $config['per_page'] = $limit;
        $config['num_links'] = 6;
        $this->pagination->initialize($config);
        $this->data['query'] = $query['rows'];
        $this->data['total_row'] = $total_row;
        $this->data['links'] = $this->pagination->create_links();
        $this->data['st'] = $this->uri->segment(4);
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Companies');
        $this->breadcrumb->add_crumb('Logs');
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";
        $this->data['subtitle'] = "Update Info Companies Logs";
        $this->data['users']=$this->Administrator->GetAllUsers();
        $this->template->load('_template', 'company/logs', $this->data);
    }
    public function scanning($row = 0)
    {
        $limit = 20;
        $this->data['search'] = FALSE;
        $year = date('Y');
        $config['base_url'] = base_url() . 'companies/scanning';
        $statements = $this->Company->GetStatementsIDs($year);
        $array_ids = array();
        foreach ($statements as $statement) {
            array_push($array_ids, $statement->company_id);
        }
        $query = $this->Company->GetScanningCompanies($array_ids, '', '', '', $row, $limit);
        $total_row = count($this->Company->GetScanningCompanies($array_ids, '', '', '', 0, 0));
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
        $this->breadcrumb->add_crumb('Companies');
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";;
        $this->data['subtitle'] = "شركات المسح الصناعي";
        $this->template->load('_template', 'company/companies', $this->data);
    }


    public function advertising($row = 0)
    {

        $this->data['search'] = TRUE;
        if (isset($_GET['search'])) {
            $limit = 100;
            $row = $this->input->get('per_page');
            $govID = $this->input->get('gov');
            $districtID = $this->input->get('district_id');
            $chapter = $this->input->get('chapter');
            $status = $this->input->get('status');
            $id = $this->input->get('id');
            $name = $this->input->get('name');
            $activity = $this->input->get('activity');
            $phone = $this->input->get('phone');
            $whatsapp = $this->input->get('whatsapp');
            $areaID = $this->input->get('area_id');
            //$query=$this->Company->AdvancedSearchCompanies($id,$name,$activity,$phone,$row,$limit);
            //$total_row=count($this->Company->AdvancedSearchCompanies($id,$name,$activity,$phone,0,0));
            $config['base_url'] = base_url() . 'companies/advertising?id=' . $id . '&name=' . $name . '&activity=' . $activity . '&phone=' . $phone . '&gov=' . $govID . '&district_id=' . $districtID . '&area_id=' . $areaID . '&status=' . $status . '&search=Search';
            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;


            $query = $this->Company->SearchCompanies($id, $name, $activity, $phone,$whatsapp, $status, $govID, $districtID, $areaID, $row, $limit, FALSE, 1);
            $total_row = count($this->Company->SearchCompanies($id, $name, $activity, $phone,$whatsapp, $status, $govID, $districtID, $areaID, 0, 0, FALSE, 1));

            //$config['base_url']=base_url().'companies?gov='.$govID.'&district_id='.$districtID.'&status='.$status.'&search=Search';
            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
        } elseif (isset($_GET['clear'])) {
            redirect('companies/advertising/');
        } else {
            $limit = 20;
            $govID = 0;
            $districtID = 0;
            $status = '';
            $config['base_url'] = base_url() . 'companies/advertising';
            //$config['uri_segment'] = 12;
            $query = $this->Company->GetCompanies('', $row, $limit, FALSE, 1);

            $total_row = count($this->Company->GetCompanies('', 0, 0, FALSE, 1));

            $this->pagination->initialize($config);
        }

        $this->data['govID'] = $govID;
        $this->data['districtID'] = $districtID;
        $this->data['areaID'] = @$areaID;
        $this->data['status'] = $status;
        $this->data['id'] = @$id;
        $this->data['name'] = @$name;
        $this->data['activity'] = @$activity;
        $this->data['phone'] = @$phone;
        $this->data['whatsapp'] = @$whatsapp;


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
        $this->breadcrumb->add_crumb('Companies');
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";

        $this->data['subtitle'] = "الشركات المعلنة";
        $this->data['sectors'] = $this->Item->GetSector('online', 0, 0);
        $this->data['sections'] = $this->Item->GetSection('online', 0, 0);
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', $this->data['govID']);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', $districtID);
        $this->template->load('_template', 'company/companies', $this->data);
    }

    public function area($row = 0)
    {

        $this->data['search'] = TRUE;

        $limit = 100;
        $row = $this->input->get('per_page');
        $govID = $this->input->get('gov');
        $districtID = $this->input->get('district_id');
        $chapter = $this->input->get('chapter');
        $status = $this->input->get('status');
        $id = $this->input->get('id');
        $name = $this->input->get('name');
        $activity = $this->input->get('activity');
        $phone = $this->input->get('phone');
        $whatsapp = $this->input->get('whatsapp');
        $areaID = $this->input->get('area_id');
        //$query=$this->Company->AdvancedSearchCompanies($id,$name,$activity,$phone,$row,$limit);
        //$total_row=count($this->Company->AdvancedSearchCompanies($id,$name,$activity,$phone,0,0));
        $config['base_url'] = base_url() . 'companies/area?id=' . $id . '&name=' . $name . '&activity=' . $activity . '&phone=' . $phone . '&gov=' . $govID . '&district_id=' . $districtID . '&area_id=' . $areaID . '&status=' . $status . '&search=Search';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;


        $query = $this->Company->SearchCompaniesArea($id, $name, $activity, $phone,$whatsapp, $status, $govID, $districtID, $areaID, $row, $limit);
        $total_row = count($this->Company->SearchCompaniesArea($id, $name, $activity, $phone,$whatsapp, $status, $govID, $districtID, $areaID, 0, 0));

        //$config['base_url']=base_url().'companies?gov='.$govID.'&district_id='.$districtID.'&status='.$status.'&search=Search';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;


        $this->data['govID'] = $govID;
        $this->data['districtID'] = $districtID;
        $this->data['areaID'] = @$areaID;
        $this->data['status'] = $status;
        $this->data['id'] = @$id;
        $this->data['name'] = @$name;
        $this->data['activity'] = @$activity;
        $this->data['phone'] = @$phone;
        $this->data['whatsapp'] = @$whatsapp;


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
        $this->breadcrumb->add_crumb('Companies');
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";

        $this->data['subtitle'] = "الشركات المعلنة";
        $this->data['sectors'] = $this->Item->GetSector('online', 0, 0);
        $this->data['sections'] = $this->Item->GetSection('online', 0, 0);
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', $this->data['govID']);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', $districtID);
        $this->template->load('_template', 'company/companies', $this->data);
    }

    public function search($row = 0)
    {
       
        if (isset($_GET['search'])) {
            $limit = 100;
            $row = $this->input->get('per_page');
            $id = $this->input->get('id');
            $name = $this->input->get('name');
            $CompanyOwner = $this->input->get('CompanyOwner');
            $activity = $this->input->get('activity');
            $phone = $this->input->get('phone');
            $whatsapp = $this->input->get('whatsapp');
            $query = $this->Company->AdvancedSearchCompanies($id, $name, $CompanyOwner, $activity, $phone, $whatsapp, $row, $limit);
            $total_row = count($this->Company->AdvancedSearchCompanies($id, $name, $CompanyOwner, $activity, $phone, $whatsapp, 0, 0));
            $config['base_url'] = base_url() . 'companies?id=' . $id . '&name=' . $name .'&CompanyOwner=' . $CompanyOwner . '&activity=' . $activity . '&phone=' . $phone .'&whatsapp=' . $whatsapp . '&search=Search';
            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
        } elseif (isset($_GET['clear'])) {
            redirect('companies/');
        } else {
            $limit = 20;
            $id = '';
            $name = '';
            $CompanyOwner = '';
            $activity = '';
            $phone = '';
            $whatsapp = '';
            $config['base_url'] = base_url() . 'companies/index';
            //$config['uri_segment'] = 12;
            $query = array();

            $total_row = 0;

            $this->pagination->initialize($config);
        }

        $this->data['id'] = $id;
        $this->data['name'] = $name;
        $this->data['activity'] = $activity;
        $this->data['phone'] = $phone;
        $this->data['whatsapp'] = $whatsapp;


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
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";;
        $this->data['subtitle'] = "Companies - الشركات";
        $this->template->load('_template', 'company/companies_search', $this->data);
    }

    public function listview()
    {
        $govID = $this->input->get('gov');
        $districtID = $this->input->get('district_id');
        $chapter = $this->input->get('chapter');
        $status = $this->input->get('status');
        $id = $this->input->get('id');
        $ministry_id = $this->input->get('ministry_id');
        $name = $this->input->get('name');
        $activity = $this->input->get('activity');
        $phone = $this->input->get('phone');
        $whatsapp = $this->input->get('whatsapp');
        $areaID = $this->input->get('area_id');

        $this->data['query'] = $this->Company->SearchCompanies($id, $name, $activity, $phone, $whatsapp, $status, $govID, $districtID, $areaID, 0, 0, FALSE, FALSE, $ministry_id);
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";;
        $this->data['subtitle'] = "Companies - الشركات";
        $this->load->view('company/listview', $this->data);
    }

public function pages()
    {
        $company_id = $this->input->get('id');
       
        $query = $this->Task->GetCompanyPagesById($company_id);

        $this->data['query'] = $query;
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";;
        $this->data['subtitle'] = "";
        $this->load->view('company/pages', $this->data);
    }
    public function liststatements()
    {
        $gov = $this->input->get('gov');
        $district_id = $this->input->get('district_id');
        $year = $this->input->get('year');
        $statements = $this->Company->GetStatementsIDs($year);
        $array_ids = array();
        foreach ($statements as $statement) {
            array_push($array_ids, $statement->company_id);
        }
        $query = $this->Company->GetStatementsCompanies($array_ids, $govID, $districtID, '', 0, 0);

        $this->data['query'] = $query;
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";;
        $this->data['subtitle'] = "Companies - الشركات";
        $this->load->view('company/listview', $this->data);
    }
public function branches($id) {

        if($this->p_branches) {
            $query = $this->Company->GetCompanyById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Companies', 'companies');
            $this->breadcrumb->add_crumb($query['name_en'], 'companies/details/'.$id);
            $this->breadcrumb->add_crumb('Branches');
            $this->data['query'] = $query;
            $this->data['id'] = $id;
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['title'] = $query['name_en']." - ".$query['name_ar'];
            $this->data['subtitle'] = $query['name_en']." - ".$query['name_ar'];
            $this->data['branches'] = $this->Company->GetBranches('', $id);
            $this->template->load('_template', 'company/branches', $this->data);
        }
        else {
            redirect('companies');
        }
    }
    public function branch_create($id) {
        if($this->p_branch_add) {
            $this->data['query']=$query = $this->Company->GetCompanyById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Companies', 'companies');
            $this->breadcrumb->add_crumb($query['name_en'], 'companies/details/'.$id);
            $this->breadcrumb->add_crumb('Branches', 'companies/branches/'.$id);
            $this->breadcrumb->add_crumb('Add New Company Branch');
            $this->form_validation->set_rules('area_id', 'Area', 'required');

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
                    'company_id' => $id,
                    'governorate_id' => $this->input->post('governorate_id'),
                    'district_id' => $this->input->post('district_id'),
                    'area_id' => $this->input->post('area_id'),
                    'street_ar' => $this->input->post('street_ar'),
                    'street_en' => $this->input->post('street_en'),
                    'bldg_ar' => $this->input->post('bldg_ar'),
                    'bldg_en' => $this->input->post('bldg_en'),
                    'fax' => $this->input->post('fax'),
                    'phone' => $this->input->post('phone'),
                    'whatsapp' => $this->input->post('whatsapp'),
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

                if($branch_id = $this->General->save('tbl_company_branches', $data)) {
                    $bank = $this->Company->GetCompanyById($id);
                    $history = array('action' => 'add', 'logs_id' => 0, 'item_id' => $branch_id, 'item_title' => $bank['name_ar'], 'type' => 'company_branch', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history);
                    $this->session->set_userdata(array('admin_message' => 'Branch Added successfully'));
                    redirect('companies/branches/'.$id);
                }
                else {
                    $this->session->set_userdata(array('admin_message' => 'Error'));
                    redirect('companies/branches/'.$id);
                }
            }
            /*             * ********************General Info*********************** */
            $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
            $this->data['districts'] = array();
            $this->data['areas'] = array();
            $this->data['id'] = $id;

            $this->data['subtitle'] = 'Add New Company Branch';
            $this->data['title'] = $this->data['Ctitle']."- Add New Company Branch";
            $this->template->load('_template', 'company/branch_form', $this->data);
        }
        else {
            redirect('companies');
        }
    }
        public function branch_edit($id) {
        if($this->p_branch_edit) {
            $this->data['row']=$row = $this->Company->GetBranchById($id);
            $this->data['query']=$query = $this->Company->GetCompanyById($row['company_id']);

            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Companies', 'companies');
            $this->breadcrumb->add_crumb($query['name_en'], 'companies/details/'.$row['company_id']);
            $this->breadcrumb->add_crumb('Branches', 'companies/branches/'.$row['company_id']);
            $this->breadcrumb->add_crumb('Edit Branch : '.$row['name_en']);
            $this->form_validation->set_rules('area_id', 'Area', 'required');

            if($this->form_validation->run()) {

                $x1 = $this->input->post('x1');
                $x2 = $this->input->post('x2');
                $x3 = $this->input->post('x3');
                $x = $x1.'°'.$x2."'".$x3.'"';

                $y1 = $this->input->post('y1');
                $y2 = $this->input->post('y2');
                $y3 = $this->input->post('y3');
                $y = $y1.'°'.$y2."'".$y3.'"';

                $company_id = $this->input->post('company_id');
                $data = array(
                    'governorate_id' => $this->input->post('governorate_id'),
                    'district_id' => $this->input->post('district_id'),
                    'area_id' => $this->input->post('area_id'),
                    'street_ar' => $this->input->post('street_ar'),
                    'street_en' => $this->input->post('street_en'),
                    'bldg_ar' => $this->input->post('bldg_ar'),
                    'bldg_en' => $this->input->post('bldg_en'),
                    'fax' => $this->input->post('fax'),
                    'phone' => $this->input->post('phone'),
                    'whatsapp' => $this->input->post('whatsapp'),
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
                $query = $this->Company->GetBranchById($id);
                if($this->Administrator->edit('tbl_company_branches', $data, $id)) {

                    $company = $this->Company->GetCompanyById($company_id);
                    $newdata = $this->Administrator->affected_fields($query, $data);
                    $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $company['name_ar'].' - '.$this->input->post('name_ar'), 'type' => 'company_branch', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history);

                    $this->session->set_userdata(array('admin_message' => 'Branch Updated successfully'));
                    redirect('companies/branches/'.$company_id);
                }
                else {
                    $this->session->set_userdata(array('admin_message' => 'Error'));
                    redirect('companies/branches/'.$company_id);
                }
            }
            /*             * ********************General Info*********************** */

            $b_area = $this->Address->GetAreaById($row['area_id']);
            $b_district = $this->Address->GetDistrictById($b_area['district_id']);
            $b_gov = $this->Address->GetGovernorateById($b_district['governorate_id']);

            $this->data['governorate_id'] = $b_district['governorate_id'];
            $this->data['district_id'] = $b_area['district_id'];

            $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
            $this->data['districts'] = $this->Address->GetDistrictByGov('online', $b_district['governorate_id']);
            $this->data['areas'] = $this->Address->GetAreaByDistrict('online', $b_area['district_id']);
            $this->data['id']=$row['company_id'];
            $this->data['subtitle'] = 'Edit Branch';
            $this->data['title'] = $this->data['Ctitle']."- Edit Branch";
            $this->template->load('_template', 'company/branch_form', $this->data);
        }
        else {
            redirect('companies');
        }
    }
    public function branch_details($id) {
        if($this->p_branches) {
            $row = $this->Company->GetBranchById($id);
            $query = $this->Company->GetCompanyById($row['company_id']);

            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Companies', 'companies');
            $this->breadcrumb->add_crumb($query['name_en'], 'companies/details/'.$row['company_id']);
            $this->breadcrumb->add_crumb('Branches', 'companies/branches/'.$row['company_id']);
            $this->breadcrumb->add_crumb($row['name_en']);

            $this->data['id'] = $row['company_id'];
            $this->data['name_ar'] = $row['name_ar'];
            $this->data['name_en'] = $row['name_en'];
            $this->data['area_id'] = $row['area_id'];
            $this->data['street_ar'] = $row['street_ar'];
            $this->data['street_en'] = $row['street_en'];
            $this->data['bldg_ar'] = $row['bldg_ar'];
            $this->data['bldg_en'] = $row['bldg_en'];
            $this->data['fax'] = $row['fax'];
            $this->data['phone'] = $row['phone'];
            $this->data['whatsapp'] = $row['whatsapp'];
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
            $this->template->load('_template', 'company/branch_details', $this->data);
        }
        else {
            redirect('companies');
        }
    }
    public function details($id)
    {   
         
         $query = $this->Company->GetCompanyById($id);
        
        $this->data['query'] = $query;

        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Companies');
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";

        $this->data['subtitle'] = "Companies - الشركات";
        $this->data['sectors'] = $this->Item->GetSector('online', 0, 0);
        $this->data['sections'] = $this->Item->GetSection('online', 0, 0);
        $this->data['governorates'] = $this->Address->GetGovernorateById($query['governorate_id']);
        $this->data['districts'] = $this->Address->GetDistrictById($query['district_id']);
        $this->data['area'] = $this->Address->GetAreaById($query['area_id']);
        $this->data['items'] = $this->Company->GetProductionInfo($id);
        $this->data['id'] = $id;
        $this->data['salesman'] = $this->General->GetSalesManById($query['sales_man_id']);
        $this->data['company_types'] = $this->Company->GetCompanyTypeById($query['company_type_id']);

        $this->data['license_sources'] = $this->Company->GetLicenseSourceById($query['license_source_id']);

        $this->template->load('_template', 'company/details', $this->data);
    }

    public function view($id)
    {
        $query = $this->Company->GetCompanyById($id);
        $this->data['query'] = $query;

        $this->data['p_delete'] = TRUE;
        $this->data['p_edit'] = TRUE;
        $this->data['p_add'] = TRUE;
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
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

    public function export($id)
    {
        $filename = "company-" . $id . ".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $query = $this->Company->GetCompanyById($id);
        $this->data['query'] = $query;
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

        $this->data['salesman'] = $this->General->GetSalesManById($query['sales_man_ids']);
        $this->data['position'] = $this->Item->GetPositionById($query['position_id']);

        $this->data['license'] = $this->Company->GetLicenseSourceById($query['license_source_id']);

        $this->load->view('company/application_view', $this->data);
        /*
        echo '<table>
                    <tr class="row"><td colspan="5" style="text-align:center"><h3>رقم الاستمارة : '.$query['id'].'</h3></td></tr>
                    <tr>
                        <td colspan="5">
                            <div class="label arabic">  وزارة ID :</div>
                            <div class="data-box arabic">'.$query['ministry_id'].'&nbsp;</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <div class="label english">Company Name :</div>
                            <div class="data-box english">'.$query['name_en'].'&nbsp;</div>
                            <div class="label arabic"> اسم المؤسسة:</div>
                            <div class="data-box arabic">'.$query['name_ar'].'&nbsp;</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <div class="label english">Owner / Owners of The Co. :</div>
                            <div class="data-box english">'.$query['owner_name_en'].'&nbsp;</div>
                            <div class="label arabic"> صاحب / اصحاب الشركة: :</div>
                            <div class="data-box arabic">'.$query['owner_name'].'&nbsp;</div>
                        </td>
                    </tr>

                </table>';
        */
        // exit;
    }
    private function CreateTask($governorate_id,$district_id,$area_id,$assigne_to,$type)
    {
        $category='company';
        $year=date('Y');
        $nbr=0;
        $quantity=0;
        $array_ids=array();
        $companies = $this->Company->SearchCompanies('', '', '', '', 'all', $governorate_id, $district_id, $area_id, 0, 0, FALSE, FALSE, '');
        $query=$this->Company->GetTasks($governorate_id,$district_id,$area_id,$assigne_to,$category,$year,$type);

        // var_dump($companies);
        // die;
        if(count($query)>0)
        {
            $task_id=$query[0]->id;
            $quantity=$query[0]->quantity;

        }
        else{
            $area=$this->Address->GetAreaById($area_id);
            $data=array(
                'title'=>($this->input->post('task_title')) ? $this->input->post('task_title') : 'Geo Company Task Area : '.@$area['label_en'],
                'assigne_to'=>$assigne_to,
                'comments'=>$this->input->post('comments'),
                'quantity'=>count($companies),
                'governorate_id'=>$governorate_id,
                'district_id'=>$district_id,
                'area_id'=>$area_id,
                'category'=>$category,
                'type'=>$type,
                'status'=>'pending',
                'year'=>$year,
                'create_time' => $this->datetime,
                'update_time' => $this->datetime,
                'user_id' => $this->session->userdata('id'),
            );
            $task_id= $this->General->save('tasks',$data);
        }
        foreach ($companies as $company) {
            $id=$company->id;
            array_push($array_ids,$company->id);
            $activity=$this->Company->GetActivityTask($task_id,$id,'','company');
            if(count($activity)==0) {
                $activity_array = array(
                    'task_id' => $task_id,
                    'item_id' => $id,
                    'start_date' => $this->datetime,
                    'end_date' => '',
                    'status' => 'pending',
                    'updated_info' => 0,
                    'salesman_id'=>$assigne_to,
                    'create_time' => $this->datetime,
                    'update_time' => $this->datetime,
                    'user_id' => $this->session->userdata('id'),
                );
                $this->General->save('task_activities', $activity_array);
                $nbr=$nbr+1;

            }
            $this->Administrator->edit('tasks',array('quantity'=>$quantity+ $nbr),$task_id);
        }
        return $array_ids;

    }
    public function printall()
    {
        $ids = $this->input->post('checkbox1');
        // $this->CreateTask($ids,$this->input->post('governorate_id'),$this->input->post('district_id'),$this->input->post('area_id'),$this->input->post('assigne_to'),$this->input->post('type'));
        foreach ($ids as $id) {
            $this->view($id);

        }
    }
    public function rprint($id)
    {
        $this->Administrator->edit('tasks',array('printed'=>0),$id);
        $this->session->set_userdata(array('admin_message' => 'Task Updated successfully'));
        redirect($this->agent->referrer());
    }
    public function task_create()
    {
        $area=$this->input->post('area_id');
        $district=$this->input->post('district_id');
        $governorate=$this->input->post('governorate_id');
        $query=$this->Address->GetAreas($governorate,$district,$area);


        foreach($query as $row){
            $this->CreateTask($row->governorate_id,$row->district_id,$row->id,$this->input->post('assigne_to'),$this->input->post('type'));
        }
        $this->session->set_userdata(array('admin_message' => 'Task Added successfully'));
        redirect($this->agent->referrer());
        //  $ids=$this->CreateTask($this->input->post('governorate_id'),$this->input->post('district_id'),$this->input->post('area_id'),$this->input->post('assigne_to'),$this->input->post('type'));
        /*
                foreach ($ids as $id) {
                    $this->view($id);
                }
        */

    }
    public function tasks_print($id,$status)
    {
        $query = $this->Company->GetActivityTask(@$id,'',@$status,'company');
        foreach($query as $row)
        {
            $this->view($row->item_id);
        }
        $this->Administrator->edit('tasks',array('printed'=>1),$id);
    }

    public function task_listview($id,$status)
    {
        $this->data['query']=$query = $this->Company->GetActivityTask(@$id,'',@$status,'company');
        $this->data['task']=$task = $this->Company->GetTaskById($id);


        $this->data['id']=$id;
        $this->load->view('company/task_listview', $this->data);
    }
    public function printw()
    {

        for ($i > 7234; $i <= 9606; $i++) {
            $this->view($i);
        }
    }

    public function productions($id, $item_id = '')
    {
        if ($this->p_production) {
            $query = $this->Company->GetCompanyById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Companies', 'companies');
            $this->breadcrumb->add_crumb($query['name_en'], 'companies/details/' . $id);
            $this->breadcrumb->add_crumb('Production information', 'companies/productions/' . $id);

            $this->form_validation->set_rules('heading_id', 'Heading', 'required');
            if ($this->form_validation->run()) {
                if ($_POST['action'] == 'add') {
                    //	var_dump($_POST);
                    //	die;
                    $data = array(
                        'company_id' => $id,
                        'heading_id' => $this->form_validation->set_value('heading_id'),
                        'create_time' => $this->datetime,
                        'update_time' => $this->datetime,
                        'user_id' => $this->session->userdata('id'),
                    );

                    if ($nid = $this->General->save($this->company_heading, $data)) {
                        $company = $this->Company->GetCompanyById($id);
                        $row = $this->Company->GetProductionInfoById($nid);
                        $history = array('action' => 'add', 'logs_id' => 0, 'item_id' => $nid, 'item_title' => $company['description_ar'] . '<br>' . $row['hscode'], 'type' => 'company_heading', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));


                        $this->General->save('logs', $history);

                        $this->session->set_userdata(array('admin_message' => 'Prodduction Added successfully'));
                        redirect('companies/productions/' . $id);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Error'));
                        redirect('companies/prodcution-create/' . $id);
                    }
                } else {
                    $data = array(
                        'company_id' => $id,
                        'heading_id' => $this->form_validation->set_value('heading_id'),
                        'update_time' => $this->datetime,
                        'user_id' => $this->session->userdata('id'),
                    );
                    $row = $this->Company->GetProductionInfoById($item_id);
                    $company = $this->Company->GetCompanyById($id);
                    $newdata = $this->Administrator->affected_fields($row, $data);
                    $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $item_id, 'item_title' => $company['name_ar'] . '<br>' . $row['hscode'], 'type' => 'company_heading', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history);

                    if ($this->Administrator->edit($this->company_heading, $data, $item_id)) {
                        $this->session->set_userdata(array('admin_message' => 'Prodduction Updated successfully'));
                        redirect('companies/productions/' . $id);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Error'));
                        redirect('companies/prodcutions/' . $id . '/' . $item_id);
                    }
                }
            }
            if ($item_id == '') {

                $this->data['subtitle'] = 'Add New Production Item';
                $this->data['action'] = 'add';
                $this->data['display'] = '';
            } else {

                $row = $this->Company->GetProductionInfoById($item_id);
                //echo $item_id;
                $this->data['subtitle'] = 'Edit Production Item';
                $this->data['action'] = 'edit';
                $this->data['display'] = @$row['heading_ar'] . '<br><hr />' . @$row['heading_en'];
            }
            $this->data['c_id'] = $id;
            $this->data['id'] = $id;
            $this->data['heading_id'] = $item_id;
            $this->data['query'] = $query;

            //$this->data['p_delete']=TRUE;
            //$this->data['p_edit']=TRUE;
            //$this->data['p_add']=TRUE;
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['productions'] = $this->Company->GetProductionInfo($id);
            $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";
            $this->data['items'] = $this->Item->GetItems('online', 0, 0);
            $this->template->load('_template', 'company/productions', $this->data);
        } else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect('companies/details/' . $id);
        }
    }

    public function banks($id, $item_id = '')
    {
        if ($this->p_banks) {

            $query = $this->Company->GetCompanyById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Companies', 'companies');
            $this->breadcrumb->add_crumb($query['name_en'], 'companies/details/' . $id);
            $this->breadcrumb->add_crumb('Banks', 'companies/banks/' . $id);

            $this->form_validation->set_rules('bank_id', 'Banks', 'required');
            if ($this->form_validation->run()) {
                if ($_POST['action'] == 'add') {
                    $data = array(
                        'company_id' => $id,
                        'bank_id' => $this->form_validation->set_value('bank_id'),
                        'create_time' => $this->datetime,
                        'update_time' => $this->datetime,
                        'user_id' => $this->session->userdata('id'),
                    );

                    if ($nid = $this->General->save($this->company_banks, $data)) {
                        $company = $this->Company->GetCompanyById($id);
                        $row = $this->Bank->GetBankById($this->form_validation->set_value('bank_id'));
                        $details = array('id' => $row['id'], 'name_ar' => $row['name_ar'], 'name_en' => $row['name_en']);
                        $history = array('action' => 'add', 'logs_id' => 0, 'item_id' => $nid, 'item_title' => 'Company : ' . $company['name_ar'] . '<br>Bank : ' . $row['name_ar'], 'type' => 'banks_company', 'details' => json_encode($details), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history);
                        $this->session->set_userdata(array('admin_message' => 'Bank Added successfully'));
                        redirect('companies/banks/' . $id);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Error'));
                        redirect('companies/banks/' . $id . '/' . $item_id);
                    }
                } else {
                    $data = array(
                        'company_id' => $id,
                        'bank_id' => $this->form_validation->set_value('bank_id'),
                        'update_time' => $this->datetime,
                        'user_id' => $this->session->userdata('id'),
                    );
                    $data1 = $data;

                    $row = $this->Company->GetCompanyBankById($item_id);
                    $company = $this->Company->GetCompanyById($id);
                    $bank = $this->Bank->GetBankById($this->form_validation->set_value('bank_id'));
                    $data1['bank_ar'] = $bank['name_ar'];
                    $data1['bank_en'] = $bank['name_en'];
                    $newdata = $this->Administrator->affected_fields($row, $data1);
                    $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $item_id, 'item_title' => 'Company : ' . $company['name_ar'] . '<br>Bank : ' . $row['bank_ar'], 'type' => 'banks_company', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history);

                    if ($this->Administrator->edit($this->company_banks, $data, $item_id)) {
                        $this->session->set_userdata(array('admin_message' => 'Bank Updated successfully'));
                        redirect('companies/banks/' . $id);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Error'));
                        redirect('companies/banks/' . $id . '/' . $item_id);
                    }
                }
            }
            if ($item_id == '') {

                $this->data['subtitle'] = 'Add New Bank';
                $this->data['action'] = 'add';
                $this->data['display'] = '';
            } else {

                $row = $this->Company->GetCompanyBankById($item_id);

                $this->data['subtitle'] = 'Edit Bank';
                $this->data['action'] = 'edit';
                $this->data['display'] = $row['bank_ar'] . '<br><hr />' . $row['bank_en'];
            }
            $this->data['c_id'] = $id;
            $this->data['id'] = $id;

            $this->data['bank_id'] = $item_id;
            $this->data['query'] = $query;

            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['banks'] = $this->Company->GetCompanyBanks($id);
            $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";
            $this->data['items'] = $this->Bank->GetBanks('1', 0, 0);
            $this->template->load('_template', 'company/banks', $this->data);
        } else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect('companies/details/' . $id);
        }
    }

    public function app_details($id)
    {
        if ($this->p_app) {
            $query = $this->Company->GetApplicationById($id);
            $this->data['query'] = $query;
            $this->data['_id'] = $id;
            $this->data['id'] = $query['company_id'];
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Companies', 'companies');
            $this->breadcrumb->add_crumb($query['name_en'], 'companies/details/' . $id);
            $this->breadcrumb->add_crumb('Applications');
            $this->data['subtitle'] = 'Application';
            $this->data['title'] = $this->data['Ctitle'] . "- Application Company";
            $this->template->load('_template', 'company/app_details', $this->data);
        } else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect('companies/details/' . $id);
        }
    }

    public function app($id)
    {
        if ($this->p_app) {
            $query = $this->Company->GetCompanyById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Companies', 'companies');
            $this->breadcrumb->add_crumb($query['name_en'], 'companies/details/' . $id);
            $this->breadcrumb->add_crumb('Applications', 'companies/app/' . $id);
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['id'] = $id;
            $this->data['query'] = $query;
            $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";
            $this->data['items'] = $this->Company->GetApplicationsByCompany($id);
            $this->template->load('_template', 'company/app', $this->data);
        } else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect('companies/details/' . $id);
        }
    }

    public function insurances($id, $item_id = '')
    {

        if ($this->p_insurance) {

            $query = $this->Company->GetCompanyById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Companies', 'companies');
            $this->breadcrumb->add_crumb($query['name_en'], 'companies/details/' . $id);
            $this->breadcrumb->add_crumb('Insurances', 'companies/insurances/' . $id);

            $this->form_validation->set_rules('insurance_id', 'Insurance', 'required');
            if ($this->form_validation->run()) {
                if ($_POST['action'] == 'add') {
                    $data = array(
                        'company_id' => $id,
                        'insurance_id' => $this->form_validation->set_value('insurance_id'),
                        'create_time' => $this->datetime,
                        'update_time' => $this->datetime,
                        'user_id' => $this->session->userdata('id'),
                    );

                    if ($nid = $this->General->save($this->company_insurance, $data)) {
                        $company = $this->Company->GetCompanyById($id);
                        $row = $this->Insurance->GetInsuranceById($this->form_validation->set_value('insurance_id'));
                        $details = array('id' => $row['id'], 'name_ar' => $row['name_ar'], 'name_en' => $row['name_en']);
                        $history = array('action' => 'add', 'logs_id' => 0, 'item_id' => $nid, 'item_title' => $company['name_ar'], 'type' => 'insurances_company', 'details' => json_encode($details), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history);
                        $this->session->set_userdata(array('admin_message' => 'Insurance Added successfully'));
                        redirect('companies/insurances/' . $id);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Error'));
                        redirect('companies/insurances/' . $id . '/' . $item_id);
                    }
                } else {
                    $data = array(
                        'company_id' => $id,
                        'insurance_id' => $this->form_validation->set_value('insurance_id'),
                        'update_time' => $this->datetime,
                        'user_id' => $this->session->userdata('id'),
                    );
                    $data1 = $data;
                    $insurance = $this->Insurance->GetInsuranceById($this->form_validation->set_value('insurance_id'));
                    $data1['insurance_ar'] = $insurance['name_ar'];
                    $data1['insurance_en'] = $insurance['name_en'];
                    $row = $this->Company->GetCompanyInsuranceById($item_id);
                    $company = $this->Company->GetCompanyById($id);


                    $newdata = $this->Administrator->affected_fields($row, $data1);
                    $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $company['name_ar'], 'type' => 'insurances_company', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history);

                    if ($this->Administrator->edit($this->company_insurance, $data, $item_id)) {
                        $this->session->set_userdata(array('admin_message' => 'Insurance Updated successfully'));
                        redirect('companies/insurances/' . $id);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Error'));
                        redirect('companies/insurances/' . $id . '/' . $item_id);
                    }
                }
            }
            if ($item_id == '') {

                $this->data['subtitle'] = 'Add';
                $this->data['action'] = 'add';
                $this->data['display'] = '';
            } else {

                $row = $this->Company->GetCompanyInsuranceById($item_id);

                $this->data['subtitle'] = 'Edit';
                $this->data['action'] = 'edit';
                $this->data['display'] = $row['insurance_ar'] . '<br><hr />' . $row['insurance_en'];
            }
            $this->data['c_id'] = $id;
            $this->data['id'] = $id;

            $this->data['insurance_id'] = $item_id;
            $this->data['query'] = $query;

            $this->data['p_delete'] = TRUE;
            $this->data['p_edit'] = TRUE;
            $this->data['p_add'] = TRUE;
            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['insurances'] = $this->Company->GetCompanyInsurances($id);
            $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";
            $this->data['items'] = $this->Insurance->GetInsurances('online', 0, 0);
            $this->template->load('_template', 'company/insurances', $this->data);
        } else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect('companies/details/' . $id);
        }
    }

    public function exports($id, $item_id = '')
    {

        if ($this->p_export) {
            $query = $this->Company->GetCompanyById($id);
            $this->data['id'] = $id;
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Companies', 'companies');
            $this->breadcrumb->add_crumb($query['name_en'], 'companies/details/' . $id);
            $this->breadcrumb->add_crumb('Export & Trade Market', 'companies/exports/' . $id);

            $this->form_validation->set_rules('country_id', 'Country', 'trim');
            $this->form_validation->set_rules('market_id', 'Market', 'trim');
            $this->form_validation->set_rules('item_type', 'Type', 'required');
            if ($this->form_validation->run()) {
                //var_dump($_POST);
                if ($_POST['action'] == 'add') {

                    if ($this->form_validation->set_value('item_type') == 'country') {
                        $market_id = $this->form_validation->set_value('country_id');
                    } elseif ($this->form_validation->set_value('item_type') == 'region') {
                        $market_id = $this->form_validation->set_value('market_id');
                    }
                    //	echo $market_id;
                    //	die;
                    $data = array(
                        'company_id' => $id,
                        'market_id' => $market_id,
                        'item_type' => $this->form_validation->set_value('item_type'),
                        'create_time' => $this->datetime,
                        'update_time' => $this->datetime,
                        'user_id' => $this->session->userdata('id'),
                    );

                    if ($nid = $this->General->save($this->company_markets, $data)) {
                        $item = $this->Company->GetCompanyMarketsById($nid);
                        $query = $this->Company->GetCompanyById($id);
                        if ($item['item_type'] == 'country') {
                            $row = $this->Parameter->GetCountryById($item['market_id']);
                            $label_en = $row['label_en'];
                            $label_ar = $row['label_ar'];
                        } elseif ($item['item_type'] == 'region') {
                            $row = $this->Parameter->GetCompanyMarketById($item['market_id']);
                            $label_en = $row['label_en'];
                            $label_ar = $row['label_ar'];
                        }
                        $details = array('id' => $item['market_id'], 'name_ar' => $label_ar, 'name_en' => $label_en);
                        $history = array('action' => 'add', 'logs_id' => 0, 'item_id' => $nid, 'item_title' => $query['name_ar'], 'type' => 'markets_company', 'details' => json_encode($details), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));

                        $this->General->save('logs', $history);
                        $this->session->set_userdata(array('admin_message' => 'Trade Market Added successfully'));
                        redirect('companies/exports/' . $id);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Error'));
                        redirect('companies/exports/' . $id . '/' . $item_id);
                    }
                } else {
                    if ($this->form_validation->set_value('item_type') == 'country') {
                        $market_id = $this->form_validation->set_value('country_id');
                    } elseif ($this->form_validation->set_value('item_type') == 'region') {
                        $market_id = $this->form_validation->set_value('market_id');
                    }
                    $data = array(
                        'company_id' => $id,
                        'market_id' => $market_id,
                        'item_type' => $this->form_validation->set_value('item_type'),
                        'update_time' => $this->datetime,
                    );
                    $row = $this->Company->GetCompanyMarketsById($item_id);
                    if ($this->Administrator->edit($this->company_markets, $data, $item_id)) {
                        $newdata = $this->Administrator->affected_fields($row, $data);
                        $history = array('action' => 'edit', 'logs_id' => 0, 'company_id' => $item_id, 'type' => 'markets_company', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history);
                        $this->session->set_userdata(array('admin_message' => 'Trade Market Updated successfully'));
                        redirect('companies/exports/' . $id);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Error'));
                        redirect('companies/exports/' . $id . '/' . $item_id);
                    }
                }
            }
            if ($item_id == '') {

                $this->data['subtitle'] = 'Add';
                $this->data['action'] = 'add';
                $this->data['display'] = '';
                $this->data['country_id'] = '';
                $this->data['market_id'] = '';
                $this->data['item_type'] = '';
            } else {

                $row = $this->Company->GetCompanyMarketsById($item_id);

                $this->data['subtitle'] = 'Edit';
                $this->data['action'] = 'edit';
                $this->data['display'] = $row['market_ar'] . '<br><hr />' . $row['market_en'];
                $this->data['country_id'] = $row['country_id'];
                $this->data['market_id'] = $row['market_id'];
                $this->data['item_type'] = $row['item_type'];
            }
            $this->data['c_id'] = $id;


            $this->data['query'] = $query;

            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['items'] = $items = $this->Company->GetCompanyMarkets($id);
            $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";
            $this->data['countries'] = $this->Company->GetCountries('online', 0, 0);
            $this->data['markets'] = $this->Parameter->GetCompanyMarkets('online');

            $markets_ids = array();
            $country_ids = array();

            foreach ($items as $item) {
                if ($item->item_type == 'region') {
                    array_push($markets_ids, $item->market_id);
                } elseif ($item->item_type == 'country') {
                    array_push($country_ids, $item->market_id);
                }
            }
            $this->data['markets_ids'] = $markets_ids;
            $this->data['country_ids'] = $country_ids;
            $this->template->load('_template', 'company/exports', $this->data);
        } else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect('companies/details/' . $id);
        }
    }

    public function production_create($id)
    {
        if ($this->p_production) {
            $query = $this->Company->GetCompanyById($id);
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Companies', 'companies');
            $this->breadcrumb->add_crumb($query['name_en'], 'companies/details/' . $id);
            $this->breadcrumb->add_crumb('Production information', 'companies/productions/' . $id);
            $this->breadcrumb->add_crumb('Add New Production Item');

            $this->form_validation->set_rules('heading_id', 'Heading', 'required');

            if ($this->form_validation->run()) {

                $data = array(
                    'company_id' => $id,
                    'heading_id' => $this->form_validation->set_value('heading_id'),
                    'create_time' => $this->datetime,
                    'update_time' => $this->datetime,
                    'user_id' => $this->session->userdata('id'),
                );

                if ($this->General->save($this->company_heading, $data)) {
                    $this->session->set_userdata(array('admin_message' => 'Prodduction Added successfully'));
                    redirect('companies/productions/' . $id);
                } else {
                    $this->session->set_userdata(array('admin_message' => 'Error'));
                    redirect('companies/prodcution-create/' . $id);
                }
            }
            $this->data['c_id'] = $id;

            $this->data['heading_id'] = '';
            $this->data['subtitle'] = 'Add New Production Item';
            $this->data['title'] = $this->data['Ctitle'] . "- Add New Production Item";
            $this->template->load('_template', 'company/production_form', $this->data);
        } else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect('companies/details/' . $id);
        }
    }
    public function task_add($company_id,$sales_man,$status)
    {
        $query = $this->Company->GetCompanyById($company_id);
        // var_dump($query);
        $tasks=$this->Task->GetListTasks('', '', $query['governorate_id'], $query['district_id'], $query['area_id'], '', $sales_man, '', '', '', '', '', '','', 0, 0);

        $list_id=0;
        if($tasks['num_results']>0)
        {
            $list_id=$tasks['results'][0]->list_id;
        }
        else{
            $sql=$this->Task->GetMaxList($sales_man);
            $list_id= $sql['list_id']+1;
        }

        $data=array(
            'list_id'=>$list_id,
            'company_id'=>$company_id,
            'governorate_id'=>$query['governorate_id'],
            'district_id'=>$query['district_id'],
            'area_id'=>$query['area_id'],
            'sales_man_id'=>$sales_man,
            'status'=>$status,
            'year'=>date('Y'),
            'category'=>'scanning',
            'comments'=>'Auto add by create company',
            'create_time' => $this->datetime,
            'update_time' => $this->datetime,
            'user_id' => $this->session->userdata('id')
        );
        $tid=$this->General->save('tbl_tasks',$data);
        return $tid;
    }
    public function task_update($company_id,$governorate,$district,$area)
    {
        $query = $this->Company->GetCompanyById($company_id);
        // var_dump($query);
        $tasks=$this->Task->GetListTasks('', $company_id, '', '', '', '', '', '', '', '', '', '', '','', 0, 0);

        $list_id=0;
        if($tasks['num_results']>0)
        {
            $list_id=$tasks['results'][0]->list_id;
        }
        else{
            $sql=$this->Task->GetMaxList($sales_man);
            $list_id= $sql['list_id']+1;
        }

        $data=array(
            'list_id'=>$list_id,
            'company_id'=>$company_id,
            'governorate_id'=>$query['governorate_id'],
            'district_id'=>$query['district_id'],
            'area_id'=>$query['area_id'],
            'sales_man_id'=>$sales_man,
            'status'=>$status,
            'year'=>date('Y'),
            'category'=>'scanning',
            'comments'=>'Auto add by create company',
            'create_time' => $this->datetime,
            'update_time' => $this->datetime,
            'user_id' => $this->session->userdata('id')
        );
        $tid=$this->General->save('tbl_tasks',$data);
        return $tid;
    }
    function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}
        function checkIsAValidDate($date, $format = 'Y-m-d'){
               $d = DateTime::createFromFormat($format, $date);
            // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
            return $d && $d->format($format) === $date;
        }
    public function create()
    { 
        if ($this->p_add) {
            $this->data['nave'] = FALSE;
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Companies', 'companies');
            $this->breadcrumb->add_crumb('Add New Company');

            $this->form_validation->set_rules('name_ar', 'company name in arabic', 'required');

            if ($this->form_validation->run()) {

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
                $task_status=$this->input->post('task_status');
                $add_task=$this->input->post('add_task');
                $data = array(
                    'ref' => $this->input->post('ref'),
                    'name_ar' => $this->input->post('name_ar'),
                    'name_en' => $this->input->post('name_en'),
                    'sector_id' => $this->input->post('sector_id'),
                    //'establish_date'=> $this->input->post('establish_date'),
                    'start_date' => $this->input->post('start_date'),
                    'commercial_register_ar' => $this->input->post('commercial_register_ar'),
                    'commercial_register_en' => $this->input->post('commercial_register_en'),
                    'activity_ar' => $this->input->post('activity_ar'),
                    'activity_en' => $this->input->post('activity_en'),
                    'com_capital' => $this->input->post('com_capital'),
                    'company_type_id' => $this->input->post('company_type_id'),
                    'governorate_id' => $this->input->post('governorate_id'),
                    'district_id' => $this->input->post('district_id'),
                    'area_id' => $this->input->post('area_id'),
                    'street_ar' => $this->input->post('street_ar'),
                    'street_en' => $this->input->post('street_en'),
                    'bldg_ar' => $this->input->post('bldg_ar'),
                    'bldg_en' => $this->input->post('bldg_en'),
                    'fax' => $this->input->post('fax'),
                    'phone' => $this->input->post('phone'),
                    'whatsapp' => $this->input->post('whatsapp'),
                    'pobox_ar' => $this->input->post('pobox_ar'),
                    'pobox_en' => $this->input->post('pobox_en'),
                    'email' => $this->input->post('email'),
                    'website' => $this->input->post('website'),
                    //'x_location'=> $x,
                    //'y_location'=> $y,
                    'x_decimal' => $this->input->post('x_decimal'),
                    'y_decimal' => $this->input->post('y_decimal'),
                    'rep_person_ar' => $this->input->post('rep_person_ar'),
                    'rep_person_en' => $this->input->post('rep_person_en'),
                    'position_id' => $this->input->post('position_id'),
                    'iro_code' => $this->input->post('iro_code'),
                    'igr_code' => $this->input->post('igr_code'),
                    'leb_ind_group' => $this->input->post('leb_ind_group'),
                    'sales_man_id' => $this->input->post('sales_man_ids'),
                    'auth_no' => $this->input->post('auth_no'),
                    'owner_name' => $this->input->post('owner_name'),
                    'eas_code' => $this->input->post('eas_code'),
                    'tun_code' => $this->input->post('tun_code'),
                    'beside_en' => $this->input->post('beside_en'),
                    'beside_ar' => $this->input->post('beside_ar'),
                    'show_online' => $this->input->post('show_online'),
                    'owner_name_en' => $this->input->post('owner_name_en'),
                    'copy_res' => $this->input->post('copy_res'),
                    'copy_res_bold' => $this->input->post('copy_res_bold'),
                    'is_adv' => $this->input->post('is_adv'),
                    'entry_date' => valid_date($this->input->post('entry_date')),
                    'ref' => $this->input->post('ref'),
                    'trade_license' => $this->input->post('trade_license'),
                    'auth_person_ar' => $this->input->post('auth_person_ar'),
                    'auth_person_en' => $this->input->post('auth_person_en'),
                    'license_date' => valid_date($this->input->post('license_date')),
                    'license_source_ar' => $this->input->post('license_source_ar'),
                    'license_source_en' => $this->input->post('license_source_en'),
                    'license_type' => $this->input->post('license_type'),
                    'app_fill_date' => valid_date($this->input->post('app_fill_date')),
                    'exp_dest_ar' => $this->input->post('exp_dest_ar'),
                    'exp_dest_en' => $this->input->post('exp_dest_en'),
                    'personal_notes' => $this->input->post('personal_notes'),
                    'adv_pic' => $this->input->post('adv_pic'),

                    'start_date_adv' =>valid_date( $this->input->post('start_date_adv')),
                    'end_date_adv' => valid_date($this->input->post('end_date_adv')),
                    'status_adv' => $this->input->post('status_adv'),

                    'ind_association' => $this->input->post('ind_association'),
                    'license_source_id' => $this->input->post('license_source_id'),

                    'display_directory' => ($this->input->post('display_directory') != false) ? 1 : 0,
                    'directory_interested' => $this->input->post('directory_interested'),
                    'display_exhibition' => ($this->input->post('display_exhibition') != false) ? 1 : 0,
                    'exhibition_interested' => $this->input->post('exhibition_interested'),
                    'address2_ar' => $this->input->post('address2_ar'),
                    'address2_en' => $this->input->post('address2_en'),

                    'wezara_source' => ($this->input->post('wezara_source') != false) ? 1 : 0,
                    'other_source' => $this->input->post('other_source'),
                    'nbr_source' => $this->input->post('nbr_source'),
                    'date_source' => valid_date($this->input->post('date_source')),
                    'type_source' => $this->input->post('type_source'),
                    'ministry_id' => is_numeric($this->input->post('ministry_id'))?$this->input->post('ministry_id'):0,
                    'employees_number' => $this->input->post('employees_number'),
                    'is_closed' => ($this->input->post('is_closed') != false) ? 1 : 0,
                    'error_address' => ($this->input->post('error_address') != false) ? 1 : 0,
                    'acc' => ($this->input->post('acc') != false) ? 'yes' : 'no',
                    'closed_date' => valid_date($this->input->post('closed_date')),
                    'related_companies'=>$this->input->post('related_companies'),
                    'chambe_commerce_no'=>$this->input->post('chambe_commerce_no'),
                    'chambe_commerce_category'=>$this->input->post('chambe_commerce_category'),
                    'delivery'=>($this->input->post('delivery_by') != '') ? 1 : 0,
                    'delivery_by'=>$this->input->post('delivery_by'),
                    'delivery_date'=>valid_date($this->input->post('delivery_date')),
                    'copy_qty'=>is_numeric($this->input->post('copy_qty'))?$this->input->post('copy_qty'):0,
                    'adv_salesman_id'=>$this->input->post('adv_salesman_id'),
                    'copy_res_salesman_id'=>$this->input->post('copy_res_salesman_id'),
                    'sales_note'=>$this->input->post('sales_note'),
                    'create_time' => $this->datetime,
                    'update_time' => $this->datetime,
                    'status' => $this->input->post('show_online')==1? 'online':'offline',
                    'user_id' => $this->session->userdata('id'),
                );

                if ($id = $this->General->save($this->company, $data)) {
                    $history = array('action' => 'add', 'logs_id' => 0, 'type' => 'company', 'details' => json_encode($data), 'item_id' => $id, 'item_title' => $data['name_ar'], 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history);
                    if($add_task==1 and $this->input->post('sales_man_ids')!=0)
                        $this->task_add($id,$this->input->post('sales_man_ids'),$task_status);
                    $this->session->set_userdata(array('admin_message' => 'Company Added successfully'));
                    redirect('companies/details/' . $id);
                } else {
                    $this->session->set_userdata(array('admin_message' => 'Error'));
                    redirect('companies/create');
                }
            }
            /*             * ********************General Info*********************** */
            $this->data['c_id'] = '';
            $this->data['name_ar'] = '';
            $this->data['name_en'] = '';
            $this->data['owner_name'] = '';
            $this->data['owner_name_en'] = '';
            $this->data['auth_person_ar'] = '';
            $this->data['auth_person_en'] = '';
            $this->data['auth_no'] = '';
            $this->data['activity_ar'] = '';
            $this->data['activity_en'] = '';
            $this->data['establish_date'] = '';
            $this->data['sector_id'] = 0;
            $this->data['license_source_id'] = 0;
            $this->data['company_type_id'] = 0;

            $this->data['personal_notes'] = '';

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
            $this->data['whatsapp'] = '';
            $this->data['pobox_ar'] = '';
            $this->data['pobox_en'] = '';
            $this->data['email'] = '';
            $this->data['website'] = '';
            $this->data['x_location'] = '';
            $this->data['y_location'] = '';
            /*             * ***********************End Address***************** */
            $this->data['ind_association'] = 0;
            $this->data['iro_code'] = 0;
            $this->data['igr_code'] = 0;
            $this->data['eas_code'] = 0;

            /*             * ***********************Molhak***************** */
            $this->data['rep_person_ar'] = '';
            $this->data['rep_person_en'] = '';
            $this->data['app_fill_date'] = '';
            $this->data['position_id'] = 0;
            $this->data['sales_man_ids'] = 0;
            $this->data['is_exporter'] = '';
            $this->data['show_online'] = 1;
            $this->data['is_adv'] = 0;
            $this->data['adv_pic'] = '';

            $this->data['start_date_adv'] = '';
            $this->data['end_date_adv'] = '';
            $this->data['status_adv'] = 0;

            $this->data['copy_res'] = 0;
            $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
            $this->data['economical_assembly'] = $this->Company->GetEconomicalAssembly('online');
            $this->data['company_types'] = $this->Company->GetCompanyTypes('online');
            $this->data['districts'] = array();
            $this->data['areas'] = array();

            $this->data['sectors'] = $this->Item->GetSector('online', 0, 0);
            $this->data['iro_data'] = $this->Company->GetIndustrialRooms();
            $this->data['igr_data'] = $this->Company->GetIndustrialGroups();
            $this->data['eas_data'] = $this->Company->GetEconomicalAssemblies();
            $this->data['positions'] = $this->Company->GetPositions();
            $this->data['sales'] = $this->Company->GetSalesMen();
            $this->data['license_sources'] = $this->Company->GetLicenseSources();

            $this->data['subtitle'] = 'Add New Company';
            $this->data['title'] = $this->data['Ctitle'] . "- Add New Company";
            $this->template->load('_template', 'company/company_form', $this->data);
        } else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect('companies');
        }
    }
    public function market_export()
    {
       $id=$this->input->post('id');
        $data=array('is_exporter' => $this->input->post('is_exporter'));
        $this->Administrator->edit($this->company, $data, $id);
        $this->session->set_userdata(array('admin_message' => 'Company Market Updated successfully'));
        redirect($this->agent->referrer());

    }
    private function UpdateActivityTask($item_id,$salesman,$year)
    {
        $task=$this->Company->GetTaskByActivityItemId($item_id,$salesman,$year);

        if(count($task)>0) {
            $this->Administrator->edit('task_activities', array('status' => 'done', 'updated_info' => 1, 'update_time' => $this->datetime,), $task['id']);
        }
        //$this->Administrator->update('task_activities', array('status'=>'done','updated_info'=>1,'update_time' => $this->datetime,), array('item_id'=>$item_id,'item_id'=>$salesman,'year'=>$year));
    }
    public function update_acc($id)
    {
        $this->Administrator->edit($this->company, array('acc'=>'yes'), $id);
        $this->session->set_userdata(array('admin_message' => 'ACC. Status Updated successfully'));
        redirect($this->agent->referrer());

    }
    public function update_info()
    {
        $query=$this->Company->GetUpdatedInfoCompanies();
        echo count($query);
        foreach($query as $row)
        {

            //$this->Administrator->edit($this->company, array('update_info'=>1), $row->item_id);
        }
    }
    public function edit_task_status($company_id)
    {
        $status='done';
        $delivery_date=date('Y-m-d');
        $note='';
        $note.='<br>Delivery Date : '. $delivery_date;
        $task=$this->Task->GetTaskByCompanyId($company_id);

        $this->Administrator->update('tbl_tasks',array('status'=>$status,'delivery_date'=>$delivery_date,'comments'=>$note,'update_time' => $this->datetime),array('company_id'=>$company_id));
        $this->Administrator->update('tbl_company',array('update_info' => ($status == 'done') ? 1 : 0,'update_time' => $this->datetime),array('id'=>$company_id));
        $this->General->save('tbl_update_info_logs',array('company_id'=>$company_id,'update_info' => ($status == 'done') ? 1 : 0,'create_time' => $this->datetime,'update_time' => $this->datetime,'user_id'=>$this->session->userdata('id')));

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
    public function update_task_status($company_id)
    {
        $status='done';
        $delivery_date=date('Y-m-d');
        $note='';
        $note.='<br>Delivery Date : '. $delivery_date;
        $task=$this->Task->GetTaskByCompanyId($company_id);
        $this->Administrator->update('tbl_tasks',array('status'=>$status,'delivery_date'=>$delivery_date,'comments'=>$note,'update_time' => $this->datetime),array('company_id'=>$company_id));
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
        // redirect('companies');
    }
    public function edit($id)   
    { 
       // var_dump($_REQUEST);  die(); 
        if ($this->p_edit) {

            $this->data['nave'] = TRUE;

            $query = $this->Company->GetCompanyById($id);
           
            $this->data['query'] = $query;
            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Companies', 'companies');
            $this->breadcrumb->add_crumb($query['name_en'], 'companies/details/' . $id);
            $this->breadcrumb->add_crumb('Edit Company');

            $this->form_validation->set_rules('name_ar', 'company name in arabic', 'required');

            if ($this->form_validation->run()) { 
                //echo $this->input->post('display_exhibition');
                //die;
                $array = $this->Administrator->do_upload('uploads/');

                if ($array['target_path'] != "") {
                    $path = $array['target_path'];
                } else {
                    $path = $this->input->post('adv_pic');
                }
                $start_date_adv= null ;
                $end_date_adv= null ;
                $status_adv= 0;
                if($this->input->post('adv_pic') !=="" )
                {
                    $start_date_adv= valid_date($this->input->post('start_date_adv')) ;
                    $end_date_adv= valid_date($this->input->post('end_date_adv'))  ;
                    $status_adv= $this->input->post('status_adv');
     
                }
              
                $data = array(
                    'ref' => $this->input->post('ref'),
                    'name_ar' => $this->input->post('name_ar'),
                    'name_en' => $this->input->post('name_en'),
                    'sector_id' => $this->input->post('sector_id'),
                    'establish_date' => $this->input->post('establish_date'),
                    'start_date' => $this->input->post('start_date'),
                    'commercial_register_ar' => $this->input->post('commercial_register_ar'),
                    'commercial_register_en' => $this->input->post('commercial_register_en'),
                    'activity_ar' => $this->input->post('activity_ar'),
                    'activity_en' => $this->input->post('activity_en'),
                    'com_capital' => $this->input->post('com_capital'),
                    'company_type_id' => $this->input->post('company_type_id'),
                    'governorate_id' => $this->input->post('governorate_id'),
                    'district_id' => $this->input->post('district_id'),
                    'area_id' => $this->input->post('area_id'),
                    'street_ar' => $this->input->post('street_ar'),
                    'street_en' => $this->input->post('street_en'),
                    'bldg_ar' => $this->input->post('bldg_ar'),
                    'bldg_en' => $this->input->post('bldg_en'),
                    'fax' => $this->input->post('fax'),
                    'phone' => $this->input->post('phone'),
                    'whatsapp' => $this->input->post('whatsapp'),
                    'pobox_ar' => $this->input->post('pobox_ar'),
                    'pobox_en' => $this->input->post('pobox_en'),
                    'email' => $this->input->post('email'),
                    'website' => $this->input->post('website'),
                    'x_decimal' => $this->input->post('x_decimal'),
                    'y_decimal' => $this->input->post('y_decimal'),
                    'rep_person_ar' => $this->input->post('rep_person_ar'),
                    'rep_person_en' => $this->input->post('rep_person_en'),
                    'position_id' => $this->input->post('position_id'),
                    'iro_code' => $this->input->post('iro_code'),
                    'igr_code' => $this->input->post('igr_code'),
                    'leb_ind_group' => $this->input->post('leb_ind_group'),
                    'sales_man_id' => $this->input->post('sales_man_ids'),
                    'auth_no' => $this->input->post('auth_no'),
                    'owner_name' => $this->input->post('owner_name'),
                    'eas_code' => $this->input->post('eas_code'),
                    'tun_code' => $this->input->post('tun_code'),
                    'beside_en' => $this->input->post('beside_en'),
                    'beside_ar' => $this->input->post('beside_ar'),
                    'show_online' => $this->input->post('show_online'),
                    'owner_name_en' => $this->input->post('owner_name_en'),
                    'copy_res' => $this->input->post('copy_res'),
                    'copy_res_bold' => $this->input->post('copy_res_bold'),
                    'is_adv' => $this->input->post('is_adv'),
                    'entry_date' => valid_date($this->input->post('entry_date')),
                    'ref' => $this->input->post('ref'),
                    'trade_license' => $this->input->post('trade_license'),
                    'auth_person_ar' => $this->input->post('auth_person_ar'),
                    'auth_person_en' => $this->input->post('auth_person_en'),
                    'license_date' => valid_date($this->input->post('license_date')),
                    'license_source_ar' => $this->input->post('license_source_ar'),
                    'license_source_en' => $this->input->post('license_source_en'),
                    'license_type' => $this->input->post('license_type'),
                    'app_fill_date' => valid_date($this->input->post('app_fill_date')),
                    'exp_dest_ar' => $this->input->post('exp_dest_ar'),
                    'exp_dest_en' => $this->input->post('exp_dest_en'),
                    'personal_notes' => $this->input->post('personal_notes'),
                    'adv_pic' => $this->input->post('adv_pic'),

                    'start_date_adv' =>  $start_date_adv,
                    'end_date_adv' =>  $end_date_adv,
                    'status_adv' =>  $status_adv,


                    'ind_association' => $this->input->post('ind_association'),
                    'license_source_id' => $this->input->post('license_source_id'),
                    'display_directory' => ($this->input->post('display_directory') != false) ? 1 : 0,
                    'directory_interested' => $this->input->post('directory_interested'),
                    'display_exhibition' => ($this->input->post('display_exhibition') != false) ? 1 : 0,
                    'exhibition_interested' => $this->input->post('exhibition_interested'),
                    'address2_ar' => $this->input->post('address2_ar'),
                    'address2_en' => $this->input->post('address2_en'),

                    'wezara_source' => ($this->input->post('wezara_source') != false) ? 1 : 0,
                    'other_source' => $this->input->post('other_source'),
                    'nbr_source' => $this->input->post('nbr_source'),
                    'date_source' => $this->input->post('date_source'),
                    'type_source' => $this->input->post('type_source'),
                    'ministry_id' => is_numeric($this->input->post('ministry_id'))?$this->input->post('ministry_id'):0,
                    'employees_number' => $this->input->post('employees_number'),
                    'is_closed' => ($this->input->post('is_closed') != false) ? 1 : 0,
                    'error_address' => ($this->input->post('error_address') != false) ? 1 : 0,
                    'update_info' => ($this->input->post('task_status') != false) ? 1 : 0,
                    'acc' => ($this->input->post('acc') != false) ? 'yes' : 'no',
                    'closed_date' => $this->checkIsAValidDate($this->input->post('closed_date'))? $this->input->post('closed_date'):NULL,
                    'related_companies'=>$this->input->post('related_companies'),
                    'chambe_commerce_no'=>$this->input->post('chambe_commerce_no'),
                    'chambe_commerce_category'=>$this->input->post('chambe_commerce_category'),
                    'delivery'=>($this->input->post('delivery_by') != '') ? 1 : 0,
                    'delivery_by'=>$this->input->post('delivery_by'),
                    'delivery_date'=>$this->checkIsAValidDate($this->input->post('delivery_date')) ? $this->input->post('delivery_date'):NULL,
                     'copy_qty'=>$this->input->post('copy_qty'),
                     'receiver_name'=>$this->input->post('receiver_name'),
                     'adv_salesman_id'=>$this->input->post('adv_salesman_id'),
                     'copy_res_salesman_id'=>$this->input->post('copy_res_salesman_id'),
                     'sales_note'=>$this->input->post('sales_note'),
                     'facebook'=>$this->input->post('facebook'),
                     'instagram'=>$this->input->post('instagram'),
                     'twitter'=>$this->input->post('twitter'),
                     'whatsapp'=>$this->input->post('whatsapp'),
                    'update_time' => $this->datetime,
                    'user_id' => $this->session->userdata('id'),
                ); 
               
               
                $delivery=($this->input->post('delivery_by') != '') ? 1 : 0;

                $query = $this->Company->GetCompanyById($id);
               
                $newdata = $this->Administrator->affected_fields($query, $data);
                $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $id, 'item_title' => $query['name_ar'], 'type' => 'company', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                $this->General->save('logs', $history);
               
                if ($this->Administrator->edit($this->company, $data, $id)) { 
                    if($delivery==1)
                    {
                       $this->Administrator->update('tbl_tasks',array('sales_man_id'=>$this->input->post('delivery_by'),'delivery_date'=>$this->input->post('delivery_date'),'status'=>'done','comments'=>'Delivered','update_time' => $this->datetime),array('company_id'=>$id,'category'=>'delivery'));  
                    }
                   // $this->Administrator->update('tbl_tasks',array('governorate_id'=>$this->input->post('governorate_id'),'district_id'=>$this->input->post('district_id'),'area_id'=>$this->input->post('area_id'),'sales_man_ids'=>$this->input->post('sales_man_ids'),'comments'=>'Updated area and transfer task','update_time' => $this->datetime),array('company_id'=>$id));
                    if($this->input->post('task_status')==1 )
                    {
                        $this->update_task_status($id);
                        $this->General->save('tbl_update_info_logs',array('company_id'=>$id,'update_info' => ($status == 'done') ? 1 : 0,'create_time' => $this->datetime,'update_time' => $this->datetime,'user_id'=>$this->session->userdata('id')));
                    }

                    // if($this->input->post('task_status')==1)
                    // {
                    //    $this->UpdateActivityTask($id,$this->input->post('sales_man_ids'),date('Y'));
                    // }


                    $this->session->set_userdata(array('admin_message' => 'Company Updated successfully'));
                    redirect('companies/details/' . $id);
                } else {
                    $this->session->set_userdata(array('admin_message' => 'Error'));
                    redirect('companies/edit/' . $id);
                }
            }
            
            /*             * ********************General Info*********************** */
            $this->data['c_id'] = $id;
            $this->data['id'] = $id;
            $this->data['ref'] = $query['ref'];
            $this->data['name_ar'] = $query['name_ar'];
            $this->data['name_en'] = $query['name_en'];
            $this->data['owner_name'] = $query['owner_name'];
            $this->data['owner_name_en'] = $query['owner_name_en'];
            $this->data['auth_person_ar'] = $query['auth_person_ar'];
            $this->data['auth_person_en'] = $query['auth_person_en'];
            $this->data['auth_no'] = $query['auth_no'];
            $this->data['activity_ar'] = $query['activity_ar'];
            $this->data['activity_en'] = $query['activity_en'];
            $this->data['establish_date'] = $query['establish_date'];
            $this->data['sector_id'] = $query['sector_id'];
            $this->data['license_source_id'] = $query['license_source_id'];
            $this->data['company_type_id'] = $query['company_type_id'];

            $this->data['personal_notes'] = $query['personal_notes'];
            $this->data['display_directory'] = $query['display_directory'];
            $this->data['directory_interested'] = $query['directory_interested'];
            $this->data['display_exhibition'] = $query['display_exhibition'];
            $this->data['exhibition_interested'] = $query['exhibition_interested'];

            /*             * ********************Address*********************** */
            $this->data['governorate_id'] = $query['governorate_id'];
            $this->data['district_id'] = $query['district_id'];
            $this->data['area_id'] = $query['area_id'];
            $this->data['street_ar'] = $query['street_ar'];
            $this->data['street_en'] = $query['street_en'];
            $this->data['bldg_ar'] = $query['bldg_ar'];
            $this->data['bldg_en'] = $query['bldg_en'];
            $this->data['fax'] = $query['fax'];
            $this->data['phone'] = $query['phone'];
            $this->data['whatsapp'] = $query['whatsapp'];
            $this->data['pobox_ar'] = $query['pobox_ar'];
            $this->data['pobox_en'] = $query['pobox_en'];
            $this->data['email'] = $query['email'];
            $this->data['website'] = $query['website'];
            $this->data['x_decimal'] = $query['x_decimal'];
            $this->data['y_decimal'] = $query['y_decimal'];
            /*             * ***********************End Address***************** */
            $this->data['ind_association'] = $query['ind_association'];
            $this->data['iro_code'] = $query['iro_code'];
            $this->data['igr_code'] = $query['igr_code'];
            $this->data['eas_code'] = $query['eas_code'];
            
            /*             * ***********************Molhak***************** */
            $this->data['rep_person_ar'] = $query['rep_person_ar'];
            $this->data['rep_person_en'] = $query['rep_person_en'];
            $this->data['app_fill_date'] = $query['app_fill_date'];
            $this->data['position_id'] = $query['position_id'];
            $this->data['sales_man_ids'] = $query['sales_man_id'];
            $this->data['is_exporter'] = $query['is_exporter'];
            $this->data['show_online'] = $query['show_online'];
            $this->data['is_adv'] = $query['is_adv'];
            $this->data['copy_res'] = $query['copy_res'];

            $this->data['adv_pic'] = $query['adv_pic'];
            $this->data['start_date_adv'] = $query['start_date_adv'];
            $this->data['end_date_adv'] = $query['end_date_adv'];
            $this->data['status_adv'] = $query['status_adv'];

            $this->data['address2_ar'] = $query['address2_ar'];
            $this->data['address2_en'] = $query['address2_en'];
            $this->data['ref'] = $query['ref'];

            $this->data['wezara_source'] = $query['wezara_source'];
            $this->data['other_source'] = $query['other_source'];
            $this->data['nbr_source'] = $query['nbr_source'];
            $this->data['date_source'] = $query['date_source'];
            $this->data['type_source'] = $query['type_source'];
            $this->data['chambe_commerce_category'] = $query['chambe_commerce_category'];
            $this->data['chambe_commerce_no'] = $query['chambe_commerce_no'];
            $this->data['task']=$task=$this->Company->GetTaskByActivityItemId($id,$query['sales_man_id'],date('Y'));
            $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
            $this->data['economical_assembly'] = $this->Company->GetEconomicalAssembly('online');
            $this->data['company_types'] = $this->Company->GetCompanyTypes('online');
            $this->data['districts'] = $this->Address->GetDistrictByGov('online', $query['governorate_id']);
            $this->data['areas'] = $this->Address->GetAreaByDistrict('online', $query['district_id']);

            $this->data['sectors'] = $this->Item->GetSector('online', 0, 0);
            $this->data['iro_data'] = $this->Company->GetIndustrialRooms();
            $this->data['igr_data'] = $this->Company->GetIndustrialGroups();
            $this->data['eas_data'] = $this->Company->GetEconomicalAssemblies();
            $this->data['positions'] = $this->Company->GetPositions();
            $this->data['sales'] = $this->Company->GetSalesMen();
            $this->data['license_sources'] = $this->Company->GetLicenseSources();

            $this->data['subtitle'] = 'Edit Company';
            $this->data['title'] = $this->data['Ctitle'] . "- Edit New Company";

            
            $this->template->load('_template', 'company/company_form', $this->data);
        } else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect('companies');
        }
    }

    public function power($id, $item_id = '')
    {

        if ($this->p_power) {
            $query = $this->Company->GetCompanyById($id);

            $this->breadcrumb->clear();
            $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
            $this->breadcrumb->add_crumb('Companies', 'companies');
            $this->breadcrumb->add_crumb($query['name_en'], 'companies/details/' . $id);
            $this->breadcrumb->add_crumb('Electric Power', 'companies/power/' . $id);

            $this->form_validation->set_rules('fuel', 'fuel', 'trim');
            $this->form_validation->set_rules('diesel', 'diesel', 'trim');
            if ($this->form_validation->run()) {
                if ($_POST['action'] == 'add') {
                    if ($this->form_validation->set_value('fuel') != '') {
                        $fuels = $this->form_validation->set_value('fuel') . ' ' . $this->input->post('fuel_unit');
                    } else {
                        $fuels = '';
                    }
                    if ($this->form_validation->set_value('diesel') != '') {
                        $diesels = $this->form_validation->set_value('diesel') . ' ' . $this->input->post('diesel_unit');
                    } else {
                        $diesels = '';
                    }
                    if ($fuels == '' and $diesels == '') {
                        $this->session->set_userdata(array('admin_message' => 'You musta t least select 1 field'));
                        redirect('companies/power/' . $id);
                    }
                    $data = array(
                        'company_id' => $id,
                        'fuel' => $fuels,
                        'diesel' => $diesels,
                        'create_time' => $this->datetime,
                        'update_time' => $this->datetime,
                        'user_id' => $this->session->userdata('id'),
                    );

                    if ($nid = $this->General->save($this->company_power, $data)) {
                        $query = $this->Company->GetCompanyById($id);
                        $history = array('action' => 'add', 'logs_id' => 0, 'item_id' => $nid, 'item_title' => $query['name_ar'], 'type' => 'power_company', 'details' => json_encode($data), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                        $this->General->save('logs', $history);
                        $this->session->set_userdata(array('admin_message' => 'Electric Power Item Added successfully'));
                        redirect('companies/power/' . $id);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Error'));
                        redirect('companies/power/' . $id . '/' . $item_id);
                    }
                } else {
                    if ($this->form_validation->set_value('fuel') != '') {
                        $fuels = $this->form_validation->set_value('fuel') . ' ' . $this->input->post('fuel_unit');
                    } else {
                        $fuels = '';
                    }
                    if ($this->form_validation->set_value('diesel') != '') {
                        $diesels = $this->form_validation->set_value('diesel') . ' ' . $this->input->post('diesel_unit');
                    } else {
                        $diesels = '';
                    }
                    $data = array(
                        'company_id' => $id,
                        'fuel' => $fuels,
                        'diesel' => $diesels,
                        'update_time' => $this->datetime,
                        'user_id' => $this->session->userdata('id'),
                    );
                    $row = $this->Company->GetCompanyEPower($id);
                    $query = $this->Company->GetCompanyById($id);
                    $newdata = $this->Administrator->affected_fields($row, $data);
                    $history = array('action' => 'edit', 'logs_id' => 0, 'item_id' => $row['id'], 'item_title' => $query['name_ar'], 'type' => 'power_company', 'details' => json_encode($newdata), 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
                    $this->General->save('logs', $history);
                    if ($this->Administrator->edit($this->company_power, $data, $row['id'])) {
                        $this->session->set_userdata(array('admin_message' => 'Electric Power Item Updated successfully'));
                        redirect('companies/power/' . $id);
                    } else {
                        $this->session->set_userdata(array('admin_message' => 'Error'));
                        redirect('companies/power/' . $id . '/' . $item_id);
                    }
                }
            }
            $items = $this->Company->GetCompanyElectricPowers($id);
            if (count($items) == 0) {

                $this->data['subtitle'] = 'Add';
                $this->data['action'] = 'add';
                $this->data['display'] = '';
                $fuel = array(0 => '', 1 => '');
                $diesel = array(0 => '', 1 => '');
            } else {

                $row = $this->Company->GetCompanyEPower($id);

                $this->data['subtitle'] = 'Edit';
                $this->data['action'] = 'edit';
                $this->data['display'] = @$row['fuel'] . '<br><hr />' . @$row['diesel'];

                $fuel = explode(' ', @$row['fuel']);
                $diesel = explode(' ', @$row['diesel']);
            }
            $this->data['id'] = $id;
            $this->data['c_id'] = $id;
            $this->data['fuel'] = @$fuel[0];
            $this->data['fuel_unit'] = @$fuel[1];
            $this->data['diesel'] = @$diesel[0];
            $this->data['diesel_unit'] = @$diesel[1];
            $this->data['query'] = $query;


            $this->data['msg'] = $this->session->userdata('admin_message');
            $this->session->unset_userdata('admin_message');
            $this->data['items'] = $this->Company->GetCompanyElectricPowers($id);
            $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";
            $this->template->load('_template', 'company/electric_power', $this->data);
        } else {

            $this->session->set_userdata(array('admin_message' => 'Access Denied'));
            redirect('companies/details/' . $id);
        }
    }

    public function sponsors($id)
    {

        /* 	$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'delete');
          $p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'edit');
          $p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,16,'add');
         */
        $query = $this->Company->GetCompanyById($id);
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Companies', 'companies');
        $this->breadcrumb->add_crumb($query['name_en'], 'companies/details/' . $id);
        $this->breadcrumb->add_crumb('Sponsors', 'companies/sponsors/' . $id);

        $this->data['c_id'] = $id;
        $this->data['query'] = $query;

        $this->data['p_delete'] = TRUE;
        $this->data['p_edit'] = TRUE;
        $this->data['p_add'] = TRUE;
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->data['items'] = $this->Company->GetCompanySponsors('online');
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";
        $this->data['subtitle'] = "Sponsors";
        $this->template->load('_template', 'company/sponsors', $this->data);
    }

    public function marketdata()
    {
        $query = $this->Company->GetCompanies('', 0, 0);
        foreach ($query as $row) {
            /*
              if($row->local_market==1)
              {
              $data=array();
              $data=array(
              'company_id'=>$row->id,
              'market_id'=>1,
              'item_type'=>'region',
              'create_time' =>  $this->datetime,
              'update_time' =>  $this->datetime,
              'user_id' =>  $this->session->userdata('id')
              );
              $this->General->save('tbl_markets_company',$data);
              }
              if($row->gulf_arab_state==1)
              {
              $data=array();
              $data=array(
              'company_id'=>$row->id,
              'market_id'=>2,
              'item_type'=>'region',
              'create_time' =>  $this->datetime,
              'update_time' =>  $this->datetime,
              'user_id' =>  $this->session->userdata('id')
              );
              $this->General->save('tbl_markets_company',$data);
              }
              if($row->other_arab_state==1)
              {
              $data=array();
              $data=array(
              'company_id'=>$row->id,
              'market_id'=>3,
              'item_type'=>'region',
              'create_time' =>  $this->datetime,
              'update_time' =>  $this->datetime,
              'user_id' =>  $this->session->userdata('id')
              );
              $this->General->save('tbl_markets_company',$data);
              }
              if($row->south_east_asia==1)
              {
              $data=array();
              $data=array(
              'company_id'=>$row->id,
              'market_id'=>4,
              'item_type'=>'region',
              'create_time' =>  $this->datetime,
              'update_time' =>  $this->datetime,
              'user_id' =>  $this->session->userdata('id')
              );
              $this->General->save('tbl_markets_company',$data);
              }
              if($row->north_west_asia==1)
              {
              $data=array();
              $data=array(
              'company_id'=>$row->id,
              'market_id'=>5,
              'item_type'=>'region',
              'create_time' =>  $this->datetime,
              'update_time' =>  $this->datetime,
              'user_id' =>  $this->session->userdata('id')
              );
              $this->General->save('tbl_markets_company',$data);
              }
              if($row->african_state==1)
              {
              $data=array();
              $data=array(
              'company_id'=>$row->id,
              'market_id'=>6,
              'item_type'=>'region',
              'create_time' =>  $this->datetime,
              'update_time' =>  $this->datetime,
              'user_id' =>  $this->session->userdata('id')
              );
              $this->General->save('tbl_markets_company',$data);
              }
              if($row->europian_countries==1)
              {
              $data=array();
              $data=array(
              'company_id'=>$row->id,
              'market_id'=>7,
              'item_type'=>'region',
              'create_time' =>  $this->datetime,
              'update_time' =>  $this->datetime,
              'user_id' =>  $this->session->userdata('id')
              );
              $this->General->save('tbl_markets_company',$data);
              }
              if($row->usa_canada==1)
              {
              $data=array();
              $data=array(
              'company_id'=>$row->id,
              'market_id'=>8,
              'item_type'=>'region',
              'create_time' =>  $this->datetime,
              'update_time' =>  $this->datetime,
              'user_id' =>  $this->session->userdata('id')
              );
              $this->General->save('tbl_markets_company',$data);
              }
              if($row->latin_american==1)
              {
              $data=array();
              $data=array(
              'company_id'=>$row->id,
              'market_id'=>9,
              'item_type'=>'region',
              'create_time' =>  $this->datetime,
              'update_time' =>  $this->datetime,
              'user_id' =>  $this->session->userdata('id')
              );
              $this->General->save('tbl_markets_company',$data);
              }
             */
            echo $row->name_ar . ' Local Market : ' . $row->local_market . ' 1';
            echo ' Gulf Arab States : ' . $row->gulf_arab_state . ' 2';
            echo ' other_arab_state : ' . $row->other_arab_state . ' 3';
            echo ' south_east_asia : ' . $row->south_east_asia . ' 4';
            echo ' north_west_asia : ' . $row->north_west_asia . ' 5';
            echo ' african_state : ' . $row->african_state . ' 6';
            echo ' europian_countries : ' . $row->europian_countries . ' 7';
            echo ' usa_canada : ' . $row->usa_canada . ' 8';
            echo ' latin_american : ' . $row->latin_american . ' 9';
            echo '<hr />';
        }
    }

    public function importexcel()
    {
        $file = base_url() . 'files/company.csv';
        $handle = fopen($file, "r");
        $c = 0;
        while (($filesop = fgetcsv($handle, filesize($file), ",")) !== false) {
            $data = array(
                'name_ar' => $filesop[1],
                'name_en' => $filesop[1],
                'owner_name' => $filesop[2],
                'owner_name_en' => $filesop[2],
                'activity_ar' => $filesop[3],
                'activity_en' => $filesop[3],
                'governorate_id' => $filesop[4],
                'district_id' => $filesop[5],
                'area_id' => $filesop[6],
                'street_ar' => $filesop[7],
                'street_en' => $filesop[7],
                'phone' => $filesop[8],
                'whatsapp' => $filesop[9],
                'fax' => $filesop[10],
                'email' => $filesop[11],
                'website' => $filesop[12],
                'personal_notes' => $filesop[13],
            );
            //$name = $filesop[0];
            //$email = $filesop[1];
            echo '<pre>';
            var_dump($data);
            echo '</pre>';
            //$sql = mysql_query("INSERT INTO csv (name, email) VALUES ('$name','$email')");
            $c = $c + 1;
        }
    }

    public function import()
    {
        error_reporting(7);
        ini_set('memory_limit', '1024M'); // or you could use 1G
        $name = 'wezaraa.xlsx';
        echo APPPATH;
        include APPPATH . 'libraries/PHPExcel/IOFactory.php';
        echo '22';
        $objPHPExcel = PHPExcel_IOFactory::load($name);
        echo '11';
        $maxCell = $objPHPExcel->getActiveSheet()->getHighestRowAndColumn();
        $sheetData = $objPHPExcel->getActiveSheet()->rangeToArray('A1:' . $maxCell['column'] . $maxCell['row']);
        //$sheetData = array_map('array_filter', $sheetData);
        //$sheetData = array_filter($sheetData);
        //unset($sheetData[0]);

        echo '<table border="1">';
        foreach ($sheetData as $temparr) {
            // $query = $this->Customer->GetCustomerByCodeNb(trim($temparr[0]));

            //$this->Administrator->change('customers', array('mobile' => trim($temparr[1])), array('card_code' => trim($temparr[0])));
            echo '<tr><td>' . trim($temparr[0]) . '</td><td>' . trim($temparr[1]) . '</td></tr>';
            //$code_array = explode(':', $temparr[22]);
            //$birthdate = date('Y-m-d', strtotime(trim($temparr[6])));
            //$registration_date = date('Y-m-d', strtotime(trim($temparr[25])));
            //  $customer = $this->Customer->GetOldCard(trim($code_array[1]));
            //echo trim($temparr[24]).'<br>';
            //echo trim($code_array[1]);
            //die;
            //$this->Administrator->edit('customers_old', $data, $customer['id']);
            //echo $temparr[23];
            //die;
            // $this->General->save('customers_old', $data);
            // echo trim($code_array[1]).' added <br>';
        }
        echo '</table>';
    }
public function imp()
    {
        error_reporting(7);
        ini_set('memory_limit', '1024M'); // or you could use 1G
        $name = FCPATH.'/industrialcompanies2017-2018.xlsx';
        echo APPPATH;
        include APPPATH . 'libraries/PHPExcel/IOFactory.php';
        echo '22';
        $objPHPExcel = PHPExcel_IOFactory::load($name);
        echo '11';
        $maxCell = $objPHPExcel->getActiveSheet()->getHighestRowAndColumn();
        $sheetData = $objPHPExcel->getActiveSheet()->rangeToArray('A1:' . $maxCell['column'] . $maxCell['row']);
        //$sheetData = array_map('array_filter', $sheetData);
        //$sheetData = array_filter($sheetData);
        //unset($sheetData[0]);

        echo '<table border="1">';
        foreach ($sheetData as $temparr) {
            // $query = $this->Customer->GetCustomerByCodeNb(trim($temparr[0]));

            //$this->Administrator->change('customers', array('mobile' => trim($temparr[1])), array('card_code' => trim($temparr[0])));
            echo '<tr><td>' . trim($temparr[0]) . '</td><td>' . trim($temparr[1]) . '</td></tr>';
            //$code_array = explode(':', $temparr[22]);
            //$birthdate = date('Y-m-d', strtotime(trim($temparr[6])));
            //$registration_date = date('Y-m-d', strtotime(trim($temparr[25])));
            //  $customer = $this->Customer->GetOldCard(trim($code_array[1]));
            //echo trim($temparr[24]).'<br>';
            //echo trim($code_array[1]);
            //die;
            //$this->Administrator->edit('customers_old', $data, $customer['id']);
            //echo $temparr[23];
            //die;
            // $this->General->save('customers_old', $data);
            // echo trim($code_array[1]).' added <br>';
        }
        echo '</table>';
    }
 public function dw()
{
    ini_set('memory_limit', '2048M');
     $json='[
{
"Category": "Second",
"Number": "6856",
"com-reg-no": "2049925",
"NM": "موريس ب. مشعلاني ش م م",
"L_NM": "Maurice B. Machaalany sarl",
"Last Subscription": "7-Feb-18",
"Industrial certificate no": "3134",
"Industrial certificate date": "10-Aug-18",
"ACTIVITY": "تجارة زيت زيتون، مخللات،شراب ومرطبات، ماء الزهر والورد، مربيات ودبس",
"Activity-L": "Trading of olive oil,pickel,soft drink,juice,orange flower&rose water,jam",
"ADRESS": "ملك موريس مشعلاني\u001c - شارع عازار\u001c - سن الفيل - المتن",
"TEL1": "01/510976",
"TEL2": "01/510977",
"TEL3": "03/936784",
"internet": "mbmfoods@yahoo.com"
},
{
"Category": "Fourth",
"Number": "23382",
"com-reg-no": "2029132",
"NM": "شركة اليزيه سويت 2 للصناعة والتجارة العامة",
"L_NM": "Elysee Sweet 2",
"Last Subscription": "20-Feb-18",
"Industrial certificate no": "146",
"Industrial certificate date": "8-Jan-19",
"ACTIVITY": "صناعة الحلويات العربية والافرنجية",
"Activity-L": "Manufacture of sweets",
"ADRESS": "ملك رضوان مخيبر\u001c - الشارع العام\u001c - دير كوشه - الشوف",
"TEL1": "03/207571",
"TEL2": "05/340490",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "30328",
"com-reg-no": "2051223",
"NM": "LE CHATEAU DU CHOCOLATIER نصري بيطار وشركاه  - توصية بسيطة",
"L_NM": "LE CHATEAU DU CHOCOLATIER -Nasri Bitar & Co",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "518",
"Industrial certificate date": "6-Sep-18",
"ACTIVITY": "التجارة العامة",
"Activity-L": "General Trade",
"ADRESS": "ملك نعمت جاد\u001c - الشارع العام\u001c - زوق مصبح- كسروان",
"TEL1": "09/215862",
"TEL2": "09/219863",
"TEL3": "",
"internet": "nasri@lechateauduchocolat,com"
},
{
"Category": "Second",
"Number": "7327",
"com-reg-no": "1014389",
"NM": "شركة المجموعة اللبنانية للالتزامات الطباعية ش م ل",
"L_NM": "Lebanese Printing Projects Group sal",
"Last Subscription": "24-Feb-18",
"Industrial certificate no": "4859",
"Industrial certificate date": "10-Nov-18",
"ACTIVITY": "طباعة وتجليد وتغليف وتقطيع الورق والكرتون",
"Activity-L": "Printing, binding, packing & cutting of paper & carton",
"ADRESS": "بناية عيتاني\u001c - شارع البطركية\u001c - زقاق البلاط - بيروت",
"TEL1": "07/9221116",
"TEL2": "03/224820",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1847",
"com-reg-no": "71088",
"NM": "شركة الخطيب ماشينري",
"L_NM": "Khatib Machinery Company - KMCO Power System",
"Last Subscription": "25-Feb-17",
"Industrial certificate no": "432",
"Industrial certificate date": "25-Apr-17",
"ACTIVITY": "تجميع المولدات الكهربائية",
"Activity-L": "Gathering of electrical generators",
"ADRESS": "بناية الفرح\u001c - طريق المطار\u001c - برج البراجنة - بعبدا",
"TEL1": "01/451486",
"TEL2": "01/451452",
"TEL3": "01/451485",
"internet": "kmco@kmcolb.com"
},
{
"Category": "Fourth",
"Number": "29586",
"com-reg-no": "1011695",
"NM": "مشغل نوبر للمجوهرات - ديما نوبر وشركاه",
"L_NM": "L\'atelier Nawbar",
"Last Subscription": "7-Feb-18",
"Industrial certificate no": "385",
"Industrial certificate date": "15-Aug-18",
"ACTIVITY": "تجارة المجوهرات",
"Activity-L": "Trading of jewelry",
"ADRESS": "بناية سوليدير\u001c - شارع الصيفي فيلج\u001c - وسط بيروت - بيروت",
"TEL1": "01/989338",
"TEL2": "03/240002",
"TEL3": "01/989339",
"internet": "dimanawbar@gmail.com"
},
{
"Category": "Fourth",
"Number": "30609",
"com-reg-no": "2035162",
"NM": "حنا جبران توماجان كوتور",
"L_NM": "Hanna Gebran Toumajean Couture",
"Last Subscription": "6-May-17",
"Industrial certificate no": "2862",
"Industrial certificate date": "22-Apr-18",
"ACTIVITY": "تجارة الملبوسات النسائية",
"Activity-L": "Trading of clothing for women",
"ADRESS": "ملك توماجان وعازر\u001c - الاوتوستراد\u001c - البوشرية - المتن",
"TEL1": "01/264222",
"TEL2": "01/264111",
"TEL3": "03/477216",
"internet": ""
},
{
"Category": "Third",
"Number": "32255",
"com-reg-no": "2039408",
"NM": "محمصة ابي نصر",
"L_NM": "Roastery Abi Nasr",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "3942",
"Industrial certificate date": "9-May-18",
"ACTIVITY": "تجارة جملة النقولات والبزورات",
"Activity-L": "Trading of Mixed Nuts ( Wholesale )",
"ADRESS": "ملك ابي نصر\u001c - شارع مجمع فؤاد شهاب الرياضي\u001c - حارة صخر- كسروان",
"TEL1": "09/901110",
"TEL2": "03/292984",
"TEL3": "",
"internet": "info@abinasrroastery.com"
},
{
"Category": "Fourth",
"Number": "29725",
"com-reg-no": "1019023",
"NM": "شركة زنكو غراف لبنان ش م م",
"L_NM": "Zincograph Du Liban",
"Last Subscription": "9-May-17",
"Industrial certificate no": "2224",
"Industrial certificate date": "12-Jul-17",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "بناية اللبان\u001c -  قريطم - شارع تقي الدين الصلح\u001c - رأس بيروت - بيروت",
"TEL1": "01/803806",
"TEL2": "01/813808",
"TEL3": "",
"internet": "zincolb@hotmail.com"
},
{
"Category": "Fourth",
"Number": "29415",
"com-reg-no": "2040728",
"NM": "بلو مير - ميدل ايست ش م ل",
"L_NM": "Bleu Mer - Me sal",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "296",
"Industrial certificate date": "8-Dec-18",
"ACTIVITY": "توضيب وحفظ الاسماك",
"Activity-L": "Packing & preserving of fish",
"ADRESS": "بناية شركة سيسكو\u001c - حي مار عبدا\u001c - بكفيا - المتن",
"TEL1": "03/641369",
"TEL2": "03/622040",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "7221",
"com-reg-no": "2042245",
"NM": "لايت ميتال باكيدجينغ ش م ل",
"L_NM": "Light Metal Packaging sal",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "4673",
"Industrial certificate date": "5-Oct-18",
"ACTIVITY": "صناعة علب تنك",
"Activity-L": "Manufacture of cans",
"ADRESS": "ملك شركة م. و.س.ت. ش م ل\u001c - العمروسيه - المنطقة الصاعية\u001c - الشويفات - عاليه",
"TEL1": "05/602250",
"TEL2": "03/948899",
"TEL3": "05/441308",
"internet": "brifcoint@yahoo.com"
},
{
"Category": "Fourth",
"Number": "30102",
"com-reg-no": "2010905",
"NM": "كونسريا انطونيو للصناعة والتجارة ش.م.م.",
"L_NM": "Conceria Antonio For Trade and Manufacturing sarl",
"Last Subscription": "7-Feb-18",
"Industrial certificate no": "4602",
"Industrial certificate date": "14-Sep-18",
"ACTIVITY": "مصنعا لدباغة الجلود",
"Activity-L": "Tanning of Leather",
"ADRESS": "ملك براج \u001c - شارع طرابلس\u001c - برج حمود- المتن",
"TEL1": "01/261404",
"TEL2": "03/888480",
"TEL3": "",
"internet": "conceria_taf@cyberia.net.lb"
},
{
"Category": "Fourth",
"Number": "23214",
"com-reg-no": "2041404",
"NM": "بون شوا - تضامن",
"L_NM": "Bon Choix",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "3836",
"Industrial certificate date": "19-Apr-18",
"ACTIVITY": "تجارة الحلويات الافرنجيه",
"Activity-L": "Trading of sweets",
"ADRESS": "ملك انيس مخيبر\u001c - حي العساكر- الشارع العام\u001c - دير كوشه - الشوف",
"TEL1": "03/821253",
"TEL2": "",
"TEL3": "",
"internet": "adel@bonchoixlbcom"
},
{
"Category": "Fourth",
"Number": "31200",
"com-reg-no": "2042775",
"NM": "اي باغ غروب ش م م",
"L_NM": "I Pack Group sarl",
"Last Subscription": "2-Dec-17",
"Industrial certificate no": "4284",
"Industrial certificate date": "27-Jul-18",
"ACTIVITY": "صناعة منتجات التعبئة والتغليف",
"Activity-L": "Manufacture of filling & packing",
"ADRESS": "ملك محمود العباسي\u001c - الدوحة - شارع كريدية\u001c - الشويفات - عاليه",
"TEL1": "03/696556",
"TEL2": "70/243536",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "31464",
"com-reg-no": "2041899",
"NM": "باي ش م م",
"L_NM": "Pye sarl",
"Last Subscription": "21-Feb-17",
"Industrial certificate no": "1887",
"Industrial certificate date": "16-May-17",
"ACTIVITY": "صناعة الحلويات العربية والافرنجية والبوظة",
"Activity-L": "Manufacture of oriental & western sweets & ice cream",
"ADRESS": "بناية النخلة\u001c - بئر العبد - شارع الدكاش\u001c - حارة حريك - بعبدا",
"TEL1": "71/101565",
"TEL2": "78/818275",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "7144",
"com-reg-no": "2037099",
"NM": "انترسـتايت انكـس ش م ل",
"L_NM": "Interstate Inks sal",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "4530",
"Industrial certificate date": "19-May-18",
"ACTIVITY": "صناعة الدهانات",
"Activity-L": "Manufacture of paints",
"ADRESS": "بناية انترستايت\u001c - المدينة الصناعية\u001c - حصرايل - جبيل",
"TEL1": "09/790884",
"TEL2": "09/790885",
"TEL3": "",
"internet": "karim.milan@interstateinks.com,"
},
{
"Category": "Third",
"Number": "29442",
"com-reg-no": "2045949",
"NM": "ليبانيز هايجين برودكتس ش م ل",
"L_NM": "Lebanese Hygiene products sal L.H.P.sal",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "4664",
"Industrial certificate date": "3-Oct-18",
"ACTIVITY": "صناعة الفوط الصحية والحفاضات",
"Activity-L": "Manufacture of sanitary napkin & diapers",
"ADRESS": "بناية ياسين\u001c - شارع الامراء\u001c - الشويفات - عاليه",
"TEL1": "05/481149",
"TEL2": "03/406034",
"TEL3": "",
"internet": "hilal.dana@lhpsal.com"
},
{
"Category": "Fourth",
"Number": "28854",
"com-reg-no": "2043058",
"NM": "Golden Sesame sarl",
"L_NM": "Golden Sesame sarl",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "204",
"Industrial certificate date": "16-Jan-19",
"ACTIVITY": "صناعة وتجارة جملة الحلاوة والطحينة",
"Activity-L": "Manufacture & Wholesale of halawa & tahineh",
"ADRESS": "ملك كامل وفهد\u001c - الشارع العام\u001c - بزحل - كسروان",
"TEL1": "09/865765",
"TEL2": "03/759820",
"TEL3": "03/717347",
"internet": "goldensesame2016@gmail.com"
},
{
"Category": "Fourth",
"Number": "30836",
"com-reg-no": "54077",
"NM": "شركة سركيس ش م م",
"L_NM": "Sarkis Co sarl",
"Last Subscription": "7-Mar-18",
"Industrial certificate no": "4362",
"Industrial certificate date": "24-Jul-18",
"ACTIVITY": "صناعة القساطل، وانابيب وقطع البلاستيكية، فراشي، مكانس ومسكات خشب وبلاستيك",
"Activity-L": "Manufacture of plastic tubes, brushes, brooms & sticks",
"ADRESS": "ملك انطوان سركيس\u001c - المدينة الصناعية\u001c - عين سعادة - المتن",
"TEL1": "01/894486",
"TEL2": "01/895563",
"TEL3": "03/220224",
"internet": "sarkisco@sarkisco.com"
},
{
"Category": "Fourth",
"Number": "30052",
"com-reg-no": "2045275",
"NM": "لكي بيرل للتجارة",
"L_NM": "Lucky Pearl Trading",
"Last Subscription": "16-Feb-18",
"Industrial certificate no": "2605",
"Industrial certificate date": "14-Mar-18",
"ACTIVITY": "تجارة المجوهرات",
"Activity-L": "Trading of jewelry",
"ADRESS": "ملك قيومجيان\u001c - سنتر ماسترمول\u001c - شارع المطرانية \u001c - برج حمود- المتن",
"TEL1": "70/964193",
"TEL2": "",
"TEL3": "",
"internet": "aramkouyoumjian@hotmail.com"
},
{
"Category": "Fourth",
"Number": "30849",
"com-reg-no": "2045370",
"NM": "شركة نوتريشنال مديتيرانيان فودز كومباني (ناتمد) ش م م",
"L_NM": "Nutritional Mediterranean Foods Company (NUTMED) sarl",
"Last Subscription": "24-Mar-18",
"Industrial certificate no": "4310",
"Industrial certificate date": "14-Jul-18",
"ACTIVITY": "صناعة طحن وتعبئة البهارات والحبوب والمأكولات النصف جاهزة",
"Activity-L": "Manufacture of milling & packing of spices, cereals & semi ready foods",
"ADRESS": "ملك غصن غصن\u001c - المدينة الصناعية\u001c - روميه - المتن",
"TEL1": "01/894694",
"TEL2": "03/789225",
"TEL3": "",
"internet": "nutmedco@gmail.com"
},
{
"Category": "Second",
"Number": "6437",
"com-reg-no": "1007186",
"NM": "شركة كلير ترم ش م م",
"L_NM": "Clear Trim sarl",
"Last Subscription": "24-Jan-18",
"Industrial certificate no": "3253",
"Industrial certificate date": "23-Feb-18",
"ACTIVITY": "خياطة الالبسة على انواعها",
"Activity-L": "Sewing of differnet kinds of clothes",
"ADRESS": "بناية 432 ملك الشركة\u001c - شارع الارز\u001c - الصيفي - بيروت",
"TEL1": "01/577774",
"TEL2": "01/577779",
"TEL3": "01/446644",
"internet": "saleh_bazzi@hotmail.com"
},
{
"Category": "Third",
"Number": "30936",
"com-reg-no": "69778",
"NM": "اس اند اس",
"L_NM": "S & S",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4125",
"Industrial certificate date": "13-May-18",
"ACTIVITY": "معملا لخياطة الشراشف والملابس الموحدة",
"Activity-L": "Manufacture of sheets & uniforms",
"ADRESS": "بناية غانم\u001c - شارع الشربينه\u001c - عجلتون - كسروان",
"TEL1": "09/234284",
"TEL2": "03/415218",
"TEL3": "03/066309",
"internet": ""
},
{
"Category": "Fourth",
"Number": "26439",
"com-reg-no": "1016191",
"NM": "اديتا ش م م",
"L_NM": "Adita sarl",
"Last Subscription": "19-Jan-17",
"Industrial certificate no": "2989",
"Industrial certificate date": "15-Dec-17",
"ACTIVITY": "صناعة مغلفات الورق وعلب الكرتون والطباعة عليها",
"Activity-L": "Manufacture of envelops & carton boxes",
"ADRESS": "بناية حيدر ورمضان ملك عيتاني\u001c - شارع جبل العرب\u001c - المصيطبة - بيروت",
"TEL1": "01/314568",
"TEL2": "03/046362",
"TEL3": "",
"internet": "info@aditaenvelopes.com"
},
{
"Category": "Fourth",
"Number": "26560",
"com-reg-no": "203490",
"NM": "كويكس",
"L_NM": "Quix",
"Last Subscription": "22-Jun-17",
"Industrial certificate no": "2850",
"Industrial certificate date": "16-Nov-17",
"ACTIVITY": "تصنيع وتوضيب وتبريد وتجليد المعجنات",
"Activity-L": "Manufacture,packing & frozen of Pastry",
"ADRESS": "ملك بسام بو داغر\u001c - الشارع العام\u001c - بصاليم - المتن",
"TEL1": "03/963053",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "26566",
"com-reg-no": "2023393",
"NM": "ادورا كوزمتيكس",
"L_NM": "Adora Cosmetics",
"Last Subscription": "23-Feb-18",
"Industrial certificate no": "4883",
"Industrial certificate date": "15-Nov-18",
"ACTIVITY": "تجارة جملة مستحضرات التجميل",
"Activity-L": "Wholesale of Cosmetic products",
"ADRESS": "ملك ايمن يزبك\u001c - طلعة مهنية العاملية\u001c - الشياح - بعبدا",
"TEL1": "01/456999",
"TEL2": "03/201963",
"TEL3": "",
"internet": "amy@dm.net.lb"
},
{
"Category": "Third",
"Number": "29212",
"com-reg-no": "2029988",
"NM": "الحلو البرتو ش م ل",
"L_NM": "El Helou Alberto sal",
"Last Subscription": "22-Mar-18",
"Industrial certificate no": "4040",
"Industrial certificate date": "15-Dec-18",
"ACTIVITY": "حفظ وتوضيب اللحوم",
"Activity-L": "Preserving & packing of meat",
"ADRESS": "ملك البر حلو\u001c - المونتيفردي - شارع البنا 14\u001c - بيت مري - المتن",
"TEL1": "01/267672",
"TEL2": "03/308806",
"TEL3": "",
"internet": "albertoelhelou@hotmil.com"
},
{
"Category": "Fourth",
"Number": "26214",
"com-reg-no": "2032490",
"NM": "هامكو ش م م",
"L_NM": "Hamco sarl",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "3474",
"Industrial certificate date": "25-Feb-18",
"ACTIVITY": "صناعة الدهانات",
"Activity-L": "Manufacture of paints",
"ADRESS": "بناية الهبر\u001c - شارع الرويس\u001c - الفنار - المتن",
"TEL1": "05/454292",
"TEL2": "03/277447",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "29117",
"com-reg-no": "1006762",
"NM": "احمد وليد وخالد اللبان - الفا باك - توصية بسيطة",
"L_NM": "A - Walid & Khalid Labban - Alpha Pack",
"Last Subscription": "2-Feb-18",
"Industrial certificate no": "435",
"Industrial certificate date": "22-Feb-19",
"ACTIVITY": "الطباعة على الكرتون والورق",
"Activity-L": "Printing on paper & carton",
"ADRESS": "بناية سعد وسعود ط سفلي 2\u001c - وطى المصيطبة - شارع البستاني\u001c - المصيطبة - بيروت",
"TEL1": "01/305004",
"TEL2": "01/705508",
"TEL3": "",
"internet": "alphapack.lb@hotmail.com"
},
{
"Category": "Fourth",
"Number": "26221",
"com-reg-no": "2002780",
"NM": "افرسيف ش م م",
"L_NM": "Eversafe sarl",
"Last Subscription": "23-Feb-17",
"Industrial certificate no": "3386",
"Industrial certificate date": "16-Feb-18",
"ACTIVITY": "صناعة الالبسة الموحدة",
"Activity-L": "Manufacture of uniforms",
"ADRESS": "ملك فريد سعد\u001c - الطريق البحرية\u001c - برج حمود - المتن",
"TEL1": "03/347634",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "26198",
"com-reg-no": "2025984",
"NM": "عبد الساتر ماربل غروب ش م م - AMG",
"L_NM": "Abdessater Marble Group sarl - AMG",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "445",
"Industrial certificate date": "22-Feb-19",
"ACTIVITY": "نشر، تفصيل وتجارة بلاط رخام",
"Activity-L": "Cutting & Trading of marbles",
"ADRESS": "بناية هدوان ط ارضي\u001c - شارع الجامعة اللبنانية\u001c - الدكوانة - المتن",
"TEL1": "01/511063",
"TEL2": "01/879582",
"TEL3": "03/406606",
"internet": "info@abdessater.com"
},
{
"Category": "Fourth",
"Number": "23705",
"com-reg-no": "2007344",
"NM": "فلكسيبل باكجينك انداستريز - اف بي أي-  ش م م",
"L_NM": "Flexible Pakaging Industries - FPI sarl",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4461",
"Industrial certificate date": "2-Feb-19",
"ACTIVITY": "صناعة اكياس النايلون",
"Activity-L": "Manufacture of nylon bags",
"ADRESS": "ملك وقف مار مارون عمشيت\u001c - الشارع العام\u001c - بلاط - جبيل",
"TEL1": "09/478823",
"TEL2": "09/478650",
"TEL3": "03/931912",
"internet": "info@fpiflex.com"
},
{
"Category": "Fourth",
"Number": "29667",
"com-reg-no": "2041513",
"NM": "J - S Style sarl",
"L_NM": "J - S Style sarl",
"Last Subscription": "16-Mar-18",
"Industrial certificate no": "3225",
"Industrial certificate date": "16-Mar-18",
"ACTIVITY": "صناعة الالبسة الرجالية والنسائية والولادية",
"Activity-L": "Manufacture of Men\'s ,ladies\' & children\'s clothes",
"ADRESS": "ملك فراشه ووفائي\u001c - حي المدارس - الشارع العام\u001c - بشامون - عاليه",
"TEL1": "01/307847",
"TEL2": "03/647481",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "25168",
"com-reg-no": "2022976",
"NM": "شركة ادوار اوزنيان واولاده ش م م",
"L_NM": "Edward Ouzounian & Sons sarl",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "2545",
"Industrial certificate date": "6-Mar-18",
"ACTIVITY": "صناعة المجوهرات",
"Activity-L": "Manufacture of jewelry",
"ADRESS": "ملك اوزنيان\u001c - حي المونتيفردي - الشارع العام\u001c - بيت مري - المتن",
"TEL1": "04/409000",
"TEL2": "03/688365",
"TEL3": "",
"internet": "info@ouzounian.com"
},
{
"Category": "Fourth",
"Number": "25153",
"com-reg-no": "1008986",
"NM": "ساراز باغ ش م م",
"L_NM": "Sarah\'s Bag sarl",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "3551",
"Industrial certificate date": "7-Mar-18",
"ACTIVITY": "صناعةالاشغال الحرفية والحقائب النسائية",
"Activity-L": "Manufacture of artisanal articles & ladies bags",
"ADRESS": "بناية بيضون\u001c - شارع قصقص\u001c - الحرج - بيروت",
"TEL1": "01/575585",
"TEL2": "01/575586",
"TEL3": "",
"internet": "sarahbeydoun73@gmail.com"
},
{
"Category": "First",
"Number": "5355",
"com-reg-no": "2029656",
"NM": "ايليغانس للتجارة ش م م",
"L_NM": "Elegance for Trade",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "3882",
"Industrial certificate date": "25-Apr-18",
"ACTIVITY": "صناعة الحلويات",
"Activity-L": "Manufacture of sweets",
"ADRESS": "ملك انور كميد\u001c - المدينة الصناعية\u001c - نهر ابراهيم - جبيل",
"TEL1": "09/445802",
"TEL2": "76/400068",
"TEL3": "",
"internet": "georges@elegancelebnon.com"
},
{
"Category": "Fourth",
"Number": "26074",
"com-reg-no": "2031940",
"NM": "مجوهرات كريدي",
"L_NM": "Kreidy Jewellery",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "3580",
"Industrial certificate date": "10-Mar-18",
"ACTIVITY": "صياغة المجوهرات",
"Activity-L": "Manufacture of jewelry",
"ADRESS": "بناية هاربويان\u001c - شارع البطريركية\u001c - برج حمود - المتن",
"TEL1": "03/305251",
"TEL2": "03/500038",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "26068",
"com-reg-no": "2030477",
"NM": "S. A. E. Design",
"L_NM": "S. A. E. Design",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "4104",
"Industrial certificate date": "8-Jun-18",
"ACTIVITY": "تصميم وخياطة الالبسة",
"Activity-L": "Fashion design & sewing",
"ADRESS": "بناية حربويان ملك شهازيان\u001c - مطرانية الارمن - الشارع العام\u001c - برج حمود - المتن",
"TEL1": "70/739588",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "24920",
"com-reg-no": "2031086",
"NM": "شركة باتيسري درويش - توصية بسيطة",
"L_NM": "Patisserie Darwich",
"Last Subscription": "1-Feb-17",
"Industrial certificate no": "2210",
"Industrial certificate date": "24-Jan-18",
"ACTIVITY": "صناعة الكاتو والحلويات",
"Activity-L": "Manufacture of cakes & sweets",
"ADRESS": "ملك درويش\u001c - المريجة - الساحة\u001c - برج البراجنة - بعبدا",
"TEL1": "01/471529",
"TEL2": "03/600334",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "5103",
"com-reg-no": "2031349",
"NM": "ام ك بلاست ش م ل",
"L_NM": "M. K. Plast sal",
"Last Subscription": "17-Mar-17",
"Industrial certificate no": "4768",
"Industrial certificate date": "23-Oct-18",
"ACTIVITY": "صناعة اواني بلاستيكية",
"Activity-L": "Manufacture of plasticware",
"ADRESS": "بناية الخوري ط ارضي وأول\u001c - حي الصناعية\u001c - بصاليم - المتن",
"TEL1": "04/717903",
"TEL2": "04/717904",
"TEL3": "",
"internet": "mkplast@terra.net.lb"
},
{
"Category": "Second",
"Number": "7114",
"com-reg-no": "2020743",
"NM": "بتروبلاس",
"L_NM": "Petro Plus",
"Last Subscription": "14-Oct-17",
"Industrial certificate no": "2872",
"Industrial certificate date": "18-Nov-17",
"ACTIVITY": "صناعة كبايات وصحون كرتون",
"Activity-L": "Manfacture of cartons cups & plates",
"ADRESS": "ملك ناجي جوهر\u001c - عين سنون\u001c - كيفون - عاليه",
"TEL1": "05/273350",
"TEL2": "05/273360",
"TEL3": "03/793558",
"internet": ""
},
{
"Category": "Fourth",
"Number": "26019",
"com-reg-no": "2030565",
"NM": "شركة سي سي تكنيك ليبانون ش م ل",
"L_NM": "CC Technique Lebanon sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4266",
"Industrial certificate date": "8-Jul-18",
"ACTIVITY": "تجارة جملة مواد لمنع النش",
"Activity-L": "Wholesale of waterproofing materials",
"ADRESS": "بناية رضا رضا\u001c - شارع التيرو\u001c - الشويفات - عاليه",
"TEL1": "01/353171",
"TEL2": "05/493006",
"TEL3": "03/240310",
"internet": ""
},
{
"Category": "Fourth",
"Number": "22981",
"com-reg-no": "2029207",
"NM": "لوغ اند لمبر ش م ل",
"L_NM": "Log & Lumber sal",
"Last Subscription": "23-Jan-18",
"Industrial certificate no": "3113",
"Industrial certificate date": "12-Jan-18",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك دياب\u001c - الشارع الداخلي\u001c - المكلس - المتن",
"TEL1": "01/694185",
"TEL2": "03/664660",
"TEL3": "",
"internet": "info@lognlumber.com"
},
{
"Category": "Third",
"Number": "29062",
"com-reg-no": "2029617",
"NM": "شركة سويت ارت ش م م",
"L_NM": "Sweet Art Co sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "4507",
"Industrial certificate date": "19-Aug-18",
"ACTIVITY": "صناعة الحلويات العربية والافرنجية",
"Activity-L": "Manufacture of oriental & western sweets",
"ADRESS": "ملك صالح خطار\u001c - الشارع العام\u001c - السمقانية - الشوف",
"TEL1": "05/502828",
"TEL2": "03/651131",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "32444",
"com-reg-no": "1019118",
"NM": "شركة حداد يونايتد ش م م",
"L_NM": "Haddad United sarl",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4931",
"Industrial certificate date": "27-Nov-18",
"ACTIVITY": "محمصة",
"Activity-L": "Roastery",
"ADRESS": "ملك الحداد \u001c - شارع بربور\u001c - المزرعة - بيروت",
"TEL1": "01/653181",
"TEL2": "01/653179",
"TEL3": "76/958188",
"internet": ""
},
{
"Category": "Third",
"Number": "32197",
"com-reg-no": "2018734",
"NM": "المصانع الحديثة للباطون الجاهز ش م ل",
"L_NM": "Modern Industries For Concrete sal",
"Last Subscription": "24-Jan-18",
"Industrial certificate no": "235",
"Industrial certificate date": "19-Jan-19",
"ACTIVITY": "صناعة الباطون الجاهز",
"Activity-L": "Production of ready concrerte",
"ADRESS": "بناية ابو جوده\u001c - شارع العام - قرب مشروع منير ابو جوده\u001c - المسقى والغابة - المتن",
"TEL1": "04/985080",
"TEL2": "71/788003",
"TEL3": "",
"internet": "mic-concrerte@kahy-holding.com"
},
{
"Category": "Fourth",
"Number": "22937",
"com-reg-no": "2026961",
"NM": "عبودكو يونيفورمز ش م م",
"L_NM": "Abboudco Uniforms sarl",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "4347",
"Industrial certificate date": "21-Jun-18",
"ACTIVITY": "صناعة الالبسة الرجالية والنسائية والبياضات العائدة للفنادق...",
"Activity-L": "Manufacture of men\'s & ladies\'  uniforms & linen for hotels ….",
"ADRESS": "بناية طنوس وحاج\u001c - حي سانت تريز\u001c - زوق مكايل - كسروان",
"TEL1": "09/213495",
"TEL2": "09/223999",
"TEL3": "",
"internet": "abboudco@hotmail.com"
},
{
"Category": "First",
"Number": "5102",
"com-reg-no": "2027856",
"NM": "الشركة اللبنانية للأسفلت والباطون L.A.C ش م ل",
"L_NM": "Lebanese Company for Asphalt and Concrete L.A.C sal",
"Last Subscription": "29-Nov-17",
"Industrial certificate no": "3959",
"Industrial certificate date": "12-Feb-18",
"ACTIVITY": "معملا لجبل الزفت",
"Activity-L": "Manufacture of asphalt",
"ADRESS": "ملك الريشاني\u001c - العمروسية - طريق التيرو\u001c - الشويفات - عاليه",
"TEL1": "05/480188",
"TEL2": "03/819998",
"TEL3": "03/221930",
"internet": "new-lac@hotmail.com"
},
{
"Category": "Fourth",
"Number": "24963",
"com-reg-no": "202889",
"NM": "شركة الوسام ترايدينغ ش م م",
"L_NM": "Wissam Trading Co. sarl",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "481",
"Industrial certificate date": "28-Aug-18",
"ACTIVITY": "تجارة اللحوم والدجاج",
"Activity-L": "Trading of meat & poultry",
"ADRESS": "ملك وسام عبد الخالق ط ارضي\u001c - حي الروضة - الساحة\u001c - حمانا - بعبدا",
"TEL1": "05/531254",
"TEL2": "03/707672",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "24765",
"com-reg-no": "2028698",
"NM": "مجوهرات سكجها ش م م",
"L_NM": "Sakkijha Jewelry sarl",
"Last Subscription": "9-Jan-17",
"Industrial certificate no": "2535",
"Industrial certificate date": "28-Sep-17",
"ACTIVITY": "صناعة المجوهرات",
"Activity-L": "Manufacture of Jewelry",
"ADRESS": "سنتر هاربوريان بلوك 2\u001c - شارع هاربوريان\u001c - برج حمود - المتن",
"TEL1": "03/637676",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "23554",
"com-reg-no": "2029497",
"NM": "لينا بلتز ش م ل",
"L_NM": "Lena Belts sal",
"Last Subscription": "10-Feb-18",
"Industrial certificate no": "3144",
"Industrial certificate date": "16-Jan-18",
"ACTIVITY": "تجارة الحقائب والالبسة والاحذية الجلدية",
"Activity-L": "Trading of leather bags, clothes and shoes",
"ADRESS": "ملك طوروسيان\u001c - شارع رقم 19\u001c - الحبوس - المتن",
"TEL1": "04/928944",
"TEL2": "04/926716",
"TEL3": "71/666490",
"internet": "lenabelts@lenabelts.com"
},
{
"Category": "Fourth",
"Number": "22963",
"com-reg-no": "2015571",
"NM": "شركة فينيا فيردي ش م م",
"L_NM": "Vignia Verde sarl",
"Last Subscription": "1-Nov-17",
"Industrial certificate no": "2642",
"Industrial certificate date": "12-May-18",
"ACTIVITY": "صناعة النبيذ",
"Activity-L": "Manufacture of wine",
"ADRESS": "ملك صبحي جعجع\u001c - شارع مدرسة سيدة الرسل\u001c - البوشرية - المتن",
"TEL1": "03/499570",
"TEL2": "03/844339",
"TEL3": "",
"internet": "info@vigniaverde.com"
},
{
"Category": "Fourth",
"Number": "22899",
"com-reg-no": "2024739",
"NM": "شركة الفا ش م م",
"L_NM": "Elva sarl",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4464",
"Industrial certificate date": "10-Aug-18",
"ACTIVITY": "صناعة قوالب صب احجار الباطون وجبالات والات المخابز (قطاعات عجين ...)",
"Activity-L": "Manufacture of moulds, concrete mixer & bakery equipment",
"ADRESS": "ملك زوهراب فارطان\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/497460",
"TEL2": "03/666134",
"TEL3": "03/666143",
"internet": "info@elvalb.com"
},
{
"Category": "Fourth",
"Number": "22869",
"com-reg-no": "2026437",
"NM": "اورو فيجن ش م م",
"L_NM": "Euro Vision sarl",
"Last Subscription": "28-Feb-18",
"Industrial certificate no": "3789",
"Industrial certificate date": "8-Apr-18",
"ACTIVITY": "صناعة الجزادين والاحزمة والالبسة الجلدية",
"Activity-L": "Manufacture of bags ,belts & leather clothes",
"ADRESS": "ملك جاغلاسيان\u001c - اتوستراد الدورة\u001c - برج حمود - المتن",
"TEL1": "01/264154",
"TEL2": "",
"TEL3": "",
"internet": "eurovision11@hotmail.com"
},
{
"Category": "Second",
"Number": "8027",
"com-reg-no": "2029468",
"NM": "ماني دورو ش م م",
"L_NM": "Mani Doro sarl",
"Last Subscription": "2-Feb-18",
"Industrial certificate no": "4387",
"Industrial certificate date": "27-Jul-18",
"ACTIVITY": "اعمال الديكور الداخلي - تجارة وصناعة المفروشات المنزلية",
"Activity-L": "Interior design -Trading & Manufacture of furniture",
"ADRESS": "ملك طوني رحمة - المدينة الصناعية - ذوق مصبح  - كسروان",
"TEL1": "09/217917",
"TEL2": "03/771718",
"TEL3": "",
"internet": "bassamrahmeh@gmail.com"
},
{
"Category": "Fourth",
"Number": "22818",
"com-reg-no": "2030562",
"NM": "ليبك فابريكايشن ش م ل",
"L_NM": "Lepeq Fabrication sal",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "3583",
"Industrial certificate date": "19-Sep-18",
"ACTIVITY": "صناعة ماكينات التغليف",
"Activity-L": "Manufacture of packing machinery",
"ADRESS": "ملك شادي مغبغب\u001c - شارع الارزة\u001c - البوشرية - المتن",
"TEL1": "01/691850",
"TEL2": "01/693850",
"TEL3": "03/935256",
"internet": "info@lepeq.com"
},
{
"Category": "Fourth",
"Number": "28592",
"com-reg-no": "2039904",
"NM": "شركة قدسي غروب ش.م.ل",
"L_NM": "Koudsi Group sal",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "3445",
"Industrial certificate date": "22-Feb-18",
"ACTIVITY": "حياكة وخياطة التريكو وخياطة الألبسة المختلفة",
"Activity-L": "Sewing of tricot & other clothes",
"ADRESS": "ملك قدسي\u001c - المنطقة الصناعية - شارع رقم 32\u001c - المكلس - المتن",
"TEL1": "01/693776",
"TEL2": "03/654845",
"TEL3": "03/617407",
"internet": "sami.koudsi@yahoo.com"
},
{
"Category": "Second",
"Number": "6236",
"com-reg-no": "2020475",
"NM": "اي - زد مانيفاكتورنغ اند ترايدنغ كومباني ش م م",
"L_NM": "A - Z Manufacturing And Trading Company sarl",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "3159",
"Industrial certificate date": "15-Mar-18",
"ACTIVITY": "صناعة المايونيز",
"Activity-L": "Manufacture of mayonnaise",
"ADRESS": "ملك فواز مرعي\u001c - حي البساتين - الشارع العام\u001c - عين عنوب - عاليه",
"TEL1": "01/611885",
"TEL2": "01/611886",
"TEL3": "70/822202",
"internet": "az-manufacturing@az-manufacturing.com"
},
{
"Category": "Fourth",
"Number": "22667",
"com-reg-no": "2009287",
"NM": "شركة بروبلاست ش م م",
"L_NM": "Proplast sarl",
"Last Subscription": "7-Jun-17",
"Industrial certificate no": "4936",
"Industrial certificate date": "27-Nov-18",
"ACTIVITY": "معملاَ للخراطة وتصنيع القوالب المعدنية وتصنيع علب بلاستيكية",
"Activity-L": "Turnery of metal moulds & manufacture of plastic boxes",
"ADRESS": "ملك سامي همدر\u001c - حي الجامع - الشارع العام\u001c - الحصون - جبيل",
"TEL1": "03/221531",
"TEL2": "03/356284",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "29391",
"com-reg-no": "2033901",
"NM": "سامتك ش م م",
"L_NM": "Samtec sarl",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "047",
"Industrial certificate date": "18-Dec-18",
"ACTIVITY": "صناعة الالات صناعية",
"Activity-L": "Manufacture of industrial machinery",
"ADRESS": "ملك سامي عبيد\u001c - حي مار روكز\u001c - الدكوانة - المتن",
"TEL1": "01/898600",
"TEL2": "03/827484",
"TEL3": "",
"internet": "samtec@mysamtec.com"
},
{
"Category": "Fourth",
"Number": "27366",
"com-reg-no": "2038867",
"NM": "شركة جنيال ش م م",
"L_NM": "Genial sarl",
"Last Subscription": "22-Feb-18",
"Industrial certificate no": "4169",
"Industrial certificate date": "20-Jun-18",
"ACTIVITY": "معملا لصناعة اكياس النايلون ومنتجات بلاستيكية والطباعة عليها",
"Activity-L": "Manufacture & printing of plastic bags & rolling sheets",
"ADRESS": "ملك روحانا - الشارع العام -  عمشيت - جبيل",
"TEL1": "78/888310",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "22652",
"com-reg-no": "2014512",
"NM": "يونيكاب",
"L_NM": "Unicap",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "3540",
"Industrial certificate date": "4-Mar-18",
"ACTIVITY": "صناعة الاغطية البلاستيكية وبريفورم PET",
"Activity-L": "Manufacture of plastic coverings &  PET",
"ADRESS": "ملك بابيك\u001c - الاوتوستراد\u001c - زوق مصبح - كسروان",
"TEL1": "03/349011",
"TEL2": "03/276754",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "24419",
"com-reg-no": "2025921",
"NM": "فرينكس ش م م",
"L_NM": "Freenex sarl",
"Last Subscription": "6-Mar-18",
"Industrial certificate no": "4763",
"Industrial certificate date": "23-Oct-18",
"ACTIVITY": "صناعة وتجارة محارم ورق وصحي وتواليت",
"Activity-L": "Trading of tissues & toilet paper",
"ADRESS": "بناية بانوراما ملك حسان وحمزة\u001c - شارع البلدية\u001c - عرمون - عاليه",
"TEL1": "05/813346",
"TEL2": "03/639959",
"TEL3": "76/609074",
"internet": "freenex@lifco.com"
},
{
"Category": "Fourth",
"Number": "22618",
"com-reg-no": "2017794",
"NM": "شركة دادور ش م ل",
"L_NM": "Dadour sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4512",
"Industrial certificate date": "21-Aug-18",
"ACTIVITY": "صناعة نشر الرخام والغرانيت",
"Activity-L": "Manufacture of cutting marble & granite",
"ADRESS": "ملك دادور وابو جوده\u001c - الطريق البحرية\u001c - عمارة شلهوب - المتن",
"TEL1": "01/892026",
"TEL2": "03/305304",
"TEL3": "03/408383",
"internet": "youssef@dadour.net"
},
{
"Category": "Fourth",
"Number": "29623",
"com-reg-no": "2039905",
"NM": "انجاز للصناعة ش م م",
"L_NM": "Injaz Industry sarl",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4643",
"Industrial certificate date": "29-Mar-18",
"ACTIVITY": "فرم وطحن دواليب الكاوتشوك",
"Activity-L": "Chopping & grinding of tires",
"ADRESS": "ملك طارق الزعيم وشركاه\u001c - الشارع العام - مقابل البلدية\u001c - بعورته - عاليه",
"TEL1": "05/600954",
"TEL2": "76/060358",
"TEL3": "",
"internet": "injazindustry@gmail.com"
},
{
"Category": "Fourth",
"Number": "24364",
"com-reg-no": "2010694",
"NM": "معمل سليم ميشال اسعد للبلاط والرخام",
"L_NM": "Salim Michel Assaad Factory forTiles & Marbles",
"Last Subscription": "5-May-17",
"Industrial certificate no": "2697",
"Industrial certificate date": "27-Mar-18",
"ACTIVITY": "معملاً لنشر وتفصيل وجلي الرخام",
"Activity-L": "Sawing & shaping of marbles",
"ADRESS": "ملك سليم اسعد ط ارضي\u001c - الشارع العام\u001c - خربة بسري - الشوف",
"TEL1": "03/343919",
"TEL2": "03/365660",
"TEL3": "07/810818",
"internet": ""
},
{
"Category": "Fourth",
"Number": "25520",
"com-reg-no": "2018268",
"NM": "الشركة المتحدة ش م م ابراهيم ابناء عم",
"L_NM": "United Co. sarl",
"Last Subscription": "16-Nov-17",
"Industrial certificate no": "4177",
"Industrial certificate date": "21-Jun-18",
"ACTIVITY": "فرن للخبز والكعك",
"Activity-L": "Bakery",
"ADRESS": "سنتر مهدي ملك ابراهيم\u001c - الاوتوستراد\u001c - الشياح - بعبدا",
"TEL1": "01/540986",
"TEL2": "71/233215",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "5173",
"com-reg-no": "1015474",
"NM": "شركة اراكو للملدنات ومواد البناء ش م م",
"L_NM": "Araco For Admixture & Costruction Material sarl",
"Last Subscription": "10-May-17",
"Industrial certificate no": "1353",
"Industrial certificate date": "17-Nov-15",
"ACTIVITY": "تجارة مواد لمنع النش",
"Activity-L": "Trading of waterproofing materials",
"ADRESS": "بناية هاربور تاور\u001c - جادة شارل الحلو\u001c - الصيفي- بيروت",
"TEL1": "03/105066",
"TEL2": "70/120072",
"TEL3": "01/444729",
"internet": "aacm@araco-group.net"
},
{
"Category": "Fourth",
"Number": "24526",
"com-reg-no": "2016722",
"NM": "شركة موتيارا ش م م",
"L_NM": "Mutiara sarl",
"Last Subscription": "8-Jun-17",
"Industrial certificate no": "2750",
"Industrial certificate date": "26-Oct-17",
"ACTIVITY": "صياغة المجوهرات وتركيب الاحجار الكريمة",
"Activity-L": "Manufacture of jewelry & precious stones",
"ADRESS": "بناية موتيارا ط ارضي\u001c - حي شاليه سويس\u001c - الجديدة - المتن",
"TEL1": "01/900601",
"TEL2": "03/731773",
"TEL3": "",
"internet": "mutiara@sodetel.net.lb"
},
{
"Category": "Fourth",
"Number": "20963",
"com-reg-no": "2015750",
"NM": "بسترما هاوس لصناعة وتجارة اللحوم ش م م",
"L_NM": "Basterma House sarl",
"Last Subscription": "22-Feb-18",
"Industrial certificate no": "3751",
"Industrial certificate date": "3-Apr-18",
"ACTIVITY": "صناعة محضرات غذائية من اللحوم (بسترما ، سجق ومقانق )",
"Activity-L": "Production of meat ( Basterma,sauages & pates)",
"ADRESS": "بناية حلو ط ارضي\u001c - المنطقة الصناعية - شارع براد اليوناني\u001c - البوشرية - المتن",
"TEL1": "01/261439",
"TEL2": "03/355693",
"TEL3": "01/250827",
"internet": ""
},
{
"Category": "Fourth",
"Number": "24496",
"com-reg-no": "2004718",
"NM": "Transorient Services",
"L_NM": "Transorient Services",
"Last Subscription": "12-Apr-17",
"Industrial certificate no": "4517",
"Industrial certificate date": "22-Aug-18",
"ACTIVITY": "طحن وتوضيب الزعتر والبهارات",
"Activity-L": "Grinding & packing of thyme & spices",
"ADRESS": "بناية رزق الله ط ارضي\u001c - شارع بيدر الشوار\u001c - بيت شباب - المتن",
"TEL1": "04/981203",
"TEL2": "03/206838",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "22719",
"com-reg-no": "2025827",
"NM": "ارميكو للصناعة والتجارة ش م م",
"L_NM": "Armico Industry and Commerce L.L.C",
"Last Subscription": "28-Jan-17",
"Industrial certificate no": "4345",
"Industrial certificate date": "20-Jul-18",
"ACTIVITY": "معملا للالات الصناعية والبناء",
"Activity-L": " Factory for Indusrial & construction machinery",
"ADRESS": "بناية ميسيريان\u001c - نهر الموت - الطريق العام\u001c - الجديدة - المتن",
"TEL1": "01/885279",
"TEL2": "01/877727",
"TEL3": "",
"internet": "armico@cyberia.net.lb"
},
{
"Category": "Fourth",
"Number": "20804",
"com-reg-no": "2027724",
"NM": "Styro Design sarl",
"L_NM": "Styro Design sarl",
"Last Subscription": "17-Feb-18",
"Industrial certificate no": "4820",
"Industrial certificate date": "30-May-16",
"ACTIVITY": "اعمال الديكور",
"Activity-L": "Decoration services",
"ADRESS": "بناية عقيقي\u001c - الشارع العام\u001c - حارة صخر - كسروان",
"TEL1": "09/645146",
"TEL2": "03/393235",
"TEL3": "",
"internet": "info@styrodesign-lb.com"
},
{
"Category": "Second",
"Number": "6831",
"com-reg-no": "2020498",
"NM": "شركة فومكس ش م ل",
"L_NM": "Foamex sal",
"Last Subscription": "1-Feb-18",
"Industrial certificate no": "305",
"Industrial certificate date": "31-Jan-19",
"ACTIVITY": "تجارة عامة",
"Activity-L": "General Trading",
"ADRESS": "بناية سليب كومفورت\u001c - الكرنتينا - شارع الرهبان\u001c - برج حمود - المتن",
"TEL1": "01/444444",
"TEL2": "",
"TEL3": "",
"internet": "admin@sleepcomfort.com"
},
{
"Category": "Second",
"Number": "6022",
"com-reg-no": "2016911",
"NM": "كونسبت كرييشن ش م ل",
"L_NM": "Concept Creation sal",
"Last Subscription": "18-Jul-17",
"Industrial certificate no": "4155",
"Industrial certificate date": "7-May-18",
"ACTIVITY": "تجارة جملة الواح زجاج، سيكوريت والمرايا",
"Activity-L": "Wholesale of glass flat, securite & mirrors",
"ADRESS": "بناية الحلال\u001c - شارع الغزال\u001c - المكلس - المتن",
"TEL1": "01/694138",
"TEL2": "01/694139",
"TEL3": "",
"internet": "conceptcreation.lb@gmail.com"
},
{
"Category": "Fourth",
"Number": "24077",
"com-reg-no": "2017743",
"NM": "دار صبح للطباعة والنشر والتوزيع ش م م",
"L_NM": "Dar Soboh for printing,Publishing Distributing. Sarl",
"Last Subscription": "29-Jun-17",
"Industrial certificate no": "4148",
"Industrial certificate date": "15-Jun-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "بناية حمدان\u001c -  الكفاءات - شارع الليسيه بيلوت\u001c - الحدث - بعبدا",
"TEL1": "05/466249",
"TEL2": "03/719441",
"TEL3": "",
"internet": "darsoboh@hotmail.com"
},
{
"Category": "Fourth",
"Number": "28499",
"com-reg-no": "2026841",
"NM": "HiXp sarl",
"L_NM": "HiXp sarl",
"Last Subscription": "22-Mar-18",
"Industrial certificate no": "4395",
"Industrial certificate date": "30-Mar-18",
"ACTIVITY": "صناعة الشامبو والعطور ومستحضرات التجميل",
"Activity-L": "Manufacture of shampoo, perfumes & cosmetics",
"ADRESS": "ملك وقف دروز المتين\u001c - الشارع الداخلي\u001c - المتين - المتن",
"TEL1": "04/295595",
"TEL2": "03/146978",
"TEL3": "03/333225",
"internet": "info@hi-xp.com"
},
{
"Category": "First",
"Number": "5349",
"com-reg-no": "2008401",
"NM": "ياسين غروب ش م ل",
"L_NM": "Yassine Group sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4259",
"Industrial certificate date": "7-Jul-18",
"ACTIVITY": "نشر وتفصيل الواح خشبية مضغوطة",
"Activity-L": "Sawmilling  of wood",
"ADRESS": "ملك ياسين\u001c - القبه - الشارع العام\u001c - الشويفات - عاليه",
"TEL1": "05/430666",
"TEL2": "03/399446",
"TEL3": "03/646704",
"internet": "dina@yassinegroup.com"
},
{
"Category": "Third",
"Number": "32184",
"com-reg-no": "2026789",
"NM": "امفر كوتنغز ش م م",
"L_NM": "Emver Coatings sarl",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "3336",
"Industrial certificate date": "8-Feb-18",
"ACTIVITY": "تجارة الدهانات",
"Activity-L": "Trading of paints",
"ADRESS": "ملك رعيدي\u001c - المدينة الصناعية\u001c - حصرايل - جبيل",
"TEL1": "09/791230",
"TEL2": "76/602062",
"TEL3": "",
"internet": "s.simon@enveroatings.com"
},
{
"Category": "Third",
"Number": "28954",
"com-reg-no": "2017166",
"NM": "بيضون لصناعة الاحذية ش م م",
"L_NM": "Beydoun for The Shoe Industry sarl",
"Last Subscription": "24-Feb-18",
"Industrial certificate no": "405",
"Industrial certificate date": "19-Feb-19",
"ACTIVITY": "صناعة الاحذية الرجالية, النسائية والولادية",
"Activity-L": "Manufacture of men\'s, ladies\' and children\'s clothes",
"ADRESS": "بناية الفرح\u001c - طريق المطار\u001c - برج البراجنة - بعبدا",
"TEL1": "01/451451",
"TEL2": "01/451051",
"TEL3": "03/322303",
"internet": "beydounshoes@gmail.com"
},
{
"Category": "First",
"Number": "5059",
"com-reg-no": "58821",
"NM": "ايتامكو ش م ل",
"L_NM": "Etamco sal",
"Last Subscription": "5-Feb-18",
"Industrial certificate no": "4808",
"Industrial certificate date": "30-Oct-18",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك يونس وشقير\u001c - حي الغصون - الشارع العام\u001c - المنصورية - المتن",
"TEL1": "04/530430",
"TEL2": "03/606151",
"TEL3": "03/606152",
"internet": "admin@etamco.com"
},
{
"Category": "Fourth",
"Number": "24256",
"com-reg-no": "55881",
"NM": "شركة يبريم للمجوهرات ش م م",
"L_NM": "Yeprem Jewellery sarl",
"Last Subscription": "16-Feb-18",
"Industrial certificate no": "3925",
"Industrial certificate date": "5-May-18",
"ACTIVITY": "معملاً للمصوغات وتركيب الاحجار الكريمة عليها",
"Activity-L": "Manufacture of jewelry & assorting precious stones",
"ADRESS": "بناية شخردميان ط اول\u001c - حي مرعش - شارع ميموزا\u001c - برج حمود - المتن",
"TEL1": "01/261958",
"TEL2": "01/265566",
"TEL3": "03/305262",
"internet": "yeprem@yepremjewellery.com"
},
{
"Category": "Third",
"Number": "29079",
"com-reg-no": "2017135",
"NM": "شركة القيسي ش م م",
"L_NM": "El Kaissi Company sarl",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "4131",
"Industrial certificate date": "13-Jun-18",
"ACTIVITY": "صناعة الشوكولا والسكاكر والملبن",
"Activity-L": "Manufacture of chocolate & candies",
"ADRESS": "ملك محمود القيسي\u001c - المنطقة الصناعية\u001c - جدرا - الشوف",
"TEL1": "07/922224",
"TEL2": "07/922225",
"TEL3": "03/098131",
"internet": "info@elkaissico.com"
},
{
"Category": "Third",
"Number": "30878",
"com-reg-no": "2028637",
"NM": "كوزمادور فور كوزماتيك للتجارة العامة والصناعة ش م م",
"L_NM": "Cosma D\'or Cosmetics for General Trading and Industry sarl",
"Last Subscription": "31-Oct-17",
"Industrial certificate no": "4637",
"Industrial certificate date": "20-Sep-18",
"ACTIVITY": "صناعة مستحضرات مواد تجميلية",
"Activity-L": "Manufacture of cosmetic products",
"ADRESS": "بناية حمدان ط سفلي\u001c - حي العمروسية - شارع الضيقة\u001c - الشويفات - عاليه",
"TEL1": "05/431898",
"TEL2": "76/781701",
"TEL3": "03/287298",
"internet": "h.ghamloush@cosmador.com"
},
{
"Category": "Fourth",
"Number": "20843",
"com-reg-no": "2003635",
"NM": "شركة اتنتو وشركاه - توصية بسيطة",
"L_NM": "Societe Attento & Co.",
"Last Subscription": "1-Jun-17",
"Industrial certificate no": "2886",
"Industrial certificate date": "23-Nov-17",
"ACTIVITY": "معملاً للمصوغات وتركيب الاحجار الكريمة عليها",
"Activity-L": "Factory of jewelry & assorting of precious stones",
"ADRESS": "ملك كريكور اوزقوشيان\u001c - شارع طرابلس\u001c - برج حمود - المتن",
"TEL1": "03/666541",
"TEL2": "01/255954",
"TEL3": "03/345728",
"internet": ""
},
{
"Category": "Fourth",
"Number": "22500",
"com-reg-no": "2004745",
"NM": "باتسري لون دوميال  ش م م",
"L_NM": "Patisserie Lune De Miel sarl",
"Last Subscription": "23-Feb-18",
"Industrial certificate no": "5314",
"Industrial certificate date": "2-Mar-18",
"ACTIVITY": "تجارة الحلويات الافرنجية وصناعة الشوكولا",
"Activity-L": "Trading of sweets& manufacture of chocolate",
"ADRESS": "ملك ناصيف\u001c - الشارع العام\u001c - الحدث - بعبدا",
"TEL1": "05/452000+05",
"TEL2": "05/452121",
"TEL3": "03/268827",
"internet": ""
},
{
"Category": "Fourth",
"Number": "22506",
"com-reg-no": "2028109",
"NM": "بلاط شعيا",
"L_NM": "Blatt Chaya",
"Last Subscription": "23-Jan-18",
"Industrial certificate no": "4864",
"Industrial certificate date": "13-Nov-18",
"ACTIVITY": "صب بلاط الموزاييك",
"Activity-L": "Forging of  mosaic  tiles",
"ADRESS": "ملك شركة مكانك\u001c - شارع الفندقية\u001c - الدكوانة - المتن",
"TEL1": "01/695222",
"TEL2": "03/323900",
"TEL3": "",
"internet": "info@blattchaya.com"
},
{
"Category": "Fourth",
"Number": "20844",
"com-reg-no": "53259",
"NM": "شركة نعمة الله منعم واولاده لتصنيع الحجر والرخام- تضامن",
"L_NM": "Nemtallah Menem and Sons Company",
"Last Subscription": "4-Apr-17",
"Industrial certificate no": "3698",
"Industrial certificate date": "27-Mar-18",
"ACTIVITY": "معملا لنشر وتفصيل الصخور والرخام",
"Activity-L": "Sawing and Shaping of Rocks and Marbles",
"ADRESS": "ملك منعم\u001c - المدينة الصناعية\u001c - مزرعة يشوع - المتن",
"TEL1": "03/335141",
"TEL2": "03/372926",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "5081",
"com-reg-no": "2020937",
"NM": "شركة مياه ترشيش ش م ل",
"L_NM": "Ste Des Eaux De Tarshish sal",
"Last Subscription": "18-Oct-17",
"Industrial certificate no": "4742",
"Industrial certificate date": "17-Oct-18",
"ACTIVITY": "تعبئة المياه الطبيعية والمعدنية",
"Activity-L": "Bottling of natural & mineral water",
"ADRESS": "بناية La Merveille ط اول\u001c - حرش تابت\u001c - سن الفيل - المتن",
"TEL1": "03/044427",
"TEL2": "04/928605",
"TEL3": "",
"internet": "info@talayawater.com"
},
{
"Category": "Fourth",
"Number": "24183",
"com-reg-no": "1013832",
"NM": "شركة ايزو فود ش م ل",
"L_NM": "Iso Food sal",
"Last Subscription": "15-Jan-18",
"Industrial certificate no": "4496",
"Industrial certificate date": "16-Aug-18",
"ACTIVITY": "صناعة المايونيز",
"Activity-L": "Manufacture of mayonnaise",
"ADRESS": "بناية سلهب\u001c - شارع شوران\u001c - الروشة - بيروت",
"TEL1": "05/814837",
"TEL2": "",
"TEL3": "",
"internet": "info@isofood.net"
},
{
"Category": "Fourth",
"Number": "24158",
"com-reg-no": "28505",
"NM": "غولدن كي ش م ل",
"L_NM": "Golden Key sal",
"Last Subscription": "20-Jan-18",
"Industrial certificate no": "3639",
"Industrial certificate date": "18-Mar-18",
"ACTIVITY": "معملا لتركيب الاحجار الكريمة على المجوهرات",
"Activity-L": "Manufacture of precious stones",
"ADRESS": "بناية اللاهوريان ط 2\u001c - شارع ارمينيا\u001c - برج حمود - المتن",
"TEL1": "01/262950",
"TEL2": "03/787570",
"TEL3": "",
"internet": "elivagioielli@hotmail.com"
},
{
"Category": "Third",
"Number": "30859",
"com-reg-no": "71687",
"NM": "شركة لو رستو ش م م",
"L_NM": "Le Resto sarl",
"Last Subscription": "24-Feb-18",
"Industrial certificate no": "427",
"Industrial certificate date": "22-Feb-19",
"ACTIVITY": "سناك",
"Activity-L": "Snack",
"ADRESS": "بناية غرابي والخوري\u001c - حي مار روكز\u001c - الحازمية - بعبدا",
"TEL1": "05/953056",
"TEL2": "05/954056",
"TEL3": "",
"internet": "info@sofiresto.com"
},
{
"Category": "Third",
"Number": "30811",
"com-reg-no": "53683",
"NM": "شركة حبو للصناعة والتجارة ـ تضامن",
"L_NM": "Hebbo For Industry & Trade",
"Last Subscription": "11-Oct-17",
"Industrial certificate no": "4575",
"Industrial certificate date": "6-Sep-18",
"ACTIVITY": "معملا لنشر الصخور والرخام، صب احجار الباطون ومصبوبات اسمنتية",
"Activity-L": "Sawing of rock & marble, manufacture of concrete products for construction",
"ADRESS": "ملك حبو\u001c - المدينة الصناعية\u001c - مزرعة يشوع - المتن",
"TEL1": "04/921744",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "28947",
"com-reg-no": "2027307",
"NM": "شركة برادو للتجارة والصناعة ش م م",
"L_NM": "Prado of Commerce and Industry sarl",
"Last Subscription": "26-Mar-18",
"Industrial certificate no": "3753",
"Industrial certificate date": "3-Apr-18",
"ACTIVITY": "صناعة الشوكولا",
"Activity-L": "Manufacture of Chocolate",
"ADRESS": "ملك ابو فخر ط سفلي\u001c - القبة - شارع ابو فخر\u001c - الشويفات - عاليه",
"TEL1": "05/430492",
"TEL2": "71/310859",
"TEL3": "",
"internet": "choco.prado@hotmail.com"
},
{
"Category": "Third",
"Number": "30757",
"com-reg-no": "2014198",
"NM": "شركة بتفورم ش م م",
"L_NM": "Petform sarl",
"Last Subscription": "21-Jan-17",
"Industrial certificate no": "3152",
"Industrial certificate date": "17-Jan-18",
"ACTIVITY": "صناعة السلع البلاستيكية",
"Activity-L": "Manufacture of plastic products",
"ADRESS": "ملك منى فؤاد يمين\u001c - المدينة الصناعية\u001c - مزرعة يشوع - المتن",
"TEL1": "04/915046",
"TEL2": "03/536777",
"TEL3": "",
"internet": "info@petform-lb.com"
},
{
"Category": "Third",
"Number": "28868",
"com-reg-no": "2024982",
"NM": "شركة وود ورلد للمقاولات ش م م",
"L_NM": "Wood World for Contracting sarl",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "3728",
"Industrial certificate date": "30-Mar-18",
"ACTIVITY": "معملا للمفروشات والمنجورات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "بناية ضو\u001c - الشارع العام\u001c - المكلس - المتن",
"TEL1": "01/683884",
"TEL2": "03/662239",
"TEL3": "",
"internet": "woodworld.lb@gmail.com"
},
{
"Category": "Second",
"Number": "5904",
"com-reg-no": "2026426",
"NM": "التجارة والسياحة العادلة في لبنان ش م ل",
"L_NM": "Fair Trade and Tourism Lebanon sal",
"Last Subscription": "15-Feb-18",
"Industrial certificate no": "2790",
"Industrial certificate date": "6-Mar-18",
"ACTIVITY": "معملا للمربيات والمخلللات والحمص وبابا غنوج وتعبئة المواد الغذائية",
"Activity-L": "Manufacture of jam, pickles,homos baba ghanouj & packing of foodstuffs",
"ADRESS": "سنتر حوراني ط 2\u001c - شارع مار الياس\u001c - الحازمية - بعبدا",
"TEL1": "05/952153",
"TEL2": "03/208443",
"TEL3": "",
"internet": "padaime@fairtradelebanon.org"
},
{
"Category": "First",
"Number": "5052",
"com-reg-no": "2022511",
"NM": "سليمان مقصود",
"L_NM": "Sleiman Maksoud",
"Last Subscription": "28-Mar-17",
"Industrial certificate no": "2508",
"Industrial certificate date": "1-Sep-17",
"ACTIVITY": "معملا لصب احجار الباطون",
"Activity-L": "Manufacture of concrete stones",
"ADRESS": "ملك الرهبانية اللبنانية المارونية\u001c - الشارع العام\u001c - مار موسى - المتن",
"TEL1": "03/300410",
"TEL2": "76/300410",
"TEL3": "",
"internet": "sleimanmaksoud@hotmail.com"
},
{
"Category": "Third",
"Number": "28917",
"com-reg-no": "2027052",
"NM": "عيتاني تويست تاي ش م م",
"L_NM": "Itani Twist Tie sarl",
"Last Subscription": "8-Mar-17",
"Industrial certificate no": "2017",
"Industrial certificate date": "6-Jun-17",
"ACTIVITY": "صناعة الشريط المعدني (لزوم استعمال ربطات الخبز )",
"Activity-L": "Manufacture of metallic wire",
"ADRESS": "بناية بعجور\u001c - حي بعجور\u001c - حارة حريك - بعبدا",
"TEL1": "01/559691",
"TEL2": "03/219754",
"TEL3": "",
"internet": "issam@itanitwisttie.com"
},
{
"Category": "Second",
"Number": "5882",
"com-reg-no": "2023561",
"NM": "الومنيوم ديزاين ش م ل",
"L_NM": "Alu Design sal",
"Last Subscription": "30-Jan-18",
"Industrial certificate no": "3117",
"Industrial certificate date": "12-Jan-18",
"ACTIVITY": "صناعة المنجورات المعدنية",
"Activity-L": "Manufacture of metallic panelling",
"ADRESS": "ملك محمد يحيى شومان\u001c - حي الاميركان - مقابل المجلس الدستوري\u001c - الحدث - بعبدا",
"TEL1": "05/470040",
"TEL2": "03/811921",
"TEL3": "",
"internet": "info@aludesign.com.lb"
},
{
"Category": "First",
"Number": "4963",
"com-reg-no": "47732",
"NM": "ب س ل ش م ل",
"L_NM": "B C L sal",
"Last Subscription": "8-Aug-17",
"Industrial certificate no": "4429",
"Industrial certificate date": "4-Aug-18",
"ACTIVITY": "صناعة الباطون الجاهز",
"Activity-L": "Manufacture of ready - mixed concrete",
"ADRESS": "ملك معلوف\u001c - المدينة الصناعية - جسر الباشا\u001c - المكلس - المتن",
"TEL1": "01/692831+2",
"TEL2": "01/692833",
"TEL3": "03/611050",
"internet": "info@bclsal.net"
},
{
"Category": "Excellent",
"Number": "1692",
"com-reg-no": "2026421",
"NM": "البان مزارع تعنايل ش م ل",
"L_NM": "Taanayel Dairy Farms co.sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4150",
"Industrial certificate date": "16-Jun-18",
"ACTIVITY": "صناعة الالبان والاجبان والبوظة",
"Activity-L": "Manufacture of dairy products & icecream",
"ADRESS": "ملك شركة عصير الفاكهة اللبنانية\u001c - حي الانوار - شارع ابو حلقة\u001c - الفنار - المتن",
"TEL1": "01/891200",
"TEL2": "01/900746",
"TEL3": "",
"internet": "info@taanayel-lesfermes.com"
},
{
"Category": "Second",
"Number": "5868",
"com-reg-no": "2024980",
"NM": "انكو غروب ش م ل",
"L_NM": "Encogroup sal",
"Last Subscription": "26-Jan-18",
"Industrial certificate no": "3015",
"Industrial certificate date": "1-Dec-18",
"ACTIVITY": "اعمال المقاولات وتنفيذ تعهدات الهندسة الكهربائية والميكانيكية",
"Activity-L": "Electrical & Mechanical Engineering Contracting",
"ADRESS": "ملك دير مار الياس الراس جعيتا\u001c - حي السنديانة الاوتوستراد\u001c - زوق مكايل - كسروان",
"TEL1": "09/218148",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "21829",
"com-reg-no": "2015115",
"NM": "جانو فودز",
"L_NM": "Jeano\'s Foods",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "4619",
"Industrial certificate date": "19-Sep-18",
"ACTIVITY": "معملا لصناعة وتوضيب المعجنات والمأكولات",
"Activity-L": "Manufacturing and packing of pastries and foods",
"ADRESS": "بناية مارقاريان\u001c - شارع اراكس\u001c - برج حمود - المتن",
"TEL1": "03/373572",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "28844",
"com-reg-no": "2023539",
"NM": "العالمية للطباعة والتجليد والتجارة ش م م",
"L_NM": "The International Co For Printing,Binding & Trading sarl",
"Last Subscription": "8-Feb-17",
"Industrial certificate no": "2480",
"Industrial certificate date": "27-Aug-17",
"ACTIVITY": "تغليف وتجليد الكتب",
"Activity-L": "Bookbinding & finishing",
"ADRESS": "ملك فواز\u001c - العمروسية\u001c - الشويفات - عاليه",
"TEL1": "05/488355",
"TEL2": "05/488344",
"TEL3": "03/684066",
"internet": "mondial-79@hotmail.com"
},
{
"Category": "Second",
"Number": "5766",
"com-reg-no": "2019362",
"NM": "انيتكس ش م ل",
"L_NM": "Anitex sal",
"Last Subscription": "25-Jan-18",
"Industrial certificate no": "075",
"Industrial certificate date": "21-Dec-18",
"ACTIVITY": "خياطة الالبسة الولادية والرجالية",
"Activity-L": "Manufacture of clothing for children & men",
"ADRESS": "بناية آرا يروانيان ط2\u001c - اوتوستراد الدوره\u001c - برج حمود - المتن",
"TEL1": "01/262728",
"TEL2": "01/264720",
"TEL3": "03/791844",
"internet": "info@anitexfashion.com"
},
{
"Category": "Second",
"Number": "6473",
"com-reg-no": "1017237",
"NM": "اسيمة غراوي ش م ل",
"L_NM": "Oussayma Ghrawi sal",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "2637",
"Industrial certificate date": "18-Mar-18",
"ACTIVITY": "صناعة شوكولا وسكاكر",
"Activity-L": "Manufacture  of chocolate & candies",
"ADRESS": "ملك اللادقي\u001c - طلعت شحاده - شارع الشيخ عباس\u001c - المصيطبة - بيروت",
"TEL1": "01/788501",
"TEL2": "01/788481",
"TEL3": "03/359095",
"internet": "oussaimaghrawi@gmail.com"
},
{
"Category": "Fourth",
"Number": "22224",
"com-reg-no": "2024904",
"NM": "F B M Trading",
"L_NM": "F B M Trading",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4351",
"Industrial certificate date": "22-Jul-18",
"ACTIVITY": "معمل للخراطة الميكانيكية وصناعة جبالات الباطون",
"Activity-L": "Manufacture of turnery, concrete mixers machinery",
"ADRESS": "ملك ابقريان\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "03/821132",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "30680",
"com-reg-no": "2025687",
"NM": "ماكمان ش م م",
"L_NM": "Macman sarl",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4616",
"Industrial certificate date": "18-Sep-18",
"ACTIVITY": "صناعة البويا على انواعها",
"Activity-L": "Manufacture of paint",
"ADRESS": "ملك الشدياق\u001c - نهر الموت - منطقة الكسارات\u001c - الجديدة - المتن",
"TEL1": "01/878270",
"TEL2": "03/293970",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "5805",
"com-reg-no": "2007769",
"NM": "ابراهيم الملاح واولاده ش م ل",
"L_NM": "Ibrahim Mallah Et Fils sal - IMF",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "3672",
"Industrial certificate date": "22-Mar-18",
"ACTIVITY": "معملا لنشر البلاط الصخري والرخامي",
"Activity-L": "Cutting of tiles",
"ADRESS": "ملك وقف القديس انطونيوس والقديسين سركيس وباخوس\u001c - نهر الموت\u001c - الجديدة - المتن",
"TEL1": "01/891699",
"TEL2": "01/891818",
"TEL3": "",
"internet": "mallah@cyberia.net.lb"
},
{
"Category": "Fourth",
"Number": "25613",
"com-reg-no": "2024487",
"NM": "ميروبول انترناسيونال ليمتد",
"L_NM": "Miropol International limited",
"Last Subscription": "20-Jan-18",
"Industrial certificate no": "195",
"Industrial certificate date": "15-Jan-19",
"ACTIVITY": "صناعة المجوهرات",
"Activity-L": "manufacture of jewelry",
"ADRESS": "بناية شلهوب ملك ريمون اسمر ط ارضي\u001c - الشارع العام\u001c - الدكوانة - المتن",
"TEL1": "01/491102",
"TEL2": "03/961901",
"TEL3": "",
"internet": "pasmar@miropol.com"
},
{
"Category": "Third",
"Number": "30626",
"com-reg-no": "2021445",
"NM": "هارون للطباعة ش م م",
"L_NM": "Haroun Printing sarl",
"Last Subscription": "4-Jul-17",
"Industrial certificate no": "20430",
"Industrial certificate date": "11-Jun-17",
"ACTIVITY": "تجارة الكتب والمطبوعات",
"Activity-L": "Trading of books & publications",
"ADRESS": "بناية بلكسي جمال ط2\u001c - الشارع العام\u001c - رومية - المتن",
"TEL1": "01/898745+6",
"TEL2": "03/776884",
"TEL3": "",
"internet": "harounprinting@hotmail.com"
},
{
"Category": "Second",
"Number": "5689",
"com-reg-no": "1013568",
"NM": "شركة فردوس لبنان الجنوبي ش م ل",
"L_NM": "Paradise of South Lebanon sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "2165",
"Industrial certificate date": "10-Feb-18",
"ACTIVITY": "صناعى وتجارة مواد بناء والبلاط",
"Activity-L": "Manufacture & Trading of building materials & tiles",
"ADRESS": "بناية الرينغ\u001c - شارع فؤاد شهاب\u001c - الصيفي - بيروت",
"TEL1": "01/999771",
"TEL2": "01/999772",
"TEL3": "",
"internet": "shuman_group@hotmail.com"
},
{
"Category": "Third",
"Number": "30603",
"com-reg-no": "2015960",
"NM": "جي اند بي ستيل وورك ش م م",
"L_NM": "J & P Steel Work sarl",
"Last Subscription": "8-Nov-17",
"Industrial certificate no": "1506",
"Industrial certificate date": "15-Jun-16",
"ACTIVITY": "تجارة صفائح معدنية وقضبان حديد",
"Activity-L": "Trading of metal sheets & iron bars",
"ADRESS": "ملك فاهي وانس تشابريان\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/488400",
"TEL2": "03/959481",
"TEL3": "",
"internet": "j.p_sarl@hotmail.com"
},
{
"Category": "Second",
"Number": "5687",
"com-reg-no": "2024411",
"NM": "شركة غراوي غروب للشوكولا والسكاكر ش م ل",
"L_NM": "Ghrawi Group for Chocolates & Sweets Co. sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4567",
"Industrial certificate date": "5-Sep-18",
"ACTIVITY": "صناعة السكاكر والشوكولا",
"Activity-L": "Manufacture of candies and chocolate",
"ADRESS": "بناية علايلي وغراوي\u001c - شارع فيلمون وهبه\u001c - كفرشيما - بعبدا",
"TEL1": "05/432122",
"TEL2": "",
"TEL3": "",
"internet": "info@ghrawi.com"
},
{
"Category": "Third",
"Number": "30569",
"com-reg-no": "2024133",
"NM": "سـاينز انـد بيـونـد ش م م",
"L_NM": "Signs & Beyond sarl",
"Last Subscription": "26-Jan-18",
"Industrial certificate no": "178",
"Industrial certificate date": "11-Jan-19",
"ACTIVITY": "تجارة وتركيب ارمات",
"Activity-L": "Trading and installation of nameplates",
"ADRESS": "ملك بسام ووسام زياده\u001c - المدينة الصناعية\u001c - بصاليم - المتن",
"TEL1": "03/307023",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "28712",
"com-reg-no": "2015758",
"NM": "يارا بلاست ش م م",
"L_NM": "Yara Plaste sarl",
"Last Subscription": "25-Apr-17",
"Industrial certificate no": "3876",
"Industrial certificate date": "25-Apr-18",
"ACTIVITY": "تصنيع اكياس بلاستيك وسلوفان والطباعة عليها",
"Activity-L": "Manufacture of plastic bags , cellophane & printing it",
"ADRESS": "ملك وليد سلامة وشركاه\u001c - المعروفية - الشارع العام\u001c - عين عنوب - عاليه",
"TEL1": "05/435426",
"TEL2": "03/674259",
"TEL3": "",
"internet": "yaraplast@hotmail.com"
},
{
"Category": "Third",
"Number": "30669",
"com-reg-no": "2025451",
"NM": "فرحات لمعدات المخابز ش م م",
"L_NM": "Farhat Bakery Equipment Ltd. Co",
"Last Subscription": "1-Feb-17",
"Industrial certificate no": "4201",
"Industrial certificate date": "28-Jun-18",
"ACTIVITY": "صناعة الافران الاليه (رقاقات، قطاعات وعجانات)",
"Activity-L": "Manufacture of automatic bakery equipments ( rough…)",
"ADRESS": "ملك الريشاني\u001c - العمروسية - طريق صيدا القديمة\u001c - الشويفات - عاليه",
"TEL1": "05/441607",
"TEL2": "03/527111",
"TEL3": "70/527111",
"internet": ""
},
{
"Category": "First",
"Number": "5028",
"com-reg-no": "2010817",
"NM": "سالتك ش م ل",
"L_NM": "Saltek sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "259",
"Industrial certificate date": "8-Feb-19",
"ACTIVITY": "صناعة المخابز الالية ولوازم الافران",
"Activity-L": "Manufacture of bakeries & its equipments",
"ADRESS": "ملك الشركة\u001c - المدينة الصناعية\u001c - مزرعة يشوع - المتن",
"TEL1": "04/925111",
"TEL2": "04/926222",
"TEL3": "03/186920",
"internet": "saltek@saltek.com.lb"
},
{
"Category": "Second",
"Number": "5815",
"com-reg-no": "2018787",
"NM": "داغر غروب ش م ل",
"L_NM": "Dagher Group sal",
"Last Subscription": "29-Mar-17",
"Industrial certificate no": "2852",
"Industrial certificate date": "17-Jan-15",
"ACTIVITY": "تجارة حلويات عربية وافرنجية",
"Activity-L": "Trading of oriental & western sweets",
"ADRESS": "بناية داغر\u001c - الشارع العام\u001c - البوشرية - المتن",
"TEL1": "03/810346",
"TEL2": "01/696346",
"TEL3": "",
"internet": "elie@daghergroup.net"
},
{
"Category": "Third",
"Number": "28772",
"com-reg-no": "2023080",
"NM": "انباك للتجارة والصناعة ش م م",
"L_NM": "Inpac Trading & Industry sarl - Inpac sarl",
"Last Subscription": "24-Feb-17",
"Industrial certificate no": "4472",
"Industrial certificate date": "11-Aug-18",
"ACTIVITY": "وتقطيع الورق وصناعة ال Labels /تجارة مطبوعات تجارية",
"Activity-L": "Cutting pf papers & LabelsTrading of commercial prints",
"ADRESS": "بناية الامين\u001c - الامراء - متفرع من شارع الفردوس\u001c - الشويفات - عاليه",
"TEL1": "05/484452",
"TEL2": "03/850825",
"TEL3": "",
"internet": "inpac@inpacliban.com"
},
{
"Category": "Fourth",
"Number": "26608",
"com-reg-no": "2034727",
"NM": "شركة ديفاين وود فاكتوري ش م م",
"L_NM": "Divine Wood Factory sarl",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4934",
"Industrial certificate date": "27-May-18",
"ACTIVITY": "تجارة المفروشات الخشبية",
"Activity-L": "Trading of wooden furniture",
"ADRESS": "بناية الحكيم\u001c - المنطقة الصناعية - شارع الكسارات\u001c - الفنار - المتن",
"TEL1": "01/892453",
"TEL2": "01/872347",
"TEL3": "70/084683",
"internet": "divinewood.co@hotmail.com"
},
{
"Category": "Second",
"Number": "6798",
"com-reg-no": "2011758",
"NM": "ايديال للصناعة ش م م",
"L_NM": "Ideal For Industry sarl",
"Last Subscription": "17-Jul-17",
"Industrial certificate no": "2204",
"Industrial certificate date": "8-Jan-17",
"ACTIVITY": "تجارة جملة الاواني المطبخية من فوم والمنيوم وبلاستيك",
"Activity-L": "Wholesale of kitchenware of foam, aluminium & plastic",
"ADRESS": "ملك سري الدين\u001c - القبة - الشارع العام\u001c - الشويفات - عاليه",
"TEL1": "05/430390",
"TEL2": "03/255748",
"TEL3": "",
"internet": "info@idealforindustry.com"
},
{
"Category": "Third",
"Number": "30552",
"com-reg-no": "2023980",
"NM": "شركة ج س بلاست ش م م",
"L_NM": "G S Plast sarl",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "2732",
"Industrial certificate date": "30-Mar-18",
"ACTIVITY": "معملا لانتاج افلام واكياس البوليريتين",
"Activity-L": "Manufacture of polytheline bags",
"ADRESS": "ملك العبد\u001c - شارع شركة الكهرباء\u001c - البوشرية - المتن",
"TEL1": "01/880603",
"TEL2": "01/880608",
"TEL3": "",
"internet": "info@gsplast.com"
},
{
"Category": "Third",
"Number": "30557",
"com-reg-no": "1013281",
"NM": "شركة تكغروب ش م م",
"L_NM": "Tecgroup Co sarl",
"Last Subscription": "23-Feb-17",
"Industrial certificate no": "3321",
"Industrial certificate date": "7-Feb-18",
"ACTIVITY": "صناعة المفروشات",
"Activity-L": "Manufacture of furniture",
"ADRESS": "بناية زين ملك تيا نصر الله\u001c - جادة شارل مالك\u001c - الرميل - بيروت",
"TEL1": "01/321399",
"TEL2": "01/321380",
"TEL3": "",
"internet": "roula.saber@tecgroupintl.com"
},
{
"Category": "Third",
"Number": "30541",
"com-reg-no": "2018160",
"NM": "انترني اتالياني ش م م",
"L_NM": "Interni Italiani sarl",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "1109",
"Industrial certificate date": "16-Feb-18",
"ACTIVITY": "صناعة المفروشات والمطابخ الخشبية والمعدنية",
"Activity-L": "Manufacture of wooden & metallic furnitures & kitchen",
"ADRESS": "ملك زغيب\u001c - حارة صخر\u001c - غزير - كسروان",
"TEL1": "09/934111",
"TEL2": "09/639677",
"TEL3": "03/127111",
"internet": "info@ag-contracting.com"
},
{
"Category": "Third",
"Number": "28686",
"com-reg-no": "77761",
"NM": "شركة خالد عبد الحفيظ السعدي واولاده - توصية بسيطة",
"L_NM": "Khaled Abdel Hafiz El Saadi & Sons Co",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "133",
"Industrial certificate date": "4-Jan-19",
"ACTIVITY": "خياطة الالبسة النسائية",
"Activity-L": "Manufacture of ladies\' clothes",
"ADRESS": "بناية البرج العاجي ط سفلي\u001c - شارع قمر - خلف تعاونية المصيطبة\u001c - المصيطبة - بيروت",
"TEL1": "01/301995",
"TEL2": "03/882051",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "5793",
"com-reg-no": "71300",
"NM": "افران الراهب - تضامن",
"L_NM": "Raheb Bakeries",
"Last Subscription": "6-Mar-17",
"Industrial certificate no": "3523",
"Industrial certificate date": "2-Mar-18",
"ACTIVITY": "فرن",
"Activity-L": "Bakery",
"ADRESS": "بناية الراهب\u001c - شارع الغزال\u001c - سن الفيل - المتن",
"TEL1": "01/494027",
"TEL2": "03/205070",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "28665",
"com-reg-no": "2004914",
"NM": "شركة فاتوريا ديل سول ش م م",
"L_NM": "Fattoria Del Sole Company sarl",
"Last Subscription": "11-Mar-17",
"Industrial certificate no": "127",
"Industrial certificate date": "22-Feb-17",
"ACTIVITY": "صناعة الالبان والاجبان",
"Activity-L": "Manufacture of dairy products",
"ADRESS": "بناية اركادا بلازا\u001c - ضهر الوحش - طريق الشام\u001c - عاريا - بعبدا",
"TEL1": "05/553519",
"TEL2": "03/662606",
"TEL3": "",
"internet": "fattoriadelsole@gmail.com"
},
{
"Category": "Second",
"Number": "5736",
"com-reg-no": "1001298",
"NM": "الشركة اللبنانية للحلويات ش م ل",
"L_NM": "Lebanese Sweets Company sal",
"Last Subscription": "31-May-17",
"Industrial certificate no": "2105",
"Industrial certificate date": "20-Jun-17",
"ACTIVITY": "صناعة الحلويات العربية والافرنجيه والبوظه",
"Activity-L": "Manufacture of sweets & glace",
"ADRESS": "بناية نوتردام\u001c - ساحة ساسين\u001c - الاشرفية - بيروت",
"TEL1": "01/202988",
"TEL2": "03/889989",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "28675",
"com-reg-no": "1007141",
"NM": "شركة عبيدو للتجارة والصناعة ش م م",
"L_NM": "Abido Company for Trade & Industry sarl",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4704",
"Industrial certificate date": "11-Oct-18",
"ACTIVITY": "طحن وتعبئة البهارات والارز وتعبئة وتوضيب الحبوب والنشويات",
"Activity-L": "Grinding and Packing of spices, rice,cereals and starches",
"ADRESS": "بناية الفاكهاني\u001c - شارع زريق\u001c - المزرعة - بيروت",
"TEL1": "01/654369",
"TEL2": "",
"TEL3": "",
"internet": "borak@abido.com"
},
{
"Category": "First",
"Number": "4889",
"com-reg-no": "1012573",
"NM": "برنتك ش م ل",
"L_NM": "Printech sal",
"Last Subscription": "1-Mar-18",
"Industrial certificate no": "2939",
"Industrial certificate date": "8-May-18",
"ACTIVITY": "صناعة اللوحات الاعلانية",
"Activity-L": "Maanufacture of nameplates",
"ADRESS": "اونيسكو تاور 2\u001c - شارع السفارة الروسية\u001c - الاونيسكو - بيروت",
"TEL1": "01/316999",
"TEL2": "01/318999",
"TEL3": "03/428700",
"internet": "info@printechlb.com"
},
{
"Category": "Excellent",
"Number": "1872",
"com-reg-no": "58622",
"NM": "محمصة الرفاعي ش م ل",
"L_NM": "Al Rifai Roastery sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "412",
"Industrial certificate date": "20-Feb-19",
"ACTIVITY": "محمصة",
"Activity-L": "Roastery",
"ADRESS": "ملك محمد رفاعي\u001c - كورنيش المزرعة\u001c - المزرعة - بيروت",
"TEL1": "01/702220",
"TEL2": "01/702221",
"TEL3": "",
"internet": "info@rifai.com"
},
{
"Category": "Second",
"Number": "5637",
"com-reg-no": "1010059",
"NM": "شركة طوني ورد - كوتور ش م ل",
"L_NM": "Tony Ward - Couture sal",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "4412",
"Industrial certificate date": "1-Aug-18",
"ACTIVITY": "تصميم الازياء ومعملا لخياطة الالبسة النسائية",
"Activity-L": "Fashion design & Manufacture of ladies\' clothes",
"ADRESS": "بناية حداد ط 1\u001c - الرميل - شارع بسترس\u001c - الاشرفية - بيروت",
"TEL1": "01/320833",
"TEL2": "03/547833",
"TEL3": "",
"internet": "info@tonyward.net"
},
{
"Category": "Third",
"Number": "28595",
"com-reg-no": "2009363",
"NM": "شركة ديا موركس كو - توصية بسيطة",
"L_NM": "Diamorex Co",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "3746",
"Industrial certificate date": "1-Apr-18",
"ACTIVITY": "صياغة المجوهرات وتركيب الاحجار الكريمة عليها",
"Activity-L": "Manufacture of Jewelry and precious stones",
"ADRESS": "ملك نرسيسيان\u001c - شارع الفرد تمرز - قرب بون جوس\u001c - الفنار - المتن",
"TEL1": "01/890951",
"TEL2": "03/882733",
"TEL3": "03/777868",
"internet": ""
},
{
"Category": "First",
"Number": "4777",
"com-reg-no": "2005240",
"NM": "اوتيري ش م ل - المكتب الفني للتصميمات الصناعية",
"L_NM": "Oteri sal Office Technique de Realisation Industrielles",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4764",
"Industrial certificate date": "23-Oct-18",
"ACTIVITY": "صناعة مواد كيماوية صناعية",
"Activity-L": "Manufacture of industrial chemical products",
"ADRESS": "ملك سمير عريف\u001c - الاوتوستراد\u001c - جل الديب - المتن",
"TEL1": "04/714390",
"TEL2": "04/714391",
"TEL3": "",
"internet": "info@oteri.com"
},
{
"Category": "Excellent",
"Number": "1421",
"com-reg-no": "2012511",
"NM": "نبيذ من لبنان ش م ل",
"L_NM": "Wines of lebanon sal",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "3010",
"Industrial certificate date": "16-May-18",
"ACTIVITY": "صناعة النبيذ والمشروبات الروحية",
"Activity-L": "Manufactureof wine & alcoholic drinks",
"ADRESS": "ملك دبانة\u001c -  حي الجسر - الاوتوستراد\u001c - زوق مكايل - كسروان",
"TEL1": "09/210023",
"TEL2": "03/923689",
"TEL3": "",
"internet": "info@ixsir.com.lb"
},
{
"Category": "Third",
"Number": "30833",
"com-reg-no": "62259",
"NM": "يعقوب حنا أسمر",
"L_NM": "Yaacoub Hanna Asmar",
"Last Subscription": "22-Feb-18",
"Industrial certificate no": "384",
"Industrial certificate date": "15-Feb-19",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "بناية حاتم رزق الله ط2\u001c - المدينة الصناعية - شارع الكهرباء\u001c - البوشرية - المتن",
"TEL1": "01/875514",
"TEL2": "03/610751",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "20621",
"com-reg-no": "2023514",
"NM": "المازة اللبنانية",
"L_NM": "Lebanese Mezze",
"Last Subscription": "22-Feb-18",
"Industrial certificate no": "4540",
"Industrial certificate date": "28-Aug-18",
"ACTIVITY": "صناعة معجون الحلويات والمأكولات الجاهزة",
"Activity-L": "Manufacture of ready-mixed for sweets & food",
"ADRESS": "ملك أديب خليل \u001c - شارع كنيسة سيدة المعونات\u001c - زوق مكايل - كسروان",
"TEL1": "09/213807",
"TEL2": "03/660369",
"TEL3": "",
"internet": "info@lebanesemezze.com"
},
{
"Category": "Excellent",
"Number": "1669",
"com-reg-no": "1012707",
"NM": "شركة صقال الصناعات ش م ل",
"L_NM": "Saccal Industries sal",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "3899",
"Industrial certificate date": "19-Feb-19",
"ACTIVITY": "تجميع المولدات الكهربائية وتنفيذ تعهدات الهندسة الميكانيكية",
"Activity-L": "Assembling of electrical generators / Mechanical engineering contracting",
"ADRESS": "سنتر الكونكورد\u001c - شارع رشيد كرامي\u001c - فردان - بيروت",
"TEL1": "01/348080",
"TEL2": "01/348081",
"TEL3": "",
"internet": "industries@saccal.com.lb"
},
{
"Category": "Second",
"Number": "5663",
"com-reg-no": "2023949",
"NM": "شركة فارمكو انترناشيونال ش م ل",
"L_NM": "Faremco International sal",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "4477",
"Industrial certificate date": "11-Aug-18",
"ACTIVITY": "صناعة وتجميع اللوحات الكهربائية والمولدات الكهربائية",
"Activity-L": "Manufacture of electrical boards and generators",
"ADRESS": "بناية فبرسيد\u001c - حارة الناعمة - المنطقة الصناعية\u001c - الناعمة - الشوف",
"TEL1": "05/601668",
"TEL2": "03/223230",
"TEL3": "",
"internet": "info@faremco-int.com"
},
{
"Category": "Second",
"Number": "5613",
"com-reg-no": "2021689",
"NM": "غرافيتي بروينغ ش م ل",
"L_NM": "Gravity Brewing sal",
"Last Subscription": "31-Jan-17",
"Industrial certificate no": "2605",
"Industrial certificate date": "24-Sep-17",
"ACTIVITY": "صناعة البيرة",
"Activity-L": "Manufacture of beer",
"ADRESS": "ملك سلوم الملاح\u001c - الشارع العام\u001c - مزرعة يشوع - المتن",
"TEL1": "04/916674",
"TEL2": "71/170101",
"TEL3": "03/967961",
"internet": "marounk@961beer.com"
},
{
"Category": "Excellent",
"Number": "1677",
"com-reg-no": "2007987",
"NM": "مخابز الحطب ش م ل",
"L_NM": "Wooden Bakery sal",
"Last Subscription": "20-Jan-18",
"Industrial certificate no": "4262",
"Industrial certificate date": "8-Jul-18",
"ACTIVITY": "فرن للخبز والمعجنات",
"Activity-L": "Bakery",
"ADRESS": "ملك بو حبيب\u001c - الاوتوستراد\u001c - الزلقا - المتن",
"TEL1": "04/410666",
"TEL2": "01/900411",
"TEL3": "04/715460",
"internet": "info@woodenbakery.com"
},
{
"Category": "Third",
"Number": "30509",
"com-reg-no": "2023919",
"NM": "محل سليم كميل بو سعيد",
"L_NM": "Selim Camille Bou Said Est",
"Last Subscription": "21-Mar-17",
"Industrial certificate no": "3627",
"Industrial certificate date": "16-Mar-18",
"ACTIVITY": "صناعة قطع وديكوارت من الجفصين",
"Activity-L": "Manufacture of plaster products",
"ADRESS": "ملك كميل بو سعيد\u001c - الشارع العام\u001c - شويت - بعبدا",
"TEL1": "03/511161",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "5662",
"com-reg-no": "2007648",
"NM": "فيلتراتيوبس ش م ل",
"L_NM": "Filtratubes sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "3941",
"Industrial certificate date": "8-May-18",
"ACTIVITY": "صناعة فلاتر السجائر",
"Activity-L": "Manufacture of cigarette filters",
"ADRESS": "بناية صلاح جبور والبير زينون ط3\u001c - شارع روفايل ابو جوده\u001c - وطى عمارة شلهوب-المتن",
"TEL1": "01/893713",
"TEL2": "01/893721",
"TEL3": "",
"internet": "fml@inco.com.lb"
},
{
"Category": "Third",
"Number": "28631",
"com-reg-no": "2014435",
"NM": "لافاندر ش م م",
"L_NM": "Lavender sarl",
"Last Subscription": "22-Mar-18",
"Industrial certificate no": "2964",
"Industrial certificate date": "12-May-18",
"ACTIVITY": "صناعة الكريمات والزيوت العطرية والشامبو",
"Activity-L": "Manufacture of cream,Perfume oil & Shampoo",
"ADRESS": "ملك زين الاتات\u001c - الشارع العام\u001c - الدبية - الشوف",
"TEL1": "01/825072",
"TEL2": "01/858785",
"TEL3": "03/935976",
"internet": "lavendersarl@hotmail.com"
},
{
"Category": "Third",
"Number": "32040",
"com-reg-no": "2005834",
"NM": "جوزف ديب صفير",
"L_NM": "Joseph Dib Sfeir",
"Last Subscription": "20-Jul-17",
"Industrial certificate no": "3796",
"Industrial certificate date": "10-Apr-18",
"ACTIVITY": "معملا لصب احجار الباطون وبلاط الارصفة",
"Activity-L": "Casting of concrete stones",
"ADRESS": "ملك جوزف صفير\u001c - وادي اده\u001c - اده - جبيل",
"TEL1": "03/216918",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "30768",
"com-reg-no": "2024086",
"NM": "International Trading Products Group sarl",
"L_NM": "International Trading Products Group sarl",
"Last Subscription": "12-Oct-17",
"Industrial certificate no": "4780",
"Industrial certificate date": "23-Apr-18",
"ACTIVITY": "تجارة البلاط",
"Activity-L": "Trading of tiles",
"ADRESS": "ملك مارغو عون\u001c - شارع ديارنا\u001c - زكريت - المتن",
"TEL1": "71/919186",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "21945",
"com-reg-no": "2026872",
"NM": "N J Wood",
"L_NM": "N J Wood",
"Last Subscription": "9-Jun-17",
"Industrial certificate no": "2376",
"Industrial certificate date": "8-Aug-17",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك مهى الحيوك\u001c - شارع نسيم البحر\u001c - خلدة - عاليه",
"TEL1": "05/806521",
"TEL2": "70/646563",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "5909",
"com-reg-no": "2018369",
"NM": "كونكريت بلاس ش م ل",
"L_NM": "Concrete Plus sal",
"Last Subscription": "16-Oct-17",
"Industrial certificate no": "3618",
"Industrial certificate date": "16-Mar-18",
"ACTIVITY": "صناعة الباطون الجاهز واحجارالباطون الفارغة والهوردي",
"Activity-L": "Manufacture of ready made concrete & stones",
"ADRESS": "ملك الشركة\u001c - الشارع العام\u001c - عمشيت - جبيل",
"TEL1": "09/622245",
"TEL2": "03/311008",
"TEL3": "",
"internet": "je@concretepluslb.com"
},
{
"Category": "First",
"Number": "5170",
"com-reg-no": "2033541",
"NM": "شركة اروان للصناعات الدوائية لبنان ش م ل",
"L_NM": "Arwan Pharmaceutical Industries Lebanon sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4166",
"Industrial certificate date": "20-Jun-18",
"ACTIVITY": "صناعة الادوية الطبية",
"Activity-L": "Manufacture of medicines",
"ADRESS": "ملك الشركة\u001c - شارع المصنع\u001c - جدرا - الشوف",
"TEL1": "07/996002",
"TEL2": "07/996003",
"TEL3": "",
"internet": "arw@arwanlb.com"
},
{
"Category": "Third",
"Number": "32012",
"com-reg-no": "2023120",
"NM": "جوزف وديع زغيب",
"L_NM": "Joseph Wadih Zoughaib",
"Last Subscription": "17-Jan-17",
"Industrial certificate no": "2992",
"Industrial certificate date": "15-Dec-17",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك جوزف زغيب\u001c - شارع جامعة L A U\u001c - مهرين - جبيل",
"TEL1": "09/946993",
"TEL2": "03/626081",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "28517",
"com-reg-no": "1012645",
"NM": "ساندرا منصور ش م م",
"L_NM": "Sandra Mansour sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "3715",
"Industrial certificate date": "28-Mar-18",
"ACTIVITY": "صناعة وتصميم الالبسة النسائية",
"Activity-L": " Manufacture and design of ladies\' clothes",
"ADRESS": "ملك وليد رحّال - طابق أرضي\u001c - شارع غورو - قرب المخفر\u001c - الجميزة - بيروت",
"TEL1": "01/444155",
"TEL2": "03/332601",
"TEL3": "",
"internet": "sandra@sandramansour.com"
},
{
"Category": "Third",
"Number": "32224",
"com-reg-no": "2033409",
"NM": "شركة س.ا.ن. لمواد التنظيف والتجميل  ش م م",
"L_NM": "S A N Household & Cosmetics sarl",
"Last Subscription": "22-Apr-17",
"Industrial certificate no": "3840",
"Industrial certificate date": "19-Apr-18",
"ACTIVITY": "معملا لمواد التنظيف والشامبو",
"Activity-L": "Factory for detergents & shampoo",
"ADRESS": "ملك جوستين صليبي\u001c - شارع الجامعة الكندية\u001c - عينطورة - كسروان",
"TEL1": "09/233750",
"TEL2": "03/282128",
"TEL3": "",
"internet": "cabinakhle@san-hc.com"
},
{
"Category": "Second",
"Number": "5393",
"com-reg-no": "2018475",
"NM": "شركة لي نوبل شوكولاتيه - ميزون دي شوكولا - ش م ل",
"L_NM": "Le Noble Chocolatier - Maison de Chocolat - sal",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "2829",
"Industrial certificate date": "19-Apr-18",
"ACTIVITY": "صناعة الحلويات, الشوكولا والسكاكر",
"Activity-L": "Manufacture of sweets, chocolate and candies",
"ADRESS": "بناية مراد\u001c - شارع الفردوس - طلعة مستشفى بيطار\u001c - البوشرية - المتن",
"TEL1": "01/687786",
"TEL2": "70/017191",
"TEL3": "",
"internet": "farouk@lenoblechocolatier.com"
},
{
"Category": "Fourth",
"Number": "32427",
"com-reg-no": "2002132",
"NM": "شـركـة : Iso Tech  ايزو تـك - توصية بسيطة",
"L_NM": "Iso Tech",
"Last Subscription": "20-Feb-18",
"Industrial certificate no": "4388",
"Industrial certificate date": "27-Jul-18",
"ACTIVITY": "صناعة المنجورات والواجهات الالمينيوم",
"Activity-L": "Manufacture of aluminium panels & front",
"ADRESS": "ملك نجيب الاعور\u001c - الساحة \u001c - قرنايل - بعبدا",
"TEL1": "05/361393",
"TEL2": "03/737015",
"TEL3": "",
"internet": "info@isotechlb.com"
},
{
"Category": "First",
"Number": "5070",
"com-reg-no": "2019398",
"NM": "المجموعة العصرية للنقل والصيانة والصناعة ش م م",
"L_NM": "A.T.M Group sarl",
"Last Subscription": "24-Nov-17",
"Industrial certificate no": "4900",
"Industrial certificate date": "30-Aug-18",
"ACTIVITY": "معملا لصب احجار الباطون",
"Activity-L": "Casting of concrete stones",
"ADRESS": "ملك ذيب الجردي\u001c - القبة - شارع الامراء\u001c - الشويفات - عاليه",
"TEL1": "05/431177",
"TEL2": "05/433199",
"TEL3": "03/082943",
"internet": "mtm@mtm-lebanon.com"
},
{
"Category": "Third",
"Number": "30396",
"com-reg-no": "2013222",
"NM": "Nylco sarl",
"L_NM": "Nylco sarl",
"Last Subscription": "23-Jan-18",
"Industrial certificate no": "3709",
"Industrial certificate date": "28-Mar-18",
"ACTIVITY": "صناعة ااكياس النايلون",
"Activity-L": "Trading of nylon bags",
"ADRESS": "ملك ديب\u001c - المنطقة الصناعية - شارع مار مارون\u001c - البوشرية - المتن",
"TEL1": "01/240964",
"TEL2": "03/945399",
"TEL3": "",
"internet": "info@nylco.net"
},
{
"Category": "Third",
"Number": "28457",
"com-reg-no": "2021579",
"NM": "شركة افران شميس التجارية ش م م",
"L_NM": "Shmeiss Commercial Bakery Company S C B C sarl",
"Last Subscription": "31-Jan-18",
"Industrial certificate no": "205",
"Industrial certificate date": "16-Jan-19",
"ACTIVITY": "فرن",
"Activity-L": "Bakery",
"ADRESS": "بناية دفلى ط سفلي\u001c - جسر الليلكي\u001c - الحدث - بعبدا",
"TEL1": "03/316908",
"TEL2": "03/260953",
"TEL3": "03/594905",
"internet": ""
},
{
"Category": "Third",
"Number": "30328",
"com-reg-no": "2000448",
"NM": "سرجيو لايتنغ",
"L_NM": "Sergio Lighting",
"Last Subscription": "28-Jan-17",
"Industrial certificate no": "2773",
"Industrial certificate date": "31-Oct-17",
"ACTIVITY": "صب المعادن",
"Activity-L": "Forging of metals",
"ADRESS": "ملك كوسه يان\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/500293",
"TEL2": "03/888006",
"TEL3": "",
"internet": "zarok69@hotmail.com"
},
{
"Category": "Second",
"Number": "5567",
"com-reg-no": "2020113",
"NM": "مولتبلاستيك ش م ل",
"L_NM": "Multiplastic sal",
"Last Subscription": "22-Apr-17",
"Industrial certificate no": "2588",
"Industrial certificate date": "21-Sep-17",
"ACTIVITY": "صناعة السلع البلاستيكية والالات المستعملة لصناعتها",
"Activity-L": "Manufacture of palsticware & its\' machines",
"ADRESS": "ملك برغل\u001c - المدينة الصناعية\u001c - بشامون - عاليه",
"TEL1": "05/801168",
"TEL2": "05/801198",
"TEL3": "03/889907",
"internet": "alib@multiplastic.com"
},
{
"Category": "Third",
"Number": "28413",
"com-reg-no": "2021935",
"NM": "شركة المسار للابداع العمراني ش م م",
"L_NM": "Al Masar Company for Creative Construction sarl",
"Last Subscription": "13-Feb-17",
"Industrial certificate no": "0246",
"Industrial certificate date": "14-Feb-16",
"ACTIVITY": "تنفيذ تعهدات الهندسة المدنية",
"Activity-L": "Civil engineering contracting",
"ADRESS": "سنتر الشويفات\u001c - حي الامراء - شارع عادل ارسلان\u001c - الشويفات - عاليه",
"TEL1": "",
"TEL2": "03/689461",
"TEL3": "03/157403",
"internet": ""
},
{
"Category": "Fourth",
"Number": "21379",
"com-reg-no": "71431",
"NM": "الشركة الحديثة للمفروشات والديكور - سماد - توصية بسيطة",
"L_NM": "La Societe Moderne Pour L\' ameublement Et Le décor - Smad",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "3918",
"Industrial certificate date": "4-May-18",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك بشير جلابيان\u001c - زعيترية\u001c - الفنار - المتن",
"TEL1": "01/692769",
"TEL2": "01/690608",
"TEL3": "03/473023",
"internet": "bachirjalabian@hotmail.com"
},
{
"Category": "Second",
"Number": "5362",
"com-reg-no": "2020718",
"NM": "شركة انتيريور ديكوريشن بروجكت ش م ل - شركة أي دي بروجكت ش م ل",
"L_NM": "Interior Decoration Project sal - ID project sal",
"Last Subscription": "3-Feb-18",
"Industrial certificate no": "348",
"Industrial certificate date": "7-Feb-19",
"ACTIVITY": "صناعة المفروشات",
"Activity-L": "Manufacture of furniture",
"ADRESS": "بناية ICF\u001c - المدينة الصناعية\u001c - المكلس - المتن",
"TEL1": "01/694698",
"TEL2": "01/694678",
"TEL3": "71/500480",
"internet": "info@idproject-lb.com"
},
{
"Category": "Fourth",
"Number": "21325",
"com-reg-no": "2017127",
"NM": "شركة جبال لبنان للانتاج البلدي - حسين القضماني وشركاه - توصية بسيطة",
"L_NM": "Jibal Loubnan Co. For Rural Production - Hussein Kadamani & Partners",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "4572",
"Industrial certificate date": "5-Sep-18",
"ACTIVITY": "تعبئة وتوضيب العسل ودبس الخروب والرمان",
"Activity-L": "Filling & packing of honey ,molasses & pomegranate",
"ADRESS": "سنتر الخيرات\u001c - الشارع العام\u001c - بخشتيه - عاليه",
"TEL1": "05/550288",
"TEL2": "03/650842",
"TEL3": "",
"internet": "info@jiballoubnan.com"
},
{
"Category": "Third",
"Number": "29027",
"com-reg-no": "2028252",
"NM": "شركة بزي للصناعة والتجارة ش م م",
"L_NM": "Bazzi for Industry & Trade Co. sarl",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "4064",
"Industrial certificate date": "1-Jun-18",
"ACTIVITY": "صناعة الاحذية",
"Activity-L": "Manufacture of shoes",
"ADRESS": "ملك سليمان بزي\u001c - الكفاءات - قرب مدراس المهدي\u001c - الحدث - بعبدا",
"TEL1": "01/476196",
"TEL2": "03/275404",
"TEL3": "",
"internet": "Bazzi.company@gmail.com"
},
{
"Category": "Second",
"Number": "7127",
"com-reg-no": "2027889",
"NM": "شركة فيرست بلاست ش م ل",
"L_NM": "First Plast sal",
"Last Subscription": "25-Jan-18",
"Industrial certificate no": "3271",
"Industrial certificate date": "1-Feb-18",
"ACTIVITY": "صناعة اكياس نايلون",
"Activity-L": "Manufacture  of naylon bags",
"ADRESS": "ملك محمد ضاهر\u001c - المنطقة الصناعية\u001c - بشامون - عاليه",
"TEL1": "03/653242",
"TEL2": "05/801429",
"TEL3": "",
"internet": "fpind@outlook.com"
},
{
"Category": "Third",
"Number": "30256",
"com-reg-no": "2017464",
"NM": "شركة رميكو ش م م",
"L_NM": "Rmieco sarl",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "4787",
"Industrial certificate date": "24-Oct-18",
"ACTIVITY": "صناعة الاحذية الرجالية والنسائية والولادية والعسكرية",
"Activity-L": "Manufacture of men\'s, ladies\' children\'s & military shoes",
"ADRESS": "ملك روبير المدور ط سفلي\u001c - الطريق العام\u001c - كفرشيما - بعبدا",
"TEL1": "05/434890",
"TEL2": "03/092044",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "30951",
"com-reg-no": "2032934",
"NM": "امبر غروب ش م م",
"L_NM": "Ambar Group sarl",
"Last Subscription": "17-May-17",
"Industrial certificate no": "2334",
"Industrial certificate date": "30-Jul-17",
"ACTIVITY": "الخراطة وصناعة الالات الزراعية والصناعية",
"Activity-L": "Turnery & Manufacture of agro & industrial machinary",
"ADRESS": "ملك جان الشمالي\u001c - المدينة الصناعية - شارع 88\u001c - سد البوشرية - المتن",
"TEL1": "01/494484",
"TEL2": "01/480652",
"TEL3": "03/385119",
"internet": ""
},
{
"Category": "Third",
"Number": "27730",
"com-reg-no": "2013919",
"NM": "شركة جوزف وميشال نحاس ش م م",
"L_NM": "Joseph & Michel Nahhas sarl JMN",
"Last Subscription": "16-Dec-17",
"Industrial certificate no": "025",
"Industrial certificate date": "13-Dec-18",
"ACTIVITY": "صناعة الاحذية والجزادين النسائية والولادية والرجالية",
"Activity-L": "Manufacture of ladies\',children\'s & men\'s shoes & bags",
"ADRESS": "ملك جوزف وميشال نحاس\u001c - شارع الغيلان\u001c - برج حمود - المتن",
"TEL1": "01/488111",
"TEL2": "01/483853",
"TEL3": "",
"internet": "michel.nahas@jmn.com.lb"
},
{
"Category": "Third",
"Number": "30210",
"com-reg-no": "2020627",
"NM": "Saab Architects Group sarl",
"L_NM": "Saab Architects Group sarl",
"Last Subscription": "25-Jan-18",
"Industrial certificate no": "977",
"Industrial certificate date": "8-Jul-16",
"ACTIVITY": "تنفيذ تعهدات الهندسة المعمارية",
"Activity-L": "Architecture enterprises",
"ADRESS": "ملك شليطا\u001c - الشارع العام\u001c - نيو سهيله - كسروان",
"TEL1": "09/230387",
"TEL2": "03/718164",
"TEL3": "",
"internet": "geosaab@gmail.com"
},
{
"Category": "Fourth",
"Number": "19821",
"com-reg-no": "1011963",
"NM": "سيدر",
"L_NM": "Cedar",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "2024",
"Industrial certificate date": "24-May-18",
"ACTIVITY": "صناعة الشوكولا",
"Activity-L": "Manufacture of chocolate",
"ADRESS": "بناية ثلجة\u001c - شارع طلعت حرب\u001c - المصيطبة - بيروت",
"TEL1": "01/355535",
"TEL2": "09/621927",
"TEL3": "03/646160",
"internet": ""
},
{
"Category": "Third",
"Number": "30191",
"com-reg-no": "61878",
"NM": "مصنع وانيس قره بتيان",
"L_NM": "Wannis Garabedian",
"Last Subscription": "25-Jul-17",
"Industrial certificate no": "2116",
"Industrial certificate date": "12-Jan-18",
"ACTIVITY": "صناعة الجبالات، المكابس والقوالب التابعة لها",
"Activity-L": "Manufacture of concrete mixers & mould boxes",
"ADRESS": "ملك باخوس \u001c - شارع اسعد باخوس - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "03/875427",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "28306",
"com-reg-no": "1008271",
"NM": "شركة مطاعم رفيق مروش ش م م",
"L_NM": "Rafic Marrouche Restaurants sarl",
"Last Subscription": "16-Mar-18",
"Industrial certificate no": "4060",
"Industrial certificate date": "1-Jun-18",
"ACTIVITY": "تجارة اللحوم والدجاج المبردة - معملا لتصنيع وتوضيب منتجات غذائية",
"Activity-L": "Trading of frozen meat & poultry - Manufacture & packing of foods",
"ADRESS": "بناية اسماعيل\u001c - شارع كنيعو\u001c - فردان - بيروت",
"TEL1": "03/387420",
"TEL2": "01/360522",
"TEL3": "",
"internet": "info@marrouchrestaurants.com"
},
{
"Category": "Fourth",
"Number": "19815",
"com-reg-no": "2020433",
"NM": "عيد للاشغال الحديدية",
"L_NM": "E. I. D",
"Last Subscription": "30-Jan-18",
"Industrial certificate no": "4210",
"Industrial certificate date": "29-Jun-18",
"ACTIVITY": "معملا للمفروشات والحدادة الافرنجية",
"Activity-L": "Manufacture of furniture and smithery services",
"ADRESS": "ملك ابو ديوان\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/481701",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "28293",
"com-reg-no": "2019266",
"NM": "شركة : Patisserie Chocolate Cake - Darwich Bross - شركة توصية بسيطة",
"L_NM": "Patisserie Chocolate Cake - Darwich Bross",
"Last Subscription": "19-Jul-17",
"Industrial certificate no": "3892",
"Industrial certificate date": "27-Apr-18",
"ACTIVITY": "صناعة الحلويات والشوكولا والبوظة",
"Activity-L": "Manufacture of sweets, chocolate & ice cream",
"ADRESS": "ملك يعقوب درويش\u001c - صفير - الشارع العام\u001c - حارة حريك - بعبدا",
"TEL1": "01/552152",
"TEL2": "70/827027",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "6409",
"com-reg-no": "2016093",
"NM": "شركة افران شمسين حالات ش م م",
"L_NM": "Chamsine Bakers sarl Halate",
"Last Subscription": "19-Jun-17",
"Industrial certificate no": "4108",
"Industrial certificate date": "9-Jun-18",
"ACTIVITY": "صناعة وتجارة الخبز العربي والافرنجي",
"Activity-L": "Manufacture & Trading of bread",
"ADRESS": "ملك الكرسي البطريركي\u001c - الشارع العام\u001c - حالات - جبيل",
"TEL1": "05/800658",
"TEL2": "71/088877",
"TEL3": "03/793293",
"internet": ""
},
{
"Category": "Third",
"Number": "28269",
"com-reg-no": "64698",
"NM": "S.K.A.B",
"L_NM": "S.K.A.B",
"Last Subscription": "18-Feb-17",
"Industrial certificate no": "3004",
"Industrial certificate date": "19-Dec-17",
"ACTIVITY": "تجارة المفروشات",
"Activity-L": "Trading of furniture",
"ADRESS": "بناية خليفه\u001c - شارع سرج ابو حلقه\u001c - الفنار - المتن",
"TEL1": "01/896789",
"TEL2": "01/901762",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "28267",
"com-reg-no": "2016627",
"NM": "طونيز فوود ش م م",
"L_NM": "Tony`s Food sarl",
"Last Subscription": "15-Jan-18",
"Industrial certificate no": "4307",
"Industrial certificate date": "14-Jul-18",
"ACTIVITY": "تجارة المعجنات",
"Activity-L": "Trading of pastries",
"ADRESS": "ملك بولس صليبا\u001c - شارع القميرزة\u001c - البوار - كسروان",
"TEL1": "09/445059",
"TEL2": "01/683886",
"TEL3": "03/180800",
"internet": "tonysfood@tonysfood.com"
},
{
"Category": "Third",
"Number": "28225",
"com-reg-no": "1011146",
"NM": "جي ال سي اكسيسوريز ش م م",
"L_NM": "JLC Accessories sarl",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "3254",
"Industrial certificate date": "28-Jan-18",
"ACTIVITY": "صناعة المجوهرات والحلى المزيفة",
"Activity-L": "Manufacture of Jewelry & false Jewelry",
"ADRESS": "بناية سعد\u001c - شارع المدور - تجاه الصليب الاحمر\u001c - الجميزة - بيروت",
"TEL1": "01/569552",
"TEL2": "03/254550",
"TEL3": "",
"internet": "mireille_constantin@hotmail.com"
},
{
"Category": "Second",
"Number": "5476",
"com-reg-no": "1005505",
"NM": "شركة لاريسا ش م ل",
"L_NM": "Larissa sal",
"Last Subscription": "16-Jun-17",
"Industrial certificate no": "2192",
"Industrial certificate date": "2-Jul-17",
"ACTIVITY": "صناعة الحلويات العربية والافرنجية وبيع الماكولات الجاهزة",
"Activity-L": "Manufacture of western & oriental sweets & catering services",
"ADRESS": "سنتر جفينور ط الارضي\u001c - الشارع العام \u001c - كليمنصو - بيروت",
"TEL1": "05/461114",
"TEL2": "05/463773+4",
"TEL3": "03/342020",
"internet": "sales@larissa.ws"
},
{
"Category": "Third",
"Number": "30126",
"com-reg-no": "2012087",
"NM": "عبدو طانيوس عطا لله",
"L_NM": "Abdo Tanios Atallah",
"Last Subscription": "11-Apr-17",
"Industrial certificate no": "4810",
"Industrial certificate date": "28-May-16",
"ACTIVITY": "تجارة المفروشات المعدنية",
"Activity-L": "Trading of metallic furniture",
"ADRESS": "ملك عطا الله\u001c - الطريق العام \u001c - المكلس - المتن",
"TEL1": "01/686002",
"TEL2": "03/711557",
"TEL3": "",
"internet": "abdo@atallahco.com"
},
{
"Category": "Third",
"Number": "30145",
"com-reg-no": "2010483",
"NM": "جبران غروب ش م م",
"L_NM": "Gebran Group sarl",
"Last Subscription": "21-Apr-17",
"Industrial certificate no": "3829",
"Industrial certificate date": "18-Apr-18",
"ACTIVITY": "تعهدات الهندسة المدنية وصناعة الباطون الجاهز",
"Activity-L": "Civil engineering contracting and manufacture of ready-mixed concrete",
"ADRESS": "ملك عازار\u001c - المدينة الصناعية - قرب معمل الفاب\u001c - حصرايل - جبيل",
"TEL1": "09/791371",
"TEL2": "09/791370",
"TEL3": "70/970007",
"internet": "info@gebrangroup.com"
},
{
"Category": "Third",
"Number": "27667",
"com-reg-no": "2005464",
"NM": "يوروكيم ش م م",
"L_NM": "EUROCHEM sarl",
"Last Subscription": "16-Mar-18",
"Industrial certificate no": "492",
"Industrial certificate date": "28-Feb-19",
"ACTIVITY": "تجارة مواد اولية لصنع الدهانات، مستحضرات التجميل ومواد التنظيف",
"Activity-L": "Trading of primary materials for paints, cosmetics & detergents",
"ADRESS": "بناية كيشيشيان ملك فريد خوري ومجدة مراد\u001c - شارع فرنسوا الحاج\u001c - بعبدا",
"TEL1": "05/468122",
"TEL2": "03/654099",
"TEL3": "",
"internet": "eurochem@cyberia.net.lb"
},
{
"Category": "Third",
"Number": "28210",
"com-reg-no": "2019581",
"NM": "شركة انتر لامينات ش م م",
"L_NM": "Inter Laminate sarl",
"Last Subscription": "25-Jan-18",
"Industrial certificate no": "3713",
"Industrial certificate date": "28-Mar-18",
"ACTIVITY": " صناعة وتجارة مفروشات مكتبة ومنزلية ومطبخية",
"Activity-L": "Manufacture & Trading  of office & home furniture&vb kitchen",
"ADRESS": "بناية سبع تعين ط سفلي\u001c - القبة - مقابل سلطان ستيل\u001c - الشويفات - عاليه",
"TEL1": "05/800011",
"TEL2": "03/282670",
"TEL3": "70/177222",
"internet": "info@interlaminate.com"
},
{
"Category": "First",
"Number": "4931",
"com-reg-no": "2012622",
"NM": "ف د غروب ش م ل",
"L_NM": "F D Group sal",
"Last Subscription": "8-Aug-17",
"Industrial certificate no": "4170",
"Industrial certificate date": "20-Jun-18",
"ACTIVITY": "خياطة الالبسة النسائية والمراويل المدرسية والبياضات، وتطريز البسة وبياضات",
"Activity-L": "Manufacture of women clothes, linen & embroidery of clothes & linen",
"ADRESS": "سنتر صفير ملك الدكاش\u001c - شارع الجديدة\u001c - البوشرية - المتن",
"TEL1": "01/497046",
"TEL2": "01/511961",
"TEL3": "03/661135",
"internet": "fahim@daccachegroup.com"
},
{
"Category": "Fourth",
"Number": "21193",
"com-reg-no": "1007261",
"NM": "فابا برنرز Vapa Burners",
"L_NM": "Vapa Burners",
"Last Subscription": "24-Jan-18",
"Industrial certificate no": "4811",
"Industrial certificate date": "31-Oct-18",
"ACTIVITY": "معملا للحدادة الافرنجية",
"Activity-L": "Factory for Smithery",
"ADRESS": "بناية كاثولكية الارمن الارثوذكس\u001c - طريق النهر - شارع مدريد\u001c - مار مخايل - بيروت",
"TEL1": "01/446727",
"TEL2": "03/500325",
"TEL3": "",
"internet": "info@vapaburners.com"
},
{
"Category": "Third",
"Number": "30113",
"com-reg-no": "2009322",
"NM": "حكيميان للاحذية الجلدية اتش ال اف ش م م",
"L_NM": "Hakimian Leather Footwear HLF sarl",
"Last Subscription": "13-Feb-18",
"Industrial certificate no": "3987",
"Industrial certificate date": "17-May-18",
"ACTIVITY": "صناعة الاحذية الرجالية والنسائية والولادية",
"Activity-L": "Manufacture of men\'s, ladies\' & children\'s footwear",
"ADRESS": "بناية يرافان بلازا\u001c - كمب امانوس - شارع ماغي الحاج\u001c - البوشرية - المتن",
"TEL1": "01/242888",
"TEL2": "01/242777",
"TEL3": "01/262670",
"internet": "info@tentenshoes.com"
},
{
"Category": "Third",
"Number": "28170",
"com-reg-no": "1004720",
"NM": "هيمو ش م م",
"L_NM": "Himo sarl",
"Last Subscription": "3-Feb-18",
"Industrial certificate no": "3871",
"Industrial certificate date": "24-Apr-18",
"ACTIVITY": "صناعة المجوهرات",
"Activity-L": "Manufacture of jewellery",
"ADRESS": "بناية هيمو\u001c - شارع مار متر\u001c - الرميل - بيروت",
"TEL1": "01/330761",
"TEL2": "03/612278",
"TEL3": "",
"internet": "joseph@himojewellery.com"
},
{
"Category": "Third",
"Number": "30082",
"com-reg-no": "2000963",
"NM": "شركة اسعد وجورج الخوري - تضامن",
"L_NM": "Assaad & Georges Khoury Co",
"Last Subscription": "1-Mar-18",
"Industrial certificate no": "3439",
"Industrial certificate date": "22-Feb-18",
"ACTIVITY": "معملا للحدادة الافرنجية",
"Activity-L": "Smithery",
"ADRESS": "بناية الخوري\u001c - المدينة الصناعية\u001c - زوق مصبح - كسروان",
"TEL1": "03/649766",
"TEL2": "03/497995",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "5437",
"com-reg-no": "1007379",
"NM": "شركة أم ك أس باكيجينغ ش م ل",
"L_NM": "MKS Packaging sal",
"Last Subscription": "29-Mar-17",
"Industrial certificate no": "3816",
"Industrial certificate date": "12-Apr-18",
"ACTIVITY": "صناعة العبوات البلاستكية واكياس النايلون والورق وتجارة جملة اواني بلاستيكية",
"Activity-L": "manufacture of plstic ans ,Nylon Bags & paper -Wholesale of plasticware",
"ADRESS": "بناية حيدر\u001c - شارع الحاراتي\u001c - رأس النبع - بيروت",
"TEL1": "01/657003",
"TEL2": "01/632554",
"TEL3": "03/201931",
"internet": "mkspacking@gmail.com"
},
{
"Category": "Second",
"Number": "6680",
"com-reg-no": "2011195",
"NM": "دكركو فودز اند بروساسينغ ش م ل",
"L_NM": "Dekerco Food and Processing sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4660",
"Industrial certificate date": "3-Apr-18",
"ACTIVITY": "توضيب وتبريد اللحوم والسمك والدواجن",
"Activity-L": "Packing & preserving  of meat , fish & poultry",
"ADRESS": "ملك كوزوبيوكيان و دكرمنجيان\u001c - مدينة الصناعية - وادي الصناعي\u001c - الفنار - المتن",
"TEL1": "03/616883",
"TEL2": "03/595452",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "27409",
"com-reg-no": "2017572",
"NM": "Engineering Power Systems International Limited sarl شركة",
"L_NM": "Engineering Power Systems International Limited sarl",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "379-24-7",
"Industrial certificate date": "12-Nov-17",
"ACTIVITY": "صناعة اجهزة حماية وتحكم و UPS",
"Activity-L": "Manufacture of EPS - (electronic protection systems) & UPS",
"ADRESS": "سنتر عمارات - ملك يوسف عبيد\u001c - كفرحباب - الشارع العام\u001c - غزير - كسروان",
"TEL1": "09/854572",
"TEL2": "09/854573",
"TEL3": "03/655245",
"internet": "info@epslebanon.com"
},
{
"Category": "Third",
"Number": "27416",
"com-reg-no": "2016515",
"NM": "زاخم ديزاينس ش م م",
"L_NM": "Zakhem Designs sarl",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "3622",
"Industrial certificate date": "16-Mar-18",
"ACTIVITY": "صناعة وتصميم الازياء النسائية",
"Activity-L": "Manufacture & fashion design of ladies\' clothes",
"ADRESS": "سنتر زاخم بلازا ط 7\u001c - شارع القلعة\u001c - سن الفيل - المتن",
"TEL1": "01/511110",
"TEL2": "",
"TEL3": "",
"internet": "info@ranizakhem.com"
},
{
"Category": "Third",
"Number": "28040",
"com-reg-no": "2017688",
"NM": "وود وركس ش م م",
"L_NM": "Wood Works sarl",
"Last Subscription": "1-Feb-18",
"Industrial certificate no": "274",
"Industrial certificate date": "25-Jan-19",
"ACTIVITY": "اعمال الديكور - ونجارة خشبية",
"Activity-L": "Decoration services & wooden carpentry",
"ADRESS": "سنتر الحازمية بلوك ب ط4\u001c - طريق الشام القديمة\u001c - الحازمية - بعبدا",
"TEL1": "05/457754",
"TEL2": "03/144447",
"TEL3": "",
"internet": "woodworks@hatemdesign.com"
},
{
"Category": "Second",
"Number": "5312",
"com-reg-no": "2018917",
"NM": "شركة غولدن اوشن ش م م",
"L_NM": "Golden Ocean sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "4054",
"Industrial certificate date": "1-Jun-18",
"ACTIVITY": "معملا للمصوغات وتركيب الاحجار الكريمة",
"Activity-L": "Manufacture of jewelry & assorting of precious stones",
"ADRESS": "سنتر حاديديان ط 2\u001c - شارع البلدية\u001c - برج حمود - المتن",
"TEL1": "01/255445",
"TEL2": "01/255446",
"TEL3": "03/760069",
"internet": "goldenocean@ocean.net"
},
{
"Category": "Fourth",
"Number": "26812",
"com-reg-no": "2015791",
"NM": "شركة كنوز للصناعة والتجارة ش م م",
"L_NM": "Kounouz Co For Industry & Trading sarl",
"Last Subscription": "31-Jan-18",
"Industrial certificate no": "3134462",
"Industrial certificate date": "10-Aug-18",
"ACTIVITY": "صناعة المواد الغذائية",
"Activity-L": "Manufacture of foodstuffs",
"ADRESS": "ملك انطوان رياشي\u001c - الشارع العام\u001c - المتين - المتن",
"TEL1": "04/271064",
"TEL2": "03/238064",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1508",
"com-reg-no": "1011008",
"NM": "شركة نست ش م ل - مفروشات وتصميم داخلي",
"L_NM": "Nest sal - Furniture and Interior Design",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "080",
"Industrial certificate date": "25-Jul-18",
"ACTIVITY": "صناعة وتجارة المفروشات",
"Activity-L": "Manufacture& Trading  of furniture",
"ADRESS": "بناية المجذوب\u001c - كليمنصو - شارع مي زياده\u001c - جنبلاط - بيروت",
"TEL1": "01/362111",
"TEL2": "01/368666",
"TEL3": "70/362111",
"internet": "info@nest.com.lb"
},
{
"Category": "Third",
"Number": "28138",
"com-reg-no": "2017803",
"NM": "شركة معادن البعد الثالث ش م م",
"L_NM": "Third Dimension Metals sarl",
"Last Subscription": "10-Mar-18",
"Industrial certificate no": "3832",
"Industrial certificate date": "18-Mar-18",
"ACTIVITY": "صناعة خردوات معدنية",
"Activity-L": "Manufacture of hardware",
"ADRESS": "ملك عثمان العنترازي ط سفلي\u001c - المدينة الصناعية\u001c - عين حالا - عاليه",
"TEL1": "05/553909",
"TEL2": "03/406366",
"TEL3": "03/393429",
"internet": "nada3dm@hotmail.com"
},
{
"Category": "Third",
"Number": "30041",
"com-reg-no": "2018598",
"NM": "Nutrico Foods sarl",
"L_NM": "Nutrico Foods sarl",
"Last Subscription": "14-Aug-17",
"Industrial certificate no": "4479",
"Industrial certificate date": "11-Aug-18",
"ACTIVITY": "توضيب وتعبئة الخضار وتصنيع الثوم",
"Activity-L": "Packing of vegetables & garlic products",
"ADRESS": "ملك ليليان مواقديه\u001c - شارع المغتربين\u001c - ديك المحدي - المتن",
"TEL1": "04/920311",
"TEL2": "03/339283",
"TEL3": "",
"internet": "nutricofoods@hotmail.com"
},
{
"Category": "Second",
"Number": "5450",
"com-reg-no": "2012219",
"NM": "شركة نعص فود كومباني ش م ل",
"L_NM": "Naas Food Company sal",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "4863",
"Industrial certificate date": "13-Nov-18",
"ACTIVITY": "صناعة المواد الغذائية والمشروبات",
"Activity-L": "Manufacture of foodstuffs & beverages",
"ADRESS": "بناية سان ميشال ط 1\u001c - حي النعص\u001c - ساقية المسك - المتن",
"TEL1": "04/981197",
"TEL2": "04/928990",
"TEL3": "",
"internet": "naasfood@gmail.com"
},
{
"Category": "Third",
"Number": "30020",
"com-reg-no": "2015873",
"NM": "Techn\'eau International",
"L_NM": "Techn\'eau International",
"Last Subscription": "2-Mar-18",
"Industrial certificate no": "457",
"Industrial certificate date": "26-Feb-19",
"ACTIVITY": "صناعة الادوات الصحية (مغاطس ، جاكوزي ، غرف سونا...)",
"Activity-L": "Industry of sanitary articles",
"ADRESS": "ملك الخوري\u001c - حي الزعيترية - شارع عين الشيخ\u001c - الفنار - المتن",
"TEL1": "01/688567",
"TEL2": "01/680489",
"TEL3": "",
"internet": "techneau@cyberia.net.lb"
},
{
"Category": "Second",
"Number": "5442",
"com-reg-no": "1009361",
"NM": "شركة بوكجا منسوجات وتصاميم ش م ل",
"L_NM": "Bokja Textile And Design sal",
"Last Subscription": "27-Jan-17",
"Industrial certificate no": "1569",
"Industrial certificate date": "18-Apr-18",
"ACTIVITY": "تنجيد المفروشات الخشبية والمعدنية",
"Activity-L": "Upholstery of wooden & metallic furniture",
"ADRESS": "ملك عائدة الحكيم\u001c - شارع البطركية\u001c - زقاق البلاط - بيروت",
"TEL1": "01/361629",
"TEL2": "70/905263",
"TEL3": "",
"internet": "info@bokjadesign.com"
},
{
"Category": "First",
"Number": "5206",
"com-reg-no": "1004489",
"NM": "برالينو - لاميزون دي شوكولا ش م م",
"L_NM": "Pralino - La Maison Du Chocolat sarl",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "3857",
"Industrial certificate date": "22-Apr-18",
"ACTIVITY": "صناعة الشوكولا والسكاكر",
"Activity-L": "Manufacture of chocolate & candies",
"ADRESS": "ملك عبدو وشركاه\u001c - كلية مار يوسف\u001c - اليسوعية - بيروت",
"TEL1": "01/683999",
"TEL2": "01/685444",
"TEL3": "01/687111",
"internet": "eh@pralino.com"
},
{
"Category": "Third",
"Number": "28096",
"com-reg-no": "69840",
"NM": "داغر ديزاين ش م م",
"L_NM": "Dagher Design sarl",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "3482",
"Industrial certificate date": "25-Feb-18",
"ACTIVITY": "خياطة الملبوسات النسائية",
"Activity-L": "Sewing of ladies\' clothes",
"ADRESS": "سنتر فيغا \u001c - الاوتوستراد\u001c - زوق مكايل - كسروان",
"TEL1": "09/215521",
"TEL2": "03/398333",
"TEL3": "",
"internet": "fashion@mireilledagher.com"
},
{
"Category": "Third",
"Number": "27465",
"com-reg-no": "2015356",
"NM": "نيت اند وير ش م م",
"L_NM": "Knit & Wear sarl",
"Last Subscription": "1-Jun-17",
"Industrial certificate no": "4051",
"Industrial certificate date": "31-May-18",
"ACTIVITY": "تجارة جملة البسة نسائية",
"Activity-L": "Wholesale of ladies\' clothes",
"ADRESS": "بناية اكرم ابو شعيا\u001c - حي الناكوزي - متفرع من شارع سلاف\u001c - الدكوانة - المتن",
"TEL1": "03/507224",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "4144",
"com-reg-no": "2014053",
"NM": "Joseph Younes Furniture & Design sal",
"L_NM": "Joseph Younes Furniture & Design sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4157",
"Industrial certificate date": "19-Jun-18",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture  of wooden furniture",
"ADRESS": "ملك نبيه فارس\u001c - شارع البساتين - قرب شركة فتال\u001c - سن الفيل - المتن",
"TEL1": "01/494204",
"TEL2": "01/493694",
"TEL3": "03/301900",
"internet": "info@josephyounes.com"
},
{
"Category": "Third",
"Number": "28099",
"com-reg-no": "2015083",
"NM": "شركة عالم المال للاستثمار ش م م",
"L_NM": "Global Finance Corporation sarl",
"Last Subscription": "25-Jan-17",
"Industrial certificate no": "2965",
"Industrial certificate date": "1-Jul-18",
"ACTIVITY": "صناعة اليخوت والقوارب",
"Activity-L": "Building  of yachts & boats",
"ADRESS": "سنتر طعمه التجاري ط4\u001c - سوق معوض\u001c - الشياح - بعبدا",
"TEL1": "01/273393",
"TEL2": "03/283393",
"TEL3": "",
"internet": "glofinanceco@hotmail.com"
},
{
"Category": "Third",
"Number": "27462",
"com-reg-no": "2000347",
"NM": "الخليج للملابس - بيروت ش م م",
"L_NM": "Gulf Professional Clothing - Beirut sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "277",
"Industrial certificate date": "25-Jan-19",
"ACTIVITY": "تجارة جملة الملبوسات",
"Activity-L": "Wholesale of divers clothing",
"ADRESS": "ملك سونيا قصار\u001c - الطريق البحرية - شارع كرومو\u001c - برج حمود - المتن",
"TEL1": "01/250919",
"TEL2": "03/209080",
"TEL3": "03/307147",
"internet": "www.gpclothing.net"
},
{
"Category": "Second",
"Number": "5116",
"com-reg-no": "2013863",
"NM": "Digidots sal",
"L_NM": "Digidots sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "1133",
"Industrial certificate date": "26-Dec-17",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "ملك جمال الدين\u001c - الساحة\u001c - بشامون - عاليه",
"TEL1": "01/853753",
"TEL2": "01/820321",
"TEL3": "03/333494",
"internet": "info@08digidots.com"
},
{
"Category": "First",
"Number": "4324",
"com-reg-no": "62664",
"NM": "اكسس ش م م",
"L_NM": "Axis sarl",
"Last Subscription": "12-Mar-18",
"Industrial certificate no": "3749",
"Industrial certificate date": "1-Apr-18",
"ACTIVITY": "صناعة الحلويات والمعجنات",
"Activity-L": "Manufacture of sweets & pastry",
"ADRESS": "ملك شركة معلوف واولاده ش م ل\u001c - المدينة الصناعية\u001c - زوق مصبح - كسروان",
"TEL1": "09/221664",
"TEL2": "09/221774",
"TEL3": "",
"internet": "axiscakes@yahoo.com"
},
{
"Category": "Second",
"Number": "5110",
"com-reg-no": "2045846",
"NM": "الو ستيل ش م ل",
"L_NM": "Alusteel sal",
"Last Subscription": "13-Mar-18",
"Industrial certificate no": "4544",
"Industrial certificate date": "28-Aug-18",
"ACTIVITY": "صناعة منجورت الالمينيوم",
"Activity-L": "Manufacture of aluminium panellings",
"ADRESS": "ملك الشركة\u001c - المنطقة الصناعية\u001c - حالات - جبيل",
"TEL1": "09/477393",
"TEL2": "09/479034",
"TEL3": "70/177205",
"internet": "admin@alusteel-lb.com"
},
{
"Category": "Second",
"Number": "5245",
"com-reg-no": "2014911",
"NM": "شركة باغ - ات ش م ل",
"L_NM": "Bag - It sal",
"Last Subscription": "17-Feb-17",
"Industrial certificate no": "4105",
"Industrial certificate date": "9-Jun-18",
"ACTIVITY": "صناعة اكياس الورق والطباعة عليها",
"Activity-L": "Manufacture of paper Bags",
"ADRESS": "ملك شركة لاروتوغرافير\u001c - المدينة الصناعية - قرب معمل اجاكس\u001c - زوق مصبح - كسروان",
"TEL1": "09/216912",
"TEL2": "03/814874",
"TEL3": "03/719453",
"internet": "Joseph.aroyan@gmail.com"
},
{
"Category": "Second",
"Number": "5249",
"com-reg-no": "2015417",
"NM": "فبركا ش م ل",
"L_NM": "Fabraka sal",
"Last Subscription": "10-May-17",
"Industrial certificate no": "2689",
"Industrial certificate date": "14-Oct-17",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "بناية يونيلاب\u001c - شارع مار انطونيوس - طريق نهر الموت\u001c - الجديدة - المتن",
"TEL1": "04/409640",
"TEL2": "03/240018",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "5100",
"com-reg-no": "1007392",
"NM": "عازار جمز كومباني ش م ل",
"L_NM": "Azar Gems Company sal",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "3768",
"Industrial certificate date": "5-Apr-18",
"ACTIVITY": "صناعة المجوهرات",
"Activity-L": "Manufacture of jewellery",
"ADRESS": "عقار 1479\u001c - شارع ويغان\u001c - النجمة - بيروت",
"TEL1": "01/974111",
"TEL2": "04/717476",
"TEL3": "03/388333",
"internet": "azarjewelers@hotmail.com"
},
{
"Category": "Third",
"Number": "26293",
"com-reg-no": "40432",
"NM": "ناشيونال بلاست شركة تضامن",
"L_NM": "National - Plast",
"Last Subscription": "22-Jun-17",
"Industrial certificate no": "2652",
"Industrial certificate date": "21-Mar-18",
"ACTIVITY": "صناعة اكسسوار تمديدات صحية وحبيبات بلاستيك",
"Activity-L": "Man. of sanitary inst. accessories &plastic in primary form (granule) PVC",
"ADRESS": "ملك كرميان وباسدريمه جيان\u001c - المدينة الصناعية\u001c - مزرعة يشوع - المتن",
"TEL1": "04/924930",
"TEL2": "03/660540",
"TEL3": "03/221424",
"internet": "natplast@cyberia.net.lb"
},
{
"Category": "Second",
"Number": "4130",
"com-reg-no": "2015668",
"NM": "شركة انتر كازا ش م ل",
"L_NM": "Inter Casa sal",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "2619",
"Industrial certificate date": "16-Mar-18",
"ACTIVITY": "تجارة المفروشات المنزلية والمكتبية واجهزة الانارة",
"Activity-L": "manufacture of home & office furniture & Lighting articles",
"ADRESS": "ملك الشركة\u001c - الشارع العام\u001c - جدرا - الشوف",
"TEL1": "01/804803",
"TEL2": "",
"TEL3": "",
"internet": "intercasa@gmx.com"
},
{
"Category": "Third",
"Number": "26895",
"com-reg-no": "2013467",
"NM": "ليبل بلاس ش م م",
"L_NM": "Label Plus sarl",
"Last Subscription": "16-Feb-18",
"Industrial certificate no": "4989",
"Industrial certificate date": "6-Dec-18",
"ACTIVITY": "مطبعة (اتيكيت)",
"Activity-L": "Printing press ( Label )",
"ADRESS": "ملك يموت\u001c - الشارع العام\u001c - حارة الناعمة - الشوف",
"TEL1": "05/603446",
"TEL2": "05/603447",
"TEL3": "03/273021",
"internet": "haythamsinno@label-plus.com"
},
{
"Category": "Third",
"Number": "26867",
"com-reg-no": "2014016",
"NM": "شركة كوفر بلاس ش م م",
"L_NM": "Cover Plus sarl",
"Last Subscription": "16-Mar-18",
"Industrial certificate no": "4510",
"Industrial certificate date": "21-Aug-18",
"ACTIVITY": "صناعة الشامبو والعطور ومواد التنظيف",
"Activity-L": "Manufacture of shampoo, perfumes  & detergents",
"ADRESS": "بناية فالنسيا تاور\u001c - القبة - طريق صيدا القديمة\u001c - الشويفات - عاليه",
"TEL1": "05/807569",
"TEL2": "03/681136",
"TEL3": "",
"internet": "goldentouchceramics@gmail.com"
},
{
"Category": "Third",
"Number": "26868",
"com-reg-no": "2009054",
"NM": "شركة اورورا الكرمة والخمور ش م م",
"L_NM": "Aurora Winery Vineyards sarl",
"Last Subscription": "20-Mar-18",
"Industrial certificate no": "2242",
"Industrial certificate date": "13-Jun-18",
"ACTIVITY": "صناعة مشروبات روحية",
"Activity-L": "Manufacture of alcoholic drinks",
"ADRESS": "سنتر سايفكو\u001c - حي الخزان - الشارع العام\u001c - الفنار - المتن",
"TEL1": "01/891816",
"TEL2": "71/632620",
"TEL3": "03/295458",
"internet": "info@aurorawinery.co"
},
{
"Category": "Second",
"Number": "7257",
"com-reg-no": "2000403",
"NM": "شركة امين شومان واولاده ش م م اميشو",
"L_NM": "Amicho",
"Last Subscription": "9-Jun-17",
"Industrial certificate no": "4031",
"Industrial certificate date": "26-May-18",
"ACTIVITY": "صناعة الحلويات العربية والافرنجية",
"Activity-L": "Manufacture of sweets",
"ADRESS": "سنتر مهدي وفواز\u001c - مار مخايل - طريق صيدا القديمة\u001c - الشياح - بعبدا",
"TEL1": "01/542222",
"TEL2": "03/767888",
"TEL3": "03/333533",
"internet": "hassanchouman@hotmail.com"
},
{
"Category": "First",
"Number": "4779",
"com-reg-no": "2016136",
"NM": "إنفيرو ـ لينك ش م م",
"L_NM": "Enviro - Link sarl",
"Last Subscription": "2-Feb-18",
"Industrial certificate no": "3182",
"Industrial certificate date": "9-Oct-18",
"ACTIVITY": "تعبئة المياه ضمن اوعية خاصة",
"Activity-L": "Bottling of water in special containers",
"ADRESS": "ملك دير مار انطونيوس\u001c - حي الجاموس - شارع مجمع المجتبى\u001c - الحدث - بعبدا",
"TEL1": "05/465222",
"TEL2": "03/021028",
"TEL3": "",
"internet": "info@drinkaliya.com"
},
{
"Category": "Third",
"Number": "28016",
"com-reg-no": "2012272",
"NM": "كلاس برو - فود ش م م",
"L_NM": "Kallas Pro - Food sarl",
"Last Subscription": "13-Jan-17",
"Industrial certificate no": "3089",
"Industrial certificate date": "9-Jan-18",
"ACTIVITY": "صناعة عصير الفاكهة،مشروبات روحية،مخللات وكاتشاب",
"Activity-L": "Manufacture of juice,alcoholic drinks,pickles & ketchup",
"ADRESS": "ملك وقف مدرسة عين ورقة\u001c - الشارع العام\u001c - حالات - جبيل",
"TEL1": "03/316356",
"TEL2": "03/294422",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "4136",
"com-reg-no": "2011382",
"NM": "ج.ب. كلارك ش م ل",
"L_NM": "G.P. Clark sal",
"Last Subscription": "18-Aug-17",
"Industrial certificate no": "2622",
"Industrial certificate date": "29-Sep-17",
"ACTIVITY": "تصنيع وتبعئة معاجين اساس لزوم البناء والديكور",
"Activity-L": " Manufacture& filling of putty for building & decoration",
"ADRESS": "ملك جورج فهوجي\u001c - الشارع العام\u001c - حالات - جبيل",
"TEL1": "09/635385",
"TEL2": "03/376324",
"TEL3": "09/478540",
"internet": "georgek@gpclarkinternational.com"
},
{
"Category": "Third",
"Number": "29508",
"com-reg-no": "2034711",
"NM": "شركة ميلينيوم للمنتوجات الورقية ش م ل",
"L_NM": "Millennium Paper Products sal",
"Last Subscription": "9-Mar-18",
"Industrial certificate no": "4840",
"Industrial certificate date": "7-Nov-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "ملك ربيع عواد وهالة ابي حيدر\u001c - المدينة الصناعية\u001c - الحصون - جبيل",
"TEL1": "01/544911",
"TEL2": "09/420024",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "4882",
"com-reg-no": "56658",
"NM": "مؤسسة ميشال عواد التجارية للمقاولات والصناعة",
"L_NM": "L\' Entreprise",
"Last Subscription": "24-Mar-17",
"Industrial certificate no": "3545",
"Industrial certificate date": "23-Mar-18",
"ACTIVITY": "معملا لنشر الصخور والرخام",
"Activity-L": "Rocks & marble industry",
"ADRESS": "بناية عواد\u001c - جادة شارل حلو\u001c - المدور - بيروت",
"TEL1": "04/911155",
"TEL2": "03/622403",
"TEL3": "",
"internet": "entreprise.aouwad@gmail.com"
},
{
"Category": "Second",
"Number": "5269",
"com-reg-no": "2016019",
"NM": "كتره برس ش م ل",
"L_NM": "Katra Press sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "261",
"Industrial certificate date": "24-Jan-19",
"ACTIVITY": "مطبعة تجارية وصناعة علب واكياس من الورق والكرتون",
"Activity-L": "Printing press& manufacture of paper & carton boxes & bags",
"ADRESS": "بناية عبيد\u001c - المدينة الصناعية - الشارع العام\u001c - البوشرية - المتن",
"TEL1": "01/511523",
"TEL2": "",
"TEL3": "",
"internet": "katrapress@wise.net.lb"
},
{
"Category": "Third",
"Number": "27198",
"com-reg-no": "2014388",
"NM": "شركة شمالي للصناعة والتجارة ش م م",
"L_NM": "Chemaly Industry and Trade sarl",
"Last Subscription": "6-Feb-18",
"Industrial certificate no": "3692",
"Industrial certificate date": "27-Mar-18",
"ACTIVITY": "صناعة البسكويت",
"Activity-L": "Manufacture of biscuits",
"ADRESS": "ملك الشمالي\u001c - طريق حريصا - الشارع العام\u001c - درعون - كسروان",
"TEL1": "09/263034",
"TEL2": "03/733670",
"TEL3": "03/796481",
"internet": "info@chemalychocolate.com"
},
{
"Category": "Third",
"Number": "27212",
"com-reg-no": "2014948",
"NM": "اسامة فتح الله واولاده ش م م",
"L_NM": "Oussama Fathallah & Fils sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "3813",
"Industrial certificate date": "12-Apr-18",
"ACTIVITY": "صناعة التخاريج لزوم الستائر والمفروشات والالبسة",
"Activity-L": "Weaving of embrioderies for curtains, furniture & clothes",
"ADRESS": "بناية الهبر ط 3\u001c - المنطقة الصناعية - شارع رقم 4\u001c - المكلس - المتن",
"TEL1": "01/686679",
"TEL2": "03/620070",
"TEL3": "",
"internet": "info@chararib.com"
},
{
"Category": "Second",
"Number": "7056",
"com-reg-no": "2014129",
"NM": "شركة ادنت للطباعة ش م م",
"L_NM": "Adnet For Printing sarl",
"Last Subscription": "24-Jan-18",
"Industrial certificate no": "1563",
"Industrial certificate date": "22-Mar-17",
"ACTIVITY": "خدمات الدعاية والاعلان",
"Activity-L": "Advertising services",
"ADRESS": "ملك حسن فاعور\u001c - شارع المعلم - خلف محطة هاشم\u001c - حارة حريك - بعبدا",
"TEL1": "01/279397",
"TEL2": "01/456020",
"TEL3": "03/890092",
"internet": "adnet_for printing@hotmail.com"
},
{
"Category": "First",
"Number": "5209",
"com-reg-no": "2012394",
"NM": "منتوجات البيت الثاني للتجارة والصناعة ش م م",
"L_NM": "Second House Products for Trading & Industry sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "4486",
"Industrial certificate date": "12-Aug-18",
"ACTIVITY": "تعبئة منتوجات غذائية بلدية وبهارات",
"Activity-L": "Packing of homemade food products & spices",
"ADRESS": "ملك الشركة\u001c - المدينة الصناعية - شارع E\u001c - مزرعة يشوع - المتن",
"TEL1": "04/915391",
"TEL2": "03/803907",
"TEL3": "",
"internet": "shp@secondhouseprod.com"
},
{
"Category": "Second",
"Number": "5659",
"com-reg-no": "2014408",
"NM": "مخابز الصفا الالية",
"L_NM": "Safa Bakery",
"Last Subscription": "11-Mar-17",
"Industrial certificate no": "4359",
"Industrial certificate date": "24-Jul-18",
"ACTIVITY": "فرن",
"Activity-L": "Bakery",
"ADRESS": "ملك نزهة الحويس ط ارضي\u001c - المريجة - الساحة\u001c - برج البراجنة - بعبدا",
"TEL1": "03/249886",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "27106",
"com-reg-no": "2009243",
"NM": "لنكو بيطار ش م م",
"L_NM": "Lenco Bitar sarl",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "4241",
"Industrial certificate date": "5-Jul-18",
"ACTIVITY": "صناعة ابواب معدنية مقاومة للحريق",
"Activity-L": "Manufacture of armoured doors",
"ADRESS": "سنتر ايفوار\u001c - الاوتوستراد\u001c - سن الفيل - المتن",
"TEL1": "01/684698",
"TEL2": "03/740525",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "26218",
"com-reg-no": "2013532",
"NM": "الومك ش م م",
"L_NM": "Alumec sarl",
"Last Subscription": "14-Mar-18",
"Industrial certificate no": "536",
"Industrial certificate date": "8-Mar-19",
"ACTIVITY": "صناعة وتجارة منجور معدني",
"Activity-L": "Mnufavture & Trading of metallic panelling",
"ADRESS": "ملك ابي رزق ط 3\u001c - الشارع العام\u001c - غزير - كسروان",
"TEL1": "09/855657",
"TEL2": "03/624959",
"TEL3": "",
"internet": "info@alu-mec.com"
},
{
"Category": "Second",
"Number": "4121",
"com-reg-no": "65457",
"NM": "الشركة الصناعية للرخام ش م م امكو",
"L_NM": "Industrial Marble Company sarl - IMCO",
"Last Subscription": "21-Apr-17",
"Industrial certificate no": "1859",
"Industrial certificate date": "10-May-17",
"ACTIVITY": "معملا لنشر الصخور والرخام",
"Activity-L": "Cutting of rocks & marble",
"ADRESS": "ملك الشركة\u001c - الشارع العام\u001c - زبدين - جبيل",
"TEL1": "09/420522",
"TEL2": "03/225697",
"TEL3": "09/636415",
"internet": "i.m.co_marble@hotmail.com"
},
{
"Category": "First",
"Number": "5031",
"com-reg-no": "2013746",
"NM": "شركة محي الدين للتجارة والصناعة ش م م - MTC Power System",
"L_NM": "Muhieddine For Trade & Industry Co sarl - MTC Power System",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "3171",
"Industrial certificate date": "3-Oct-18",
"ACTIVITY": "تجميع مولدات كهربائية",
"Activity-L": "Gathering of electrical generators",
"ADRESS": "بناية كسرواني \u001c - كاليري سمعان - الشارع العام\u001c - الحدث - بعبدا",
"TEL1": "01/276333",
"TEL2": "01/276444",
"TEL3": "",
"internet": "info@mtcpowersystem.com"
},
{
"Category": "Third",
"Number": "26736",
"com-reg-no": "2014588",
"NM": "شركة عقاد لصناعة الشوكولا Lychee - توصية بسيطة - رفيق العقاد وشركاه",
"L_NM": "Akkad For Manufacturing Of Chocolate Lychee - Rafic Akkad & Partners",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "2894",
"Industrial certificate date": "27-Apr-18",
"ACTIVITY": "صناعة الشوكولا",
"Activity-L": "Manufacture of chocolate",
"ADRESS": "بناية الوزي 10ط1\u001c - القبة - شارع نادي كاليبسو\u001c - دوحة عرمون - عاليه",
"TEL1": "05/803362",
"TEL2": "03/201415",
"TEL3": "03/201416",
"internet": ""
},
{
"Category": "Fourth",
"Number": "20248",
"com-reg-no": "2014504",
"NM": "صايكو ستيل - Sayco Steel",
"L_NM": "Sayco Steel",
"Last Subscription": "27-Jan-18",
"Industrial certificate no": "2854",
"Industrial certificate date": "22-Apr-18",
"ACTIVITY": "تجارة الواح الزجاج",
"Activity-L": "Trading of glass sheets",
"ADRESS": "ملك الصياح\u001c - شارع مار روكز\u001c - الدكوانة - المتن",
"TEL1": "01/689588",
"TEL2": "03/611358",
"TEL3": "",
"internet": "roygeagea@saycosteel.com"
},
{
"Category": "Third",
"Number": "27063",
"com-reg-no": "2007214",
"NM": "شركة سلكتي ش م م",
"L_NM": "Selecti sarl",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "363",
"Industrial certificate date": "8-Feb-19",
"ACTIVITY": "صناعة المفروشات",
"Activity-L": "Manufacture of furniture",
"ADRESS": "سنتر روكلاند سفلي ثالث وارضي\u001c - الشارع العام\u001c - المطيلب - المتن",
"TEL1": "04/922119",
"TEL2": "",
"TEL3": "",
"internet": "msebaaly@selectidesign.com"
},
{
"Category": "Second",
"Number": "6185",
"com-reg-no": "1005260",
"NM": "بلاك بوكس ش م م",
"L_NM": "Black Box sarl",
"Last Subscription": "20-Jan-17",
"Industrial certificate no": "3398",
"Industrial certificate date": "17-Feb-18",
"ACTIVITY": "صناعة تابلوهات كهربائية",
"Activity-L": "Manufacture of electrical boards",
"ADRESS": "بناية عكر ط 1\u001c - شارع الارز\u001c - الصيفي - بيروت",
"TEL1": "01/443773",
"TEL2": "",
"TEL3": "",
"internet": "mark@blackboxcontrol.com"
},
{
"Category": "Third",
"Number": "26711",
"com-reg-no": "1007982",
"NM": "سنا سابيني كوتور ش م م",
"L_NM": "Sana Sabini Couture sarl",
"Last Subscription": "24-Feb-18",
"Industrial certificate no": "4257",
"Industrial certificate date": "7-Jul-18",
"ACTIVITY": "صناعة الالبسة النسائية",
"Activity-L": "Manufacture of ladies\' clothes",
"ADRESS": "بناية المصري - شارع المنتزه - الاشرفية - بيروت",
"TEL1": "03/812251",
"TEL2": "",
"TEL3": "",
"internet": "sana@sanasabini.com"
},
{
"Category": "Third",
"Number": "26818",
"com-reg-no": "2014814",
"NM": "شركة انتاج وتعليب المواد الغذائية ش م ل",
"L_NM": "Food Processing and Packaging Company - FPP- SAL",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "125",
"Industrial certificate date": "4-Jan-19",
"ACTIVITY": "صناعة ماء الورد والزهر،الخل، الجيلو والنشويات الغذائية",
"Activity-L": "Manufacture of orange flower water,rose water, vinegar, gelo & starches",
"ADRESS": "ملك شركة يونيفيكو ش م م\u001c - طريق بشامون - خلف محطة ضو\u001c - دير قوبل - عاليه",
"TEL1": "05/400134",
"TEL2": "03/607575",
"TEL3": "",
"internet": "nabil@fpp-lb.com"
},
{
"Category": "Third",
"Number": "26268",
"com-reg-no": "2013277",
"NM": "القدوم للتجارة ش م م",
"L_NM": "Al Kaddoum Pour Le Commerce sarl",
"Last Subscription": "28-Feb-18",
"Industrial certificate no": "431",
"Industrial certificate date": "22-Feb-19",
"ACTIVITY": "معملا لفرز وتعبئة العسل",
"Activity-L": "Factory for filling honey",
"ADRESS": "ملك االقدوم للتجارة ش م م \u001c - الطريق العام\u001c - الكفر - جبيل",
"TEL1": "09/739042",
"TEL2": "03/701740",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "26266",
"com-reg-no": "3573",
"NM": "كولورتكس - بابيك إخوان",
"L_NM": "Colortex -Babik Freres",
"Last Subscription": "27-Jan-18",
"Industrial certificate no": "4877",
"Industrial certificate date": "15-Nov-18",
"ACTIVITY": "معملا لتحضير وطبع الاقمشة",
"Activity-L": "Preparing & printing on textiles",
"ADRESS": "ملك بابيك اخوان\u001c - طريق يسوع الملك - المدينة الصناعية\u001c - زوق مصبح - كسروان",
"TEL1": "09/218486",
"TEL2": "09/218487",
"TEL3": "",
"internet": "info@colortexbf.com"
},
{
"Category": "Second",
"Number": "5081",
"com-reg-no": "1007843",
"NM": "قرطاسية الترك ش م ل",
"L_NM": "Turk Stationery sal",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "216",
"Industrial certificate date": "17-Jan-19",
"ACTIVITY": "تجارة جملة القرطاسية",
"Activity-L": "Wholesale of stationery",
"ADRESS": "بناية ميرا ط ارضي وسفلي اول\u001c - شارع الامام الشافعي\u001c - المصيطبة - بيروت",
"TEL1": "01/386623",
"TEL2": "03/631400",
"TEL3": "",
"internet": "wassim@turkstationary.com"
},
{
"Category": "First",
"Number": "4716",
"com-reg-no": "2012016",
"NM": "زيدان ش م ل",
"L_NM": "Zaidan sal",
"Last Subscription": "22-Apr-17",
"Industrial certificate no": "4891",
"Industrial certificate date": "16-Nov-18",
"ACTIVITY": "اشغال وصناعة المنشأت المعدنية",
"Activity-L": "Construction & manufacture of metallic structure",
"ADRESS": "ملك شركة زيدان هوس سيكوم ش م ل\u001c - الوادي الصناعي\u001c - عين سعاده - المتن",
"TEL1": "01/878714",
"TEL2": "01/878715+16",
"TEL3": "03/680380",
"internet": "info@zaidan.com"
},
{
"Category": "Third",
"Number": "27138",
"com-reg-no": "2015074",
"NM": "شركة كميكو للهندسة الميكانيكية ش م م",
"L_NM": "Chemico Mechanical Engineering sarl C.M.E sarl",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "2293",
"Industrial certificate date": "4-Feb-18",
"ACTIVITY": "صناعة الحدادة الافرنجية، مفروشات معدنية وتجارة منجور معدني",
"Activity-L": " Manufacture of smithery, metallic furniture & trading of whittled metal",
"ADRESS": "بناية جوزف خوري - ملك حاتم\u001c - مارتقلا - شارع السفارة الليبية\u001c - الحازمية - بعبدا",
"TEL1": "05/454624",
"TEL2": "05/454292",
"TEL3": "03/277447",
"internet": "engineering@chemicosarl.com"
},
{
"Category": "Third",
"Number": "26984",
"com-reg-no": "63134",
"NM": "بست متال - توصية بسيطة",
"L_NM": "Best Metal",
"Last Subscription": "20-Jan-18",
"Industrial certificate no": "2802",
"Industrial certificate date": "7-Nov-17",
"ACTIVITY": "معملا للحدادة",
"Activity-L": "Wholesale of metallic furniture & supplies for supermarkets",
"ADRESS": "سنتر سجعان الصناعي\u001c - مار روكز\u001c - الدكوانة - المتن",
"TEL1": "01/685028",
"TEL2": "01/685033",
"TEL3": "03/666614",
"internet": "bestmetal@cyberia.net.lb"
},
{
"Category": "Second",
"Number": "5211",
"com-reg-no": "2013685",
"NM": "زينا لاين ش م م",
"L_NM": "Zina Line sarl",
"Last Subscription": "28-Feb-18",
"Industrial certificate no": "1621",
"Industrial certificate date": "1-Apr-17",
"ACTIVITY": "صناعة المفروشات",
"Activity-L": "Manufacture of furniture",
"ADRESS": "ملك وقف دير سيدة الحقلة دلبتا\u001c - الاوتوستراد\u001c - مستيتا - جبيل",
"TEL1": "09/796970",
"TEL2": "09/796971",
"TEL3": "",
"internet": "lara.sfeir@zinaline.com"
},
{
"Category": "Third",
"Number": "27123",
"com-reg-no": "70307",
"NM": "شركة كريستالينا ش م م",
"L_NM": "Cristalina Co. sarl",
"Last Subscription": "31-Aug-17",
"Industrial certificate no": "4442",
"Industrial certificate date": "7-Aug-18",
"ACTIVITY": "صناعة مكعبات الثلج",
"Activity-L": "Manufacture of ice cubes",
"ADRESS": "سنتر روني ابو غزالة\u001c - شارع شركة الكهرباء\u001c - المجذوب - المتن",
"TEL1": "04/713633",
"TEL2": "03/346787",
"TEL3": "03/856514",
"internet": ""
},
{
"Category": "First",
"Number": "5131",
"com-reg-no": "76268",
"NM": "شركة مطاحن البركة ش م ل",
"L_NM": "Barake Mills sal",
"Last Subscription": "2-Feb-17",
"Industrial certificate no": "2256",
"Industrial certificate date": "30-Jan-18",
"ACTIVITY": "مطحنة الية للحبوب",
"Activity-L": " Milling of cereals",
"ADRESS": "سنتر دولفين\u001c - شارع شوران\u001c - الروشة - بيروت",
"TEL1": "01/902835",
"TEL2": "",
"TEL3": "",
"internet": "info@barakamill.com"
},
{
"Category": "Second",
"Number": "5136",
"com-reg-no": "1802106",
"NM": "استروفيزيكس ميدل ايست ش م ل - اوف شور",
"L_NM": "Astrophysics Middle East sal - Offshore",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4638",
"Industrial certificate date": "5-May-16",
"ACTIVITY": "شركة اوف شور",
"Activity-L": "Offshore Company",
"ADRESS": "سنتر ابي نصر ط 2\u001c - شارع الملعب البلدي\u001c - حارة صخر - كسروان",
"TEL1": "09/832500",
"TEL2": "09/832503",
"TEL3": "",
"internet": "edib@astrophysicsme.com"
},
{
"Category": "Third",
"Number": "27339",
"com-reg-no": "2011728",
"NM": "شركة مياه يانوح ش م م",
"L_NM": "Yanouh Natural Water sarl",
"Last Subscription": "22-Aug-17",
"Industrial certificate no": "4182",
"Industrial certificate date": "22-Jun-18",
"ACTIVITY": "تجارة وتوزيع المياه ضمن اوعية خاصة",
"Activity-L": "Trading of water with special contaniers",
"ADRESS": "ملك البعيني\u001c - شارع مار تقلا\u001c - يانوح - جبيل",
"TEL1": "09/542897",
"TEL2": "03/446262",
"TEL3": "",
"internet": "omarbeaini@gmail.com"
},
{
"Category": "Third",
"Number": "26181",
"com-reg-no": "70531",
"NM": "الجيكو ش م م",
"L_NM": "Algeco sarl Aluminium Glazing Engineering & Contracting Company sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "4947",
"Industrial certificate date": "28-Nov-18",
"ACTIVITY": "صناعة وتجارة منجور معدني",
"Activity-L": "Manufacture & trading of metllic panelling",
"ADRESS": "ملك روبير ايوب\u001c - المدينة الصناعية\u001c - روميه - المتن",
"TEL1": "01/873232",
"TEL2": "01/876087",
"TEL3": "03/823334",
"internet": "info@algecoltd.com"
},
{
"Category": "Third",
"Number": "25960",
"com-reg-no": "2012896",
"NM": "دجاست انجل",
"L_NM": "Just Angel",
"Last Subscription": "6-Mar-17",
"Industrial certificate no": "2856",
"Industrial certificate date": "17-May-17",
"ACTIVITY": "تجارة جملة الملبوسات النسائية",
"Activity-L": "Wholesale of ladies\' clothes",
"ADRESS": "سنتر نور ملك عبده\u001c - شارع العسيلي\u001c - سد البوشرية - المتن",
"TEL1": "01/886899",
"TEL2": "03/116899",
"TEL3": "",
"internet": "e_iverson83@hotmail.com"
},
{
"Category": "First",
"Number": "4800",
"com-reg-no": "1491",
"NM": "اميرزيان - سيران دوفينيـسي",
"L_NM": "Emirzian - La Sirene De Phoenicie",
"Last Subscription": "14-Mar-17",
"Industrial certificate no": "3559",
"Industrial certificate date": "8-Mar-18",
"ACTIVITY": "صناعة البياضات النسائية",
"Activity-L": "Manufacture of ladies lingery",
"ADRESS": "ملك اندون اميرزيان\u001c - شارع السيدة\u001c - سن الفيل - المتن",
"TEL1": "01/500865",
"TEL2": "01/483791",
"TEL3": "01/491428",
"internet": "syrene@idm.net.lb"
},
{
"Category": "Second",
"Number": "6630",
"com-reg-no": "2033098",
"NM": "لاسيكال لبنان ش م ل",
"L_NM": "La Cigale Lebanon sal",
"Last Subscription": "8-Mar-18",
"Industrial certificate no": "468",
"Industrial certificate date": "26-Feb-19",
"ACTIVITY": "صناعة الحلويات العربية والافرنجية",
"Activity-L": "Manufacture of sweets",
"ADRESS": "بناية فندق لاسيكال\u001c - اوتوستراد طرابلس\u001c - وطى عمارة شلهوب - المتن",
"TEL1": "03/244452",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "20511",
"com-reg-no": "2000934",
"NM": "مؤسسة قربان",
"L_NM": "Korban Est",
"Last Subscription": "29-Aug-17",
"Industrial certificate no": "3486",
"Industrial certificate date": "27-Feb-18",
"ACTIVITY": "تجارة المنجور والمطابخ الخشبية",
"Activity-L": "Trading of Wooden Carpentry & Kitchen Furniture",
"ADRESS": "ملك بطرس وايلي قربان\u001c - الشارع العام\u001c - عين السنديانة - المتن",
"TEL1": "03/303928",
"TEL2": "03/707324",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1787",
"com-reg-no": "1008517",
"NM": "ابيض غروب ش م ل",
"L_NM": "Abiad Group sal",
"Last Subscription": "15-Jan-18",
"Industrial certificate no": "4088",
"Industrial certificate date": "7-Jun-18",
"ACTIVITY": "صناعة السكاكر والشوكولا وتجارة جملة اواني ومواد اولية لصنع الحلويات",
"Activity-L": "manuf. of candies & chocolate & Wholesale of glassware& materials of sweets",
"ADRESS": "بناية سعاده وعيتاني ط7\u001c - شارع المكاوي\u001c - قصقص - بيروت",
"TEL1": "01/856250",
"TEL2": "01/856247+9",
"TEL3": "03/635664",
"internet": "accounting@abiadgroup.com"
},
{
"Category": "Second",
"Number": "4979",
"com-reg-no": "2012733",
"NM": "كالكو ستيل ش م ل",
"L_NM": "Kalco Steel sal",
"Last Subscription": "30-Jan-18",
"Industrial certificate no": "222",
"Industrial certificate date": "18-Jan-19",
"ACTIVITY": "صناعة معدات صناعية واشغال معدنية",
"Activity-L": "Manufacture of industrial machinery & metallic carpentery",
"ADRESS": "ملك كلوغليان\u001c - الشارع العام\u001c - روميه - المتن",
"TEL1": "01/877718",
"TEL2": "01/877719",
"TEL3": "01/877723",
"internet": "info@kalcosteel.com"
},
{
"Category": "Second",
"Number": "5022",
"com-reg-no": "1802631",
"NM": "الشركة الدولية للتجارة والتعهدات الميكانيكية ش م ل اوف شور",
"L_NM": "Mechanical Trading And Contracting International M T C I sal Offshore",
"Last Subscription": "27-Apr-17",
"Industrial certificate no": "5022",
"Industrial certificate date": "24-Dec-13",
"ACTIVITY": "شركة اوف شور",
"Activity-L": "Offshore company",
"ADRESS": "ملك ايلي خاطر\u001c - الشارع العام\u001c - قرنة شهوان - المتن",
"TEL1": "03/610247",
"TEL2": "",
"TEL3": "",
"internet": "eliekhater@hotmail.com"
},
{
"Category": "Second",
"Number": "5903",
"com-reg-no": "38229",
"NM": "مؤسسة شربل نصر - البان واجبان اللقلوق",
"L_NM": "Charbel Nasr Est - Laklouk Dairies",
"Last Subscription": "11-Jul-17",
"Industrial certificate no": "4212",
"Industrial certificate date": "30-Jun-18",
"ACTIVITY": "صناعة الالبان والاجبان",
"Activity-L": "Manufacture of dairy products",
"ADRESS": "ملك شربل نصر\u001c - طريق مار شربل - شارع زغيب\u001c - حبوب - جبيل",
"TEL1": "09/946431",
"TEL2": "81/314001",
"TEL3": "03/278431",
"internet": "lakloukdairies@hotmail.com"
},
{
"Category": "Third",
"Number": "26166",
"com-reg-no": "2013049",
"NM": "مجموعة نصر للتجارة ش م م",
"L_NM": "Nasr Trading Group sarl",
"Last Subscription": "1-Feb-17",
"Industrial certificate no": "2471",
"Industrial certificate date": "25-Aug-17",
"ACTIVITY": "تجارة مواد غذائية وبهارات",
"Activity-L": "wholesale of food products and spices",
"ADRESS": "ملك نصر -\u001c - حي المير\u001c - زوق مكايل - كسروان",
"TEL1": "09/214319",
"TEL2": "03/217082",
"TEL3": "",
"internet": "elienasr68@yahoo.com"
},
{
"Category": "Second",
"Number": "5018",
"com-reg-no": "1006477",
"NM": "شركة نوكاتيني انترناشيونال ش م ل",
"L_NM": "Nougatini International sal",
"Last Subscription": "24-Jan-18",
"Industrial certificate no": "3648",
"Industrial certificate date": "21-Mar-18",
"ACTIVITY": "صناعة الشوكولا",
"Activity-L": "Manufacture of chocolate",
"ADRESS": "بناية قرطاس\u001c - شارع البصرة\u001c - الحمراء - بيروت",
"TEL1": "03/585728",
"TEL2": "01/343759",
"TEL3": "",
"internet": "info@nougatini.com"
},
{
"Category": "Second",
"Number": "6049",
"com-reg-no": "2012232",
"NM": "شركة ايسكو للتجارة والصناعة - تضامن",
"L_NM": "Iskco for Trading and Manufacturing",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4625",
"Industrial certificate date": "19-Sep-18",
"ACTIVITY": "صناعة السكاكر والشوكولا",
"Activity-L": "Manufacture of candies & chocolate",
"ADRESS": "بناية زحم\u001c - حي الميدان\u001c - مزرعة يشوع - المتن",
"TEL1": "04/918856",
"TEL2": "03/305807",
"TEL3": "",
"internet": "info@iskco-crumble.com"
},
{
"Category": "Second",
"Number": "5021",
"com-reg-no": "2011809",
"NM": "مايند ووركس ش م ل",
"L_NM": "Mind works sal",
"Last Subscription": "20-Jan-17",
"Industrial certificate no": "1112",
"Industrial certificate date": "23-Dec-17",
"ACTIVITY": "صناعة ستاندات عرض",
"Activity-L": "Manufacture of show stands",
"ADRESS": "ملك رافي كلوغليان\u001c - الشارع العام\u001c - روميه - المتن",
"TEL1": "01/899950",
"TEL2": "01/898409",
"TEL3": "",
"internet": "lina.francis@themindgroup.com"
},
{
"Category": "Second",
"Number": "4199",
"com-reg-no": "2010631",
"NM": "محمصة عصمت ابي نصر ش م ل",
"L_NM": "Roastery Ismat Abi Nasr sal",
"Last Subscription": "28-Apr-17",
"Industrial certificate no": "2512",
"Industrial certificate date": "2-Sep-17",
"ACTIVITY": "محمصة بزورات",
"Activity-L": "Roastery of mixed nuts",
"ADRESS": "ملك ابي نصر\u001c - ساحة ملعب فؤاد شهاب\u001c - حارة صخر - كسروان",
"TEL1": "09/901111",
"TEL2": "03/292984",
"TEL3": "",
"internet": "info@abinasrroastery.com"
},
{
"Category": "First",
"Number": "4708",
"com-reg-no": "2012371",
"NM": "ريجنسي ش م ل",
"L_NM": "Regency sal",
"Last Subscription": "9-Oct-17",
"Industrial certificate no": "4644",
"Industrial certificate date": "29-Sep-18",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "بناية ريجنسي\u001c - الشارع العام - قرب افران يني\u001c - المكلس - المتن",
"TEL1": "01/684386",
"TEL2": "01/684387",
"TEL3": "",
"internet": "info@regencyfurniture-lb.com"
},
{
"Category": "Third",
"Number": "22661",
"com-reg-no": "2001176",
"NM": "فيرفي للتجارة العامة والصناعة",
"L_NM": "Vervie for General Trade & Industry",
"Last Subscription": "7-Apr-17",
"Industrial certificate no": "3184",
"Industrial certificate date": "20-Jan-18",
"ACTIVITY": "صناعة مستحضرات التجميل",
"Activity-L": "Manufacture of cosmetic products",
"ADRESS": "ملك عماد ابو ضرغم\u001c - شارع الخلي\u001c - دميت - الشوف",
"TEL1": "05/720296",
"TEL2": "03/387164",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "4627",
"com-reg-no": "1006399",
"NM": "شركة عبد القادر عمر غندور واولاده ش م ل",
"L_NM": "Abdel Kader Omar Ghandour & Sons sal",
"Last Subscription": "22-Apr-17",
"Industrial certificate no": "3974",
"Industrial certificate date": "16-May-18",
"ACTIVITY": "صناعة الحلاوة والطحينة والراحة والسمسمية",
"Activity-L": "Manufacture of halawa & tahina & turkish delight & sesame",
"ADRESS": "ملك العجوز وشامات\u001c - بولفار صائب سلام\u001c - كورنيش المزرعة - بيروت",
"TEL1": "01/545331",
"TEL2": "01/273649",
"TEL3": "",
"internet": "ghandou.lb@gmail.com"
},
{
"Category": "Third",
"Number": "26663",
"com-reg-no": "2013338",
"NM": "بولس غروب ستونز ش م ل",
"L_NM": "Boulos Group stones sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4000",
"Industrial certificate date": "18-May-18",
"ACTIVITY": "نشر وتفصيل الصخور",
"Activity-L": "Cutting & shaping of rocks",
"ADRESS": "ملك توفيق وكميل بولس\u001c - الشارع العام\u001c - قرنة الحمرا - المتن",
"TEL1": "01/317287",
"TEL2": "04/930029",
"TEL3": "03/694555",
"internet": "info@boulosgroup.com"
},
{
"Category": "Third",
"Number": "27324",
"com-reg-no": "2011898",
"NM": "ج . ساروفيم ش م م طباعة وتغليف",
"L_NM": "J. Saroufim sarl Printing & Converting",
"Last Subscription": "20-Jan-18",
"Industrial certificate no": "4424",
"Industrial certificate date": "3-Aug-18",
"ACTIVITY": "مطبعة لطباعة الطلاحي الورقية والكرتونية المختلفة",
"Activity-L": "Printing press",
"ADRESS": "سنتر صفير\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/497238",
"TEL2": "01/497241",
"TEL3": "",
"internet": "info@jsaroufim.com"
},
{
"Category": "Second",
"Number": "5124",
"com-reg-no": "74751",
"NM": "رفاعي فودز ش م ل",
"L_NM": "Rifai Foods sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "3584",
"Industrial certificate date": "11-Mar-18",
"ACTIVITY": "محمصة بزورات وبن",
"Activity-L": "Roastery of mixed nuts & coffee",
"ADRESS": "بناية محمصة الرفاعي\u001c - كورنيش المزرعة\u001c - المزرعة - بيروت",
"TEL1": "01/707107",
"TEL2": "01/702220",
"TEL3": "03/669000",
"internet": "samia.alom@alrifai.com"
},
{
"Category": "Second",
"Number": "6308",
"com-reg-no": "2013376",
"NM": "شركة حاج ارت ستون ش م م",
"L_NM": "Hajj Art Stone sarl",
"Last Subscription": "30-Mar-17",
"Industrial certificate no": "2672",
"Industrial certificate date": "23-Mar-18",
"ACTIVITY": "معمل احجار باطون",
"Activity-L": "Manufacture of concrete stones",
"ADRESS": "بناية الحاج\u001c - شارع البلدية - قرب بنك بيروت\u001c - المنصورية - المتن",
"TEL1": "04/401725",
"TEL2": "04/401765",
"TEL3": "03/240218",
"internet": "georges@hajjartstone.com"
},
{
"Category": "Third",
"Number": "27537",
"com-reg-no": "2011907",
"NM": "جراماك ش م م",
"L_NM": "Gramak sarl",
"Last Subscription": "11-May-17",
"Industrial certificate no": "3930",
"Industrial certificate date": "6-May-18",
"ACTIVITY": "فرن للخبز",
"Activity-L": "Bakery",
"ADRESS": "ملك ريشار عضيمي\u001c - الاوتوستراد - قرب محمصة ابي عاد\u001c - صربا - كسروان",
"TEL1": "09/838811",
"TEL2": "09/838822",
"TEL3": "71/179279",
"internet": "sarba@moulindor.com"
},
{
"Category": "Third",
"Number": "27310",
"com-reg-no": "1002397",
"NM": "شركة بليسينغ ش م م",
"L_NM": "Blessing sarl",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "4546",
"Industrial certificate date": "28-Aug-18",
"ACTIVITY": "صناعة لوازم زينة الشوكولا والهدايا",
"Activity-L": "Manufacture of ornament for chocolate & gifts",
"ADRESS": "بناية ايفوار\u001c - شارع موسى نمور - خلف السفارة الصينية\u001c - الجناح - بيروت",
"TEL1": "01/848111",
"TEL2": "03/695571",
"TEL3": "03/266606",
"internet": "rana@blessing.com.lb"
},
{
"Category": "Second",
"Number": "5119",
"com-reg-no": "2013282",
"NM": "شركة جورج روزفلت فتوح ش م ل",
"L_NM": "George Roosevilt Fattouh sal",
"Last Subscription": "15-Feb-18",
"Industrial certificate no": "104",
"Industrial certificate date": "27-Jun-18",
"ACTIVITY": "تقطيع ورق السلوفان لزوم السكاكر والحلويات وجملة مواد اولية لصنع الحلويات",
"Activity-L": "Cutting of Cellophane papers&whole.of primary materials for sweets",
"ADRESS": "بناية جورجيت فارس ط سفلي\u001c - القلعة - شارع الاتحاد\u001c - سن الفيل - المتن",
"TEL1": "01/494497",
"TEL2": "01/694794",
"TEL3": "03/338563",
"internet": "info@gfattouh.com"
},
{
"Category": "First",
"Number": "4671",
"com-reg-no": "2014983",
"NM": "شركة فونيكس انرجي ش م ل",
"L_NM": "Phoenix Energy sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4990",
"Industrial certificate date": "6-Jun-18",
"ACTIVITY": "تجارة جملة المولدات الكهربائية",
"Activity-L": "Wholesale of electrical generators",
"ADRESS": "بناية اندفكو\u001c - تلة العصافير - الشارع العام\u001c - عجلتون - كسروان",
"TEL1": "09/230130",
"TEL2": "09/855691+2",
"TEL3": "09/855693+4",
"internet": "energy@phoenixlb.com"
},
{
"Category": "Third",
"Number": "26945",
"com-reg-no": "2015012",
"NM": "شركة قصقص - سليم وعمر قصقص وشركاهما - قصقص - توصية بسيطة",
"L_NM": "Kaskas Co - Kaskas",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4316",
"Industrial certificate date": "15-Jul-18",
"ACTIVITY": "تجارة جملة اقمشة الملبوسات والمفروشات والتطريز على الالبسة والاقمشة",
"Activity-L": "Wholesale of textiles for clohtes & furniture & embrioiders",
"ADRESS": "بناية ديالا \u001c - الجناح - شارع عدنان الحكيم\u001c - بئر حسن - بعبدا",
"TEL1": "01/820333",
"TEL2": "01/821333",
"TEL3": "03/894267",
"internet": "kaskas@kaskasco.com"
},
{
"Category": "Third",
"Number": "26947",
"com-reg-no": "1009817",
"NM": "شركة احمد عماد بكري - بي بلاس -  ش م ل",
"L_NM": "Ahmad Imad Bakri - B Plus - sal",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "54",
"Industrial certificate date": "19-Dec-18",
"ACTIVITY": "صناعة معدات ولوازم المخابز",
"Activity-L": "Manufacture of bakeries\'equipments",
"ADRESS": "بناية مكحل ط 7\u001c - شارع مار الياس\u001c - المصيطبة - بيروت",
"TEL1": "01/739777",
"TEL2": "05/811572+3",
"TEL3": "03/723656",
"internet": "info@bplus.com.lb"
},
{
"Category": "First",
"Number": "5207",
"com-reg-no": "46324",
"NM": "شركة تكنوركس - رنه لبكي وشركاه - شركة توصية بسيطة",
"L_NM": "Technorex Co",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "134",
"Industrial certificate date": "4-Jan-19",
"ACTIVITY": "تجارة جملة اجهزة LCD وشاشات كمبيوتر وتحضير الحبر للطباعة",
"Activity-L": "Wholesale of LCD& computer screens & preparing of printing inks",
"ADRESS": "بناية هنري الحداد\u001c - حي النعص - الشارع الرئيسي\u001c - روميه - المتن",
"TEL1": "04/865965",
"TEL2": "04/862286",
"TEL3": "",
"internet": "techcom@cyberia.net.lb"
},
{
"Category": "Third",
"Number": "25841",
"com-reg-no": "2009328",
"NM": "كادانا ش م م",
"L_NM": "Kadana sarl",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "3684",
"Industrial certificate date": "24-Mar-18",
"ACTIVITY": "تنفيذ تعهدات الهندسة المدنية ومعملا لصب المعادن ( اغطية ريغارات)",
"Activity-L": " Civil engineering contracting & Factory for casing of metals",
"ADRESS": "بناية كادانا ش م م\u001c - المدينة الصناعية\u001c - رومية - المتن",
"TEL1": "01/261137",
"TEL2": "01/900833",
"TEL3": "03/583832",
"internet": "kadana@kadana-sarl.com"
},
{
"Category": "Excellent",
"Number": "1779",
"com-reg-no": "60167",
"NM": "ام. اس. سي ش م ل",
"L_NM": "M.S.C sal",
"Last Subscription": "8-Nov-17",
"Industrial certificate no": "2880",
"Industrial certificate date": "21-Nov-17",
"ACTIVITY": "صناعة الباطون الجاهز",
"Activity-L": "Production of ready concrete",
"ADRESS": "ملك ابو جودة\u001c - الطريق العام\u001c - جورة البلوط - المتن",
"TEL1": "04/925888",
"TEL2": "04/806222",
"TEL3": "04/806333",
"internet": "msc@mouawadgroup.com"
},
{
"Category": "Third",
"Number": "25844",
"com-reg-no": "2011712",
"NM": "شركة لافايت ابولستري اند ديزين ش م م",
"L_NM": "La Fayette Upholstery & Design sarl",
"Last Subscription": "23-Feb-18",
"Industrial certificate no": "4281",
"Industrial certificate date": "11-Jul-18",
"ACTIVITY": "تنجيد المفروشات",
"Activity-L": "Upholstery of furniture",
"ADRESS": "سنتر سان روك\u001c - جسر الباشا - الشارع العام\u001c - حازمية - بعبدا",
"TEL1": "05/450974",
"TEL2": "03/509275",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "26140",
"com-reg-no": "2001310",
"NM": "عواضه وود لاين ش م م",
"L_NM": "Awada Woodline Ltd",
"Last Subscription": "18-Feb-17",
"Industrial certificate no": "1325",
"Industrial certificate date": "22-Aug-16",
"ACTIVITY": "تجارة جملة المفروشات الخشبية",
"Activity-L": "Wholesale of wooden furniture",
"ADRESS": "ملك عواضه\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/480001",
"TEL2": "03/881121",
"TEL3": "",
"internet": "info@awadawoodline.com"
},
{
"Category": "Third",
"Number": "26142",
"com-reg-no": "2011631",
"NM": "4A Concept sarl",
"L_NM": "4A Concept sarl",
"Last Subscription": "21-Jan-17",
"Industrial certificate no": "3935",
"Industrial certificate date": "6-Aug-17",
"ACTIVITY": "تجارة المفروشات الخشبية",
"Activity-L": "Trading of wooden funriture",
"ADRESS": "ملك شركة A4 Concept sarl\u001c - الشارع العام\u001c - زوق مصبح- كسروان",
"TEL1": "03/234428",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "4948",
"com-reg-no": "2008657",
"NM": "كونستركت كومباني ش م ل",
"L_NM": "Construct Company sal",
"Last Subscription": "18-Jul-17",
"Industrial certificate no": "3503",
"Industrial certificate date": "28-Feb-18",
"ACTIVITY": "صناعة المفروشات والمطابخ وتفصيل الواح الاخشاب",
"Activity-L": "Manufacture of furniture & kitchens & sawmilling of wood",
"ADRESS": "بناية حريز ط سفلي 1\u001c - الشارع العام\u001c - المكلس - المتن",
"TEL1": "01/681322",
"TEL2": "03/243702",
"TEL3": "",
"internet": "construct.lb@gmail.com"
},
{
"Category": "Excellent",
"Number": "1385",
"com-reg-no": "2010795",
"NM": "المشرق للعصير والالبان للصناعة ش م ل",
"L_NM": "Levant Beverage & Dairy Industries - LBDI sal",
"Last Subscription": "24-Jan-18",
"Industrial certificate no": "4645",
"Industrial certificate date": "29-Sep-18",
"ACTIVITY": "صناعة الالبان والاجبان وتجارة جملة المرطبات بنكهات مختلفة",
"Activity-L": "Manufacture of dairy products & Wholesale of soft drinks",
"ADRESS": "ملك غندور\u001c - شارع فيلمون وهبي\u001c - كفرشيما - بعبدا",
"TEL1": "05/463777",
"TEL2": "05/437135",
"TEL3": "",
"internet": "dairyday@dairyday.com"
},
{
"Category": "Second",
"Number": "5839",
"com-reg-no": "49633",
"NM": "مؤسسة كوثراني التجارية Cremino كريمينو 2",
"L_NM": "Cremino 2",
"Last Subscription": "18-Jan-17",
"Industrial certificate no": "365",
"Industrial certificate date": "30-Dec-16",
"ACTIVITY": "صناعة وتجارة الحلويات العربية والافرنجية",
"Activity-L": "Manufacture & Trading of oriental & western sweets",
"ADRESS": "بناية كوثراني\u001c - طريق المطار - مدخل حارة حريك\u001c - الغبيري - بعبدا",
"TEL1": "01/453800",
"TEL2": "76/643643",
"TEL3": "03/332737",
"internet": "marketing@cremino-intl.com"
},
{
"Category": "Third",
"Number": "26431",
"com-reg-no": "1002265",
"NM": "شركة ترك باك ش م م",
"L_NM": "Turk Pack Co. sarl",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4287",
"Industrial certificate date": "11-Jul-18",
"ACTIVITY": "مصنعا للطباعة والتغليف والامبلاج",
"Activity-L": "Manufacture for printing & packing",
"ADRESS": "بناية الريحان\u001c - شارع عبد المولى الشعار\u001c - رأس النبع - بيروت",
"TEL1": "03/652617",
"TEL2": "03/695300",
"TEL3": "",
"internet": "turkpack@hotmail.com"
},
{
"Category": "First",
"Number": "4310",
"com-reg-no": "1007237",
"NM": "بطل ديزاين ش م ل",
"L_NM": "Batal Design sal",
"Last Subscription": "21-Jan-17",
"Industrial certificate no": "2759",
"Industrial certificate date": "3-Apr-18",
"ACTIVITY": "تجارة المفروشات الخشبية والثريات",
"Activity-L": "Trading of furniture & chandeliers",
"ADRESS": "اونيسكو هوم سنتر\u001c - الشارع العام\u001c - الاونيسكو- بيروت",
"TEL1": "01/804803",
"TEL2": "03/800456",
"TEL3": "03/599922",
"internet": ""
},
{
"Category": "Third",
"Number": "26108",
"com-reg-no": "43611",
"NM": "مؤسسة الفغالي للتجارة العامة",
"L_NM": "Feghali General Trade Est.",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "4669",
"Industrial certificate date": "4-Oct-18",
"ACTIVITY": "معملا لصب احجار الباطون",
"Activity-L": "Manufacture of concrete stones",
"ADRESS": "ملك وقف كنيسة سيدة الحدث  \u001c - شارع سان جورج\u001c - الحدث - بعبدا",
"TEL1": "03/660989",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1593",
"com-reg-no": "2004215",
"NM": "الشركة المتحدة لصناعة وطباعة مواد التعبئة والتغليف ش م م",
"L_NM": "United Company For Printing & Packaging sarl - UCPP sarl",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4497",
"Industrial certificate date": "16-Aug-18",
"ACTIVITY": "صناعة رولو نايلون للتعبئة والتغليف والتوضيب",
"Activity-L": "Manufacture of nylon roll for filling & packing",
"ADRESS": "ملك عبد الله\u001c - شارع المتحد\u001c - بحمدون - عاليه",
"TEL1": "05/559859",
"TEL2": "05/555187",
"TEL3": "05/559759",
"internet": "ucpp@ucpp.net"
},
{
"Category": "Second",
"Number": "4895",
"com-reg-no": "69453",
"NM": "سي بي في العقارية ش م ل",
"L_NM": "C B V Immobilière sal",
"Last Subscription": "4-Mar-17",
"Industrial certificate no": "2821",
"Industrial certificate date": "11-Nov-17",
"ACTIVITY": "صناعة النبيذ والخل",
"Activity-L": "Manufacture of wine & vinegar",
"ADRESS": "ملك عبد النور\u001c - الشارع العام\u001c - بحمدون الضيعة - عاليه",
"TEL1": "03/221205",
"TEL2": "05/261512",
"TEL3": "",
"internet": "jill@chateaubelle-vue.com"
},
{
"Category": "Second",
"Number": "4896",
"com-reg-no": "2008726",
"NM": "شركة اي نتورك اوتومايشن ش م ل",
"L_NM": "I. Network Automation sal",
"Last Subscription": "19-Sep-17",
"Industrial certificate no": "4641",
"Industrial certificate date": "22-Sep-18",
"ACTIVITY": "تجميع البلاكات والتابلوهات الكهربائية لزوم المولدات والمعدات الصناعية",
"Activity-L": "Assorting of electrical plaques & boards",
"ADRESS": "بناية يونايتد انشورنس\u001c - الشارع العام\u001c - البوشرية - المتن",
"TEL1": "01/249562",
"TEL2": "01/249563",
"TEL3": "03/820230",
"internet": "info@inetlb.com"
},
{
"Category": "First",
"Number": "4886",
"com-reg-no": "2011040",
"NM": "المنيوم شومان ش م م",
"L_NM": "Chouman Aluminium sarl",
"Last Subscription": "19-Jan-17",
"Industrial certificate no": "3059",
"Industrial certificate date": "3-Jan-18",
"ACTIVITY": "صناعة المنجورات وواجهات المينيوم",
"Activity-L": "Manufacture of aluminium panelling",
"ADRESS": "بناية ابو طعان وحكيم\u001c - حي الاميركان\u001c - الحدث - بعبدا",
"TEL1": "01/545815",
"TEL2": "01/545816",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "5952",
"com-reg-no": "2009723",
"NM": "هاشم إندستري اند ترايدينغ غروب ش م م",
"L_NM": "Hachem Industry & Trading Group sarl (Hintrag)",
"Last Subscription": "24-Feb-18",
"Industrial certificate no": "4504",
"Industrial certificate date": "18-Aug-18",
"ACTIVITY": "معملا لخلط ومزج وتعبئة بودرة الشراب",
"Activity-L": "Mixing & filing of powder for beverages",
"ADRESS": "ملك الهاشم\u001c - شارع البدوي\u001c - زوق مصبح - كسروان",
"TEL1": "03/495274",
"TEL2": "09/213045",
"TEL3": "09/213046",
"internet": "info@hintrag.com"
},
{
"Category": "Third",
"Number": "26365",
"com-reg-no": "1006467",
"NM": "نضركو ش م م",
"L_NM": "Nadarco sarl",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "4904",
"Industrial certificate date": "21-Nov-18",
"ACTIVITY": "مصنعا للطباعة على أكياس الورق وأوراق الصر",
"Activity-L": "Printing on paper Bags",
"ADRESS": "سنتر النجاح\u001c - شارع مار الياس\u001c - كركول الدروز - بيروت",
"TEL1": "05/905961",
"TEL2": "03/934323",
"TEL3": "03/275240",
"internet": "nadarco@gmail.com"
},
{
"Category": "Third",
"Number": "26369",
"com-reg-no": "1000083",
"NM": "شركة سي اي ش م م",
"L_NM": "C A sarl",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "4304",
"Industrial certificate date": "14-Jul-18",
"ACTIVITY": "تصميم الاعلانات الدعائية - وتصنيع افلام وبلاكتات للطباعة",
"Activity-L": "Advertising services & manufacture of films & plaques for printing",
"ADRESS": "سنتر الصباح\u001c - كورنيش المزرعة\u001c - المزرعة - بيروت",
"TEL1": "01/304444",
"TEL2": "01/815678",
"TEL3": "",
"internet": "mad@ca.com.lb"
},
{
"Category": "First",
"Number": "5148",
"com-reg-no": "2010680",
"NM": "مصانع معتوق ش م ل",
"L_NM": "Maatouk Factories sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4972",
"Industrial certificate date": "4-Dec-18",
"ACTIVITY": "طحن وتعبئة البن",
"Activity-L": "Coffee processing",
"ADRESS": "ملك شركة جواد معتوق وشركاه\u001c - المدينة الصناعية\u001c - بشامون - عاليه",
"TEL1": "05/801133",
"TEL2": "05/800143",
"TEL3": "",
"internet": "info@maatouk.com"
},
{
"Category": "Fourth",
"Number": "19605",
"com-reg-no": "1007284",
"NM": "ربيع لبنان للتجارة",
"L_NM": "Rabih Lebanon Trading",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "118",
"Industrial certificate date": "29-Dec-18",
"ACTIVITY": "منشرة",
"Activity-L": "Sawmilling of wood",
"ADRESS": "ملك نور الدين الشامي\u001c - النويري - شارع زيدان\u001c - برج ابي حيدر - بيروت",
"TEL1": "03/284078",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "25643",
"com-reg-no": "2004094",
"NM": "سبماتيك ش م م",
"L_NM": "Sabmatic sarl",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "155",
"Industrial certificate date": "10-Jan-19",
"ACTIVITY": "صناعة محولات ومقويات كهربائية",
"Activity-L": "Manufacture of transformers",
"ADRESS": "بناية سالومي\u001c - شارع مار الياس\u001c - الدكوانة - المتن",
"TEL1": "01/685420",
"TEL2": "03/695420",
"TEL3": "",
"internet": "sabmatic@hotmail.com"
},
{
"Category": "Second",
"Number": "6555",
"com-reg-no": "2010478",
"NM": "اليكترو مونتا ش م م",
"L_NM": "Electro Monta sarl",
"Last Subscription": "17-Feb-18",
"Industrial certificate no": "76",
"Industrial certificate date": "21-Dec-18",
"ACTIVITY": "تجميع تابلوهات كهربائية - تعهدات انشاءات وتمديدات كهربائية",
"Activity-L": "Assembling of electrical boards - Electrical contracting",
"ADRESS": "ملك دير مار يوسف البرج\u001c - طريق زكريت\u001c - زوق الخراب - المتن",
"TEL1": "03/903837",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "4935",
"com-reg-no": "2011105",
"NM": "شركة باريمكس للتجارة والصناعة ش م م",
"L_NM": "Société Parimex pour le Commerce et l\'industrie sarl",
"Last Subscription": "20-Jun-17",
"Industrial certificate no": "4143",
"Industrial certificate date": "14-Jun-18",
"ACTIVITY": "صناعة احجار باطون وبلاط موزاييك وتجارة جملة الدهان",
"Activity-L": " Manufacture of tiles & wholesale of paints",
"ADRESS": "ملك خليل بو صقر\u001c - الطريق العام\u001c - بسوس - عاليه",
"TEL1": "05/942323",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "26521",
"com-reg-no": "1006628",
"NM": "سوبرة غروب للمعادن ش م م",
"L_NM": "Soubra Metal Group sarl",
"Last Subscription": "17-Feb-17",
"Industrial certificate no": "2231",
"Industrial certificate date": "26-Jan-18",
"ACTIVITY": "صناعة منجور معدني",
"Activity-L": "Manufacture of metallic panelling",
"ADRESS": "بناية برج الابيض\u001c - طلعة النويري - شارع عبد الغني العريسي\u001c - المزرعة - بيروت",
"TEL1": "01/656025",
"TEL2": "01/656028",
"TEL3": "03/722003",
"internet": "info@soubrametalgroup.com"
},
{
"Category": "Second",
"Number": "6138",
"com-reg-no": "1002420",
"NM": "كروب ماركس للتصميم والطباعة ش م م",
"L_NM": "Crop Marks Graphic Design & Printing sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "3193",
"Industrial certificate date": "21-Jan-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "بناية الديوان ط سفلي 1\u001c - شارع رشيد نخله\u001c - الظريف - بيروت",
"TEL1": "01/371357",
"TEL2": "03/188844",
"TEL3": "",
"internet": "cropmarks@gmail.com"
},
{
"Category": "First",
"Number": "4787",
"com-reg-no": "54850",
"NM": "سعد غروب ش م م - تجارة عامة وتعهدات",
"L_NM": "Saad Group sarl",
"Last Subscription": "4-Dec-17",
"Industrial certificate no": "4903",
"Industrial certificate date": "21-Oct-18",
"ACTIVITY": "معملا لصب احجار الباطون",
"Activity-L": "Factory of concrete stones",
"ADRESS": "ملك سعد\u001c - حي الوطايا - الشارع العام\u001c - الصفرا - كسروان",
"TEL1": "03/570002",
"TEL2": "09/852505",
"TEL3": "",
"internet": "grpsaad@hotmail.com"
},
{
"Category": "First",
"Number": "5219",
"com-reg-no": "59905",
"NM": "شركة ليو ديجيتال بريس ش م ل",
"L_NM": "Societe Leo Digital Press sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4807",
"Industrial certificate date": "30-Oct-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "ملك ترزيان\u001c - شارع الفندقية\u001c - الدكوانة - المتن",
"TEL1": "01/690740",
"TEL2": "01/691758",
"TEL3": "03/678200",
"internet": "joseph@leodigital.com.lb"
},
{
"Category": "First",
"Number": "4614",
"com-reg-no": "1007600",
"NM": "Inkript Forms sal",
"L_NM": "Inkript Forms sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "479",
"Industrial certificate date": "27-Feb-19",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "بناية طبارة\u001c - شارع العرداتي\u001c - رأس بيروت - بيروت",
"TEL1": "01/740901+5",
"TEL2": "05/808081",
"TEL3": "",
"internet": "ehajjar@inkript.com"
},
{
"Category": "First",
"Number": "4598",
"com-reg-no": "75247",
"NM": "مجموعة الرعيدي للطباعة ش م ل",
"L_NM": "Raidy Printing Group sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4303",
"Industrial certificate date": "13-Jul-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "بناية دياب\u001c - شارع مارانطونيوس\u001c - الجميزة - بيروت",
"TEL1": "05/954854",
"TEL2": "",
"TEL3": "",
"internet": "raidy@raidy.com"
},
{
"Category": "Second",
"Number": "6857",
"com-reg-no": "2047051",
"NM": "شركة كرامبل  للصناعة و التجارة ش م ل",
"L_NM": "Crumble For Manufacturing & Trading sal",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "489",
"Industrial certificate date": "28-Feb-19",
"ACTIVITY": "صناعة الشوكولا والسكاكر والحلويات",
"Activity-L": "Manufacture of chocolate, confectionery & sweets",
"ADRESS": "بناية اسكندر\u001c - المنطقة الصناعية - شارع ميرالكو\u001c - مزرعة يشوع - المتن",
"TEL1": "04/930068",
"TEL2": "",
"TEL3": "",
"internet": "info@crumble-lb.com"
},
{
"Category": "First",
"Number": "4978",
"com-reg-no": "2012057",
"NM": "ماجوما",
"L_NM": "Majoma",
"Last Subscription": "24-Apr-17",
"Industrial certificate no": "3795",
"Industrial certificate date": "10-Apr-18",
"ACTIVITY": "صناعة الدهان",
"Activity-L": "Manufacture of paints",
"ADRESS": "ملك شرفان\u001c - الشارع العام\u001c - الديشونيه - المتن",
"TEL1": "05/433792",
"TEL2": "03/744990",
"TEL3": "03/944608",
"internet": "info@majomapainting.com"
},
{
"Category": "Third",
"Number": "30885",
"com-reg-no": "2011775",
"NM": "Salem Curtains Arts",
"L_NM": "Salem Curtains Arts",
"Last Subscription": "21-Feb-18",
"Industrial certificate no": "407",
"Industrial certificate date": "19-Feb-19",
"ACTIVITY": "خياطة البرادي",
"Activity-L": "Sewing of curtains",
"ADRESS": "ملك جورج سالم ط 3\u001c - حارة سالم - الشارع العام\u001c - بسوس - عاليه",
"TEL1": "05/942598",
"TEL2": "03/871978",
"TEL3": "",
"internet": "salemcurtainsarts@gmail.com"
},
{
"Category": "Third",
"Number": "30048",
"com-reg-no": "2007143",
"NM": "Deo Group - Freshair",
"L_NM": "Deo Group - Freshair",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4909",
"Industrial certificate date": "21-Nov-18",
"ACTIVITY": "صناعة معطرات للجو",
"Activity-L": "Manufacture of fresh air products",
"ADRESS": "ملك طراد\u001c - طريق بزمار\u001c - غوسطا - كسروان",
"TEL1": "03/285389",
"TEL2": "03/574643",
"TEL3": "70/141433",
"internet": ""
},
{
"Category": "Second",
"Number": "6340",
"com-reg-no": "2008899",
"NM": "الشركة اللبنانية لفرم وتوضيب الورق ش م م",
"L_NM": "Lebanese Corporation for Paper Products sarl",
"Last Subscription": "29-Mar-17",
"Industrial certificate no": "3424",
"Industrial certificate date": "20-Feb-18",
"ACTIVITY": "صناعة الورق والكرتون",
"Activity-L": "Manufacture of paper & carton",
"ADRESS": "بناية الشعابين\u001c - حي الامراء - شارع التيرو\u001c - الشويفات - عاليه",
"TEL1": "03/220811",
"TEL2": "05/480646",
"TEL3": "",
"internet": "leb.corporation.f.ppr@windowsleb.com"
},
{
"Category": "Second",
"Number": "4674",
"com-reg-no": "1007176",
"NM": "شركة الوفا للتجارة والصناعة ش م ل",
"L_NM": "El Wafa For Trade & Industry sal",
"Last Subscription": "5-Oct-17",
"Industrial certificate no": "3837",
"Industrial certificate date": "19-Apr-18",
"ACTIVITY": "صناعة الطحينة واالحلاوة والراحة",
"Activity-L": "Maufacture of tahina, halawa & turkish delight",
"ADRESS": "بناية حسونة وكوش\u001c - شارع الماما\u001c - تلة الخياط - بيروت",
"TEL1": "03/899939",
"TEL2": "01/316066",
"TEL3": "07/972339",
"internet": ""
},
{
"Category": "First",
"Number": "4772",
"com-reg-no": "70984",
"NM": "شركة : First Co تضامن",
"L_NM": "First Co",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "3754",
"Industrial certificate date": "3-May-18",
"ACTIVITY": "صناعة منتجات اللحوم والاسماك",
"Activity-L": "Manufacture of meat products",
"ADRESS": "ملك ابو عاصي\u001c - المنطقة الصناعية - شارع وادي العين\u001c - زوق مصبح - كسروان",
"TEL1": "09/226667",
"TEL2": "09/226669",
"TEL3": "03/352903",
"internet": "info@first-company.com"
},
{
"Category": "Second",
"Number": "4884",
"com-reg-no": "1001310",
"NM": "شاتو مارسياس ش م ل",
"L_NM": "Chateau Marsyas sal",
"Last Subscription": "7-Feb-18",
"Industrial certificate no": "2968",
"Industrial certificate date": "3-Jul-18",
"ACTIVITY": "صناعة النبيذ",
"Activity-L": "Manufacture of wine",
"ADRESS": "بناية بيروتك\u001c - شارع باستور\u001c - المدور - بيروت",
"TEL1": "01/442082",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1813",
"com-reg-no": "1006517",
"NM": "الشامي دايت هوم مخابز وحلويات ش م م",
"L_NM": "Al Shami Diet Home Bakeries & Sweets Co. sarl",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "2775",
"Industrial certificate date": "6-Apr-18",
"ACTIVITY": "فرن للخبز",
"Activity-L": "Bakery",
"ADRESS": "بناية نسرين\u001c - شارع مار الياس\u001c - المصيطبة - بيروت",
"TEL1": "01/375558",
"TEL2": "03/882300",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "4114",
"com-reg-no": "2006020",
"NM": "بوليترا ش م م",
"L_NM": "Polytra sarl",
"Last Subscription": "15-Feb-17",
"Industrial certificate no": "3334",
"Industrial certificate date": "8-Feb-18",
"ACTIVITY": "تجارة جملة تجهيزات ومواد طب الاسنان ومعمل للخزائن واسرة المستشفيات",
"Activity-L": "Wholesale of dental supplies & manufacture of hospitals beds & closets",
"ADRESS": "مزيارة  سنتر بلوك B\u001c - الاوتوستراد\u001c - زوق مصبح - كسروان",
"TEL1": "09/224447",
"TEL2": "03/711447",
"TEL3": "",
"internet": "info@polytra.net"
},
{
"Category": "Excellent",
"Number": "1742",
"com-reg-no": "2009541",
"NM": "بارودي اخوان ش م ل",
"L_NM": "Baroody Bros sal",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "4802",
"Industrial certificate date": "26-Oct-18",
"ACTIVITY": "تجارة جملة مستحضرات تجميل وصناعة الصابون",
"Activity-L": "Wholesale of cosmetics & Manufacture of soaps",
"ADRESS": "ملك بارودي\u001c - اول طلعة المكلس\u001c - الدكوانة - المتن",
"TEL1": "01/486395",
"TEL2": "01/486396",
"TEL3": "01/486397+8",
"internet": "info@baroodygroup.com"
},
{
"Category": "Fourth",
"Number": "26745",
"com-reg-no": "2035927",
"NM": "شركة رفيق منلا واولاده أر اس ام للكيماويات ش م م",
"L_NM": "RAFIK MANLA & SONS  R.S.M. for Chemicals sarl",
"Last Subscription": "31-Jul-17",
"Industrial certificate no": "4278",
"Industrial certificate date": "11-Jul-18",
"ACTIVITY": "صناعة مواد المنظفات",
"Activity-L": "manufacture of antiseptic",
"ADRESS": "بناية حسن ابراهيم\u001c - الشارع العام - قرب محطة توتال\u001c - عين سعاده - المتن",
"TEL1": "78/838170",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "25848",
"com-reg-no": "2035637",
"NM": "Perma Foam",
"L_NM": "Perma Foam",
"Last Subscription": "27-Jan-18",
"Industrial certificate no": "4075",
"Industrial certificate date": "5-Jun-18",
"ACTIVITY": "صناعة الاسفنج",
"Activity-L": "Manufacture  of sponges",
"ADRESS": "بناية نشأت محمد فارس\u001c - قرب معمل شهاب\u001c - الدبيه - الشوف",
"TEL1": "05/480470",
"TEL2": "78/886118",
"TEL3": "03/275949",
"internet": "perma.foam@outlook.com"
},
{
"Category": "First",
"Number": "4742",
"com-reg-no": "2009214",
"NM": "شركة رانك غروب ش م م شفيا",
"L_NM": "Rank Group sarl - Shfia",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "3283",
"Industrial certificate date": "3-Feb-18",
"ACTIVITY": "تعبئة المياه الطبيعية وتجارة الخل والعرق والعسل ومشتقات الحليب",
"Activity-L": "Trading of vinegar, arrack & honey & dairy products",
"ADRESS": "بناية ابي خليل ط ارضي\u001c - حي الشميسات - الشارع العام\u001c - لحفد - جبيل",
"TEL1": "01/294141",
"TEL2": "03/406066",
"TEL3": "",
"internet": "gss@terra.net.lb"
},
{
"Category": "Third",
"Number": "24741",
"com-reg-no": "201000",
"NM": "شركة بكري ش م م",
"L_NM": "Bakri Co. sarl",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4839",
"Industrial certificate date": "7-Nov-18",
"ACTIVITY": "صناعة افران الية والقطاعات والرقاقات",
"Activity-L": "Manufacture of bakery machinery",
"ADRESS": "ملك غادة طبارة بلوك A\u001c - حي الامراء - شارع التيرو\u001c - الشويفات - عاليه",
"TEL1": "03/775545",
"TEL2": "03/737333",
"TEL3": "05/433772",
"internet": "info@bakrico.com"
},
{
"Category": "Second",
"Number": "4602",
"com-reg-no": "59562",
"NM": "افر ايست مد ش م ل",
"L_NM": "Ever East Med sal",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "4514",
"Industrial certificate date": "21-Aug-18",
"ACTIVITY": "اعمال البرمجة",
"Activity-L": "Software services",
"ADRESS": "ملك الشركة\u001c - شارع مار منصور\u001c - النقاش - المتن",
"TEL1": "01/513531+2",
"TEL2": "03/397239",
"TEL3": "70/225178",
"internet": "info@ever-me.com"
},
{
"Category": "Fourth",
"Number": "19478",
"com-reg-no": "2004832",
"NM": "مؤسسة محمد وهبة جمال الدين شميس التجارية لصاحبيها حسن وطلال شميس - تضامن",
"L_NM": "Mohamad Wehbe Jamal Eddine Chmais Trading Est",
"Last Subscription": "27-Oct-17",
"Industrial certificate no": "2226",
"Industrial certificate date": "26-Oct-18",
"ACTIVITY": "فرن للخبز وتجارة البزورات والشوكولا",
"Activity-L": "Bakery & trading of mixed nuts & chocolate",
"ADRESS": "ملك شميس\u001c - نزلة الرسول الاعظم - شارع حسين علي ناصر\u001c - برج البراجنة - بعبدا",
"TEL1": "03/882987",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1654",
"com-reg-no": "2009338",
"NM": "شركة القزي للتجاره ش م ل",
"L_NM": "Al - Kazzi Trading sal",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "3881",
"Industrial certificate date": "25-Apr-18",
"ACTIVITY": "محمصة بزورات",
"Activity-L": "Roastery of mixed nuts",
"ADRESS": "ملك القزي\u001c - المدينة الصناعية\u001c - المكلس - المتن",
"TEL1": "01/513133",
"TEL2": "01/513134",
"TEL3": "03/201090",
"internet": "accounting@alkazzi.com"
},
{
"Category": "First",
"Number": "5329",
"com-reg-no": "1006418",
"NM": "انتر اوفيس - اوفيس فرنتشير ش م م",
"L_NM": "Inter Office - Office furniture sarl",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "3714",
"Industrial certificate date": "28-Mar-18",
"ACTIVITY": "صناعة مفروشات مكتبية",
"Activity-L": "Manufacture of office furniture",
"ADRESS": "ملك سبع تعين\u001c - الاونيسكو - الشارع العام\u001c - المصيطبة - بيروت",
"TEL1": "01/855791",
"TEL2": "70/177222",
"TEL3": "05/813333",
"internet": "info@interfoffice-lb.com"
},
{
"Category": "Third",
"Number": "25403",
"com-reg-no": "64700",
"NM": "ابناء نعمان غصوب للرخام والصخر الوطني - شركة توصية بسيطة",
"L_NM": "Nouman Ghoussoub Sons for Marbles",
"Last Subscription": "11-Jul-17",
"Industrial certificate no": "4229",
"Industrial certificate date": "3-Jun-18",
"ACTIVITY": "معملا لنشر وتفصيل وجلي الصخور والرخام",
"Activity-L": "Manufacture of marbles & rocks",
"ADRESS": "ملك غصوب\u001c - المنطقة الصناعية\u001c - زكريت - المتن",
"TEL1": "04/915076",
"TEL2": "03/436813",
"TEL3": "03/948200",
"internet": ""
},
{
"Category": "Second",
"Number": "6647",
"com-reg-no": "2009459",
"NM": "Bedago Silverware sarl",
"L_NM": "Bedago Silverware sarl",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "3389",
"Industrial certificate date": "16-Feb-18",
"ACTIVITY": "صناعة اواني مفضضة وبلكسي",
"Activity-L": "Wholesale of silverware & plexy",
"ADRESS": "بناية تريز عبيد ط 2\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "03/717710",
"TEL2": "03/717711",
"TEL3": "01/496933",
"internet": "bedagosilverware@hotmail.com"
},
{
"Category": "Second",
"Number": "6162",
"com-reg-no": "2009215",
"NM": "سيلك اند فلفيت ش م م",
"L_NM": "Silk & Velvet sarl",
"Last Subscription": "25-Jan-18",
"Industrial certificate no": "3252",
"Industrial certificate date": "6-Feb-19",
"ACTIVITY": "صناعة الالبسة النسائية وتطريزها",
"Activity-L": "Manufacture of ladies\' clothes & embroidery",
"ADRESS": "ملك طانيوس البيروتي\u001c - شارع قصر العدل\u001c - الجديدة - المتن",
"TEL1": "01/888151",
"TEL2": "01/888251",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1679",
"com-reg-no": "2007745",
"NM": "شركة وان واي ش م م",
"L_NM": "One Way sarl",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "95",
"Industrial certificate date": "26-Dec-18",
"ACTIVITY": "صناعة الشوكولا والبوظة والحلويات الافرنجية",
"Activity-L": "Manufacture of chocolate ice-cream & western sweets",
"ADRESS": "بناية معلوف\u001c - شارع تل الزعتر\u001c - الدكوانة - المتن",
"TEL1": "01/689707",
"TEL2": "03/604756",
"TEL3": "",
"internet": "rm@onewaylb.com"
},
{
"Category": "Third",
"Number": "26325",
"com-reg-no": "67983",
"NM": "مطبعة سليم دبوس ش م م",
"L_NM": "Salim Dabbous Printing Co. sarl",
"Last Subscription": "18-Jan-17",
"Industrial certificate no": "1134",
"Industrial certificate date": "25-Jan-17",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "بناية اللعازارية\u001c - وسط بيروت - شارع الامير بشير\u001c - الباشورة - بيروت",
"TEL1": "01/980808",
"TEL2": "01/980707",
"TEL3": "",
"internet": "nabil@dabbousprinting.com"
},
{
"Category": "Second",
"Number": "5923",
"com-reg-no": "70597",
"NM": "نخول كوربوريشن ش م م",
"L_NM": "Nakhoul Corporation sarl",
"Last Subscription": "10-Mar-18",
"Industrial certificate no": "4683",
"Industrial certificate date": "6-Oct-18",
"ACTIVITY": "صناعة مجاري تكييف الهواء",
"Activity-L": "Manufacture of cooling ducts",
"ADRESS": "بناية بستاني\u001c - شارع كهرباء الزوق\u001c - زوق مكايل - كسروان",
"TEL1": "09/225888",
"TEL2": "03/624482",
"TEL3": "09/225888",
"internet": "info@nakhoulcorp.com"
},
{
"Category": "Second",
"Number": "4632",
"com-reg-no": "2010500",
"NM": "شركة ا.ج. بيلدينغ سيستمز ش م ل",
"L_NM": "A G Building Systems sal",
"Last Subscription": "16-Aug-17",
"Industrial certificate no": "4467",
"Industrial certificate date": "10-Aug-18",
"ACTIVITY": "معمل للمنجورات وواجهات الالمنيوم",
"Activity-L": "Manufacture of carpentry & aluminium front",
"ADRESS": "ملك زياد الجميل\u001c - شارع مار يوسف\u001c - البوشرية - المتن",
"TEL1": "01/891188",
"TEL2": "03/621521",
"TEL3": "01/689688",
"internet": "info@agsal.com"
},
{
"Category": "Second",
"Number": "2609",
"com-reg-no": "56453",
"NM": "حلواني ترانستيك ش م ل",
"L_NM": "Halwany Transtech sal",
"Last Subscription": "9-Nov-17",
"Industrial certificate no": "4826",
"Industrial certificate date": "2-Nov-18",
"ACTIVITY": "صناعة غرف التبريد",
"Activity-L": "Manufacture of cooling rooms",
"ADRESS": "ملك مهدي التاجر\u001c - شارع كليمنصو\u001c - جنبلاط - بيروت",
"TEL1": "01/364142",
"TEL2": "01/364817",
"TEL3": "01/360362",
"internet": "info@halwany.com"
},
{
"Category": "Second",
"Number": "5947",
"com-reg-no": "2008033",
"NM": "شركة دويهي بور لو بوا ش م م",
"L_NM": "Douaihy Pour Le Bois sarl",
"Last Subscription": "29-Apr-17",
"Industrial certificate no": "3400",
"Industrial certificate date": "18-Feb-18",
"ACTIVITY": "تجارة الاخشاب",
"Activity-L": "Trading of wood",
"ADRESS": "ملك باخوس الدويهي\u001c - المنطقة الصناعية\u001c - زوق مصبح - كسروان",
"TEL1": "09/216114",
"TEL2": "09/216115",
"TEL3": "03/653977",
"internet": "dpb@douaihypourlebois.com"
},
{
"Category": "First",
"Number": "5026",
"com-reg-no": "2000995",
"NM": "شركة فؤاد البعينو للتجليد ش م م",
"L_NM": "Fouad Baayno Bookbindery sarl",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "3971",
"Industrial certificate date": "15-May-18",
"ACTIVITY": "معملا للتجليد الفني",
"Activity-L": "Factory of bookbinding",
"ADRESS": "بناية بعينو\u001c - طريق المطار - قرب محطة الايتام\u001c - برج البراجنة - بعبدا",
"TEL1": "01/455000",
"TEL2": "01/455501",
"TEL3": "03/499660",
"internet": "info@baayno.com"
},
{
"Category": "Third",
"Number": "30071",
"com-reg-no": "32279",
"NM": "مؤسسة ايلا زحلان التجارية",
"L_NM": "Ella Zahlan Trading Est",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "2052",
"Industrial certificate date": "17-Jan-18",
"ACTIVITY": "تصميم وصناعة الالبسة النسائية",
"Activity-L": "Design & manufacture of ladies\' clothes",
"ADRESS": "بناية زحلان\u001c - تلة السرور\u001c - النقاش - المتن",
"TEL1": "04/410535",
"TEL2": "01/350707",
"TEL3": "",
"internet": "info@ellazahlan.com"
},
{
"Category": "Second",
"Number": "6512",
"com-reg-no": "2007189",
"NM": "اوريجينال برينت باك ش م م",
"L_NM": "Original Print - Pack sarl",
"Last Subscription": "3-Feb-18",
"Industrial certificate no": "3588",
"Industrial certificate date": "11-Mar-18",
"ACTIVITY": "صناعة اكياس الورق والنايلون وعلب الكرتون",
"Activity-L": "Manufacture of paper & plastic bags & paperboard cases",
"ADRESS": "ملك سلامة\u001c - مزهر - الشارع الداخلي\u001c - انطلياس - المتن",
"TEL1": "04/711334",
"TEL2": "04/723937",
"TEL3": "03/723937",
"internet": "original.pack@hotmail.com"
},
{
"Category": "Second",
"Number": "8020",
"com-reg-no": "2008838",
"NM": "شركة المثمن للاستثمار والانماء التجاري ش م م",
"L_NM": "Octagon Invest sarl",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "4463",
"Industrial certificate date": "10-Aug-18",
"ACTIVITY": "صيانة السيارات والاليات وصناعة هياكل السيارات",
"Activity-L": "Maintenance and manufacture of bodies for cars & vehicles",
"ADRESS": "ملك شركة المثمن للاستثمار والانماء التجاري ش م م\u001c - شارع البياض\u001c - غزير - كسروان",
"TEL1": "09/920376",
"TEL2": "03/565505",
"TEL3": "03/162048",
"internet": "elie@octagonlb.com"
},
{
"Category": "Second",
"Number": "4875",
"com-reg-no": "59052",
"NM": "ابينيستا لينيا ش م م",
"L_NM": "Ebenista Linea sarl",
"Last Subscription": "17-Mar-17",
"Industrial certificate no": "1735",
"Industrial certificate date": "19-Apr-17",
"ACTIVITY": "تجارة المفروشات والمطابخ الخشبية",
"Activity-L": "Trading of wooden furniture & kitchen",
"ADRESS": "ملك رواد كونستراكشن\u001c - الرميل - شارع الثلاثة اقمار\u001c - الاشرفية - بيروت",
"TEL1": "09/227627",
"TEL2": "01/561627",
"TEL3": "01/446571",
"internet": "design@prima-linea.com"
},
{
"Category": "Second",
"Number": "4863",
"com-reg-no": "60297",
"NM": "دكاش وودلين ش م م",
"L_NM": "Daccache Woodline sarl",
"Last Subscription": "4-Apr-17",
"Industrial certificate no": "4152",
"Industrial certificate date": "16-Jun-18",
"ACTIVITY": "صناعة المفروشات",
"Activity-L": "Manufacture of furniture",
"ADRESS": "ملك الدكاش\u001c - المدينة الصناعية\u001c - نهر ابراهيم - جبيل",
"TEL1": "09/446111",
"TEL2": "09/446112",
"TEL3": "",
"internet": "dwl@dm.net.lb"
},
{
"Category": "Excellent",
"Number": "1690",
"com-reg-no": "2010274",
"NM": "شركة دايري خوري وشركاءه ش م ل",
"L_NM": "Dairy Khoury and Company sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4701",
"Industrial certificate date": "10-Oct-18",
"ACTIVITY": "صناعة الاجبان والالبان",
"Activity-L": "Manufacture of dairy products",
"ADRESS": "ملك عبد الله الخوري\u001c - عين السنديانة\u001c - الشوير - المتن",
"TEL1": "04/274600",
"TEL2": "03/243448",
"TEL3": "",
"internet": "dairy_khoury@idm.net.lb"
},
{
"Category": "Excellent",
"Number": "1741",
"com-reg-no": "2009227",
"NM": "زيناتي غروب ش م ل",
"L_NM": "Zeinaty Group sal",
"Last Subscription": "9-Mar-18",
"Industrial certificate no": "4650",
"Industrial certificate date": "29-Sep-18",
"ACTIVITY": "صناعة مفروشات خشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "بناية زيناتي\u001c - المنطقة الصناعية\u001c - بعبدات - المتن",
"TEL1": "04/821210",
"TEL2": "03/736566",
"TEL3": "",
"internet": "zeinaty@hotmail.com"
},
{
"Category": "Third",
"Number": "25394",
"com-reg-no": "2008916",
"NM": "اد. ار. هندسة صناعية",
"L_NM": "ED - Art",
"Last Subscription": "20-Mar-18",
"Industrial certificate no": "3109",
"Industrial certificate date": "11-Jan-18",
"ACTIVITY": "معمل السوائل الكيماوية للمراجل البخارية والراديورات",
"Activity-L": "Manufacture of chemical liquids for boilers & radiators",
"ADRESS": "بناية بولغورجيان ملك نصرالله\u001c - المنطقة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/895164",
"TEL2": "01/877785",
"TEL3": "03/808619",
"internet": ""
},
{
"Category": "Fourth",
"Number": "23937",
"com-reg-no": "2003679",
"NM": "جيتكس كيميكلز ش م م",
"L_NM": "Getex Chemicals sarl",
"Last Subscription": "30-May-17",
"Industrial certificate no": "4022",
"Industrial certificate date": "24-May-18",
"ACTIVITY": "صناعة علاقات حديدية للثياب",
"Activity-L": "Manufacture of hooks for clothes",
"ADRESS": "ملك جورج الترك\u001c - شارع الشميس\u001c - جديدة غزير - كسروان",
"TEL1": "09/926576",
"TEL2": "03/605576",
"TEL3": "",
"internet": "getexchemicals@hotmail.com"
},
{
"Category": "First",
"Number": "5159",
"com-reg-no": "2006600",
"NM": "شركة دانيكا ش م ل",
"L_NM": "Danika sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "3811",
"Industrial certificate date": "11-Apr-18",
"ACTIVITY": "صناعة الالبان والاجبان",
"Activity-L": "Manufacture of dairy products",
"ADRESS": "ملك شركة دانيكا العقارية ش م ل\u001c - المدينة الصناعية\u001c - نهر ابراهيم - جبيل",
"TEL1": "09/440001",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "24576",
"com-reg-no": "63552",
"NM": "ادوار وشركاه ش م م",
"L_NM": "Société Edward Et Co. sarl",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "4752",
"Industrial certificate date": "19-Oct-18",
"ACTIVITY": "صناعة الالبسة النسائية",
"Activity-L": "Manufacture of ladies\' clothes",
"ADRESS": "ملك ادوار قرصوني\u001c - الشارع العام\u001c - جل الديب - المتن",
"TEL1": "04/719192",
"TEL2": "03/306731",
"TEL3": "",
"internet": "samia@edwardarsouni.me"
},
{
"Category": "Third",
"Number": "25221",
"com-reg-no": "39664",
"NM": "شركة فيينا شوز ش م م",
"L_NM": "Vienna Shoes sarl",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4203",
"Industrial certificate date": "28-Jun-18",
"ACTIVITY": "صناعة الاحذية والجزادين النسائية والولادية",
"Activity-L": "Manufacture of shoes & bags for ladies & kids",
"ADRESS": "بناية الهاني\u001c - شارع ربايا\u001c - زوق مصبح - كسروان",
"TEL1": "09/220218",
"TEL2": "09/220219",
"TEL3": "",
"internet": "vienna@inco.com.lb"
},
{
"Category": "Third",
"Number": "24573",
"com-reg-no": "2005682",
"NM": "يونيفورمز ش م م",
"L_NM": "Uniforms sarl",
"Last Subscription": "6-Feb-18",
"Industrial certificate no": "4016",
"Industrial certificate date": "23-May-18",
"ACTIVITY": "صناعة الالبسة الموحدة (لزوم المطاعم والفنادق والمستشفيات)",
"Activity-L": "Manufacture of uniforms",
"ADRESS": "بناية مقصود\u001c - شارع العسيلي\u001c - الجديدة - المتن",
"TEL1": "01/890117",
"TEL2": "01/890118",
"TEL3": "03/336001",
"internet": "info@uniformslb.com"
},
{
"Category": "First",
"Number": "5051",
"com-reg-no": "69787",
"NM": "افران وباتيسري ابراهيم الحديثة ش م م",
"L_NM": "Patisserie Cornetto sarl",
"Last Subscription": "3-Feb-18",
"Industrial certificate no": "4279",
"Industrial certificate date": "11-Jul-18",
"ACTIVITY": "فرن للخبز",
"Activity-L": "Bakery",
"ADRESS": "بناية مهدي\u001c - بولفار وزارة العمل\u001c - الشياح - بعبدا",
"TEL1": "01/540986",
"TEL2": "71/232215",
"TEL3": "",
"internet": "ibrahimbakeries@yahoo.com"
},
{
"Category": "Third",
"Number": "25164",
"com-reg-no": "2007334",
"NM": "راشيو بلاس ش م ل",
"L_NM": "Ratio Plus sal",
"Last Subscription": "9-Dec-17",
"Industrial certificate no": "4396",
"Industrial certificate date": "29-Jul-18",
"ACTIVITY": "تقديم مأكولات جاهزة",
"Activity-L": "Catering",
"ADRESS": "سنتر مكلس 2000\u001c - الشارع العام\u001c - المكلس - المتن",
"TEL1": "01/684984",
"TEL2": "",
"TEL3": "",
"internet": "mls@cyberia.net.lb"
},
{
"Category": "Third",
"Number": "25167",
"com-reg-no": "2008134",
"NM": "شركة جورج حبيقة - المشغل - ش م ل",
"L_NM": "Georges Hobeika - Atelier sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4791",
"Industrial certificate date": "25-Oct-18",
"ACTIVITY": "تصميم وصناعة الالبسة النسائية",
"Activity-L": " Fashion design & manufacture of ladies clothes",
"ADRESS": "ملك جورج حبيقة\u001c - بيروت هول\u001c - سن الفيل - المتن",
"TEL1": "01/489969",
"TEL2": "01/511251",
"TEL3": "01/511351",
"internet": "info@georgeshobeika.com"
},
{
"Category": "Third",
"Number": "25119",
"com-reg-no": "1002333",
"NM": "شركة كريستيان بونجا واولاده ش م م",
"L_NM": "Christian Bonja & Fils sarl",
"Last Subscription": "16-Feb-18",
"Industrial certificate no": "2146",
"Industrial certificate date": "15-Feb-18",
"ACTIVITY": "صناعة المصوغات وتركيب الاحجار الكريمة",
"Activity-L": "Manufacture of jewelry & assorting of precious stones",
"ADRESS": "ملك زعيم بونجا\u001c - حي ابراهيم مدور- شارع بدارو\u001c - البارك - بيروت",
"TEL1": "01/383150",
"TEL2": "",
"TEL3": "",
"internet": "info@chirstianbonja.com"
},
{
"Category": "First",
"Number": "4563",
"com-reg-no": "62268",
"NM": "شركة نصولي للمجوهرات ش م ل",
"L_NM": "Nsouli Jewellery sal",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "365",
"Industrial certificate date": "8-Feb-19",
"ACTIVITY": "صناعة المجوهرات وتركيب الاحجار الكريمة",
"Activity-L": "Manufacture of jewelry & assorting of precious stones",
"ADRESS": "ملك الامير سعد بن عبد العزيز ال سعود\u001c - شارع الحمراء\u001c - رأس بيروت - بيروت",
"TEL1": "01/347606",
"TEL2": "01/350724",
"TEL3": "03/248088",
"internet": "nsouli@nsoulijewelry.com"
},
{
"Category": "Second",
"Number": "7195",
"com-reg-no": "32551",
"NM": "شركة تجارة المعادن والمعدات الصناعية - ميماكو - شركة توصية بسيطة",
"L_NM": "Memaco",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "2052",
"Industrial certificate date": "25-Jul-18",
"ACTIVITY": "تجارة جملة منجور وواجهات معدنية",
"Activity-L": "Wholesale of metallic panelling & front",
"ADRESS": "ملك الشركة وجهينة التنير\u001c - بئر حسن - شارع السفارة الايرانية\u001c - الشياح - بعبدا",
"TEL1": "01/856862",
"TEL2": "01/856863",
"TEL3": "03/982982",
"internet": "info@memacosteel.com"
},
{
"Category": "Second",
"Number": "7129",
"com-reg-no": "1005038",
"NM": "Quartz Cosmetics sarl",
"L_NM": "Quartz Cosmetics sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "4261",
"Industrial certificate date": "8-Jul-18",
"ACTIVITY": "صناعة مستحضرات العناية بالشعر والبشرة",
"Activity-L": "Manufacture of cosmetics for hair & skin",
"ADRESS": "بناية رئيف حمدان\u001c - العمروسية - شارع الضيعة\u001c - الشويفات - عاليه",
"TEL1": "05/431333",
"TEL2": "03/745707",
"TEL3": "03/313238",
"internet": "quartz_cosmetic@hotmail.com"
},
{
"Category": "Second",
"Number": "6493",
"com-reg-no": "75621",
"NM": "غرين غلوري ش م م",
"L_NM": "Green Glory sarl",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "011",
"Industrial certificate date": "12-Dec-18",
"ACTIVITY": "مطبعة - تجارة جملة ورق الطباعة وتصوير مستندات وماكينات الطباعة",
"Activity-L": "Printing press-Whole. of paper for printing ,Photocopy & printing machines",
"ADRESS": "بناية برج ليون\u001c - شارع ليون\u001c - الحمراء - بيروت",
"TEL1": "01/755977",
"TEL2": "01/737772",
"TEL3": "03/717707",
"internet": "mamagement@green-glory.com"
},
{
"Category": "Second",
"Number": "4105",
"com-reg-no": "66057",
"NM": "ارت وودلين ش م م",
"L_NM": "Art  Woodline sarl",
"Last Subscription": "19-Jun-17",
"Industrial certificate no": "4149",
"Industrial certificate date": "15-Jun-18",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك يوسف رزق الله\u001c - طريق بسوس\u001c - الكحالة - بعبدا",
"TEL1": "05/943595",
"TEL2": "03/852529",
"TEL3": "03/347274",
"internet": "info@artwoodline.com"
},
{
"Category": "Second",
"Number": "4545",
"com-reg-no": "1005437",
"NM": "شركة ايلي صعب لبنان ش م ل",
"L_NM": "Elie Saab Liban sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "3700",
"Industrial certificate date": "27-Mar-18",
"ACTIVITY": "تصميم وخياطة الالبسة النسائية وفساتين الاعراس",
"Activity-L": "Designing & sewing of ladies\'clothes & wedding dresses",
"ADRESS": "بناية ايلي صعب\u001c - ميناء الحصن\u001c - وسط بيروت - بيروت",
"TEL1": "01/981982",
"TEL2": "01/981983",
"TEL3": "03/671114",
"internet": "info@eliesaab.com"
},
{
"Category": "First",
"Number": "4525",
"com-reg-no": "1004329",
"NM": "Inkript Cards sal",
"L_NM": "Inkript Cards sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "3908",
"Industrial certificate date": "3-May-18",
"ACTIVITY": "طباعة تجارية وتجهيز البطاقات الذكية",
"Activity-L": "Printing press & preparing of magnetic cards",
"ADRESS": "ملك عيتاني\u001c - شارع العرداتي\u001c - المنارة - بيروت",
"TEL1": "01/740901",
"TEL2": "05/808081",
"TEL3": "",
"internet": "crizkallah@inkript.com"
},
{
"Category": "Third",
"Number": "29245",
"com-reg-no": "1002661",
"NM": "التنور",
"L_NM": "El Tannour",
"Last Subscription": "31-Jan-18",
"Industrial certificate no": "4411",
"Industrial certificate date": "1-Aug-18",
"ACTIVITY": "صناعة وتجارة الخبز",
"Activity-L": "Manufacture & Trading of bread",
"ADRESS": "بناية عقار رقم 4433 المقسم 4\u001c - حي صفير - شارع الجاموس\u001c - الحدث - بعبدا",
"TEL1": "01/476267",
"TEL2": "03/874928",
"TEL3": "",
"internet": "altannour@hotmail.com"
},
{
"Category": "Second",
"Number": "4809",
"com-reg-no": "2007402",
"NM": "شركة وود لاند ليبانون ش م م",
"L_NM": "Wood Land Lebanon sarl",
"Last Subscription": "16-Mar-18",
"Industrial certificate no": "4867",
"Industrial certificate date": "14-Nov-18",
"ACTIVITY": "تجارة الاخشاب",
"Activity-L": "Trading of wood",
"ADRESS": "ملك سهيل زكا\u001c - المدينة الصناعية\u001c - المكلس - المتن",
"TEL1": "01/687797",
"TEL2": "",
"TEL3": "",
"internet": "woodland@idm.net.lb"
},
{
"Category": "Second",
"Number": "6343",
"com-reg-no": "2005775",
"NM": "شركة بلكسي برو - شركة محدودة المسؤولية",
"L_NM": "Plexi - Pro sarl",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "151",
"Industrial certificate date": "9-Jan-19",
"ACTIVITY": "صناعة مفروسات وستندات من البلكسي غلاس",
"Activity-L": "Manufacture of plexi glass products",
"ADRESS": "بناية صفير\u001c - شارع الكسار\u001c - ريفون - كسروان",
"TEL1": "04/980347",
"TEL2": "03/360162",
"TEL3": "",
"internet": "plexipro@plexipro.com"
},
{
"Category": "Third",
"Number": "24599",
"com-reg-no": "2005786",
"NM": "فواياجور ش م م",
"L_NM": "Voyageur sarl",
"Last Subscription": "31-Jan-18",
"Industrial certificate no": "3527",
"Industrial certificate date": "3-Mar-18",
"ACTIVITY": "تجارة جملة المجوهرات",
"Activity-L": "Wholesale of Jewelry",
"ADRESS": "ملك بشير سركيس\u001c - شارع الكسليك\u001c - صربا - كسروان",
"TEL1": "09/640474",
"TEL2": "03/590359",
"TEL3": "",
"internet": "info@voyageurjewelry.com"
},
{
"Category": "Third",
"Number": "25258",
"com-reg-no": "2001655",
"NM": "ان وود ش م م",
"L_NM": "In Wood sarl",
"Last Subscription": "26-Jul-17",
"Industrial certificate no": "33",
"Industrial certificate date": "1-Jul-16",
"ACTIVITY": "تجارة المفروشات الخشبية",
"Activity-L": "Trading of wooden furniture",
"ADRESS": "ملك شركة سماط اخوان\u001c - الشارع العام - مفرق الفيلبس\u001c - المكلس - المتن",
"TEL1": "01/686995",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "4801",
"com-reg-no": "2005761",
"NM": "س.د. فورنيتشر فاكتوري اند كونتراكت",
"L_NM": "S.D. Furniture Factory and Contract",
"Last Subscription": "12-Sep-17",
"Industrial certificate no": "4574",
"Industrial certificate date": "6-Sep-18",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "بناية سهيل داغر\u001c - الشارع الرئيسي\u001c - مزرعة يشوع - المتن",
"TEL1": "04/926288",
"TEL2": "01/563333",
"TEL3": "03/313141",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1711",
"com-reg-no": "2008812",
"NM": "شركة تكمان - اندستري - ش م ل",
"L_NM": "Tecman - Industry - sal",
"Last Subscription": "20-Feb-18",
"Industrial certificate no": "3722",
"Industrial certificate date": "29-Mar-18",
"ACTIVITY": "صناعة المفروشات",
"Activity-L": "Manufacture of furniture",
"ADRESS": "ملك مطرانية بيروت المارونية\u001c - الوادي الصناعي\u001c - عين سعادة - المتن",
"TEL1": "01/879111",
"TEL2": "",
"TEL3": "",
"internet": "Tecman@idm.net.lb"
},
{
"Category": "Excellent",
"Number": "1647",
"com-reg-no": "2008810",
"NM": "بلبر ش م ل",
"L_NM": "Pulper sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4841",
"Industrial certificate date": "7-Nov-18",
"ACTIVITY": "صناعة الزيوت النباتية slim oil",
"Activity-L": "Manufacture of vegetable oil (Slim oil)",
"ADRESS": "ملك كتانة\u001c - المنطقة الصناعية\u001c - نهر ابراهيم - جبيل",
"TEL1": "09/444428",
"TEL2": "09/444535",
"TEL3": "03/787278",
"internet": "pulper@dm.net.lb"
},
{
"Category": "Third",
"Number": "25509",
"com-reg-no": "57026",
"NM": "ول بلاست - تضامن",
"L_NM": "Well Plast",
"Last Subscription": "22-Feb-18",
"Industrial certificate no": "4985",
"Industrial certificate date": "5-Dec-18",
"ACTIVITY": "معملا لتصنيع حبيبات بلاستيك P.V.C",
"Activity-L": "Manufacture of plastic in primary forms (Granule )P.V.C",
"ADRESS": "ملك نهرا وهاني\u001c - المنطقة الصناعية\u001c - مزرعة يشوع - المتن",
"TEL1": "04/928337",
"TEL2": "",
"TEL3": "",
"internet": "welplast@idm.net.lb"
},
{
"Category": "Third",
"Number": "25041",
"com-reg-no": "47257",
"NM": "Baal Artisans",
"L_NM": "Baal Artisans",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "336",
"Industrial certificate date": "5-Feb-19",
"ACTIVITY": "صناعة الاشغال الحرفية",
"Activity-L": " Manufacture of handicraft articles",
"ADRESS": "ملك بوياجيان\u001c - طريق بصاليم\u001c - المجذوب - المتن",
"TEL1": "04/713768",
"TEL2": "03/765517",
"TEL3": "",
"internet": "baalmail@idm.net.lb"
},
{
"Category": "First",
"Number": "4527",
"com-reg-no": "1002623",
"NM": "شركة رويال فورم / محمود الخطيب وشركاه - توصية بسيطة",
"L_NM": "Royal Form Co /Mahmoud Khatib & Co",
"Last Subscription": "26-Jan-18",
"Industrial certificate no": "3601",
"Industrial certificate date": "14-Mar-18",
"ACTIVITY": "مطبعة تجارية",
"Activity-L": "Commercial printing press",
"ADRESS": "ملك يوسف محمود\u001c - القبة - طريق مدرسة امجاد\u001c - الشويفات - عاليه",
"TEL1": "05/807884",
"TEL2": "03/322278",
"TEL3": "01/841426",
"internet": "gefco@cyberia.net.lb"
},
{
"Category": "Third",
"Number": "25024",
"com-reg-no": "2001769",
"NM": "شركة ميزون كليه ش م م",
"L_NM": "Maison Clé sarl",
"Last Subscription": "14-Sep-17",
"Industrial certificate no": "2922",
"Industrial certificate date": "30-Nov-17",
"ACTIVITY": "صناعة المفروشات",
"Activity-L": "Manufacture of furniture",
"ADRESS": "سنتر سان روك\u001c - الشارع العام\u001c - الحازمية - بعبدا",
"TEL1": "05/457144",
"TEL2": "03/670302",
"TEL3": "03/757325",
"internet": "suhabre@gmail.com"
},
{
"Category": "Second",
"Number": "4747",
"com-reg-no": "2001519",
"NM": "شركة ماغرامار ش م م",
"L_NM": "Magramar sarl",
"Last Subscription": "13-Mar-17",
"Industrial certificate no": "3480",
"Industrial certificate date": "25-Feb-18",
"ACTIVITY": "معملا لنشر الصخور والرخام",
"Activity-L": "Cutting of rocks & marbles",
"ADRESS": "ملك مسعود \u001c - مشيخا - الشارع العام\u001c - المتين - المتن",
"TEL1": "04/713578",
"TEL2": "03/753578",
"TEL3": "03/907236",
"internet": "info@magramar.com"
},
{
"Category": "Second",
"Number": "4520",
"com-reg-no": "1004905",
"NM": "محمصة الحلبي ش م ل",
"L_NM": "Al Halabi Roastary sal",
"Last Subscription": "8-Feb-18",
"Industrial certificate no": "3517",
"Industrial certificate date": "2-Mar-18",
"ACTIVITY": "محمصة",
"Activity-L": "Roastary",
"ADRESS": "مشروع الربيع ط ارضي\u001c - ارض جلول\u001c - الحرج - بيروت",
"TEL1": "01/855994",
"TEL2": "01/855993",
"TEL3": "03/617677",
"internet": "alhalabi@alhalabi.com"
},
{
"Category": "Fourth",
"Number": "25886",
"com-reg-no": "2034401",
"NM": "ماورا ش م ل",
"L_NM": "Mawara sal",
"Last Subscription": "12-Jul-17",
"Industrial certificate no": "4189",
"Industrial certificate date": "23-Jun-18",
"ACTIVITY": "صناعة الحقائب",
"Activity-L": "Manufacture of bags",
"ADRESS": "بناية فلامينكو\u001c - شارع البلدية\u001c - برج حمود - المتن",
"TEL1": "01/258369",
"TEL2": "03/759958",
"TEL3": "03/741418",
"internet": "info@waste-lb.com"
},
{
"Category": "Third",
"Number": "23894",
"com-reg-no": "70444",
"NM": "شركة Glasspro sal شركة مساهمة لبنانية",
"L_NM": "Glasspro sal",
"Last Subscription": "24-Feb-18",
"Industrial certificate no": "411",
"Industrial certificate date": "20-Feb-19",
"ACTIVITY": "قص وتقوية وتغشية الزجاج",
"Activity-L": "Cutting of glass",
"ADRESS": "بناية النسر\u001c - شارع عبد الله المشنوق\u001c - ساقية الجنزير - بيروت",
"TEL1": "01/814766+7",
"TEL2": "03/282898",
"TEL3": "05/808998",
"internet": "glasspro@arakji.com"
},
{
"Category": "Third",
"Number": "23857",
"com-reg-no": "70574",
"NM": "غود دايز ش م م",
"L_NM": "Good Days sarl",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "2869",
"Industrial certificate date": "18-Jan-17",
"ACTIVITY": "صناعة الحلويات العربية والافرنجية",
"Activity-L": "Manufacture of oriental & western sweets",
"ADRESS": "سنتر حطيط\u001c - طريق المطار\u001c - الغبيري - بعبدا",
"TEL1": "01/451839",
"TEL2": "",
"TEL3": "",
"internet": "info@goodies.com.lb"
},
{
"Category": "Fourth",
"Number": "19132",
"com-reg-no": "51693",
"NM": "سمارت كونترولر - ايلي جوزيف ابي عاد",
"L_NM": "Smart Controller",
"Last Subscription": "23-Jan-18",
"Industrial certificate no": "3594",
"Industrial certificate date": "13-Mar-18",
"ACTIVITY": "تجميع تابلوهات كهربائية للمصاعد",
"Activity-L": "Gathering  of electrical boards for elevators",
"ADRESS": "ملك ريتا ابي عاد\u001c - الشارع العام\u001c - عجلتون - كسروان",
"TEL1": "09/230987",
"TEL2": "03/284148",
"TEL3": "",
"internet": "elie.aa@hotmail.com"
},
{
"Category": "Second",
"Number": "6833",
"com-reg-no": "2003754",
"NM": "ليبان - فيبر ش م م",
"L_NM": "Liban - Fibre sarl",
"Last Subscription": "13-Feb-18",
"Industrial certificate no": "2127",
"Industrial certificate date": "23-Jun-17",
"ACTIVITY": "صناعة الالياف الاصطناعية (حشوات بوليستر) وخياطة اللحف والبياضات",
"Activity-L": "Manufacture of industrial fibers & sewing of quitls & linen",
"ADRESS": "ملك شركة بانوراما مكلس ش م ل\u001c - شارع قناطر زبيدة\u001c - المكلس - المتن",
"TEL1": "01/883213",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "4452",
"com-reg-no": "71320",
"NM": "مؤسسة اوهانس قرة بتيان للحدادة والالمنيوم",
"L_NM": "Ohannes Garabedian Est",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "127",
"Industrial certificate date": "3-Jan-19",
"ACTIVITY": "صناعة منجور الالمنيوم",
"Activity-L": "Manufacture of whittled aluminium",
"ADRESS": "ملك ابي جوده\u001c - طريق روميه\u001c - نهر الموت - المتن",
"TEL1": "01/880576",
"TEL2": "03/774242",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "6104",
"com-reg-no": "21657",
"NM": "الشركة اللبنانية للنجارة والتنجيد ش م م",
"L_NM": "Sté Libanaise d\' Ameublement  sarl",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "3742",
"Industrial certificate date": "1-Apr-18",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك قزي\u001c - المدينة الصناعية\u001c - المكلس - المتن",
"TEL1": "01/683230",
"TEL2": "03/881781",
"TEL3": "03/618825",
"internet": "sla@sla.com.lb"
},
{
"Category": "Third",
"Number": "23832",
"com-reg-no": "43613",
"NM": "فوتوغرافير وارطان ش م م",
"L_NM": "Photogravure Wartan sarl",
"Last Subscription": "3-Feb-18",
"Industrial certificate no": "3322",
"Industrial certificate date": "7-Feb-18",
"ACTIVITY": "صناعة كلشهات واختام وبلاكتات لزوم الطباعة",
"Activity-L": "Manufacture of cliché,stamps & valves for printing",
"ADRESS": "ملك ديرنيكوغوصيان\u001c - شارع المسلخ\u001c - برج حمود - المتن",
"TEL1": "01/254822",
"TEL2": "01/299603",
"TEL3": "03/270384",
"internet": "vartan2@dm.net.lb"
},
{
"Category": "Excellent",
"Number": "1685",
"com-reg-no": "65155",
"NM": "شركة فريحة فود ش م ل",
"L_NM": "Freiha Food Company- FFC sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "2603",
"Industrial certificate date": "14-Mar-18",
"ACTIVITY": "تقطيع وتوضيب منتجات الدواجن واللحوم وتكرير الزيوت النباتية",
"Activity-L": "Cutting & packing of poultry products & meat & vegetable oils",
"ADRESS": "بناية فريحة\u001c - المدينة الصناعية - خلف البراد اليوناني\u001c - البوشرية - المتن",
"TEL1": "01/499721",
"TEL2": "01/497171",
"TEL3": "",
"internet": "rima@freiha.com"
},
{
"Category": "Second",
"Number": "4451",
"com-reg-no": "2005846",
"NM": "شركة التو ترايدينغ ش م م",
"L_NM": "EltoTrading sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "196",
"Industrial certificate date": "21-Jan-19",
"ACTIVITY": " تجارة جملة لوازم الزينة والتجميل",
"Activity-L": "Wholesale of cosmetics",
"ADRESS": "ملك سليم خليفه\u001c - وطى عمارة شلهوب\u001c - الزلقا - المتن",
"TEL1": "01/901252",
"TEL2": "03/566989",
"TEL3": "",
"internet": "elie@eltotrading.com"
},
{
"Category": "Third",
"Number": "23557",
"com-reg-no": "16879",
"NM": "شركة ايزوتوب ش م م",
"L_NM": "Isotop Co. sarl",
"Last Subscription": "10-Feb-18",
"Industrial certificate no": "281",
"Industrial certificate date": "25-Jan-19",
"ACTIVITY": "صناعة منجورات بلاستكية",
"Activity-L": "Manufacture of plastic panels",
"ADRESS": "ملك سعود\u001c - الشارع العام\u001c - بيت شباب - المتن",
"TEL1": "04/983293",
"TEL2": "04/984023",
"TEL3": "",
"internet": "isotop@inco.com.lb"
},
{
"Category": "Third",
"Number": "23560",
"com-reg-no": "61281",
"NM": "الفريق المتحد للتسويق ش م م",
"L_NM": "United MarketingTeam Co.ltd",
"Last Subscription": "10-Jan-17",
"Industrial certificate no": "1991",
"Industrial certificate date": "1-Jun-17",
"ACTIVITY": "تجارة جملة موادغذائية وصناعة الكعك والبسكويت",
"Activity-L": "Wholesale of foodstuffs & manufacture of biscuits & cakes",
"ADRESS": "ملك ايفون الحاج\u001c - حي مار جرجس\u001c - كفرياسين - كسروان",
"TEL1": "09/855509",
"TEL2": "03/222661",
"TEL3": "03/333668",
"internet": "umt333green@gmail.com"
},
{
"Category": "Second",
"Number": "6514",
"com-reg-no": "2003377",
"NM": "هاردوود فلورنغ كومباني ش م م",
"L_NM": "Hardwood Flooring Company sarl",
"Last Subscription": "23-May-17",
"Industrial certificate no": "3984",
"Industrial certificate date": "17-May-18",
"ACTIVITY": "صناعة المفروشات وباركيه خشب",
"Activity-L": "Manufacture of furniture & parquet",
"ADRESS": "ملك ارابيان\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/489038",
"TEL2": "01/500962",
"TEL3": "03/252375",
"internet": ""
},
{
"Category": "Third",
"Number": "24460",
"com-reg-no": "40694",
"NM": "معامل لبكي الصناعية",
"L_NM": "Labaki Industries",
"Last Subscription": "11-Nov-17",
"Industrial certificate no": "3534",
"Industrial certificate date": "4-Mar-18",
"ACTIVITY": "معملا لنشر الصخور",
"Activity-L": "Sawing of rocks",
"ADRESS": "ملك لبكي\u001c - المنطقة الصناعية\u001c - بعبدات - المتن",
"TEL1": "04/821794",
"TEL2": "03/244459",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1638",
"com-reg-no": "2007614",
"NM": "المجموعة اللبنانية للتحميص ش م ل",
"L_NM": "Lebanese Roasting Group sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "137",
"Industrial certificate date": "5-Feb-18",
"ACTIVITY": "تحميص المكسرات والبن",
"Activity-L": "Roasting of nuts & coffee",
"ADRESS": "بناية الياس دانيال ط 1\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/685685",
"TEL2": "01/691601",
"TEL3": "01/685168",
"internet": "info@castanianuts.com"
},
{
"Category": "Third",
"Number": "23593",
"com-reg-no": "2006482",
"NM": "كي بي اي انترناشيونال ش م ل",
"L_NM": "KBE International sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4565",
"Industrial certificate date": "5-Sep-18",
"ACTIVITY": "صناعة اجهزة تكييف الهواء والمجاري المركزية",
"Activity-L": "Manufacture of central A.C & cooling products",
"ADRESS": "ملك بطرس\u001c - المدينة الصناعية\u001c - عين سعادة - المتن",
"TEL1": "01/898268",
"TEL2": "01/897659",
"TEL3": "01/896899",
"internet": "kboutros@kbelebanon.com"
},
{
"Category": "Second",
"Number": "4731",
"com-reg-no": "2007671",
"NM": "شركة ضاهر الصناعية ش م م",
"L_NM": "Daher Industrial Company sarl",
"Last Subscription": "6-Mar-18",
"Industrial certificate no": "4348",
"Industrial certificate date": "21-Jul-18",
"ACTIVITY": "تجارة الات البناء",
"Activity-L": "Trading of construction machinery",
"ADRESS": "ملك ضاهر\u001c - حي النادي\u001c - عمشيت - جبيل",
"TEL1": "09/622423",
"TEL2": "03/325288",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "575",
"com-reg-no": "21344",
"NM": "شركة انطوان كرم للتجارة ش م ل",
"L_NM": "Antoine Karam for Trade and Commerce sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "3954",
"Industrial certificate date": "11-May-18",
"ACTIVITY": "صناعة البياضات المنزلية",
"Activity-L": "Manufacture of linen",
"ADRESS": "ملك كرم ط ارضي\u001c - مار تقلا - شارع سحيما\u001c - الحازمية - بعبدا",
"TEL1": "05/453915",
"TEL2": "03/821121",
"TEL3": "",
"internet": "etsantoinekaram@hotmail.com"
},
{
"Category": "Third",
"Number": "23818",
"com-reg-no": "2002263",
"NM": "شركة دبوق العالمية للطباعة والتجارة العامة ش م م",
"L_NM": "Dbouk International For Printing & General Trading ltd",
"Last Subscription": "16-Feb-18",
"Industrial certificate no": "4938",
"Industrial certificate date": "27-Nov-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "ملك حسن غندور\u001c - شارع معوض\u001c - الشياح - بعبدا",
"TEL1": "01/546171",
"TEL2": "",
"TEL3": "",
"internet": "info@dboukart.com"
},
{
"Category": "Third",
"Number": "30984",
"com-reg-no": "2029922",
"NM": "شركة ليبانيز ابيتيزرس كومباني ال اي سي ش م ل",
"L_NM": "Lebanese Appetizers Company - Lac- sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4331",
"Industrial certificate date": "18-Jul-18",
"ACTIVITY": "تصنيع وتعبئة وتوضيب المعجنات المجمدة (السنبوسك ، الشيش براك .....)",
"Activity-L": "Manufacture & packing of frozon pastry",
"ADRESS": "بناية سان جان ملك عبيد\u001c - شارع سان جان\u001c - روميه - المتن",
"TEL1": "01/896146",
"TEL2": "01/896148",
"TEL3": "04/865155",
"internet": "info@lacleb.com"
},
{
"Category": "Second",
"Number": "4446",
"com-reg-no": "2004694",
"NM": "وود مايكر غاليري ش م ل",
"L_NM": "Wood Maker Gallery sal",
"Last Subscription": "5-Apr-17",
"Industrial certificate no": "3568",
"Industrial certificate date": "9-Mar-18",
"ACTIVITY": "صناعة المفروشات الخشبية والمطابخ",
"Activity-L": "Manufacture of wooden furniture & kitchens",
"ADRESS": "بناية وود مايكر غاليري\u001c - المدينة الصناعية\u001c - زوق مصبح - كسروان",
"TEL1": "09/222556",
"TEL2": "03/341424",
"TEL3": "03/213407",
"internet": "woodmakergallery@hotmail.com"
},
{
"Category": "Fourth",
"Number": "18894",
"com-reg-no": "2002335",
"NM": "بيكرز دريم - توصية بسيطة",
"L_NM": "Baker\'s Dream",
"Last Subscription": "6-Mar-18",
"Industrial certificate no": "578",
"Industrial certificate date": "14-Mar-19",
"ACTIVITY": "صناعة محسنات الخبز",
"Activity-L": "Manufacture of bread improver",
"ADRESS": "بناية حدرج ملك ارانس للمقاولات والتجارة ش م م ط 1\u001c - شارع معوض\u001c - الشياح - بعبدا",
"TEL1": "01/552544",
"TEL2": "03/669623",
"TEL3": "",
"internet": "khodorsaad@hotmail.com"
},
{
"Category": "Second",
"Number": "6053",
"com-reg-no": "2005734",
"NM": "ذي كوكرز ش م م",
"L_NM": "The Cookers sarl",
"Last Subscription": "25-Sep-17",
"Industrial certificate no": "4551",
"Industrial certificate date": "28-Aug-18",
"ACTIVITY": "تقديم المأكولات الجاهزة وصناعة الحلويات الافرنجية",
"Activity-L": "Catering & Manufacture of sweets",
"ADRESS": "ملك شركة مؤسسة ميشال نجار\u001c - المدينة الصناعية\u001c - الفنار - المتن",
"TEL1": "01/249033",
"TEL2": "03/270808",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1938",
"com-reg-no": "2002750",
"NM": "بنتا ش م ل  Benta sal",
"L_NM": "Benta sal",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "4489",
"Industrial certificate date": "14-Jul-18",
"ACTIVITY": "صناعة الادوية",
"Activity-L": "Manufacture of medicines",
"ADRESS": "ملك الشركة\u001c - زوق الخراب - الشارع العام\u001c - ضبية - المتن",
"TEL1": "04/541444",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "23738",
"com-reg-no": "75014",
"NM": "ريانا ش م م",
"L_NM": "Rayana\'s sarl",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "193",
"Industrial certificate date": "15-Jan-19",
"ACTIVITY": "صناعة المجوهرات وترصيع الساعات",
"Activity-L": "Manufacture of jewellery & enchasing of watches",
"ADRESS": "بناية الفقيه\u001c - شارع كنيعو\u001c - المصيطبة - بيروت",
"TEL1": "01/800276",
"TEL2": "03/818060",
"TEL3": "",
"internet": "rayand@rcotunnel.com"
},
{
"Category": "Second",
"Number": "4411",
"com-reg-no": "2001515",
"NM": "غلاس ستوديو ش م م",
"L_NM": "Glass Studio sarl",
"Last Subscription": "21-Jun-17",
"Industrial certificate no": "2158",
"Industrial certificate date": "28-Jun-17",
"ACTIVITY": "معملا للحفر والرسم على الزجاجيات والكريستال والبورسلان",
"Activity-L": "Drawing & engraving on glassware, crystal & porcelain",
"ADRESS": "بناية Delfa 7\u001c - شارع الجاموس\u001c - الحدث - بعبدا",
"TEL1": "01/477111",
"TEL2": "70/477111",
"TEL3": "71/477111",
"internet": "office@glass-studio2000.com"
},
{
"Category": "Third",
"Number": "23732",
"com-reg-no": "2003962",
"NM": "شركة اسعد ضاوي واولاده ش م م",
"L_NM": "Ste. Assaad Daoui et Fils sarl",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "23",
"Industrial certificate date": "13-Dec-18",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك مكارم وحريز\u001c - طريق بيت مري\u001c - المكلس - المتن",
"TEL1": "01/755100",
"TEL2": "01/755200",
"TEL3": "01/698885",
"internet": "info@assaaddaoui.com"
},
{
"Category": "First",
"Number": "429",
"com-reg-no": "12931",
"NM": "اكشر وميداني ولبابيدي وشركاهم - مطاحن الشرق الاوسط",
"L_NM": "Akcshar, Midani & lababidi & Co -Moulins du Moyen Orient",
"Last Subscription": "7-Mar-18",
"Industrial certificate no": "297",
"Industrial certificate date": "29-Jan-19",
"ACTIVITY": "مطحنة للحبوب",
"Activity-L": "Mill of cereal",
"ADRESS": "ملك الشركة\u001c - قرب شركة كهرباء شمعون\u001c - زوق مكايل - كسروان",
"TEL1": "09/211614",
"TEL2": "03/524734",
"TEL3": "01/735522",
"internet": ""
},
{
"Category": "Third",
"Number": "23940",
"com-reg-no": "2005707",
"NM": "افينوكس - تضامن",
"L_NM": "Avinox",
"Last Subscription": "27-Jul-17",
"Industrial certificate no": "4618",
"Industrial certificate date": "19-Mar-18",
"ACTIVITY": "تجارة جملة تجهيزات مطبخية خاصة للمطاعم والفنادق والمستشفيات",
"Activity-L": "Wholesale of kitchenware for restaurants,hotels& hospitals",
"ADRESS": "بناية شربل سجعان\u001c - مار روكز\u001c - الدكوانة - المتن",
"TEL1": "01/682721",
"TEL2": "03/620210",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1621",
"com-reg-no": "2005072",
"NM": "سانيتا برسونا ش م ل",
"L_NM": "Sanita Persona sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "2116",
"Industrial certificate date": "12-Jun-18",
"ACTIVITY": "صناعة المحارم المرطبة والمعطرة",
"Activity-L": "Manufacture of perfumed tissues",
"ADRESS": "ملك افرام\u001c - الاوتوستراد\u001c - عجلتون - كسروان",
"TEL1": "09/214004",
"TEL2": "09/214006",
"TEL3": "",
"internet": "david.dekermanjian@sanitalb.com"
},
{
"Category": "First",
"Number": "5036",
"com-reg-no": "44274",
"NM": "ستروكتور ش م ل",
"L_NM": "Structures sal",
"Last Subscription": "12-May-17",
"Industrial certificate no": "1993",
"Industrial certificate date": "1-Jun-17",
"ACTIVITY": "معملا لصب احجار الباطون",
"Activity-L": "Factory of concrete stones",
"ADRESS": "ملك داغر\u001c - شارع باستور\u001c - الجميزة - بيروت",
"TEL1": "09/478256",
"TEL2": "01/562563",
"TEL3": "03/313222",
"internet": "structures@ppb-liban.com"
},
{
"Category": "Second",
"Number": "4585",
"com-reg-no": "1002716",
"NM": "Pate Boulanger",
"L_NM": "Pate Boulanger",
"Last Subscription": "15-Feb-18",
"Industrial certificate no": "3790",
"Industrial certificate date": "8-Apr-18",
"ACTIVITY": "فرن للخبز الافرنجي والمعجنات",
"Activity-L": "Backery for bread & pastry",
"ADRESS": "بناية الكفوري\u001c - حي الياس بعقليني - شارع ساسين\u001c - الاشرفية - بيروت",
"TEL1": "01/322662",
"TEL2": "03/290587",
"TEL3": "01/501100",
"internet": "info@pateboulanger.com"
},
{
"Category": "Third",
"Number": "23489",
"com-reg-no": "2004392",
"NM": "الشركة اللبنانية الخليجية ش م م",
"L_NM": "Lebanese - Gulf Co sarl",
"Last Subscription": "3-Mar-18",
"Industrial certificate no": "410",
"Industrial certificate date": "14-Sep-16",
"ACTIVITY": "تجارة جملة الالبسة الخاصة بالمستشفيات والمطاعم والفنادق",
"Activity-L": "Wholesale of clothes for hospitals, restaurants, & hotels",
"ADRESS": "ملك وفيق عيد\u001c - حي الكروم - الشارع العام\u001c - بشامون - عاليه",
"TEL1": "03/317622",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1855",
"com-reg-no": "2002492",
"NM": "شركة حلباوي اخوان ش م م",
"L_NM": "Helbawi Brothers Co sarl",
"Last Subscription": "27-Feb-18",
"Industrial certificate no": "2518",
"Industrial certificate date": "3-Mar-18",
"ACTIVITY": "تعبئة الحبوب وطحن وتعبئة البهارات",
"Activity-L": "Packing of cereals & grinding of spices",
"ADRESS": "بناية الزين\u001c - شارع الرويس\u001c - حارة حريك - بعبدا",
"TEL1": "03/220893",
"TEL2": "03/220895+6",
"TEL3": "01/559058+9",
"internet": "helbawi@helbawibros.com"
},
{
"Category": "Second",
"Number": "4405",
"com-reg-no": "52129",
"NM": "مجوهرات مكرزل ش م م",
"L_NM": "Joallerie Moukarzel sarl",
"Last Subscription": "26-Jan-18",
"Industrial certificate no": "2756",
"Industrial certificate date": "3-Apr-18",
"ACTIVITY": "صناعة وتجارة المجوهرات",
"Activity-L": "Manufacture & trading of Jewelry",
"ADRESS": "سنتر Kaya\u001c - الساحة\u001c - انطلياس - المتن",
"TEL1": "04/520600",
"TEL2": "03/520600",
"TEL3": "",
"internet": "info@moukarzeljewelry.com"
},
{
"Category": "Third",
"Number": "23496",
"com-reg-no": "1002533",
"NM": "شركة بادغيش اللبنانية المحدودة -BALC - ش م م",
"L_NM": "Badoghaish Lebanese company ltd - BALC - sarl",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "2975",
"Industrial certificate date": "11-Jul-18",
"ACTIVITY": "صناعة مستحضرات التجميل ولوازم الزينة",
"Activity-L": "Manufacture of cosmetics",
"ADRESS": "بناية مهدي التاجر\u001c - شارع كليمنصو\u001c - رأس بيروت - بيروت",
"TEL1": "01/371091",
"TEL2": "01/371092",
"TEL3": "03/053629",
"internet": "rabih_sall@hotmail.com"
},
{
"Category": "Third",
"Number": "23903",
"com-reg-no": "1003819",
"NM": "شركة الرشيدي للتجارة والصناعة ش م م",
"L_NM": "El Rashidy Company for Trading and Industry sarl",
"Last Subscription": "19-Apr-17",
"Industrial certificate no": "3948",
"Industrial certificate date": "11-May-18",
"ACTIVITY": "صناعة المعجنات والمغربية",
"Activity-L": "Manufacture of pastries",
"ADRESS": "بناية شاهين وبطل\u001c - شارع محي الدين الخياط\u001c - المصيطبة - بيروت",
"TEL1": "01/743133",
"TEL2": "03/367270",
"TEL3": "03/005310",
"internet": "helrachidi@hotmail.com"
},
{
"Category": "Excellent",
"Number": "1376",
"com-reg-no": "1003906",
"NM": "باش سناكس ش م ل",
"L_NM": "Bach Snacks sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4133",
"Industrial certificate date": "13-Jun-18",
"ACTIVITY": "صناعة رقائق البطاطا",
"Activity-L": "Manufacture of potato chips",
"ADRESS": "ملك الشركة\u001c - المنطقة الصناعية - قرب مصنع ليسيكو\u001c - كفرشيما - بعبدا",
"TEL1": "05/431555",
"TEL2": "05/431720",
"TEL3": "03/290292",
"internet": "bachsnacks@bachsnacks.com"
},
{
"Category": "Third",
"Number": "23673",
"com-reg-no": "2003627",
"NM": "شركة ايتيفير - حكيم لصناعة الزجاج ش م م",
"L_NM": "Etiver - Hokayem Glass Industry Ltd",
"Last Subscription": "21-Feb-17",
"Industrial certificate no": "3080",
"Industrial certificate date": "1-Jul-17",
"ACTIVITY": "صناعة الواح الزجاج والمرايا",
"Activity-L": "Manufacture of glass & mirrors",
"ADRESS": "ملك الرهبانية المارونية المريمية\u001c - الشارع العام \u001c - زوق مصبح - كسروان",
"TEL1": "09/223236",
"TEL2": "09/223237",
"TEL3": "03/315851",
"internet": "etiver@hotmail.com"
},
{
"Category": "Second",
"Number": "7002",
"com-reg-no": "64240",
"NM": "مؤسسة اورينت للتجليد الفني والطباعة والتجارة العامة والصناعات الجلدية",
"L_NM": "Orient Est Technical Bookbinding,printing,General Trading &leather products",
"Last Subscription": "7-Mar-17",
"Industrial certificate no": "3509",
"Industrial certificate date": "1-Mar-18",
"ACTIVITY": "صناعة االتجليد الفني",
"Activity-L": "Manufacture of bookbinding",
"ADRESS": "ملك يحي وفقيه ودروبي\u001c - شارع الجاموس\u001c - برج البراجنة - بعبدا",
"TEL1": "01/477335",
"TEL2": "03/569846",
"TEL3": "",
"internet": "orient60@idm.net.lb"
},
{
"Category": "Third",
"Number": "23788",
"com-reg-no": "72692",
"NM": "عطار ستيل ش م م",
"L_NM": "Attar Steel sarl",
"Last Subscription": "22-Jan-18",
"Industrial certificate no": "2681",
"Industrial certificate date": "12-Jan-18",
"ACTIVITY": "صناعة المنجور المعدني",
"Activity-L": "Manufacture of metallic panelling",
"ADRESS": "ملك شهاب\u001c - الشارع العام\u001c - خلده - عاليه",
"TEL1": "05/813851",
"TEL2": "05/802604",
"TEL3": "03/221872",
"internet": "sales@attarsteel.com"
},
{
"Category": "Second",
"Number": "4433",
"com-reg-no": "65340",
"NM": "لو مونويزيه ش م م",
"L_NM": "Le Menuisier sarl",
"Last Subscription": "30-Jan-18",
"Industrial certificate no": "130",
"Industrial certificate date": "3-Jan-19",
"ACTIVITY": "صناعة المفروشات",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك صليبا\u001c - الشارع العام\u001c - بتغرين - المتن",
"TEL1": "04/270726",
"TEL2": "03/384388",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "4430",
"com-reg-no": "71679",
"NM": "لوجيان -Legeant",
"L_NM": "Legeant",
"Last Subscription": "23-Jun-17",
"Industrial certificate no": "4142",
"Industrial certificate date": "14-Jun-18",
"ACTIVITY": "معملا للاشغال المعدنية واعمال الحدادة الافرنجيه",
"Activity-L": "Factory of metal works & smithery",
"ADRESS": "ملك وقف مار مارون عمشيت\u001c - طريق بشللي\u001c - بلاط - جبيل",
"TEL1": "09/795500",
"TEL2": "03/608012",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "19113",
"com-reg-no": "64174",
"NM": "مجوهرات لوكا",
"L_NM": "Bijouterie Luka",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "4587",
"Industrial certificate date": "12-Sep-18",
"ACTIVITY": "صناعة المجوهرات",
"Activity-L": "Manufacture of jewellery",
"ADRESS": "سنتر ارين\u001c - شارع العريض\u001c - برج حمود - المتن",
"TEL1": "01/267047",
"TEL2": "03/444110",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "4334",
"com-reg-no": "2005025",
"NM": "لا فوتيل ش م م",
"L_NM": "Lavotel sarl",
"Last Subscription": "22-Mar-18",
"Industrial certificate no": "661",
"Industrial certificate date": "22-Mar-19",
"ACTIVITY": "مصبغة",
"Activity-L": "Laundry",
"ADRESS": "ملك صقر\u001c - الشارع العام\u001c - روميه - المتن",
"TEL1": "03/319310",
"TEL2": "",
"TEL3": "",
"internet": "lavotel@yahoo.com"
},
{
"Category": "Second",
"Number": "5778",
"com-reg-no": "63771",
"NM": "مشرق للصناعة والتعهدات",
"L_NM": "Mechreck For Industry & Contracting",
"Last Subscription": "30-May-17",
"Industrial certificate no": "4019",
"Industrial certificate date": "23-May-18",
"ACTIVITY": "صناعة الحدادة الافرنجية",
"Activity-L": "Manufacture of smithery",
"ADRESS": "ملك مشرق\u001c - القلعة - حي الغزالة\u001c - المكلس - المتن",
"TEL1": "01/692286",
"TEL2": "03/290286",
"TEL3": "",
"internet": "mechreck@terra.net.lb"
},
{
"Category": "Excellent",
"Number": "1583",
"com-reg-no": "2003201",
"NM": "الومكو ش م ل",
"L_NM": "Alumco sal",
"Last Subscription": "20-Oct-17",
"Industrial certificate no": "2865",
"Industrial certificate date": "18-Nov-17",
"ACTIVITY": "صناعة المنجور المعدني",
"Activity-L": "Manufacture of metallic panelling",
"ADRESS": "ملك الشركة\u001c - القبة - طريق صيدا القديمة\u001c - الشويفات - عاليه",
"TEL1": "05/433335",
"TEL2": "05/433336",
"TEL3": "05/433337",
"internet": "info.lebanon@alumcogroup.com"
},
{
"Category": "First",
"Number": "4292",
"com-reg-no": "2004920",
"NM": "كارلما ش م ل",
"L_NM": "Carlama sal",
"Last Subscription": "25-Jan-18",
"Industrial certificate no": "3913",
"Industrial certificate date": "4-May-18",
"ACTIVITY": "صناعة كاروسري الاليات والشاحنات",
"Activity-L": "Manufacture of vehicle & van bodies",
"ADRESS": "بناية ابي اللمع\u001c - شارع ابي اللمع\u001c - زوق الخراب - المتن",
"TEL1": "04/542810",
"TEL2": "04/542811",
"TEL3": "04/542812",
"internet": "info@abillama.net"
},
{
"Category": "Third",
"Number": "24400",
"com-reg-no": "2000524",
"NM": "شركة جورج الحج برينتغ برس ج ح ب ب  - تضامن",
"L_NM": "Ste. Georges Hajj Printing Press G.H.P.P",
"Last Subscription": "22-Feb-18",
"Industrial certificate no": "3575",
"Industrial certificate date": "9-Mar-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "بناية رياشي - ط سفلي\u001c - شارع الدكتور سلهب\u001c - انطلياس - المتن",
"TEL1": "04/520931",
"TEL2": "70/520931",
"TEL3": "",
"internet": "ghpp@terra.net.lb"
},
{
"Category": "Second",
"Number": "6328",
"com-reg-no": "2004825",
"NM": "زعني غروب للصناعة والتجارة لصاحبها احمد غازي الزغني",
"L_NM": "Zeenni Group for Industries and Trading",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "3597",
"Industrial certificate date": "14-Mar-18",
"ACTIVITY": "صناعة الحدادة الافرنجية",
"Activity-L": " Manufacture of smithery",
"ADRESS": "ملك نزيه بعجور\u001c - شارع بعجور\u001c - حارة حريك - بعبدا",
"TEL1": "01/277408",
"TEL2": "03/854571",
"TEL3": "",
"internet": "zeenni_group@hotmail.com"
},
{
"Category": "Third",
"Number": "23408",
"com-reg-no": "76960",
"NM": "فايد ش م م",
"L_NM": "Fayed sarl",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "62",
"Industrial certificate date": "20-Jun-18",
"ACTIVITY": "تجارة الثريات، لوازم الانارة، تحف منزلية من كريستال وبورسلان وخشب",
"Activity-L": "Trading of chandeliers & lighting articles & home appliances",
"ADRESS": "بناية فايد\u001c - الشارع العام\u001c - برج ابي حيدر - بيروت",
"TEL1": "01/302218",
"TEL2": "01/304304",
"TEL3": "03/845831",
"internet": "info@fayedstores.com"
},
{
"Category": "Third",
"Number": "23346",
"com-reg-no": "1003421",
"NM": "شركة كوزماشاين ش م م",
"L_NM": "Cosmashine sarl",
"Last Subscription": "23-Jan-18",
"Industrial certificate no": "4269",
"Industrial certificate date": "10-Jul-18",
"ACTIVITY": "صناعة مستحضرات التجميل والشامبو",
"Activity-L": "Manufacture of cosmetics & shampoo",
"ADRESS": "بناية الامين\u001c - شارع البدوي\u001c - المزرعة - بيروت",
"TEL1": "03/905317",
"TEL2": "01/648185",
"TEL3": "",
"internet": "cosmashine@terra.net.lb"
},
{
"Category": "Fourth",
"Number": "26855",
"com-reg-no": "2036715",
"NM": "صعب انتربرايز ش م م",
"L_NM": "Saab Enterprises sarl",
"Last Subscription": "22-Jul-17",
"Industrial certificate no": "2771",
"Industrial certificate date": "7-Jan-16",
"ACTIVITY": "تجارة مواد بناء",
"Activity-L": "Trading of building materials",
"ADRESS": "ملك محمد صعب\u001c - القبة\u001c - الشويفات - عاليه",
"TEL1": "05/435363",
"TEL2": "03/044444",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "4991",
"com-reg-no": "68260",
"NM": "ايسبورغ ش م م - Iceberg sarl",
"L_NM": "Iceberg sarl",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4747",
"Industrial certificate date": "17-Oct-18",
"ACTIVITY": "تجميع وحدات تكييف الهواء وغرف التبريد ومجاري الهواء",
"Activity-L": "Manufacture of air- conditions\' units, cooling room & ventilation equipment",
"ADRESS": "ملك فرج الله وحسون\u001c - شارع المهمول\u001c - الحدث - بعبدا",
"TEL1": "05/461626",
"TEL2": "01/495280",
"TEL3": "",
"internet": "info@iceberg-lb.com"
},
{
"Category": "Excellent",
"Number": "1744",
"com-reg-no": "2002852",
"NM": "م ج انترناشونال دايمند تولز ش م ل",
"L_NM": "MG International Diamond Tools sal",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "194",
"Industrial certificate date": "15-Jan-19",
"ACTIVITY": "صناعة ادوات صناعية للقطع والنشر والجلي (ديسكات، شفر، اسنان وشريط الماسي)",
"Activity-L": "Manufacture of cutting tools inlaid with diamonds",
"ADRESS": "ملك شركة ميكر للصناعة ش م م\u001c - المدينة الصناعية\u001c - عين سعاده - المتن",
"TEL1": "01/881010",
"TEL2": "",
"TEL3": "",
"internet": "mgidt@idm.net.lb"
},
{
"Category": "First",
"Number": "5259",
"com-reg-no": "67539",
"NM": "واكيم ترايدينغ ش م م",
"L_NM": "Wakim Trading sarl",
"Last Subscription": "18-Oct-17",
"Industrial certificate no": "4688",
"Industrial certificate date": "9-Oct-18",
"ACTIVITY": "صناعة المفروشات والمطابخ الخشبية",
"Activity-L": "Manufacture of wooden furniture & kitchens",
"ADRESS": "بناية واكيم\u001c - بولفار سن الفيل\u001c - البوشرية - المتن",
"TEL1": "01/999196",
"TEL2": "01/999197",
"TEL3": "",
"internet": "swakim@wakimest.com.lb"
},
{
"Category": "Third",
"Number": "11703",
"com-reg-no": "43084",
"NM": "سنتشوري ش م م",
"L_NM": "Century sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "4907",
"Industrial certificate date": "21-Nov-18",
"ACTIVITY": "صناعة المفروشات",
"Activity-L": "Manufacture of furniture",
"ADRESS": "بناية الاتحاد الوطني\u001c - شارع سبيرز\u001c - الصنائع - بيروت",
"TEL1": "01/879043",
"TEL2": "",
"TEL3": "",
"internet": "century@centurystyle.com"
},
{
"Category": "Third",
"Number": "23260",
"com-reg-no": "2003526",
"NM": "شركة عصام ومشاركوه ش م م",
"L_NM": "Issam & Co sarl",
"Last Subscription": "5-May-17",
"Industrial certificate no": "3900",
"Industrial certificate date": "29-Apr-18",
"ACTIVITY": "صناعة انعال واكعاب لزوم الاحذية",
"Activity-L": "Manufacture of parts of footwear",
"ADRESS": "بناية الهلالين\u001c - حي الابيض الشارع العام مقابل مسجد القائم\u001c - حارة حريك - بعبدا",
"TEL1": "01/545528",
"TEL2": "01/553571",
"TEL3": "",
"internet": "issam8236@yahoo.com"
},
{
"Category": "First",
"Number": "4277",
"com-reg-no": "2000631",
"NM": "مؤسسة ابي راشد",
"L_NM": "Abi Rached Est",
"Last Subscription": "15-Jan-18",
"Industrial certificate no": "4195",
"Industrial certificate date": "28-Jun-18",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك طانيوس ابي راشد\u001c - شارع الغزالي\u001c - المكلس - المتن",
"TEL1": "01/493730",
"TEL2": "01/510824",
"TEL3": "03/340270",
"internet": "info@abirachedest.com"
},
{
"Category": "Third",
"Number": "28775",
"com-reg-no": "77672",
"NM": "شركة كراميل للصناعة والتجارة - مروان بدر وشركاه - ش م م",
"L_NM": "Caramel Industrial & Trading Co sarl",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4158",
"Industrial certificate date": "19-Jun-18",
"ACTIVITY": "صناعة الالبسة النسائية والولادية",
"Activity-L": "Manufacture of ladies\' & children\'s clothes",
"ADRESS": "بناية عصام سعد\u001c - شارع مناصفي\u001c - زقاق البلاط - بيروت",
"TEL1": "01/377514",
"TEL2": "01/377870",
"TEL3": "03/882873",
"internet": "marwanl16@hotmail.com"
},
{
"Category": "Second",
"Number": "4859",
"com-reg-no": "2002130",
"NM": "لابنديل - La Pendule",
"L_NM": "La Pendule",
"Last Subscription": "25-Jan-18",
"Industrial certificate no": "382",
"Industrial certificate date": "13-Feb-19",
"ACTIVITY": "صناعة المجوهرات وترصيع الساعات",
"Activity-L": "Manufacture of jewellery & enchasing of watches",
"ADRESS": "بناية مخيتاريان ط2\u001c - ساحة البلدية\u001c - برج حمود - المتن",
"TEL1": "01/245006",
"TEL2": "03/320027",
"TEL3": "",
"internet": "pavlo_dorian@yahoo.com"
},
{
"Category": "Third",
"Number": "23175",
"com-reg-no": "65875",
"NM": "شركة اناكيم الصناعية ش م م",
"L_NM": "Anachem Industrial sarl",
"Last Subscription": "14-Jan-17",
"Industrial certificate no": "2878",
"Industrial certificate date": "19-Nov-17",
"ACTIVITY": "صناعة السوائل المنظفة، المطهرة والمعقمة، والشامبو",
"Activity-L": "Manufacture of detergents & Shampoo",
"ADRESS": "ملك الحاج\u001c - الشارع الرئيسي\u001c - المكلس - المتن",
"TEL1": "01/484685",
"TEL2": "03/626050",
"TEL3": "",
"internet": "anachem@inco.com.lb"
},
{
"Category": "Third",
"Number": "23242",
"com-reg-no": "2003365",
"NM": "علي حسين فاعور",
"L_NM": "Ali Hussein Faour",
"Last Subscription": "7-Oct-17",
"Industrial certificate no": "3680",
"Industrial certificate date": "23-Mar-18",
"ACTIVITY": "صناعة احذية رجالية، نسائية وولادية",
"Activity-L": "Manufacturing of men\'s ,ladies\'  & children\'s shoes",
"ADRESS": "ملك منى نوفل\u001c - شارع الجاموس - خلف مدرسة الكفاءات\u001c - الحدث - بعبدا",
"TEL1": "01/470914",
"TEL2": "03/440373",
"TEL3": "03/330472",
"internet": "sachigroup_lb@hotmail.com"
},
{
"Category": "Third",
"Number": "23246",
"com-reg-no": "72349",
"NM": "شركة ميلانو ستيل واير ش م م",
"L_NM": "Milano Steel Wire Company sarl",
"Last Subscription": "24-Feb-17",
"Industrial certificate no": "3886",
"Industrial certificate date": "25-Apr-18",
"ACTIVITY": "اشغال معدنية منزلية (الفيرفورجيه)",
"Activity-L": "Manufacture of home metal works (ferforgé)",
"ADRESS": "ملك كامل ابو غيدا\u001c - القبه - اوتوستراد خلده\u001c - الشويفات - عاليه",
"TEL1": "05/802815",
"TEL2": "05/801511",
"TEL3": "03/912282",
"internet": "info@milanosteel.net"
},
{
"Category": "First",
"Number": "5143",
"com-reg-no": "71419",
"NM": "ذي روستر ش م ل",
"L_NM": "The Roaster sal",
"Last Subscription": "5-Feb-18",
"Industrial certificate no": "4151",
"Industrial certificate date": "16-Jun-18",
"ACTIVITY": "معملا لتحميص البن وتجارة مشروبات روحية",
"Activity-L": "Roasting of coffee & trading of alcoholic drinks",
"ADRESS": "بناية الدكتور يزبك\u001c - الاوتوستراد\u001c - البوشرية - المتن",
"TEL1": "04/720520",
"TEL2": "",
"TEL3": "",
"internet": "info@the-roaster.com"
},
{
"Category": "Third",
"Number": "22582",
"com-reg-no": "61862",
"NM": "شركة سميزار الصناعية - سمير عازار واولاده ش م م",
"L_NM": "Société Samizar pour l\'industrie - Samir Azar et Fils sarl",
"Last Subscription": "17-Mar-18",
"Industrial certificate no": "4297",
"Industrial certificate date": "29-Jul-18",
"ACTIVITY": "معملا لنشر وتفصيل وجلي الرخام والصخور",
"Activity-L": "Cutting of marble & rocks",
"ADRESS": "ملك عازار\u001c - الشارع العام\u001c - خرائب نهر ابراهيم - كسروان",
"TEL1": "09/446978",
"TEL2": "09/446979",
"TEL3": "03/660089",
"internet": "info@samizar.com"
},
{
"Category": "First",
"Number": "4862",
"com-reg-no": "75811",
"NM": "برنت ووركس ش م ل",
"L_NM": "Printworks sal",
"Last Subscription": "3-Feb-18",
"Industrial certificate no": "4898",
"Industrial certificate date": "17-Dec-18",
"ACTIVITY": "خدمات الطباعة",
"Activity-L": "Digital printing",
"ADRESS": "بناية الشركة اللبنانية للمعادن\u001c - الكرنتينا\u001c - المدور - بيروت",
"TEL1": "01/577772",
"TEL2": "01/999985",
"TEL3": "03/257545",
"internet": "info@printw.com"
},
{
"Category": "Third",
"Number": "23409",
"com-reg-no": "1002613",
"NM": "شركة كرم وكرم للزراعة والصناعة والتجارة - اي كيك - ش م م",
"L_NM": "Agriculture for Karam Industry & Commerce for Karam - A KICK- sarl",
"Last Subscription": "11-Jan-17",
"Industrial certificate no": "3175",
"Industrial certificate date": "25-Feb-18",
"ACTIVITY": "صناعة النبيذ والكحول المقطرة",
"Activity-L": "Manufacture of wines & distilled alcoholic",
"ADRESS": "ملك ابراهيم مسلماني\u001c - شارع ابراهيم سير\u001c - القنطاري - بيروت",
"TEL1": "01/370519",
"TEL2": "03/373703",
"TEL3": "01/370516",
"internet": "contact@karamwines.com"
},
{
"Category": "Fourth",
"Number": "25982",
"com-reg-no": "2026973",
"NM": "شركة مجوهرات مطر ش م م",
"L_NM": "Mattar Jewellery sarl",
"Last Subscription": "24-Jan-18",
"Industrial certificate no": "3732",
"Industrial certificate date": "31-Mar-18",
"ACTIVITY": "صناعة وتركيب الالماس والاحجار الكريمة",
"Activity-L": "Manufacture of jewelry & assorting of precious stones",
"ADRESS": "بناية سانتا ماريا ط 1\u001c -  شارع مار يوحنا\u001c - سد البوشرية - المتن",
"TEL1": "01/890454",
"TEL2": "03/977050",
"TEL3": "",
"internet": "miledmatar@hotmail.com"
},
{
"Category": "First",
"Number": "4605",
"com-reg-no": "2011327",
"NM": "شركة ميتس انيرجي ش م ل",
"L_NM": "Mets Energy sal",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "644",
"Industrial certificate date": "21-Jun-18",
"ACTIVITY": "تجارة المولدات الكهربائية",
"Activity-L": "Trading of electrical generators",
"ADRESS": "ملك شركة عقارية الساحل الحديثة ش م ل\u001c - القبة\u001c - الشويفات - عاليه",
"TEL1": "05/801401",
"TEL2": "03/810023",
"TEL3": "",
"internet": "info@metslb.com"
},
{
"Category": "First",
"Number": "4606",
"com-reg-no": "2011614",
"NM": "ركتنكل جون ش م ل",
"L_NM": "Rectangle Jaune sal",
"Last Subscription": "21-Mar-18",
"Industrial certificate no": "556",
"Industrial certificate date": "12-Mar-19",
"ACTIVITY": "صناعة الالبسة الرجالية والولادية",
"Activity-L": "Manufacture of clothing for men & children",
"ADRESS": "بناية ابو جوده\u001c - حي بقنايا - شارع ابونا يعقوب\u001c - جل الديب - المتن",
"TEL1": "04/723723",
"TEL2": "04/723724",
"TEL3": "",
"internet": "carbid@rectanglejaune.com"
},
{
"Category": "Fourth",
"Number": "29244",
"com-reg-no": "2018840",
"NM": "Profitech sarl Aluminium Hmeidani",
"L_NM": "Profitech sarl Aluminium Hmeidani",
"Last Subscription": "21-Feb-18",
"Industrial certificate no": "377",
"Industrial certificate date": "13-Feb-19",
"ACTIVITY": "تجارة منجور وواجهات المنيوم",
"Activity-L": "Trading of aluminium panels & front",
"ADRESS": "بناية حميداني\u001c - المنطقة الصناعية - حي اليهودية\u001c - بشامون - عاليه",
"TEL1": "05/812006",
"TEL2": "03/208723",
"TEL3": "",
"internet": " hmeidani@hmeidani.com"
},
{
"Category": "Second",
"Number": "4292",
"com-reg-no": "2001282",
"NM": "ستورك ديستريبيوشن ش م ل",
"L_NM": "Stork Distribution sal",
"Last Subscription": "1-Feb-18",
"Industrial certificate no": "4786",
"Industrial certificate date": "24-Apr-18",
"ACTIVITY": "صناعة العصير المعلب والمشروبات غير الكحولية",
"Activity-L": "Manufacture of juice & non alcoholic drinks",
"ADRESS": "ملك دير مار الياس\u001c - الشاوية - شارع 40\u001c - ذوق مصبح - كسروان",
"TEL1": "09/218410",
"TEL2": "09/217510",
"TEL3": "",
"internet": "info@storkdistribution.com"
},
{
"Category": "Third",
"Number": "23105",
"com-reg-no": "70718",
"NM": "باسيل سوده للازياء ش م م",
"L_NM": "Basil Soda Couture ltd",
"Last Subscription": "7-Feb-18",
"Industrial certificate no": "513",
"Industrial certificate date": "6-Mar-19",
"ACTIVITY": "تصميم الازياء وصناعة الالبسة",
"Activity-L": "Fashion design & manufacture of ladies\' clothes",
"ADRESS": "بناية باسيل سوده ملك نجم\u001c - شارع ديمتري حايك -مقابل قصر نورا\u001c - حرش تابت - المتن",
"TEL1": "01/511775",
"TEL2": "01/511885",
"TEL3": "03/196256",
"internet": "basil@basilsoda.com"
},
{
"Category": "Excellent",
"Number": "1596",
"com-reg-no": "64436",
"NM": "بيضون ستور Beydoun Store",
"L_NM": "Beydoun Store",
"Last Subscription": "4-Mar-17",
"Industrial certificate no": "3459",
"Industrial certificate date": "23-Feb-18",
"ACTIVITY": "صناعة وتجارة الخيم والبرادي والستائرالزجاجية",
"Activity-L": "Manufacture & Trading of tents, curtains &securite",
"ADRESS": "ملك احمد بيضون\u001c - شارع الاستقلال\u001c - البسطة التحتا - بيروت",
"TEL1": "01/666660",
"TEL2": "01/659890",
"TEL3": "03/658853",
"internet": "sales@beydounstore.com.lb"
},
{
"Category": "Third",
"Number": "23088",
"com-reg-no": "62860",
"NM": "سعد غروب للتجارة والصناعة ش م م",
"L_NM": "Saad Commercial & Industrial Group sarl",
"Last Subscription": "10-Nov-17",
"Industrial certificate no": "1343",
"Industrial certificate date": "24-Feb-17",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك فادي وانطوان سعد\u001c -  الشارع العام\u001c -  زوق مصبح - كسروان",
"TEL1": "09/217915",
"TEL2": "",
"TEL3": "",
"internet": "scigroup@idm.net.lb"
},
{
"Category": "Third",
"Number": "22572",
"com-reg-no": "58401",
"NM": "شقير غروب ش م م",
"L_NM": "Choucair Group sarl",
"Last Subscription": "31-Jan-18",
"Industrial certificate no": "4370",
"Industrial certificate date": "25-Jul-18",
"ACTIVITY": "صناعة احجار الباطون ونشر وجلي الرخام والغرانيت",
"Activity-L": "Manufacture of concrete stones & cutting of marble & granite",
"ADRESS": "ملك شقير\u001c - حرش تابت\u001c - سن الفيل - المتن",
"TEL1": "01/485334",
"TEL2": "01/485335",
"TEL3": "03/323200",
"internet": "georges@choucairgroup.com"
},
{
"Category": "Third",
"Number": "22969",
"com-reg-no": "2003271",
"NM": "م . رحال واولاده ش م م",
"L_NM": "M. Rahal & Sons sarl",
"Last Subscription": "12-Apr-17",
"Industrial certificate no": "2884",
"Industrial certificate date": "23-Nov-17",
"ACTIVITY": "صناعة الالبسة الرجالية والنسائية",
"Activity-L": "Manufacure of men & women clothes",
"ADRESS": "ملك محمد رحال\u001c - شارع العنان\u001c - حارة حريك - بعبدا",
"TEL1": "03/649065",
"TEL2": "01/478065",
"TEL3": "",
"internet": "mehdirahhal@yahoo.com"
},
{
"Category": "Excellent",
"Number": "1833",
"com-reg-no": "2003462",
"NM": "شركة دكروب اللبنانية لانتاج الباطون الجاهز ش م م",
"L_NM": "Dakroub Ready Mix Concrete of Lebanon - Rmcl - Ltd",
"Last Subscription": "17-Jul-17",
"Industrial certificate no": "2296",
"Industrial certificate date": "22-Jul-17",
"ACTIVITY": "تنفيذ تعهدات الهندسة المدنية وصناعة الباطون الجاهز",
"Activity-L": "Civil Contracting & manufacture of ready mix concrete",
"ADRESS": "بناية دكروب ط 1\u001c - شارع الامراء\u001c - الشويفات - عاليه",
"TEL1": "05/431573",
"TEL2": "03/752055",
"TEL3": "",
"internet": "dkrmcl@hotmail.com"
},
{
"Category": "Third",
"Number": "22839",
"com-reg-no": "43082",
"NM": "شركة النخيل للمواد الغذائية ش م م",
"L_NM": "Al Nakhil Co. for Food Production sarl",
"Last Subscription": "29-Jan-18",
"Industrial certificate no": "4483",
"Industrial certificate date": "12-Aug-18",
"ACTIVITY": "صناعة الحلاوة والطحينة، تعبئة الكبيس وماء الزهر والورد والزيت والزيتون",
"Activity-L": "Manufacture of halawa & tahina,filling of pickles,rose water,oil&olive oil",
"ADRESS": "ملك شركة النخيل للمواد الغذائية ش م م\u001c - الشارع العام\u001c - دير شمرا - المتن",
"TEL1": "04/984394+5",
"TEL2": "03/688101",
"TEL3": "03/688102",
"internet": "alnakhilco@hotmail.com"
},
{
"Category": "Third",
"Number": "22540",
"com-reg-no": "2002114",
"NM": "بايبرمون ش م م",
"L_NM": "Paper Moon sarl",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "2798",
"Industrial certificate date": "10-Apr-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "ملك الغول\u001c - المنطقة الصناعية\u001c - رومية - المتن",
"TEL1": "01/899288",
"TEL2": "03/361616",
"TEL3": "03/230107",
"internet": "gabyabisaab@papermoon-pp.com"
},
{
"Category": "Fourth",
"Number": "18147",
"com-reg-no": "70408",
"NM": "فادي عطوي - اشغال خشبية وديكور",
"L_NM": "Fadi Atwi",
"Last Subscription": "21-Jun-17",
"Industrial certificate no": "4689",
"Industrial certificate date": "9-Oct-18",
"ACTIVITY": "صناعة المفروشات واعمال الديكور",
"Activity-L": "Manufacture of furniture & decoration services",
"ADRESS": "ملك ندى الدبس\u001c - المدينة الصناعية\u001c - المكلس - المتن",
"TEL1": "01/687937",
"TEL2": "03/247408",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "8029",
"com-reg-no": "2007785",
"NM": "GAF & Co S.A.L.",
"L_NM": "GAF & Co S.A.L.",
"Last Subscription": "27-May-17",
"Industrial certificate no": "2049",
"Industrial certificate date": "13-Jun-17",
"ACTIVITY": "صناعة الرخام والغرانيت",
"Activity-L": "Marble and Granite industry",
"ADRESS": "ملك عازار -  المدينة الصناعية - نهر ابراهيم - جبيل",
"TEL1": "09/444014",
"TEL2": "09/444484",
"TEL3": "",
"internet": "gaf@gafweb.com"
},
{
"Category": "Third",
"Number": "29168",
"com-reg-no": "2002103",
"NM": "مؤسسة رأفت علي رمضان",
"L_NM": "Raafat Ali Ramadan Est",
"Last Subscription": "1-Mar-18",
"Industrial certificate no": "4592",
"Industrial certificate date": "12-Sep-18",
"ACTIVITY": "صناعة وتعبئة وتغليف مزيل للشعر(سوفت سكين)",
"Activity-L": "Manufacture of depilatory ( Soft Skin )",
"ADRESS": "ملك عادل القمند\u001c - حي قلع شملان\u001c - شملان - عاليه",
"TEL1": "05/270774",
"TEL2": "03/387978",
"TEL3": "",
"internet": "softskin@live.com"
},
{
"Category": "Third",
"Number": "22730",
"com-reg-no": "2001615",
"NM": "كلنور ش م م",
"L_NM": "Kalanor sarl",
"Last Subscription": "2-Jun-17",
"Industrial certificate no": "2891",
"Industrial certificate date": "23-Nov-17",
"ACTIVITY": "صناعة المجوهرات والاحجار الكريمة",
"Activity-L": "Manufacture of jewellery & precious stones",
"ADRESS": "بناية هاربويان (ماسترمول)  ط13\u001c - الشارع العام\u001c - برج حمود - المتن",
"TEL1": "01/251251",
"TEL2": "01/246246",
"TEL3": "",
"internet": "kalanor@inco.com.lb"
},
{
"Category": "Fourth",
"Number": "18207",
"com-reg-no": "1000727",
"NM": "ديلوتشي",
"L_NM": "DELUCHY",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "4642",
"Industrial certificate date": "22-Sep-18",
"ACTIVITY": "تجارة الالبسة النسائية",
"Activity-L": "Trading of ladies clothes",
"ADRESS": "بناية فاخوري ط سفلي\u001c - شارع المصيطبة\u001c - المصيطبة - بيروت",
"TEL1": "01/705781",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "22708",
"com-reg-no": "72183",
"NM": "سكاربينا ش م م",
"L_NM": "Scarbina sarl",
"Last Subscription": "26-Feb-18",
"Industrial certificate no": "3902",
"Industrial certificate date": "29-Apr-18",
"ACTIVITY": "صناعة الاحذية والجزادين النسائية",
"Activity-L": "Manufacture of ladies\' shoes & bags",
"ADRESS": "ملك انطوان بلعيس\u001c - شارع مار مارون\u001c - الجديدة - المتن",
"TEL1": "01/697566",
"TEL2": "01/698566",
"TEL3": "03/517374",
"internet": "info@scarbina.com"
},
{
"Category": "Second",
"Number": "6189",
"com-reg-no": "2002356",
"NM": "امريس لايتينغ ش م ل",
"L_NM": "Emrys Lighting sal",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "4607",
"Industrial certificate date": "15-Sep-18",
"ACTIVITY": "اعمال تأجير المعدات والالات والاجهزة الخاصة بالتصوير السينمائي",
"Activity-L": "Renting of filming systems & equipments",
"ADRESS": "ملك رافي يميزيان\u001c - الشارع العام\u001c - الفنار - المتن",
"TEL1": "03/250641",
"TEL2": "01/696465",
"TEL3": "01/900993",
"internet": "chant@platformstudios.com"
},
{
"Category": "Third",
"Number": "22446",
"com-reg-no": "71661",
"NM": "ا. ايوب واولاده شركة توصية بسيطة",
"L_NM": "A. Ayoub et Fils",
"Last Subscription": "14-Jan-17",
"Industrial certificate no": "2887",
"Industrial certificate date": "23-Nov-17",
"ACTIVITY": "صناعة المفروشات",
"Activity-L": "Manufacture of furniture",
"ADRESS": "ملك اديب ايوب\u001c - المدينة الصناعية - شارع فرا\u001c - الدكوانة - المتن",
"TEL1": "01/683675",
"TEL2": "03/250978",
"TEL3": "",
"internet": "a-ayoub@idm.net.lb"
},
{
"Category": "Fourth",
"Number": "17688",
"com-reg-no": "2051132",
"NM": "يونيبلاست - المعامل الحديثة للميكانيك والبلاستيك - الياس اسعد يونس",
"L_NM": "Y. ouniplast",
"Last Subscription": "25-Jan-18",
"Industrial certificate no": "4319",
"Industrial certificate date": "15-Jul-18",
"ACTIVITY": "صناعة  الاواني المنزلية البلاستيكية",
"Activity-L": "Manufacture of plastic product",
"ADRESS": "ملك حلال ورزق\u001c - شارع الغزال \u001c - المكلس  - المتن",
"TEL1": "03/622964",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "22433",
"com-reg-no": "64982",
"NM": "G.N.D Group sarl",
"L_NM": "G.N.D Group sarl",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4845",
"Industrial certificate date": "9-Nov-18",
"ACTIVITY": "صناعة الالبسة الرجالية والولادية",
"Activity-L": "Manufacture of men\'s & children\'s clothes",
"ADRESS": "ملك غسان ونبيل سابا\u001c - شارع الغزال\u001c - سن الفيل - المتن",
"TEL1": "01/490119",
"TEL2": "03/276702",
"TEL3": "03/649194",
"internet": "gndgroup@wise.net.lb"
},
{
"Category": "Second",
"Number": "7066",
"com-reg-no": "66163",
"NM": "الشركة الصناعية التجارية بونكس ش م م",
"L_NM": "I & T Bonex sarl",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4517",
"Industrial certificate date": "22-Aug-18",
"ACTIVITY": "صناعة المصاعد",
"Activity-L": "Manufacture of elevators",
"ADRESS": "ملك ايمن الجراح\u001c - طريق المطار\u001c - برج البراجنة - بعبدا",
"TEL1": "01/450135",
"TEL2": "01/451009",
"TEL3": "03/646717",
"internet": "stock@bonexlift.com"
},
{
"Category": "Fourth",
"Number": "17620",
"com-reg-no": "2000950",
"NM": "مجوهرات اشجيان",
"L_NM": "Ashjian Jewelers",
"Last Subscription": "3-Nov-17",
"Industrial certificate no": "4050",
"Industrial certificate date": "31-May-18",
"ACTIVITY": "صناعة المجوهرات",
"Activity-L": "Manufacture of Jewelry",
"ADRESS": "ملك جمعية مرعش الارمنية الخيرية\u001c - كمب مرعش\u001c - برج حمود - المتن",
"TEL1": "01/268361",
"TEL2": "03/602505",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "4056",
"com-reg-no": "2000931",
"NM": "الشركة اللبنانية للزراعة والكيمياء ش م ل",
"L_NM": "Société Libanaise d\'Agriculture et de Chimie",
"Last Subscription": "8-Feb-18",
"Industrial certificate no": "3876",
"Industrial certificate date": "6-Feb-19",
"ACTIVITY": "صناعة الاسمدة العضوية وتحضير المبيدات الزراعية",
"Activity-L": "Manufacture of fertilizers & insecticides products",
"ADRESS": "ملك ارنست بدوي\u001c - الميناء الجديدة - \u001c - جونيه - كسروان",
"TEL1": "09/938194",
"TEL2": "09/931534",
"TEL3": "08/511797",
"internet": "slac@dm.net.lb"
},
{
"Category": "Second",
"Number": "6646",
"com-reg-no": "70787",
"NM": "شركة البير مسعد ش م م",
"L_NM": "Albert Massaad sarl",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "3325",
"Industrial certificate date": "8-Feb-18",
"ACTIVITY": "صناعة المفروشات الخشبية والمعدنية(خاصة للمستشفيات ... )",
"Activity-L": "Manufacture of hospital, laboratory & clinic furnitures",
"ADRESS": "ملك مسعد\u001c - الشارع العام\u001c - حصرايل - جبيل",
"TEL1": "01/690341",
"TEL2": "03/643036",
"TEL3": "",
"internet": "henry@albertmassaad.com"
},
{
"Category": "Second",
"Number": "3994",
"com-reg-no": "75384",
"NM": "Blink sal",
"L_NM": "Blink sal",
"Last Subscription": "12-Oct-17",
"Industrial certificate no": "4687",
"Industrial certificate date": "9-Oct-18",
"ACTIVITY": "صناعة اللوحات الاعلانية واعمال تصميم الاعلانات والدعايات",
"Activity-L": "Manufacture of advertising boards & advertising services",
"ADRESS": "ملك جمعية المقاصد الخيرية الاسلامية ط5\u001c - شارع الاورغواي\u001c - المرفأ - بيروت",
"TEL1": "01/986688",
"TEL2": "03/353542",
"TEL3": "",
"internet": "karim.salman@blinkbtl.com"
},
{
"Category": "Excellent",
"Number": "1837",
"com-reg-no": "76113",
"NM": "شركة شمص للطباعة والنشر ش م ل",
"L_NM": "Chamas for Printing & Publishing sal",
"Last Subscription": "16-Feb-18",
"Industrial certificate no": "486",
"Industrial certificate date": "28-Aug-18",
"ACTIVITY": "مطبعة وصناعة علب الكرتون",
"Activity-L": "Printing press& manufacture of carton boxes",
"ADRESS": "كولومبيا سنتر\u001c - كورنيش المزرعة\u001c - وطى المصيطبة - بيروت",
"TEL1": "01/707735",
"TEL2": "01/707736+7",
"TEL3": "03/646491",
"internet": "3achamas@inco.com.lb"
},
{
"Category": "Second",
"Number": "6080",
"com-reg-no": "55572",
"NM": "اكيبلاست ش م م",
"L_NM": "Equiplast sarl",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "2760",
"Industrial certificate date": "4-Apr-18",
"ACTIVITY": "صناعة انابيب بلاستيكية",
"Activity-L": "Manufacture of plastic tubes",
"ADRESS": "ملك نصر الشدياق\u001c - شارع كابلات لبنان\u001c - حالات - جبيل",
"TEL1": "09/448980",
"TEL2": "09/446132",
"TEL3": "03/611632",
"internet": ""
},
{
"Category": "Third",
"Number": "22105",
"com-reg-no": "16770",
"NM": "مطابع معوشي و زكريا - تضامن",
"L_NM": "Imprimeries Meouchy & Zakaria",
"Last Subscription": "20-Feb-18",
"Industrial certificate no": "353",
"Industrial certificate date": "7-Feb-19",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing Press",
"ADRESS": "ملك زكريا ومعوشي\u001c - المدينة الصناعية\u001c - سد البوشرية - المتن",
"TEL1": "01/497183",
"TEL2": "01/485668",
"TEL3": "",
"internet": "info@neouchyzakaria.com"
},
{
"Category": "Fourth",
"Number": "17848",
"com-reg-no": "74426",
"NM": "دوناتكس Donnatex",
"L_NM": "Donnatex",
"Last Subscription": "27-Feb-17",
"Industrial certificate no": "2560",
"Industrial certificate date": "15-Sep-17",
"ACTIVITY": "صناعة اللانجري النسائية والولادية",
"Activity-L": "Manufacture of ladies\' & children\'s lingerie",
"ADRESS": "بناية الندى\u001c - شارع مار الياس\u001c - المصيطبة - بيروت",
"TEL1": "01/308555",
"TEL2": "03/666358",
"TEL3": "",
"internet": "donnatex@idm.net.lb"
},
{
"Category": "Excellent",
"Number": "1688",
"com-reg-no": "72289",
"NM": "شركة افران الباشا كيروز ش م ل",
"L_NM": "Boulangerie El Bacha Keirouz sal",
"Last Subscription": "20-Feb-18",
"Industrial certificate no": "4929",
"Industrial certificate date": "27-Nov-18",
"ACTIVITY": "صناعة الخبز والكعك",
"Activity-L": "Manufacture of bread & cakes",
"ADRESS": "ملك هليط\u001c - طريق جسر الباشا - تجاه مطعم الباشا\u001c - سن الفيل - المتن",
"TEL1": "01/499992",
"TEL2": "01/500003",
"TEL3": "03/965558",
"internet": "info@keyrouzbakery.com"
},
{
"Category": "Second",
"Number": "6510",
"com-reg-no": "76983",
"NM": "شركة فانيل ش م م",
"L_NM": "Vanille sarl",
"Last Subscription": "11-May-17",
"Industrial certificate no": "2766",
"ACTIVITY": "صناعة البوظة والحلويات الافرنجية",
"Activity-L": "Manufacture of ice cream & western sweets",
"ADRESS": "بناية ابو حيدر ط1\u001c - شارع مارلويس\u001c - الرميل - بيروت",
"TEL1": "01/338782",
"TEL2": "03/298222",
"TEL3": "",
"internet": "nicole@vanille-patissiere.com"
},
{
"Category": "Third",
"Number": "22300",
"com-reg-no": "64021",
"NM": "شركة د. م . ن. للمفروشات ش م م",
"L_NM": "D.M.N. Furniture sarl",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "3623",
"Industrial certificate date": "16-Mar-18",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك نجاريان\u001c - الشارع العام\u001c - روميه - المتن",
"TEL1": "09/477755+57",
"TEL2": "03/520074",
"TEL3": "03/320078",
"internet": "info@dmnfurniture.com"
},
{
"Category": "Third",
"Number": "25815",
"com-reg-no": "27236",
"NM": "مؤسسة فادي مسعود",
"L_NM": "Ets. Fadi Massoud",
"Last Subscription": "7-Mar-18",
"Industrial certificate no": "484",
"Industrial certificate date": "28-Feb-19",
"ACTIVITY": "صناعة المصوغات والاحجار الكريمة",
"Activity-L": "Manufacture of jewellery & precious stones",
"ADRESS": "بناية آني\u001c - شارع اراكس\u001c - برج حمود - المتن",
"TEL1": "01/264510",
"TEL2": "03/719683",
"TEL3": "",
"internet": "info@massoudjewellery.com"
},
{
"Category": "Second",
"Number": "6273",
"com-reg-no": "72760",
"NM": "هوم سيتي ش م م",
"L_NM": "Home City sarl",
"Last Subscription": "1-Feb-17",
"Industrial certificate no": "3315",
"Industrial certificate date": "7-Aug-17",
"ACTIVITY": "صناعة المفروشات وتجارة جملة السجاد",
"Activity-L": "Manufacture of furniture & wholesale of carpets",
"ADRESS": "ملك حرو\u001c - ساحل علما - الشارع العام\u001c - جونيه - كسروان",
"TEL1": "03/969090",
"TEL2": "09/911911",
"TEL3": "09/216116",
"internet": "Homecity2002@gmail.com"
},
{
"Category": "Second",
"Number": "4492",
"com-reg-no": "69758",
"NM": "شركة طيور البترون ش م ل",
"L_NM": "Volailles de Batroun sal",
"Last Subscription": "5-Feb-18",
"Industrial certificate no": "2345",
"Industrial certificate date": "15-May-18",
"ACTIVITY": "تجارة الطيور",
"Activity-L": "Trading of poultry",
"ADRESS": "ملك بوتك ش م ل\u001c - مستديرة المكلس\u001c - الدكوانه - المتن",
"TEL1": "01/512333",
"TEL2": "06/520567",
"TEL3": "",
"internet": "gyaacoub@butec.com.lb"
},
{
"Category": "First",
"Number": "801",
"com-reg-no": "36737",
"NM": "مؤسسة كرم عازار واولاده ش م م - كازار",
"L_NM": "Ets. Karam Azar & Fils sarl - Kazar",
"Last Subscription": "13-Mar-18",
"Industrial certificate no": "514",
"Industrial certificate date": "6-Mar-19",
"ACTIVITY": "معملا لصب احجار الباطون ونشر الرخام والغرانيت",
"Activity-L": "Manufacture of concrete stones & cutting of marble & granite",
"ADRESS": "ملك البطريركية المارونية\u001c - شارع يسوع الملك\u001c - زوق مصبح - كسروان",
"TEL1": "09/217634",
"TEL2": "09/217793",
"TEL3": "03/627531",
"internet": "kazar@terra.net.lb"
},
{
"Category": "Third",
"Number": "21942",
"com-reg-no": "75297",
"NM": "شركة سليم مزنر ش م م",
"L_NM": "Selim Mouzannar sarl",
"Last Subscription": "29-Jan-18",
"Industrial certificate no": "4010",
"Industrial certificate date": "10-May-18",
"ACTIVITY": "معملا للمصوغات",
"Activity-L": "Manufacture of jewellery",
"ADRESS": "ملك ريا ملاط\u001c - شارع شحاده\u001c - الاشرفية - بيروت",
"TEL1": "03/331299",
"TEL2": "01/201154",
"TEL3": "03/477888",
"internet": "selim@selimmouzannar.com"
},
{
"Category": "Excellent",
"Number": "1515",
"com-reg-no": "9310",
"NM": "شركة سولاركو للصيانة والتركيبات ش م ل",
"L_NM": "Solarco Maintenace & Installation sal",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "3991",
"Industrial certificate date": "18-May-18",
"ACTIVITY": "صناعة اشغال مختلفة من الستانلس ستيل للمطابخ",
"Activity-L": "Manufacture of stainless steel for kitchens",
"ADRESS": "ملك الشركة\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/489100",
"TEL2": "",
"TEL3": "",
"internet": "solarco@dm.net.lb"
},
{
"Category": "First",
"Number": "4489",
"com-reg-no": "71031",
"NM": "اش ديكو ش م م",
"L_NM": "H.Deco L.L.C",
"Last Subscription": "10-Feb-18",
"Industrial certificate no": "4751",
"Industrial certificate date": "19-Oct-18",
"ACTIVITY": "صناعة المفروشات",
"Activity-L": "Manufacture of furniture",
"ADRESS": "ملك اليان\u001c - الشارع الرئيسي\u001c - المكلس - المتن",
"TEL1": "01/692325",
"TEL2": "01/692326",
"TEL3": "",
"internet": "info@hdeco.com"
},
{
"Category": "Second",
"Number": "6094",
"com-reg-no": "2008035",
"NM": "صناعات ش م م",
"L_NM": "Sinaat sarl",
"Last Subscription": "26-Jan-17",
"Industrial certificate no": "2772",
"Industrial certificate date": "21-Oct-17",
"ACTIVITY": "صناعة المفروشات",
"Activity-L": "Manufacture of furniture",
"ADRESS": "ملك ايلي متى\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/682118",
"TEL2": "03/290830",
"TEL3": "01/682184",
"internet": ""
},
{
"Category": "Third",
"Number": "21921",
"com-reg-no": "36270",
"NM": "مودا بلاست للتجارة العامة والصناعة ش م م",
"L_NM": "Moda Plast sarl",
"Last Subscription": "3-Nov-17",
"Industrial certificate no": "4765",
"Industrial certificate date": "23-Oct-18",
"ACTIVITY": "صناعة اكعاب وقوالب بلاستيكية للاحذية",
"Activity-L": "Manufacture of plastic heels & moulds for shoes",
"ADRESS": "ملك ارسلانيان\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/883911",
"TEL2": "01/883922",
"TEL3": "",
"internet": "modapls@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "1566",
"com-reg-no": "69371",
"NM": "سلطان ستيل ش م م",
"L_NM": "Sultan Steel sarl",
"Last Subscription": "7-Feb-18",
"Industrial certificate no": "4887",
"Industrial certificate date": "16-Nov-18",
"ACTIVITY": "صناعة الحدادة الافرنجيه",
"Activity-L": "Manufacture of smithery",
"ADRESS": "بناية شاهين ملك يوسف العجمي\u001c - شارع فروخ\u001c - برج ابي حيدر - بيروت",
"TEL1": "05/810111",
"TEL2": "03/882610",
"TEL3": "03/882885",
"internet": "mgt@sultansteel.com.lb"
},
{
"Category": "Third",
"Number": "21907",
"com-reg-no": "62847",
"NM": "فيتروني كونفكسيون ش م م",
"L_NM": "Feitrouni Confection sarl",
"Last Subscription": "12-Jul-17",
"Industrial certificate no": "4239",
"Industrial certificate date": "4-Jun-18",
"ACTIVITY": "تجارة الالبسة الداخلية واللانجري",
"Activity-L": "Trading of underwear & lingerie",
"ADRESS": "ملك عبده طانيوس الفيتروني\u001c - حارة البطم\u001c - الحدث - بعبدا",
"TEL1": "05/463937",
"TEL2": "05/463936",
"TEL3": "",
"internet": "seicom@inco.com.lb"
},
{
"Category": "Third",
"Number": "21911",
"com-reg-no": "75887",
"NM": "شركة هادكو ش م م",
"L_NM": "Hadco sarl",
"Last Subscription": "13-Oct-17",
"Industrial certificate no": "4699",
"Industrial certificate date": "9-Oct-18",
"ACTIVITY": "معملا لتصنيع وطباعة لفائف لاصقة مختلفة",
"Activity-L": "Manufacture of adhesive paper",
"ADRESS": "ملك شركة ماتلسيكو ش م م\u001c - الشارع العام\u001c - كورنيش النهر - بيروت",
"TEL1": "01/443246",
"TEL2": "71/282903",
"TEL3": "01/540778",
"internet": "hadco@lynx.net.lb"
},
{
"Category": "Third",
"Number": "21846",
"com-reg-no": "69554",
"NM": "زيمكو ش م م",
"L_NM": "Zimco sarl",
"Last Subscription": "6-Jul-17",
"Industrial certificate no": "3012",
"Industrial certificate date": "21-Dec-17",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing",
"ADRESS": "بناية مكارم\u001c - شارع الكومودور\u001c - الحمراء - بيروت",
"TEL1": "01/685601",
"TEL2": "01/685602",
"TEL3": "01/685603",
"internet": "fouad@zincogroup.com"
},
{
"Category": "Third",
"Number": "21792",
"com-reg-no": "69561",
"NM": "شركة فورنيكوم ش م م",
"L_NM": "Furnicom sarl",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "049",
"Industrial certificate date": "18-Dec-18",
"ACTIVITY": "صناعة البسة رجالية وولادية وسبورومدارس وفنادق ومستشفيات وتريكو",
"Activity-L": "Manuf. of men&children\'s clothes,tricot&school,hotels&hospitals uniforms",
"ADRESS": "ملك جان عين وزيبور اوده ديسيان\u001c - شارع العريض\u001c - الدكوانه - المتن",
"TEL1": "01/512660",
"TEL2": "03/667679",
"TEL3": "",
"internet": "furnicom@terra.net.lb"
},
{
"Category": "Third",
"Number": "21797",
"com-reg-no": "71964",
"NM": "شركة ب اند ب اندستري ش م م",
"L_NM": "B & B Industry sarl",
"Last Subscription": "5-Mar-18",
"Industrial certificate no": "3166",
"Industrial certificate date": "18-Jan-18",
"ACTIVITY": "صناعة الالبسة النسائية والرجالية",
"Activity-L": "Manufacture of ladies\' & men\'s clothes",
"ADRESS": "ملك لودي مرعب\u001c - شارع الميدان\u001c - الدكوانه - المتن",
"TEL1": "03/393322",
"TEL2": "01/489483",
"TEL3": "",
"internet": "dany@bandbindustry.com"
},
{
"Category": "Excellent",
"Number": "1284",
"com-reg-no": "77961",
"NM": "شركة اتش ام بي ار للصناعة والتجارة ش م ل",
"L_NM": "HMBR Manufacturing & Trading Co. sal",
"Last Subscription": "20-Mar-17",
"Industrial certificate no": "2634",
"Industrial certificate date": "18-Mar-18",
"ACTIVITY": "صناعة الحلويات والخبز الافرنجي والمعجنات والبوظة والمأكولات",
"Activity-L": "Manufacture of sweets, pastry, rolls & catering",
"ADRESS": "سنتر الكوسا ط 7\u001c - كورنيش المزرعة\u001c - المزرعة - بيروت",
"TEL1": "01/653014",
"TEL2": "01/653015",
"TEL3": "05/800811",
"internet": "malco@malco.com.lb"
},
{
"Category": "Excellent",
"Number": "1285",
"com-reg-no": "77962",
"NM": "شركة مالكو للصناعة والتوزيع ش م ل",
"L_NM": "Malco Manufacturing & Distributiion Co. sal",
"Last Subscription": "22-Feb-17",
"Industrial certificate no": "2635",
"Industrial certificate date": "18-Mar-18",
"ACTIVITY": "تصنيع وتعبئة البطاطا الشيبس",
"Activity-L": "Manufacture & packing of potatos",
"ADRESS": "سنتر الكوسا ط 8\u001c - كورنيش المزرعة\u001c - المزرعة - بيروت",
"TEL1": "01/653015",
"TEL2": "01/653014",
"TEL3": "05/800811",
"internet": "malco@malco.com.lb"
},
{
"Category": "Excellent",
"Number": "1316",
"com-reg-no": "68264",
"NM": "هنري عبدالله مصنع انتاج الفرش والاسفنج الاصطناعي ش م ل",
"L_NM": "Henry Abdallah Polyurethane Foam & Spring Mattresses Manufactures sal",
"Last Subscription": "28-Feb-18",
"Industrial certificate no": "485",
"Industrial certificate date": "28-Feb-19",
"ACTIVITY": "معمل للاسفنج والفرشات الاسفنجية وخياطة اللحف والبرادي والمخدات ومفروشات",
"Activity-L": "Manufacture of sponge,mattresses, pillow & curtains & furniture",
"ADRESS": "ملك هنري عبد الله\u001c - المدينة الصناعية\u001c - زوق مصبح - كسروان",
"TEL1": "09/218793",
"TEL2": "09/218790",
"TEL3": "03/385202",
"internet": "info@revamat.com"
},
{
"Category": "First",
"Number": "4992",
"com-reg-no": "70448",
"NM": "شركة يونيباغ ش م ل",
"L_NM": "Unibag sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "3860",
"Industrial certificate date": "22-Apr-18",
"ACTIVITY": "معملا لتصنيع اكياس الورق والطباعة عليها",
"Activity-L": "Manufacture of paper bags & printing on it",
"ADRESS": "ملك انيس عبيد\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/510171",
"TEL2": "03/635915",
"TEL3": "",
"internet": "unibag@inco.com.lb"
},
{
"Category": "Second",
"Number": "6173",
"com-reg-no": "66714",
"NM": "شويري مولتي باكيجينج ش م م",
"L_NM": "Choueiry Multi Packaging sarl",
"Last Subscription": "22-Jun-17",
"Industrial certificate no": "0761",
"Industrial certificate date": "19-Jul-16",
"ACTIVITY": "تجارة الات التوضيب ولوازمها",
"Activity-L": "Trading of packaging machinery & equipment",
"ADRESS": "ملك ميشال عبده شويري\u001c - شارع سامي الصلح\u001c - المنصورية - المتن",
"TEL1": "04/401777",
"TEL2": "03/808077",
"TEL3": "",
"internet": "michelchoueiry@hotmail.com"
},
{
"Category": "Third",
"Number": "21695",
"com-reg-no": "60461",
"NM": "شركة س س ل الشرق الاوسط ش م م",
"L_NM": "C C L Middle East sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "0040",
"Industrial certificate date": "2-Jul-16",
"ACTIVITY": "دراسة وتنفيذ المنشاءات بالباطون المسلح والمضغوط - سحب وتصنيع قساطل",
"Activity-L": "Construction studies & execution - Drawing & manufacture of tubes",
"ADRESS": "ملك الشركة\u001c - جامعة اللويزه - الشارع العام\u001c - زوق مصبح - كسروان",
"TEL1": "09/226044",
"TEL2": "",
"TEL3": "",
"internet": "contact@dhme-prestress.com"
},
{
"Category": "Third",
"Number": "21810",
"com-reg-no": "77581",
"NM": "الشركة العامة لمنتوجات لبنان ش م م",
"L_NM": "General Company for Lebanon Products sarl",
"Last Subscription": "5-Mar-18",
"Industrial certificate no": "3838",
"Industrial certificate date": "19-Apr-18",
"ACTIVITY": "طحن البهارات على انواعها",
"Activity-L": "Grinding of spices",
"ADRESS": "ملك عبير شحاده\u001c - شارع زريق\u001c - المزرعة - بيروت",
"TEL1": "01/855844",
"TEL2": "03/657765",
"TEL3": "",
"internet": "adonis@adonisspices.com.lb"
},
{
"Category": "Third",
"Number": "21900",
"com-reg-no": "1000361",
"NM": "شركة دوريان كوبار ش م م",
"L_NM": "Doriane- Copar sarl",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "4283",
"Industrial certificate date": "11-Jul-18",
"ACTIVITY": "صناعة القوالب المعدنية تحجارة مستحضرات التجميل",
"Activity-L": "Manufacture of metallic moulds & cosmetics",
"ADRESS": "ملك شركة هيف إيموبليه ش م م\u001c - الشارع الرئيسي\u001c - الشويفات  - عاليه",
"TEL1": "01/801590",
"TEL2": "01/804590",
"TEL3": "05/810590",
"internet": "doriane@terra.net.lb"
},
{
"Category": "Second",
"Number": "6126",
"com-reg-no": "12310",
"NM": "مؤسسة هراتش كوسريان التجارية",
"L_NM": "Hratch K. Keusseryan",
"Last Subscription": "22-Mar-18",
"Industrial certificate no": "4708",
"Industrial certificate date": "11-Apr-18",
"ACTIVITY": "صناعة مسكات ولوازم النجارين والحدادين",
"Activity-L": "Manufacture of hinges, carpentry & smithery equipment",
"ADRESS": "ملك اميل عضيمي\u001c - شارع مار مارون\u001c - البوشرية - المتن",
"TEL1": "01/249194",
"TEL2": "03/670614",
"TEL3": "01/248953",
"internet": "hratchkeusseyan@gmail.com"
},
{
"Category": "Third",
"Number": "25628",
"com-reg-no": "54569",
"NM": "مؤسسة ايفاسول",
"L_NM": "Evasol",
"Last Subscription": "22-Feb-17",
"Industrial certificate no": "2227",
"Industrial certificate date": "8-Feb-18",
"ACTIVITY": "تصنيع اكعاب وانعال بلاستيكية للاحذية وخراطة القوالب",
"Activity-L": "Manufacture of heels, plastic soles & mould",
"ADRESS": "ملك اوهانس بيحامه يان\u001c - المدينة الصناعية\u001c - برج حمود - المتن",
"TEL1": "01/497117",
"TEL2": "01/497474",
"TEL3": "71/710971",
"internet": "evasol@terra.net.lb"
},
{
"Category": "Third",
"Number": "21587",
"com-reg-no": "49604",
"NM": "بارثلي ش م م",
"L_NM": "Barthley sarl",
"Last Subscription": "2-Feb-17",
"Industrial certificate no": "1798",
"Industrial certificate date": "21-Oct-17",
"ACTIVITY": "صناعة الالبسة الولادية والنسائية",
"Activity-L": "Manufacture of children\'s & ladies\' clothes",
"ADRESS": "بناية مرهج ملك جورج ابي عاد\u001c - السبتيه - شارع الفردوس\u001c - البوشرية - المتن",
"TEL1": "01/692138",
"TEL2": "03/301136",
"TEL3": "",
"internet": "barthley@hotmail.com"
},
{
"Category": "Third",
"Number": "21575",
"com-reg-no": "71692",
"NM": "امبالاج لبنان ش م م",
"L_NM": "Emballage du Liban sarl",
"Last Subscription": "28-Feb-18",
"Industrial certificate no": "4900",
"Industrial certificate date": "5-Dec-18",
"ACTIVITY": "صناعة علب المجوهرات",
"Activity-L": "Manufacture of boxes for Jewellery",
"ADRESS": "ملك زوين\u001c - شارع رقم 1\u001c - دير طاميش - المتن",
"TEL1": "04/917420",
"TEL2": "03/250155",
"TEL3": "",
"internet": "emballageduliban@gmail.com"
},
{
"Category": "First",
"Number": "4327",
"com-reg-no": "71493",
"NM": "مؤسسة ميلاد ابو رجيلي - تعهدات عامة ش م م",
"L_NM": "Ets Milad Abou Rjeily - General Contracting sarl",
"Last Subscription": "21-Apr-17",
"Industrial certificate no": "3799",
"Industrial certificate date": "11-Apr-18",
"ACTIVITY": "تنفيذ التعهدات المدنية ومعملا للأنشاءات والاشغال المعدنية",
"Activity-L": "Civil contracting & manufacture of metal structures",
"ADRESS": "ملك ميلاد ابو رجيلي \u001c - الشارع العام \u001c - شيخان - جبيل",
"TEL1": "09/790674",
"TEL2": "09/790866",
"TEL3": "03/615679",
"internet": "info@marcontracting.com"
},
{
"Category": "Fourth",
"Number": "26911",
"com-reg-no": "2030465",
"NM": "All Bags Packaging Industries",
"L_NM": "All Bags Packaging Industries",
"Last Subscription": "7-Apr-17",
"Industrial certificate no": "3724",
"Industrial certificate date": "30-Mar-18",
"ACTIVITY": "صناعة اكياس الورق والبلاستيك",
"Activity-L": "Manufacture of paper & plastic bags",
"ADRESS": "بناية ابي حبيب\u001c - الشارع العام\u001c - روميه - المتن",
"TEL1": "03/182375",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "4115",
"com-reg-no": "30446",
"NM": "Artech for Marble sal",
"L_NM": "Artech for Marble sal",
"Last Subscription": "24-Jan-18",
"Industrial certificate no": "3356",
"Industrial certificate date": "11-Feb-18",
"ACTIVITY": "معملا لنشر وجلي الرخام والصخر وتفصيل بلاط الغرانيت",
"Activity-L": "Manufacture of marble, sawing of rocks & granite",
"ADRESS": "ملك الشركة\u001c - المدينة الصناعية\u001c - كفرشيما - بعبدا",
"TEL1": "05/437268+69",
"TEL2": "05/768884",
"TEL3": "",
"internet": "info@artechformarble.com"
},
{
"Category": "First",
"Number": "4791",
"com-reg-no": "66063",
"NM": "الشركة الوطنية للذخيرة ش م ل",
"L_NM": "National Ammunition Company sal",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "145",
"Industrial certificate date": "8-Jan-19",
"ACTIVITY": "معملا لأنتاج وتعبئة خرطوش الصيد وتصنيع وتجميع الخرطوش الفارغة وخردق الصيد",
"Activity-L": "Manufacture of hunting cartridges and components",
"ADRESS": "بناية فلوريل\u001c - حرش تابت - الشارع العام\u001c - سن الفيل - المتن",
"TEL1": "01/265000",
"TEL2": "09/231616",
"TEL3": "03/215005",
"internet": "national@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "1590",
"com-reg-no": "68146",
"NM": "شركة المتحد ش م ل",
"L_NM": "Al Moutahed Co sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4306",
"Industrial certificate date": "14-Jul-18",
"ACTIVITY": "صناعة اكياس ورولو تغليف من النايلون والورق والسلوفان",
"Activity-L": "Manufacture of cellophane, paper & nylon packing rolls & bags",
"ADRESS": "ملك حسين عبد الله\u001c - طريق بحمدون\u001c - بخشتيه - عاليه",
"TEL1": "05/555187",
"TEL2": "05/559859",
"TEL3": "05/559759",
"internet": "moutahed@moutahed.com"
},
{
"Category": "Fourth",
"Number": "17209",
"com-reg-no": "39776",
"NM": "باتيسري سانت اونوريه - لوريت فرح وشركاها - شركة تضامن",
"L_NM": "Patisserie St. Honore - Laurette Farah & Co",
"Last Subscription": "23-Jan-17",
"Industrial certificate no": "2489",
"Industrial certificate date": "27-Feb-18",
"ACTIVITY": "صناعة الشوكولا",
"Activity-L": "Manufacture of chocolate",
"ADRESS": "ملك لوران الباروكي\u001c - نيو جديدة - شارع الراهبات\u001c - الجديدة - المتن",
"TEL1": "01/890150",
"TEL2": "03/318271",
"TEL3": "",
"internet": "sthonore@gmail.com"
},
{
"Category": "Third",
"Number": "21525",
"com-reg-no": "62029",
"NM": "اسبري تاندانس ش م م",
"L_NM": "Esprit Tendance sarl",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "4485",
"Industrial certificate date": "12-Aug-18",
"ACTIVITY": "صناعة الالبسة النسائية",
"Activity-L": "Manufacture of ladies\' clothes",
"ADRESS": "ملك جوزف نخله\u001c - حي الموتور\u001c - الفنار - المتن",
"TEL1": "01/885135",
"TEL2": "01/885464",
"TEL3": "",
"internet": "jcnakhle@yahoo.ca"
},
{
"Category": "Second",
"Number": "6191",
"com-reg-no": "64883",
"NM": "صفير اندستريز ش م م",
"L_NM": "Sfeir Industries sarl",
"Last Subscription": "31-Jul-17",
"Industrial certificate no": "4265",
"Industrial certificate date": "8-Jul-18",
"ACTIVITY": "صناعة البرادات والافران والشوايات والمجالي وطاولات ستانلس",
"Activity-L": "Manufacture of refrigerators, ovens, grills, sinks & stainless tables",
"ADRESS": "بناية ناصيف الحاج\u001c - الشارع الداخلي\u001c - الضبيه - المتن",
"TEL1": "04/412700",
"TEL2": "04/414310",
"TEL3": "01/884666",
"internet": "hisham@sfeirindustries.com"
},
{
"Category": "Second",
"Number": "5866",
"com-reg-no": "63759",
"NM": "بالينا - أكوب جيلنكريان واولاده ش م ل",
"L_NM": "Balina - Hagop Gilinguirian & Sons sal",
"Last Subscription": "25-Nov-17",
"Industrial certificate no": "4875",
"Industrial certificate date": "14-Nov-18",
"ACTIVITY": "معملا لتصنيع الانعال والاكعاب لزوم الاحذية",
"Activity-L": "Manufacture of parts of footwear",
"ADRESS": "ملك جيلنكريان وداغليان\u001c - شارع ابو خاطر\u001c - الدوره - المتن",
"TEL1": "01/902323",
"TEL2": "01/902324",
"TEL3": "01/902325",
"internet": "balina@dm.net.lb"
},
{
"Category": "Second",
"Number": "6037",
"com-reg-no": "76869",
"NM": "جبور باور ش م م",
"L_NM": "Jabbour Power sarl",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4559",
"Industrial certificate date": "30-Aug-18",
"ACTIVITY": "تنفيذ تعهدات الهندسة الكهربائية وتجميع المولدات",
"Activity-L": "Electrical engineering contracting & assembling of generators",
"ADRESS": "ملك جبور\u001c - شارع مار مخايل\u001c - المدور - بيروت",
"TEL1": "01/580758",
"TEL2": "01/564640",
"TEL3": "03/250181",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1271",
"com-reg-no": "68970",
"NM": "شركة الطباعة والتغليف ش م ل - روتو فلكسوبرس",
"L_NM": "Roto Flexopress - Societe d\'imprimerie et d\'emballage sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4079",
"Industrial certificate date": "6-Jun-18",
"ACTIVITY": "صناعة اكياس النايلون والطباعة عليها",
"Activity-L": "Manufacture of nylon bags & printing on it",
"ADRESS": "ملك كمال ومنى نجار\u001c - طريق البحر\u001c - عمارة شلهوب - المتن",
"TEL1": "01/891428",
"TEL2": "01/895794",
"TEL3": "04/390900",
"internet": "sales@rotoflexopress.com"
},
{
"Category": "Excellent",
"Number": "1270",
"com-reg-no": "68990",
"NM": "عساف وكبابة ترايدنغ  ش م ل",
"L_NM": "Assaf & Kabbabe Trading sal",
"Last Subscription": "15-Mar-18",
"Industrial certificate no": "2573",
"Industrial certificate date": "9-Mar-18",
"ACTIVITY": "صناعة وتجميع واجهات وستاندات",
"Activity-L": "Manufacture of stands",
"ADRESS": "ملك الشركة\u001c - الشارع الرئيسي\u001c - المكلس - المتن",
"TEL1": "01/687591+93",
"TEL2": "03/347420",
"TEL3": "",
"internet": "askaintt@dm.net.lb"
},
{
"Category": "Second",
"Number": "3858",
"com-reg-no": "70082",
"NM": "بلاستي باكينغ",
"L_NM": "Plasti Packing",
"Last Subscription": "16-Nov-17",
"Industrial certificate no": "4281",
"Industrial certificate date": "16-Sep-15",
"ACTIVITY": "تجارة اكياس وادوات منزلية بلاستيكية",
"Activity-L": "Trading of plastic bags & household products",
"ADRESS": "ملك بسام حوماني\u001c - حي المصانع- شارع التيرو\u001c - الشويفات - عاليه",
"TEL1": "05/434500",
"TEL2": "03/614300",
"TEL3": "",
"internet": "plastipacking@hotmail.com"
},
{
"Category": "Excellent",
"Number": "1563",
"com-reg-no": "77270",
"NM": "دلال للانشاءات المعدنية ش.م.ل",
"L_NM": "Dalal Steel Industries sal",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "3846",
"Industrial certificate date": "24-Jul-18",
"ACTIVITY": "صناعة الانشاءات المعدنية والحدادة",
"Activity-L": "Manufacture of metal structure & smithery",
"ADRESS": "بناية دلال\u001c - التحويطة - شارع الحكمة\u001c - فرن الشباك - بعبدا",
"TEL1": "01/282555",
"TEL2": "01/280404",
"TEL3": "70/607079",
"internet": "info@dalalsteel.com"
},
{
"Category": "Fourth",
"Number": "17171",
"com-reg-no": "62121",
"NM": "المؤسسة الوطنية عبر المتوسط للتجارة والصناعة العامة",
"L_NM": "National Est. across Middle East",
"Last Subscription": "30-Jan-18",
"Industrial certificate no": "3906",
"Industrial certificate date": "2-May-18",
"ACTIVITY": "صناعة الافران ومحامص البن",
"Activity-L": "Manufacture of bakeries & roasters",
"ADRESS": "ملك رضا محمود رضا - حي الامراء - الشويفات - عاليه",
"TEL1": "03/886979",
"TEL2": "01/545933",
"TEL3": "",
"internet": "sales@mmelebanon.com"
},
{
"Category": "Excellent",
"Number": "1570",
"com-reg-no": "70790",
"NM": "شركة افران شمسين ش م م (خلدة)",
"L_NM": "Chamsine Bakeries sarl (Khalde)",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "231",
"Industrial certificate date": "18-Jan-19",
"ACTIVITY": "فرن",
"Activity-L": "Bakery",
"ADRESS": "ملك موسى القادري\u001c - الشارع العام\u001c - خلده - عاليه",
"TEL1": "05/800658",
"TEL2": "05/800659",
"TEL3": "05/801510",
"internet": "info@chamsine.com"
},
{
"Category": "Excellent",
"Number": "1630",
"com-reg-no": "66015",
"NM": "بلاستي لاب ش م م",
"L_NM": "Plasti Lab sarl",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4573",
"Industrial certificate date": "5-Sep-18",
"ACTIVITY": "صناعة عبوات بلاستكية طبية وتجارة جملة تجهيزات الطبية والمخبرية",
"Activity-L": "Manuf.of plastic medical cans&wholesale of laboratory&medical supplies",
"ADRESS": "ملك ابناء يوسف الخوري\u001c - الشارع العام\u001c - روميه - المتن",
"TEL1": "01/902000",
"TEL2": "01/902111",
"TEL3": "03/387287",
"internet": "info@plastilab-lb.com"
},
{
"Category": "Second",
"Number": "6175",
"com-reg-no": "70595",
"NM": "مؤسسة فوزي حداد",
"L_NM": "Fawzi Haddad",
"Last Subscription": "28-Feb-18",
"Industrial certificate no": "2556",
"Industrial certificate date": "19-Dec-18",
"ACTIVITY": "صناعة علب وصحون كرتون",
"Activity-L": "Manufacture of carton boxes & plates",
"ADRESS": "بناية حداد\u001c - مار روكز - جانب مجمع اميل لحود العسكري الرياضي\u001c - الدكوانة - المتن",
"TEL1": "01/682280",
"TEL2": "03/738502",
"TEL3": "",
"internet": "haddad55@hotmail.com"
},
{
"Category": "Fourth",
"Number": "28066",
"com-reg-no": "2031058",
"NM": "لين - الشركة اللبنانية للابداعات الهندسية ش م م",
"L_NM": "LEEN - Lebanese Enterprise for Engineering Novelty sarl",
"Last Subscription": "20-Feb-18",
"Industrial certificate no": "2955",
"Industrial certificate date": "11-May-18",
"ACTIVITY": "صناعة الورق الصحي",
"Activity-L": "Manufacture of hygienic paper",
"ADRESS": "ملك بالقجي والحاج\u001c - المدينة الصناعية\u001c - اده - جبيل",
"TEL1": "03/742084",
"TEL2": "76/758580",
"TEL3": "76/588991",
"internet": "bechara.yared@yahoo.com"
},
{
"Category": "First",
"Number": "4224",
"com-reg-no": "70056",
"NM": "شركة بيواكسيس ش م ل",
"L_NM": "Société Bioaxis sal",
"Last Subscription": "31-Jan-18",
"Industrial certificate no": "3612",
"Industrial certificate date": "15-Mar-18",
"ACTIVITY": "صناعة اسمدة زراعية عضوية",
"Activity-L": "Manufacture of organic fertilizers",
"ADRESS": "ملك كمال مدور\u001c - شارع الميدان\u001c - الدكوانة - المتن",
"TEL1": "01/487989",
"TEL2": "01/481996",
"TEL3": "03/244615",
"internet": "bioaxis@bioaxis.net"
},
{
"Category": "Second",
"Number": "6666",
"com-reg-no": "69589",
"NM": "فال - دو - لي  ش م م",
"L_NM": "Val - de - Lis sarl",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "3733",
"Industrial certificate date": "31-Mar-18",
"ACTIVITY": "صناعة اللانجري",
"Activity-L": "Manufacture of lingerie",
"ADRESS": "بناية هيريفانيان - ملك الشركة ط 3+4\u001c - شارع سوق السمك\u001c - برج حمود - المتن",
"TEL1": "01/260224",
"TEL2": "03/396141",
"TEL3": "",
"internet": "marketing@valdelis.com"
},
{
"Category": "Third",
"Number": "21351",
"com-reg-no": "77126",
"NM": "شركة ZAN التجارية - زكريا الحلبي وشركاه - توصية بسيطة",
"L_NM": "Zan",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "4429",
"Industrial certificate date": "5-Aug-18",
"ACTIVITY": "تجارة اقمشة للملبوسات ومعملا للمنتجات النسجية المصنعة",
"Activity-L": "Trading of textiles & manufacture of weaving products",
"ADRESS": "ملك زكريا الحلبي\u001c - شارع عمر بن الخطاب\u001c - رأس النبع - بيروت",
"TEL1": "03/269473",
"TEL2": "07/920973",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "25262",
"com-reg-no": "32921",
"NM": "شركة وديع سلمون واولاده ش م م",
"L_NM": "W. Salamoon & Sons sarl",
"Last Subscription": "1-Mar-18",
"Industrial certificate no": "374",
"Industrial certificate date": "12-Feb-19",
"ACTIVITY": "معملا للمصوغات وتركيب الاحجار الكريمة عليها",
"Activity-L": "Manufacture of Jewellery & precious stones assorting",
"ADRESS": "ملك سلمون\u001c - الكسليك\u001c - صربا - كسروان",
"TEL1": "09/640799",
"TEL2": "01/202122",
"TEL3": "01/200001",
"internet": ""
},
{
"Category": "Second",
"Number": "6044",
"com-reg-no": "71499",
"NM": "شركة ساب انترناسيونال ش م م",
"L_NM": "SAB International sarl",
"Last Subscription": "25-Jan-18",
"Industrial certificate no": "4192",
"Industrial certificate date": "23-Jun-18",
"ACTIVITY": "تجارة جملة احبار وورق للطباعة",
"Activity-L": "Wholesale of ink & paper for printing",
"ADRESS": "ملك عبد الامير بيضون\u001c - شارع نقولا سرسق\u001c - الرملة البيضاء - بيروت",
"TEL1": "03/681111",
"TEL2": "01/270440",
"TEL3": "01/271144",
"internet": "dairy@sab.com.lb"
},
{
"Category": "Third",
"Number": "21313",
"com-reg-no": "69144",
"NM": "شركة رويال بابيروس ش م م",
"L_NM": "Royal Papyrus Company sarl",
"Last Subscription": "1-Mar-17",
"Industrial certificate no": "2178",
"Industrial certificate date": "30-Jun-17",
"ACTIVITY": "معملا لتقطيع الورق والكرتون",
"Activity-L": "Cutting of paper & carton",
"ADRESS": "بناية دار الانماء\u001c - السانت تريز- شارع الجاموس\u001c - الحدث - بعبدا",
"TEL1": "05/466872",
"TEL2": "05/466873",
"TEL3": "03/702008",
"internet": "hadialwan@royalpapyrus.com"
},
{
"Category": "Second",
"Number": "5977",
"com-reg-no": "68817",
"NM": "شركة روبنسون اغري ش م م",
"L_NM": "Robinson Agri sarl",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "4197",
"Industrial certificate date": "28-Jun-18",
"ACTIVITY": "صناعة البيوت الزراعية",
"Activity-L": "Manufacture of greenhouses",
"ADRESS": "ملك وقف دير سيدة الحقلة - مستيتا -بلاط - جبيل",
"TEL1": "09/796502",
"TEL2": "09/796144",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1538",
"com-reg-no": "54669",
"NM": "شركة مثلجات دولسي ش م م",
"L_NM": "Dolsi sarl",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "082",
"Industrial certificate date": "21-Dec-18",
"ACTIVITY": "صناعة البوظة والشيبس",
"Activity-L": "Manufacture of Ice cream & Chips",
"ADRESS": "ملك عبد الكريم ابو اللبن\u001c - شارع رقم 3\u001c - بعبدا",
"TEL1": "05/470444",
"TEL2": "05/470447",
"TEL3": "",
"internet": "dolsi@cyberia.net.lb"
},
{
"Category": "Second",
"Number": "6161",
"com-reg-no": "61233",
"NM": "شركة جوزيف طراد واخوانه توصية بسيطة",
"L_NM": "Joseph Trad & Bros Co",
"Last Subscription": "19-Oct-17",
"Industrial certificate no": "4670",
"Industrial certificate date": "4-Oct-18",
"ACTIVITY": "صناعة سلع واشغال الكاوتشوك المختلفة وتلبيس وخراطة سلندرات المطابع والمعامل",
"Activity-L": "Manufacture of rubber products & cylinders",
"ADRESS": "ملك طراد\u001c - الشارع العام\u001c - كفرشيما - بعبدا",
"TEL1": "05/436412",
"TEL2": "03/303781",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "21280",
"com-reg-no": "68437",
"NM": "مجموعة شعيب للمجوهرات ش م م",
"L_NM": "Cheaib Jewellery Collection sarl",
"Last Subscription": "16-Feb-18",
"Industrial certificate no": "3507",
"Industrial certificate date": "1-Mar-18",
"ACTIVITY": "صناعة المجوهرات وتركيب الاحجار الكريمة",
"Activity-L": "Manufacture of jewellery & assorting of  precious stones",
"ADRESS": "سنتر اعمال\u001c - شارع بربر ابو جوده\u001c - البوشرية - المتن",
"TEL1": "01/901017",
"TEL2": "01/889991+3",
"TEL3": "",
"internet": "cs@cheaibcollection.com"
},
{
"Category": "First",
"Number": "5277",
"com-reg-no": "62882",
"NM": "شركة ابناء مكرم عبدو للمصاعد ش م م UCE",
"L_NM": "C.M.A. For Elevators sarl.( UCE)",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "106",
"Industrial certificate date": "27-Jun-18",
"ACTIVITY": "صناعة المصاعد",
"Activity-L": "Manufacture of elevators",
"ADRESS": "بناية عبده\u001c - شارع طانيوس ابو جوده\u001c - الجديدة - المتن",
"TEL1": "01/901076",
"TEL2": "01/901077",
"TEL3": "",
"internet": "cmaforelevators@hotmail.com"
},
{
"Category": "Second",
"Number": "6083",
"com-reg-no": "64258",
"NM": "وود فكتوري ش م م",
"L_NM": "Wood Factory sarl",
"Last Subscription": "19-Mar-18",
"Industrial certificate no": "530",
"Industrial certificate date": "7-Mar-19",
"ACTIVITY": "صناعة المفروشات",
"Activity-L": "Manufacture of furniture",
"ADRESS": "ملك سلامه بلوك A  ط 1\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/481493",
"TEL2": "03/491110",
"TEL3": "03/637216",
"internet": "woodfactory@terra.net.lb"
},
{
"Category": "Third",
"Number": "25373",
"com-reg-no": "40398",
"NM": "شركة شهاب وكريمونا - موديزاين - تضامن",
"L_NM": "Mo-Design Chehab & Cremona Co",
"Last Subscription": "19-Mar-18",
"Industrial certificate no": "3561",
"Industrial certificate date": "8-Mar-18",
"ACTIVITY": "صناعة الارمات",
"Activity-L": "Manufacture of nameplates",
"ADRESS": "ملك رفول فخري\u001c - شارع غورو\u001c - المدور - بيروت",
"TEL1": "01/687498",
"TEL2": "03/277711",
"TEL3": "",
"internet": "modesign@idm.net.lb"
},
{
"Category": "Excellent",
"Number": "1783",
"com-reg-no": "68648",
"NM": "هيفي اويل ديستريبيشن كومباني هوديكو ش م ل",
"L_NM": "Heavy Oil Distribution Company - Hodico sal",
"Last Subscription": "20-Dec-17",
"Industrial certificate no": "4988",
"Industrial certificate date": "6-Oct-18",
"ACTIVITY": "تجارة جملة المحروقات",
"Activity-L": "Wholesale of fuel",
"ADRESS": "كوينز بلازا بلوك C ط7\u001c - اوتوستراد الشالوحي\u001c - البوشرية - المتن",
"TEL1": "01/247475",
"TEL2": "01/259948",
"TEL3": "03/277040",
"internet": "hodico@cyberia.net.lb"
},
{
"Category": "Third",
"Number": "20887",
"com-reg-no": "68976",
"NM": "مؤسسة شلوف للصناعة والتجارة",
"L_NM": "Challouf Est. for Industry & Trade",
"Last Subscription": "24-Feb-18",
"Industrial certificate no": "4455",
"Industrial certificate date": "9-Aug-18",
"ACTIVITY": "صناعة الشوكولا السكاكر",
"Activity-L": "Manufacture of chocolate & candies",
"ADRESS": "ملك فواز وسعيد فرحات\u001c - شارع هادي نصرالله\u001c - الشياح - بعبدا",
"TEL1": "01/552674",
"TEL2": "71/442009",
"TEL3": "01/550162",
"internet": "info@challouf.com"
},
{
"Category": "First",
"Number": "4082",
"com-reg-no": "68025",
"NM": "سوفي دي فرانس ش م ل",
"L_NM": "Sofi De France sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "71",
"Industrial certificate date": "21-Dec-18",
"ACTIVITY": "معملاً لتصنيع الخبز الافرنجي وخبز الحلويات الافرنجية",
"Activity-L": "Manufacture of bread & western sweet bread",
"ADRESS": "ملك الشركة\u001c - الشارع العام\u001c - المجذوب - المتن",
"TEL1": "04/721880",
"TEL2": "04/721881",
"TEL3": "03/270340",
"internet": "info@sofidefrance.com"
},
{
"Category": "Third",
"Number": "20876",
"com-reg-no": "63025",
"NM": "شركة بو نادر اخوان - تضامن",
"L_NM": "Bou Nader Bros Co",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "187",
"Industrial certificate date": "12-Jan-19",
"ACTIVITY": "صناعة العرق والمشروبات الروحية والشرابات وماء الزهر وتجارة الخل والسبيرتو",
"Activity-L": "Manufacture of alcoholic drinks, beverages & flower water",
"ADRESS": "ملك بونادر\u001c - الشارع العام\u001c - المتين - المتن",
"TEL1": "04/295593",
"TEL2": "03/878652",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "3803",
"com-reg-no": "75786",
"NM": "كوادراكيم ش م ل",
"L_NM": "Quadrakim sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "278",
"Industrial certificate date": "25-Jan-19",
"ACTIVITY": "صناعة المجوهرات",
"Activity-L": "Manufacture of jewelry",
"ADRESS": "ملك كوادراكيم العقارية ش م ل \u001c - شارع ويغان\u001c - المرفأ - بيروت",
"TEL1": "01/250251",
"TEL2": "01/257818",
"TEL3": "01/981555",
"internet": "info@georgehakim.com"
},
{
"Category": "Second",
"Number": "4774",
"com-reg-no": "67437",
"NM": "ارتي مودا ش م ل",
"L_NM": "Arti Moda sal",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "3700",
"Industrial certificate date": "27-Mar-18",
"ACTIVITY": "صناعة الاحذية والجزادين والاكسسوارات المعدنية لزوم المصنوعات الجلدية",
"Activity-L": "Manufacture of shoes, bags &  metallic accessories for leather industry",
"ADRESS": "سنتر هاربويان\u001c - الشارع العام\u001c - برج حمود - المتن",
"TEL1": "01/255540+3",
"TEL2": "",
"TEL3": "",
"internet": "admin@artimoda.com"
},
{
"Category": "Third",
"Number": "20858",
"com-reg-no": "74883",
"NM": "شركة عطور الشرق ش م م",
"L_NM": "Senteurs d\'Orient sarl",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "2761",
"Industrial certificate date": "4-Apr-18",
"ACTIVITY": "صناعة وتغليف الواح الصابون",
"Activity-L": "Manufacture of soap",
"ADRESS": "بناية كورنيش غاردنز\u001c - جادة باريس\u001c - عين المريسه - بيروت",
"TEL1": "01/744762",
"TEL2": "01/689455",
"TEL3": "01/367406",
"internet": "info@senteursdorient.com"
},
{
"Category": "First",
"Number": "4405",
"com-reg-no": "68326",
"NM": "مؤسسة فوزي غيث التجارية",
"L_NM": "Fawzi Ghaith Trading Est",
"Last Subscription": "17-Jul-17",
"Industrial certificate no": "2245",
"Industrial certificate date": "14-Jul-17",
"ACTIVITY": "حدادة افرنجيه",
"Activity-L": "Smithery",
"ADRESS": "ملك فوزي غيث\u001c - بقعاتا - الشارع العام\u001c - الجديدة - الشوف",
"TEL1": "03/231741",
"TEL2": "05/508583",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1551",
"com-reg-no": "68461",
"NM": "شركة اراكو للاسفلت اللبنانية ش م ل",
"L_NM": "Araco Lebanese Asphalt sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4443",
"Industrial certificate date": "7-Aug-18",
"ACTIVITY": "تنفيذ اعمال الهندسة المدنية وتعهدات اشغال وجبل الاسفلت",
"Activity-L": "Civil engineering & contracting - mixing of asphalt",
"ADRESS": "ملك غيث \u001c - العمروسية - شارع التيرو\u001c - الشويفات - عاليه",
"TEL1": "05/482100",
"TEL2": "05/480100",
"TEL3": "03/443377",
"internet": ""
},
{
"Category": "First",
"Number": "3974",
"com-reg-no": "66748",
"NM": "شركة فورتاس ش م م",
"L_NM": "Fortess sarl",
"Last Subscription": "25-Feb-17",
"Industrial certificate no": "3870",
"Industrial certificate date": "24-Apr-18",
"ACTIVITY": "صناعة وتجميع المصاعد",
"Activity-L": "Manufacture of elevators",
"ADRESS": "ملك مسعود\u001c - شارع حنا زياده\u001c - الدكوانة - المتن",
"TEL1": "01/481205",
"TEL2": "03/302017",
"TEL3": "01/489512",
"internet": "fortess@cyberia.net.lb"
},
{
"Category": "Fourth",
"Number": "23988",
"com-reg-no": "2030474",
"NM": "ديليفريشور ش م م",
"L_NM": "Delifraicheur sarl",
"Last Subscription": "10-Jun-17",
"Industrial certificate no": "3058",
"Industrial certificate date": "28-Feb-15",
"ACTIVITY": "تجارة لحوم واسماك وثمار بحر مبردة",
"Activity-L": "Trading of frozon meat ,fish& seafood",
"ADRESS": "ملك اسد الراعي\u001c -  BEC Tower - الاوتوستراد\u001c - جل الديب - المتن",
"TEL1": "03/203610",
"TEL2": "03/275676",
"TEL3": "",
"internet": "delifraicheur@delifraicheur.com"
},
{
"Category": "Second",
"Number": "6339",
"com-reg-no": "68521",
"NM": "الشركة اللبنانية لفرم وتوضيب وتصنيع الكرتون - توصية بسيطة",
"L_NM": "Lebanese Co. for Carton Mince & Industry",
"Last Subscription": "22-Feb-18",
"Industrial certificate no": "3548",
"Industrial certificate date": "7-Mar-18",
"ACTIVITY": "معملا لفرم النفايات والبلاستيك وتوضيب نفايات الورق والكرتون",
"Activity-L": "Chopping & packing of carton & plastic wastes",
"ADRESS": "ملك علي الشعابين\u001c - حي الامراء\u001c - الشويفات - عاليه",
"TEL1": "03/283233",
"TEL2": "03/220811",
"TEL3": "05/480646",
"internet": ""
},
{
"Category": "Third",
"Number": "30881",
"com-reg-no": "69458",
"NM": "هشام غروب للصناعة والتجارة",
"L_NM": "Hicham Group for Industry & Trading",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "021",
"Industrial certificate date": "12-Dec-18",
"ACTIVITY": "صناعة مواد ضد الصداء والجليد",
"Activity-L": "Manufacture of materials for Rust & Anti freeze",
"ADRESS": "ملك احمد عبود\u001c - شارع مكتية البشير\u001c - عرمون - عاليه",
"TEL1": "05/104742",
"TEL2": "03/811228",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "21114",
"com-reg-no": "67982",
"NM": "دنتوبلاست ش م م",
"L_NM": "Dentoplast sarl",
"Last Subscription": "27-Jan-18",
"Industrial certificate no": "4305",
"Industrial certificate date": "14-Jun-18",
"ACTIVITY": "صناعة سلع بلاستيكية لاستخدام طب الاسنان",
"Activity-L": "Manufacture of plastic products for dentists",
"ADRESS": "بناية عطالله\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/511794",
"TEL2": "03/984371",
"TEL3": "",
"internet": "dentoplast@terra.net.lb"
},
{
"Category": "First",
"Number": "4092",
"com-reg-no": "69895",
"NM": "شركة موندي لبنان ش م ل",
"L_NM": "Mondi Lebanon sal",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "2390",
"Industrial certificate date": "11-Oct-18",
"ACTIVITY": "صناعة اكياس الورق لتعبئة الاسمنت",
"Activity-L": "Manufacture of paper sacks",
"ADRESS": "سنتر قسيس بلوك C\u001c - شارع القسيس\u001c - النقاش - المتن",
"TEL1": "04/407293",
"TEL2": "04/522990",
"TEL3": "04/522991",
"internet": "antoine.Kachouh@mondigroup.com"
},
{
"Category": "Excellent",
"Number": "1406",
"com-reg-no": "61977",
"NM": "سنتراكو شركة سنترا للتجارة والصناعة - تضامن",
"L_NM": "Sintraco - Sintra Industrial & Trading Co",
"Last Subscription": "7-Oct-17",
"Industrial certificate no": "3313",
"Industrial certificate date": "6-Feb-18",
"ACTIVITY": "صناعة الدهان وتجارة مواد بناء",
"Activity-L": "Manufacture of paints & trading of building materials",
"ADRESS": "بناية La Belle\u001c - جسر الواطي - شارع خليل فتال\u001c - سن الفيل - المتن",
"TEL1": "01/492986",
"TEL2": "01/488976",
"TEL3": "03/278728",
"internet": "sintra@sintraco.com"
},
{
"Category": "Excellent",
"Number": "1407",
"com-reg-no": "69328",
"NM": "هـ. قصارجيان ش م م",
"L_NM": "H. Kassardjian sarl",
"Last Subscription": "2-Mar-18",
"Industrial certificate no": "419",
"Industrial certificate date": "23-Feb-19",
"ACTIVITY": "صناعة الاسفنج",
"Activity-L": "Manufacture of sponges",
"ADRESS": "ملك يراونيان وشركاها\u001c - المدينة الصناعية - شارع ارا يروانيان\u001c - البوشرية - المتن",
"TEL1": "01/500418",
"TEL2": "01/497176",
"TEL3": "01/497177",
"internet": "pflex@dm.net.lb"
},
{
"Category": "First",
"Number": "4982",
"com-reg-no": "76572",
"NM": "شركة فيتزباتريك ش م ل",
"L_NM": "Fitzpatrick sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "524",
"Industrial certificate date": "7-Jun-18",
"ACTIVITY": "معملا للحدادة الافرنجية وابواب ضد الحريق",
"Activity-L": "Manufacture of smithery & fire fighting doors",
"ADRESS": "بناية كرم\u001c - شارع باستور\u001c - الرميل - بيروت",
"TEL1": "01/901888",
"TEL2": "",
"TEL3": "",
"internet": "firodoors@fitzpatricksal.com"
},
{
"Category": "Third",
"Number": "21074",
"com-reg-no": "73185",
"NM": "شركة رستورانتس ش م م",
"L_NM": "Restaurants sarl",
"Last Subscription": "3-Feb-18",
"Industrial certificate no": "4912",
"Industrial certificate date": "23-Nov-18",
"ACTIVITY": "صناعة الشوكولا",
"Activity-L": "Manufacture of chocolate",
"ADRESS": "ملك الشركة المتحدة للإستثمار العقاري\u001c - شارع بشارة الخوري\u001c - العاملية - بيروت",
"TEL1": "01/663715",
"TEL2": "05/461584",
"TEL3": "05/470800",
"internet": "ahmad.chamoun@chantilly-chocolatier.com"
},
{
"Category": "Third",
"Number": "24334",
"com-reg-no": "60983",
"NM": "باور ستيل",
"L_NM": "Power Steel",
"Last Subscription": "12-Apr-17",
"Industrial certificate no": "2655",
"Industrial certificate date": "6-Oct-17",
"ACTIVITY": "صناعة السقالات المعدنية",
"Activity-L": " Manufacture of metal scaffolds",
"ADRESS": "ملك هيلدا كورونيان\u001c - شارع مار انطونيوس\u001c - الجديدة - المتن",
"TEL1": "01/894690",
"TEL2": "03/244748",
"TEL3": "",
"internet": "powersteel@hotmail.com"
},
{
"Category": "First",
"Number": "4090",
"com-reg-no": "68877",
"NM": "ديانا للتجميل ش م ل",
"L_NM": "Diana de Beauté sal - Diana Cosmetics sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "189",
"Industrial certificate date": "15-Jan-19",
"ACTIVITY": "صناعة مستحضرات التجميل والشامبو والصابون",
"Activity-L": "Manufacture of cosmetics, shampoo & soap",
"ADRESS": "ملك حسن يحفوفي\u001c - طريق المطار\u001c - برج البراجنة - بعبدا",
"TEL1": "01/451516",
"TEL2": "01/451515",
"TEL3": "03/233011",
"internet": "diana@dianacosmetics.com"
},
{
"Category": "Third",
"Number": "24982",
"com-reg-no": "57780",
"NM": "مؤسسة زغيب للتصنيع الالي",
"L_NM": "Zgheib Industrial Machinery",
"Last Subscription": "28-Feb-18",
"Industrial certificate no": "449",
"Industrial certificate date": "22-Feb-19",
"ACTIVITY": "معملا للخراطة الميكانيكية والات صناعية ومنها الات غذائية",
"Activity-L": "Mechanical turnery & Manufacture of industrial & foodstuffs machinery",
"ADRESS": "بناية بولس شقير\u001c - المنطقة الصناعية - شارع فولدا\u001c - زوق مصبح - كسروان",
"TEL1": "09/221141",
"TEL2": "03/216777",
"TEL3": "",
"internet": "zgheib-ind@gmail.com"
},
{
"Category": "Third",
"Number": "20983",
"com-reg-no": "56132",
"NM": "شركة بلاستيبون للصناعة الفنية ش م م",
"L_NM": "Plastiban sarl",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "4206",
"Industrial certificate date": "29-Jun-18",
"ACTIVITY": "صناعة اكياس وعلب من كرتون وبلاستيك وورق",
"Activity-L": " Manufacture of paper, carton & plastic boxes & bags",
"ADRESS": "ملك عبد القادر واحمد وناهد شقير\u001c - ساقية الجنزير\u001c - عين التينه - بيروت",
"TEL1": "01/809454",
"TEL2": "01/810454",
"TEL3": "",
"internet": "info@plastiban-lb.com"
},
{
"Category": "Second",
"Number": "5945",
"com-reg-no": "68810",
"NM": "ايبمار ش م م",
"L_NM": "Ibmar sarl",
"Last Subscription": "1-Mar-18",
"Industrial certificate no": "4676",
"Industrial certificate date": "5-Oct-18",
"ACTIVITY": "صناعة نشرالصخور والرخام",
"Activity-L": "Cutting of rocks & marbles",
"ADRESS": "ملك ابراهيم وهاشم\u001c - الشارع العام\u001c - اده - جبيل",
"TEL1": "09/546616",
"TEL2": "03/421442",
"TEL3": "03/689950",
"internet": "ibmar@terra.net.lb"
},
{
"Category": "Excellent",
"Number": "1242",
"com-reg-no": "67987",
"NM": "شركة بيطار انترناسيونال ش م ل",
"L_NM": "Bitar International sal",
"Last Subscription": "27-Jan-18",
"Industrial certificate no": "4528",
"Industrial certificate date": "23-Aug-18",
"ACTIVITY": "تعبئة وتوضيب الحبوب الغذائية المتنوعة والملح والسكر",
"Activity-L": "Filling & packing of cereals , foodstuffs , salt & sugar",
"ADRESS": "بناية العمارة\u001c - صفير- اوتوستراد سانت تريز\u001c - الحدث - بعبدا",
"TEL1": "05/466888",
"TEL2": "05/467994",
"TEL3": "05/467995",
"internet": "bitar@bitarintl.com"
},
{
"Category": "First",
"Number": "5227",
"com-reg-no": "4108",
"NM": "شركة عقل ديكور ش م ل",
"L_NM": "akl décor sal",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "2550",
"Industrial certificate date": "9-Sep-17",
"ACTIVITY": "صناعة وتجارة المفروشات",
"Activity-L": "Manufacture & trading of furniture",
"ADRESS": "ملك جورج عقل\u001c - الشارع العام - نزلة الريجنسي\u001c - المكلس - المتن",
"TEL1": "05/457293",
"TEL2": "05/453834",
"TEL3": "03/326650",
"internet": "info@akldecor.com"
},
{
"Category": "Second",
"Number": "6813",
"com-reg-no": "2034739",
"NM": "ايفو ميتال ش م ل",
"L_NM": "Evometal sal",
"Last Subscription": "25-Aug-17",
"Industrial certificate no": "3581",
"Industrial certificate date": "10-Mar-18",
"ACTIVITY": "تجارة صفائح وحديد صناعي",
"Activity-L": "Trading of metal sheets & iron bars",
"ADRESS": "بناية شديد وايوب وشركاهم ش م م  ط4\u001c - المدينة الصناعية\u001c - المكلس - المتن",
"TEL1": "01/494592",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "4070",
"com-reg-no": "60714",
"NM": "شركة صناعة الالمنيوم وخردواتها \" الاكسو \" ش م ل",
"L_NM": "Aluminium and Accessories Company \" Alakso\" sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4432",
"Industrial certificate date": "4-Aug-18",
"ACTIVITY": "سحب بروفيلات الالمنيوم وتصنيع الاكسورات",
"Activity-L": "Drawing of aluminium profiles & accessories",
"ADRESS": "ملك رفيق الحاج موسى\u001c - طريق قرطبا\u001c - حالات - جبيل",
"TEL1": "09/478991",
"TEL2": "09/478995",
"TEL3": "09/420440",
"internet": "alakso@alakso.com"
},
{
"Category": "Excellent",
"Number": "1210",
"com-reg-no": "70311",
"NM": "شركة تفنكجيان اخوان ش م م",
"L_NM": "Tufenkjian Frères sarl",
"Last Subscription": "25-Jan-18",
"Industrial certificate no": "501",
"Industrial certificate date": "2-Mar-19",
"ACTIVITY": "صناعة المجوهرات وتركيب الاحجار الكريمة",
"Activity-L": "Manufacture of jewellery & assorting of precious stones",
"ADRESS": "بناية اي بي ان عمرو\u001c - جادة شارل مالك\u001c - الاشرفية - بيروت",
"TEL1": "01/330701",
"TEL2": "01/330702",
"TEL3": "01/330798+9",
"internet": "info@tufenkjian.com"
},
{
"Category": "First",
"Number": "4748",
"com-reg-no": "63198",
"NM": "حاج كونتراكتشرز ش م م",
"L_NM": "Hajj Contractors sarl",
"Last Subscription": "3-Apr-17",
"Industrial certificate no": "2396",
"Industrial certificate date": "16-Feb-18",
"ACTIVITY": "دراسات وتنفيذ اعمال الهندسة المدنية",
"Activity-L": "Civil engineering studies & contracting",
"ADRESS": "ملك نبيه وريمون الحاج\u001c - الشارع العام\u001c - بقعتوته - كسروان",
"TEL1": "09/710720",
"TEL2": "09/710820",
"TEL3": "03/642022",
"internet": "hajj_contractors@hotmail.com"
},
{
"Category": "Second",
"Number": "4790",
"com-reg-no": "46134",
"NM": "مؤسسة قره اوغليان اخوان",
"L_NM": "Ets. Karaoghlian Freres",
"Last Subscription": "27-Jan-17",
"Industrial certificate no": "3199",
"Industrial certificate date": "23-Jan-18",
"ACTIVITY": "صناعة المجوهرات",
"Activity-L": "Manufacture of jewellery",
"ADRESS": "ملك اوغليان\u001c - الشارع العام\u001c - جل الديب - المتن",
"TEL1": "03/305783",
"TEL2": "01/241515",
"TEL3": "",
"internet": "karadaghlian@hotmail.com"
},
{
"Category": "Third",
"Number": "20632",
"com-reg-no": "65462",
"NM": "شركة مصانع الكيماويات الصناعية ش م م",
"L_NM": "Chemical Industrial Factories sarl",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "4675",
"Industrial certificate date": "5-Oct-18",
"ACTIVITY": "خلط ومزج وتعبئة الزيوت المائية والزيتية لزوم الدهانات",
"Activity-L": "Mixing & filling of paint oils",
"ADRESS": "ملك شركة فلوطي التجارية ش م م\u001c - الوادي الصناعي\u001c - روميه - المتن",
"TEL1": "01/877160",
"TEL2": "01/903013",
"TEL3": "",
"internet": "ftc@flouty.com"
},
{
"Category": "First",
"Number": "4970",
"com-reg-no": "67215",
"NM": "ليبال ش م م",
"L_NM": "Libel sarl",
"Last Subscription": "24-Apr-17",
"Industrial certificate no": "3729",
"Industrial certificate date": "30-Mar-18",
"ACTIVITY": "صناعة الستائر المعدنية",
"Activity-L": "Manufacture of blinds",
"ADRESS": "ملك ابو جودة\u001c - الشارع العام\u001c - بقنايا - المتن",
"TEL1": "04/722123",
"TEL2": "04/723901",
"TEL3": "04/723900",
"internet": "libel@cyberia.net.lb"
},
{
"Category": "Second",
"Number": "6062",
"com-reg-no": "52056",
"NM": "L.V.L Laboratoire Veterinaire Libanais",
"L_NM": "L.V.L. Laboratoire Veterinaire Libanais",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "466",
"Industrial certificate date": "26-Feb-19",
"ACTIVITY": "صناعة الادوية البيطرية",
"Activity-L": "Manufacture of veterinary medicines",
"ADRESS": "ملك الياس قرباني\u001c - المدينة الصناعية\u001c - بعبدات - المتن",
"TEL1": "04/820361",
"TEL2": "03/659088",
"TEL3": "",
"internet": "info@lvl.com.lb"
},
{
"Category": "Third",
"Number": "20602",
"com-reg-no": "60191",
"NM": "داندي ش م م",
"L_NM": "Dandy sarl",
"Last Subscription": "15-Jan-18",
"Industrial certificate no": "491",
"Industrial certificate date": "28-Feb-19",
"ACTIVITY": "صناعة الشوكولا والسكاكر والبوظة",
"Activity-L": "Manufacture of chocolate, candies & ice cream",
"ADRESS": "ملك جمعية التضامن الخيري الدرزي\u001c - شارع فردان\u001c - عين التينه - بيروت",
"TEL1": "01/345282",
"TEL2": "01/341861",
"TEL3": "",
"internet": "dandy@dm.net.lb"
},
{
"Category": "Excellent",
"Number": "1537",
"com-reg-no": "74527",
"NM": "شركة زين جعفر حرب وشركاه ش م ل",
"L_NM": "Zein J. Harb & Partners sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "2975",
"Industrial certificate date": "16-May-18",
"ACTIVITY": "معملاً لتعبئة وتوضيب الحبوب الغذائية والبهارات",
"Activity-L": "Manufacture & paking of cereal & spices",
"ADRESS": "بناية برج بشارة الخوري\u001c - شارع بشارة الخوري\u001c - رأس النبع - بيروت",
"TEL1": "01/270450",
"TEL2": "01/270451+3",
"TEL3": "01/279900",
"internet": "info@zjharb.com"
},
{
"Category": "First",
"Number": "5232",
"com-reg-no": "61608",
"NM": "ترامستيل ش م ل",
"L_NM": "Tramsteel sal",
"Last Subscription": "3-Apr-17",
"Industrial certificate no": "2426",
"Industrial certificate date": "17-Aug-17",
"ACTIVITY": "صناعة شبك معدني وسحب قساطل صناعية معدنية ودعائم للبناء",
"Activity-L": "Manufacture of metal net ,tubes & turnery",
"ADRESS": "ملك الشركة\u001c - الشارع العام\u001c - معاد - جبيل",
"TEL1": "01/688372",
"TEL2": "01/687942",
"TEL3": "03/361362",
"internet": "info@tramsteel.com"
},
{
"Category": "First",
"Number": "4340",
"com-reg-no": "66492",
"NM": "مؤسسة امازونا",
"L_NM": "Amazona Ets.",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "100",
"Industrial certificate date": "26-Dec-18",
"ACTIVITY": "صناعة الدهانات",
"Activity-L": "Manufacture of paints",
"ADRESS": "ملك جورج يونس\u001c - شارع جامعة اللويزة\u001c - زوق مصبح - كسروان",
"TEL1": "03/302216",
"TEL2": "09/218656",
"TEL3": "09/218645",
"internet": "happywal@inco.com.lb"
},
{
"Category": "Third",
"Number": "20538",
"com-reg-no": "66773",
"NM": "مؤسسة ليبان فور للصناعة والتجارة",
"L_NM": "Liban - Four",
"Last Subscription": "24-Jan-18",
"Industrial certificate no": "4315",
"Industrial certificate date": "15-Jul-18",
"ACTIVITY": "صناعة افران الخبز الالية",
"Activity-L": "Manufacture of bakeries equipments",
"ADRESS": "ملك صعب\u001c - حارة الأمراء - طريق صيدا القديمة\u001c - الشويفات - عاليه",
"TEL1": "03/549586",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "3747",
"com-reg-no": "75284",
"NM": "شركة اي دي ام للصناعة ش م ل",
"L_NM": "IDM Industrial Company sal",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "571",
"Industrial certificate date": "3-Apr-19",
"ACTIVITY": "صناعة الشامبو، مواد التجميل، شامبو التنظيف والغسيل وملطف للاقمشة",
"Activity-L": "Manufacture of shampoo, cosmetics, detergents & softner",
"ADRESS": "ملك الداعوق\u001c - شارع صالح بن يحيى\u001c - رأس النبع - بيروت",
"TEL1": "05/400002",
"TEL2": "",
"TEL3": "",
"internet": "idm@daouk.com"
},
{
"Category": "Excellent",
"Number": "1432",
"com-reg-no": "50676",
"NM": "شركة جرجي الدكاش واولاده ش م م",
"L_NM": "Gergy Daccache & Sons sarl",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4415",
"Industrial certificate date": "1-Aug-18",
"ACTIVITY": "صناعة البيوت الزراعية وتجارة جملة الخضار والفاكهة، الشتول والبذورالزراعية",
"Activity-L": "Manufacture of green houses & Wholesale of vegetables, plants & seeds",
"ADRESS": "ملك جرجي رشيد الدكاش\u001c - حي القميرزة\u001c - البوار - كسروان",
"TEL1": "09/440770",
"TEL2": "09/440816",
"TEL3": "03/668668",
"internet": "chaouki.daccache@daccache.com"
},
{
"Category": "Third",
"Number": "20577",
"com-reg-no": "61741",
"NM": "شركة الشامي للتجارة والصناعة - توصية بسيطة",
"L_NM": "Shami Est. for Trading & Industry",
"Last Subscription": "30-May-17",
"Industrial certificate no": "610",
"Industrial certificate date": "21-Dec-16",
"ACTIVITY": "صناعة افران الخبز وتجهيزات المطاعم والمستشفيات",
"Activity-L": "Manufacture of bakery\'s, restaurants & hospitals supplies",
"ADRESS": "ملك وجيه السبع\u001c - شارع حسين درويش عمار\u001c - برج البراجنة - بعبدا",
"TEL1": "01/472139",
"TEL2": "03/839269",
"TEL3": "03/838856",
"internet": "shamiest@shamiest.com.lb"
},
{
"Category": "First",
"Number": "4057",
"com-reg-no": "73784",
"NM": "شركة اساكو للتجارة والمقاولات - وهيب نجيب ابو سعيد وشركاه - توصية بسيطة",
"L_NM": "ASACO - General Trade & Contracting",
"Last Subscription": "17-Feb-18",
"Industrial certificate no": "4285",
"Industrial certificate date": "11-Jul-18",
"ACTIVITY": "تصنيع اللمبات الكهربائية",
"Activity-L": "Manufacture of electrical lighting",
"ADRESS": "بناية الحسنيه\u001c - شارع الماما\u001c - تلة الخياط - بيروت",
"TEL1": "01/700548",
"TEL2": "03/603410",
"TEL3": "01/310649",
"internet": "asaco@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "1235",
"com-reg-no": "68007",
"NM": "غافيوتا سيمباك ميدل ايست ش م ل",
"L_NM": "Gaviota Simbac Middle East sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4896",
"Industrial certificate date": "17-Nov-18",
"ACTIVITY": "صناعة الاكسسوارت لزوم الستورات ومنجور الالمنيوم",
"Activity-L": "Manufacture of aluminium accessories",
"ADRESS": "ملك شركة فولدا ش م ل\u001c - المنطقة الصناعية\u001c - زوق مصبح - كسروان",
"TEL1": "09/219383",
"TEL2": "09/217858",
"TEL3": "09/217870",
"internet": "folda@dm.net.lb"
},
{
"Category": "First",
"Number": "4078",
"com-reg-no": "10353",
"NM": "مطاحن عساف الحديثة للصناعة والتجارة العامة - تضامن",
"L_NM": "Assaf Modern Mills",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "2422",
"Industrial certificate date": "17-Aug-18",
"ACTIVITY": "مطحنة حبوب",
"Activity-L": "Grain Milling",
"ADRESS": "ملك محمد عساف\u001c - المدينة الصناعية\u001c - بشامون - عاليه",
"TEL1": "05/802027",
"TEL2": "03/619923",
"TEL3": "",
"internet": "massaf1977@hotmail.com"
},
{
"Category": "Third",
"Number": "20905",
"com-reg-no": "65558",
"NM": "سيتكس غروب ش م م",
"L_NM": "Citex Group sarl",
"Last Subscription": "22-Jan-18",
"Industrial certificate no": "1282",
"Industrial certificate date": "15-Mar-18",
"ACTIVITY": "خياطة البياضات المنزلية",
"Activity-L": "Manufacture of household linen",
"ADRESS": "بناية قزحيا شاوول\u001c - جسر الواطي\u001c - سن الفيل - المتن",
"TEL1": "01/684919",
"TEL2": "01/684920",
"TEL3": "",
"internet": "tamsons@inco.com.lb"
},
{
"Category": "Second",
"Number": "5589",
"com-reg-no": "68663",
"NM": "Global Cosmetics",
"L_NM": "Global Cosmetics",
"Last Subscription": "23-Sep-17",
"Industrial certificate no": "4070",
"Industrial certificate date": "3-Jun-18",
"ACTIVITY": "صناعة مستحضرات التجميل ومواد التنظيف",
"Activity-L": "Manufacture of cosmetics & detergents",
"ADRESS": "ملك شركة ليبانو بلاست ش.م.م.\u001c - القبّة - الشارع العام\u001c - الشويفات - عاليه",
"TEL1": "05/801310",
"TEL2": "",
"TEL3": "03/645207",
"internet": "info@globalcosmetics-lb.com"
},
{
"Category": "Third",
"Number": "20741",
"com-reg-no": "67575",
"NM": "شركة سابيتك للصناعة والتجارة ش م م",
"L_NM": "Société Sabitech pour l\'Industrie et le Commerce sarl",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "4115",
"Industrial certificate date": "10-Jun-18",
"ACTIVITY": "صناعة الافران الالية والنصف آلية",
"Activity-L": "Manufacture of automatic & semi-automatic bakeries equipments",
"ADRESS": "ملك البيطار وبو سعد\u001c - المنطقة الصناعية \u001c - غزير - كسروان",
"TEL1": "09/926927",
"TEL2": "03/889763",
"TEL3": "03/889933",
"internet": "mail@sabitechco.com"
},
{
"Category": "Third",
"Number": "20783",
"com-reg-no": "67322",
"NM": "بلايدكس ش م م",
"L_NM": "Plydex sarl",
"Last Subscription": "23-Nov-17",
"Industrial certificate no": "4893",
"Industrial certificate date": "16-Nov-18",
"ACTIVITY": "صناعة مواد سائلة مساعدة تضاف للاسمنت وتجارة مواد عازلة للنش",
"Activity-L": "Manuf. of liquid materials for cement & trading of waterproofing materials",
"ADRESS": "ملك عفاف ابو فخري\u001c - حي الامراء\u001c - الشويفات - عاليه",
"TEL1": "05/480439",
"TEL2": "01/738725",
"TEL3": "02/3911951",
"internet": "info@plydex.com"
},
{
"Category": "Second",
"Number": "6058",
"com-reg-no": "64650",
"NM": "مؤسسة حبيب جعجع للتجارة",
"L_NM": "Flexo Print H. G. Fondation",
"Last Subscription": "25-Feb-17",
"Industrial certificate no": "3923",
"Industrial certificate date": "5-May-18",
"ACTIVITY": "صناعة رولو واكياس النايلون",
"Activity-L": "Manufacture of nylon bags & rolls",
"ADRESS": "ملك هاشم\u001c - المدينة الصناعية - شارع سلاف\u001c - الدكوانة - المتن",
"TEL1": "01/490450",
"TEL2": "03/450900",
"TEL3": "",
"internet": "habibgeagea@hotmail.com"
},
{
"Category": "Second",
"Number": "6158",
"com-reg-no": "36568",
"NM": "شركة اجهزة الامان والمكننة ش م م",
"L_NM": "Security and Automation Systems - S.&A.S -  sarl",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "417",
"Industrial certificate date": "20-Feb-19",
"ACTIVITY": "صناعة بلاكتات الكترونية",
"Activity-L": "Manufacture of electronic valves",
"ADRESS": "ملك البستاني\u001c - الشارع العام\u001c - الجيه - الشوف",
"TEL1": "07/996333",
"TEL2": "07/996115",
"TEL3": "01/216994",
"internet": "info@sascontrollers.com"
},
{
"Category": "Second",
"Number": "3770",
"com-reg-no": "67548",
"NM": "عون فود كومباني - عون ش م م",
"L_NM": "Aoun Food Co. Aoun sarl",
"Last Subscription": "23-Jan-18",
"Industrial certificate no": "243",
"Industrial certificate date": "22-Jan-19",
"ACTIVITY": "معملا لطحن البهارات وتعبئة الحبوب الغذائية وتعبئة السوائل المنظفة",
"Activity-L": "Manufacture of spices & packing of cereals & detergents",
"ADRESS": "ملك عون\u001c - شارع السيدة\u001c - الدامور - الشوف",
"TEL1": "03/619164",
"TEL2": "04/926381",
"TEL3": "04/928759",
"internet": "info@aounfood.com"
},
{
"Category": "Second",
"Number": "3768",
"com-reg-no": "67536",
"NM": "هامبي",
"L_NM": "Hampy",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "4917",
"Industrial certificate date": "23-Nov-18",
"ACTIVITY": "صناعة الالبسة الرجالية",
"Activity-L": "Manufacture of men\'s clothes",
"ADRESS": "ملك جورج رزق الله\u001c - طريق الدوره\u001c - برج حمود - المتن",
"TEL1": "01/254129",
"TEL2": "01/254130",
"TEL3": "",
"internet": "hagop@hampy.com"
},
{
"Category": "Third",
"Number": "20696",
"com-reg-no": "73094",
"NM": "شركة الفيحاء للمواد الهندسية ش م م",
"L_NM": "Al Faiha For Engineering Products sarl",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "300",
"Industrial certificate date": "16-Apr-18",
"ACTIVITY": "تجارة  مواد لتحسين وتقوية الخرسانة",
"Activity-L": "Trading of concrete admixture",
"ADRESS": "بناية بخعازي\u001c - طلعة المنارة\u001c - المناره - بيروت",
"TEL1": "01/741276",
"TEL2": "03/677491",
"TEL3": "",
"internet": "alfaiha@cyberia.net.lb"
},
{
"Category": "Third",
"Number": "20699",
"com-reg-no": "47957",
"NM": "افران باراديز للمعجنات",
"L_NM": "Paradise Bakery Est",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "2277",
"Industrial certificate date": "15-Feb-18",
"ACTIVITY": "صناعة الكعك والكيك واقراص التمر والكرواسان",
"Activity-L": " Manufacture of cake,dates & pastry",
"ADRESS": "ملك مازن ريدان\u001c - الشارع العام\u001c - عين كسور - عاليه",
"TEL1": "05/410306",
"TEL2": "03/810493",
"TEL3": "03/308997",
"internet": ""
},
{
"Category": "Third",
"Number": "20674",
"com-reg-no": "20834",
"NM": "وودي ش م م",
"L_NM": "Woody ltd",
"Last Subscription": "6-Apr-17",
"Industrial certificate no": "3495",
"Industrial certificate date": "28-Feb-18",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك الياس القارح\u001c - طريق قرطبا\u001c - حالات - جبيل",
"TEL1": "09/477088",
"TEL2": "03/234005",
"TEL3": "03/443874",
"internet": "info@woodydeco.com"
},
{
"Category": "Third",
"Number": "20649",
"com-reg-no": "67715",
"NM": "ايماج 36 ش م م",
"L_NM": "Image 36 sarl",
"Last Subscription": "28-Nov-17",
"Industrial certificate no": "4914",
"Industrial certificate date": "23-Nov-18",
"ACTIVITY": "صناعة مستحضرات التجميل",
"Activity-L": "Manufacture of cosmetics",
"ADRESS": "ملك شحاده عبد المسيح\u001c - الشارع العام\u001c - درعون - كسروان",
"TEL1": "09/263351",
"TEL2": "09/261717",
"TEL3": "03/660980",
"internet": "image36@saintgermainlb.com"
},
{
"Category": "Second",
"Number": "203",
"com-reg-no": "2887",
"NM": "شركة مطاحن التاج ش.م.ل",
"L_NM": "Crown Flour Mills sal",
"Last Subscription": "30-Jan-18",
"Industrial certificate no": "4690",
"Industrial certificate date": "9-Oct-18",
"ACTIVITY": "مطحنة للحنطة",
"Activity-L": "Mill of wheat",
"ADRESS": "بناية التاج\u001c - الشارع العام\u001c - كورنيش النهر - بيروت",
"TEL1": "01/448104",
"TEL2": "01/443440",
"TEL3": "03/339662",
"internet": "cfm@inco.com.lb"
},
{
"Category": "First",
"Number": "833",
"com-reg-no": "458",
"NM": "المصانع اللبنانية للنسيج - تضامن",
"L_NM": "Lebanese Textiles Mills L.T.M",
"Last Subscription": "11-Jan-17",
"Industrial certificate no": "3026",
"Industrial certificate date": "23-Dec-17",
"ACTIVITY": "صناعة مواد التنظيف",
"Activity-L": "Manufacture of detergents",
"ADRESS": "ملك وقف الروم الارثوذكس\u001c - طريق بيت مري\u001c - المكلس - المتن",
"TEL1": "01/688222",
"TEL2": "01/685222",
"TEL3": "03/144644",
"internet": "info@sanipro.com"
},
{
"Category": "Second",
"Number": "2263",
"com-reg-no": "26593",
"NM": "الشركة العالمية لصناعة الاحذية - انترشو - شركة تضامن",
"L_NM": "International Shoe Makers - Intershoe",
"Last Subscription": "2-Feb-18",
"Industrial certificate no": "4118",
"Industrial certificate date": "12-Jun-18",
"ACTIVITY": "صناعة الاحذية الرجالية والولادية",
"Activity-L": "Manufacture of men\'s & children\'s shoes",
"ADRESS": "ملك وارطان عربيان\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/487877",
"TEL2": "03/347004",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "20313",
"com-reg-no": "60367",
"NM": "شركة جي آر سي - الشرق الاوسط ش م م",
"L_NM": "G.R.C. Middle East sarl",
"Last Subscription": "6-Sep-17",
"Industrial certificate no": "4283",
"Industrial certificate date": "28-Jul-18",
"ACTIVITY": "معملا لصب الخرسانة المقوات بالالياف الزجاجية",
"Activity-L": "Casting of concrete products braced with fiber glass",
"ADRESS": "بناية سفيان صالح\u001c - شارع اليهودية\u001c - بشامون - عاليه",
"TEL1": "05/801248",
"TEL2": "03/331182",
"TEL3": "03/331332",
"internet": "grcmesarl@gmail.com"
},
{
"Category": "First",
"Number": "4491",
"com-reg-no": "65925",
"NM": "شركة فودز انداستريال كوربوريشين- فوديكو ش م م",
"L_NM": "Foods Industrial Corporation - Fodico sarl",
"Last Subscription": "1-Feb-18",
"Industrial certificate no": "2039",
"Industrial certificate date": "27-Nov-18",
"ACTIVITY": "معملا لتحميص وتعبئة وتوضيب البزروات والبن",
"Activity-L": "Roasting & packing of mixed nuts & coffee",
"ADRESS": "ملك ابراهيم زيدان وشركاه\u001c - حي الامراء - شارع التيرو\u001c - الشويفات - عاليه",
"TEL1": "05/433535",
"TEL2": "05/433636",
"TEL3": "",
"internet": "info@fodico.net"
},
{
"Category": "Third",
"Number": "20289",
"com-reg-no": "59049",
"NM": "اكوسيستم ليبان ش م م",
"L_NM": "Acousystem Liban sarl",
"Last Subscription": "13-Jun-17",
"Industrial certificate no": "4095",
"Industrial certificate date": "8-Jun-18",
"ACTIVITY": "تنفيذ تعهدات الهندسة المدنية وصناعة كواتم الصوت والحرارة",
"Activity-L": "Civil engineering contracting & manufacture of mufflers",
"ADRESS": "بناية كنيدر\u001c - طريق المكلس شارع  OTV\u001c - الدكوانة - المتن",
"TEL1": "01/683530",
"TEL2": "01/683531",
"TEL3": "03/781166",
"internet": "acousyst@inco.com.lb"
},
{
"Category": "Second",
"Number": "6174",
"com-reg-no": "56921",
"NM": "شركة كيسو اخوان هوت كوتير ش م ل",
"L_NM": "Guisso Bros Haute Couture sal",
"Last Subscription": "17-May-17",
"Industrial certificate no": "2093",
"Industrial certificate date": "18-Jun-17",
"ACTIVITY": "صناعة الالبسة النسائية والولادية",
"Activity-L": "Manufacture of ladies\' & childrens\' clothes",
"ADRESS": "بناية العضيمي ط 1\u001c - مار مارون\u001c - البوشرية - المتن",
"TEL1": "01/262240",
"TEL2": "03/667339",
"TEL3": "01/495882",
"internet": "guisso@dm.net.lb"
},
{
"Category": "First",
"Number": "3947",
"com-reg-no": "33978",
"NM": "بلكسي جمال",
"L_NM": "Plexi Jammal",
"Last Subscription": "17-Mar-17",
"Industrial certificate no": "4685",
"Industrial certificate date": "6-Oct-19",
"ACTIVITY": "معملا للمصنوعات الدعائية من البلكسي",
"Activity-L": "Manufacture of plexi products from advertising",
"ADRESS": "ملك سليم جمال\u001c - الشارع العام\u001c - رومية - المتن",
"TEL1": "01/898638",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "19995",
"com-reg-no": "61399",
"NM": "جي. ام. سي. للمقاولات والتجارة ش م م",
"L_NM": "J.M.C. Contracting & Trading sarl",
"Last Subscription": "6-Mar-18",
"Industrial certificate no": "4991",
"Industrial certificate date": "6-Dec-18",
"ACTIVITY": "مصنعا للنجارة والمفروشات",
"Activity-L": "Manufacture of  carpentry & furniture",
"ADRESS": "ملك االرهبانية المارونية المريمية\u001c - الساحة\u001c - زوق مصبح  - كسروان",
"TEL1": "03/320999",
"TEL2": "03/651655",
"TEL3": "09/225437",
"internet": "mouintannous@hotmail.com"
},
{
"Category": "First",
"Number": "3945",
"com-reg-no": "64732",
"NM": "شركة القناطر ش م ل",
"L_NM": "Sté Al Kanater sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4921",
"Industrial certificate date": "23-Nov-18",
"ACTIVITY": "معملا لتصنيع الطحينه والحلاوة وراحة الحلقوم",
"Activity-L": "Manufacture of halawa ,tahina & turkish delight",
"ADRESS": "ملك طوني ابو نعوم\u001c - الشارع العام\u001c - المكلس - المتن",
"TEL1": "01/687880",
"TEL2": "01/687881",
"TEL3": "01/687882",
"internet": "info@alkanater.com"
},
{
"Category": "Third",
"Number": "20509",
"com-reg-no": "73726",
"NM": "اكستاز - محمد وحيد قباني وشركاه - توصية بسيطة",
"L_NM": "Extase - M.W.Kabbani & Co",
"Last Subscription": "11-Feb-17",
"Industrial certificate no": "2529",
"Industrial certificate date": "2-Mar-18",
"ACTIVITY": "تجارة جملة التريكو والالبسة الرجالية والنسائية والولادية",
"Activity-L": " Wholesale of men\'s, ladies\' & children\'s clothes & tricot",
"ADRESS": "بناية شومان ورمضان\u001c - شارع صيدنايا\u001c - المصيطبة - بيروت",
"TEL1": "01/311885",
"TEL2": "01/703600",
"TEL3": "01/703601",
"internet": ""
},
{
"Category": "Fourth",
"Number": "27596",
"com-reg-no": "2037289",
"NM": "الجزيرة تك ش م ل",
"L_NM": "Aljazeera Tech sal",
"Last Subscription": "3-Feb-17",
"Industrial certificate no": "4745",
"Industrial certificate date": "17-Oct-18",
"ACTIVITY": " صناعة معدات الافران",
"Activity-L": "Manufacture  of bakery equipment",
"ADRESS": "ملك محمد زعرورط سفلي1\u001c - العمروسية - قرب حراجلي للصيرفه\u001c - الشويفات - عاليه",
"TEL1": "70/872694",
"TEL2": "03/872694",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "3737",
"com-reg-no": "65397",
"NM": "شركة روبير قشوع للتجارة والصناعة ش م م",
"L_NM": "Robert Kashou Trading & Manufacturing Co. (R.K.C) sarl",
"Last Subscription": "22-Jan-18",
"Industrial certificate no": "197",
"Industrial certificate date": "16-Jan-19",
"ACTIVITY": "صناعة سحب وتصنيع شفرات الالمنيوم لزوم الستورات والاسقف المستعارة والابواب",
"Activity-L": "Manufacture & drawing of aluminium blades for Blinds, False Ceilings& Doors",
"ADRESS": "ملك البير وروبير قشوع\u001c - المكلس - الشارع العام\u001c - الدكوانة - المتن",
"TEL1": "01/486195",
"TEL2": "01/486196+7",
"TEL3": "01/485500",
"internet": "kashouhm@idm.net.lb"
},
{
"Category": "Excellent",
"Number": "1554",
"com-reg-no": "66979",
"NM": "مؤسسة حمود",
"L_NM": "Beauty Home - Hammoud Est",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "3624",
"Industrial certificate date": "16-Mar-18",
"ACTIVITY": "معملا لغزل وصبغ وحياكة الاقمشة وصناعة المفروشات الخشبية والمعدنية والمطابخ",
"Activity-L": "Weaving & dyeing of textile - Manufacture of furniture & kitchen",
"ADRESS": "بناية ناصر الدين - ملك هشام حمود\u001c - شارع المقداد\u001c - حارة حريك - بعبدا",
"TEL1": "03/666981",
"TEL2": "01/278278",
"TEL3": "01/273381",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1710",
"com-reg-no": "66412",
"NM": "يونس اخوان ش م م",
"L_NM": "Younes Bros sarl",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4012",
"Industrial certificate date": "29-Mar-18",
"ACTIVITY": "تجميع المولدات الكهربائية وتصنيع تابلوهات كهربائية وكواتم الصوت",
"Activity-L": "Manufacture of generators & electrical boards & mufflers",
"ADRESS": "ملك يوسف وعماد يونس\u001c - طريق نهر الموت\u001c - الجديدة - المتن",
"TEL1": "01/901488",
"TEL2": "01/902488",
"TEL3": "01/887886",
"internet": "info@younesbros.com"
},
{
"Category": "Second",
"Number": "57",
"com-reg-no": "6",
"NM": "وديع تادرس واولاده - شركة تضامن",
"L_NM": "Wadih Tadros & Fils",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4382",
"Industrial certificate date": "27-Jul-18",
"ACTIVITY": "معملا لجلي الصخور والرخام والبلاط وتصنيع حجر البناء الصخري",
"Activity-L": "Cutting & polishing of stones, marble & rocks",
"ADRESS": "ملك ميشال وديع تادرس\u001c - شارع تادرس\u001c - المزرعة - بيروت",
"TEL1": "05/432223",
"TEL2": "05/432224",
"TEL3": "",
"internet": "admin@tadrosmarble.com"
},
{
"Category": "First",
"Number": "5044",
"com-reg-no": "66540",
"NM": "ابي اللمع وشعيا للهندسة الصناعية A.C.I.D ش م م",
"L_NM": "A.C.I.D sarl",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "2972",
"Industrial certificate date": "15-May-18",
"ACTIVITY": "اعمال الهندسة المدنية ومعملا للحدادة الافرنجية",
"Activity-L": "Civil engineering services & smithery factory",
"ADRESS": "ملك شركة ابي اللمع العقارية ش م ل\u001c - شارع ابي اللمع\u001c - الضبيه - المتن",
"TEL1": "04/542007",
"TEL2": "04/542008",
"TEL3": "04/542327",
"internet": "info@acidprojects.com"
},
{
"Category": "First",
"Number": "4039",
"com-reg-no": "71954",
"NM": "شركة الشرق الاوسط للصناعة والاليات ش م ل",
"L_NM": "Middle East Industries & Machineries -M.E.I.M sal",
"Last Subscription": "2-Jun-17",
"Industrial certificate no": "2768",
"Industrial certificate date": "22-Feb-18",
"ACTIVITY": "صناعة قوارير الغاز وقازانات",
"Activity-L": "Manufacture of bottles of gas & boilers",
"ADRESS": "ملك سناء جابر\u001c - شارع فردان\u001c - عين التينه - بيروت",
"TEL1": "01/808770",
"TEL2": "01/863464",
"TEL3": "",
"internet": "sigmalb@cyberia.net.lb"
},
{
"Category": "Fourth",
"Number": "26997",
"com-reg-no": "2034324",
"NM": "روزا جوليري ش م م",
"L_NM": "Rosa Jewellery sarl",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "4068",
"Industrial certificate date": "3-Jun-18",
"ACTIVITY": "صياغة المجوهرات",
"Activity-L": "Manufacture of jewelry",
"ADRESS": "ملك جمعية مرعش الارمنية الخيرية\u001c - شارع كرمانيك\u001c - برج حمود - المتن",
"TEL1": "03/614677",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "20353",
"com-reg-no": "66379",
"NM": "برجاق كومباني ش م م",
"L_NM": "Borjak Company sarl",
"Last Subscription": "13-Feb-18",
"Industrial certificate no": "4261",
"Industrial certificate date": "24-Jul-18",
"ACTIVITY": "صناعة السكاكر والشوكولا",
"Activity-L": "Manufacture of candies & chocolate",
"ADRESS": "ملك اسعد واسامة برجاق\u001c - الشارع العام\u001c - كترمايا - الشوف",
"TEL1": "07/971292",
"TEL2": "01/308189",
"TEL3": "03/220864",
"internet": "assaadborjak@hotmail.com"
},
{
"Category": "Third",
"Number": "20166",
"com-reg-no": "64957",
"NM": "بيد اند بيد ش م م",
"L_NM": "Bed and Bed sarl",
"Last Subscription": "2-Mar-18",
"Industrial certificate no": "418",
"Industrial certificate date": "20-Feb-19",
"ACTIVITY": "صناعة الفرشات وتنجيد اللحف والمخدات",
"Activity-L": "Manufacture of mattresses & upholstery of quilts & pillows",
"ADRESS": "ملك يروانيان\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/510632",
"TEL2": "01/497176",
"TEL3": "01/497177",
"internet": "bed-bed@dm.net.lb"
},
{
"Category": "Fourth",
"Number": "27627",
"com-reg-no": "1013540",
"NM": "شركة ايفان تفنكجيان ش م ل",
"L_NM": "Ivan Tufenkjian sal",
"Last Subscription": "23-Feb-18",
"Industrial certificate no": "2853",
"Industrial certificate date": "16-Nov-18",
"ACTIVITY": "صناعة وتجارة جملة المجوهرات والحلى الذهبية",
"Activity-L": "Manufacture & Wholesale of jewelry",
"ADRESS": "بناية فوش 94 ملك الشركة\u001c - شارع فوش\u001c - المرفأ - بيروت",
"TEL1": "01/999051",
"TEL2": "03/609609",
"TEL3": "",
"internet": "info@yvantufenkjian.com"
},
{
"Category": "Fourth",
"Number": "26993",
"com-reg-no": "2027519",
"NM": "جينيرال كوزميتكس مانيفاكتشور ش م م",
"L_NM": "General Cosmetics Manufacture - GCM - sarl",
"Last Subscription": "10-Mar-17",
"Industrial certificate no": "2365",
"Industrial certificate date": "5-Aug-17",
"ACTIVITY": "صناعة مستحضرات التجميل",
"Activity-L": "Manufacture of cosmetic products",
"ADRESS": "ملك الاشقر\u001c - المدينة الصناعية - شارع مار مارون\u001c - البوشرية - المتن",
"TEL1": "70/823400",
"TEL2": "03/915961",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "3660",
"com-reg-no": "63990",
"NM": "سيكا الشرق الادنى ش م ل",
"L_NM": "Sika Near East sal",
"Last Subscription": "29-May-17",
"Industrial certificate no": "2746",
"Industrial certificate date": "25-Oct-17",
"ACTIVITY": "انتاج مواد كيماوية بواسطة الخلط تضاف الى الباطون الجاهز",
"Activity-L": "Mixing of chemical materials for ready mixed concrete",
"ADRESS": "ملك اتحاد مصانع ورق السيكارة\u001c - القلعة - جسر الباشا\u001c - سن الفيل - المتن",
"TEL1": "01/510270",
"TEL2": "01/512272",
"TEL3": "",
"internet": "sikareg@cyberia.net.lb"
},
{
"Category": "Third",
"Number": "24358",
"com-reg-no": "65099",
"NM": "مؤسسة كرتاش",
"L_NM": "Kertache Est",
"Last Subscription": "28-Jan-17",
"Industrial certificate no": "4098",
"Industrial certificate date": "8-Jun-18",
"ACTIVITY": "صياغة المجوهرات",
"Activity-L": "manufacture of jewellery",
"ADRESS": "بناية بولاديان\u001c - الشارع العام\u001c - برج حمود - المتن",
"TEL1": "01/241774",
"TEL2": "01/244662",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "5519",
"com-reg-no": "2001648",
"NM": "شركة مطبعة دار الكتب ش م ل",
"L_NM": "Imprimeire Dar Al Kotob sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "316",
"Industrial certificate date": "1-Feb-19",
"ACTIVITY": "مطبعة للمطبوعات التجارية",
"Activity-L": "Printing press",
"ADRESS": "بناية باراديز\u001c - شارع عدنان الحكيم\u001c - بئر حسن - بعبدا",
"TEL1": "01/853753",
"TEL2": "03/599899",
"TEL3": "",
"internet": "info@53dots.com"
},
{
"Category": "Fourth",
"Number": "16029",
"com-reg-no": "59001",
"NM": "مؤسسة جانو بلاست التجارية",
"L_NM": "Jano Plast Trading Est",
"Last Subscription": "19-Jul-17",
"Industrial certificate no": "3409",
"Industrial certificate date": "18-Feb-18",
"ACTIVITY": "معمل اكياس نايلون والطباعة عليها",
"Activity-L": "Manufacture of nylon bags",
"ADRESS": "ملك جان سليخانيان\u001c - المنطقة الصناعية - الشارع العام\u001c - مزرعة يشوع - المتن",
"TEL1": "04/914015",
"TEL2": "03/217791",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "27655",
"com-reg-no": "2033967",
"NM": "شركة حلاق غروب",
"L_NM": "Hallak Group Co",
"Last Subscription": "22-Feb-18",
"Industrial certificate no": "483",
"Industrial certificate date": "28-Feb-19",
"ACTIVITY": "صياغة المجوهرات وتركيب الاحجار الكريمة",
"Activity-L": "Manufacture of jewelry & precious stones",
"ADRESS": "سنتر ده ده يان ط 6\u001c - الشارع العام\u001c - البوشرية - المتن",
"TEL1": "70/022023",
"TEL2": "01/256730",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1732",
"com-reg-no": "61992",
"NM": "شركة العلم للمقاولات والتجارة العامة ش م م",
"L_NM": "Al Alam Contracting & General Trading Company sarl",
"Last Subscription": "22-Feb-18",
"Industrial certificate no": "3472",
"Industrial certificate date": "24-Feb-18",
"ACTIVITY": "صناعة سقالات واشغال انشاءات معدنية",
"Activity-L": "Manufacture of scaffolds & metallic construction",
"ADRESS": "ملك الشركة\u001c - جسر الباشا - الشارع الرئيسي\u001c - المكلس - المتن",
"TEL1": "01/487762",
"TEL2": "01/487760",
"TEL3": "03/100161",
"internet": "alalam@idm.net.lb"
},
{
"Category": "Excellent",
"Number": "1799",
"com-reg-no": "73898",
"NM": "شركة ابناء عبد الله زين التجارية ش م م",
"L_NM": "Sons of Abdallah Zein Trading Co. sarl",
"Last Subscription": "24-Feb-17",
"Industrial certificate no": "3032",
"Industrial certificate date": "27-Dec-17",
"ACTIVITY": "اعمال الحدادة وتجارة الدهان، لوازم التمديدات الصحية والخردوات المعدنية",
"Activity-L": "Metallic carpentry & trading of paints, sanitary installation & hardware",
"ADRESS": "ملك مروان زين\u001c - شارع مايكل انجلو\u001c - الروشه - بيروت",
"TEL1": "01/820951",
"TEL2": "03/237931",
"TEL3": "03/237932",
"internet": ""
},
{
"Category": "Third",
"Number": "19799",
"com-reg-no": "59959",
"NM": "اسيوتكس غروب",
"L_NM": "Assiotex Group",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "2917",
"Industrial certificate date": "4-May-18",
"ACTIVITY": "صناعة الالبسة النسائية والولادية والرجالية",
"Activity-L": "Manufacture of ladies\' childrens & clothes",
"ADRESS": "ملك رحال\u001c - اوتوستراد الدوره\u001c - البوشرية - المتن",
"TEL1": "01/896489",
"TEL2": "01/880172",
"TEL3": "",
"internet": "assiotex@hotmail.com"
},
{
"Category": "Third",
"Number": "30085",
"com-reg-no": "51995",
"NM": "مؤسسة الفا بلاست لصناعة وتجارة البلاستيك",
"L_NM": "Alpha Plast Est. for Plastic Trade & Industry",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4538",
"Industrial certificate date": "28-Aug-18",
"ACTIVITY": "صناعة مصنوعات بلاستيكية: اواني منزلية, احواض زرع وصناديق خضارسدادات",
"Activity-L": "Manu.of plastic products:Kitchenware, Plant beds, fruit boxes&stoppers",
"ADRESS": "ملك عايدة السبع\u001c - تحويطة الغدير\u001c - برج البراجنة - بعبدا",
"TEL1": "03/750290",
"TEL2": "03/288144",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "5623",
"com-reg-no": "63206",
"NM": "يونسابلاي - توصية بسيطة",
"L_NM": "Unisupply",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4838",
"Industrial certificate date": "7-Nov-18",
"ACTIVITY": "صناعة ومزج وتعبئة بودرة معاجن للجدران ولاصق للبلاط",
"Activity-L": "Manufacture of wall powder putty & tiles glues",
"ADRESS": "ملك ميشال يونس\u001c - شارع البحر\u001c - البوشرية - المتن",
"TEL1": "01/255022",
"TEL2": "",
"TEL3": "",
"internet": "unis@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "1927",
"com-reg-no": "63200",
"NM": "مؤسسة رزوق - حبوبنا",
"L_NM": "Razzouk Est- Hboubna",
"Last Subscription": "13-Feb-18",
"Industrial certificate no": "4100",
"Industrial certificate date": "8-Jun-18",
"ACTIVITY": "تجارة الحبوب، البهارات، مواد غذائية معلبة، الحلاوة، الطحينة وراحة الحلقوم",
"Activity-L": "Trading of cereal, spices, canned foodstuffs, halawa tahina&turkish delight",
"ADRESS": "ملك زعيتر\u001c - النبعة - شارع الغيلان\u001c - برج حمود - المتن",
"TEL1": "01/240359",
"TEL2": "03/211996",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "5015",
"com-reg-no": "68069",
"NM": "شركة اللتيك ليبانون ش م ل",
"L_NM": "Alltek Lebanon sal",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "136",
"Industrial certificate date": "4-Jan-19",
"ACTIVITY": "صناعة وتعبئة المعاجين والدهانات",
"Activity-L": "Manufacture of putty & paints",
"ADRESS": "ملك لور ابتور\u001c - شارع سامي الصلح\u001c - بدارو - بيروت",
"TEL1": "01/384171",
"TEL2": "01/384172",
"TEL3": "09/945938",
"internet": "altek@terra.net.lb"
},
{
"Category": "Third",
"Number": "20151",
"com-reg-no": "64908",
"NM": "كركي للصناعة والتجارة ش م م",
"L_NM": "Karaki for Industry & Trading sarl",
"Last Subscription": "6-Feb-18",
"Industrial certificate no": "3522",
"Industrial certificate date": "16-Mar-18",
"ACTIVITY": "صناعة الافران وتجهيزات المطاعم والمستشفيات",
"Activity-L": "Manufacture of bakeries, restaurant & hospital supplies",
"ADRESS": "ملك محمد يوسف كركي\u001c - شارع الكنيسه\u001c - حارة حريك - بعبدا",
"TEL1": "05/434905",
"TEL2": "05/434906",
"TEL3": "",
"internet": "info@karaki.com"
},
{
"Category": "First",
"Number": "3944",
"com-reg-no": "57105",
"NM": "استرا اندستريز ش م ل",
"L_NM": "Astra Industries sal",
"Last Subscription": "1-Feb-18",
"Industrial certificate no": "3968",
"Industrial certificate date": "13-May-18",
"ACTIVITY": "صناعة اجهزة معدنية وشاسيهات للانارة",
"Activity-L": "Manufacture of metal articles for lighting",
"ADRESS": "ملك عرمان\u001c - شارع طرابلس القديم\u001c - برج حمود - المتن",
"TEL1": "01/251635+6",
"TEL2": "01/251637",
"TEL3": "03/694468",
"internet": "astra@sodetel.net.lb"
},
{
"Category": "Second",
"Number": "3657",
"com-reg-no": "65142",
"NM": "اوتوماتيك برورز ش م م",
"L_NM": "Automatic Brewers sarl",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "4218",
"Industrial certificate date": "6-Mar-16",
"ACTIVITY": "تجارة ماكينات قهوة والشرابات الساخنة- (expresso)",
"Activity-L": "Wholesale of vending machines (expresso)",
"ADRESS": "ملك الياس دانيال\u001c - المدينة الصناعية\u001c - سد البوشرية - المتن",
"TEL1": "01/685685",
"TEL2": "01/685686",
"TEL3": "03/109757",
"internet": "info@barista-espresso.com"
},
{
"Category": "Excellent",
"Number": "1585",
"com-reg-no": "61893",
"NM": "شركة PAC  ش م م",
"L_NM": "Power & Automation Control sarl",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "3232",
"Industrial certificate date": "26-Jan-18",
"ACTIVITY": "صناعة التابلوهات والمحولات الكهربائية",
"Activity-L": " Manufacture of electrical board & transformers",
"ADRESS": "بناية حيدر وشركاه\u001c - شارع السفارات\u001c - بئر حسن - بعبدا",
"TEL1": "01/854288",
"TEL2": "01/854286",
"TEL3": "",
"internet": "info@paclb.com"
},
{
"Category": "Second",
"Number": "6141",
"com-reg-no": "69257",
"NM": "الشركة المتحدة لصناعة وتجارة الشوكولا والسكاكر ش م م",
"L_NM": "United Co. for Manufacturing&Trading of Chocolate&Confectionery sarl",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "634",
"Industrial certificate date": "6-Jun-18",
"ACTIVITY": "صناعة الشوكولا وتجارة علب الافراح",
"Activity-L": "Manufacture of chocolates & trading of souvenir for wedding",
"ADRESS": "بناية حاموش\u001c - اوتوستراد هادي نصر الله\u001c - حارة حريك - بعبدا",
"TEL1": "01/547373",
"TEL2": "01/557889",
"TEL3": "03/743070",
"internet": "amigo_beirut@hotmail.com"
},
{
"Category": "Second",
"Number": "6043",
"com-reg-no": "54487",
"NM": "شركة فيتراس - اميل رسام - ش م م",
"L_NM": "Vet - Rass - Emile Rassam - sarl",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "3381",
"Industrial certificate date": "15-Mar-18",
"ACTIVITY": "صناعة البسة خاصة بالمطاعم والمستشفيات والبياضات، وتجارة الاحذية",
"Activity-L": "Manufacture of uniforms & household textile arlicles, & Trading of shoes",
"ADRESS": "ملك لورانس المقدسي\u001c - شارع البيبسي\u001c - الحازمية - بعبدا",
"TEL1": "05/451732",
"TEL2": "05/950164",
"TEL3": "05/950202",
"internet": "mr@emilerassam.com"
},
{
"Category": "Third",
"Number": "19984",
"com-reg-no": "64712",
"NM": "مؤسسة باز للصناعة والتجارة",
"L_NM": "Baz for Industrial and Trade Est",
"Last Subscription": "14-Mar-17",
"Industrial certificate no": "4452",
"Industrial certificate date": "8-Aug-18",
"ACTIVITY": "صناعة قوالب معدنية وماكينات صناعية للبلاستيك",
"Activity-L": "Manufacture of metal moulds & industrial machines for plastic",
"ADRESS": "ملك جواد باز\u001c - حي اليهودية\u001c - بشامون - عاليه",
"TEL1": "03/366289",
"TEL2": "05/801689",
"TEL3": "",
"internet": "jawadbaz@inco.com.lb"
},
{
"Category": "Excellent",
"Number": "1192",
"com-reg-no": "2068",
"NM": "مصانع حشيمة ش م ل",
"L_NM": "Hechaimé Factories sal",
"Last Subscription": "22-Jan-18",
"Industrial certificate no": "4656",
"Industrial certificate date": "2-Oct-18",
"ACTIVITY": "صناعة البلاط ونشر الصخور",
"Activity-L": "Manufacture of tiles & cutting of rocks",
"ADRESS": "ملك شركة شير ش م ل\u001c - طلعة يسوع الملك\u001c - زوق مصبح - كسروان",
"TEL1": "09/218485",
"TEL2": "09/218484",
"TEL3": "09/218483",
"internet": "hechaime.factories@inco.com"
},
{
"Category": "First",
"Number": "4353",
"com-reg-no": "61551",
"NM": "Boraplast sarl",
"L_NM": "Boraplast sarl",
"Last Subscription": "12-Feb-18",
"Industrial certificate no": "313",
"Industrial certificate date": "30-Apr-18",
"ACTIVITY": "صناعة اواني بلاستيكية",
"Activity-L": "Manufacture of plastic products",
"ADRESS": "ملك سركيس ساريان\u001c - شارع الضمان الاجتماعي\u001c - البوشرية - المتن",
"TEL1": "01/874234",
"TEL2": "03/308051",
"TEL3": "",
"internet": "borakev@hotmail.com"
},
{
"Category": "Second",
"Number": "6075",
"com-reg-no": "66292",
"NM": "موريس بشير مشعلاني م.ب.م",
"L_NM": "Maurice B. Machaalany M.B.M",
"Last Subscription": "20-Jan-17",
"Industrial certificate no": "2734",
"Industrial certificate date": "7-Feb-18",
"ACTIVITY": "صناعة الخمور، ماء الزهر والورد والخل والكونسروة والمربيات",
"Activity-L": "Manufacture of alcoholic drinks,canned foods,orange-flower,rose water&jams",
"ADRESS": "ملك موريس مشعلاني\u001c - شارع عازار\u001c - سن الفيل - المتن",
"TEL1": "01/510976",
"TEL2": "01/510977",
"TEL3": "03/636634",
"internet": "mechelanyfoods@hotmail.com"
},
{
"Category": "Third",
"Number": "20335",
"com-reg-no": "66343",
"NM": "شركة ايفل الدولية للتجارة العامة والصناعة ش م م",
"L_NM": "Eavel International Company for General Trade & Industry sarl",
"Last Subscription": "31-Oct-17",
"Industrial certificate no": "4636",
"Industrial certificate date": "30-Sep-18",
"ACTIVITY": "صناعة الدهانات - تنفيذ التعهدات المعمارية",
"Activity-L": "Paints Industry - Building Contracting",
"ADRESS": "ملك حسن غملوش\u001c - العمروسية - شارع الديقه\u001c - الشويفات - عاليه",
"TEL1": "03/387398",
"TEL2": "05/431898",
"TEL3": "03/634892",
"internet": ""
},
{
"Category": "Second",
"Number": "6256",
"com-reg-no": "69295",
"NM": "شركة صدقة للمعجنات والحلويات - توصية بسيطة",
"L_NM": "Sadaka Company for Pastries & Sweets",
"Last Subscription": "24-Jan-18",
"Industrial certificate no": "2330",
"Industrial certificate date": "8-Feb-18",
"ACTIVITY": "صناعة الحلويات العربية والمعجنات",
"Activity-L": "Manufacture of oriental sweets & pastries",
"ADRESS": "ملك احمد صدقة\u001c - شارع القسيس\u001c - حارة حريك - بعبدا",
"TEL1": "01/278248",
"TEL2": "01/542542",
"TEL3": "",
"internet": "info@sadaka-lb.com"
},
{
"Category": "Fourth",
"Number": "16892",
"com-reg-no": "75906",
"NM": "مؤسسة بلاكستيل",
"L_NM": "Plexstyle",
"Last Subscription": "27-Jan-18",
"Industrial certificate no": "3611",
"Industrial certificate date": "15-Mar-18",
"ACTIVITY": "صناعة الارمات واللوحات الاعلانية",
"Activity-L": "Manufacture of nameplates",
"ADRESS": "بناية الميساء ملك مازن عضاضة\u001c - شارع المتحف\u001c - العدلية - بيروت",
"TEL1": "01/386856",
"TEL2": "",
"TEL3": "",
"internet": "mzadada@plexstyle.com"
},
{
"Category": "Third",
"Number": "29214",
"com-reg-no": "76439",
"NM": "مطبعة ملاك التجارية",
"L_NM": "Malak Printing Press",
"Last Subscription": "25-Jan-18",
"Industrial certificate no": "2261",
"Industrial certificate date": "30-Jan-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing",
"ADRESS": "بناية منيمنة وسعد\u001c - شارع عبد الله خالد\u001c - البسطا التحتا - بيروت",
"TEL1": "70/120420",
"TEL2": "03/740207",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "28029",
"com-reg-no": "2025137",
"NM": "شركة حداد لتجارة الورق ش م م",
"L_NM": "Haddad Papers Trading Company sarl",
"Last Subscription": "9-Sep-17",
"Industrial certificate no": "4202",
"Industrial certificate date": "28-May-18",
"ACTIVITY": "طباعة ورق الهدايا وورق التغليف والتوضيب، اكياس وعلب وورق كرتون والاتيكيت",
"Activity-L": "Printing of gift & wrapping papers, paper & carton bags & boxes, etiquettes",
"ADRESS": "ملك الحداد\u001c - الروضه - شارع السيدة\u001c - البوشرية - المتن",
"TEL1": "01/680155",
"TEL2": "",
"TEL3": "",
"internet": "tony@haddadpapers.com"
},
{
"Category": "First",
"Number": "3310",
"com-reg-no": "48114",
"NM": "كاترينغ ديسبوزبل سيستم - كاديس ش م ل",
"L_NM": "Catering Disposable System - Cadis sal",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4120",
"Industrial certificate date": "12-Jun-18",
"ACTIVITY": "صناعة اكواب وصحون وصواني من ورق",
"Activity-L": "Manufacture of paper cups, dishes & trays",
"ADRESS": "ملك الشركة\u001c - الشارع العام\u001c - حصرايل - جبيل",
"TEL1": "09/790675",
"TEL2": "09/790676",
"TEL3": "03/766266",
"internet": "elie.seif@cadis.cc"
},
{
"Category": "Third",
"Number": "21382",
"com-reg-no": "27435",
"NM": "شركة الكترا للصناعة والتجارة ش م م",
"L_NM": "Electra - Industrial & Commercial Company sarl",
"Last Subscription": "6-Jul-17",
"Industrial certificate no": "89",
"Industrial certificate date": "26-Dec-18",
"ACTIVITY": "صاعة التوصيلات المعدنية وحدادة (علب معدنية للأدوات والتابلوهات الكهربائية)",
"Activity-L": "Manufacture of spot lights & electrical boards",
"ADRESS": "ملك ابي سمرا وشرارة\u001c - صفير- اوتوستراد المطار\u001c - حارة حريك - بعبدا",
"TEL1": "01/550850",
"TEL2": "70/812842",
"TEL3": "03/225554",
"internet": "info@electraco.com"
},
{
"Category": "Third",
"Number": "26041",
"com-reg-no": "24143",
"NM": "عقاد ش م م",
"L_NM": "Accad sarl",
"Last Subscription": "5-Jan-17",
"Industrial certificate no": "1799",
"Industrial certificate date": "28-Apr-17",
"ACTIVITY": "صناعة نسيج شريط المغيط والدنتيل",
"Activity-L": "Manufacture of elastic ribbon & laces",
"ADRESS": "ملك جوزف عقاد\u001c - المنطقة الصناعية - الشارع العام\u001c - غزير - كسروان",
"TEL1": "09/920833",
"TEL2": "03/615233",
"TEL3": "03/444486",
"internet": "accad_ltd@terra.net.lb"
},
{
"Category": "Fourth",
"Number": "27659",
"com-reg-no": "2031302",
"NM": "جورج الياس حبيب للتجارة",
"L_NM": "Georges Elias Habib for Trade",
"Last Subscription": "19-Feb-18",
"Industrial certificate no": "2123",
"Industrial certificate date": "23-Jan-17",
"ACTIVITY": "تجارة الاخشاب",
"Activity-L": "Trading of wood",
"ADRESS": "ملك حبيب\u001c - المدينة الصناعية - شارع رقم 92\u001c - سد البوشرية - المتن",
"TEL1": "01/707712",
"TEL2": "03/940845",
"TEL3": "03/221357",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1728",
"com-reg-no": "61928",
"NM": "الشركة المتحدة للصناعة والتعهدات ش م ل - يونيك",
"L_NM": "The United for Industry and Contracting sal - Unic",
"Last Subscription": "16-Mar-18",
"Industrial certificate no": "2903",
"Industrial certificate date": "29-Apr-18",
"ACTIVITY": "صناعة فتحات ومجاري تكييف الهواء وغرف التبريد",
"Activity-L": "Manufacture of ventilation & cooling rooms",
"ADRESS": "ملك خنيصر\u001c - المنطقة الصناعية\u001c - روميه - المتن",
"TEL1": "01/884579",
"TEL2": "03/236936",
"TEL3": "01/878853",
"internet": "unic@unic-cooler.com"
},
{
"Category": "Excellent",
"Number": "1678",
"com-reg-no": "22176",
"NM": "شركة بي ام اي  B.M.A للتجارة والصناعة ش م م",
"L_NM": "B.M.A Commercial and Industrial sarl",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "3826",
"Industrial certificate date": "13-Apr-18",
"ACTIVITY": "صناعة الدهانات للموبيليا والسيارات",
"Activity-L": "Manufacture of paints for furniture & cars",
"ADRESS": "ملك الشركة\u001c - المدينة الصناعية\u001c - نهر الموت عين سعادة - المتن",
"TEL1": "01/885385",
"TEL2": "01/885485",
"TEL3": "70/285085",
"internet": "info@bmapaints.com"
},
{
"Category": "Second",
"Number": "4487",
"com-reg-no": "61197",
"NM": "شركة صفا غروب ش م ل",
"L_NM": "Safa Group Co. sal",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "4035",
"Industrial certificate date": "27-May-18",
"ACTIVITY": "معملا لنشر الرخام والغرانيت",
"Activity-L": "Cutting of marble and granite",
"ADRESS": "ملك سلمان بو غانم\u001c - الشارع العام\u001c - الرملية - عاليه",
"TEL1": "05/230231",
"TEL2": "03/234123",
"TEL3": "",
"internet": "info@safa-group.com"
},
{
"Category": "First",
"Number": "4249",
"com-reg-no": "50835",
"NM": "شركة سوبرا غروب ش م م",
"L_NM": "Supra Group sarl",
"Last Subscription": "3-Mar-18",
"Industrial certificate no": "4721",
"Industrial certificate date": "13-Jan-18",
"ACTIVITY": "تجارة جملة الدهانات ومواد ضد النش",
"Activity-L": "Wholesale of paints & waterproofing materials",
"ADRESS": "ملك عبدو غزال\u001c - الشارع العام\u001c - فتقا- كسروان",
"TEL1": "09/222340",
"TEL2": "03/342661",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "19451",
"com-reg-no": "54978",
"NM": "شركة S.M.S للخدمات والتجارة العامة ش م م",
"L_NM": "Company: Sign Module System (S.M.S) sarl",
"Last Subscription": "17-Feb-18",
"Industrial certificate no": "373",
"Industrial certificate date": "12-Feb-19",
"ACTIVITY": "صناعة الارمات ولوازم تركيبها",
"Activity-L": "Manufacture of nameplates",
"ADRESS": "ملك وقف مدرسة عين ورقة\u001c - المدينة الصناعية\u001c - حالات - جبيل",
"TEL1": "09/478582",
"TEL2": "70/743439",
"TEL3": "",
"internet": "sms@cyberia.net.lb"
},
{
"Category": "Third",
"Number": "19484",
"com-reg-no": "53175",
"NM": "الشركة اللبنانية لصناعة ملبوسات الاطفال Elsa - Tex ش م م",
"L_NM": "Elsa - Tex sarl",
"Last Subscription": "20-Jan-17",
"Industrial certificate no": "1086",
"Industrial certificate date": "21-Jan-17",
"ACTIVITY": "صناعة الالبسة الولادية والنسائية والرياضية",
"Activity-L": "Manufacture of ladies\' & children\'s clothes & sportswear",
"ADRESS": "ملك الياس صليبي\u001c - المنطقة الصناعية\u001c - مزرعة يشوع - المتن",
"TEL1": "04/922559",
"TEL2": "04/910570",
"TEL3": "03/616579",
"internet": "elsatex@hotmail.com"
},
{
"Category": "Third",
"Number": "19567",
"com-reg-no": "61521",
"NM": "شركة المطابع الحديثة ش م م",
"L_NM": "Modern Printing Co. sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "3468",
"Industrial certificate date": "24-Feb-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing",
"ADRESS": "ملك ندين وريشارد نصراوي\u001c - شارع الفندقية\u001c - الدكوانة - المتن",
"TEL1": "01/691407",
"TEL2": "01/691408",
"TEL3": "",
"internet": "mpc.mpco@gmail.com"
},
{
"Category": "Second",
"Number": "6472",
"com-reg-no": "20901",
"NM": "هومتل ش م م",
"L_NM": "Société Hometel sarl",
"Last Subscription": "21-Aug-17",
"Industrial certificate no": "4418",
"Industrial certificate date": "2-Aug-18",
"ACTIVITY": "صناعة علب وتابلوهات وخزائن معدنية وبلاكات الكترونية",
"Activity-L": "Manufacture of electrical board & electronic components",
"ADRESS": "ملك ابي سلوم\u001c - المنطقة الصناعية\u001c - حصرايل - جبيل",
"TEL1": "09/791993",
"TEL2": "09/790993",
"TEL3": "03/623621",
"internet": "hometel@home-tel.net"
},
{
"Category": "Third",
"Number": "24354",
"com-reg-no": "58155",
"NM": "مؤسسة فريج شماسيان",
"L_NM": "Vrej Shemmessian Est",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "294",
"Industrial certificate date": "16-Feb-19",
"ACTIVITY": "صياغة المجوهرات",
"Activity-L": " Manufacture of jewellery",
"ADRESS": "سنتر هاربويان\u001c - الشارع الداخلي\u001c - برج حمود - المتن",
"TEL1": "01/241381",
"TEL2": "01/260232",
"TEL3": "",
"internet": "info@vrejshemmessian.com"
},
{
"Category": "Second",
"Number": "6290",
"com-reg-no": "72717",
"NM": "شركة السا ش م ل",
"L_NM": "Elsa sal",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "309",
"Industrial certificate date": "31-Jan-19",
"ACTIVITY": "صناعة السكاكر والشوكولا",
"Activity-L": "Manufacture of candies & chocolate",
"ADRESS": "بناية الديار\u001c - شارع الاستقلال - تقاطع كركول الدروز\u001c - المصيطبة - بيروت",
"TEL1": "01/375984",
"TEL2": "01/369342",
"TEL3": "",
"internet": "info@elsachocolate.com"
},
{
"Category": "First",
"Number": "4530",
"com-reg-no": "67676",
"NM": "شركة: Mega بريفاب ش م ل",
"L_NM": "Mega Prefab sal",
"Last Subscription": "14-Jun-17",
"Industrial certificate no": "2341",
"Industrial certificate date": "1-Jun-18",
"ACTIVITY": "معمل لصب الباطون الجاهز",
"Activity-L": "Casting of ready mixed concrete",
"ADRESS": "ملك مروان نقفور\u001c - شارع مار شربل\u001c - الاشرفية - بيروت",
"TEL1": "01/322022",
"TEL2": "01/328847",
"TEL3": "01/217402",
"internet": "mail@megaprefab.com"
},
{
"Category": "Third",
"Number": "16675",
"com-reg-no": "64922",
"NM": "ناتورال ش م م",
"L_NM": "Natural sarl",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4589",
"Industrial certificate date": "12-Sep-18",
"ACTIVITY": "صناعة الزيوت وكريمات التجميل",
"Activity-L": "Manufacture of cosmetic oils and creams",
"ADRESS": "بناية العريسي\u001c - شارع الماما\u001c - تلة الخياط - بيروت",
"TEL1": "05/807870",
"TEL2": "05/807871",
"TEL3": "",
"internet": "info@beesline.com"
},
{
"Category": "Third",
"Number": "19649",
"com-reg-no": "73205",
"NM": "وارطان بابازيان واولاده ش م م",
"L_NM": "Vartan Papazian & Sons sarl",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "4426",
"Industrial certificate date": "3-Aug-18",
"ACTIVITY": "صناعة المجوهرات",
"Activity-L": "Manufacture of jewelry",
"ADRESS": "ملك الوقف الماروني\u001c - مار ميخائيل\u001c - بيروت",
"TEL1": "01/585117+8",
"TEL2": "01/442819",
"TEL3": "01/445911",
"internet": "Hagop@dm.net.lb"
},
{
"Category": "Excellent",
"Number": "1505",
"com-reg-no": "60629",
"NM": "زعني ستيل للصناعة والتجارة ش م م",
"L_NM": "Zeeni Steel Industries & Trading sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "4059",
"Industrial certificate date": "5-Jun-18",
"ACTIVITY": "صناعة المنتجات الحديدية وتجارة جملة الحديد والصفائح",
"Activity-L": "Manufacture of iron works / wholesale of iron sheets & doors",
"ADRESS": "ملك زياد ومازن زعني\u001c - الشارع العام\u001c - بشامون - عاليه",
"TEL1": "05/804222",
"TEL2": "03/222966",
"TEL3": "03/704001+2",
"internet": "zeennisteel@hotmail.com"
},
{
"Category": "Third",
"Number": "19635",
"com-reg-no": "62422",
"NM": "غاتينوللي",
"L_NM": "Gattinolli",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4843",
"Industrial certificate date": "8-Oct-18",
"ACTIVITY": "صناعة الالبسة النسائية",
"Activity-L": "Manufacture of ladies clothes",
"ADRESS": "ملك مروان اميل نصر الله\u001c - قرب كنيسة مار تقلا\u001c - سد البوشرية - المتن",
"TEL1": "01/877335",
"TEL2": "03/302749",
"TEL3": "",
"internet": "gattinolli@yahoo.com"
},
{
"Category": "Excellent",
"Number": "1164",
"com-reg-no": "62792",
"NM": "شمالي اند شمالي للطباعة ش م ل",
"L_NM": "Chemaly & Chemaly Printing Press sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "447",
"Industrial certificate date": "22-Feb-19",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "ملك الشركة\u001c - جسر الباشا - شارع مار الياس\u001c - المكلس - المتن",
"TEL1": "01/510385+7",
"TEL2": "01/510612+13",
"TEL3": "01/510616",
"internet": "chemaly@chemaly.com"
},
{
"Category": "First",
"Number": "3859",
"com-reg-no": "25956",
"NM": "شركة مختبرات شرف الدين الصناعية ش م م",
"L_NM": "Charafeddine Industrial Laboratories",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "3810",
"Industrial certificate date": "11-Apr-18",
"ACTIVITY": "صناعة مستحضرات صيدلانية للتجميل",
"Activity-L": "Manufacture of pharmaceutical cosmetic products",
"ADRESS": "ملك سعيد شرف الدين\u001c - طريق الشام - عاليه",
"TEL1": "05/554211",
"TEL2": "05/559959",
"TEL3": "03/355211",
"internet": "cil@dm.net.lb"
},
{
"Category": "Excellent",
"Number": "1160",
"com-reg-no": "59531",
"NM": "شركة المجموعة اللبنانية للاعلام ش م ل",
"L_NM": "Lebanese Communication Group LCG. Sal",
"Last Subscription": "29-Mar-17",
"Industrial certificate no": "3394",
"Industrial certificate date": "16-Feb-18",
"ACTIVITY": "تلفزيون (المنار) ونسخ ودبلجة اشرطة الفيديو",
"Activity-L": "TV( Manar) & reproduction of video recording",
"ADRESS": "ملك الشركة\u001c - شارع القسيس\u001c - حارة حريك - بعبدا",
"TEL1": "01/276000",
"TEL2": "03/217405",
"TEL3": "01/555953",
"internet": "info@manartv.com.lb"
},
{
"Category": "First",
"Number": "3896",
"com-reg-no": "62097",
"NM": "مجوهرات الجميل الدولية ش م ل",
"L_NM": "Joaillerie Gemayel International sal",
"Last Subscription": "12-Feb-18",
"Industrial certificate no": "3579",
"Industrial certificate date": "10-Mar-18",
"ACTIVITY": "صناعة الحلى والمجوهرات",
"Activity-L": "Manufacture of jewellery",
"ADRESS": "ملك الجميل\u001c - صربا - شارع الكسليك\u001c - جونيه - كسروان",
"TEL1": "09/640501+2",
"TEL2": "09/640803",
"TEL3": "",
"internet": "mail@gemayeljewellery.com"
},
{
"Category": "First",
"Number": "5331",
"com-reg-no": "2037516",
"NM": "كونفكسيا ش م ل",
"L_NM": "Confexia sal",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4785",
"Industrial certificate date": "24-Apr-18",
"ACTIVITY": "صناعة الشوكولا والبسكويت",
"Activity-L": "Manufacture of chocolate & biscuits",
"ADRESS": "بناية اكمكجي- ملك الشركة\u001c -  شارع ثكنة الوروار\u001c - الحدت - بعبدا",
"TEL1": "05/464062",
"TEL2": "05/463727",
"TEL3": "",
"internet": "info@confexia.com"
},
{
"Category": "Third",
"Number": "29384",
"com-reg-no": "1017581",
"NM": "شركة بروستيل ش م ل",
"L_NM": "Pro Steel sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4998",
"Industrial certificate date": "25-Jun-16",
"ACTIVITY": "اشغال معدنية",
"Activity-L": "Manufacture of metallic structure",
"ADRESS": "ملك جمال القواص ط 7\u001c - جسر سليم سلام\u001c - المصيطبة - بيروت",
"TEL1": "05/803397",
"TEL2": "03/455458",
"TEL3": "",
"internet": "info@prosteel.me"
},
{
"Category": "Third",
"Number": "19391",
"com-reg-no": "59816",
"NM": "روك ماربل غرانيت ش م م",
"L_NM": "Rock Marble Granite - R.M.G - sarl",
"Last Subscription": "14-Dec-17",
"Industrial certificate no": "4798",
"Industrial certificate date": "26-Oct-18",
"ACTIVITY": "معملا لنشر الصخور والرخام",
"Activity-L": "Sawing of rocks & marble",
"ADRESS": "ملك جان الراعي وهند دكاش\u001c - شارع المصفاة\u001c - جبيل",
"TEL1": "09/790283",
"TEL2": "09/790285",
"TEL3": "03/609464",
"internet": "info@rmgranite.com"
},
{
"Category": "First",
"Number": "357",
"com-reg-no": "15290",
"NM": "شركة تحويل الورق ومشتقاته - باتراكو ش م ل",
"L_NM": "Paper Transformation Co. Patraco sal",
"Last Subscription": "10-Mar-18",
"Industrial certificate no": "4026",
"Industrial certificate date": "24-May-18",
"ACTIVITY": "تقطيع وتوضيب ورق الطباعة",
"Activity-L": "Cutting & Packing of paper for printing",
"ADRESS": "ملك الشركة\u001c - الاوتوستراد\u001c - الدكوانة - المتن",
"TEL1": "01/480238",
"TEL2": "01/481297",
"TEL3": "01/510737",
"internet": "patraco@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "1123",
"com-reg-no": "57749",
"NM": "مدينة المفروشات ش م ل",
"L_NM": "City Furniture sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4377",
"Industrial certificate date": "26-Jul-18",
"ACTIVITY": "صناعة المفروشات المعدنية والخشبية",
"Activity-L": "Manufacture of wooden & metallic furnitures",
"ADRESS": "ملك كرسي ابرشية بيروت المارونية\u001c -  تقاطع الشفروليه\u001c -  فرن الشباك - بعبدا",
"TEL1": "01/293333",
"TEL2": "",
"TEL3": "",
"internet": "hr@citifurniture.net"
},
{
"Category": "Second",
"Number": "3540",
"com-reg-no": "60485",
"NM": "شركة وديع قساطلي للصناعة والتجارة ش م ل",
"L_NM": "Ste. Wadih Kassatly Pour L\'Industrie Et le Commerce sal",
"Last Subscription": "23-Mar-18",
"Industrial certificate no": "4950",
"Industrial certificate date": "29-Oct-18",
"ACTIVITY": "صناعة وتعبئة المشروبات الروحية والشرابات والخل والمكابيس والمربيات",
"Activity-L": "Manufacture of beverages, alcoholic drinks,vinegar, pickles& jams",
"ADRESS": "بناية راجحة\u001c - شارع الحكمة\u001c - عين الرمانة - بعبدا",
"TEL1": "01/381374",
"TEL2": "01/396015",
"TEL3": "03/334156",
"internet": "ajyal@kassatly.com"
},
{
"Category": "First",
"Number": "4747",
"com-reg-no": "43431",
"NM": "سمبلاست ش م م",
"L_NM": "Samplast sarl",
"Last Subscription": "7-Feb-18",
"Industrial certificate no": "4291",
"Industrial certificate date": "13-Jul-18",
"ACTIVITY": "صناعة السلع البلاستيكية كالطاولات والكراسي والادوات المنزلية",
"Activity-L": "Manufature of Plastic Tables, Chairs & Kitchenware",
"ADRESS": "ملك سمور\u001c - الشارع العام\u001c - غرزوز - جبيل",
"TEL1": "09/790645",
"TEL2": "03/618789",
"TEL3": "",
"internet": "chawkys@hotmail.com"
},
{
"Category": "Third",
"Number": "19378",
"com-reg-no": "55516",
"NM": "مجوهرات يساييان ش م م",
"L_NM": "Yessayan Jewellery sarl",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "4097",
"Industrial certificate date": "8-Jun-18",
"ACTIVITY": "صناعة المجوهرات",
"Activity-L": "Manufacture of jewellery",
"ADRESS": "ملك يساييان\u001c - كمب التيرو\u001c - برج حمود - المتن",
"TEL1": "01/322522",
"TEL2": "01/321681",
"TEL3": "01/970751",
"internet": "yessayan@yessayan.com"
},
{
"Category": "Second",
"Number": "7062",
"com-reg-no": "60788",
"NM": "مؤسسة برنس اورينت",
"L_NM": "Prince Orient",
"Last Subscription": "27-Jan-18",
"Industrial certificate no": "223",
"Industrial certificate date": "18-Jan-19",
"ACTIVITY": "صناعة الالبسة العسكرية والمدنية وتجارة جملة اسلحة صيد وحربية",
"Activity-L": "Manufacture of military&civil clothes & Wholesale of war& hunting weapons",
"ADRESS": "بناية السلام\u001c - حي الابيض - شارع صفير\u001c - حارة حريك - بعبدا",
"TEL1": "01/542485",
"TEL2": "03/756284",
"TEL3": "03/909957",
"internet": "prince_orient_maatouk@hotmail.com"
},
{
"Category": "Fourth",
"Number": "15405",
"com-reg-no": "58504",
"NM": "ميلوديا Melodia - حمادي للتجارة والصناعة",
"L_NM": "Melodia",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4847",
"Industrial certificate date": "9-Nov-18",
"ACTIVITY": "صناعة الشوكولا والسكاكر",
"Activity-L": " Manufacture of candies & chocolate",
"ADRESS": "ملك علي شكر ومنى حاموش\u001c - المعمورة\u001c - المريجة - بعبدا",
"TEL1": "03/386395",
"TEL2": "",
"TEL3": "",
"internet": "ahamadi@melodia-est-est.com"
},
{
"Category": "Second",
"Number": "6626",
"com-reg-no": "39003",
"NM": "الحكيم للمواد الانشائية ش م م",
"L_NM": "Hakim Construction Materials Co. sarl -Limited Liability",
"Last Subscription": "14-Mar-17",
"Industrial certificate no": "2911",
"Industrial certificate date": "26-Nov-17",
"ACTIVITY": "معمل لنشر الصخور وجلي البلاط",
"Activity-L": "Cutting of rocks & polishing of tiles",
"ADRESS": "بناية مونته ليبانو\u001c - شارع نيو جديدة\u001c - الجديدة - المتن",
"TEL1": "01/877343+4",
"TEL2": "01/898033",
"TEL3": "03/655203",
"internet": "joseph@hakimstone.com"
},
{
"Category": "Third",
"Number": "25525",
"com-reg-no": "35991",
"NM": "غرافتك ش م م",
"L_NM": "Graphtec sarl",
"Last Subscription": "25-Jul-17",
"Industrial certificate no": "4335",
"Industrial certificate date": "18-Jun-18",
"ACTIVITY": "مطبعة، خدمات التصميم واعمال التجليد",
"Activity-L": "Printing press, pre-printing & bookbinding",
"ADRESS": "بناية سابا وغابي ط 1\u001c - المنطقة الصناعية\u001c - عين سعاده - المتن",
"TEL1": "01/873074",
"TEL2": "01/873075",
"TEL3": "03/624646",
"internet": "rgraphtec@hotmail.com"
},
{
"Category": "First",
"Number": "496",
"com-reg-no": "18598",
"NM": "الشركة اللبنانية الايطالية لصنع الصابون ومساحيق الغسيل ش م ل",
"L_NM": "Société Libano - Italienne des Savons et Detergents",
"Last Subscription": "2-Feb-18",
"Industrial certificate no": "283",
"Industrial certificate date": "25-Jan-19",
"ACTIVITY": "صناعة المساحيق المنظفة للغسيل",
"Activity-L": "Manufacture of detergents & soaps",
"ADRESS": "بناية سليد\u001c - الاوتوستراد\u001c - زوق مصبح - كسروان",
"TEL1": "09/217749",
"TEL2": "09/217750",
"TEL3": "09/217751",
"internet": "edward.nehme@slisd.com"
},
{
"Category": "Excellent",
"Number": "973",
"com-reg-no": "21916",
"NM": "مؤسسة اليانور للمصاعد",
"L_NM": "Elianor Lifts Est",
"Last Subscription": "7-Mar-18",
"Industrial certificate no": "474",
"Industrial certificate date": "27-Feb-19",
"ACTIVITY": "صناعة كابينات وشاسيات وتابلوهات للمصاعد",
"Activity-L": "Manufacture of elevators\' parts",
"ADRESS": "بناية دمرجيان\u001c - طريق بياقوت\u001c - الزلقا - المتن",
"TEL1": "01/885826",
"TEL2": "01/902003",
"TEL3": "",
"internet": "elianor@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "1131",
"com-reg-no": "71785",
"NM": "شركة البان لبنان ش م ل",
"L_NM": "Liban Lait sal",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "2828",
"Industrial certificate date": "30-Mar-18",
"ACTIVITY": "صناعة البان واجبان وحليب وقشطة",
"Activity-L": "Manufacture of dairy products",
"ADRESS": "ملك اسامة العارف\u001c - شارع الزين\u001c - الطيونه - بيروت",
"TEL1": "05/959446+7",
"TEL2": "05/959444",
"TEL3": "03/959444",
"internet": "admin@libanlait.com"
},
{
"Category": "Third",
"Number": "24810",
"com-reg-no": "25842",
"NM": "شركة سيسيل ش م م",
"L_NM": "Secile sarl",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "181",
"Industrial certificate date": "12-Jan-19",
"ACTIVITY": "صناعة الالبسة النسائية والجينز",
"Activity-L": "Manufacture of ladies\' clothes and jeans",
"ADRESS": "ملك صونيا سرحان\u001c - كمب مرعش\u001c - برج حمود - المتن",
"TEL1": "01/252251",
"TEL2": "03/222145",
"TEL3": "",
"internet": "secile@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "1525",
"com-reg-no": "17759",
"NM": "الشركة العالمية لصناعة مستحضرات التجميل ش م ل",
"L_NM": "International Cosmetic Manufacturing Co. Incoma sal",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "2229",
"Industrial certificate date": "26-Jan-18",
"ACTIVITY": "صناعة الشامبو ومعاجين الحلاقة وروائح عطرية",
"Activity-L": "Manufacture of perfumes, shampoo & shaving cream",
"ADRESS": "ملك الصايغ\u001c - شارع ابراهيم سرسق\u001c - الاشرفية - بيروت",
"TEL1": "01/684204",
"TEL2": "01/684205",
"TEL3": "",
"internet": "rmaalouf@abouadal.com"
},
{
"Category": "Excellent",
"Number": "161",
"com-reg-no": "28788",
"NM": "شركة الكيماويات للبناء ش م ل",
"L_NM": "Building Chemicals Co. sal",
"Last Subscription": "26-Jan-17",
"Industrial certificate no": "16763877",
"Industrial certificate date": "25-Apr-18",
"ACTIVITY": "صناعة المواد الكيماوية العضوية ومواد منع النش",
"Activity-L": "Manufacture of organic basic chemicals & waterproofing materials",
"ADRESS": "بناية ميرنا البستاني\u001c - الشارع العام\u001c - اليرزه - بعبدا",
"TEL1": "05/920691",
"TEL2": "05/923986",
"TEL3": "",
"internet": "bcc@buildingchemicals.com"
},
{
"Category": "Excellent",
"Number": "177",
"com-reg-no": "15466",
"NM": "الشركة اللبنانية لتجارة الغاز - نيوغاز - ش م ل",
"L_NM": "Ste.Libanaise pour le Commerce du Gaz - New Gaz sal",
"Last Subscription": "22-Apr-17",
"Industrial certificate no": "2925",
"Industrial certificate date": "1-Dec-17",
"ACTIVITY": "تجارة قناني الغاز المنزلي",
"Activity-L": "Trading of bottle of gas",
"ADRESS": "بناية الضاني ط 4\u001c - شارع المعماري\u001c - الحمراء - بيروت",
"TEL1": "",
"TEL2": "",
"TEL3": "01/241111",
"internet": "ali.alhassan@unigaz.net"
},
{
"Category": "Fourth",
"Number": "15400",
"com-reg-no": "72238",
"NM": "مؤسسة قيامه - شركة تضامن",
"L_NM": "Etablissemnet Kiamé",
"Last Subscription": "8-Feb-18",
"Industrial certificate no": "2378",
"Industrial certificate date": "20-Sep-18",
"ACTIVITY": "صناعة الالبسة النسائية والولادية والبسة السبور",
"Activity-L": "Manufacture of ladies\' & children\'s clothes",
"ADRESS": "ملك الياس قيامه\u001c - شارع غورو\u001c - الصيفي - بيروت",
"TEL1": "01/561812",
"TEL2": "01/445066",
"TEL3": "03/300593",
"internet": ""
},
{
"Category": "Third",
"Number": "17236",
"com-reg-no": "42299",
"NM": "بلاستوني بانتس غروب",
"L_NM": "Plastoni Paints Group",
"Last Subscription": "13-Feb-18",
"Industrial certificate no": "465",
"Industrial certificate date": "26-Feb-19",
"ACTIVITY": "صناعة الدهانات",
"Activity-L": "Manufacture of paints",
"ADRESS": "ملك ورثة ميشال الفغالي\u001c - الشارع العام\u001c - بسوس - عاليه",
"TEL1": "05/940958",
"TEL2": "",
"TEL3": "",
"internet": "plastoni@cyberia.net.lb"
},
{
"Category": "Third",
"Number": "19438",
"com-reg-no": "70878",
"NM": "شركة الوغا ليبان ش م م",
"L_NM": "ELOGA Liban sarl",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "3693",
"Industrial certificate date": "27-Mar-18",
"ACTIVITY": "صناعة مجوهرات وقطع الساعات",
"Activity-L": "Manufacture of Jewellery & parts of watches",
"ADRESS": "ملك الامير سعد بن عبد العزيز ال سعود\u001c - الشارع العام\u001c - الحمراء - بيروت",
"TEL1": "01/797239",
"TEL2": "01/343636",
"TEL3": "03/644444",
"internet": "elgoliban@elgoswiss.com"
},
{
"Category": "First",
"Number": "5225",
"com-reg-no": "53456",
"NM": "مؤسسة سامي حموي غروب - غولد سميث",
"L_NM": "Sami Hamawi Groupe - Gold Smith",
"Last Subscription": "24-Jan-18",
"Industrial certificate no": "4154",
"Industrial certificate date": "16-May-18",
"ACTIVITY": "صناعة المجوهرات",
"Activity-L": "Manufacture of jewellery",
"ADRESS": "بناية غرين لاند\u001c - شارع  طرابلس\u001c - برج حمود - المتن",
"TEL1": "01/261328",
"TEL2": "01/260686",
"TEL3": "",
"internet": "shgroup@inco.com.lb"
},
{
"Category": "Excellent",
"Number": "27",
"com-reg-no": "3692",
"NM": "شركة الترابة الوطنية ش م ل",
"L_NM": "Cimenterie Nationale sal",
"Last Subscription": "10-Mar-18",
"Industrial certificate no": "3043",
"Industrial certificate date": "1-Feb-19",
"ACTIVITY": "معمل لانتاج الاسمنت (الترابة السوداء )",
"Activity-L": "Manufacture of cement",
"ADRESS": "ملك  شركة جاكو العقارية ش م ل\u001c - الشارع العام\u001c - اليرزة - بعبدا",
"TEL1": "05/921351",
"TEL2": "05/922320",
"TEL3": "05/468553",
"internet": "admin@cimnat.com.lb"
},
{
"Category": "Third",
"Number": "85",
"com-reg-no": "2002268",
"NM": "شركة م. خشادوريان واولاده - توصية بسيطة",
"L_NM": "M. Khatchadourian & Sons",
"Last Subscription": "20-Sep-17",
"Industrial certificate no": "4603",
"Industrial certificate date": "14-Sep-18",
"ACTIVITY": "معملا لصناعة كمر وبريم",
"Activity-L": "Manufacture of belt & lace",
"ADRESS": "ملك قوشيان وخجاطوريان\u001c - شارع ارمينيا -  الدورة\u001c - برج حمود - المتن",
"TEL1": "01/240709",
"TEL2": "01/260013",
"TEL3": "03/622643",
"internet": "ara622@hotmail.com"
},
{
"Category": "Fourth",
"Number": "31463",
"com-reg-no": "2047291",
"NM": "غانم للحبوب والتجارة العامة",
"L_NM": "Ghanem for Cereal & General Trade",
"Last Subscription": "21-Mar-18",
"Industrial certificate no": "3218",
"Industrial certificate date": "25-Jul-17",
"ACTIVITY": "تجارة الحبوب والعلف",
"Activity-L": "Trading of cereal & animal feed",
"ADRESS": "ملك مروان غانم\u001c - حي الشاوية - طريق بتلون\u001c - الورهانية - الشوف",
"TEL1": "05/432060",
"TEL2": "03/371234",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "19293",
"com-reg-no": "40928",
"NM": "شركة لارجيس",
"L_NM": "Largess Co",
"Last Subscription": "26-Jan-17",
"Industrial certificate no": "3296",
"Industrial certificate date": "4-Feb-18",
"ACTIVITY": "صناعة الالبسة النسائية",
"Activity-L": "Manufacture of ladies\' clothes",
"ADRESS": "ملك اصادوريان\u001c - شارع مار مارون\u001c - البوشرية - المتن",
"TEL1": "01/248777",
"TEL2": "01/248648",
"TEL3": "03/666779",
"internet": "info@largess-co.com"
},
{
"Category": "Fourth",
"Number": "28103",
"com-reg-no": "2036072",
"NM": "شركة المنتجات الطبيعية للتجميل ش م م",
"L_NM": "Natural Cosmetic SARL",
"Last Subscription": "3-Mar-18",
"Industrial certificate no": "4131",
"Industrial certificate date": "12-Jun-18",
"ACTIVITY": "صناعة وتجارة مزيل الشعر",
"Activity-L": "Manufacture & trading of hair removal",
"ADRESS": "ملك جوزف مطر\u001c - شارع المعامل\u001c - زوق مصبح - كسروان",
"TEL1": "79/134038",
"TEL2": "70/076149",
"TEL3": "",
"internet": "dikran.egho@gmail.com"
},
{
"Category": "Third",
"Number": "211",
"com-reg-no": "12400",
"NM": "توفيق طانيوس برباري واولاده - تضامن",
"L_NM": "Toufic Tanios Berberi & Sons",
"Last Subscription": "7-Mar-17",
"Industrial certificate no": "3376",
"Industrial certificate date": "15-Feb-18",
"ACTIVITY": "صناعة الدهانات",
"Activity-L": "Manufacture of paints",
"ADRESS": "ملك ربيز\u001c - نزلة المرفأ\u001c - المرفأ - بيروت",
"TEL1": "09/218271",
"TEL2": "09/218272",
"TEL3": "03/610032",
"internet": ""
},
{
"Category": "Second",
"Number": "6567",
"com-reg-no": "54385",
"NM": "برومتال ش م م",
"L_NM": "Prometal sarl",
"Last Subscription": "19-May-17",
"Industrial certificate no": "4085",
"Industrial certificate date": "7-Jun-18",
"ACTIVITY": "معملا للأشغال والانشاءات المعدنية",
"Activity-L": "Manufacture of metal works",
"ADRESS": "ملك سعد وشحود\u001c - شارع السمراني\u001c - بياقوت - المتن",
"TEL1": "03217720",
"TEL2": "01893753",
"TEL3": "",
"internet": "info@prometal-industries.com"
},
{
"Category": "Third",
"Number": "19143",
"com-reg-no": "56807",
"NM": "شركة مغني اخوان ش م م",
"L_NM": "Moughany Brother\'s Co. sarl",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "175",
"Industrial certificate date": "11-Jan-19",
"ACTIVITY": "صناعة الثريات النحاسية وتجارة المصنوعات الحرفية",
"Activity-L": "Manufacture of brass chandeliers & trading of artisanal articles",
"ADRESS": "ملك شركة مغني اخوان ش م م\u001c - الروضه - شارع مدرسة الرسل\u001c - البوشرية - المتن",
"TEL1": "01/683184",
"TEL2": "01/683185",
"TEL3": "03/613956",
"internet": ""
},
{
"Category": "Second",
"Number": "3468",
"com-reg-no": "53301",
"NM": "شركة أ. حكيم وشركاؤه  ش م ل",
"L_NM": "A. Hakim & Co sal",
"Last Subscription": "17-Feb-18",
"Industrial certificate no": "4067",
"Industrial certificate date": "2-Jun-18",
"ACTIVITY": "صياغة المجوهرات وتركيب الاحجار الكريمة",
"Activity-L": "Manufacture of jewelry and assorting of precious stones",
"ADRESS": "ملك انطوان حكيم\u001c - الدوره - شارع البنوك\u001c - البوشريه - المتن",
"TEL1": "01/240500",
"TEL2": "01/240501",
"TEL3": "01/240502",
"internet": "tony@antoinehakim.com"
},
{
"Category": "Fourth",
"Number": "31803",
"com-reg-no": "2041836",
"NM": "شركة:  ADIDA للصناعة والتجارة ش م م",
"L_NM": "ADIDA",
"Last Subscription": "18-Aug-17",
"Industrial certificate no": "3285",
"Industrial certificate date": "3-Feb-18",
"ACTIVITY": "طحن وتعبئة وتوضيب البهارات",
"Activity-L": "Grind, fill & pack spices",
"ADRESS": "بناية نصره\u001c - شارع فينيسيا\u001c - دوحة عرمون - عاليه",
"TEL1": "05/803209",
"TEL2": "71/188000",
"TEL3": "",
"internet": "info@adidaspices.com"
},
{
"Category": "Second",
"Number": "8045",
"com-reg-no": "2050190",
"NM": "باستيل للصناعة الكيميائية ش.م.ل.",
"L_NM": "Pastel Chemical Industry sal",
"Last Subscription": "9-Mar-18",
"Industrial certificate no": "262",
"Industrial certificate date": "8-Aug-18",
"ACTIVITY": " صناعة الدهانات",
"Activity-L": "Manufacture of Paints",
"ADRESS": "ملك حرفوش\u001c - المدينة  الصناعية\u001c - مزرعة يشوع- المتن",
"TEL1": "04/920200",
"TEL2": "04/915115",
"TEL3": "",
"internet": "www.pastelpaints.com"
},
{
"Category": "Excellent",
"Number": "1095",
"com-reg-no": "59908",
"NM": "شركة بتكو ش م ل",
"L_NM": "Petco sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "2847",
"Industrial certificate date": "11-Apr-18",
"ACTIVITY": "صناعة قناني بلاستيكية",
"Activity-L": "Manufacture of plastic bottles",
"ADRESS": "سنتر BPC Logistics\u001c - حي الاميركان\u001c - الحدث - بعبدا",
"TEL1": "01/680453",
"TEL2": "",
"TEL3": "",
"internet": "ydaher@petco.com.lb"
},
{
"Category": "Excellent",
"Number": "1322",
"com-reg-no": "69917",
"NM": "شركة كمبيوتك ش م م",
"L_NM": "Computek & Co. sarl",
"Last Subscription": "3-Apr-17",
"Industrial certificate no": "3696",
"Industrial certificate date": "27-Mar-18",
"ACTIVITY": "تجارة جملة الكومبيوتر والات مكتبية وتجميع اجهزة الكومبيوتر",
"Activity-L": "Wholesale of computer systems & office machinery gathering of comp. systems",
"ADRESS": "ملك دوري ورولان نصار\u001c - شارع الترك\u001c - مار ميخائيل - بيروت",
"TEL1": "01/442915",
"TEL2": "01/448558",
"TEL3": "03/302231",
"internet": "cmptk@cyberia.net.lb"
},
{
"Category": "First",
"Number": "5126",
"com-reg-no": "9197",
"NM": "شركة التوزيعات الكهربائية  ش م م",
"L_NM": "Electro Distribution sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "3979",
"Industrial certificate date": "16-May-18",
"ACTIVITY": "معملا لتصنيع وتجميع لوحات توزيع كهربائية",
"Activity-L": "Manufacture of electrical boards",
"ADRESS": "ملك امين ابو عرم\u001c - طريق صيدا القديمة\u001c - الشويفات - عاليه",
"TEL1": "05/431763",
"TEL2": "05/433325",
"TEL3": "03/814757",
"internet": "eds@eds-lb.com"
},
{
"Category": "Fourth",
"Number": "14670",
"com-reg-no": "15463",
"NM": "بمبو",
"L_NM": "Bimbo",
"Last Subscription": "27-Feb-18",
"Industrial certificate no": "4671",
"Industrial certificate date": "5-Oct-18",
"ACTIVITY": "تجارة الات لزوم المصوغات",
"Activity-L": "Trading of machines for jewellery",
"ADRESS": "ملك مختاريان واغا سركيسيان\u001c - شارع عساف خوري\u001c - برج حمود - المتن",
"TEL1": "01/263054",
"TEL2": "01/261515",
"TEL3": "03/346503",
"internet": "bimbotools@hotmail.com"
},
{
"Category": "Third",
"Number": "25268",
"com-reg-no": "35874",
"NM": "شركة فيبراكو ش م م",
"L_NM": "Phibraco sarl",
"Last Subscription": "24-Mar-18",
"Industrial certificate no": "4448",
"Industrial certificate date": "8-Aug-18",
"ACTIVITY": "صناعة الالبسة الرجالية والولادية",
"Activity-L": "Manufacture of men\'s & children\'s clothes",
"ADRESS": "ملك زرزور\u001c - شارع الجوهرجي\u001c - الزلقا - المتن",
"TEL1": "01/888832",
"TEL2": "03/220347",
"TEL3": "",
"internet": "info@phibraco.com"
},
{
"Category": "Third",
"Number": "19339",
"com-reg-no": "59934",
"NM": "الخدمات الكهربائية اللبنانية ش م م",
"L_NM": "Lebanese Electrical Services - LES - sarl",
"Last Subscription": "20-May-17",
"Industrial certificate no": "2872",
"Industrial certificate date": "18-Nov-17",
"ACTIVITY": "تنفيذ تعهدات الهندسة الكهربائية ومعمل لف وتجميع المحولات الكهربائية",
"Activity-L": "Electrical engineering contracting / Manufacture of electrical transformers",
"ADRESS": "ملك شفيق يحي\u001c - شارع حقل العناب\u001c - عرمون - عاليه",
"TEL1": "03/236297",
"TEL2": "",
"TEL3": "",
"internet": "scyehia@yahoo.com"
},
{
"Category": "Fourth",
"Number": "27779",
"com-reg-no": "2036466",
"NM": "سيدر هيلز",
"L_NM": "Cedar Hills",
"Last Subscription": "7-Apr-17",
"Industrial certificate no": "4250",
"Industrial certificate date": "6-Jul-18",
"ACTIVITY": "تبريد الخضار والفاكهة وصناعة الشرابات",
"Activity-L": "Freezing of vegatables & fruits, Manufacture of beverages",
"ADRESS": "بناية الحاج حسن ط ارضي\u001c - حي الشويفات - الشارع العام\u001c - العمروسية - عاليه",
"TEL1": "03/270557",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "5040",
"com-reg-no": "41741",
"NM": "شركة سيتي بلاست ش م م - ضاهر اخوان",
"L_NM": "Ste. City Plast sarl - Daher Frères",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "102",
"Industrial certificate date": "27-Dec-18",
"ACTIVITY": "صناعة اكياس نايلون",
"Activity-L": "Manufacture of nylon bags",
"ADRESS": "بناية نصرالدين فخرالدين\u001c - شارع الرويس\u001c - حارة حريك - بعبدا",
"TEL1": "01/541218+9",
"TEL2": "03/360058",
"TEL3": "03/653242",
"internet": "info@cityplast.net"
},
{
"Category": "Second",
"Number": "6417",
"com-reg-no": "69646",
"NM": "شركة مشموشي غروب ش م م",
"L_NM": "M.J.M Mashmouchi Group Co. Ltd",
"Last Subscription": "21-Feb-18",
"Industrial certificate no": "3986",
"Industrial certificate date": "17-May-18",
"ACTIVITY": "صناعة الالبسة الرجالية والولادية",
"Activity-L": "Manufacture of men\'s & children\'s wear",
"ADRESS": "بناية الرنا\u001c - شارع الاستقلال\u001c - كركول الدروز- بيروت",
"TEL1": "01/375770",
"TEL2": "01/375771",
"TEL3": "03/241413",
"internet": "mjmgroup@hotmail.com"
},
{
"Category": "Excellent",
"Number": "1919",
"com-reg-no": "70165",
"NM": "شركة Royal Gourmet ش م ل",
"L_NM": "Royal Gourmet sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "2180",
"Industrial certificate date": "30-Jan-18",
"ACTIVITY": "توضيب وتبريد الاسماك واللحوم",
"Activity-L": "Packing & refregerating of fish & meat",
"ADRESS": "بناية سلهب ط1\u001c - شارع شوران\u001c - الروشة - بيروت",
"TEL1": "05/441204",
"TEL2": "",
"TEL3": "",
"internet": "info@rgourmet.com"
},
{
"Category": "First",
"Number": "2872",
"com-reg-no": "55801",
"NM": "مؤسسة جرجي عازار واولاده - تضامن",
"L_NM": "Ets. Georges Azar et Fils",
"Last Subscription": "27-Jan-17",
"Industrial certificate no": "2048",
"Industrial certificate date": "13-Jun-17",
"ACTIVITY": "معملا لصب احجار الباطون ونشر الصخور والرخام",
"Activity-L": "Casting of concrete stones & Cutting of marbles & rocks",
"ADRESS": "ملك ابناء جرجي عازار\u001c - المدينة الصناعية\u001c - خرائب نهر ابراهيم - كسروان",
"TEL1": "09/444484",
"TEL2": "09/448999",
"TEL3": "03/244044",
"internet": "g.a.f@dm.net.lb"
},
{
"Category": "Second",
"Number": "146",
"com-reg-no": "58766",
"NM": "شركة بشاره بارودي ش م م",
"L_NM": "Société Bechara Baroody sarl",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "164",
"Industrial certificate date": "10-Jan-19",
"ACTIVITY": "صناعة الكريمات (ايديال) ولوسيون لتنظيف الوجه",
"Activity-L": "Manufacture of facial cream & lotion",
"ADRESS": "بناية الندى\u001c - شارع غراهام\u001c - عين المريسه - بيروت",
"TEL1": "01/487569",
"TEL2": "01/487593",
"TEL3": "01/366127",
"internet": "sbbsbb@inco.com.lb"
},
{
"Category": "Third",
"Number": "29087",
"com-reg-no": "60583",
"NM": "مؤسسة ساره التجارية",
"L_NM": "Sarah Trading Est",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "039",
"Industrial certificate date": "15-Dec-18",
"ACTIVITY": "صناعة وتعبئة كريم للتجميل ومزيل الشعر وماء كولونيا",
"Activity-L": "Manufacture of beauty cream, depilatory & perfumes",
"ADRESS": "ملك احمد قيس\u001c - شارع مارون مسك\u001c - الشياح - بعبدا",
"TEL1": "03/412864",
"TEL2": "01/277343",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "894",
"com-reg-no": "40498",
"NM": "سهاكو",
"L_NM": "Sahako",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "4925",
"Industrial certificate date": "23-Nov-18",
"ACTIVITY": "صناعة وتجارة المفروشات",
"Activity-L": "Manufacture & Trading of furniture",
"ADRESS": "بناية كلاسي \u001c - المدينة الصناعية\u001c - زوق مصبح - كسروان",
"TEL1": "09/217835",
"TEL2": "09/217836",
"TEL3": "03/309276",
"internet": "sahacosh@inco.com.lb"
},
{
"Category": "First",
"Number": "3788",
"com-reg-no": "57007",
"NM": "حاج كونسبت - جوزف الحاج واولاده ش م ل",
"L_NM": "Hajj Concept - Joseph Hajj & Sons sal",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "2252",
"Industrial certificate date": "3-Aug-17",
"ACTIVITY": " صناعة وتجارة المفروشات المنزلية",
"Activity-L": "Manufacture & trading of furniture",
"ADRESS": "ملك جوزف مخايل الحاج\u001c - الشارع العام\u001c - المكلس - المتن",
"TEL1": "01/689444",
"TEL2": "01/687444",
"TEL3": "01/682100",
"internet": "info@hajjconcept.com"
},
{
"Category": "First",
"Number": "4468",
"com-reg-no": "32908",
"NM": "مطابع المستقبل ش م م",
"L_NM": "Al Moustakbal Press",
"Last Subscription": "9-Jan-17",
"Industrial certificate no": "2561",
"Industrial certificate date": "15-Sep-17",
"ACTIVITY": "اعمال الطباعة وتجليد الكتب والمطبوعات",
"Activity-L": "Printing & bookbinding",
"ADRESS": "بناية المستقبل\u001c - طريق المطار\u001c - الشياح - بعبدا",
"TEL1": "01/850870+1",
"TEL2": "01/870850",
"TEL3": "03/284113",
"internet": "info@almostakbalpress.com"
},
{
"Category": "First",
"Number": "3801",
"com-reg-no": "68230",
"NM": "بي اس لاب ش م ل",
"L_NM": "Pslab sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4460",
"Industrial certificate date": "9-Aug-18",
"ACTIVITY": "معملاً للأسقف المستعارة ( فوبلافون ) وأجهزة الإنارة وطلائها",
"Activity-L": "Manufacture of metallic false ceiling & lighting systems",
"ADRESS": "ملك اي اند اتش بروبرتيز ش م ل\u001c - شارع مار مخايل\u001c - المدور - بيروت",
"TEL1": "01/442546",
"TEL2": "01/448672",
"TEL3": "",
"internet": "mailbox@projectsandsupplies.com"
},
{
"Category": "Third",
"Number": "18980",
"com-reg-no": "59512",
"NM": "شركة مخابز ديلايت ش م م",
"L_NM": "Delight Bakery sarl",
"Last Subscription": "30-Jan-17",
"Industrial certificate no": "2207",
"Industrial certificate date": "24-Jan-18",
"ACTIVITY": "صناعة الخبز والمعجنات",
"Activity-L": "Manufacture of bread & pastry",
"ADRESS": "بناية الشامي\u001c - شارع الخرطوم\u001c - طريق الجديدة - بيروت",
"TEL1": "01/840162",
"TEL2": "01/854781",
"TEL3": "",
"internet": "abbasghada2011@hotmail.com"
},
{
"Category": "Third",
"Number": "6457",
"com-reg-no": "18240",
"NM": "البحصلي - شركة توصية بسيطة",
"L_NM": "Bohsali",
"Last Subscription": "11-Feb-17",
"Industrial certificate no": "320",
"Industrial certificate date": "1-May-17",
"ACTIVITY": "صناعة الحلويات العربية والافرنجية",
"Activity-L": "Manufacture of oriental & western sweets",
"ADRESS": "بناية العسيلي\u001c - شارع رياض الصلح\u001c - النجمة - بيروت",
"TEL1": "03/898298",
"TEL2": "01/980211",
"TEL3": "",
"internet": "amer@albohsali.com"
},
{
"Category": "Excellent",
"Number": "373",
"com-reg-no": "376",
"NM": "بوليتكستيل - معامل نقولا ابي نصر - ماري فرانس انترناسيونال",
"L_NM": "Polytextile (Marie - France International )",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4886",
"Industrial certificate date": "16-Nov-18",
"ACTIVITY": "خياطة التريكو والالبسة القطنية واللآنجري حياكة الكلسات والكولونات",
"Activity-L": "Manufacture of underwear, tricot, socks,hose & lingerie",
"ADRESS": "ملك نقولا ابي نصر\u001c - الشارع العام\u001c - برج حمود - المتن",
"TEL1": "09/926135",
"TEL2": "09/926019",
"TEL3": "",
"internet": "info@polytextile.net"
},
{
"Category": "First",
"Number": "3798",
"com-reg-no": "52224",
"NM": "بارالو بيفم ش م م",
"L_NM": "Paralu Bifem sarl",
"Last Subscription": "20-Oct-17",
"Industrial certificate no": "4784",
"Industrial certificate date": "24-Oct-18",
"ACTIVITY": "صناعة منجورات الالمنيوم",
"Activity-L": "Manufacture of whittled aluminum",
"ADRESS": "ملك بشاره فرحات\u001c - المدينة الصناعية - شارع رقم 10\u001c - المكلس - المتن",
"TEL1": "01/683721+23",
"TEL2": "01/683409",
"TEL3": "01/683410",
"internet": "bfparalu@inco.com.lb"
},
{
"Category": "Second",
"Number": "6309",
"com-reg-no": "39628",
"NM": "شركة جيمكو للتجارة العامة والصناعة العامة - شركة توصية بسيطة",
"L_NM": "Gimco General Trade and General Industry",
"Last Subscription": "7-Mar-17",
"Industrial certificate no": "2612",
"Industrial certificate date": "27-Sep-17",
"ACTIVITY": "صناعة عجينة مزيل للشعر",
"Activity-L": "Manufacture of depilatory",
"ADRESS": "ملك معلوف\u001c - المنطقة الصناعية - الشارع العام\u001c - بعبدات - المتن",
"TEL1": "04/825005",
"TEL2": "03/245514",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "19045",
"com-reg-no": "57924",
"NM": "شركة بليكسي لاين ش م م",
"L_NM": "Plexi Line sarl",
"Last Subscription": "10-May-17",
"Industrial certificate no": "3841",
"Industrial certificate date": "19-Apr-18",
"ACTIVITY": "صناعة البلكسي غلاس",
"Activity-L": "Manufacture of plexi glass",
"ADRESS": "ملك سعد\u001c - المدينة الصناعية\u001c - حالات - جبيل",
"TEL1": "03/251652",
"TEL2": "03/590150",
"TEL3": "09/446171",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1073",
"com-reg-no": "56721",
"NM": "سوبر برازيل كومباني ش م ل",
"L_NM": "Super Brasil Company sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "162",
"Industrial certificate date": "10-Jan-19",
"ACTIVITY": "صناعة البن وتجارة ماكينات للقهوة",
"Activity-L": "Coffee processing & trading of coffee machines",
"ADRESS": "ملك الشركة\u001c - طريق بيت مري\u001c - المكلس - المتن",
"TEL1": "01/680680",
"TEL2": "01/685080",
"TEL3": "",
"internet": "info@cafesuperbrasil.com"
},
{
"Category": "Excellent",
"Number": "1674",
"com-reg-no": "57616",
"NM": "شركة ج. فنشنتي واولاده ش م ل",
"L_NM": "G. Vincenti and Sons sal",
"Last Subscription": "6-Feb-18",
"Industrial certificate no": "1322",
"Industrial certificate date": "22-Sep-18",
"ACTIVITY": "تجارة جملة مواد غذائية معلبة ومشروبات روحية وتعبئة وتوضيب الاجبان واللحوم",
"Activity-L": "Filling & packing of food - Wholesale of canned food & alcoholic drinks",
"ADRESS": "بناية فنشنتي\u001c - بولفار انطوان شختوره\u001c - الدكوانة - المتن",
"TEL1": "01/485380+1",
"TEL2": "01/485382+3",
"TEL3": "01/485384+5",
"internet": "vincenti@dm.net.lb"
},
{
"Category": "Second",
"Number": "1616",
"com-reg-no": "14795",
"NM": "مؤسسة ريمون نصور",
"L_NM": "Raymond Nassour Est.",
"Last Subscription": "5-May-17",
"Industrial certificate no": "3895",
"Industrial certificate date": "27-Mar-18",
"ACTIVITY": "صناعة وتجارة المفروشات",
"Activity-L": "Manufacture & trading of furniture",
"ADRESS": "ملك اميرة الغزال\u001c - الشارع الرئيسي\u001c - المكلس - المتن",
"TEL1": "01/683130",
"TEL2": "03/266427",
"TEL3": "",
"internet": "boisdereve@hotmail.com"
},
{
"Category": "Third",
"Number": "19024",
"com-reg-no": "54828",
"NM": "شركة كوزميتكس غروب ش م م",
"L_NM": "Cosmetics Group sarl",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "3866",
"Industrial certificate date": "24-Apr-18",
"ACTIVITY": "صناعة مواد ومستحضرات الزينه والتجميل",
"Activity-L": "Manufacture of cosmetic products",
"ADRESS": "ملك انطوان والياس المقوم\u001c - عين اللبني\u001c - درعون - كسروان",
"TEL1": "09/260501",
"TEL2": "",
"TEL3": "",
"internet": "cosmetic@terra.net.lb"
},
{
"Category": "Third",
"Number": "19027",
"com-reg-no": "60065",
"NM": "شركة كامل للدباغة ش م م",
"L_NM": "Kamel Tanning sarl",
"Last Subscription": "16-Feb-18",
"Industrial certificate no": "4610",
"Industrial certificate date": "5-Sep-18",
"ACTIVITY": "معملا لدباغة الجلود وانتاج لبادات الفرو",
"Activity-L": "Tanning of leather",
"ADRESS": "ملك منير كامل\u001c - الدورة - شارع الشل\u001c - برج حمود - المتن",
"TEL1": "01/241398",
"TEL2": "01/241394",
"TEL3": "03/703901",
"internet": "kameltan@cyberia.net.lb"
},
{
"Category": "Second",
"Number": "6129",
"com-reg-no": "60593",
"NM": "هبركو ش م م",
"L_NM": "Habreco sarl",
"Last Subscription": "11-May-17",
"Industrial certificate no": "2543",
"Industrial certificate date": "10-Jun-12",
"ACTIVITY": "تجارة جملة اللحوم المبردة",
"Activity-L": "Wholesale of frozen meat",
"ADRESS": "بناية انطوان فرح\u001c - الشارع الداخلي\u001c - صربا - كسروان",
"TEL1": "09/835089",
"TEL2": "09/639576",
"TEL3": "03/308320",
"internet": "info@elhabre.com"
},
{
"Category": "Third",
"Number": "19322",
"com-reg-no": "60827",
"NM": "ملحم رسلان واولاده ش م م - Marbex sarl",
"L_NM": "Marbex sarl",
"Last Subscription": "2-Mar-17",
"Industrial certificate no": "3305",
"Industrial certificate date": "6-Feb-18",
"ACTIVITY": "معملا لنشر الصخور والرخام",
"Activity-L": "Sawing of rocks & marbles",
"ADRESS": "ملك ملحم رسلان\u001c - القبة - الشارع العام\u001c - الشويفات - عاليه",
"TEL1": "05/433164",
"TEL2": "03/310319",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1106",
"com-reg-no": "56503",
"NM": "هوا تشيكن - شركة انتاج وتوزيع الفروج ش م ل",
"L_NM": "Hawa Chicken - Broiler Produce and Distributive Co. sal",
"Last Subscription": "12-Aug-17",
"Industrial certificate no": "4440",
"Industrial certificate date": "7-Aug-18",
"ACTIVITY": "انتاج لحوم الطيور وتجارة جملة مواد غذائية ودواجن",
"Activity-L": "Production of poultry & wholesale of foodstuffs and poultry",
"ADRESS": "ملك الشركة\u001c - الشارع العام\u001c - الصفرا - كسروان",
"TEL1": "09/851257",
"TEL2": "09/851258",
"TEL3": "09/851259",
"internet": "hawachicken@inco.com.lb"
},
{
"Category": "Fourth",
"Number": "28246",
"com-reg-no": "2029573",
"NM": "فوجي ليفت ش م ل",
"L_NM": "Fujilift sal",
"Last Subscription": "24-Feb-17",
"Industrial certificate no": "2784",
"Industrial certificate date": "3-Dec-17",
"ACTIVITY": "تجارة المصاعد الكهربائية",
"Activity-L": "Trading of electrical elevators",
"ADRESS": "ملك مارون\u001c - شارع OTV\u001c - الدكوانة - المتن",
"TEL1": "05/951676",
"TEL2": "05/951677",
"TEL3": "70/120218",
"internet": "support@fujilift.com"
},
{
"Category": "Third",
"Number": "25129",
"com-reg-no": "43811",
"NM": "مؤسسة شربل كرم للمفروشات والموبيليا",
"L_NM": "Est. Charbel Karam For Furniture",
"Last Subscription": "20-Feb-18",
"Industrial certificate no": "322",
"Industrial certificate date": "2-Feb-19",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك شربل كرم\u001c - الشارع العام\u001c - الصفرا - كسروان",
"TEL1": "09/852325",
"TEL2": "03/301914",
"TEL3": "03/741807",
"internet": ""
},
{
"Category": "Second",
"Number": "6183",
"com-reg-no": "18535",
"NM": "مؤسسة ناهي حداد للمفروشات",
"L_NM": "Boisselier Nahi Haddad",
"Last Subscription": "19-Aug-17",
"Industrial certificate no": "1573",
"Industrial certificate date": "13-Dec-17",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك ناهي حداد\u001c - شارع الزعيترية\u001c - الفنار - المتن",
"TEL1": "03/251983",
"TEL2": "03/660505",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1777",
"com-reg-no": "432",
"NM": "الشركة اللبنانية المتحدة لصناعة البلاستيك ش م ل",
"L_NM": "The United Lebanese Plastic Industries sal",
"Last Subscription": "31-May-17",
"Industrial certificate no": "4044",
"Industrial certificate date": "30-May-18",
"ACTIVITY": "صناعة قساطل البلاستيك",
"Activity-L": "Manufacture of plastic tubes",
"ADRESS": "بناية سماحة \u001c - الشارع العام\u001c - روميه - المتن",
"TEL1": "01/877857+9",
"TEL2": "",
"TEL3": "",
"internet": "ulpi@dm.net.lb"
},
{
"Category": "Fourth",
"Number": "13833",
"com-reg-no": "21420",
"NM": "شركة مكرزل الصناعية - شركة تضامن",
"L_NM": "Ste. Moukarzel P/L\'industrie",
"Last Subscription": "23-Aug-17",
"Industrial certificate no": "4445",
"Industrial certificate date": "7-Aug-18",
"ACTIVITY": "صناعة الملبوسات النسائية الداخلية",
"Activity-L": "Manufacture of ladies\' underwears",
"ADRESS": "ملك ايفون غصوب مكرزل\u001c - الشارع العام\u001c - الفريكة - المتن",
"TEL1": "04/922281",
"TEL2": "03/312929",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "4729",
"com-reg-no": "47695",
"NM": "غولد سيركل غروب ش م ل",
"L_NM": "Gold Circle Group sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4908",
"Industrial certificate date": "21-Dec-18",
"ACTIVITY": "معمل لحياكة الكلسات",
"Activity-L": " Manufacture of socks",
"ADRESS": "بناية انطوان حاج\u001c - الشارع العام\u001c - المكلس - المتن",
"TEL1": "01/686635",
"TEL2": "03/308805",
"TEL3": "",
"internet": "gcg@cyberia.net.lb"
},
{
"Category": "Fourth",
"Number": "29038",
"com-reg-no": "2026308",
"NM": "الوفاء بايكري - توصية بسيطة",
"L_NM": "AL Wafaa Bakery",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4076",
"Industrial certificate date": "5-Jun-18",
"ACTIVITY": "فرن",
"Activity-L": "Bakery",
"ADRESS": "بناية شعلان\u001c - الطيونة - الشارع العام - قرب بيروت مول\u001c - الشياح - بعبدا",
"TEL1": "01/383675",
"TEL2": "03/152015",
"TEL3": "03/216193",
"internet": "alwafaa.bakery@hotmail.com"
},
{
"Category": "Fourth",
"Number": "29040",
"com-reg-no": "2039401",
"NM": "لونار غروب ش م م",
"L_NM": "Lunar Group sarl",
"Last Subscription": "21-Feb-18",
"Industrial certificate no": "218",
"Industrial certificate date": "17-Jan-19",
"ACTIVITY": "صناعة مستحضرات التجميل",
"Activity-L": "Manufacture of cosmetic products",
"ADRESS": "بناية سلمان سلمان\u001c - القبه - شارع العرب\u001c - عرمون - عاليه",
"TEL1": "71/111261",
"TEL2": "",
"TEL3": "",
"internet": "info@lunarcosmetics.com"
},
{
"Category": "Excellent",
"Number": "1067",
"com-reg-no": "22358/1754",
"NM": "دمكو ستيل انداستريز ش م ل - داميرجيان اخوان",
"L_NM": "Demco Steel Industries sal -Demirdjian Bros",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "086",
"Industrial certificate date": "22-Dec-18",
"ACTIVITY": "صناعة سحب وجدل ولف وتقطيع الحديد وتصنيع وتطعيج الصفائح",
"Activity-L": "Drawing, cutting of iron & manufacture of sheets",
"ADRESS": "ملك داميرجيان\u001c - المدينة الصناعية\u001c - برج حمود - المتن",
"TEL1": "01/246000+5",
"TEL2": "01/247000+5",
"TEL3": "",
"internet": "demcosteel@demcosteel.com"
},
{
"Category": "Third",
"Number": "18924",
"com-reg-no": "18575",
"NM": "بي . ام . جي - شركة توصية بسيطة",
"L_NM": "B.M.J. Co.",
"Last Subscription": "9-May-17",
"Industrial certificate no": "3171",
"Industrial certificate date": "19-Jan-18",
"ACTIVITY": "صناعة اللانجري",
"Activity-L": "Manufacture of lingerie",
"ADRESS": "ملك عقاد وصفير\u001c - حي السريان\u001c - البوشرية - المتن",
"TEL1": "01/685392",
"TEL2": "03/633013",
"TEL3": "",
"internet": "bmj-co@idm.net.lb"
},
{
"Category": "Third",
"Number": "24368",
"com-reg-no": "39909",
"NM": "فاكيوم باغز ش م م",
"L_NM": "Vacuum Bags sarl",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "230",
"Industrial certificate date": "18-Jan-19",
"ACTIVITY": "صناعة اكياس الفاكيوم",
"Activity-L": "Manufacture of vacuum bags",
"ADRESS": "ملك محمد ومصطفى شري\u001c - شارع شركة الكهرباء\u001c - سد البوشرية - المتن",
"TEL1": "01/878578",
"TEL2": "01/878579+80",
"TEL3": "03/628918",
"internet": "info@vacuumbags.com.lb"
},
{
"Category": "Second",
"Number": "6107",
"com-reg-no": "56609",
"NM": "شركة ديا سبورا ليمتد ش م م",
"L_NM": "Diaspora Ltd. Sarl",
"Last Subscription": "7-Apr-17",
"Industrial certificate no": "1753",
"Industrial certificate date": "21-Apr-17",
"ACTIVITY": "صناعة منجورات الالمنيوم والواجهات",
"Activity-L": "Manufacture of aluminium panelling & fronts",
"ADRESS": "ملك عساف ابراهيم قازان\u001c - الزعيترية - الشارع العام\u001c - الفنار - المتن",
"TEL1": "01/691939",
"TEL2": "01/690939",
"TEL3": "03/619217",
"internet": "diaspora@diaspora.com.lb"
},
{
"Category": "Fourth",
"Number": "5913",
"com-reg-no": "39439",
"NM": "مؤسسة محمد كلوت للتجليد والطباعة",
"L_NM": "Mohamad Kalot Est for Binding & Printing",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "3069",
"Industrial certificate date": "4-Jan-18",
"ACTIVITY": "اعمال تجليد الكتب",
"Activity-L": "Bookbinding services",
"ADRESS": "ملك محمد كلوت\u001c - شارع الرواس\u001c - الملعب البلدي - بيروت",
"TEL1": "01/651618",
"TEL2": "01/473518",
"TEL3": "03/737519",
"internet": ""
},
{
"Category": "Fourth",
"Number": "14155",
"com-reg-no": "37835",
"NM": "سامو بلت",
"L_NM": "Samo Belt",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4456",
"Industrial certificate date": "9-Aug-18",
"ACTIVITY": "صناعة الاحزمة الجلدية",
"Activity-L": "Manufacture of leather belts",
"ADRESS": "ملك بسام فرشوخ\u001c - الاوتوستراد العريض\u001c - حارة حريك - بعبدا",
"TEL1": "05/466020",
"TEL2": "03/216014",
"TEL3": "03/465842",
"internet": "info@samobelt.com"
},
{
"Category": "Fourth",
"Number": "28264",
"com-reg-no": "1012108",
"NM": "خوام غروب للطباعة ش م م",
"L_NM": "Khawam group for printing sarl",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "3993",
"Industrial certificate date": "18-May-18",
"ACTIVITY": "مطبعة تجارية",
"Activity-L": "Printing Press",
"ADRESS": "ملك طوني خوام\u001c - شارع صلاح لبكي\u001c - الرميل - بيروت",
"TEL1": "01/444173",
"TEL2": "03/611712",
"TEL3": "",
"internet": "toni@imprimeriekhawam.com"
},
{
"Category": "Fourth",
"Number": "29033",
"com-reg-no": "1016195",
"NM": "سيس برو ش م ل",
"L_NM": "Sys Pro sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "139",
"Industrial certificate date": "8-Apr-18",
"ACTIVITY": "تجارة اجهزة انارة ومفروشات مكتبية",
"Activity-L": "Trading of lighting systems & offce furniture",
"ADRESS": "بناية النهر\u001c - شارع النهر\u001c - الاشرفية - بيروت",
"TEL1": "01/582000",
"TEL2": "",
"TEL3": "",
"internet": "j.korban@syspro-me.com"
},
{
"Category": "Excellent",
"Number": "892",
"com-reg-no": "31157",
"NM": "يونايتد انفستمنت اند ترايدنغ كومباني - يونيفست ش م ل",
"L_NM": "United Investment and Trading Company - Univest sal",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "3488",
"Industrial certificate date": "27-Feb-18",
"ACTIVITY": "تقطيع وتوضيب الورق الصحي وتصنيع وتعبئة المنظفات",
"Activity-L": "Manufacture of toilet paper & detergents",
"ADRESS": "ملك ضاهر اخوان ط2\u001c - شارع مار روكز\u001c - الدكوانة - المتن",
"TEL1": "01/684839",
"TEL2": "01/684840",
"TEL3": "01/684841",
"internet": "moniquedaher@univestag.com"
},
{
"Category": "Third",
"Number": "21834",
"com-reg-no": "42989",
"NM": "ميمونه ش م م",
"L_NM": "Mymoune sarl",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4855",
"Industrial certificate date": "10-Nov-18",
"ACTIVITY": "صناعة مكابيس ومخللات ومربيات وشراب وتعبئة وتوضيب الحبوب ومنتوجات بلدية",
"Activity-L": "Manufacture of pickles, jams, beverages,packing of cereals& agro products",
"ADRESS": "ملك الغصين\u001c - الشارع العام\u001c - عين القبو - المتن",
"TEL1": "04/542542",
"TEL2": "04/280101",
"TEL3": "03/429897",
"internet": "info@mymoune.com"
},
{
"Category": "Excellent",
"Number": "194",
"com-reg-no": "9783",
"NM": "الشركة الدولية المتحدة - يونالكو ش م م",
"L_NM": "United International Company Unalco sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "3960",
"Industrial certificate date": "12-May-18",
"ACTIVITY": "صناعة الدهانات",
"Activity-L": "Manufacture of paints",
"ADRESS": "بناية الحسيني ط 10 ملك نزيه الكرد\u001c - شارع انيس النصولي\u001c - فردان - بيروت",
"TEL1": "05/804238",
"TEL2": "03/306990",
"TEL3": "05/804240",
"internet": "unalcolb@gmail,com"
},
{
"Category": "Excellent",
"Number": "1304",
"com-reg-no": "54272",
"NM": "شركة ابناء انور فرا ش م ل",
"L_NM": "Fils Anwar Farra sal",
"Last Subscription": "11-May-17",
"Industrial certificate no": "2500",
"Industrial certificate date": "30-Aug-17",
"ACTIVITY": "صناعة المفروشات المكتبية والمنزلية",
"Activity-L": "Manufacture of office & home furniture",
"ADRESS": "ملك شركة فرا العقارية ش م ل\u001c - الشارع العام\u001c - المكلس - المتن",
"TEL1": "01/687000",
"TEL2": "03/306734",
"TEL3": "03/408044",
"internet": "info@farra.com"
},
{
"Category": "Third",
"Number": "13908",
"com-reg-no": "58357",
"NM": "شركة عز الدين للأقمشة ش م م",
"L_NM": "Ezzeddine Textile Co. sarl",
"Last Subscription": "24-Jan-18",
"Industrial certificate no": "4232",
"Industrial certificate date": "3-Jul-18",
"ACTIVITY": "خياطة البرادي وتنجيد المفروشات",
"Activity-L": "Sewing of curtains & upholstery of furnitures",
"ADRESS": "ملك عز الدين\u001c - شارع مار الياس\u001c - المصيطبة - بيروت",
"TEL1": "01/858440",
"TEL2": "01/858499",
"TEL3": "03/288519",
"internet": "tezzeddine@yahoo.com"
},
{
"Category": "Fourth",
"Number": "25234",
"com-reg-no": "2029472",
"NM": "شركة رار رزين ش م م",
"L_NM": "Rar Resin sarl",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "3335",
"Industrial certificate date": "8-Feb-18",
"ACTIVITY": "تجارة جملة مذيبات عضوية ودهانات",
"Activity-L": "Wholesale of organic solvents &  paints",
"ADRESS": "ملك رعيدي\u001c - شارع البترون\u001c - حصرايل- جبيل",
"TEL1": "03/706606",
"TEL2": "03/898911",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "29020",
"com-reg-no": "2028731",
"NM": "انيس امين مطر",
"L_NM": "Anis Amine Mattar",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "215",
"Industrial certificate date": "17-Jan-19",
"ACTIVITY": "تجارة المجوهرات والمصوغات الذهبية",
"Activity-L": "Trading of golden jewelry",
"ADRESS": "بناية جوخوزيان\u001c - شارع ارمينيا\u001c - برج حمود - المتن",
"TEL1": "03/180164",
"TEL2": "",
"TEL3": "",
"internet": "mataranis@hotmail.com"
},
{
"Category": "Third",
"Number": "32240",
"com-reg-no": "2039603",
"NM": "مطابع الهبر ش م م",
"L_NM": "Haber Printing sarl",
"Last Subscription": "19-Aug-17",
"Industrial certificate no": "2187",
"Industrial certificate date": "1-Jul-17",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "ملك الهبر\u001c - شارع اوتار\u001c - زوق مكايل - كسروان",
"TEL1": "09/222935",
"TEL2": "09/211935",
"TEL3": "03/765961",
"internet": ""
},
{
"Category": "Excellent",
"Number": "468",
"com-reg-no": "12063",
"NM": "شركة جورج متى للصناعة والتجارة ش م ل",
"L_NM": "Société Georges Matta pour L\'Industrie et le Commerce sal",
"Last Subscription": "1-Dec-17",
"Industrial certificate no": "4940",
"Industrial certificate date": "27-Nov-18",
"ACTIVITY": "صناعة المفروشات الخشبية والمعدنية والخيزران",
"Activity-L": "Manufacture of wooden, metallic & bamboo furniture",
"ADRESS": "ملك شركة متى العقارية\u001c - تل الزعتر\u001c - الدكوانة - المتن",
"TEL1": "09/235014",
"TEL2": "09/235015",
"TEL3": "01/500850",
"internet": "info@sgmatta.com"
},
{
"Category": "First",
"Number": "3392",
"com-reg-no": "62144",
"NM": "دار الفكر للطباعة والنشر والتوزيع ش م ل",
"L_NM": "Dar El Fikr sal Printers,Publishers & Distributors",
"Last Subscription": "24-Jan-17",
"Industrial certificate no": "1749",
"Industrial certificate date": "20-Sep-17",
"ACTIVITY": "اعمال الطباعة والتجليد",
"Activity-L": "Printing & binding services",
"ADRESS": "ملك ال سعود\u001c - شارع الام جيلاس\u001c - الباشورة - بيروت",
"TEL1": "01/559900+1",
"TEL2": "01/559902+3",
"TEL3": "01/860361",
"internet": "darlfikr@cyberia.net.lb"
},
{
"Category": "Second",
"Number": "6587",
"com-reg-no": "48544",
"NM": "شماتك - شمالي تكنيك",
"L_NM": "Chematec - Chemaly Technique",
"Last Subscription": "5-Jan-17",
"Industrial certificate no": "3050",
"Industrial certificate date": "29-May-17",
"ACTIVITY": "صناعة وتجميع الات صناعية مختلفة",
"Activity-L": "Manufacture of industrial machinery",
"ADRESS": "ملك بيار شمالي\u001c - مونتي فردي - شارع 11a لوزولا\u001c - بيت مري - المتن",
"TEL1": "04/530318",
"TEL2": "03/650390",
"TEL3": "",
"internet": "chematec@lyberia.net.lb"
},
{
"Category": "Fourth",
"Number": "29048",
"com-reg-no": "1018026",
"NM": "شركة مرقبي للتجارة ش م م",
"L_NM": "Markabi Company sarl",
"Last Subscription": "2-Mar-18",
"Industrial certificate no": "4810",
"Industrial certificate date": "21-Oct-18",
"ACTIVITY": "صناعة وتجارة جملة الشوكولا",
"Activity-L": "Manufacture & Wholesale of chocolate",
"ADRESS": "بناية سلوم\u001c - شارع المطران شبلي\u001c - ميناء الحصن - بيروت",
"TEL1": "01/361445",
"TEL2": "71/911821",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "4144",
"com-reg-no": "56722",
"NM": "بايكوب ش م ل",
"L_NM": "Bycop sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4111",
"Industrial certificate date": "9-Jun-18",
"ACTIVITY": "صناعة البياضات المنزلية (Cannon) وتجارة جملة الالبسة الداخلية",
"Activity-L": "Manufacture of household linen(Cannon) & wholesale of underwear",
"ADRESS": "بناية نظريان\u001c - جسر الواطي - شارع داوود عمون\u001c - سن الفيل - المتن",
"TEL1": "01/480533",
"TEL2": "01/480532",
"TEL3": "01/494021",
"internet": "administration@bycop.com"
},
{
"Category": "Fourth",
"Number": "13699",
"com-reg-no": "18744",
"NM": "باتي شوب ش م م",
"L_NM": "Patty Shop sarl",
"Last Subscription": "16-Feb-18",
"Industrial certificate no": "1271",
"Industrial certificate date": "15-Feb-17",
"ACTIVITY": "تجارة جملة مواد اولية لصنع الحلويات",
"Activity-L": "Wholesale of primary materials for sweets",
"ADRESS": "سنتر جورج الخامس\u001c - ادونيس\u001c - زوق مصبح - كسروان",
"TEL1": "09/217973",
"TEL2": "09/217974",
"TEL3": "",
"internet": "pattyshp@yahoo.com"
},
{
"Category": "Fourth",
"Number": "29088",
"com-reg-no": "1018407",
"NM": "كالين ش م م",
"L_NM": "Caline sarl",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4106",
"Industrial certificate date": "9-Jun-18",
"ACTIVITY": "صناعة الشوكولا والسكاكر والبوظة",
"Activity-L": "Manufacture of chocolate ,candies & ice Cream",
"ADRESS": "ملك قرنقل\u001c - شارع كرم العريس\u001c - الباشورة - بيروت",
"TEL1": "01/641925",
"TEL2": "01/650398",
"TEL3": "03/195199",
"internet": "calinesarl@outlook.com"
},
{
"Category": "Third",
"Number": "16175",
"com-reg-no": "46976",
"NM": "ماريو غروب",
"L_NM": "Mario Groupe",
"Last Subscription": "10-Jun-17",
"Industrial certificate no": "4071",
"ACTIVITY": "تجارة اجهزة كمبيوتر والعاب كهربائية للتسلية وقطع التبديل",
"Activity-L": "Trading of computer & electronic games& spare parts",
"ADRESS": "ملك مارون ديب رزق\u001c - جسر الواطي \u001c - سن الفيل - المتن",
"TEL1": "01/490213",
"TEL2": "03/303112",
"TEL3": "",
"internet": "mariogrp@cyberia.net.lb"
},
{
"Category": "Second",
"Number": "3368",
"com-reg-no": "57693",
"NM": "شركة ابناء جوزف ناضر - جهاد وجوسلين ناضر - تضامن",
"L_NM": "Société Fils Joseph Nader - Jihad et Jocelyne Nader",
"Last Subscription": "15-Feb-18",
"Industrial certificate no": "4679",
"Industrial certificate date": "6-Oct-18",
"ACTIVITY": "معمل لنشر الصخور",
"Activity-L": "Cutting of rocks",
"ADRESS": "ملك جوزف ناضر\u001c - شارع القرقوف\u001c - الغينة - كسروان",
"TEL1": "09/788083",
"TEL2": "03/685580",
"TEL3": "",
"internet": "stenader@hotmail.com"
},
{
"Category": "First",
"Number": "5502",
"com-reg-no": "50634",
"NM": "مؤسسة الارز للطباعة ش م م",
"L_NM": "Arz Est. For Printing sarl",
"Last Subscription": "21-Nov-17",
"Industrial certificate no": "4856",
"Industrial certificate date": "10-Nov-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing Press",
"ADRESS": "ملك الشركة\u001c - شارع السلاف\u001c - الدكوانة - المتن",
"TEL1": "01/692220",
"TEL2": "01/692221",
"TEL3": "03/604487",
"internet": "walarz@hotmail.com"
},
{
"Category": "Second",
"Number": "5857",
"com-reg-no": "69985",
"NM": "شركة الصناعات الحديثة ش م م - ام اي بي",
"L_NM": "Modern Industrial Product sarl - M I P",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "4008",
"Industrial certificate date": "20-May-18",
"ACTIVITY": "صناعة اكواب وصحون بلاستيكية",
"Activity-L": "Manufacture of plastic cups & dishes",
"ADRESS": "ملك رولاند حايك\u001c - شارع الاستقلال\u001c - الاشرفية - بيروت",
"TEL1": "04/918777",
"TEL2": "04/919888",
"TEL3": "03/300024",
"internet": "mip@mipsarl.com"
},
{
"Category": "Fourth",
"Number": "13631",
"com-reg-no": "33255",
"NM": "انجو تراد ش م م",
"L_NM": "Anjo Trade sarl",
"Last Subscription": "20-Feb-17",
"Industrial certificate no": "2870",
"Industrial certificate date": "18-Nov-17",
"ACTIVITY": "صناعة وتعبئة المشروبات الروحية",
"Activity-L": "Manufacture & filling of alcoholic drinks",
"ADRESS": "ملك جوزف خير الله\u001c - الشارع العام\u001c - المتين - المتن",
"TEL1": "04/295558",
"TEL2": "03/361540",
"TEL3": "70/361540",
"internet": "alkasrfact@hotmail.com"
},
{
"Category": "First",
"Number": "2062",
"com-reg-no": "42300",
"NM": "وانليان اخوان - شركة تضامن",
"L_NM": "Vanlian Frères",
"Last Subscription": "23-Jun-17",
"Industrial certificate no": "4135",
"Industrial certificate date": "14-Jun-18",
"ACTIVITY": "صناعة المفروشات الخشبية وتجارة جملة الادوات الكهربائية المنزلية",
"Activity-L": " Manufacture of furniture & wholesale of electrical home appliances",
"ADRESS": "ملك ارتين سميتيان\u001c - شارع الشل\u001c - برج حمود - المتن",
"TEL1": "01/241951",
"TEL2": "03/241951",
"TEL3": "",
"internet": "accounting@galerievanlian.com"
},
{
"Category": "Second",
"Number": "3367",
"com-reg-no": "44072",
"NM": "كارلا",
"L_NM": "Karla",
"Last Subscription": "13-May-17",
"Industrial certificate no": "2367",
"Industrial certificate date": "13-Feb-18",
"ACTIVITY": "صناعة الشوكولا والسكاكر والبسكويت",
"Activity-L": "Manufacture of chocolate, candies & biscuits",
"ADRESS": "ملك شمعون\u001c - تلة السرور - الشارع العام\u001c - النقاش - المتن",
"TEL1": "04/522425",
"TEL2": "03/624252",
"TEL3": "",
"internet": "karla@dm.net.lb"
},
{
"Category": "Third",
"Number": "18687",
"com-reg-no": "58695",
"NM": "جيمي نيو فاشن - عجان وشركاه توصية بسيطة",
"L_NM": "Gemy New Fashion - Ajjan & Co.",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "171",
"Industrial certificate date": "11-Jan-19",
"ACTIVITY": "صناعة الالبسة النسائية والولادية",
"Activity-L": "Manufacture of ladies\' and children\'s wear",
"ADRESS": "ملك جيمي عجان\u001c - شارع مدرسة الرسل\u001c - البوشرية - المتن",
"TEL1": "01/689503",
"TEL2": "03/821230",
"TEL3": "",
"internet": "gemy@gemynewfashion.com"
},
{
"Category": "Excellent",
"Number": "1546",
"com-reg-no": "69097",
"NM": "ليدز انترناشيونال ش م ل",
"L_NM": "Leeds International sal",
"Last Subscription": "6-Feb-18",
"Industrial certificate no": "091",
"Industrial certificate date": "26-Dec-18",
"ACTIVITY": "معالجة النفايات وتصنيع الحاويات والهياكل المعدنية",
"Activity-L": "Treatment of waste products &manufacture of metallic Container & Chassis",
"ADRESS": "بناية Averda house \u001c - شارع عبد الملك\u001c - المرفأ - بيروت",
"TEL1": "01/360000",
"TEL2": "",
"TEL3": "",
"internet": "info@leedsintl.com"
},
{
"Category": "Fourth",
"Number": "32085",
"com-reg-no": "2045919",
"NM": "شركة مالتيكابس ش م ل",
"L_NM": "Multicaps sal",
"Last Subscription": "14-Oct-17",
"Industrial certificate no": "4744",
"Industrial certificate date": "17-Apr-18",
"ACTIVITY": "صناعة سدات بلاستيكية",
"Activity-L": "Manufacture of plastic lids and covers",
"ADRESS": "ملك باسورمه جيان وكرميان\u001c - المنطقة الصناعية - الشارع العام\u001c - مزرعة يشوع- المتن",
"TEL1": "04/924930",
"TEL2": "03/660540",
"TEL3": "",
"internet": "natplast94@gmail.com"
},
{
"Category": "Third",
"Number": "28952",
"com-reg-no": "7002",
"NM": "الشركة اللبنانية للانماء الصناعي - ليدكو ش م م",
"L_NM": "Lebanese Industrial for Development Co sarl - Lidco",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4013",
"Industrial certificate date": "28-Feb-18",
"ACTIVITY": "صناعة الصابون والشامبو ومساحيق التنظيف",
"Activity-L": "Manufacture of shampoo, soap and detergents",
"ADRESS": "ملك محمود بو عاصي\u001c - حي المشايخ\u001c - عاليه",
"TEL1": "05/285540",
"TEL2": "05/555670",
"TEL3": "03/352670",
"internet": ""
},
{
"Category": "First",
"Number": "4985",
"com-reg-no": "50938",
"NM": "ابناء محمد فريد العطار - توصية بسيطة",
"L_NM": "Mohamad Farid Attar Sons",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "174",
"Industrial certificate date": "11-Jan-19",
"ACTIVITY": "صناعة الملبس",
"Activity-L": "Manufacture of confection",
"ADRESS": "بناية اسكندراني رقم 3\u001c - شارع البستاني\u001c - طريق الجديدة - بيروت",
"TEL1": "01/854112",
"TEL2": "01/854105",
"TEL3": "03622805",
"internet": "attarco@inco.com.lb"
},
{
"Category": "Second",
"Number": "6391",
"com-reg-no": "61580",
"NM": "مؤسسة هاني فايد للتجارة العامة",
"L_NM": "Hani Fayed General Trade Est",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "192",
"Industrial certificate date": "15-Jan-19",
"ACTIVITY": "معملا لحفر وزخرفة كبايات وفناجين الزجاج والسراميك",
"Activity-L": " Graving of glasses,cups & ceramic",
"ADRESS": "بناية برج البشائر\u001c - شارع جبل العرب\u001c - وطى المصيطبة - بيروت",
"TEL1": "03/871050",
"TEL2": "01/316560",
"TEL3": "",
"internet": "fayed.han@hotmail.com"
},
{
"Category": "Third",
"Number": "12168",
"com-reg-no": "22090",
"NM": "بيشا - بيار شليطا ش م ل",
"L_NM": "Bicha sal",
"Last Subscription": "22-May-17",
"Industrial certificate no": "2146",
"Industrial certificate date": "25-Jun-17",
"ACTIVITY": "صناعة البياضات",
"Activity-L": "Manufacture of linen",
"ADRESS": "ملك شليطا\u001c - الشارع الرئيسي\u001c - الفنار - المتن",
"TEL1": "01/891367",
"TEL2": "01/890782",
"TEL3": "",
"internet": "picha@dm.net.lb"
},
{
"Category": "First",
"Number": "3530",
"com-reg-no": "53313",
"NM": "ادفانسد بلاستيك اندستريز ش م ل",
"L_NM": "Advanced Plastic Industries sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "148",
"Industrial certificate date": "8-Jan-19",
"ACTIVITY": "صناعة انابيب بلاستيك",
"Activity-L": "Manufacture of plastic tubes",
"ADRESS": "ملك تابت\u001c - المنطقة الصناعية\u001c - زوق مصبح - كسروان",
"TEL1": "09/220857",
"TEL2": "09/220858",
"TEL3": "09/220859",
"internet": "contact@api.com.lb"
},
{
"Category": "Third",
"Number": "24326",
"com-reg-no": "54269",
"NM": "مؤسسة خورين كوسيان التجارية - كوموتكس",
"L_NM": "Est. Khoren Kosseyan Pour le Commerce - Comotex",
"Last Subscription": "13-Feb-18",
"Industrial certificate no": "3704",
"Industrial certificate date": "27-Mar-18",
"ACTIVITY": "صناعة ربطات العنق والبيجامات والقمصان",
"Activity-L": "Manufacture of neckties, pyjama & shirts",
"ADRESS": "ملك جاغلاسيان\u001c - الاوتستراد\u001c - برج حمود - المتن",
"TEL1": "01/265773",
"TEL2": "01/266308",
"TEL3": "",
"internet": "comotex@cyberia.net.lb"
},
{
"Category": "Third",
"Number": "25406",
"com-reg-no": "41977",
"NM": "شركة اكسترا فور ش م م",
"L_NM": "Extra Four sarl",
"Last Subscription": "23-Jan-18",
"Industrial certificate no": "3949",
"Industrial certificate date": "11-May-18",
"ACTIVITY": "صناعة افران الية ومعدات المخابز",
"Activity-L": "Manufacture of bakeries & equipments",
"ADRESS": "سنتر شكر وباسيل\u001c - حي الغدير - شارع اللسيكو\u001c - كفرشيما - بعبدا",
"TEL1": "05/435433",
"TEL2": "03/641804",
"TEL3": "",
"internet": "contact@extrafourco.com"
},
{
"Category": "Fourth",
"Number": "27838",
"com-reg-no": "1010333",
"NM": "شركة دي جي أي ش م م - شركة مجوهرات الدبس الدولية ش م م D.J.I.sarl",
"L_NM": "D.J.I.sarl",
"Last Subscription": "11-Jan-17",
"Industrial certificate no": "4976",
"Industrial certificate date": "5-Jun-18",
"ACTIVITY": "صناعة المصوغات وتركيب الاحجار الكريمة",
"Activity-L": "Manufacture of jewelry & assorting of precious stones",
"ADRESS": "ملك كرم\u001c - شارع وديع نعيم\u001c - الاشرفية - بيروت",
"TEL1": "01/217116",
"TEL2": "03/800303",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1595",
"com-reg-no": "52847",
"NM": "مخابز مهدي الالية",
"L_NM": "Mahdi Automatic Bakery",
"Last Subscription": "8-Feb-18",
"Industrial certificate no": "4252",
"Industrial certificate date": "6-Jul-18",
"ACTIVITY": "فرن للخبز العربي والافرنجي",
"Activity-L": "Bakery",
"ADRESS": "ملك محمود مهدي\u001c - شارع الرادوف\u001c - برج البراجنة - بعبدا",
"TEL1": "01/472068",
"TEL2": "03/357118",
"TEL3": "",
"internet": "mmouhh@hotmail.com"
},
{
"Category": "First",
"Number": "456",
"com-reg-no": "970",
"NM": "شركة فارمادكس ش م ل",
"L_NM": "Pharmadex sal",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "111",
"Industrial certificate date": "28-Dec-18",
"ACTIVITY": "صناعة الادوية والشامبو الطبي",
"Activity-L": "Manufacture of medicines and medical shampoo",
"ADRESS": "ملك الشركة\u001c - حي السنديانة - طريق الشام\u001c - الكحالة - عاليه",
"TEL1": "05/769119",
"TEL2": "05/768296",
"TEL3": "03/814605",
"internet": "info@pharmadex.net"
},
{
"Category": "Excellent",
"Number": "1746",
"com-reg-no": "20336",
"NM": "فقرا للتجارة والصناعة",
"L_NM": "Fakra Trading & Industries",
"Last Subscription": "31-Jan-18",
"Industrial certificate no": "3937",
"Industrial certificate date": "8-May-18",
"ACTIVITY": "صناعة النبيذ والمشروبات الروحية وماء الزهر والورد والشرابات",
"Activity-L": "Manufacture of wine&alcoholic drinks- Orange-flower&rose water& beverages",
"ADRESS": "سنتر فقرا\u001c - حي الصايغ\u001c - كفرذبيان - كسروان",
"TEL1": "09/635111",
"TEL2": "09/635222",
"TEL3": "09/913186",
"internet": "info@fakra.com"
},
{
"Category": "First",
"Number": "4254",
"com-reg-no": "42557",
"NM": "نصري كرم واولاده ش م م",
"L_NM": "Nasri Karam & Sons sarl",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "088",
"Industrial certificate date": "26-Dec-18",
"ACTIVITY": "معملا لصب الاسفنج وتقطيعه وصنع الفرش",
"Activity-L": "Casting & cutting of sponge - Manufacture of matresses",
"ADRESS": "ملك الشركة\u001c - الشارع العام\u001c - روميه - المتن",
"TEL1": "01/899222",
"TEL2": "01/899223",
"TEL3": "01/894170",
"internet": "info@nasrikaramandsons.com"
},
{
"Category": "Second",
"Number": "6275",
"com-reg-no": "8846",
"NM": "سوشيه ش م م",
"L_NM": "Souchét sarl",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4297",
"Industrial certificate date": "13-Jul-18",
"ACTIVITY": "صناعة الشوكولا والسكاكر والبسكويت",
"Activity-L": "Manufacture of chocolate, candies & biscuits",
"ADRESS": "ملك منير السبع\u001c - عين الدلبة - شارع مدرسة الرمل الرسمية\u001c - برج البراجنة - بعبدا",
"TEL1": "01/452900",
"TEL2": "04/451600",
"TEL3": "03/246040",
"internet": "info@souchet-lb.com"
},
{
"Category": "First",
"Number": "3546",
"com-reg-no": "53536",
"NM": "كلود جورج كشر",
"L_NM": "Claude Georges Cachard",
"Last Subscription": "6-Feb-18",
"Industrial certificate no": "085",
"Industrial certificate date": "22-Dec-18",
"ACTIVITY": "صناعة المجوهرات وتركيب الاحجار الكريمة",
"Activity-L": "Manufacture of Jewelry & assorting of precious stones",
"ADRESS": "بناية اندلوسيا ط 4\u001c - شارع غورو\u001c - الجميزة - بيروت",
"TEL1": "01/448818",
"TEL2": "01/448033",
"TEL3": "",
"internet": "joailleriecachard@hotmail.com"
},
{
"Category": "Third",
"Number": "15290",
"com-reg-no": "40640",
"NM": "شركة ليفكو الفنية التجارية ش م م",
"L_NM": "Lifco Technical & Trading Co. sarl",
"Last Subscription": "25-Jan-18",
"Industrial certificate no": "264",
"Industrial certificate date": "24-Jan-19",
"ACTIVITY": "صناعة و تجارة برادات صناعية وشوايات وتجهيزات السوبرماركت",
"Activity-L": "Manufacture& Trading of industrial refrigerator, grill,supermarket supplies",
"ADRESS": "سنتر ليفكو\u001c - الاوتوستراد\u001c - خلده - عاليه",
"TEL1": "05/800151",
"TEL2": "05/800152+3",
"TEL3": "03/653194",
"internet": "lifco@cyberia.net.lb"
},
{
"Category": "Second",
"Number": "6520",
"com-reg-no": "18597",
"NM": "رابيد اندستريز ش م م",
"L_NM": "Rapid Industries sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "4354",
"Industrial certificate date": "22-Jul-18",
"ACTIVITY": "صناعة عبوات بلاستيكية",
"Activity-L": "Manufacture of plastic containers",
"ADRESS": "ملك الشركة\u001c - المدينة الصناعية\u001c - مزرعة يشوع - المتن",
"TEL1": "04/927013",
"TEL2": "04/920045",
"TEL3": "03/678764",
"internet": "rapid@dm.net.lb"
},
{
"Category": "Excellent",
"Number": "167",
"com-reg-no": "575",
"NM": "شركة يوسف طحيني واولاده  - ميشال طحيني وشركاه خلفاء",
"L_NM": "Joseph Tehini & Fils - Michel Tehini & Cie - Successeurs",
"Last Subscription": "22-Feb-18",
"Industrial certificate no": "3592",
"Industrial certificate date": "11-Mar-18",
"ACTIVITY": "معملا لتجميع مولدات وتابلوهات كهربائية - تجارة جملة معدات صناعية وزراعية",
"Activity-L": "Manufactureofgenerators&boards-Wholesaleofagricultural&industrial equipment",
"ADRESS": "ملك ستاركو ط ارضي\u001c - وسط بيروت\u001c - ميناء الحصن - بيروت",
"TEL1": "04/928178",
"TEL2": "04/926564",
"TEL3": "03/652208",
"internet": "info@tehini.com"
},
{
"Category": "First",
"Number": "1789",
"com-reg-no": "33497",
"NM": "حنا اخوان - شركة تضامن",
"L_NM": "Hanna Frères",
"Last Subscription": "16-Feb-18",
"Industrial certificate no": "3985",
"Industrial certificate date": "17-May-18",
"ACTIVITY": "صياغة المجوهرات",
"Activity-L": "Manufacture of jewelry",
"ADRESS": "مبنى البلدية\u001c - شارع ويغان\u001c - النجمة - بيروت",
"TEL1": "04/722448+9",
"TEL2": "04/724555",
"TEL3": "",
"internet": "ibrahim@hannafreres.com"
},
{
"Category": "Third",
"Number": "17722",
"com-reg-no": "51488",
"NM": "ريشا الفيتر غروب ش م م - هوفمان",
"L_NM": "Richa Elevator Group sarl.- Hovman",
"Last Subscription": "24-Oct-17",
"Industrial certificate no": "4730",
"Industrial certificate date": "16-Oct-18",
"ACTIVITY": "تجميع المصاعد",
"Activity-L": "Gathering of electrical elevators",
"ADRESS": "ملك عفيف ريشا\u001c - حارة صخر- شارع مار مارون\u001c - جونيه - كسروان",
"TEL1": "09/935088",
"TEL2": "09/931507",
"TEL3": "03/758755",
"internet": "info@hovmanelevators.com"
},
{
"Category": "Excellent",
"Number": "270",
"com-reg-no": "19339",
"NM": "شركة ينابيع لبنان ش م ل - صنين",
"L_NM": "Compagnie des Sources du Liban sal - Sannine",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "3856",
"Industrial certificate date": "22-Apr-18",
"ACTIVITY": "معملا لتعبئة المياه المعدنية والطبيعية",
"Activity-L": "Bottling of mineral & natural water",
"ADRESS": "ملك الشركة - الشارع العام - بقتعوته - كسروان",
"TEL1": "09/213491+2",
"TEL2": "09/214476+7",
"TEL3": "09/710550",
"internet": "sannine@sannine.com"
},
{
"Category": "Excellent",
"Number": "72",
"com-reg-no": "942/21546",
"NM": "شركة مصاعد اوتيس ش م ل",
"L_NM": "Otis Elevator Company sal",
"Last Subscription": "24-Feb-18",
"Industrial certificate no": "4547",
"Industrial certificate date": "28-Aug-18",
"ACTIVITY": "تجميع المصاعد الكهربائية وقطع التبديل",
"Activity-L": "Gathering of electrical elevators & spare parts",
"ADRESS": "بناية ابراهيم دياب\u001c - المنطقة الصناعية - شارع رقم12\u001c - المكلس - المتن",
"TEL1": "01/685801",
"TEL2": "01/685806",
"TEL3": "",
"internet": "otisleb@dm.net.lb"
},
{
"Category": "First",
"Number": "1065",
"com-reg-no": "10140",
"NM": "شركة أم أم أس لبنان (مشغل الميكانيك الحديث)",
"L_NM": "M.M.S Co Lebanon (The Modern Machine Shop)",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "538",
"Industrial certificate date": "8-Mar-19",
"ACTIVITY": "معمل تصنيع الالات والمعدات الصناعية المختلفه والخراطة",
"Activity-L": "Manufacture of industrial machinery & turnery",
"ADRESS": "ملك بشاره بو خاطر\u001c - الشارع العام\u001c - البوشرية - المتن",
"TEL1": "01/894825",
"TEL2": "01/894844",
"TEL3": "03/566624",
"internet": "info@mmslb.com"
},
{
"Category": "Second",
"Number": "3590",
"com-reg-no": "17503",
"NM": "مؤسسة صدقة للصناعة والتجارة",
"L_NM": "Sadaka Est. for Industry & Trade",
"Last Subscription": "20-Feb-18",
"Industrial certificate no": "387",
"Industrial certificate date": "15-Feb-19",
"ACTIVITY": "صناعة المعجنات( قطايف، مغربية، رقاق، قشطة)",
"Activity-L": "Manufacture of pastry & cream from fresh milk",
"ADRESS": "ملك احمد صدقة\u001c - شارع الامراء\u001c - الشويفات - عاليه",
"TEL1": "05/488000",
"TEL2": "05/482482",
"TEL3": "03/215875",
"internet": "info@sadaka-lb.com"
},
{
"Category": "Second",
"Number": "6513",
"com-reg-no": "37665",
"NM": "نيون ناسيونال ش م م",
"L_NM": "Neon National sarl",
"Last Subscription": "2-Feb-18",
"Industrial certificate no": "4037",
"Industrial certificate date": "29-May-18",
"ACTIVITY": "صناعة آرمات نيون",
"Activity-L": "Manufacture of neon nameplates",
"ADRESS": "ملك ريمون اسايان\u001c - المنطقة الصناعية\u001c - عين سعادة - المتن",
"TEL1": "01/900978",
"TEL2": "01/870874",
"TEL3": "",
"internet": "neonat@dm.net.lb"
},
{
"Category": "Second",
"Number": "2384",
"com-reg-no": "25432",
"NM": "مؤسسة الهلال للتجارة والمقاولات",
"L_NM": "Al Hilal Trading & Contracting Est",
"Last Subscription": "27-May-17",
"Industrial certificate no": "2186",
"Industrial certificate date": "10-Mar-18",
"ACTIVITY": "تجارة ادوات كهربائية منزلية وتجارة المياه الطبعية",
"Activity-L": "Trading of electrical home appliances- Trading of natural water",
"ADRESS": "بناية الهلال\u001c - شارع عبد النور\u001c - حارة حريك - بعبدا",
"TEL1": "01/557120",
"TEL2": "01/557118",
"TEL3": "03/246550",
"internet": ""
},
{
"Category": "Third",
"Number": "9872",
"com-reg-no": "4334",
"NM": "اتحاد المنتوجات الكيماوية والدهانات - كوبا - لصاحبها فيكتور فرج الله حداد",
"L_NM": "Consolidated Paint & Chemicals Products (Copa)",
"Last Subscription": "21-Mar-17",
"Industrial certificate no": "2972",
"Industrial certificate date": "12-Dec-17",
"ACTIVITY": "صناعة الدهانات والبويا واللكر",
"Activity-L": "Manufacture of paints",
"ADRESS": "ملك حداد\u001c - الشارع العام\u001c - عمارة شلهوب - المتن",
"TEL1": "01/879576",
"TEL2": "01/893563",
"TEL3": "03/305312",
"internet": "copa@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "770",
"com-reg-no": "31096",
"NM": "فسكو نوبيزول",
"L_NM": "Fesco Noubisol",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "3176",
"Industrial certificate date": "20-Jan-18",
"ACTIVITY": "صناعة العوازل الحرارية والصوتية والسقوف المستعارة",
"Activity-L": "Manufacture of sound & heat insulating & false ceiling",
"ADRESS": "بناية غوستانيان\u001c - خلف شركة بردويل\u001c - البوشرية - المتن",
"TEL1": "01/893341",
"TEL2": "03/659594",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "3722",
"com-reg-no": "64994",
"NM": "مؤسسة بسام الغراوي لصناعة وتجارة السكاكر والشوكولا والحلويات",
"L_NM": "Bassam Ghrawi Est. For Sweets Industry & Trade",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4568",
"Industrial certificate date": "5-Sep-18",
"ACTIVITY": "صناعة الشوكولا والسكاكر والفواكه المجففة",
"Activity-L": "Manufacture of chocolate, candies & dried fruit",
"ADRESS": "بناية الحياة\u001c - شارع ابن خلدون\u001c - برج ابي حيدر - بيروت",
"TEL1": "01/317460",
"TEL2": "03/285211",
"TEL3": "01/313186",
"internet": "info@ghrawi.com"
},
{
"Category": "Third",
"Number": "24357",
"com-reg-no": "46229",
"NM": "كاما ش م م",
"L_NM": "Cama sarl",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "3263",
"Industrial certificate date": "31-Mar-18",
"ACTIVITY": "نشر وجلي البلاط والرخام",
"Activity-L": "Cutting & Polishing of tiles & marbles",
"ADRESS": "ملك الشركة\u001c - طريق بكفيا\u001c - انطلياس - المتن",
"TEL1": "04/404295",
"TEL2": "04/404296",
"TEL3": "04/524155",
"internet": "cama@terra.net.lb"
},
{
"Category": "First",
"Number": "4975",
"com-reg-no": "27083",
"NM": "شركة العصير الطبيعي اللبناني - جونال ش م م",
"L_NM": "Jus Natural Libanais - Junal sarl",
"Last Subscription": "2-Feb-18",
"Industrial certificate no": "3461",
"Industrial certificate date": "23-Feb-18",
"ACTIVITY": "صناعة وتعبئة عصير الحامض",
"Activity-L": "Bottling of lemon juice",
"ADRESS": "بناية جونال\u001c - المدينة الصناعية\u001c - الفنار - المتن",
"TEL1": "01/895342",
"TEL2": "01/879796",
"TEL3": "01/898386",
"internet": "info@junal.com"
},
{
"Category": "Third",
"Number": "21383",
"com-reg-no": "43335",
"NM": "شركة الحكيم للصناعة والتجارة ش م م",
"L_NM": "Al Hakim Co. For Industry & Trade sarl",
"Last Subscription": "13-Mar-18",
"Industrial certificate no": "517",
"Industrial certificate date": "6-Mar-19",
"ACTIVITY": "تصنيع الحشوات من نسيج غير منسوجة",
"Activity-L": "Manufacture of pads",
"ADRESS": "بناية سنو\u001c - شارع عبد الله المشنوق\u001c - ساقية الجنزير - بيروت",
"TEL1": "01/868851",
"TEL2": "01/868852",
"TEL3": "03/614160",
"internet": "whakim@inco.com.lb"
},
{
"Category": "Excellent",
"Number": "1806",
"com-reg-no": "33563",
"NM": "مؤسسة سالتك",
"L_NM": "Saltek Est",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "110",
"Industrial certificate date": "28-Feb-18",
"ACTIVITY": "معمل الافران الالية ونصف الالية",
"Activity-L": "Manufacture of automatic bakery machineries",
"ADRESS": "ملك ورثة جورج حجيلي\u001c - الدورة - الشارع البحري\u001c - برج حمود - المتن",
"TEL1": "01/264121",
"TEL2": "01/242628",
"TEL3": "03/222217",
"internet": "saltek@saltek.com.lb"
},
{
"Category": "Third",
"Number": "17064",
"com-reg-no": "52807",
"NM": "شركة جورج جمال واولاده ش م م",
"L_NM": "Société Georges Jammal et Fils sarl",
"Last Subscription": "20-Jun-17",
"Industrial certificate no": "4145",
"Industrial certificate date": "15-Jun-18",
"ACTIVITY": "صناعة العرق والنبيذ والشرابات وتجارة المشروبات الروحية",
"Activity-L": "Manufacture of arrack, wine & beverages & wholesale of alcoholic drinks",
"ADRESS": "ملك جمال\u001c - شارع مار روكز\u001c - الدكوانة - المتن",
"TEL1": "01/683077",
"TEL2": "03/337699",
"TEL3": "",
"internet": "info@georgesjammal.com"
},
{
"Category": "Second",
"Number": "4494",
"com-reg-no": "54740",
"NM": "هوريزونتال تامبيرينغ غلاس ش م م",
"L_NM": "Horizontal Tempering Glass sarl",
"Last Subscription": "24-Feb-18",
"Industrial certificate no": "408",
"Industrial certificate date": "19-Feb-19",
"ACTIVITY": "صناعة قص الزجاج ( Securite)",
"Activity-L": "Manufacture of securite glass",
"ADRESS": "ملك الشركة\u001c - شارع مار الياس\u001c - المكلس - المتن",
"TEL1": "01/683074",
"TEL2": "01/683075",
"TEL3": "03/258717",
"internet": "htg@dm.net.lb"
},
{
"Category": "Second",
"Number": "6668",
"com-reg-no": "55842",
"NM": "شركة ميروديك ش م م",
"L_NM": "Mirodec sarl",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "213",
"Industrial certificate date": "17-Jan-19",
"ACTIVITY": "صناعة الزجاج والزجاج المزخرف",
"Activity-L": "Manufacture of glass",
"ADRESS": "ملك جوزف الخوري\u001c - شارع بربر ابو جوده\u001c - البوشرية - المتن",
"TEL1": "01/688162+3",
"TEL2": "03/688162",
"TEL3": "03/599011",
"internet": "mirodec@dm.net.lb"
},
{
"Category": "First",
"Number": "5241",
"com-reg-no": "8939",
"NM": "كاليري الحويك",
"L_NM": "Galerie Hoayek",
"Last Subscription": "1-Feb-18",
"Industrial certificate no": "4188",
"Industrial certificate date": "23-Jun-18",
"ACTIVITY": "صناعة وتجارة المفروشات الخشبية",
"Activity-L": "Manufacture & trading of wooden furniture",
"ADRESS": "ملك الحويك\u001c - الشارع العام\u001c - اللويزة - بعبدا",
"TEL1": "05/921080",
"TEL2": "05/921081",
"TEL3": "03/749746",
"internet": "ghoayek@cyberia.net.lb"
},
{
"Category": "Second",
"Number": "5948",
"com-reg-no": "32680",
"NM": "مؤسسة حرفوش للتجارة والصناعة - باستل Pastel",
"L_NM": "Harfouch for Trading & Industring - Pastel - Est",
"Last Subscription": "9-Mar-18",
"Industrial certificate no": "2940",
"Industrial certificate date": "8-May-18",
"ACTIVITY": "صناعة الدهانات",
"Activity-L": "Manufacture of paints",
"ADRESS": "ملك حرفوش\u001c - المدينة الصناعية\u001c - مزرعة يشوع - المتن",
"TEL1": "04/915115+16",
"TEL2": "03/275959",
"TEL3": "04/920200",
"internet": "pastel@pastelpaints.com"
},
{
"Category": "Second",
"Number": "6067",
"com-reg-no": "50354",
"NM": "الشركة العامة للصيانة والتصنيع ش م م",
"L_NM": "General Manufacturing & Maintenance Ltd. - G.M.M",
"Last Subscription": "3-Mar-17",
"Industrial certificate no": "1524",
"Industrial certificate date": "18-Mar-18",
"ACTIVITY": "صناعة ماكينات لتكرير المياه وتعبئة السوائل وتنشيف القناني",
"Activity-L": "Manufacture of water treatment, liquid filling & drying machinery",
"ADRESS": "ملك نكد\u001c - المنطقة الصناعية - الشارع العام\u001c - روميه - المتن",
"TEL1": "01/887947",
"TEL2": "03/341929",
"TEL3": "",
"internet": "info@gmm-nakad.com"
},
{
"Category": "Excellent",
"Number": "1249",
"com-reg-no": "69546",
"NM": "المتحدة للاغذية والتموين ش م ل",
"L_NM": "United Food Stuffs and Catering sal",
"Last Subscription": "23-Feb-18",
"Industrial certificate no": "4591",
"Industrial certificate date": "12-Sep-18",
"ACTIVITY": "صناعة اكياس النايلون وتجارة جملة غذائية وزيوت نباتية",
"Activity-L": "Manufacture of nylon bags & wholesale of foodstuffs & vegetable oils",
"ADRESS": "ملك الشركة\u001c - منطقة المعامل - شارع 74\u001c - المكلس - المتن",
"TEL1": "01/683510",
"TEL2": "01/683511",
"TEL3": "03/282356",
"internet": "info@ufclb.com"
},
{
"Category": "Excellent",
"Number": "1053",
"com-reg-no": "23871",
"NM": "حلويات ومخابز الامراء الالية",
"L_NM": "P‏âtisserie et Boulangerie Al Oumara",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "094",
"Industrial certificate date": "26-Nov-18",
"ACTIVITY": "فرن",
"Activity-L": "Bakery",
"ADRESS": "ملك كاظم ابراهيم\u001c - شارع الامراء\u001c - حارة حريك - بعبدا",
"TEL1": "01/556777",
"TEL2": "01/557999",
"TEL3": "",
"internet": "info@aloumara.com.lb"
},
{
"Category": "Second",
"Number": "6597",
"com-reg-no": "7836",
"NM": "شركة شديد وايوب وشركاهم ش م م",
"L_NM": "Chedid & Ayoub & Co sarl",
"Last Subscription": "16-Mar-17",
"Industrial certificate no": "3582",
"Industrial certificate date": "10-Mar-18",
"ACTIVITY": "صناعة وتطعيج الصفائح الحديدية",
"Activity-L": "Manufacture & forming of iron sheets",
"ADRESS": "ملك شديد وايوب \u001c - جسر الباشا - شارع مار الياس\u001c - المكلس - المتن",
"TEL1": "01/486338+9",
"TEL2": "01/486340",
"TEL3": "01/493650",
"internet": "michelchedid@yahoo.com"
},
{
"Category": "Second",
"Number": "985",
"com-reg-no": "55545",
"NM": "قره بت ورطان طاشجيان",
"L_NM": "Garabet Vartan Tachajian",
"Last Subscription": "31-Jul-17",
"Industrial certificate no": "4378",
"Industrial certificate date": "27-Jul-18",
"ACTIVITY": "طحن البن والبهارات وتجارة بقالة وسمانة والتبغ",
"Activity-L": "Grocery & tobbacco, grinding of spices & coffee processing",
"ADRESS": "ملك احمد علي طربيه\u001c - كمب مرعش\u001c - برج حمود - المتن",
"TEL1": "01/261287",
"TEL2": "03/821235",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "24858",
"com-reg-no": "72120",
"NM": "شركة تيبو برس - الياس ملكي واولاده  - تضامن",
"L_NM": "Typopress",
"Last Subscription": "22-Jun-17",
"Industrial certificate no": "2994",
"Industrial certificate date": "18-May-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing",
"ADRESS": "ملك الشركة\u001c - نهر الموت - شارع مار مار مطانيوس\u001c - الجديدة - المتن",
"TEL1": "01/870252",
"TEL2": "03/626042",
"TEL3": "01/870253",
"internet": "info@typo-press.com"
},
{
"Category": "Excellent",
"Number": "821",
"com-reg-no": "54282",
"NM": "شركة كامل بكداش واولاده ش م ل",
"L_NM": "Société Kamel Bekdache et Fils sal",
"Last Subscription": "5-Apr-17",
"Industrial certificate no": "833",
"Industrial certificate date": "8-Apr-17",
"ACTIVITY": "معملا لتقطيع وتوضيب الورق - تجارة جملة الورق والكرتون والقرطاسية",
"Activity-L": "Cutting of paper - Wholesale of paper, carton & stationery",
"ADRESS": "ملك الشركة\u001c - الجناح - شارع عدنان الحكيم\u001c - بئر حسن - بيروت",
"TEL1": "03/377194",
"TEL2": "07/996734",
"TEL3": "07/996738",
"internet": "skb@bekdache.com"
},
{
"Category": "First",
"Number": "1330",
"com-reg-no": "41562",
"NM": "ايوب للصناعة والتجارة ش م ل",
"L_NM": "Ayoub Industries & Commerce sal",
"Last Subscription": "10-Feb-18",
"Industrial certificate no": "308",
"Industrial certificate date": "31-Jan-19",
"ACTIVITY": "انتاج افلام البوليتلين واكياس واشرطة لاصقة وفرشات الاسرة وتجارة المفروشات",
"Activity-L": "Manufacture of polytheline bags & mattresses & trading of furniture",
"ADRESS": "ملك ايوب\u001c - شارع الشل\u001c - برج حمود - المتن",
"TEL1": "01/259900",
"TEL2": "01/259901",
"TEL3": "01/259902",
"internet": "ayoubindustries@gmail.com"
},
{
"Category": "Excellent",
"Number": "1709",
"com-reg-no": "310",
"NM": "الشركة الصناعية للشرق ش م ل",
"L_NM": "Société Industrielle du Levant sal",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "4471",
"Industrial certificate date": "11-Aug-18",
"ACTIVITY": "مطاحن للحبوب",
"Activity-L": "Grain milling",
"ADRESS": "ملك الشركة\u001c - شارع البرازيل\u001c - الكرنتينا - بيروت",
"TEL1": "01/442144",
"TEL2": "01/445901",
"TEL3": "01/580142",
"internet": "info@sidul.com"
},
{
"Category": "Second",
"Number": "1980",
"com-reg-no": "19489",
"NM": "كاليري سماحة",
"L_NM": "Galerie Samaha",
"Last Subscription": "21-Jun-17",
"Industrial certificate no": "4091",
"Industrial certificate date": "7-Jun-18",
"ACTIVITY": " صناعة المفروشات الخشبية والمنجورات",
"Activity-L": "Manufacture of wooden furniture & panelling",
"ADRESS": "ملك نسيم هارون\u001c - الاوتوستراد\u001c - عمارة شلهوب - المتن",
"TEL1": "01/891913",
"TEL2": "03/647733",
"TEL3": "03/392369",
"internet": "samaha@samaha.info"
},
{
"Category": "Second",
"Number": "6432",
"com-reg-no": "25789",
"NM": "شركة مجمعات سماحه للصناعة والتجارة ش م م",
"L_NM": "Samaha Groupement pour L\'Industrie et Le Commerce sarl",
"Last Subscription": "16-Jun-17",
"Industrial certificate no": "4092",
"Industrial certificate date": "7-Jun-18",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك انيس وسامر سماحة\u001c - المدينة الصناعية\u001c - روميه - المتن",
"TEL1": "01/891913",
"TEL2": "01/875294",
"TEL3": "03/647744",
"internet": "samaha@samaha.info"
},
{
"Category": "Second",
"Number": "5302",
"com-reg-no": "24702",
"NM": "الشركة اللبنانية للصناعة - جان عنيد واولاده ش م ل",
"L_NM": "Ste. Libanaise pour l\'Industrie - Jean Anid&Fils sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "207",
"Industrial certificate date": "17-Jan-19",
"ACTIVITY": "صناعة علب التنك",
"Activity-L": "Manufacture of metal boxes",
"ADRESS": "ملك شركة عنيد ترايدينغ اند انفستمنت ش م ل\u001c - الشارع العام\u001c - المكلس - المتن",
"TEL1": "01/684111",
"TEL2": "01/684890",
"TEL3": "",
"internet": "janid@dm.net.lb"
},
{
"Category": "Second",
"Number": "5629",
"com-reg-no": "58827",
"NM": "سو - ي - مي - لبنان ش م ل",
"L_NM": "SO. I. ME Liban sal",
"Last Subscription": "11-May-17",
"Industrial certificate no": "2057",
"Industrial certificate date": "14-Jun-17",
"ACTIVITY": " مصنعا للباطون الجاهز",
"Activity-L": "Manufacture of ready mixed concrete",
"ADRESS": "ملك الشركة\u001c - حي الامراء - شارع التيرو\u001c - الشويفات - عاليه",
"TEL1": "05/480225",
"TEL2": "03/334940",
"TEL3": "",
"internet": "soime@soimeliban.com"
},
{
"Category": "Excellent",
"Number": "1308",
"com-reg-no": "4933",
"NM": "الشركة الوطنية للزجاج والمرايا ش م ل",
"L_NM": "Glass & Mirrors National Co",
"Last Subscription": "20-Mar-17",
"Industrial certificate no": "3544",
"Industrial certificate date": "6-Mar-18",
"ACTIVITY": "شطب وقص الزجاج",
"Activity-L": "Cutting of glass",
"ADRESS": "ملك عبيد\u001c - شارع سلاف\u001c - الدكوانة - المتن",
"TEL1": "01/688100",
"TEL2": "01/688101+3",
"TEL3": "",
"internet": "gmnc2@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "850",
"com-reg-no": "57927",
"NM": "شركة مطر للرخام ش م ل - رأ مطر وشركاهم",
"L_NM": "Mattar Marble Company sal - R.E. Mattar & Partners",
"Last Subscription": "7-Mar-18",
"Industrial certificate no": "2717",
"Industrial certificate date": "29-Mar-18",
"ACTIVITY": "معمل نشر وجلي الصخور والرخام",
"Activity-L": "Cutting & polishing of marble & rocks",
"ADRESS": "ملك مطر\u001c - المستديرة\u001c - المكلس - المتن",
"TEL1": "01/684959",
"TEL2": "01/702431",
"TEL3": "03/729472",
"internet": "info@mattargroup.com"
},
{
"Category": "Excellent",
"Number": "248",
"com-reg-no": "55944",
"NM": "شركة عصير الفاكهة اللبنانية ش م ل",
"L_NM": "Lebanon Fruit Juice Co sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "3422",
"Industrial certificate date": "20-Feb-18",
"ACTIVITY": "صناعة عصير الفاكهة والبان واجبان وبوظة",
"Activity-L": "Manufacture of juice,dairy products, & ice cream",
"ADRESS": "ملك الشركة\u001c - شارع ابو حلقه\u001c - الفنار - المتن",
"TEL1": "01/891200+1",
"TEL2": "01/891202",
"TEL3": "01/891205",
"internet": "bonjus@bonjus.com"
},
{
"Category": "Excellent",
"Number": "1810",
"com-reg-no": "9781",
"NM": "مطاحن الدوره ش م ل",
"L_NM": "Dora Flours Mills sal",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "4268",
"Industrial certificate date": "10-Jul-18",
"ACTIVITY": "مطاحن الحبوب والعلف",
"Activity-L": "Mills of cereals & animal feed",
"ADRESS": "ملك الشركة\u001c - الطريق البحري\u001c - الدوره - المتن",
"TEL1": "01/252577",
"TEL2": "01/252578",
"TEL3": "01/252579",
"internet": "sinnoam@dm.net.lb"
},
{
"Category": "Third",
"Number": "26753",
"com-reg-no": "29792",
"NM": "اتحاد الكرتون ش م م - يوني كرتون ش م م",
"L_NM": "Uni Carton sarl - United Carton sarl",
"Last Subscription": "6-Feb-17",
"Industrial certificate no": "2932",
"Industrial certificate date": "3-Dec-17",
"ACTIVITY": "صناعة علب الكرتون",
"Activity-L": "Manufacture of carton boxes",
"ADRESS": "بناية شلالا\u001c - الشارع العام\u001c - غزير - كسروان",
"TEL1": "09/920435",
"TEL2": "03/020726",
"TEL3": "03/678971",
"internet": "info@unicarton.com"
},
{
"Category": "First",
"Number": "2169",
"com-reg-no": "21806",
"NM": "مؤسسة المطبخ الفني",
"L_NM": "Cuisine d\'Art",
"Last Subscription": "19-Oct-17",
"Industrial certificate no": "4713",
"Industrial certificate date": "12-Oct-18",
"ACTIVITY": "صناعة المطابخ الجاهزة",
"Activity-L": "Manufacture of kitchens",
"ADRESS": "ملك انطوان عطا الله\u001c - حي الزيعترية - المنطقة الصناعية\u001c - الفنار - المتن",
"TEL1": "01/684333",
"TEL2": "01/683671",
"TEL3": "01/684333",
"internet": "cuisinedart@cuisinedart.net"
},
{
"Category": "Third",
"Number": "14042",
"com-reg-no": "35282",
"NM": "فين كورب",
"L_NM": "Fin Corp",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4074",
"Industrial certificate date": "5-Jun-18",
"ACTIVITY": "صناعة الات صناعية",
"Activity-L": "Manufacture of industrial machinery",
"ADRESS": "ملك حبيب مجاعص\u001c - عين السنديانة - المدينة الصناعية\u001c - ضهور الشوير - المتن",
"TEL1": "04/270663",
"TEL2": "",
"TEL3": "",
"internet": "fincorp@beirut.com"
},
{
"Category": "Excellent",
"Number": "47",
"com-reg-no": "8110",
"NM": "الشركة الاهلية لتوزيع الغاز - ناتغاز ش م ل",
"L_NM": "National Distributing Gaz Co. - NAT GAZ - sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "008",
"Industrial certificate date": "8-Dec-18",
"ACTIVITY": "تعبئة وتجارة الغاز",
"Activity-L": "Trading & filling of gas",
"ADRESS": "مبنى ذي سكوير اوفيسيز \u001c - شارع ناصيف اليازجي\u001c - الباشورة - بيروت",
"TEL1": "01/877802",
"TEL2": "01/888881",
"TEL3": "03/745004",
"internet": "info@natgaz.com.lb"
},
{
"Category": "Excellent",
"Number": "1687",
"com-reg-no": "48164",
"NM": "نصار تكنو غروب ش م ل",
"L_NM": "Nassar Techno Group sal",
"Last Subscription": "13-Apr-17",
"Industrial certificate no": "2985",
"Industrial certificate date": "14-Dec-17",
"ACTIVITY": "صناعة محطات تكرير المياه والخزانات البلاستكية",
"Activity-L": "Manufacture of purifying machinery for water & plastic tanks",
"ADRESS": "نصار تكنو غروب ش م ل\u001c - المنطقة الصناعية\u001c - مزرعة يشوع - المتن",
"TEL1": "04/925000",
"TEL2": "04/913890+91",
"TEL3": "04/912239",
"internet": "ntg@nassar-group.com"
},
{
"Category": "Excellent",
"Number": "1054",
"com-reg-no": "70413",
"NM": "مجموعة حميد التجارية - حميد وشركاه  ش م ل",
"L_NM": "Commercial Hamid Group - Hamid & Co. - sal",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "199",
"Industrial certificate date": "16-Jan-19",
"ACTIVITY": "صناعة وتجارة جملة الحلى المزيفة والمسابح",
"Activity-L": "Maufacture & wholesale of false jewelry & rosaries",
"ADRESS": "ملك مريم حراجلي\u001c - كورنيش المزرعة\u001c - وطى المصيطبة - بيروت",
"TEL1": "01/270555",
"TEL2": "01/270444",
"TEL3": "03/271196",
"internet": "hamid@cyberia.net.lb"
},
{
"Category": "Third",
"Number": "13361",
"com-reg-no": "32467",
"NM": "شركة سبارتاكوس للاحذية ش م م",
"L_NM": "Spartakus Co sarl",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4025",
"Industrial certificate date": "24-May-18",
"ACTIVITY": "صناعة الاحذية الرجالية والولادية",
"Activity-L": "Manufacture of men\'s & children\'s shoes",
"ADRESS": "بناية علي حمدان\u001c - شارع المحقن\u001c - الغبيري - بعبدا",
"TEL1": "03/665767",
"TEL2": "01/543422",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "4474",
"com-reg-no": "1001550",
"NM": "اجيف ش م ل",
"L_NM": "AGEV sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4217",
"Industrial certificate date": "30-Jun-18",
"ACTIVITY": "مقاولات بناء وتصنيع الارمات الاعلانية والاشارات",
"Activity-L": "Building contracting & manufacture of illuminated nameplates & signs",
"ADRESS": "بناية الارز\u001c - شارع فرنيني\u001c - الاشرفية - بيروت",
"TEL1": "01/290390",
"TEL2": "01/290391",
"TEL3": "01/290392",
"internet": "info@agev.com"
},
{
"Category": "First",
"Number": "1534",
"com-reg-no": "8771",
"NM": "شركة تين وير ش م م",
"L_NM": "Teen Wear sarl",
"Last Subscription": "9-Jan-17",
"Industrial certificate no": "2554",
"Industrial certificate date": "14-Sep-17",
"ACTIVITY": "صناعة الالبسة النسائية والولادية والتريكو",
"Activity-L": "Manufacture of ladies\' & children\'s clothes & tricot",
"ADRESS": "ملك عبد القادر كريمة \u001c - شارع مدرسة القتال\u001c - حارة حريك - بعبدا",
"TEL1": "01/555632",
"TEL2": "01/555633",
"TEL3": "01/653019",
"internet": ""
},
{
"Category": "First",
"Number": "1605",
"com-reg-no": "41945",
"NM": "شركة كرتونال ش م م",
"L_NM": "Cartonal W.L.L",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "2862",
"Industrial certificate date": "20-Apr-18",
"ACTIVITY": "صناعة صناديق الفاكهة والعلب من بلاسيتك",
"Activity-L": "Manufacture of plastic boxes for fruit",
"ADRESS": "ملك جورج كرم\u001c - شارع مار الياس\u001c - الحازمية - بعبدا",
"TEL1": "05/457184",
"TEL2": "05/456696",
"TEL3": "03/241775",
"internet": "cartonal_lb@hotmail.com"
},
{
"Category": "First",
"Number": "2394",
"com-reg-no": "3737",
"NM": "مؤسسة جورج  م . عطا الله",
"L_NM": "G.M.A.",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "3687",
"Industrial certificate date": "24-Mar-18",
"ACTIVITY": "صناعة الالبسة النسائية والولادية والتريكو والجينز",
"Activity-L": "Manufacture of ladies\' & children\'s clothes, tricot & jeans",
"ADRESS": "ملك جورج مطر ط3\u001c - المسلخ - شارع كرومو\u001c - الدورة - المتن",
"TEL1": "01/250919",
"TEL2": "03/307147",
"TEL3": "03/849187",
"internet": "gattallah80@hotmail.com"
},
{
"Category": "Second",
"Number": "7008",
"com-reg-no": "10310",
"NM": "محمصة الحلباوي لصاحبها محمد علي الحلباوي",
"L_NM": "Halbawi Roastery",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4144",
"Industrial certificate date": "15-Jun-18",
"ACTIVITY": "محمصة بن وبزورات وصناعة وتعبئة الشوكولا والسكاكر",
"Activity-L": "Roastery of mixed nuts & coffee - Manufacture&packing of candies&chocolate",
"ADRESS": "ملك محمد الحلباوي\u001c - الشارع العام\u001c - حارة حريك - بعبدا",
"TEL1": "01/556316",
"TEL2": "01/556317",
"TEL3": "01/836268",
"internet": "al_helbawi@hotmail.com"
},
{
"Category": "Third",
"Number": "15993",
"com-reg-no": "63950",
"NM": "مؤسسة شومان التجارية",
"L_NM": "Chouman Trading Est",
"Last Subscription": "20-Oct-17",
"Industrial certificate no": "4746",
"Industrial certificate date": "17-Oct-18",
"ACTIVITY": "تجارة الخبز",
"Activity-L": "trading of bread",
"ADRESS": "ملك محمد الصيفي ومحمد العره\u001c - شارع سيدي حسن\u001c - البسطا الفوقا - بيروت",
"TEL1": "01/640470",
"TEL2": "01/657041",
"TEL3": "01/630810",
"internet": ""
},
{
"Category": "Third",
"Number": "16902",
"com-reg-no": "62399",
"NM": "معامل عيتاني - مركز التجمع الصناعي اللبناني ش م م",
"L_NM": "Itani Manufacturing Co. \" IMCO \" sarl",
"Last Subscription": "25-Feb-17",
"Industrial certificate no": "2415",
"Industrial certificate date": "20-Feb-18",
"ACTIVITY": "اعمال الخراطة وصناعة الادوات الصحية",
"Activity-L": "Turnery & Manufacture of sanitary articles",
"ADRESS": "ملك محي الدين عيتاني\u001c - شارع الامام ابي حنيفة\u001c - تلة الخياط - بيروت",
"TEL1": "01/788118",
"TEL2": "",
"TEL3": "",
"internet": "imco_itani@hotmail.com"
},
{
"Category": "Second",
"Number": "4476",
"com-reg-no": "25513",
"NM": "شركة يونيفرسال ميتال برودكتس ش م ل",
"L_NM": "Universal Metal Products sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "3695",
"Industrial certificate date": "27-Mar-18",
"ACTIVITY": "صناعة انابيب معدنية قابلة للطي ( لتعبئة المعاجين )",
"Activity-L": "Manufacture of empty collapsible aluminium tubes (to fill cream)",
"ADRESS": "ملك الشركة\u001c - جوار العدس - الشارع العام\u001c - شويت - بعبدا",
"TEL1": "05/555455",
"TEL2": "03/210513",
"TEL3": "",
"internet": "ump@ump.com.lb"
},
{
"Category": "First",
"Number": "2433",
"com-reg-no": "34",
"NM": "مؤسسة ابي خليل - شركة تضامن",
"L_NM": "Ets. Abi Khalil",
"Last Subscription": "23-Jan-18",
"Industrial certificate no": "202",
"Industrial certificate date": "16-Jan-19",
"ACTIVITY": "صناعة المفروشات المنزلية والمكتبية",
"Activity-L": "Manufacture of home & office furniture",
"ADRESS": "ملك ابو خليل\u001c - الشارع العام\u001c - بصاليم - المتن",
"TEL1": "04/715785",
"TEL2": "04/711785",
"TEL3": "05/920838",
"internet": "fabrics@abikhalil.com"
},
{
"Category": "Fourth",
"Number": "18917",
"com-reg-no": "5870",
"NM": "انطوان بركات",
"L_NM": "Antoine Barakat",
"Last Subscription": "2-Mar-18",
"Industrial certificate no": "4722",
"Industrial certificate date": "12-Oct-18",
"ACTIVITY": "صناعة الالبسة العسكرية - تجارة مواد وادوات التنظيف",
"Activity-L": "Manufacture of military uniforms -Trading of detergents",
"ADRESS": "بناية Forest ط4\u001c - حرش تابت\u001c - سن الفيل - المتن",
"TEL1": "01/493053",
"TEL2": "03/453293",
"TEL3": "",
"internet": "baritexe@yahoo.com"
},
{
"Category": "Excellent",
"Number": "1737",
"com-reg-no": "7958",
"NM": "ميكانيكس ش م ل",
"L_NM": "Mecanix sal",
"Last Subscription": "23-Feb-18",
"Industrial certificate no": "608",
"Industrial certificate date": "19-Mar-19",
"ACTIVITY": "صناعة ماكينات صناعية للتبريد",
"Activity-L": "Manufacture of industrial machines for cooling",
"ADRESS": "ملك الشركة\u001c - الشارع الداخلي\u001c - المكلس - المتن",
"TEL1": "05/950866",
"TEL2": "05/950867",
"TEL3": "",
"internet": "mecanix@mecanixsal.com"
},
{
"Category": "First",
"Number": "4845",
"com-reg-no": "47410",
"NM": "مؤسسة راؤوف غانم التجارية",
"L_NM": "Raouf Ghanem Trading Est",
"Last Subscription": "26-Jan-18",
"Industrial certificate no": "229",
"Industrial certificate date": "18-Jan-19",
"ACTIVITY": "تصنيع وتوضيب اللحوم",
"Activity-L": "Manufacture & packing of meat",
"ADRESS": "ملك راؤوف غانم\u001c - الشارع العام\u001c - كفرنبرخ - الشوف",
"TEL1": "03/207357",
"TEL2": "05/240255",
"TEL3": "05/240266",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1422",
"com-reg-no": "59022",
"NM": "صقر باور سيستمس ش م ل",
"L_NM": "Sakr Power Systems sal",
"Last Subscription": "3-Feb-18",
"Industrial certificate no": "279",
"Industrial certificate date": "25-Jan-19",
"ACTIVITY": "تجميع كواتم الصوت والمولدات والتابلوهات الكهربائية",
"Activity-L": " Gathering of mufflers,generators & electrical boards",
"ADRESS": "ملك صقر اندستريز لاند ش.م.م\u001c - طريق قرطبا\u001c - حالات - جبيل",
"TEL1": "09/444888",
"TEL2": "09/444777",
"TEL3": "09/444666",
"internet": "info@sakr.com"
},
{
"Category": "Third",
"Number": "18866",
"com-reg-no": "59481",
"NM": "مؤسسة ابو لبن التجارية",
"L_NM": "Abou Laban Trading Est",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "1113",
"Industrial certificate date": "23-Jan-17",
"ACTIVITY": "تجارة المنجور المعدني",
"Activity-L": "Trading of Whittled Aluminium",
"ADRESS": "ملك عبيد\u001c - المدينة الصناعية\u001c - سد البوشرية - المتن",
"TEL1": "01/500274",
"TEL2": "01/497261",
"TEL3": "03/309784",
"internet": ""
},
{
"Category": "Third",
"Number": "27230",
"com-reg-no": "39354",
"NM": "شركة مطابع عيد ش م م",
"L_NM": "Eid Printing Press sarl",
"Last Subscription": "10-Mar-18",
"Industrial certificate no": "4153",
"Industrial certificate date": "16-Jun-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "بناية رقم 90\u001c - المكلس - شارع 830 مار الياس\u001c - جسر الباشا - المتن",
"TEL1": "01/693030",
"TEL2": "01/694040",
"TEL3": "03/996639",
"internet": "info@eidpress.com"
},
{
"Category": "Fourth",
"Number": "27879",
"com-reg-no": "72113",
"NM": "فلات فاشن ش م م",
"L_NM": "Flat Fashion sarl",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4984",
"Industrial certificate date": "29-Nov-18",
"ACTIVITY": "صناعة الالبسة النسائية",
"Activity-L": "Manufacture of ladies clothes",
"ADRESS": "بناية ابي ياغي\u001c - شارع السكوني\u001c - سد البوشرية - المتن",
"TEL1": "01/894713",
"TEL2": "",
"TEL3": "",
"internet": "info@flatfashion.com"
},
{
"Category": "Fourth",
"Number": "27208",
"com-reg-no": "2035947",
"NM": "بروبك ش م م",
"L_NM": "Propack sarl",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "152",
"Industrial certificate date": "9-Jan-19",
"ACTIVITY": "مطبعة (اللواصق والاتيكيت والستيكرز)",
"Activity-L": "Printing press ( Badges,Stickers & Labels",
"ADRESS": "ملك البعيني\u001c - طريق قرطبا\u001c - حالات - جبيل",
"TEL1": "04/545171",
"TEL2": "78/800442",
"TEL3": "",
"internet": "joud@propack.me"
},
{
"Category": "Second",
"Number": "5972",
"com-reg-no": "2031948",
"NM": "كي براندس غروب ش م ل",
"L_NM": "Key - Brands Group sal",
"Last Subscription": "11-Aug-17",
"Industrial certificate no": "1617",
"Industrial certificate date": "30-Jun-16",
"ACTIVITY": "تجارة مستحضرات التجميل",
"Activity-L": "Trading of cosmetic products",
"ADRESS": "ملك ريتا بو ناصيف\u001c - شارع ربايا\u001c - زوق مصبح - كسروان",
"TEL1": "09/223595",
"TEL2": "03/884499",
"TEL3": "",
"internet": "info@keybrands-group.com"
},
{
"Category": "Fourth",
"Number": "26671",
"com-reg-no": "2032332",
"NM": "سامر للمجوهرات ش م م",
"L_NM": "Samer Jewellery sarl",
"Last Subscription": "15-Mar-17",
"Industrial certificate no": "910",
"Industrial certificate date": "15-Mar-17",
"ACTIVITY": "صناعة المصوغات وتركيب الاحجار الكريمة",
"Activity-L": "Manufacture of jewelry & assorting of presious stones",
"ADRESS": "بناية ماستر مول\u001c - حي كنيسة فارتاناتس\u001c - برج حمود - المتن",
"TEL1": "03/291223",
"TEL2": "03/510984",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "30972",
"com-reg-no": "2033774",
"NM": "انكلش كيك ش م ل",
"L_NM": "English Cake sal",
"Last Subscription": "3-Mar-17",
"Industrial certificate no": "4045",
"Industrial certificate date": "30-May-18",
"ACTIVITY": "صناعة الحلويات الافرنجية",
"Activity-L": "Manufacture of sweets",
"ADRESS": "ملك انطوان معلوف\u001c - الشارع الرئيسي\u001c - النقاش - المتن",
"TEL1": "04/523308",
"TEL2": "03/428120",
"TEL3": "",
"internet": "englishcake@hotmail.com"
},
{
"Category": "First",
"Number": "2891",
"com-reg-no": "35246",
"NM": "غولدن ديزرت - بوياجيان اخوان - شركة تضامن",
"L_NM": "Golden Desert - Boyadjian Bros",
"Last Subscription": "10-Feb-18",
"Industrial certificate no": "4416",
"Industrial certificate date": "1-Aug-18",
"ACTIVITY": "صياغة المجوهرات",
"Activity-L": "Manufacture of jewellery",
"ADRESS": "ملك بوياجيان\u001c - ساحة البلدية\u001c - برج حمود - المتن",
"TEL1": "01/267787",
"TEL2": "03/295400",
"TEL3": "03/888875",
"internet": ""
},
{
"Category": "Second",
"Number": "6288",
"com-reg-no": "61520",
"NM": "شركة سنوبيز - التاج - الحاج حسن فليفل وولديه ش م م",
"L_NM": "Snoppies Co. - Attaj - Hajj Hassan Fleifel & Sons sarl",
"Last Subscription": "23-Jan-18",
"Industrial certificate no": "3762",
"Industrial certificate date": "4-Apr-18",
"ACTIVITY": "صناعة اكياس الورق",
"Activity-L": "Manufacture of paper bags",
"ADRESS": "بناية درويش ط 9\u001c - شارع زريق\u001c - المزرعة - بيروت",
"TEL1": "01/305246",
"TEL2": "05/488585",
"TEL3": "03/393041",
"internet": "superbags40@gmail.com"
},
{
"Category": "Second",
"Number": "4642",
"com-reg-no": "45653",
"NM": "سوبريل ليبان ش م ل",
"L_NM": "Soprel Liban sal",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "4584",
"Industrial certificate date": "11-Sep-18",
"ACTIVITY": "صناعة الباطون الجاهز ومصبوبات الاسمنت",
"Activity-L": "Manufacture of ready-mixed concrete",
"ADRESS": "ملك جبور\u001c - شارع جنينة اليسوعية\u001c - الرميل - بيروت",
"TEL1": "01/567181",
"TEL2": "09/448860",
"TEL3": "09/448862",
"internet": "contact@soprel-liban.com"
},
{
"Category": "Third",
"Number": "14536",
"com-reg-no": "36040",
"NM": "شركة سليمان زهرالدين للتجارة والصناعة ش م م",
"L_NM": "Suleiman Zahreddine Co. for Trade & Industry sarl",
"Last Subscription": "27-Jul-17",
"Industrial certificate no": "4336",
"Industrial certificate date": "19-Jul-18",
"ACTIVITY": "تجارة  جملة مواد بناء وصناعة الحدادة الافرنجية",
"Activity-L": "Wholesale of building materials & smithery industry",
"ADRESS": "ملك سليمان زهر الدين\u001c - ضهور العبادية - الشارع العام\u001c - العبادية - بعبدا",
"TEL1": "05/554482",
"TEL2": "05/558649",
"TEL3": "03/898710",
"internet": ""
},
{
"Category": "Third",
"Number": "6095",
"com-reg-no": "8839",
"NM": "شركة تيفولي Tivoli للصناعة والتجارة - شركة تضامن",
"L_NM": "Tivoli",
"Last Subscription": "20-Oct-17",
"Industrial certificate no": "4521",
"Industrial certificate date": "23-Aug-18",
"ACTIVITY": "صناعة وتجارة حلويات عربية وافرنجية والبوظة",
"Activity-L": "Manufacture & trading of sweets& oriental sweets & ice cream",
"ADRESS": "ملك حافظ ابو ضرغم\u001c - بيدر الرمل\u001c - كفرحيم - الشوف",
"TEL1": "05/340440",
"TEL2": "05/340485",
"TEL3": "03/212044",
"internet": ""
},
{
"Category": "Third",
"Number": "7615",
"com-reg-no": "8181",
"NM": "شركة AM 3  للدهانات",
"L_NM": "AM 3 Paints Co. sarl",
"Last Subscription": "4-Apr-17",
"Industrial certificate no": "3710",
"Industrial certificate date": "28-Mar-18",
"ACTIVITY": "صناعة الدهانات",
"Activity-L": "Manufacture of paints",
"ADRESS": "ملك كمال الشرتوني\u001c - شارع المعامل\u001c - المكلس - المتن",
"TEL1": "01/691159",
"TEL2": "03/100334",
"TEL3": "",
"internet": "newam3@inco.com.lb"
},
{
"Category": "First",
"Number": "5296",
"com-reg-no": "2015268",
"NM": "بيكابلاست ش م ل",
"L_NM": "Bekaplast sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4223",
"Industrial certificate date": "1-Jul-18",
"ACTIVITY": "صناعة السلع البلاستيكية وتعبئة مواد في عبوات او ظروف صغيرة",
"Activity-L": "Manufacture of plastic products & filling materials in envelope(sachets)",
"ADRESS": "بناية واكيم\u001c - حي الغصون - الشارع العام\u001c - المنصورية - المتن",
"TEL1": "04/531990",
"TEL2": "04/409876",
"TEL3": "",
"internet": "info@bekaplast.com.lb"
},
{
"Category": "Fourth",
"Number": "25653",
"com-reg-no": "2030559",
"NM": "لو كوير لزر امنتيز ش م م",
"L_NM": "Le Cuir Leather Amenities sarl",
"Last Subscription": "12-Feb-18",
"Industrial certificate no": "2667",
"Industrial certificate date": "25-Jan-18",
"ACTIVITY": "صناعة الجلديات",
"Activity-L": "Manufacture of leather",
"ADRESS": "بناية مار عبدا\u001c - مار عبدا\u001c - جل الديب - المتن",
"TEL1": "01/256916",
"TEL2": "03/291717",
"TEL3": "",
"internet": "lecuirla@gmail.com"
},
{
"Category": "Second",
"Number": "6495",
"com-reg-no": "1806639",
"NM": "الشركة الايطالية للمصاعد الحديثة ش م ل - اوف شور",
"L_NM": "Italy New Lifts sal - Off Shore",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4517",
"Industrial certificate date": "22-Aug-18",
"ACTIVITY": "شركة اوف شور",
"Activity-L": "Off Shore company",
"ADRESS": "بناية بيلا كازا ملك طلال شكر\u001c - طريق المطار\u001c - برج البراجنة - بعبدا",
"TEL1": "01/450135",
"TEL2": "03/646717",
"TEL3": "",
"internet": "gm@italynewlifts.com"
},
{
"Category": "Second",
"Number": "6430",
"com-reg-no": "50563",
"NM": "شركة مصانع عساف الحديثة للرخام ش م م",
"L_NM": "Assaf Marble Company sarl",
"Last Subscription": "22-Feb-17",
"Industrial certificate no": "2119",
"Industrial certificate date": "22-Jun-17",
"ACTIVITY": "معمل لنشر وتفصيل الرخام والغرانيت والصخور",
"Activity-L": "Manufacture of marble, granite & rocks",
"ADRESS": "ملك الشركة\u001c - حي الامراء - المنطقة الصناعية\u001c - الشويفات - عاليه",
"TEL1": "05/433051",
"TEL2": "03/882332",
"TEL3": "",
"internet": "info@assafmarble.com"
},
{
"Category": "Third",
"Number": "18483",
"com-reg-no": "49325",
"NM": "الشركة اللبنانية لأعادة التصنيع ش م م",
"L_NM": "Lebanese Recycling Works L.R.W. sarl",
"Last Subscription": "27-Mar-17",
"Industrial certificate no": "2917",
"Industrial certificate date": "29-Nov-17",
"ACTIVITY": "فرم مرتجعات ونفايات البلاستيك",
"Activity-L": "Chopping of plastic wastes",
"ADRESS": "ملك الدبس\u001c - المنطقة الصناعية - الشارع العام\u001c - روميه - المتن",
"TEL1": "03/659065",
"TEL2": "01/888057",
"TEL3": "01/890383",
"internet": "eliodebs@hotmail.com"
},
{
"Category": "Excellent",
"Number": "278",
"com-reg-no": "14156",
"NM": "شركة ماتيليك ش م ل",
"L_NM": "Matelec sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4164",
"Industrial certificate date": "19-Jun-18",
"ACTIVITY": "صناعة معدات كهربائية مختلفة (محولات ومقويات ...)",
"Activity-L": "Manufacture of electrical equipments(transformers...)",
"ADRESS": "ملك الياس ضومط\u001c - الشارع العام\u001c - غرفين - جبيل",
"TEL1": "09/620920",
"TEL2": "",
"TEL3": "",
"internet": "matelec@matelecgroup.com"
},
{
"Category": "First",
"Number": "3415",
"com-reg-no": "32647",
"NM": "ميوركس اندستريز اند ترايدنغ ش م ل",
"L_NM": "Murex Industries and Trading sal",
"Last Subscription": "23-May-17",
"Industrial certificate no": "1915",
"Industrial certificate date": "18-May-18",
"ACTIVITY": "صناعة اغطية المراحيض والمغاطس",
"Activity-L": "Manufacture of sanitary articles (cover)",
"ADRESS": "ملك الشركة\u001c - ماربطرس كرم التين الشارع العام\u001c - بيت شباب - المتن",
"TEL1": "04/711812+3",
"TEL2": "04/985688",
"TEL3": "03/651505",
"internet": "murex@murex.com.lb"
},
{
"Category": "First",
"Number": "3745",
"com-reg-no": "56558",
"NM": "قصعة غروب للدهانات ش م ل",
"L_NM": "Kassa\'a Paints Group sal",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4960",
"Industrial certificate date": "1-Dec-18",
"ACTIVITY": "صناعة الدهانات",
"Activity-L": "Manufacture of paints",
"ADRESS": "ملك محمد قصعة\u001c - شارع ابي شهلا\u001c - وطى المصيطبة - بيروت",
"TEL1": "01/305649",
"TEL2": "01/303414",
"TEL3": "01/306966",
"internet": "kassaa@kassaa.com"
},
{
"Category": "First",
"Number": "4534",
"com-reg-no": "28434",
"NM": "مركز الطباعة الحديثة ش م م",
"L_NM": "Modern Printing Center sarl",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4126",
"Industrial certificate date": "13-Jun-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "بناية عازار\u001c - شارع توماس اديسون\u001c - الرملة البيضاء - بيروت",
"TEL1": "01/867504",
"TEL2": "01/868353",
"TEL3": "01/802112",
"internet": ""
},
{
"Category": "Second",
"Number": "4495",
"com-reg-no": "3091",
"NM": "قره بت جابوطيان للصاغة والمجوهرات",
"L_NM": "Garabed K. Jabotian Jewellery",
"Last Subscription": "19-Jan-17",
"Industrial certificate no": "434",
"Industrial certificate date": "22-Feb-19",
"ACTIVITY": "صناعة المجوهرات",
"Activity-L": "Manufacture of jewelry",
"ADRESS": "ملك جابوطيان \u001c - كمب امانوس - شارع مار مارون\u001c - البوشرية  - المتن",
"TEL1": "01/249000",
"TEL2": "01/267200",
"TEL3": "03/615717",
"internet": "garo@lorajewelry.com"
},
{
"Category": "Fourth",
"Number": "27234",
"com-reg-no": "2031258",
"NM": "شركة اوتوميت - توصية بسيطة",
"L_NM": "Automate",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "399",
"Industrial certificate date": "19-Feb-19",
"ACTIVITY": "صناعة اللوحات الكهربائية",
"Activity-L": "Manufacture of electrical Boards",
"ADRESS": "ملك جورج وهبي\u001c - حي دكان الضهر\u001c - حبالين - جبيل",
"TEL1": "09/735699",
"TEL2": "03/609706",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1776",
"com-reg-no": "29391",
"NM": "مارتون اندستريز ش م م",
"L_NM": "Marton Industries sarl",
"Last Subscription": "22-Apr-17",
"Industrial certificate no": "4350",
"Industrial certificate date": "21-Jul-18",
"ACTIVITY": "صناعة انشاءات المعدنية",
"Activity-L": "Manufacture of metal structures",
"ADRESS": "ملك الحكيم\u001c - شارع الوادي الصناعي\u001c - عين سعاده - المتن",
"TEL1": "01/498316",
"TEL2": "01/510624",
"TEL3": "01/510625",
"internet": "marton@cyberia.net.lb"
},
{
"Category": "First",
"Number": "4998",
"com-reg-no": "26709",
"NM": "التجمع الصناعي اللبناني ش م م",
"L_NM": "Lebanese Industrial Group sarl",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "214",
"Industrial certificate date": "17-Jan-19",
"ACTIVITY": "صناعة الدهانات لزوم السيارات والاليات",
"Activity-L": "Manufacture of paints for vehicles",
"ADRESS": "ملك الشركة\u001c - شارع الكسارات\u001c - اده - جبيل",
"TEL1": "09/945992",
"TEL2": "09/945993",
"TEL3": "",
"internet": "ligsprint@gmail.com"
},
{
"Category": "First",
"Number": "2740",
"com-reg-no": "26021",
"NM": "الشركة الصناعية للتغليف ش م م",
"L_NM": "Société Industrielle de Conditionnement sarl",
"Last Subscription": "19-Jan-17",
"Industrial certificate no": "3726",
"Industrial certificate date": "30-Mar-18",
"ACTIVITY": "تجارة مواد التنظيف والكاتشاب والبهارات والسكر والملح  بالظروف المغلفة",
"Activity-L": "Trading of detergents, ketchup,spices, sugar & salt in sachet",
"ADRESS": "بناية معوض ملك شوقي شرابية\u001c - الشارع العام\u001c - الفنار - المتن",
"TEL1": "01/878155",
"TEL2": "01/878228",
"TEL3": "01/900239",
"internet": "sic@cyberia.net.lb"
},
{
"Category": "Third",
"Number": "18966",
"com-reg-no": "45415",
"NM": "مؤسسة مقصود التجارية ش م م",
"L_NM": "Maksoud Trading Est sarl",
"Last Subscription": "2-Feb-18",
"Industrial certificate no": "250",
"Industrial certificate date": "22-Jan-19",
"ACTIVITY": "صناعة فناجين وكبايات وصحون من الكرتون والورق",
"Activity-L": "Manufacture of paper & carton cups & dishes",
"ADRESS": "ملك سهيلا الشمالي\u001c - حريصا - الشارع العام\u001c - درعون - كسروان",
"TEL1": "03/614540",
"TEL2": "01/399311",
"TEL3": "03/384848",
"internet": "maksoud@inco.com.lb"
},
{
"Category": "Second",
"Number": "4200",
"com-reg-no": "9",
"NM": "شركة باريسيس للهندسة المعدنية والمقاولات ش م م",
"L_NM": "Parissis Steel Engineering & Contracting Co. sarl",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4222",
"Industrial certificate date": "1-Jul-18",
"ACTIVITY": "اعمال الحدادة الافرنجية",
"Activity-L": "Smithery",
"ADRESS": "ملك لامبسوس\u001c - حي بوليكاريوس - شارع ارمينيا\u001c - برج حمود - المتن",
"TEL1": "01/260125",
"TEL2": "01/260126",
"TEL3": "01/258137",
"internet": "parissis@parissis.com"
},
{
"Category": "Fourth",
"Number": "27971",
"com-reg-no": "1014549",
"NM": "نجم للرخام والمصبوبات ش م م",
"L_NM": "Najem for Marble and Agglomerates sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "3834",
"Industrial certificate date": "11-Jul-18",
"ACTIVITY": "مصنعا لنشر الصخور والاحجار",
"Activity-L": "Sawing of rocks & stone industry",
"ADRESS": "مبنى بلس سنترا \u001c - حي حبيش - شارع بلس\u001c - رأس بيروت - بيروت",
"TEL1": "01/363101",
"TEL2": "",
"TEL3": "",
"internet": "info@marbleandcement.com"
},
{
"Category": "First",
"Number": "5341",
"com-reg-no": "6293",
"NM": "الشركة الصناعية للغاز - يونيغاز ش م ل",
"L_NM": "Indusrial Gaz Company \" Unigaz\" sal",
"Last Subscription": "20-May-17",
"Industrial certificate no": "2925",
"Industrial certificate date": "1-Dec-17",
"ACTIVITY": "تعبئة الغاز",
"Activity-L": "Filling of gas",
"ADRESS": "بناية اكسا للتأمين ط 4\u001c - شارع روما\u001c - كليمنصو - بيروت",
"TEL1": "01/241111",
"TEL2": "01/241891+3",
"TEL3": "03/524111",
"internet": "info@unigaz.net"
},
{
"Category": "Excellent",
"Number": "1426",
"com-reg-no": "18094",
"NM": "ميتسوليفت لبنان ش م ل",
"L_NM": "Mitsulift Lebanon sal",
"Last Subscription": "14-Mar-18",
"Industrial certificate no": "4754",
"Industrial certificate date": "20-Apr-18",
"ACTIVITY": "صناعة وتجميع المصاعد الكهربائية والسلالم المتحركة",
"Activity-L": "Manufacture and gathering of electrical elevators and escalators",
"ADRESS": "ملك سمير ونبيل ابي اللمع\u001c - زوق الخراب\u001c - الضبيه - المتن",
"TEL1": "04/542802+9",
"TEL2": "03/499336",
"TEL3": "03/499337",
"internet": "info@mitsulift.com"
},
{
"Category": "First",
"Number": "913",
"com-reg-no": "36963",
"NM": "شركة مؤسسة خاطر اخوان وشركاهم ش م م",
"L_NM": "Khater Bros Est.& Co sarl",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "4490",
"Industrial certificate date": "14-Aug-18",
"ACTIVITY": "تعبئة وتوضيب الحبوب والمكابيس والزيوت",
"Activity-L": "Packing of cereals, pickles&oils - Farming of cattles",
"ADRESS": "بناية حمد\u001c - شارع الماما\u001c - تلة الخياط - بيروت",
"TEL1": "01/815136",
"TEL2": "01/815137",
"TEL3": "",
"internet": "khaterjamil64@gamil.com"
},
{
"Category": "Excellent",
"Number": "157",
"com-reg-no": "266",
"NM": "شركة الغوريتم ش م ل",
"L_NM": "Algorithm sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "3569",
"Industrial certificate date": "9-Mar-18",
"ACTIVITY": "صناعة الادوية الطبية",
"Activity-L": "Manufacture of medicines",
"ADRESS": "ملك الشركة\u001c - الشارع الرئيسي\u001c - زوق مصبح - كسروان",
"TEL1": "09/222050+1",
"TEL2": "09/222052+3",
"TEL3": "09/222054+5",
"internet": "sjghorayeb@algorithm-lb.com"
},
{
"Category": "Second",
"Number": "1003",
"com-reg-no": "7727",
"NM": "شركة عصير لبنان ش م ل",
"L_NM": "Liban - Jus sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "645",
"Industrial certificate date": "21-Mar-19",
"ACTIVITY": "صناعة العصير والالبان والاجبان والبوظة",
"Activity-L": "Manufacture of juice, dairy products & ice cream",
"ADRESS": "بناية غاريوس\u001c - شارع كميل شمعون\u001c - الحدث - بعبدا",
"TEL1": "05/465662",
"TEL2": "05/465663",
"TEL3": "05/467111",
"internet": "libanjus@dm.net.lb"
},
{
"Category": "Excellent",
"Number": "1588",
"com-reg-no": "33873",
"NM": "شاتو موزار ش م ل",
"L_NM": "Chateau Musar sal",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "50",
"Industrial certificate date": "19-Dec-18",
"ACTIVITY": "صناعة النبيذ، العرق والخل",
"Activity-L": "Manufacture of wine, arrack & vinegar",
"ADRESS": "بناية سونيكو\u001c - شارع بارودي\u001c - الاشرفية - بيروت",
"TEL1": "01/201828",
"TEL2": "01/328211",
"TEL3": "01/328200",
"internet": "info@chateaumusar.com.lb"
},
{
"Category": "Excellent",
"Number": "11",
"com-reg-no": "75",
"NM": "شركة ذي كورال اويل كومباني ليمتد",
"L_NM": "The Coral Oil Company Ltd",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "3475",
"Industrial certificate date": "25-Feb-18",
"ACTIVITY": "مشغلا لمزج وتعبئة الزيوت والتنر وتجارة جملة مشتقات نفطية وزيوت معدنية",
"Activity-L": "Manufacture of lubricants & tinner - Wholesale of fuel & lubricants",
"ADRESS": "ملك الشركة\u001c - شارع الشل\u001c - برج حمود - المتن",
"TEL1": "01/241871",
"TEL2": "03/368834",
"TEL3": "01/241873",
"internet": "coralbo@dm.net.lb"
},
{
"Category": "First",
"Number": "4884",
"com-reg-no": "34385",
"NM": "شركة تريباك للصناعات الغذائية ش م ل",
"L_NM": "Tripak Food Industries sal",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "3727",
"Industrial certificate date": "30-Mar-18",
"ACTIVITY": "صناعة وتعبئة العصير والكاتشاب",
"Activity-L": "Manufacture & packing of soft drinks & ketchup",
"ADRESS": "بناية الاسود\u001c - شارع المعماري\u001c - الحمراء - بيروت",
"TEL1": "05/433633+4",
"TEL2": "05/950820",
"TEL3": "03/227800",
"internet": "tripak@tripak.com"
},
{
"Category": "Excellent",
"Number": "1312",
"com-reg-no": "50475",
"NM": "غارف غروب - شركة تضامن",
"L_NM": "Garff Group",
"Last Subscription": "4-Apr-17",
"Industrial certificate no": "1579",
"Industrial certificate date": "4-Mar-18",
"ACTIVITY": "معملا للطباعة الحريرية على الاصناف الدعائية من الورق والمعدن والبلاستيك",
"Activity-L": "Factory of silk printing on promotional articles",
"ADRESS": "بناية غارف غروب\u001c - روميه - شارع النزهة\u001c - عين سعاده - المتن",
"TEL1": "01/889888",
"TEL2": "01/888585",
"TEL3": "01/902280",
"internet": "garff@garffgroup.com"
},
{
"Category": "Second",
"Number": "4804",
"com-reg-no": "2029913",
"NM": "داكسيان",
"L_NM": "Dakessian",
"Last Subscription": "16-Feb-18",
"Industrial certificate no": "4652",
"Industrial certificate date": "28-Sep-18",
"ACTIVITY": "صياغة المجوهرات",
"Activity-L": "Manufacture of jewellery",
"ADRESS": "ملك بطركية الارمن الكاثوليك\u001c - كمب مرعش\u001c - برج حمود - المتن",
"TEL1": "03/273831",
"TEL2": "01/259732",
"TEL3": "01/259733",
"internet": "dakessian@dakessian.com"
},
{
"Category": "Third",
"Number": "17823",
"com-reg-no": "36813",
"NM": "مؤسسة رزق للصناعة والتجارة ش م م",
"L_NM": "Rizk Industry & Trade Est. ltd",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "4635",
"Industrial certificate date": "20-Sep-18",
"ACTIVITY": "صناعة اتيكيت ورولو ورق لماكينات التسعير وتقطيع وتغليف ورق منوع",
"Activity-L": "Manufacture of stickers & cutting & binding of paper",
"ADRESS": "ملك رزق\u001c - الشارع الرئيسي\u001c - درعون - كسروان",
"TEL1": "09/263770",
"TEL2": "09/263780",
"TEL3": "03/221370",
"internet": "info@riklabel.com"
},
{
"Category": "First",
"Number": "5136",
"com-reg-no": "10283",
"NM": "مطاحن الشهباء ش م م",
"L_NM": "Shahba Mills sarl",
"Last Subscription": "20-Jan-18",
"Industrial certificate no": "3965",
"Industrial certificate date": "13-May-18",
"ACTIVITY": "مطاحن للحنطة ومشتقاتها",
"Activity-L": "Mills of wheat",
"ADRESS": "ملك شبارق\u001c - عين السكه - شارع جمال عبد الناصر\u001c - برج البراجنة - بعبدا",
"TEL1": "01/450216+7",
"TEL2": "01/792346+7",
"TEL3": "01/450218",
"internet": "shahbamills@shabarekgroup.com"
},
{
"Category": "Second",
"Number": "6061",
"com-reg-no": "22666",
"NM": "شركة رياشي للتجارة والمقاولات ش م م",
"L_NM": "Riachi Trading & Contracting Co. sarl",
"Last Subscription": "15-Feb-18",
"Industrial certificate no": "353",
"Industrial certificate date": "7-Feb-19",
"ACTIVITY": "مطحنة حبوب وتجارة جملة المواد غذائية",
"Activity-L": "Mill of cereal, Wholesale of foodstuffs",
"ADRESS": "ملك رياشي\u001c - الشارع العام\u001c - الخنشاره - المتن",
"TEL1": "04/295944",
"TEL2": "03/745666",
"TEL3": "01/898541",
"internet": "riachi@dm.net.lb"
},
{
"Category": "Second",
"Number": "609",
"com-reg-no": "2693",
"NM": "شركة خير الله للموبيليا - خير الله اخوان",
"L_NM": "Société d\'Ameublement Khairallah - Khairallah Frères",
"Last Subscription": "16-Dec-17",
"Industrial certificate no": "4959",
"Industrial certificate date": "1-Dec-18",
"ACTIVITY": "صناعة وتجارة المفروشات الخشبية",
"Activity-L": "Manufacture & trading of wooden furniture",
"ADRESS": "ملك الشركة\u001c - ضهر الوحش\u001c - عاريا - بعبدا",
"TEL1": "05/768080",
"TEL2": "05/768181",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "24968",
"com-reg-no": "338",
"NM": "مؤسسة ابناء لويس عبجي",
"L_NM": "Etablissement les Fils de Louis Abaji",
"Last Subscription": "25-Aug-17",
"Industrial certificate no": "1957",
"Industrial certificate date": "28-May-14",
"ACTIVITY": "تجارة  الواح خشب",
"Activity-L": "Trading of wood",
"ADRESS": "ملك شركة عبيد للاخشاب ش م ل\u001c - المنطقة الصناعية\u001c - كفرشيما - بعبدا",
"TEL1": "03/300133",
"TEL2": "",
"TEL3": "",
"internet": "abaji-el@inco.com.lb"
},
{
"Category": "Excellent",
"Number": "347",
"com-reg-no": "10633",
"NM": "شركة ينابيع مياه تنورين اللبنانية ش م ل - تنورين",
"L_NM": "Société Libanaise des Sources des Eaux de Tannourine sal",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "3025",
"Industrial certificate date": "18-Dec-18",
"ACTIVITY": "تعبئة المياه المعدنية",
"Activity-L": "Bottling of mineral water",
"ADRESS": "ملك شركة انفسكو ش م ل\u001c - جسر الباشا\u001c - الحازمية - بعبدا",
"TEL1": "05/955777",
"TEL2": "03/611671",
"TEL3": "03/338639",
"internet": "tannourine@tannourine.com"
},
{
"Category": "Third",
"Number": "6540",
"com-reg-no": "39563",
"NM": "شركة فلوطي التجارية فتكوم ش م م",
"L_NM": "Flouty Trading Company Ltd. -F.T. Com. Ltd",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "4829",
"Industrial certificate date": "2-Nov-18",
"ACTIVITY": "معملا لأنتاج التنر",
"Activity-L": "Manufacture of tinner",
"ADRESS": "ملك ايلي صعب\u001c - جادة الاستقلال\u001c - الاشرفية - بيروت",
"TEL1": "01/877160",
"TEL2": "01/877161",
"TEL3": "01/877162+3",
"internet": "ftc@flouty.com"
},
{
"Category": "Fourth",
"Number": "11894",
"com-reg-no": "64664",
"NM": "شركة بدر وشركاه للألبسة - توصية بسيطة",
"L_NM": "Badr & Co. for Clothes",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4740",
"Industrial certificate date": "17-Oct-18",
"ACTIVITY": "صناعة البسة رجالية",
"Activity-L": "Manufacture of men\'s clothes",
"ADRESS": "بناية حبلي\u001c - شارع ميشال دعيبس\u001c - برج ابي حيدر - بيروت",
"TEL1": "01/700702",
"TEL2": "01/302446",
"TEL3": "03/882872",
"internet": "issambadre@hotmail.com"
},
{
"Category": "Excellent",
"Number": "634",
"com-reg-no": "22105",
"NM": "غازوتك للصناعات ش م ل",
"L_NM": "Gazetec Industries Co. sal",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "099",
"Industrial certificate date": "26-Dec-18",
"ACTIVITY": "تعبئة غازات كيماوية ومنظفات ومواد لتعقيم المياه",
"Activity-L": "Filling of chemical gas, detergents & materials for sterilization of water",
"ADRESS": "ملك الشركة\u001c - المدينة الصناعية\u001c - عين سعاده - المتن",
"TEL1": "01/885495",
"TEL2": "01/885496",
"TEL3": "03/663712",
"internet": "gazetec@dm.net.lb"
},
{
"Category": "Excellent",
"Number": "1738",
"com-reg-no": "51944",
"NM": "مؤسسة عساف للدهانات",
"L_NM": "Ets. Assaf pour le Peinture",
"Last Subscription": "12-Jan-17",
"Industrial certificate no": "1150",
"Industrial certificate date": "28-Jan-17",
"ACTIVITY": "صناعة الدهانات",
"Activity-L": "Manufacture of paints",
"ADRESS": "ملك سامي عساف\u001c - نهر الموت - الشارع العام\u001c - عين سعاده - المتن",
"TEL1": "01/897550",
"TEL2": "01/892799",
"TEL3": "03/635996",
"internet": "assafsamy@hotmail.com"
},
{
"Category": "Excellent",
"Number": "1759",
"com-reg-no": "836",
"NM": "فلوريد المنيوم",
"L_NM": "Florid Aluminium",
"Last Subscription": "2-Feb-18",
"Industrial certificate no": "282",
"Industrial certificate date": "25-Jan-19",
"ACTIVITY": "صناعة الاشغال المعدنية والخشبية والالمنيوم",
"Activity-L": "Manufacture of metallic carpentry, wooden & aluminium works",
"ADRESS": "ملك البطريركية المارونية\u001c - الشارع العام\u001c - الحازمية - بعبدا",
"TEL1": "05/450375",
"TEL2": "05/456270",
"TEL3": "05/456271",
"internet": "rharb@floridgroup.com"
},
{
"Category": "Third",
"Number": "25038",
"com-reg-no": "13845",
"NM": "مطبعة الحرية - شركة تضامن",
"L_NM": "Imprimerie Al Huriyat",
"Last Subscription": "1-Feb-17",
"Industrial certificate no": "3997",
"Industrial certificate date": "18-May-18",
"ACTIVITY": "اعمال الطباعة والتجليد",
"Activity-L": "Printing & binding services",
"ADRESS": "ملك ناصيف بجاني\u001c - شارع المطران مسّرة\u001c - الاشرفية - بيروت",
"TEL1": "01/218112",
"TEL2": "01/320440",
"TEL3": "",
"internet": "alhuriat@inco.com.lb"
},
{
"Category": "Excellent",
"Number": "288",
"com-reg-no": "59630",
"NM": "الشركة العامة لصناعات الالمنيوم - الوكسال ش م ل",
"L_NM": "The General Co. for Aluminium Extrusion - Aluxal - sal",
"Last Subscription": "15-Jan-18",
"Industrial certificate no": "4571",
"Industrial certificate date": "5-Sep-18",
"ACTIVITY": "معملا لسحب البروفيلات وزوايا الالمنيوم",
"Activity-L": "Drawing of aluminium profiles",
"ADRESS": "ملك الشركة\u001c - حي الامراء - شارع التيرو\u001c - الشويفات - عاليه",
"TEL1": "05/480406",
"TEL2": "05/480407",
"TEL3": "05/480408+9",
"internet": "aluxal@inco.com.lb"
},
{
"Category": "Excellent",
"Number": "1158",
"com-reg-no": "6382",
"NM": "شركة قاسم محفوظ واولاده - محفوظ ستورز - تضامن",
"L_NM": "Kassem Mahfouz & Sons Co. - Mahfouz Stores - K.M.B",
"Last Subscription": "10-Feb-17",
"Industrial certificate no": "2169",
"Industrial certificate date": "28-Jun-17",
"ACTIVITY": "صناعة وتجارة التريكو والكلسات والالبسة الرجالية والنسائية والولادية",
"Activity-L": "Manufacture&Trading  of tricot, socks & men\'s, ladies\' & children\'s clothes",
"ADRESS": "ملك ابناء قاسم محفوظ\u001c - شارع المقدسي\u001c - الحمراء - بيروت",
"TEL1": "05/433399",
"TEL2": "01/552465",
"TEL3": "03/210121",
"internet": "alimahfz@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "1767",
"com-reg-no": "27841",
"NM": "ارشيتكترال الومنيوم تكنيكس - أ.أ.ث - ش م ل",
"L_NM": "Architectural Aluminium Technics -A.A.T- sal",
"Last Subscription": "14-Mar-17",
"Industrial certificate no": "3572",
"Industrial certificate date": "9-Mar-18",
"ACTIVITY": "صناعة منجورات وواجهات المنيوم",
"Activity-L": "Manufacture of aluminium panellings",
"ADRESS": "ملك الشركة\u001c - حي المعامل\u001c - روميه - المتن",
"TEL1": "01/888981",
"TEL2": "01/888982",
"TEL3": "",
"internet": "aat@cyberia.net.lb"
},
{
"Category": "First",
"Number": "276",
"com-reg-no": "11279",
"NM": "شركة شتال المساهمة ش م ل",
"L_NM": "Stal sal",
"Last Subscription": "20-Apr-17",
"Industrial certificate no": "1812",
"Industrial certificate date": "3-May-17",
"ACTIVITY": "حدادة افرنجية وصناعة منجورات المنيوم",
"Activity-L": "Smithery & manufacture of aluminiun panelling",
"ADRESS": "ملك الشركة\u001c - المنصورية - الشارع العام\u001c - بيت مري - المتن",
"TEL1": "04/400400",
"TEL2": "04/409272",
"TEL3": "04/400399",
"internet": "info@stal-me.com"
},
{
"Category": "Third",
"Number": "29385",
"com-reg-no": "2030330",
"NM": "شركة حلباوي التجارية ش م م",
"L_NM": "Helbawi Trading Company sarl",
"Last Subscription": "8-Dec-17",
"Industrial certificate no": "4430",
"Industrial certificate date": "4-Aug-18",
"ACTIVITY": "طحن وتعبئة البهارات والحبوب",
"Activity-L": "Grinding & filling of spices & cereals",
"ADRESS": "بناية النجاة ملك الحلباوي\u001c - حي الصنوبرة - الشارع العام\u001c - الشياح - بعبدا",
"TEL1": "03/221203",
"TEL2": "03/639144",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "6063",
"com-reg-no": "63113",
"NM": "اوميغا بنتس ش م م",
"L_NM": "Omega Paints sarl",
"Last Subscription": "16-Feb-18",
"Industrial certificate no": "4817",
"Industrial certificate date": "4-Mar-18",
"ACTIVITY": "صناعة الدهانات",
"Activity-L": "Manufacture of paints",
"ADRESS": "ملك الشركة - الشارع العام- عين عنوب- عاليه",
"TEL1": "01/820590",
"TEL2": "01/855916",
"TEL3": "03/464707",
"internet": "m.maatouk@omegapaints.com"
},
{
"Category": "Excellent",
"Number": "1320",
"com-reg-no": "52741",
"NM": "Salam Orfevres",
"L_NM": "Salam Orfevres",
"Last Subscription": "10-May-17",
"Industrial certificate no": "3801",
"Industrial certificate date": "11-Apr-18",
"ACTIVITY": "صناعة وتفضيض الاواني المنزلية",
"Activity-L": "Manufacture of sliverware",
"ADRESS": "ملك الشركة\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/497484",
"TEL2": "01/500277",
"TEL3": "01/481312",
"internet": "salamorfevres@gmail.com"
},
{
"Category": "Second",
"Number": "1723",
"com-reg-no": "16350",
"NM": "شركة رياشي للصناعة والتجارة - روبير رياشي وشركاه",
"L_NM": "Société Riachi Pour L\'industrie Et Le Commerce - Robert Riachi et Co",
"Last Subscription": "3-Jul-17",
"Industrial certificate no": "4198",
"Industrial certificate date": "28-Jun-18",
"ACTIVITY": "صناعة المشروبات الروحية و النبيذ والخل",
"Activity-L": "Manufacture of alcoholic drinks, wine & vinegar",
"ADRESS": "ملك رياشي\u001c - شارع مار انطونيوس\u001c - الخنشاره - المتن",
"TEL1": "01/442245",
"TEL2": "04/442522",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "17815",
"com-reg-no": "46673",
"NM": "مؤسسة روجه يارد التجارية",
"L_NM": "Sani Air of America",
"Last Subscription": "18-Jan-17",
"Industrial certificate no": "4623",
"Industrial certificate date": "19-Sep-18",
"ACTIVITY": "لتصنيع وتعبئة العطورات",
"Activity-L": "Trading of perfumes & cosmetics",
"ADRESS": "ملك رحباني\u001c - شارع الدكتور سلهب\u001c - انطلياس - المتن",
"TEL1": "01/495874",
"TEL2": "03/889391",
"TEL3": "",
"internet": "saniair@inco.com.lb"
},
{
"Category": "Second",
"Number": "5957",
"com-reg-no": "24493",
"NM": "شركة أ. شاهين للحلويات ش م م",
"L_NM": "A. Chahine Sweets Co. sarl",
"Last Subscription": "11-May-17",
"Industrial certificate no": "3927",
"Industrial certificate date": "6-May-18",
"ACTIVITY": "صناعة الحلاوة والطحينة والراحة والنوغا والملبن وتحميص وتعبئة السمسم والسكر",
"Activity-L": "Manufacture of halawa,tahina,&turkish delight, packing of sesame&sugar",
"ADRESS": "ملك الشركة\u001c - الشارع العام\u001c - حصرايل - جبيل",
"TEL1": "09/790437",
"TEL2": "03/270234",
"TEL3": "09/790559",
"internet": "info@eshahin.com"
},
{
"Category": "Excellent",
"Number": "1010",
"com-reg-no": "51335",
"NM": "نافكو اينوكس ش م ل",
"L_NM": "Nafco Inox sal",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "3835",
"Industrial certificate date": "18-Apr-18",
"ACTIVITY": "صناعة الالات الصناعية الغذائية",
"Activity-L": "Manufacture of industrial food machinery",
"ADRESS": "ملك الشركة\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/497066",
"TEL2": "01/487468",
"TEL3": "01/502823",
"internet": "soussani@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "124",
"com-reg-no": "7421",
"NM": "شركة خطيب اخوان - الحذاء الاحمر ش م ل",
"L_NM": "Khatib Bros Co. Red Shoe sal",
"Last Subscription": "14-Mar-17",
"Industrial certificate no": "3576",
"Industrial certificate date": "9-Mar-18",
"ACTIVITY": "صناعة وتجارة الاحذية الولادية والرجالية والنسائية",
"Activity-L": "Manufacture & trading of children\'s, men\'s & ladies\' shoes",
"ADRESS": "ملك محمد كجك\u001c - كورنيش المزرعة\u001c - المصيطبة - بيروت",
"TEL1": "07/970030+31",
"TEL2": "07/970032",
"TEL3": "07/970033",
"internet": "redshoe@dm.net.lb"
},
{
"Category": "First",
"Number": "909",
"com-reg-no": "13993",
"NM": "راك للورق والكرتون ش م ل",
"L_NM": "Rak Paper & Board sal",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "598",
"Industrial certificate date": "15-Mar-19",
"ACTIVITY": "معملا لتقطيع الورق والكرتون",
"Activity-L": "Manufacture: Cutting of paper & carton",
"ADRESS": "ملك الشركة\u001c - حي الزعيترية\u001c - الفنار- المتن",
"TEL1": "01/694444",
"TEL2": "01/697474",
"TEL3": "03/697474",
"internet": "rak@rak-paperboard.com"
},
{
"Category": "Excellent",
"Number": "289",
"com-reg-no": "33301",
"NM": "ترابة سبلين ش م ل",
"L_NM": "Ciment de Sibline sal",
"Last Subscription": "31-Jan-18",
"Industrial certificate no": "4588",
"Industrial certificate date": "12-Sep-18",
"ACTIVITY": "معمل انتاج الاسمنت",
"Activity-L": "Manufacture of cement products",
"ADRESS": "بناية التجارة والمال\u001c - شارع الجيش\u001c - القنطاري - بيروت",
"TEL1": "01/365690+1",
"TEL2": "07/970097",
"TEL3": "03/230023+25",
"internet": "cds@cimentdesibline.com.lb"
},
{
"Category": "Second",
"Number": "354",
"com-reg-no": "10645",
"NM": "الكونسروة الحديثة شتورة ش م ل",
"L_NM": "Conserves Modernes Chtaura sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "2665",
"Industrial certificate date": "2-Oct-18",
"ACTIVITY": "صناعة وتجارة جملة المواد الغذائية المعلبة",
"Activity-L": "Manufacture and wholesale of canned foodstuffs",
"ADRESS": "بناية الاسود ط 1\u001c - شارع عبد العزيز\u001c - الحمراء - بيروت",
"TEL1": "01/348542",
"TEL2": "01/350378",
"TEL3": "01/343104+1",
"internet": "export@chtaura.com"
},
{
"Category": "First",
"Number": "776",
"com-reg-no": "2608/23212",
"NM": "شركة ايليا نخله مطر واولاده - جان مطر وشريكه",
"L_NM": "Sté Elie N. Mattar & Fils",
"Last Subscription": "7-Mar-18",
"Industrial certificate no": "4226",
"Industrial certificate date": "3-Jul-18",
"ACTIVITY": "معمل لصب البلاط ونشر وجلي الصخور والرخام",
"Activity-L": "Manufacture of tiles & cutting & polishing of rocks & marble",
"ADRESS": "ملك وقف الروم\u001c - شارع سليمان البستاني\u001c - وطى المصيطبة - بيروت",
"TEL1": "01/702431",
"TEL2": "03/729472",
"TEL3": "01/702435",
"internet": "info@mattargroup.com"
},
{
"Category": "Excellent",
"Number": "1857",
"com-reg-no": "27337",
"NM": "شركة اكسبرس انترناشيونال  ش م ل",
"L_NM": "Express International sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4290",
"Industrial certificate date": "12-Jul-18",
"ACTIVITY": "اعمال الطباعة والتجليد",
"Activity-L": "Printing & binding services",
"ADRESS": "بناية مختار حجعلي\u001c - شارع اليس الفرد نقاش\u001c - رملة البيضاء - بيروت",
"TEL1": "01/803300",
"TEL2": "01/866195",
"TEL3": "03/338058",
"internet": "diary@expressinternational.com"
},
{
"Category": "First",
"Number": "3520",
"com-reg-no": "54482",
"NM": "مؤسسة فينو بلاست للتجارة والصناعة",
"L_NM": "Fino Plast For Trade & Industry",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "093",
"Industrial certificate date": "26-Dec-18",
"ACTIVITY": "صناعة اكياس الورق والنايلون",
"Activity-L": "Manufacture of paper & nylon bags",
"ADRESS": "ملك علي احمد خليل\u001c - الشارع العام\u001c - الدبيه - الشوف",
"TEL1": "07/995421",
"TEL2": "07/995422",
"TEL3": "07/995423",
"internet": "finoplast_factory@hotmail.com"
},
{
"Category": "Third",
"Number": "3912",
"com-reg-no": "6427",
"NM": "حنا الصايغ واولاده",
"L_NM": "Hanna Sayegh & Sons",
"Last Subscription": "26-Jan-18",
"Industrial certificate no": "4080",
"Industrial certificate date": "6-May-18",
"ACTIVITY": "صناعة الزيوت والصابون والطحينة وراحة الحلقوم وجرش وطحن الحبوب",
"Activity-L": "Manufacture of oil, soap, tahina & turkish delight & grinding of cereals",
"ADRESS": "بناية الصحناوي\u001c - شارع المارسيلياز\u001c - المرفأ - بيروت",
"TEL1": "01/681236",
"TEL2": "01/681235",
"TEL3": "",
"internet": "sayegh4@cyberia.net.lb"
},
{
"Category": "Second",
"Number": "4515",
"com-reg-no": "56787",
"NM": "مؤسسة نزيه كركي",
"L_NM": "Nazih Karaky Est",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "201",
"Industrial certificate date": "16-Jan-19",
"ACTIVITY": "مطبعة وتصنيع علب الكرتون والطباعة الحريرية",
"Activity-L": "Printing press & manufacture of carton boxes",
"ADRESS": "بناية جميل ابراهيم\u001c - شارع مدام كوري\u001c - قريطم - بيروت",
"TEL1": "01/862500",
"TEL2": "01/860951+2",
"TEL3": "01/806420",
"internet": "print@karaky.com"
},
{
"Category": "Second",
"Number": "6656",
"com-reg-no": "51717",
"NM": "شركة باتيسري أ. بحصلي وشركاه ش م ل",
"L_NM": "Patisserie A. Bohsali & Co.sal",
"Last Subscription": "1-Feb-18",
"Industrial certificate no": "1558",
"Industrial certificate date": "22-Mar-17",
"ACTIVITY": "صناعة الحلويات العربية والبوظه",
"Activity-L": "Manufacture of oriental sweets, ice cream",
"ADRESS": "بناية يونس\u001c - شارع الفرد نوبل\u001c - الحمراء - بيروت",
"TEL1": "01/745322",
"TEL2": "01/785566",
"TEL3": "",
"internet": "info@abohsali.com.lb"
},
{
"Category": "First",
"Number": "4020",
"com-reg-no": "29142",
"NM": "شركة عيتاني للطباعة والتجارة - شركة تضامن",
"L_NM": "Itani Printing & Trading - IPT",
"Last Subscription": "30-Jan-17",
"Industrial certificate no": "2439",
"Industrial certificate date": "19-Aug-17",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing Press",
"ADRESS": "مبنى طبارة\u001c - شارع العرداتي\u001c - رأس بيروت - بيروت",
"TEL1": "01/740901",
"TEL2": "01/740902",
"TEL3": "01/740903",
"internet": "mail@ipt.com.lb"
},
{
"Category": "First",
"Number": "5157",
"com-reg-no": "69030",
"NM": "سيلور",
"L_NM": "Silor",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "3306",
"Industrial certificate date": "6-Mar-18",
"ACTIVITY": "صناعة الاواني النحاسية والمفضضة",
"Activity-L": "Manufacture of brassware and Silverplated",
"ADRESS": "ملك طوروسيان\u001c - شارع البدوي\u001c - الرميل - بيروت",
"TEL1": "01/585449",
"TEL2": "01/581933",
"TEL3": "03/710703",
"internet": "silorleb@gmail.com"
},
{
"Category": "Third",
"Number": "12478",
"com-reg-no": "54138",
"NM": "شركة موزاييك ش م ل",
"L_NM": "Mosaique sal",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "4364",
"Industrial certificate date": "24-Jul-18",
"ACTIVITY": "تجارة المفروشات الخشبية والاشغال الحرفية من نحاسيات",
"Activity-L": "Trading of furniture & copper artisanal Items",
"ADRESS": "بناية مكرزل\u001c - شارع زهرة الاحسان\u001c - فرن الحايك - بيروت",
"TEL1": "04/862194",
"TEL2": "04/964288",
"TEL3": "03/635050",
"internet": "info@maisontarazi.com"
},
{
"Category": "Excellent",
"Number": "1011",
"com-reg-no": "54696",
"NM": "م.ا.غ. ميدل ايست غرانيت ش م ل",
"L_NM": "M.E.G. Middle East Granite sal",
"Last Subscription": "23-Aug-17",
"Industrial certificate no": "4511",
"Industrial certificate date": "21-Nov-17",
"ACTIVITY": "معملا لنشر بلوكات الغرانيت بشكل الواح مختلفة القياسات واعمال التلميع",
"Activity-L": " Manufacture of cutting & polishing the Granite",
"ADRESS": "ملك الاوقاف الدرزية\u001c - الشارع العام\u001c - بعورته - عاليه",
"TEL1": "05/601337",
"TEL2": "03/337887",
"TEL3": "",
"internet": "info@meg-stones.com"
},
{
"Category": "Third",
"Number": "29032",
"com-reg-no": "50922",
"NM": "بوداقيان",
"L_NM": "Boudakian",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4681",
"Industrial certificate date": "6-Oct-18",
"ACTIVITY": "صناعة البسة رجالية والبسة مهنية",
"Activity-L": "Manufacture of men\'s clothes  & workwear",
"ADRESS": "بناية 650 الرميل ط 1\u001c - شارع النهر\u001c - مار مخايل - بيروت",
"TEL1": "01/570500+2",
"TEL2": "01/681100",
"TEL3": "01/682200",
"internet": "accounting@bodakian.biz"
},
{
"Category": "First",
"Number": "4832",
"com-reg-no": "39173",
"NM": "شركة مطاحن الجنوب الكبرى - ماركة الديك ش م م",
"L_NM": "Great South Mills - El Dick Brand sarl",
"Last Subscription": "12-Oct-17",
"Industrial certificate no": "4680",
"Industrial certificate date": "6-Oct-18",
"ACTIVITY": "مطحنة لطحن الحبوب والحنطة",
"Activity-L": "Grain Mill",
"ADRESS": "ملك حطيط\u001c - شارع جنبلاط\u001c - سبلين - الشوف",
"TEL1": "01/868181+2",
"TEL2": "07/970444",
"TEL3": "",
"internet": "hoteit@cyberia.net.lb"
},
{
"Category": "First",
"Number": "4984",
"com-reg-no": "26021",
"NM": "تكنيكا انترناشيونال ش م ل",
"L_NM": "Technica International sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4509",
"Industrial certificate date": "21-Aug-18",
"ACTIVITY": "صناعة الآت ومعدات صناعية والرافعات",
"Activity-L": "Manufacture of industrial machinery, equipments & cranes",
"ADRESS": "ملك حداد\u001c - المدينة الصناعية \u001c - بكفيا - المتن",
"TEL1": "04/982224",
"TEL2": "04/986466",
"TEL3": "",
"internet": "tony.haddad@technicaintl.com"
},
{
"Category": "Excellent",
"Number": "287",
"com-reg-no": "37956",
"NM": "شركة شاتو كساره ش م ل",
"L_NM": "Chateau Ksara sal",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "3880",
"Industrial certificate date": "8-Feb-19",
"ACTIVITY": "صناعة النبيذ والمشروبات الروحية",
"Activity-L": "Manufacture of wine & alcoholic drinks",
"ADRESS": "بناية نخله حنا\u001c - جادة شارل مالك\u001c - التباريس - بيروت",
"TEL1": "01/200715",
"TEL2": "08/813495",
"TEL3": "",
"internet": "info@ksara.com.lb"
},
{
"Category": "Excellent",
"Number": "321",
"com-reg-no": "11657",
"NM": "كروسري ابي اللمع ش م ل",
"L_NM": "Carrosserie Abillama sal",
"Last Subscription": "31-Jan-17",
"Industrial certificate no": "2648",
"Industrial certificate date": "5-Oct-17",
"ACTIVITY": "صناعة هياكل سيارات وبرادات نقل وباصات واشغال حديدية منوعة",
"Activity-L": "Manufacture of cars, cooling trucks & buses bodies &iron works",
"ADRESS": "ملك ابي اللمع\u001c - زوق الخراب\u001c - الضبيه - المتن",
"TEL1": "04/542810",
"TEL2": "04/542811",
"TEL3": "04/542812",
"internet": "info@abillama.net"
},
{
"Category": "First",
"Number": "3128",
"com-reg-no": "43430",
"NM": "شركة خضر فليفل الصناعية ش م م - فليكو",
"L_NM": "K. Fleifel Ind. Co. sarl",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4997",
"Industrial certificate date": "7-Dec-18",
"ACTIVITY": "صناعة مفروشات مكتبية معدنية وخشبية",
"Activity-L": "Manufacture of metallic & wooden office furniture",
"ADRESS": "ملك خضر فليفل\u001c - برج ابي حيدر\u001c - بيروت",
"TEL1": "01/817444",
"TEL2": "01/310717",
"TEL3": "01/313000",
"internet": "fleifel@fleifel.com"
},
{
"Category": "First",
"Number": "2188",
"com-reg-no": "191",
"NM": "معامل لافلوكس الصناعية - احمد عطايا",
"L_NM": "Usine Laveluxe Industrielle - A. Ataya",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "242",
"Industrial certificate date": "22-Jan-19",
"ACTIVITY": "صناعة الصابون ومواد التنظيف والخل والحامض وماء الزهر والورد وشرابات",
"Activity-L": "Man. of soap,detergent,alcohol,vinegar, flower orange& rose water&beverages",
"ADRESS": "ملك احمد عطايا\u001c - حي الشقيف - شارع الجندي المجهول\u001c - حارة الناعمة - الشوف",
"TEL1": "05/600006",
"TEL2": "03/215888",
"TEL3": "03/379555",
"internet": "info@yamama-lb.com"
},
{
"Category": "Excellent",
"Number": "1375",
"com-reg-no": "54293",
"NM": "شركة الاوكسيجين والاسيتيلان في لبنان ش م ل SOAL",
"L_NM": "Société D\'oxygène et D\'acetylene du Liban sal SOAL",
"Last Subscription": "1-Feb-18",
"Industrial certificate no": "2312",
"Industrial certificate date": "9-May-18",
"ACTIVITY": "معمل اوكسيجين والازوت والارغون (غاز سائل) وتجارة جملة قناني غاز الاستيلين",
"Activity-L": "Manuf. of oxygen, acetylene & liquid gas/Wholesale of Acetylene Gas bottles",
"ADRESS": "ملك الشركة\u001c - شارع الميدان\u001c - الدكوانة - المتن",
"TEL1": "01/692380+81",
"TEL2": "01/692382+83",
"TEL3": "01/692384+85",
"internet": "manal.barhoum@airliquide.com"
},
{
"Category": "First",
"Number": "383",
"com-reg-no": "61243",
"NM": "شركة مرج الصناعية ش م ل",
"L_NM": "Marge Industrial Co. sal",
"Last Subscription": "20-Apr-17",
"Industrial certificate no": "3711",
"Industrial certificate date": "28-Mar-18",
"ACTIVITY": "معمل لنشر وجلي الرخام",
"Activity-L": "Manufacture of marbles",
"ADRESS": "ملك الشركة\u001c - خلف ليسيكو\u001c - كفرشيما - بعبدا",
"TEL1": "05/430440",
"TEL2": "05/430686",
"TEL3": "",
"internet": "mic-lebanon@hotmail.com"
},
{
"Category": "Second",
"Number": "5993",
"com-reg-no": "36263",
"NM": "روبرتس كروب ش م ل",
"L_NM": "Robert\'s Group sal",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "3525",
"Industrial certificate date": "2-Mar-18",
"ACTIVITY": "صناعة ماكينات كهربائية ( فليبر) والكترونية للتسلية",
"Activity-L": "Manufacture of electrical & electronic machines for amusement",
"ADRESS": "بناية بول دور\u001c - الاوتوستراد\u001c - زوق مكايل - كسروان",
"TEL1": "09/211461",
"TEL2": "09/211462",
"TEL3": "09/211463",
"internet": "robgroup@terra.net.lb"
},
{
"Category": "Fourth",
"Number": "15130",
"com-reg-no": "41955",
"NM": "مؤسسة تايجون لصناعة وتجارة الفراشي",
"L_NM": "Tigon Est. for the Production and Commerce of  Brushes",
"Last Subscription": "23-Nov-17",
"Industrial certificate no": "2271",
"Industrial certificate date": "12-Feb-18",
"ACTIVITY": "صناعة الفراشي للدهان وتجارة جملة البويا",
"Activity-L": "Manufacture of brushes for paint - Wholesale of paints",
"ADRESS": "ملك بهيجه وهبي\u001c - شارع عبد الغني العريسي\u001c - النويري - بيروت",
"TEL1": "01/656090",
"TEL2": "01/654188",
"TEL3": "03/208743+4",
"internet": "tigon@inco.com.lb"
},
{
"Category": "Third",
"Number": "16865",
"com-reg-no": "45932",
"NM": "الشركة العالمية للمعادن ش م م",
"L_NM": "International Metal Company I.M.C sarl",
"Last Subscription": "29-Jan-18",
"Industrial certificate no": "3438",
"Industrial certificate date": "21-Feb-18",
"ACTIVITY": "تجارة صفائح معدنية وبطاريات للسيارات",
"Activity-L": "Trading of metal Sheets & Batteries for motor Vehicles",
"ADRESS": "ملك جورج حجيلي\u001c - شارع البحر\u001c - برج حمود - المتن",
"TEL1": "03/788388",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1762",
"com-reg-no": "45823",
"NM": "واتر ماستر ش م م",
"L_NM": "Water Master sarl",
"Last Subscription": "30-Mar-17",
"Industrial certificate no": "4040",
"Industrial certificate date": "29-May-18",
"ACTIVITY": "تجارة جملة اجهزة التكييف وتجميع وتركيب فلاتر المياه",
"Activity-L": "Wholesale of air-conditions & gathering of water filters",
"ADRESS": "ملك الشركة\u001c - السيوفي - شارع اخوان الصفا\u001c - الاشرفية - بيروت",
"TEL1": "01/422905",
"TEL2": "01/612197",
"TEL3": "01/612698",
"internet": "contact@watermaster.com.lb"
},
{
"Category": "Third",
"Number": "17528",
"com-reg-no": "47639",
"NM": "مانوتك ش م م",
"L_NM": "Manutech sarl",
"Last Subscription": "17-Jan-17",
"Industrial certificate no": "4758",
"Industrial certificate date": "20-Oct-18",
"ACTIVITY": " معملا لصنع آلات لاستعمالات صناعية مختلفة",
"Activity-L": "Manufacture of other special purpose machinery",
"ADRESS": "ملك منير يوسف كامل\u001c - شارع الشل\u001c - برج حمود - المتن",
"TEL1": "01/241394",
"TEL2": "01/241398",
"TEL3": "",
"internet": "manutech@terra.net.lb"
},
{
"Category": "Excellent",
"Number": "1916",
"com-reg-no": "55257",
"NM": "شركة مطبعة انيس التجارية ش م ل",
"L_NM": "Anis Commercial Printing Press sal",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "4924",
"Industrial certificate date": "23-Nov-18",
"ACTIVITY": "اعمال الطباعة",
"Activity-L": "Printing services",
"ADRESS": "ملك الاشقر\u001c - طلعة العكاوي - مفرق مدرسة الحكمة\u001c - الحكمة - بيروت",
"TEL1": "01/561510",
"TEL2": "01/561512+13",
"TEL3": "03/274005",
"internet": "gihad@anispress.com"
},
{
"Category": "Second",
"Number": "3209",
"com-reg-no": "63260",
"NM": "شركة تاج الملوك ش م م",
"L_NM": "Taj El Moulouk sarl",
"Last Subscription": "27-Dec-17",
"Industrial certificate no": "087",
"Industrial certificate date": "21-Dec-18",
"ACTIVITY": "صناعة وتجارة الحلويات العربية",
"Activity-L": "Manufacture & trading of sweets",
"ADRESS": "بناية الداعوق\u001c - شارع بلس\u001c - المناره - بيروت",
"TEL1": "01/365797",
"TEL2": "01/365795",
"TEL3": "01/755780",
"internet": "tajalmoulouk@hotmail.com"
},
{
"Category": "Excellent",
"Number": "1562",
"com-reg-no": "56801",
"NM": "شركة عبد الرزاق عيتاني واولاده ش م م",
"L_NM": "Arison sarl - Abdul Razzak Itani & Sons",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "3353",
"Industrial certificate date": "11-Feb-18",
"ACTIVITY": "صناعة المضخات المائية والمولدات كهربائية",
"Activity-L": "Manufacture of pumps & electrical generators",
"ADRESS": "ملك عبد الرزاق عيتاني\u001c - شارع تقي الدين الصلح\u001c - قريطم - بيروت",
"TEL1": "01/793900",
"TEL2": "01/864824",
"TEL3": "03/287936",
"internet": "arison@arison.com.lb"
},
{
"Category": "Excellent",
"Number": "222",
"com-reg-no": "2751/23355",
"NM": "شركة اتحاد مصانع ورق السيكارا - صبحي وصلاح الدين الشربجي وشركاهم ش م ل",
"L_NM": "Association des Fabriques de Papier A Cigarettes",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "2737",
"Industrial certificate date": "4-Apr-18",
"ACTIVITY": "صناعة ورق السجائر وماكينات للف السيجارة",
"Activity-L": "Manufacture of cigarette paper & machines",
"ADRESS": "ملك الشركة\u001c - جسر الباشا - شارع القلعة\u001c - سن الفيل - المتن",
"TEL1": "01/498772",
"TEL2": "01/500295",
"TEL3": "01/498823",
"internet": "afpc@inco.com.lb"
},
{
"Category": "Excellent",
"Number": "961",
"com-reg-no": "36615",
"NM": "رباط للصناعة Rabbath Industrie - شركة تضامن",
"L_NM": "Rabbath Industrie",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "3738",
"Industrial certificate date": "1-Apr-18",
"ACTIVITY": "صناعة دفاتر مدرسية وورق لعب وسجائر واكياس",
"Activity-L": "Manufacture of copy books, playing cards, cigarette paper & bags",
"ADRESS": "ملك اتحاد مصانع ورق السيكارة\u001c - جسر الباشا\u001c - سن الفيل - المتن",
"TEL1": "01/500295",
"TEL2": "",
"TEL3": "01/498772",
"internet": "afpc@inco.com.lb"
},
{
"Category": "First",
"Number": "798",
"com-reg-no": "720",
"NM": "شركة صناعة الادوية للشرق الاوسط - مفيكو - ش م ل",
"L_NM": "Middle East Pharmaceutical & Industrial Co. Mephico - sal",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "4419",
"Industrial certificate date": "2-Aug-18",
"ACTIVITY": "صناعة المستحضرات الطبية والصيدلانية",
"Activity-L": "Manufacture of medical & pharmaceutical products",
"ADRESS": "ملك الشركة\u001c - طريق الشام\u001c - الجمهور - بعبدا",
"TEL1": "05/769600",
"TEL2": "05/769602",
"TEL3": "03/290504",
"internet": "info@mephico.me"
},
{
"Category": "First",
"Number": "589",
"com-reg-no": "24766",
"NM": "فيليتكس ش م ل",
"L_NM": "Filitex sal",
"Last Subscription": "2-Feb-18",
"Industrial certificate no": "272",
"Industrial certificate date": "24-Jan-19",
"ACTIVITY": "صناعة غزل ونسج الخيوط وصناعة الالبسة الداخلية",
"Activity-L": "Weaving of textile & manufacture of underwear",
"ADRESS": "ملك الشركة\u001c - تجاه دير يسوع الملك\u001c - زوق مصبح - كسروان",
"TEL1": "09/219290",
"TEL2": "09/219293+4",
"TEL3": "09/212107",
"internet": "info@filitex.com"
},
{
"Category": "Second",
"Number": "5935",
"com-reg-no": "38426",
"NM": "SM - داليا Dalia",
"L_NM": "SM Dalia",
"Last Subscription": "9-Jun-17",
"Industrial certificate no": "4055",
"Industrial certificate date": "1-Jun-18",
"ACTIVITY": "صناعة وتوضيب المأكولات والمعجنات المبردة",
"Activity-L": "Manufacture & packing of frozen food & pastries",
"ADRESS": "ملك صليبا\u001c - حي السنسال - متفرع من الشارع العام\u001c - جبيل",
"TEL1": "03/259008",
"TEL2": "09/946027",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "6076",
"com-reg-no": "29814",
"NM": "معامل امين كنفاني - شركة توصية بسيطة",
"L_NM": "Amine Kanafani Factories",
"Last Subscription": "10-Feb-18",
"Industrial certificate no": "4205",
"Industrial certificate date": "29-Jun-18",
"ACTIVITY": "معمل بلاط ونشر الصخور والرخام",
"Activity-L": "Manufacture of tiles, marbles & rocks",
"ADRESS": "ملك محمد امين كنفاني\u001c - الليلكي - شارع الكرامة\u001c - المريجة - بعبدا",
"TEL1": "01/310115",
"TEL2": "03/814814",
"TEL3": "03/217165",
"internet": "kanmarmi@cyberia.net.lb"
},
{
"Category": "Second",
"Number": "6048",
"com-reg-no": "56720",
"NM": "شركة فن الطباعة ش م م",
"L_NM": "Société Fan Attiba\'a sarl",
"Last Subscription": "7-Mar-18",
"Industrial certificate no": "3874",
"Industrial certificate date": "25-Apr-18",
"ACTIVITY": "صناعة وطباعة علب الكرتون واكياس ورق",
"Activity-L": "Manufacture & printing of carton boxes & paper bags",
"ADRESS": "ملك خليل\u001c - الشارع العام\u001c - عين سعاده - المتن",
"TEL1": "01/878454",
"TEL2": "01/878455+6",
"TEL3": "03/333987",
"internet": "info@fanattibaa.com"
},
{
"Category": "Excellent",
"Number": "1933",
"com-reg-no": "20123",
"NM": "شركة المطبعة العربية ش م ل",
"L_NM": "Arab Printing Press sal",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "4487",
"Industrial certificate date": "14-Aug-18",
"ACTIVITY": "اعمال الطباعة والتجليد",
"Activity-L": "Printing & binding services",
"ADRESS": "ملك الشركة\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/497393",
"TEL2": "01/510050",
"TEL3": "03/453470",
"internet": "app@arab-printing-press.com"
},
{
"Category": "First",
"Number": "4981",
"com-reg-no": "41618",
"NM": "غولدن بايبر ش م م",
"L_NM": "Golden Paper sarl",
"Last Subscription": "2-Mar-18",
"Industrial certificate no": "4394",
"Industrial certificate date": "28-Jul-18",
"ACTIVITY": "صناعة الورق",
"Activity-L": "Manufacture of paper",
"ADRESS": "ملك كمال حداد\u001c - منطقة ضهر الجمل\u001c - سن الفيل - المتن",
"TEL1": "01/259683+4",
"TEL2": "03/216796",
"TEL3": "03/216797",
"internet": "goldpape@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "1306",
"com-reg-no": "7995",
"NM": "امكو انجينيرنغ ش م م",
"L_NM": "Emco Engineering Ltd",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "3533",
"Industrial certificate date": "4-Mar-18",
"ACTIVITY": "تعهدات الهندسة المدنية وصناعة اجهزة لتنقية ومعالجة المياه وصناعة البراغي",
"Activity-L": "Engineering studies & manufacture of purifying machines & of fasteners",
"ADRESS": "بناية كيروز\u001c - شارع د. هنري صعب\u001c - الحازمية - بعبدا",
"TEL1": "05/452010+11",
"TEL2": "05/459943",
"TEL3": "05/457482",
"internet": "emco@emco.com.lb"
},
{
"Category": "First",
"Number": "782",
"com-reg-no": "24261/3657",
"NM": "شركة ليون اندستريز ش م م",
"L_NM": "Leon Industries sarl",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4977",
"Industrial certificate date": "5-Dec-18",
"ACTIVITY": "صناعة تجهيزات المطابخ للمطاعم والفنادق",
"Activity-L": "Manufacture of machinery for restaurants",
"ADRESS": "ملك خليفه\u001c - شارع غورو\u001c - المدور - بيروت",
"TEL1": "09/219360",
"TEL2": "09/212314",
"TEL3": "03/302736",
"internet": "info@leonindustries.net"
},
{
"Category": "Excellent",
"Number": "1033",
"com-reg-no": "36523",
"NM": "شركة الرخام والمصبوبات الاسمنتية ش م ل",
"L_NM": "Marble And Cement Products sal",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "3620",
"Industrial certificate date": "23-Oct-18",
"ACTIVITY": "صناعة وتجارة للرخام والمصبوبات الاسمنتية",
"Activity-L": "Manufacture & trading of marble & cement products",
"ADRESS": "ملك وقف الروم\u001c - شارع سليمان البستاني\u001c - وطى المصيطبة - بيروت",
"TEL1": "01/303420",
"TEL2": "01/702149",
"TEL3": "01/702150",
"internet": "info@marbleandcement.com"
},
{
"Category": "First",
"Number": "3549",
"com-reg-no": "15684",
"NM": "جنرال باكيجينغ اندستريز  جي. بي. اي. ش م م",
"L_NM": "General Packaging Industries - G.P.I - sarl",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4545",
"Industrial certificate date": "12-May-18",
"ACTIVITY": "صناعة لفائف ورق المنيوم وشوك وملاعق وسكاكين بلاستيك والمنيوم وكرتون",
"Activity-L": "Manufacture of aluminium foils, plastic, aluminium & carton products",
"ADRESS": "ملك عبود\u001c - الشارع الرئيسي\u001c - بكفيا - المتن",
"TEL1": "04/921300",
"TEL2": "04/921301",
"TEL3": "04/928990",
"internet": "prch@gpilebanon.com"
},
{
"Category": "Fourth",
"Number": "903",
"com-reg-no": "20258",
"NM": "معمل القاطرجي للبلاستيك",
"L_NM": "Katerji Plastics Factory",
"Last Subscription": "23-May-17",
"Industrial certificate no": "3982",
"Industrial certificate date": "16-May-18",
"ACTIVITY": "صناعة القطع والخردوات البلاستيكية (حاملة مفاتيح…)",
"Activity-L": "Manufacture of plastic products (Key Holder…)",
"ADRESS": "ملك ابراهيم ويوسف ومليح قاطرجي\u001c - شارع الرواس\u001c - طريق الجديدة - بيروت",
"TEL1": "01/316083",
"TEL2": "03/811921",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "3752",
"com-reg-no": "11018",
"NM": "معمل شوكولا لاروش - شركة تضامن",
"L_NM": "La Roche Chocolate Factory",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "3791",
"Industrial certificate date": "10-Apr-18",
"ACTIVITY": "صناعة السكاكر والشوكولا",
"Activity-L": "Manufacture of chocolate & candies",
"ADRESS": "ملك علي وحسين عساف\u001c - شارع راغب علامة\u001c - الغبيري - بعبدا",
"TEL1": "01/540667",
"TEL2": "01/541667",
"TEL3": "03/230667",
"internet": "laroche@larochechocolate.com"
},
{
"Category": "Third",
"Number": "1094",
"com-reg-no": "26988",
"NM": "شركة مغازل جبل لبنان",
"L_NM": "Filature du Mont Liban",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4805",
"Industrial certificate date": "30-Oct-18",
"ACTIVITY": "معملا للغزل والحياكة القطنية والحرير الاصطناعي وتصنيع فيلتر للسجائر",
"Activity-L": "Weaving of cotton & silk - manufacture of filter cigarette",
"ADRESS": "ملك الشركة\u001c - شارع السيدة\u001c - الزلقا - المتن",
"TEL1": "01/893713",
"TEL2": "01/893721",
"TEL3": "03/605713",
"internet": ""
},
{
"Category": "Second",
"Number": "1492",
"com-reg-no": "14583",
"NM": "شركة اوجمكو - شركة تضامن",
"L_NM": "Société Ojamco",
"Last Subscription": "14-Mar-18",
"Industrial certificate no": "022",
"Industrial certificate date": "12-Dec-18",
"ACTIVITY": "تجارة جملة ادوات منزلية مطبخية وصناعة اكياس االنايلون",
"Activity-L": "Wholesale of kitchenware & manufacture of nylon bags",
"ADRESS": "ملك ادمون جمال\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/688219",
"TEL2": "01/681190",
"TEL3": "03/015292",
"internet": "ojamco@ojamco.com.lb"
},
{
"Category": "Excellent",
"Number": "1809",
"com-reg-no": "49977",
"NM": "ذ. م. لصناعة الزيوت النباتية ش م ل",
"L_NM": "Z.M.Vegetable Oils Industries sal",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "4318",
"Industrial certificate date": "15-Jul-18",
"ACTIVITY": "استخراج الزيوت النباتية وتكريرها",
"Activity-L": "Extraction of refined vegetable oils",
"ADRESS": "ملك شركة مطاحن الدورة\u001c - برج حمود\u001c - الدورة - المتن",
"TEL1": "01/252577",
"TEL2": "01/252578",
"TEL3": "09/219378",
"internet": "sinnoam@dm.net.lb"
},
{
"Category": "Third",
"Number": "4246",
"com-reg-no": "242",
"NM": "مطابع لونا ش م م",
"L_NM": "Luna Press sarl",
"Last Subscription": "19-Aug-17",
"Industrial certificate no": "4482",
"Industrial certificate date": "12-Aug-18",
"ACTIVITY": "مطبعة - طباعة على البلاستيك والنايلون",
"Activity-L": "Printing press - Printing on plastic & nylon",
"ADRESS": "ملك الشركة\u001c - المدينة الصناعية\u001c - زوق مصبح - كسروان",
"TEL1": "09/219828+29",
"TEL2": "09/219830+31",
"TEL3": "",
"internet": "info@luna-press.com"
},
{
"Category": "Fourth",
"Number": "26382",
"com-reg-no": "2024584",
"NM": "روكي بلاست ش م ل",
"L_NM": "Roky Plast sal",
"Last Subscription": "10-Feb-18",
"Industrial certificate no": "3912",
"Industrial certificate date": "3-May-18",
"ACTIVITY": "صناعة مواد اولية بلاستيكية ( حبيبات )",
"Activity-L": "Manufacture of plastic in primary forms ( Granule )",
"ADRESS": "بناية خوري\u001c - الشارع الرئيسي\u001c - بلاط - جبيل",
"TEL1": "03/634400",
"TEL2": "09/795666",
"TEL3": "",
"internet": "rokyplast@rokyplast.com"
},
{
"Category": "Third",
"Number": "7058",
"com-reg-no": "38577",
"NM": "شركة نجار للصناعة ش م م",
"L_NM": "Naggiar Industries sarl",
"Last Subscription": "2-Feb-17",
"Industrial certificate no": "3739",
"Industrial certificate date": "1-Jul-17",
"ACTIVITY": "صناعة الات صناعية وزراعية وهندسية",
"Activity-L": "Manufacture of industrial, agricultural & engineering machinery",
"ADRESS": "بناية صالومي ط ارضي\u001c - شارع المسلخ\u001c - المدور - بيروت",
"TEL1": "01/449224",
"TEL2": "01/444895",
"TEL3": "03/247085",
"internet": "naggiar@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "1700",
"com-reg-no": "3998",
"NM": "شركة قيصر دباس واولاده ش م ل",
"L_NM": "Cesar Debbas & Fils sal",
"Last Subscription": "2-Feb-18",
"Industrial certificate no": "2250",
"Industrial certificate date": "10-Feb-18",
"ACTIVITY": "صناعة تابلوهات كهربائية وثريات، تجارة جملة ادوات منزلية كهربائية وانارة",
"Activity-L": "Manu.of electrical board, chandeliers & wholesale of elec. home appliances",
"ADRESS": "بناية دباس \u001c - كورنيش النهر\u001c - الاشرفية - بيروت",
"TEL1": "01/562306",
"TEL2": "01/585000",
"TEL3": "01/444470",
"internet": "cdf@debbas.com.lb"
},
{
"Category": "Excellent",
"Number": "1427",
"com-reg-no": "37868",
"NM": "سانيتا ش م ل",
"L_NM": "Sanita sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "3148",
"Industrial certificate date": "22-Jan-19",
"ACTIVITY": "صناعة المحارم، الورق والفوط الصحية، الحفاضات وورق ورولو النايلون والالمنيوم",
"Activity-L": "Manufacture of napkins, protection adhesives& diapers,Aluminium&Nylon foils",
"ADRESS": "ملك الشركة\u001c - الشارع العام\u001c - حالات - جبيل",
"TEL1": "09/477001",
"TEL2": "",
"TEL3": "",
"internet": "managements@sanitalb.com"
},
{
"Category": "Excellent",
"Number": "1333",
"com-reg-no": "16287",
"NM": "شركة تصنيع المفروشات والبلاستيك - فاب ش م م",
"L_NM": "Furniture & Plastic Industries - FAP sarl",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "413",
"Industrial certificate date": "20-Feb-19",
"ACTIVITY": "معمل للأسفنج والفرشات الاسفنجية والرفاصية وخياطة اللحف والبرادي والمخدات",
"Activity-L": "Manufacture of sponge, mattresses, pillow & curtains",
"ADRESS": "ملك الشدراوي\u001c - الشارع العام\u001c - حصرايل - جبيل",
"TEL1": "09/790970+72",
"TEL2": "09/790830+32",
"TEL3": "03/600217+19",
"internet": "fap@fapindustries.com"
},
{
"Category": "Excellent",
"Number": "1631",
"com-reg-no": "3952",
"NM": "شركة مكر للصناعة ش م ل",
"L_NM": "Société Meker pour L\' Industrie sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "3803",
"Industrial certificate date": "11-Apr-18",
"ACTIVITY": "صناعة المطابخ والابواب والسقوفيات الخشبية والمعدنية",
"Activity-L": "Manufacture of wooden & metallic kitchen, doors & ceiling",
"ADRESS": "ملك شركة مكر للصناعة ش م ل\u001c - جسر الواطي\u001c - سن الفيل - المتن",
"TEL1": "01/492566",
"TEL2": "01/493177",
"TEL3": "03/616498",
"internet": "meker@dm.net.lb"
},
{
"Category": "First",
"Number": "1780",
"com-reg-no": "29142",
"NM": "ساغا كونسبت ش م ل",
"L_NM": "Saga Concept sal",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4723",
"Industrial certificate date": "16-Oct-18",
"ACTIVITY": "صناعة العطور ومواد التجميل والمنظفات وتجارة جملة المشروبات الروحية",
"Activity-L": "Manufacture of perfumes,cosmetics,detergents& Wholesale of alcoholic drinks",
"ADRESS": "ملك الشركة\u001c - المنطقة الصناعية\u001c - عين سعاده - المتن",
"TEL1": "01/897450",
"TEL2": "01/872421",
"TEL3": "01/872422",
"internet": "admin@sagaconcept.com"
},
{
"Category": "First",
"Number": "777",
"com-reg-no": "2206/22810",
"NM": "شركة ابناء سليم شامات - شركة تضامن",
"L_NM": "Ste. Fils Selim Chamat",
"Last Subscription": "12-Jul-17",
"Industrial certificate no": "4215",
"Industrial certificate date": "30-Jun-18",
"ACTIVITY": "معمل صب احجار البلاط والموزاييك ونشر الصخور والرخام",
"Activity-L": "Manufacture of tiles, mosaic & marble",
"ADRESS": "ملك وقف الروم\u001c - شارع البستاني\u001c - وطى المصيطبة - بيروت",
"TEL1": "01/301681",
"TEL2": "01/301867",
"TEL3": "01/301091",
"internet": ""
},
{
"Category": "First",
"Number": "2570",
"com-reg-no": "42928",
"NM": "جاني سيكس",
"L_NM": "Jany Six",
"Last Subscription": "3-Feb-17",
"Industrial certificate no": "3449",
"Industrial certificate date": "22-Feb-18",
"ACTIVITY": "صناعة الالبسة النسائية",
"Activity-L": "Manufacture of ladies\' clothes",
"ADRESS": "بناية برج الحرية\u001c - شارع يزبك\u001c - المصيطبة - بيروت",
"TEL1": "01/816845",
"TEL2": "01/300874",
"TEL3": "03/800509",
"internet": "info@saidmidani.com"
},
{
"Category": "First",
"Number": "3475",
"com-reg-no": "66960",
"NM": "منى كول ش م م - مياه طبيعية نقية",
"L_NM": "Mona Cool sarl -Pure Natural Water",
"Last Subscription": "28-Jan-17",
"Industrial certificate no": "2720",
"Industrial certificate date": "26-Jan-18",
"ACTIVITY": "تعبئة وتجارة المياه ضمن اوعية خاصة",
"Activity-L": "Filling &Trading of water with special contaniers",
"ADRESS": "بناية النخيل\u001c -  شارع سليم سلام\u001c - برج ابي حيدر - بيروت",
"TEL1": "01/844300+1",
"TEL2": "01/844302+3",
"TEL3": "01/844304",
"internet": "monacool@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "1504",
"com-reg-no": "30",
"NM": "محمد خليل الداعوق ش م ل",
"L_NM": "Mohamed Khalil Daouk sal",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "4799",
"Industrial certificate date": "26-Oct-18",
"ACTIVITY": "قص وتقطيع وتوضيب الورق والكرتون",
"Activity-L": "Cutting & packing of paper & paperboard",
"ADRESS": "ملك نبيه الداعوق واخوانه\u001c - شارع الحلواني\u001c - الصنائع - بيروت",
"TEL1": "01/737785",
"TEL2": "01/737786",
"TEL3": "01/753560",
"internet": "mkdaouk@mkdaouk.com"
},
{
"Category": "Excellent",
"Number": "435",
"com-reg-no": "20219",
"NM": "كوزمالين ش م ل",
"L_NM": "Cosmaline sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4532",
"Industrial certificate date": "24-Aug-18",
"ACTIVITY": "صناعة قناني بلاستيكية ومعاجين حلاقة واسنان وشامبو والمنظفات",
"Activity-L": "Manufacture of plastic bottles,shampoo,toothpaste,shaving cream&detergents",
"ADRESS": "ملك ش. صراف وشركاه  ش م ل\u001c - عمارة شلهوب - الشارع العام\u001c - الجديدة - المتن",
"TEL1": "01/888306",
"TEL2": "01/899886",
"TEL3": "",
"internet": "cosmaline@maliaholding.com"
},
{
"Category": "Excellent",
"Number": "570",
"com-reg-no": "6812",
"NM": "مؤسسة زمرود - منير زمرود واولاده - MZ توصية بسيطة",
"L_NM": "Ets. Zamroud - Mounir Zamroud & Fils - MZ",
"Last Subscription": "1-Mar-18",
"Industrial certificate no": "253",
"Industrial certificate date": "22-Jan-19",
"ACTIVITY": "صياغة المجوهرات وتركيب الاحجار الكريمة",
"Activity-L": "Manufacture of jewellery & assorting of precious stones",
"ADRESS": "ملك الشركة\u001c - الشارع الرئيسي\u001c - برج حمود - المتن",
"TEL1": "01/240708",
"TEL2": "03/660280",
"TEL3": "03/555199",
"internet": "etszamroud@hotmail.com"
},
{
"Category": "Excellent",
"Number": "908",
"com-reg-no": "24521",
"NM": "شركة فارمالين ش م ل",
"L_NM": "Pharmaline sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4582",
"Industrial certificate date": "11-Sep-18",
"ACTIVITY": "صناعة مستحضرات صيدلانية وادوية",
"Activity-L": "Manufacture of medical products & medicines",
"ADRESS": "ملك صراف وشركاه ش م ل\u001c - وطى عمارة شلهوب - الاوتوستراد\u001c - الجديدة - المتن",
"TEL1": "01/888306+9",
"TEL2": "01/899886",
"TEL3": "",
"internet": "pharmaline@maliaholding.com"
},
{
"Category": "Excellent",
"Number": "202",
"com-reg-no": "16284",
"NM": "يونيباك ش م ل - اتحاد صناعة الورق والكرتون المضلع",
"L_NM": "Unipak sal",
"Last Subscription": "8-Dec-17",
"Industrial certificate no": "4600",
"Industrial certificate date": "14-Mar-18",
"ACTIVITY": "صناعة كرتون مضلع وصناديق كرتون ورولو وورق صحي",
"Activity-L": "Manufacture of corrugated carton & boxes & toilet paper",
"ADRESS": "ملك الشركة\u001c - الشارع العام\u001c - حالات - جبيل",
"TEL1": "09/478900+9",
"TEL2": "",
"TEL3": "",
"internet": "info@unipaklb.com"
},
{
"Category": "Excellent",
"Number": "475",
"com-reg-no": "2411",
"NM": "شركة بوريبلاست لبنان ش م ل",
"L_NM": "Puriplast Liban sal",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "335",
"Industrial certificate date": "5-Feb-19",
"ACTIVITY": "صناعة الواح بلاستيكية منضده - ورق ديكور وكرفت مشرب وراتنجات",
"Activity-L": "Manufacture of resins,impregnated paper & plastic laminates",
"ADRESS": "ملك الشركة\u001c - الشارع العام\u001c - اده - جبيل",
"TEL1": "09/737114+5",
"TEL2": "09/217083",
"TEL3": "03/661736",
"internet": "puriplast@lynx.net.lb"
},
{
"Category": "Excellent",
"Number": "841",
"com-reg-no": "68360",
"NM": "غلاسلاين اندستريز ش م ل",
"L_NM": "Glassline Industries sal",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "4555",
"Industrial certificate date": "29-Aug-18",
"ACTIVITY": "معملا لقص الواح الزجاج - سيكوريت",
"Activity-L": " Cutting of flat glass (securite)",
"ADRESS": "ملك مي نجار\u001c - شارع اميل اده\u001c - قريطم - بيروت",
"TEL1": "05/432045",
"TEL2": "05/432046",
"TEL3": "03/334800",
"internet": "info@glasslineindustries.com"
},
{
"Category": "Excellent",
"Number": "174",
"com-reg-no": "7155",
"NM": "شركة دهانات تينول الدولية ش م ل",
"L_NM": "Tinol Paints International Co. sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "3863",
"Industrial certificate date": "22-Apr-18",
"ACTIVITY": "صناعة وتجارة الدهانات",
"Activity-L": "Manufacture & Trading  of paints",
"ADRESS": "ملك علي عبد الله الجمال\u001c - شارع فردان\u001c - عين التينه - بيروت",
"TEL1": "01/803270+71",
"TEL2": "01/812345",
"TEL3": "01/245222",
"internet": "paints@tinol.com.lb"
},
{
"Category": "First",
"Number": "1265",
"com-reg-no": "21950",
"NM": "ميرو بلاستك ش.م.م.",
"L_NM": "Miroplastic SARL",
"Last Subscription": "17-Mar-18",
"Industrial certificate no": "403",
"Industrial certificate date": "19-Feb-19",
"ACTIVITY": "صناعة اكياس ورولو نايلون",
"Activity-L": "Manufacture of nylon bags & rolls",
"ADRESS": "ملك نظمي عقاد\u001c - جسرالاوبارا -   شارع الفردوس \u001c - البوشرية  - المتن",
"TEL1": "01/688908",
"TEL2": "03/776882",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "170",
"com-reg-no": "3653",
"NM": "شركة صناعة المعادن ش م ل سيدم",
"L_NM": "Sidem - Société pour L\'Industrie des Métaux sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "343",
"Industrial certificate date": "7-Feb-19",
"ACTIVITY": "صناعة وسحب الالمنيوم بروفيليه واقراص وانابيب وصفائح",
"Activity-L": "Manufacture of aluminium profiles, tubes & sheets",
"ADRESS": "بناية فياض\u001c - شارع شكري العسيلي\u001c - الاشرفية - بيروت",
"TEL1": "09/220163",
"TEL2": "03/220164",
"TEL3": "09/220165",
"internet": "sidem@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "20",
"com-reg-no": "22070",
"NM": "معامل البيرة الماسة ش م ل",
"L_NM": "Brasserie Almaza sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4402",
"Industrial certificate date": "1-Aug-18",
"ACTIVITY": "صناعة البيرة",
"Activity-L": "Manufacture of beer",
"ADRESS": "ملك الشركة\u001c - الاوتوستراد\u001c - البوشرية - المتن",
"TEL1": "01/883300",
"TEL2": "01/890200",
"TEL3": "",
"internet": "alma.baaklini@heineken.com"
},
{
"Category": "Excellent",
"Number": "416",
"com-reg-no": "21592",
"NM": "بواسوليه دي ريف ش م م",
"L_NM": "Boisseliers du Rif sarl",
"Last Subscription": "23-May-17",
"Industrial certificate no": "3846",
"Industrial certificate date": "20-Apr-18",
"ACTIVITY": "صناعة المفروشات",
"Activity-L": "Manufacture of furniture",
"ADRESS": "بناية جبارة\u001c - شارع المسلخ\u001c - برج حمود - المتن",
"TEL1": "01/241728",
"TEL2": "01/241729",
"TEL3": "01/241727",
"internet": "boirif@inco.com.lb"
},
{
"Category": "Excellent",
"Number": "334",
"com-reg-no": "12172",
"NM": "شركة دباس للصناعة ش م ل",
"L_NM": "Debbas Industries sal",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "324",
"Industrial certificate date": "2-Feb-19",
"ACTIVITY": "صناعة لمبات ومصابيح ولوازم الانارة وتابلوهات كهربائية والبكل والازرار",
"Activity-L": "Manufacture of lighting articles, electrical boards, button & buckles",
"ADRESS": "ملك شركة قيصر دباس واولاده\u001c - طريق المكلس - الشارع العام\u001c - الدكوانة - المتن",
"TEL1": "01/486313",
"TEL2": "01/486311",
"TEL3": "01/486312",
"internet": "info@di.debbas.com.lb"
},
{
"Category": "Excellent",
"Number": "267",
"com-reg-no": "15880",
"NM": "الشركة اللبنانية الجديدة للصناعات التحويلية ش م ل - ماسترباك",
"L_NM": "New Lebanese Company for Converting Industries sal -Masterpak",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4284",
"Industrial certificate date": "11-Jul-18",
"ACTIVITY": "صناعة اكياس ولفائف وصناديق وقناني وصفائح بلاستيكية",
"Activity-L": "Manufacture of plastic bags, boxes,rolls & bottles& sheets",
"ADRESS": "بناية ماستر باك\u001c - طلعة يسوع الملك\u001c - زوق مصبح - كسروان",
"TEL1": "09/209000",
"TEL2": "09/209001",
"TEL3": "",
"internet": "info@masterpaklb.com"
},
{
"Category": "Excellent",
"Number": "538",
"com-reg-no": "23324",
"NM": "الوادي الاخضر ش م ل",
"L_NM": "Al Wadi Al Akhdar sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "455",
"Industrial certificate date": "23-Feb-19",
"ACTIVITY": "صناعة وتعبئة وتثليج المواد الغذائية، طحينة، حلاوة ومربيات وشرابات",
"Activity-L": "Manufacture of conserves,tahina,halawa,Jams & beverages",
"ADRESS": "ملك عبجي\u001c - الشارع العام\u001c - عمارة شلهوب - المتن",
"TEL1": "01/892029",
"TEL2": "01/898141",
"TEL3": "01/898755",
"internet": "info@alwadi-alakhdar.com"
},
{
"Category": "Excellent",
"Number": "506",
"com-reg-no": "11618",
"NM": "الشركة الصناعية فولدا ش م ل",
"L_NM": "Société Industrielle Folda sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "3849",
"Industrial certificate date": "21-Apr-18",
"ACTIVITY": "صناعة سحب البروفيل والابواب الجرارة",
"Activity-L": "Manufacture of profiles drawing & sliding doors",
"ADRESS": "ملك الشركة\u001c - المنطقة الصناعية\u001c - زوق مصبح - كسروان",
"TEL1": "09/217858",
"TEL2": "09/219383",
"TEL3": "09/217868",
"internet": "folda@dm.net.lb"
},
{
"Category": "Excellent",
"Number": "171",
"com-reg-no": "2652/23256",
"NM": "هنكل لبنان ش م ل",
"L_NM": "Henkel Lebanon sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4576",
"Industrial certificate date": "7-Sep-18",
"ACTIVITY": "صناعة مساحيق التنظيف والشامبو",
"Activity-L": "Manufacture of detergents & shampoo",
"ADRESS": "بناية عبجي\u001c - شارع يسوع الملك\u001c - زوق مصبح - كسروان",
"TEL1": "09/220361+9",
"TEL2": "",
"TEL3": "",
"internet": "henkel@henkel-lebanon.com"
},
{
"Category": "Third",
"Number": "7949",
"com-reg-no": "36924",
"NM": "الحرفي اللبناني ش م م",
"L_NM": "L\'artisan du Liban sarl",
"Last Subscription": "20-Jan-18",
"Industrial certificate no": "2891",
"Industrial certificate date": "26-Apr-18",
"ACTIVITY": "صناعة اشغال حرفية",
"Activity-L": "Manufacture of artisanal articles",
"ADRESS": "ملك مهدي التاجر\u001c - شارع كليمنصو\u001c - القنطاري - بيروت",
"TEL1": "01/374031",
"TEL2": "01/364880",
"TEL3": "01/580618",
"internet": "lartisan@lartisanlb.com"
},
{
"Category": "Second",
"Number": "4722",
"com-reg-no": "7720",
"NM": "شركة عبجي كيماويات ش م ل",
"L_NM": "Obegi Chemicals sal",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4240",
"Industrial certificate date": "5-Jul-18",
"ACTIVITY": "صناعة الدهانات والاحبار الصناعية",
"Activity-L": "Manufacture of paints& industrial inks",
"ADRESS": "ملك الشركة\u001c - الدوره - الطريق البحرية\u001c - البوشرية - المتن",
"TEL1": "01/900771",
"TEL2": "01/900772",
"TEL3": "01/900774",
"internet": "lebanon_support@obegichem.com"
},
{
"Category": "Excellent",
"Number": "1754",
"com-reg-no": "5389",
"NM": "شركة الكرتون اللبنانية ش م ل - سوليكار",
"L_NM": "Société Libanaise de Carton sal - Solicar",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "3574",
"Industrial certificate date": "9-Mar-18",
"ACTIVITY": "صناعة الورق والكرتون",
"Activity-L": "Manufacture of paper & carton",
"ADRESS": "ملك الشركة\u001c - الشارع العام\u001c - وادي شحرور - بعبدا",
"TEL1": "05/940248",
"TEL2": "05/942676",
"TEL3": "05/942666",
"internet": "solicar@sodetel.net.lb"
},
{
"Category": "Excellent",
"Number": "1381",
"com-reg-no": "64997",
"NM": "شركة باتشي الصناعية ش م ل",
"L_NM": "Patchi Industrial Company sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "263",
"Industrial certificate date": "24-Jan-19",
"ACTIVITY": "صناعة الشوكولا والسكاكر والاواني الفضية المنزلية",
"Activity-L": "Manufacture of chocolate & candies & silverware",
"ADRESS": "بناية باتشي\u001c - كراكاس - شارع القلعة\u001c - رأس بيروت - بيروت",
"TEL1": "07/970037",
"TEL2": "07/970038",
"TEL3": "07/970039",
"internet": "patchi@patchi-industrial.com"
},
{
"Category": "Second",
"Number": "6372",
"com-reg-no": "58782",
"NM": "شركة عزيز مصور وولده ش م م لاتوليه",
"L_NM": "Aziz Moussawer & Son sarl",
"Last Subscription": "14-Jan-17",
"Industrial certificate no": "292",
"Industrial certificate date": "26-Jun-17",
"ACTIVITY": "صناعة المفروشات",
"Activity-L": "Manufacture of furniture",
"ADRESS": "ملك وقف الروم\u001c - شارع البستاني \u001c - وطى المصيطبة - بيروت",
"TEL1": "05/434111",
"TEL2": "05/433367",
"TEL3": "01/817535",
"internet": "info@ateliermoussawer.com"
},
{
"Category": "Third",
"Number": "16749",
"com-reg-no": "44628",
"NM": "مادونا تييري وشركاؤها توصية بسيطة",
"L_NM": "Madonna Thierry et Co",
"Last Subscription": "13-Mar-18",
"Industrial certificate no": "3613",
"Industrial certificate date": "15-Mar-18",
"ACTIVITY": "صياغة المجوهرات",
"Activity-L": "Manufacture of jewellery",
"ADRESS": "ملك سلوى ابي سمرا\u001c - الشارع العام\u001c - بيت مري - المتن",
"TEL1": "01/999800",
"TEL2": "",
"TEL3": "",
"internet": "mthierry@inco.com.lb"
},
{
"Category": "First",
"Number": "3863",
"com-reg-no": "34577",
"NM": "شركة سفن بلاست للصناعات الكيماوية ش م م",
"L_NM": "Seven Plast Chemical Industries- S.P.C.I - sarl",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "150",
"Industrial certificate date": "9-Jan-19",
"ACTIVITY": "صناعة حبيبات بلاستيكية وتجارة المواد البلاستيكية",
"Activity-L": "Manufacture of plastic in primary forms(Granule)Trade of plastic materials",
"ADRESS": "ملك سعاده وزروي وشلهوب وحلاوي وشيا وادلبي\u001c - شارع التيرو\u001c - الشويفات - عاليه",
"TEL1": "05/480492",
"TEL2": "05/480493",
"TEL3": "05/480494",
"internet": "sevenpla@sevenplast.com.lb"
},
{
"Category": "Third",
"Number": "13879",
"com-reg-no": "57918",
"NM": "مصنوعات الرشيدي - ابو سمير - شركة توصية بسيطة",
"L_NM": "Al Rachidy Products - Abou Samir",
"Last Subscription": "20-Feb-18",
"Industrial certificate no": "3899",
"Industrial certificate date": "29-Apr-18",
"ACTIVITY": "صناعة القشدة والقطايف والمغربية والكنافة ورقاقات وكافة المعجنات",
"Activity-L": "Manufacture of cream from milk, sweet & pastry",
"ADRESS": "ملك امين الرشيدي\u001c - زاروب عبلا\u001c - عائشة بكار - بيروت",
"TEL1": "01/810115",
"TEL2": "01/736236",
"TEL3": "03/395943",
"internet": ""
},
{
"Category": "Second",
"Number": "5267",
"com-reg-no": "34178",
"NM": "المصنع الكيميائي - جباره ش م ل",
"L_NM": "Usine Chimique - Gebara sal",
"Last Subscription": "26-Jan-18",
"Industrial certificate no": "67",
"Industrial certificate date": "21-Dec-18",
"ACTIVITY": "صناعة الدهانات والمعجونة والتنر للسيارات",
"Activity-L": "Manufacture of paints & putty for cars",
"ADRESS": "ملك جباره\u001c - الشارع العام\u001c - بيت الككو - المتن",
"TEL1": "04/911424",
"TEL2": "04/912444",
"TEL3": "03/267672",
"internet": "usinechi@dm.net.lb"
},
{
"Category": "Fourth",
"Number": "30855",
"com-reg-no": "2041826",
"NM": "سيفن اوركيد كوزميتيكز ش م م",
"L_NM": "Seven Orkid Cosmetics sarl",
"Last Subscription": "7-Mar-18",
"Industrial certificate no": "3564",
"Industrial certificate date": "9-Mar-18",
"ACTIVITY": "صناعة مواد التجميل",
"Activity-L": "Manufacture of cosmetics",
"ADRESS": "ملك الشركة العالمية للاغذية\u001c - القبة - خلده - الاتوستراد\u001c - الشويفات - عاليه",
"TEL1": "05/805363",
"TEL2": "03/888087",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1715",
"com-reg-no": "19709",
"NM": "شركة الشرق الاوسط للتجارة والتوضيب ش م ل  مبتيكو",
"L_NM": "Middle East Packing & Trading  Co. MEPTICO sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "471",
"Industrial certificate date": "27-Feb-19",
"ACTIVITY": "تصنيع وتعبئة المواد الاولية للحلويات، الشرابات، البوظة والبهارات",
"Activity-L": "Manufacture of primary materials of sweets, sirop, Ice cream & spieces",
"ADRESS": "ملك جوزف اسود\u001c - شارع عبد الوهاب الانكليزي\u001c - الاشرفية - بيروت",
"TEL1": "09/220886+7",
"TEL2": "09/218067+8",
"TEL3": "",
"internet": "meptico@meptico.com"
},
{
"Category": "Excellent",
"Number": "1676",
"com-reg-no": "55377",
"NM": "خنيصر موتورز ش م م",
"L_NM": "Khonaysser Motors sarl",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "3147",
"Industrial certificate date": "16-Mar-18",
"ACTIVITY": "تجميع المولدات الكهربائية وصناعة التابلوهات الكهربائية والاكسسوار",
"Activity-L": "Assembling of generators & Manufacture of electrical boards & accessories",
"ADRESS": "ملك انطوان خنيصر\u001c - شارع الكسارات\u001c - بياقوت - المتن",
"TEL1": "01/870078",
"TEL2": "01/887212",
"TEL3": "03/617813",
"internet": "info@khonaysser.com"
},
{
"Category": "Third",
"Number": "17480",
"com-reg-no": "52090",
"NM": "شركة صناعة الفضية الحديثة - سيوم ش م م",
"L_NM": "Société Industrielle D\'orfèvrerie Moderne - Siom sarl",
"Last Subscription": "15-Jan-18",
"Industrial certificate no": "4330",
"Industrial certificate date": "18-Jul-18",
"ACTIVITY": "صناعة الاواني الفضية",
"Activity-L": "Manufacture of silverware",
"ADRESS": "ملك ناجي وانطوان وسامي بارود\u001c - المدينة الصناعية\u001c - مزرعة يشوع - المتن",
"TEL1": "04/921080",
"TEL2": "04/920981",
"TEL3": "04/927397",
"internet": "siom@siomorfevres.com"
},
{
"Category": "Fourth",
"Number": "30610",
"com-reg-no": "2002033",
"NM": "تريكو هارون",
"L_NM": "Tricot Haroun",
"Last Subscription": "23-Jan-18",
"Industrial certificate no": "25840",
"Industrial certificate date": "21-Oct-18",
"ACTIVITY": "مصنعا للحياكة والخياطة",
"Activity-L": "kniting & sewing factory",
"ADRESS": "ملك روجيه هارون\u001c - الشارع العام\u001c - مزرعة يشوع - المتن",
"TEL1": "04/920858",
"TEL2": "03/666466",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "26373",
"com-reg-no": "2023422",
"NM": "برووال ليبانون ش م م",
"L_NM": "Proal Lebanon sarl",
"Last Subscription": "10-Jan-17",
"Industrial certificate no": "3945",
"Industrial certificate date": "9-Dec-17",
"ACTIVITY": "صناعة الاخشاب",
"Activity-L": "Manufacture of wood",
"ADRESS": "ملك شركة بانوراما مكلس ش م ل\u001c - جسر الباشا-شارع كنيسة مار الياس\u001c - المكلس-المتن",
"TEL1": "01/695288",
"TEL2": "01/695388",
"TEL3": "76/444686",
"internet": "info@praollebanon.com"
},
{
"Category": "Third",
"Number": "18227",
"com-reg-no": "56819",
"NM": "شركة تريكو ستارلت - تضامن",
"L_NM": "Tricot Starlet Co",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "1492",
"Industrial certificate date": "9-Mar-18",
"ACTIVITY": "معمل لحياكة التريكو",
"Activity-L": "Manufacture of tricot",
"ADRESS": "بناية الدفلة 9 ط سفلي\u001c - شارع الجاموس\u001c - الحدث - بعبدا",
"TEL1": "05/467764",
"TEL2": "03/730764",
"TEL3": "03/730763",
"internet": ""
},
{
"Category": "Fourth",
"Number": "29731",
"com-reg-no": "2033660",
"NM": "الـيكوبـاك ش م ل",
"L_NM": "Allecopack sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4537",
"Industrial certificate date": "28-Aug-18",
"ACTIVITY": "صناعة الشامبو والعطور ومستحضرات التجميل",
"Activity-L": "Manufacture of shampoo, perfumes & cosmetics",
"ADRESS": "بناية سادا باك ملك سامي ضاهر\u001c - شارع الكنيسة\u001c - ضهر المغارة - الشوف",
"TEL1": "07/985885",
"TEL2": "70/222722",
"TEL3": "",
"internet": "accounting@allecopack.com"
},
{
"Category": "Fourth",
"Number": "30899",
"com-reg-no": "2030290",
"NM": "فيردا اينرجي",
"L_NM": "Verda Energy",
"Last Subscription": "10-May-17",
"Industrial certificate no": "4465",
"Industrial certificate date": "10-Aug-18",
"ACTIVITY": "تنفيذ تعهدات الهندسة الكهربائية واشغال التمديدات الكهربائية",
"Activity-L": "Electrical engineering contracting & electrical installation works",
"ADRESS": "ملك اكرم عطوي\u001c - حي ماضي - الشارع العام\u001c - حارة حريك - بعبدا",
"TEL1": "01/554802",
"TEL2": "76/550482",
"TEL3": "",
"internet": "verda.Energy@gmail.com"
},
{
"Category": "Second",
"Number": "6649",
"com-reg-no": "18372",
"NM": "جوزف ب عماطوري ش م م",
"L_NM": "Joseph B. Amatoury sarl",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4353",
"Industrial certificate date": "22-Jul-18",
"ACTIVITY": "صناعة وتعبئة العطورات ومواد التجميل",
"Activity-L": " Manufacture & filling of perfumes & cosmetics",
"ADRESS": "ملك بدران\u001c - حرج كتانه - شارع كميل شمعون\u001c - سن الفيل - المتن",
"TEL1": "01/480207",
"TEL2": "01/481700",
"TEL3": "01/481845",
"internet": "jba@dm.net.lb"
},
{
"Category": "Third",
"Number": "32206",
"com-reg-no": "2013732",
"NM": "جاست ساين ش م م",
"L_NM": "Just Sign sarl",
"Last Subscription": "29-Mar-17",
"Industrial certificate no": "3769",
"Industrial certificate date": "5-Apr-18",
"ACTIVITY": "صناعة الارمات والاشارات",
"Activity-L": "Manufacture of nameplates & signs",
"ADRESS": "مبنى المركز الصناعي التجاري\u001c - نهر الموت - الشارع العام\u001c - الجديدة - المتن",
"TEL1": "01/877644",
"TEL2": "03/626762",
"TEL3": "",
"internet": "charles@justsignsarl.com"
},
{
"Category": "Fourth",
"Number": "25355",
"com-reg-no": "1016012",
"NM": "شركة قرنفل غروب للصناعة والتجارة ش م م",
"L_NM": "Kronfol Group for Manufacturing and Trading sarl",
"Last Subscription": "30-Jan-18",
"Industrial certificate no": "432",
"Industrial certificate date": "22-Feb-19",
"ACTIVITY": "صناعة الشوكولا",
"Activity-L": "Manufacture of chocolate",
"ADRESS": "بناية قرنفل\u001c - شارع كرم العريس\u001c - برج ابي حيدر - بيروت",
"TEL1": "01/614916",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "5317",
"com-reg-no": "1015794",
"NM": "شركة سهيل فخران فودز ش م ل",
"L_NM": "Souheil Fakhran Foods sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "2820",
"Industrial certificate date": "13-Apr-18",
"ACTIVITY": "طحن وتبعئة وتوضيب السكر والمكسرات والحبوب والتمور",
"Activity-L": "Grinding & packing of sugar,mixed nuts,cereal & dates",
"ADRESS": "بنابة البارك\u001c - شارع محمد الحوت\u001c - رأس النبع - بيروت",
"TEL1": "01/841300",
"TEL2": "01/841301",
"TEL3": "",
"internet": "mohamadf@fakhranfoods.com"
},
{
"Category": "Second",
"Number": "6242",
"com-reg-no": "2030734",
"NM": "شركة بوام للصناعة والتجارة ش م ل",
"L_NM": "Poeme for Industry and Trading sal",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "2952",
"Industrial certificate date": "18-Jan-19",
"ACTIVITY": "صناعة الشوكولا",
"Activity-L": "Manufacture of chocolate",
"ADRESS": "بناية يحي ط ارضي\u001c - القبه - الشارع العام\u001c - دوحة عرمون - عاليه",
"TEL1": "05/811369",
"TEL2": "05/810922",
"TEL3": "03/834567",
"internet": ""
},
{
"Category": "Second",
"Number": "6243",
"com-reg-no": "1016123",
"NM": "فريق كو ش م ل",
"L_NM": "Fraick.co sal",
"Last Subscription": "26-Jan-18",
"Industrial certificate no": "33",
"Industrial certificate date": "14-Dec-18",
"ACTIVITY": "صناعة القشطة",
"Activity-L": "Manufacture of milk cream",
"ADRESS": "بناية اركادا 4 ط3\u001c - شارع جورج زوين\u001c - الروشة - بيروت",
"TEL1": "03/682777",
"TEL2": "05/603506",
"TEL3": "05/603803",
"internet": "info@fraick.co"
},
{
"Category": "Fourth",
"Number": "25040",
"com-reg-no": "2002955",
"NM": "مؤسسة KHM للتجارة العامة فابو - Fabo",
"L_NM": "Fabo",
"Last Subscription": "26-Jan-18",
"Industrial certificate no": "96",
"Industrial certificate date": "26-Dec-18",
"ACTIVITY": "صناعة السوائل المنظفة والشامبو",
"Activity-L": "Manufacture of detergents & shampoo",
"ADRESS": "ملك مكارم ط سفلي\u001c - الشارع العام\u001c - رأس المتن - بعبدا",
"TEL1": "05/380927",
"TEL2": "03/603951",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "25050",
"com-reg-no": "2032314",
"NM": "Universal Ceramico",
"L_NM": "Universal Ceramico",
"Last Subscription": "3-Jul-17",
"Industrial certificate no": "3706",
"Industrial certificate date": "28-Mar-18",
"ACTIVITY": "صناعة مواد منع النش",
"Activity-L": "Manufacture of waterproofing materials",
"ADRESS": "بناية بعينو\u001c - شارع مار يوحنا\u001c - البوشرية - المتن",
"TEL1": "03/539589",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "4368",
"com-reg-no": "2000757",
"NM": "درويش حداد - ب ب ب  ستروكتور ش.م.ل.",
"L_NM": "Derviche Haddad -PPB Structures sal",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "4238",
"Industrial certificate date": "4-Jul-18",
"ACTIVITY": "تجهيز خرسانة مسبقة الاجهاد في المباني والجسور",
"Activity-L": "Trading of ready mixed concrete for buildings & bridges",
"ADRESS": "ملك شركة س س ل الشرق الاوسط ش م م\u001c - الشارع العام\u001c - ذوق مصبح- كسروان",
"TEL1": "09/226055",
"TEL2": "09/226044",
"TEL3": "",
"internet": "cassaf@cclint.com"
},
{
"Category": "Second",
"Number": "7170",
"com-reg-no": "2022465",
"NM": "الومنيوم ماركـت ش م ل - شومان غروب",
"L_NM": "Alu Market sal - Chouman Group",
"Last Subscription": "21-Apr-17",
"Industrial certificate no": "1886",
"Industrial certificate date": "16-May-17",
"ACTIVITY": "صناعة منجور الالمنيوم والمطابخ",
"Activity-L": "Manufacture of aluminium panels & kitchens",
"ADRESS": "ملك ايمن شومان\u001c - شارع الزيتون الغربي\u001c - الجيه - الشوف",
"TEL1": "01/545815",
"TEL2": "03/909290",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "21512",
"com-reg-no": "2009219",
"NM": "افران جمول",
"L_NM": "Jammoul Bakeries",
"Last Subscription": "3-May-17",
"Industrial certificate no": "3875",
"Industrial certificate date": "25-Apr-18",
"ACTIVITY": "فرن للخبز والكعك والحلويات",
"Activity-L": "Bakery",
"ADRESS": "بناية جمول\u001c - الطريق العام\u001c - الجيه - الشوف",
"TEL1": "07/995190",
"TEL2": "03/952271",
"TEL3": "",
"internet": "jammoul.bakeries@gmail.com"
},
{
"Category": "Third",
"Number": "30432",
"com-reg-no": "53185",
"NM": "شركة طوني رحمه وولده للمفروشات والديكور - ماني دورو- تضامن",
"L_NM": "Tony Rahme & Son for furniture& Decoration - Mani Doro",
"Last Subscription": "16-Feb-18",
"Industrial certificate no": "3429",
"Industrial certificate date": "21-Feb-18",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك رزق\u001c - ادونيس - المنطقة الصناعية\u001c - زوق مصبح - كسروان",
"TEL1": "09/217917",
"TEL2": "03/225698",
"TEL3": "",
"internet": "info@mani-doro.com"
},
{
"Category": "Third",
"Number": "30423",
"com-reg-no": "3686",
"NM": "شركة معامل ادم لتكرير الملح وصناعة الخل (سونيا فؤاد آدم وشركاه) توصية بسيطة",
"L_NM": "Adam Factory Purification of Salt&Manufacture of vinegar(Sonia Fouad Adam&Co)",
"Last Subscription": "26-Apr-17",
"Industrial certificate no": "4738",
"Industrial certificate date": "17-Apr-18",
"ACTIVITY": "صناعة الخل وتعبئة الملح ضمن علب كرتون",
"Activity-L": "Manufacture of vinegar and packaging of salt into boxes",
"ADRESS": "ملك صالومي\u001c - كورنيش النهر\u001c - المدور - بيروت",
"TEL1": "01/446343",
"TEL2": "",
"TEL3": "",
"internet": "adamsfactory@outlook.com"
},
{
"Category": "Fourth",
"Number": "28227",
"com-reg-no": "2016672",
"NM": "بيبلوس برينتينغ ش م ل",
"L_NM": "Byblos Printing sal",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "3973",
"Industrial certificate date": "15-May-18",
"ACTIVITY": "مطبعة تجارية",
"Activity-L": "Printing press",
"ADRESS": "سنتر مكلس 2000 - ملك زياد المتني ط سفلي7\u001c - الشارع العام\u001c - المكلس - المتن",
"TEL1": "01/697111",
"TEL2": "70/598111",
"TEL3": "",
"internet": "info@byblosprinting.com"
},
{
"Category": "Third",
"Number": "30415",
"com-reg-no": "62146",
"NM": "شركة CA عفيف وشوقي جرجورة - تضامن",
"L_NM": "CA Co Afif & Chaouki Jarjoura",
"Last Subscription": "21-Feb-18",
"Industrial certificate no": "357",
"Industrial certificate date": "8-Aug-18",
"ACTIVITY": "خدمات الطباعة",
"Activity-L": "Printing services",
"ADRESS": "ملك جرجورة\u001c - شارع مار شربل\u001c - الفنار - المتن",
"TEL1": "01/688728",
"TEL2": "03/241631",
"TEL3": "03/241633",
"internet": "afifjarjoura@hotmail.com"
},
{
"Category": "Third",
"Number": "25382",
"com-reg-no": "36981",
"NM": "شركة فؤاد جميل بحوث للتجارة والصناعة - شركة توصية بسيطة",
"L_NM": "Fouad Bahous Trading & Industrial Co",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "4061",
"Industrial certificate date": "1-Jun-18",
"ACTIVITY": "صناعة الشوكولا",
"Activity-L": "Manufacture of chocolate",
"ADRESS": "سنتر سعاده  ط 3\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/492755",
"TEL2": "01/487708",
"TEL3": "01/487709",
"internet": "bahous.chocolate@hotmail.com"
},
{
"Category": "Fourth",
"Number": "28333",
"com-reg-no": "2036054",
"NM": "H.A.G sal",
"L_NM": "H.A.G sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "2185",
"Industrial certificate date": "31-Jul-18",
"ACTIVITY": "صناعة الات صناعية لتجليس جنوطة السيارات",
"Activity-L": "Manufacture of industrial machinary need for tires",
"ADRESS": "بناية هاتكو ش م ل\u001c - الطريق البحرية - شارع سوق السمك\u001c - برج حمود - المتن",
"TEL1": "01/241900",
"TEL2": "01/241901",
"TEL3": "03/700879",
"internet": "hag@hatco.com.lb"
},
{
"Category": "Excellent",
"Number": "952",
"com-reg-no": "59799",
"NM": "الشركة اللبنانية للمعادن ش م ل",
"L_NM": "Societe Libanaise pour Les Metaux sal",
"Last Subscription": "7-Jul-17",
"Industrial certificate no": "1357",
"Industrial certificate date": "16-Dec-14",
"ACTIVITY": "تجارة جملة الحديد الصناعي",
"Activity-L": "Wholesale of industrial Iron",
"ADRESS": "ملك حكمت سليم طنوس\u001c - شارع المسلخ\u001c - المدور - بيروت",
"TEL1": "01/444817",
"TEL2": "01/447756",
"TEL3": "01/449431",
"internet": "slpm@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "781",
"com-reg-no": "50383",
"NM": "دبانه اخوان ش م ل",
"L_NM": "Debbane Frères sal",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "4289",
"ACTIVITY": "تجارة جملة ادوية ومعدات زراعية ونصوب وشتول",
"Activity-L": "wholesaleof agricultural medicines,equipment&plant",
"ADRESS": "ملك ماري عودة\u001c - شارع سليم بسترس- \u001c - الاشرفية- بيروت",
"TEL1": "09/211800",
"TEL2": "",
"TEL3": "",
"internet": "info@debbane.com"
},
{
"Category": "Fourth",
"Number": "31288",
"com-reg-no": "2047219",
"NM": "ريف",
"L_NM": "Rif",
"Last Subscription": "23-Jun-17",
"Industrial certificate no": "2678",
"Industrial certificate date": "11-Apr-17",
"ACTIVITY": "صناعة الصابون",
"Activity-L": "Manufacture of soap",
"ADRESS": "بناية شوقي نصر\u001c - الشارع العام\u001c - كفرفاقود - الشوف",
"TEL1": "05/720780",
"TEL2": "03/219813",
"TEL3": "",
"internet": "rifsoap@gmail.com"
},
{
"Category": "Excellent",
"Number": "1364",
"com-reg-no": "25561",
"NM": "شركة الامصال اللبنانية ش م م",
"L_NM": "Serum Products sarl",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "3557",
"Industrial certificate date": "8-Mar-18",
"ACTIVITY": "صناعة الامصال",
"Activity-L": "Manufacture of serum products",
"ADRESS": "ملك الشركة\u001c - حي الامراء\u001c - الشويفات - عاليه",
"TEL1": "01/351456",
"TEL2": "05/480207+8",
"TEL3": "03/618677",
"internet": "tabbatar@t-net.com.lb"
},
{
"Category": "First",
"Number": "681",
"com-reg-no": "35436",
"NM": "شركة التضامن للمنجور والموبيليا - شركة تضامن",
"L_NM": "Ste. Al Tadamon pour la Menuiserie et L\'Ameublement",
"Last Subscription": "2-Feb-18",
"Industrial certificate no": "1847",
"Industrial certificate date": "9-May-18",
"ACTIVITY": "صناعة المفروشات",
"Activity-L": "Manufacture of furniture",
"ADRESS": "ملك الاسمر\u001c - قرب فرن يني - شارع رقم 4\u001c - المكلس - المتن",
"TEL1": "01/681444",
"TEL2": "01/689871+2",
"TEL3": "03/681444",
"internet": "tadamon@asmarwood.com"
},
{
"Category": "First",
"Number": "3193",
"com-reg-no": "45617",
"NM": "الشركة العامة للموبيليا والديكور - شركة تضامن",
"L_NM": "General Company for Woodwork and Decoration",
"Last Subscription": "3-Jul-17",
"Industrial certificate no": "4187",
"Industrial certificate date": "22-Jun-18",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "بناية منير ابراهيم\u001c - شارع عبد الغني العريسي\u001c - المزرعة - بيروت",
"TEL1": "01/655585",
"TEL2": "01/655586",
"TEL3": "03/634035",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1079",
"com-reg-no": "23231",
"NM": "شركة جورجي صابونجيان ش م م",
"L_NM": "Georgi Sabounjian sarl",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "212",
"Industrial certificate date": "17-Jan-19",
"ACTIVITY": "صناعة قوالب وعلب المجوهرات",
"Activity-L": "Manufacture of moulds & boxes for jewellery",
"ADRESS": "بناية حبيب ابو حبيب\u001c - حارة الغوارنه\u001c - انطلياس - المتن",
"TEL1": "04/711117",
"TEL2": "",
"TEL3": "",
"internet": "georgi@georgisabounjian.com.lb"
},
{
"Category": "Excellent",
"Number": "1913",
"com-reg-no": "8542",
"NM": "شركة ادونيس الصناعية ش م ل - سياد",
"L_NM": "Siad Société Industrielle Adonis sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "3778",
"Industrial certificate date": "6-Apr-18",
"ACTIVITY": "صناعة الادوية الزراعية",
"Activity-L": "Manufacture of agricultural medicines",
"ADRESS": "بناية العسيلي\u001c - شارع رياض الصلح\u001c - النجمة - بيروت",
"TEL1": "09/790940+1",
"TEL2": "01/898021",
"TEL3": "04/890312",
"internet": "adonis@dm.net.lb"
},
{
"Category": "Excellent",
"Number": "1662",
"com-reg-no": "23851",
"NM": "شركة سودامكو ش م ل",
"L_NM": "Sodamco sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "459",
"Industrial certificate date": "26-Aug-18",
"ACTIVITY": "صناعة مواد تقوية الباطون ومواد ضد النش ولاصقة",
"Activity-L": "Manufacture of concrete & waterproofing materials & silicones",
"ADRESS": "بناية سوداب\u001c - الشارع العام\u001c - حصرايل - جبيل",
"TEL1": "09/790920",
"TEL2": "09/790921",
"TEL3": "09/790922+23",
"internet": "jbeil@sodamco.com"
},
{
"Category": "First",
"Number": "3311",
"com-reg-no": "35258",
"NM": "شركة زهير ورامز بو نادر التجارية - شركة تضامن",
"L_NM": "Zouheir & Ramez Bou Nader Trd. Co",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4524",
"Industrial certificate date": "23-Aug-18",
"ACTIVITY": "صناعة المشروبات الروحية والسبيرتو وخل وماء الزهر والورد",
"Activity-L": "Manu. of alco.drinks,alcohol,vinegar,flower&rose water",
"ADRESS": "بناية رقم 16\u001c - شارع 44\u001c - سن الفيل - المتن",
"TEL1": "01/484457",
"TEL2": "01/482500",
"TEL3": "",
"internet": "levant@sami-sa.com"
},
{
"Category": "First",
"Number": "1915",
"com-reg-no": "15804",
"NM": "شركة ابناء ميشال بطرس - شركة تضامن",
"L_NM": "The Sons of M. Boutros Co",
"Last Subscription": "26-Jan-18",
"Industrial certificate no": "165",
"Industrial certificate date": "10-Jan-19",
"ACTIVITY": "صناعة الدهانات",
"Activity-L": " Manufacture of paints",
"ADRESS": "ملك ابناء ميشال بطرس\u001c - المنطقة الصناعية\u001c - زوق مصبح - كسروان",
"TEL1": "09/219523",
"TEL2": "09/219525",
"TEL3": "09/218774",
"internet": "sonsbtr@gmail.com"
},
{
"Category": "Excellent",
"Number": "1912",
"com-reg-no": "113",
"NM": "جميل اخوان ش م ل",
"L_NM": "Gemayel Frères sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4233",
"Industrial certificate date": "4-Jul-18",
"ACTIVITY": "صناعة الكرتون العادي والمضلع وصناعة العلب",
"Activity-L": "Manufacture of corrugated paper, paperborad & boxes",
"ADRESS": "ملك سنا\u001c - شارع سعيد عقل\u001c - مار مارون - بيروت",
"TEL1": "04/980122",
"TEL2": "04/985048+9",
"TEL3": "01/203323",
"internet": "gf@gemayelfreres.com"
},
{
"Category": "First",
"Number": "331",
"com-reg-no": "15029",
"NM": "شركة ايوب اللبنانية للصناعة ش م ل اليكو",
"L_NM": "Ayoub Lebanese Industrial Co. sal\" Alico \"",
"Last Subscription": "5-Aug-17",
"Industrial certificate no": "4420",
"Industrial certificate date": "2-Aug-18",
"ACTIVITY": "صناعة وتجارة مفروشات منزلية، مكتبية، معدنية وخيزران، وبياضات منزلية وسجاد",
"Activity-L": "Manfacture & trading of home, ofices & other furnitures, linen & carpet",
"ADRESS": "بناية ايوب\u001c - شارع الرهبان\u001c - المدور - بيروت",
"TEL1": "01/444250",
"TEL2": "01/444444",
"TEL3": "",
"internet": "sleep_comfort@inco.com.lb"
},
{
"Category": "First",
"Number": "728",
"com-reg-no": "38611",
"NM": "السير ش م ل",
"L_NM": "Elcir sal",
"Last Subscription": "21-Mar-18",
"Industrial certificate no": "4639",
"Industrial certificate date": "20-Sep-18",
"ACTIVITY": "صناعة المفروشات وصناعة البرادي الداخلية والخارجية",
"Activity-L": "Manufacture of furniture & curtains",
"ADRESS": "ملك انجا\u001c - شارع سامي الصلح\u001c - المكلس - المتن",
"TEL1": "01/690701+6",
"TEL2": "03/030025",
"TEL3": "",
"internet": "elcir@elcir.com"
},
{
"Category": "First",
"Number": "3428",
"com-reg-no": "53559",
"NM": "انترانيك بالجيان واولاده - تضامن",
"L_NM": "Antranik Baljian & Sons",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "619",
"Industrial certificate date": "20-Mar-19",
"ACTIVITY": "قص وطعج صفائح المعادن والبلاستيك",
"Activity-L": "Cuting & folding of metal & plastic sheets",
"ADRESS": "ملك كامل\u001c - شارع الشل\u001c - برج حمود- المتن",
"TEL1": "01/240516",
"TEL2": "01/242605",
"TEL3": "01/254351",
"internet": "sam2@cyberia.net.lb"
},
{
"Category": "First",
"Number": "2518",
"com-reg-no": "2992",
"NM": "شركة سالم انترناسيونال تانيري - توصية بسيطة",
"L_NM": "Salem International Tannery",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "2929",
"Industrial certificate date": "6-May-18",
"ACTIVITY": "دباغة",
"Activity-L": " Tanning",
"ADRESS": "ملك سالم\u001c - شارع الدباغة\u001c - وادي شحرور العليا - بعبدا",
"TEL1": "05/940099",
"TEL2": "03/809899",
"TEL3": "01/264287",
"internet": ""
},
{
"Category": "First",
"Number": "1996",
"com-reg-no": "29719",
"NM": "عاطف ابو مراد واخوانه - تضامن",
"L_NM": "Atef Abou Mrad & Bros",
"Last Subscription": "31-Jan-18",
"Industrial certificate no": "3794",
"Industrial certificate date": "10-Apr-18",
"ACTIVITY": "صناعة دهانات والمعاجين",
"Activity-L": "Manufacture of paints & putty",
"ADRESS": "ملك روجيه تمرز\u001c - حارة سالم\u001c - بسوس - عاليه",
"TEL1": "05/941419",
"TEL2": "03/610372",
"TEL3": "",
"internet": "aamrad@live.com"
},
{
"Category": "Excellent",
"Number": "1550",
"com-reg-no": "61116",
"NM": "شركة الجهاد للتجارة والتعهدات ش م ل",
"L_NM": "Al Jihad for Commerce & Contracting Co sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4314",
"Industrial certificate date": "15-Jul-18",
"ACTIVITY": "معملا للخراطة الميكانيكية / مقاولات البناء وصيانة البنى التحتية",
"Activity-L": "Turnery - Building contracting & maintenance of infrastructure",
"ADRESS": "هاربور تاور ملك العرب\u001c - جادة شارل الحلو\u001c - الصيفي - بيروت",
"TEL1": "01/444729",
"TEL2": "01/444728",
"TEL3": "",
"internet": "jihadco@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "1556",
"com-reg-no": "23985",
"NM": "جيلاتي كورتينا ش م ل",
"L_NM": "Gelati Cortina sal",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "3420",
"Industrial certificate date": "20-Feb-18",
"ACTIVITY": "صناعة البوظة والالبان والاجبان",
"Activity-L": "Manufacture of Ice cream & dairy products",
"ADRESS": "ملك الشركة\u001c - شارع مركز البحوث\u001c - الدكوانة - المتن",
"TEL1": "01/691872+5",
"TEL2": "03/223980",
"TEL3": "01/689942",
"internet": "gecort@yahoo.com"
},
{
"Category": "Excellent",
"Number": "191",
"com-reg-no": "27239",
"NM": "شركة مختبرات الفا ش م ل",
"L_NM": "Alfa Laboratories sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4525",
"Industrial certificate date": "23-Aug-18",
"ACTIVITY": "صناعة وتعقيم امصال طبية ومستوعبات زجاجية ومواد غسل الكلي مع اجهزتها",
"Activity-L": "Manufacture&sterilization of serums& ampuls&materials for lavaging kidneys",
"ADRESS": "ملك الشركة\u001c - المنطقة الصفراء - الشارع الداخلي\u001c - سهيلة - كسروان",
"TEL1": "09/235490",
"TEL2": "09/235492",
"TEL3": "03/411567",
"internet": "info@alfalabs.com.lb"
},
{
"Category": "Excellent",
"Number": "337",
"com-reg-no": "4212",
"NM": "شركة تامر اندستريز سلي ش م ل",
"L_NM": "Tamer Industries Slee sal",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4809",
"Industrial certificate date": "21-Oct-18",
"ACTIVITY": "صناعة مواد التجميل وتجارة جملة معدات لطب الاسنان وادوات مكتبية",
"Activity-L": "Manufacture of cosmetics/wholesale of dental instrument & stationery",
"ADRESS": "ملك شركة سيم ش م ل\u001c - شارع الميدان\u001c - الدكوانة - المتن",
"TEL1": "01/694000",
"TEL2": "",
"TEL3": "",
"internet": "cosmetics@tamerholding.com"
},
{
"Category": "Excellent",
"Number": "164",
"com-reg-no": "563",
"NM": "شركة الصناعات الخزفية اللبنانية ش م ل - ليسيكو",
"L_NM": "The Lebanese Ceramic Industries Co. sal - LECICO",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "284",
"Industrial certificate date": "25-Jul-18",
"ACTIVITY": "صناعة الادوات الصحية الخزفية والبورسلان والبلاط",
"Activity-L": "Manufacture of cecerqasanitary, porcelain & tiles",
"ADRESS": "ملك الشركة\u001c - المنطقة الصناعية - شارع نهر الغدير\u001c - كفرشيما - بعبدا",
"TEL1": "05/434222",
"TEL2": "05/431125",
"TEL3": "03/257800",
"internet": "lecico@dm.net.lb"
},
{
"Category": "Excellent",
"Number": "1006",
"com-reg-no": "67219",
"NM": "شركة الحرف الفنية  ش م ل",
"L_NM": "Métiers d\'Art sal",
"Last Subscription": "19-Jan-17",
"Industrial certificate no": "2425",
"Industrial certificate date": "17-Aug-17",
"ACTIVITY": "صياغة المجوهرات وتركيب الاحجار الكريمة",
"Activity-L": "Manufacture of jewellery and assorting of precious stones",
"ADRESS": "ملك شركة طانيوس سابا ش م ل\u001c - شارع ابراهيم باشا\u001c - المدور - بيروت",
"TEL1": "01/583980",
"TEL2": "01/583981",
"TEL3": "",
"internet": "christian.abi hanna@tabbah.com"
},
{
"Category": "Excellent",
"Number": "1028",
"com-reg-no": "56026",
"NM": "شركة الوباتك ش م ل",
"L_NM": "Alubatec sal",
"Last Subscription": "3-May-17",
"Industrial certificate no": "3898",
"Industrial certificate date": "28-Apr-18",
"ACTIVITY": "صناعة المنجورات المعدنية",
"Activity-L": "Manufacture of Metallic  panellings",
"ADRESS": "بناية لاند\u001c - شارع المعامل\u001c - المكلس - المتن",
"TEL1": "01/684647",
"TEL2": "01/684648",
"TEL3": "01/684649",
"internet": "alubatec@dm.net.lb"
},
{
"Category": "Excellent",
"Number": "205",
"com-reg-no": "1872/22476",
"NM": "مديترانيان اويل شيبنك اند ترانسبورت كومباني  مدكو ش م ل",
"L_NM": "Mediterranean Oil Shipping & Transport Company  Medco sal",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "4181",
"Industrial certificate date": "22-Jun-18",
"ACTIVITY": "تجارة جملة المحروقات والبترول والغاز السائل وتعبئة المحروقات الغازية",
"Activity-L": "Wholesale of fuel, petrol & gas liquid & filling of gaseous fuel",
"ADRESS": "ملك الشماس\u001c - شارع لبنان\u001c - مار مارون - بيروت",
"TEL1": "01/240984",
"TEL2": "01/581836",
"TEL3": "03/790367",
"internet": "medco@dm.net.lb"
},
{
"Category": "Excellent",
"Number": "206",
"com-reg-no": "16099",
"NM": "شركة فينيسيا للبترول ش م ل",
"L_NM": "Phoenicia Oil Company sal",
"Last Subscription": "2-Mar-18",
"Industrial certificate no": "2812",
"Industrial certificate date": "16-Mar-18",
"ACTIVITY": "تجارة جملة المحروقات وتعبئة المحروقات الغازية",
"Activity-L": "Wholesale of fuel & filling of gaseous fuels",
"ADRESS": "ملك شماس\u001c - شارع لبنان\u001c - التباريس - بيروت",
"TEL1": "01/443489",
"TEL2": "01/240984",
"TEL3": "01/581836",
"internet": "phoenicia@dm.net.lb"
},
{
"Category": "Excellent",
"Number": "196",
"com-reg-no": "12705",
"NM": "الشركة الجديدة للتجارة والصناعة ش م ل",
"L_NM": "Société Nouvelle pour le Commerce et L\'Industrie (S.N.C.I.)sal",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "271",
"Industrial certificate date": "24-Jan-19",
"ACTIVITY": "صناعة العطورات وادوات التجميل ومعجون الحلاقة ومنظفات",
"Activity-L": "Manufacture of perfumes,cosmetics&shaving cream&detergents",
"ADRESS": "بناية فتال\u001c - جسر الواطي - شارع ايكوشار\u001c - سن الفيل - المتن",
"TEL1": "01/492175",
"TEL2": "01/512002",
"TEL3": "01/485250",
"internet": "snci@fattal.com.lb"
},
{
"Category": "Excellent",
"Number": "239",
"com-reg-no": "7",
"NM": "شركة الكونتوار الزراعي للشرق- فؤاد سعاده وشركاه ش م ل",
"L_NM": "Comptoir Agricole du Levant - Fouad Saade & Co sal",
"Last Subscription": "1-Feb-18",
"Industrial certificate no": "2297",
"Industrial certificate date": "23-Apr-15",
"ACTIVITY": "تجارة جملة اسمدة وادوية زراعية",
"Activity-L": " Wholesale of fertilizers & medicines",
"ADRESS": "ملك رياض سعاده\u001c - حي المدور\u001c - الكرنتينا - بيروت",
"TEL1": "01/890811",
"TEL2": "01/899433",
"TEL3": "03/388128",
"internet": "executive@cal-rl.com"
},
{
"Category": "Excellent",
"Number": "221",
"com-reg-no": "64805",
"NM": "الشركة اللبنانية لمصنوعات الورق ش م ل",
"L_NM": "Lebanese Paper Products Co. sal",
"Last Subscription": "19-Jan-17",
"Industrial certificate no": "3864",
"Industrial certificate date": "24-Apr-18",
"ACTIVITY": "صناعة وتجارة الدفاتر وورق القرطاسية",
"Activity-L": "Manufacture & Trading of paper stationery",
"ADRESS": "ملك غندور ط3\u001c - النويري - شارع الاوزاعي\u001c - المزرعة - بيروت",
"TEL1": "01/842447",
"TEL2": "01/818522",
"TEL3": "01/273449",
"internet": "aoghando@gmail.com"
},
{
"Category": "Excellent",
"Number": "33",
"com-reg-no": "5526",
"NM": "شركة كيماويات لبنان ش م ل",
"L_NM": "Lebanon Chemicals Company sal",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "3999",
"Industrial certificate date": "18-May-18",
"ACTIVITY": "مصنعا لانتاج السماد والكيماويات",
"Activity-L": "Manufacture of fertilizers & chemical products",
"ADRESS": "بناية بولس فياض\u001c - شارع المارسيلياز\u001c - المرفأ - بيروت",
"TEL1": "01/580420",
"TEL2": "01/580421+22",
"TEL3": "03/294040",
"internet": "lcc@lebanonchemical.com"
},
{
"Category": "Excellent",
"Number": "371",
"com-reg-no": "61641",
"NM": "شركة المرطبات الوطنية ش م ل",
"L_NM": "National Beverage Company sal",
"Last Subscription": "19-Jan-17",
"Industrial certificate no": "4220",
"Industrial certificate date": "1-Jul-18",
"ACTIVITY": "تعبئة المرطبات  (كوكا كولا) وتصنيع شراب الفاكهة والخضار",
"Activity-L": "Bottling of soft drinks( coca cola) & fruit sirop",
"ADRESS": "ملك الشركة\u001c - حي الامراء - شارع الغدير\u001c - الشويفات - عاليه",
"TEL1": "05/438000",
"TEL2": "03/750203",
"TEL3": "",
"internet": "sultan.said@aujan.com"
},
{
"Category": "Excellent",
"Number": "209",
"com-reg-no": "1630",
"NM": "الشركة الصناعية للورق والكرتون المضلع - سيبكو ش م ل",
"L_NM": "Société Industrielle de Papier et de Carton Ondule SIPCO sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "307",
"Industrial certificate date": "31-Jan-19",
"ACTIVITY": "صناعة الكرتون المضلع والعلب وصناديق الكرتون والورق",
"Activity-L": "Manufacture of paperboard, boxes, carton & paper",
"ADRESS": "ملك غندور\u001c - شارع فيلمون وهبي\u001c - كفرشيما - بعبدا",
"TEL1": "05/430675",
"TEL2": "05/433553",
"TEL3": "",
"internet": "sipco@sipcolb.com"
},
{
"Category": "Excellent",
"Number": "207",
"com-reg-no": "17204",
"NM": "شركة قرطاس للمعلبات والتبريد ش م ل",
"L_NM": "Cortas Canning & Refrigerating Co. sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "140",
"Industrial certificate date": "8-Jul-18",
"ACTIVITY": "معملا للمربيات والشرابات والمواد الغذائية المعلبة",
"Activity-L": "Manufacture of jams, beverages &canned foodstuffs",
"ADRESS": "ملك الشركة\u001c - اوتوستراد الدورة\u001c - البوشرية - المتن",
"TEL1": "01/257171",
"TEL2": "",
"TEL3": "",
"internet": "sbitar@cortas.net"
},
{
"Category": "Fourth",
"Number": "31301",
"com-reg-no": "2041326",
"NM": "سكاي سكرابر",
"L_NM": "Skyscraper",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "4009",
"Industrial certificate date": "20-May-18",
"ACTIVITY": "تجارة منجور حديد وحدادة وانشاءات معدنية",
"Activity-L": "Trading of iron panels, Smithery & metallic structure",
"ADRESS": "بناية نبيل صفا\u001c - المنطقة الصناعية\u001c - بعبدات - المتن",
"TEL1": "01/215008",
"TEL2": "03/440648",
"TEL3": "",
"internet": "safanabil@hotmai.com"
},
{
"Category": "First",
"Number": "4268",
"com-reg-no": "35490",
"NM": "زكا مولتيتك ش م م",
"L_NM": "Zakka Multitec sarl",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "3885",
"Industrial certificate date": "25-Oct-17",
"ACTIVITY": "تجارة جملة ماكينات التعبئة والتعليب",
"Activity-L": "Wholesale of packing machinery",
"ADRESS": "ملك سعيد جان زكا الخوري سفلي3\u001c - شارع ابو حلقة\u001c - الفنار - المتن",
"TEL1": "01/890654",
"TEL2": "01/870941+42",
"TEL3": "03/925521",
"internet": "info@zakkamultitec.com"
},
{
"Category": "Second",
"Number": "6038",
"com-reg-no": "41921",
"NM": "الشركة اللبنانية للصناعة والتوضيب ش م م - الكو",
"L_NM": "Arrangement & Industry Lebanese Company sarl A.I.L.Co",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "172",
"Industrial certificate date": "11-Jan-19",
"ACTIVITY": "صناعة المفروشات - فك وتوضيب ونقل وتركيب اثاث وتجهيزات مكتبية",
"Activity-L": "Manufacture of furniture - Packing & Local Transport",
"ADRESS": "بناية حدشيتي\u001c - شارع السيدة\u001c - رأس الدكوانة - المتن",
"TEL1": "01/684650",
"TEL2": "03/612789",
"TEL3": "03/420520",
"internet": "ailco@ailcogroup.com"
},
{
"Category": "Second",
"Number": "5361",
"com-reg-no": "2021526",
"NM": "انترديزاين كونتراكت ش م ل",
"L_NM": "Interdesign Contract sal",
"Last Subscription": "20-Jan-17",
"Industrial certificate no": "4248",
"Industrial certificate date": "6-Jul-18",
"ACTIVITY": "صناعة المفروشات الخشبية والمنزلية",
"Activity-L": "manufacture of wooden and home furniture",
"ADRESS": "بناية غصن واكيم\u001c - حي المعامل - شارع الغصون\u001c - المنصورية - المتن",
"TEL1": "04/400568",
"TEL2": "03/244424",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "28381",
"com-reg-no": "2012811",
"NM": "شركة اندستريال ميتال باكدجينغ ش م م",
"L_NM": "Industrial Metal Packaging Co. sarl",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "6483646",
"Industrial certificate date": "21-Mar-19",
"ACTIVITY": "صناعة علب التنك",
"Activity-L": "Manufacture of tins",
"ADRESS": "ملك المزعفل\u001c - المنطقة الصناعية\u001c - حارة الناعمة - الشوف",
"TEL1": "05/602250",
"TEL2": "03/948899",
"TEL3": "",
"internet": "brifcoint@yahoo.com"
},
{
"Category": "Third",
"Number": "27747",
"com-reg-no": "2018155",
"NM": "فيديا ماستر برو ش م م",
"L_NM": "Videa Master Pro - sarl",
"Last Subscription": "4-Apr-17",
"Industrial certificate no": "3295",
"Industrial certificate date": "4-Feb-18",
"ACTIVITY": "صناعة خراطة فنية وقطع وقوالب معدنية",
"Activity-L": "Manufacture of turnery and metal moulding",
"ADRESS": "ملك جان عازار\u001c - المنطقة الصناعية - الشارع العام\u001c - زوق مصبح - كسروان",
"TEL1": "09/218945+6",
"TEL2": "03/889837",
"TEL3": "",
"internet": "robert@videamaster.com"
},
{
"Category": "First",
"Number": "4923",
"com-reg-no": "73730",
"NM": "شركة كات اند ماوث ش م ل",
"L_NM": "Cat and Mouth sal",
"Last Subscription": "15-Jan-18",
"Industrial certificate no": "330",
"Industrial certificate date": "5-Feb-19",
"ACTIVITY": "صناعة الحلويات العربية والافرنجية والمأكولات المحضرة",
"Activity-L": "Manufacture of oriental & western sweets & catering",
"ADRESS": "بناية الف\u001c - شارع سيف الدين\u001c - الاشرفية - بيروت",
"TEL1": "01/424484",
"TEL2": "01/424485",
"TEL3": "03/452777",
"internet": "info@catandmouth.com"
},
{
"Category": "Second",
"Number": "1573",
"com-reg-no": "15156",
"NM": "كوكو بلاست - تضامن",
"L_NM": "Koko Plast",
"Last Subscription": "16-Dec-17",
"Industrial certificate no": "13",
"Industrial certificate date": "12-Dec-18",
"ACTIVITY": "صناعة الانابيب البلاستيكية",
"Activity-L": "Manufacture of plastic tubes",
"ADRESS": "بناية عبيد اخوان\u001c - المدينة الصناعية\u001c - سد البوشرية - المتن",
"TEL1": "01/497893",
"TEL2": "01/500933",
"TEL3": "03/688296",
"internet": "saro@cyberia.net.lb"
},
{
"Category": "Third",
"Number": "15467",
"com-reg-no": "40917",
"NM": "شركة مايسترو للصناعة والتجارة العامة ش م م",
"L_NM": "Maestro for General Trade & Industry Co. sarl",
"Last Subscription": "27-Jan-17",
"Industrial certificate no": "4077",
"Industrial certificate date": "5-Jun-18",
"ACTIVITY": "صناعة الاحذية الرجالية والولادية",
"Activity-L": "Manufacture of men\'s & children\'s shoes",
"ADRESS": "ملك حسن ووائل ريس\u001c - شارع الكفاءات\u001c - الحدث - بعبدا",
"TEL1": "03/215873",
"TEL2": "01/558784",
"TEL3": "05/464360",
"internet": "rayisswael@hotmail.com"
},
{
"Category": "Third",
"Number": "25649",
"com-reg-no": "18872",
"NM": "الف - شركة توصية بسيطة",
"L_NM": "Aleph Co.",
"Last Subscription": "31-Mar-17",
"Industrial certificate no": "3657",
"Industrial certificate date": "21-Mar-18",
"ACTIVITY": "مطبعة تجارية",
"Activity-L": "Printing press",
"ADRESS": "بناية سيزار اليان\u001c - شارع رقم 10\u001c - المكلس - المتن",
"TEL1": "01/685354",
"TEL2": "01/685355",
"TEL3": "",
"internet": "aleph@sodetel.net.lb"
},
{
"Category": "Third",
"Number": "7799",
"com-reg-no": "5826",
"NM": "براشيا للشرق الاوسط",
"L_NM": "Brescia Middle East",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "3484",
"Industrial certificate date": "25-Feb-18",
"ACTIVITY": "تجارة جملة البسة ولوازم صيد وذخيرة وتعبئة خرطوش الصيد",
"Activity-L": "Wholesale of hunting clothes, equipment,weapons&ammunitions & filling of it",
"ADRESS": "ملك ابي صعب\u001c - غادير - الاوتوستراد\u001c - جونيه - كسروان",
"TEL1": "09/636896",
"TEL2": "03/257123",
"TEL3": "",
"internet": "bme-arm@bme.com.lb"
},
{
"Category": "Third",
"Number": "13996",
"com-reg-no": "58330",
"NM": "شركة اوريجينال ترانس للتجارة والصناعة ش م م",
"L_NM": "Original Trans Company for Commercial & Industry sarl",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "3078",
"Industrial certificate date": "5-Jan-18",
"ACTIVITY": "تجارة جملة التمديدات الكهربائية وتجميع المحولات الكهربائية",
"Activity-L": "Assembling of transformers -Whole. of equipment for electrical installation",
"ADRESS": "ملك خباز\u001c - شارع البستاني- قرب مدرسة عائشة ام المؤمنين\u001c - الحرج - بيروت",
"TEL1": "01/633958",
"TEL2": "01/645669",
"TEL3": "",
"internet": "originaltrans@gmail.com"
},
{
"Category": "Second",
"Number": "3287",
"com-reg-no": "50793",
"NM": "مؤسسة عينبال للتجارة والصناعة",
"L_NM": "Ainbal Est. For Trade & Industry",
"Last Subscription": "13-Sep-17",
"Industrial certificate no": "4533",
"Industrial certificate date": "25-Aug-18",
"ACTIVITY": "تجارة جملة علف وبيض ودجاج ومعملا للعلف",
"Activity-L": "Wholesale of animal feed, eggs & chicken and manufacture of animal feeds",
"ADRESS": "ملك بشير عبد الباقي\u001c - خلف المركز الطبي\u001c - السمقانية - الشوف",
"TEL1": "05/304102",
"TEL2": "03/231892",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "4910",
"com-reg-no": "26358",
"NM": "شركة الدهانات العامة ش م ل",
"L_NM": "General Paint Co. sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "398",
"Industrial certificate date": "19-Feb-19",
"ACTIVITY": "صناعة الدهانات والبويا للسيارات",
"Activity-L": "Manufacture of paints & car paints",
"ADRESS": "ملك الشركة\u001c - شارع بيار حلو\u001c - الحازمية - بعبدا",
"TEL1": "09/925990",
"TEL2": "09/925991",
"TEL3": "09/925992",
"internet": "info@generalpaint.biz"
},
{
"Category": "Excellent",
"Number": "1721",
"com-reg-no": "26590",
"NM": "ديابيبر ش م ل",
"L_NM": "Diapaper sal",
"Last Subscription": "23-Jan-18",
"Industrial certificate no": "4484",
"Industrial certificate date": "12-Aug-18",
"ACTIVITY": "صناعة الورق والكرتون وتجارة جملة الكرتون والقرطاسية",
"Activity-L": "Manufacture of paper & paperboard, & Wholesale of paperboard & stationery",
"ADRESS": "ملك العقارية الوطنية للانماء ش م ل - ط3\u001c - شارع المصانع\u001c - المكلس - المتن",
"TEL1": "01/683004",
"TEL2": "01/683005+6",
"TEL3": "",
"internet": "diapaper@dm.net.lb"
},
{
"Category": "Excellent",
"Number": "294",
"com-reg-no": "40228",
"NM": "الشركة العالمية لصناعة الدهانات والمواد الكيماوية كميبنت ش م م",
"L_NM": "Universal Paint & Chemical Industries - Chemipaint sarl",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4674",
"Industrial certificate date": "5-Apr-18",
"ACTIVITY": "صناعة وتجارة الدهانات ومشتقاتها",
"Activity-L": "Manufacture & Trading of paints, varnishes, silicon & sealant caulk",
"ADRESS": "ملك البزري\u001c - شارع اللبان\u001c - الحمراء - بيروت",
"TEL1": "03/922211",
"TEL2": "03/653135",
"TEL3": "05/807020",
"internet": "chemipaint@chemipaint.com"
},
{
"Category": "First",
"Number": "2497",
"com-reg-no": "5674",
"NM": "سوناكو ش م م",
"L_NM": "Sonaco sarl",
"Last Subscription": "21-Feb-18",
"Industrial certificate no": "4978",
"Industrial certificate date": "5-Dec-18",
"ACTIVITY": "صناعة حلاوة وطحينة وراحة وتعليب مواد غذائية ومربى وشراب",
"Activity-L": "Manufacture of halawa,tahina & canned food",
"ADRESS": "ملك الشركة\u001c - حارة البلانة\u001c - ضبيه - المتن",
"TEL1": "04/541207",
"TEL2": "04/541208",
"TEL3": "",
"internet": "sonaco@alrabih.com.lb"
},
{
"Category": "First",
"Number": "4528",
"com-reg-no": "21929",
"NM": "دار بلال للطباعة والنشر ش م م",
"L_NM": "Dar Bilal for Printing & Publishing sarl",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "3615",
"Industrial certificate date": "15-Mar-18",
"ACTIVITY": "اعمال طباعة الكتب والمجلات",
"Activity-L": "Printing ( Books and Magazines)",
"ADRESS": "ملك جمعية امل المحرومين\u001c - شارع السفارات\u001c - بئر حسن - بعبدا",
"TEL1": "01/826937",
"TEL2": "01/853638",
"TEL3": "03/650850",
"internet": "b.852868@gmail.com"
},
{
"Category": "Excellent",
"Number": "122",
"com-reg-no": "101",
"NM": "شركة صناعة التغليف سيديما ش م ل",
"L_NM": "Sidema - Industrie de L\'emballage sal",
"Last Subscription": "3-Feb-17",
"Industrial certificate no": "2358",
"Industrial certificate date": "11-Feb-18",
"ACTIVITY": "صناعة علب وصناديق الكرتون والطباعة عليها",
"Activity-L": "Manufacture of carton boxes",
"ADRESS": "ملك الشركة\u001c - شارع الكنائس\u001c - المكلس - المتن",
"TEL1": "01/684575",
"TEL2": "01/684576",
"TEL3": "01/684577",
"internet": "nabilkar@sodetel.net.lb"
},
{
"Category": "Third",
"Number": "23441",
"com-reg-no": "52797",
"NM": "شركة قزاز للرخام",
"L_NM": "Kazzaz Marble Co",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "4518",
"Industrial certificate date": "22-Aug-18",
"ACTIVITY": "معملا لنشر وتفصيل الصخور والرخام",
"Activity-L": "Manufacture of rocks and marbles",
"ADRESS": "ملك ميسون سريدار وعصام قزاز\u001c - الشارع العام\u001c - بعورته - عاليه",
"TEL1": "05/602021",
"TEL2": "05/602022",
"TEL3": "03/821160",
"internet": "kazzazmarble@gmail.com"
},
{
"Category": "Second",
"Number": "6099",
"com-reg-no": "2002797",
"NM": "شركة ميرنا للتجارة ش م م",
"L_NM": "Société Mirna pour le Commerce sarl",
"Last Subscription": "30-Jan-18",
"Industrial certificate no": "3878",
"Industrial certificate date": "25-Apr-18",
"ACTIVITY": "معملا لحفظ المواد الغذائية والبهارات - تجارة ثمار البحر ومواد غذائية مثلجة",
"Activity-L": "Packing and preserving of food &spices-trading of sea food&frozen food",
"ADRESS": "بناية سانتا ماريا\u001c - الشارع العام\u001c - الفنار - المتن",
"TEL1": "01/683221",
"TEL2": "01/691522",
"TEL3": "03/821216",
"internet": ""
},
{
"Category": "Third",
"Number": "23635",
"com-reg-no": "2004980",
"NM": "مؤسسة اميل عبيد",
"L_NM": "Ets Emile Obeid",
"Last Subscription": "27-Feb-17",
"Industrial certificate no": "1189",
"Industrial certificate date": "26-Jan-18",
"ACTIVITY": "تنجيد المفروشات",
"Activity-L": "Upholstery of furniture",
"ADRESS": "ملك حداد وقطيط\u001c - حرش ثابت\u001c - سن الفيل - المتن",
"TEL1": "01/502519",
"TEL2": "03/743838",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "23641",
"com-reg-no": "73073",
"NM": "شركة أ ك ت - قطرنجي اخوان - شركة توصية بسيطة",
"L_NM": "E.K.T - Katrangi Bros",
"Last Subscription": "24-Apr-17",
"Industrial certificate no": "2852",
"Industrial certificate date": "16-Nov-17",
"ACTIVITY": "تصنيع وتجميع ادوات الكترونية ولوحات اعلانية ضوئية",
"Activity-L": "Manufacture of electronic boards and signs",
"ADRESS": "ملك حجيج\u001c - كورنيش المزرعة\u001c - المزرعة - بيروت",
"TEL1": "01/823023",
"TEL2": "01/820020",
"TEL3": "",
"internet": "maher@ekt2.com"
},
{
"Category": "First",
"Number": "4578",
"com-reg-no": "1004168",
"NM": "مجوهرات المولى ش م م",
"L_NM": "Mawla Jewellery sarl",
"Last Subscription": "6-Feb-18",
"Industrial certificate no": "391",
"Industrial certificate date": "15-Feb-19",
"ACTIVITY": "صناعة المجوهرات",
"Activity-L": "Manufacture of jewelry",
"ADRESS": "ملك الخوري وكالوسيان\u001c - االحمراء - شارع نعمت يافت\u001c - رأس بيروت - بيروت",
"TEL1": "01/742444",
"TEL2": "01/347510",
"TEL3": "03/739009",
"internet": "mawlajewellery@hotmail.com"
},
{
"Category": "First",
"Number": "4999",
"com-reg-no": "68167",
"NM": "شركة لينكس للتوزيع  ش م م",
"L_NM": "Lynx Distribution Company sarl",
"Last Subscription": "5-Mar-18",
"Industrial certificate no": "4048",
"Industrial certificate date": "30-May-18",
"ACTIVITY": "صناعة اللفائف اللاصقة والسييلكون",
"Activity-L": "Manufacture of adhesive rolls & Silicone",
"ADRESS": "ملك زغيب \u001c - المنطقة الصناعية\u001c - زوق مصبح - كسروان",
"TEL1": "03/273188",
"TEL2": "",
"TEL3": "",
"internet": "ldc-lynx@inco.com.lb"
},
{
"Category": "Third",
"Number": "22100",
"com-reg-no": "72843",
"NM": "شركة المهندسون السويسريون في لبنان - سيل - ش م م",
"L_NM": "Swiss Ingenieurs Liban - Sil - sarl",
"Last Subscription": "9-May-17",
"Industrial certificate no": "2195",
"Industrial certificate date": "4-Jul-17",
"ACTIVITY": "تعهدات الهندسة الكهربائية وصناعة اجهزة سحب الرطوبة وبخ للحشرات وApsوUPS",
"Activity-L": "Elec. enterprises/ take out of humidity,spray of insect. machines &Aps& UPS",
"ADRESS": "ملك طانيوس الراعي\u001c - مقابل شركة بون جوس\u001c - الفنار - المتن",
"TEL1": "01/901742",
"TEL2": "03/621969",
"TEL3": "03/996947",
"internet": "siliban@cyberia.net.lb"
},
{
"Category": "Second",
"Number": "4256",
"com-reg-no": "2001862",
"NM": "العبيكان لبنان ش م م",
"L_NM": "Al Obeikan Lebanon sarl",
"Last Subscription": "31-Aug-17",
"Industrial certificate no": "4535",
"Industrial certificate date": "28-Aug-18",
"ACTIVITY": "صناعة مواد التغليف",
"Activity-L": "Manufacture of packing materials",
"ADRESS": "ملك العبيكان\u001c - طريق عام جدرا  - المنطقة الصناعية\u001c - جدرا - الشوف",
"TEL1": "07/995335",
"TEL2": "03/819777",
"TEL3": "07/974199",
"internet": "omar.sibai@obeikan.com.sa"
},
{
"Category": "Fourth",
"Number": "28433",
"com-reg-no": "2024596",
"NM": "برو بلاس كرييتيف (شركة تضامن)",
"L_NM": "Pro Plus Creative",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "3905",
"Industrial certificate date": "3-May-18",
"ACTIVITY": "تجارة حقائب، قبعات وعلب دعائية مطبوعة",
"Activity-L": "Trading of promotional items ( bags, hat & boxes)",
"ADRESS": "مبنى عبود - ملك صبرا\u001c - السبتيه - شارع الشرق الاوسط\u001c - البوشرية - المتن",
"TEL1": "03/810018",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "4877",
"com-reg-no": "62024",
"NM": "مؤسسة عمر الشامي واولاده للصناعة والتجارة ش م م",
"L_NM": "Omar Chami & Sons Est. For Industry & Trade sarl",
"Last Subscription": "29-Jan-18",
"Industrial certificate no": "270",
"Industrial certificate date": "24-Jan-19",
"ACTIVITY": "صناعة الاشبمانات والمواسير",
"Activity-L": "Manufacture of exhaust muffer & tubes",
"ADRESS": "بناية الطبش ملك عثمان وهيثم الشامي\u001c - شارع جنبلاط\u001c - مار الياس - بيروت",
"TEL1": "01/703523",
"TEL2": "03/226237",
"TEL3": "03/226239",
"internet": "tala_baa@live.com"
},
{
"Category": "Second",
"Number": "6124",
"com-reg-no": "176",
"NM": "شركة كمبرو صهيون وشركاه",
"L_NM": "Commercial Promoters - Compro - Sahyoun & Co",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "3426",
"Industrial certificate date": "20-Feb-18",
"ACTIVITY": "صناعة المواد اللآصقة والغراء",
"Activity-L": "Manufacture of glues",
"ADRESS": "ملك ورثة ارميناك قره كوزيان\u001c - شارع سامي الصلح\u001c - المكلس - المتن",
"TEL1": "01/686422",
"TEL2": "01/682832",
"TEL3": "01/500926",
"internet": "compro@inco.com.lb"
},
{
"Category": "Excellent",
"Number": "210",
"com-reg-no": "90",
"NM": "شركة م . ع. غندور واولاده ش م ل",
"L_NM": "M.O. Ghandour & Sons sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4717",
"Industrial certificate date": "12-Oct-18",
"ACTIVITY": "صناعة سكاكر وشوكولا وبسكويت وحلاوة وطحينه وعصير وزيت وسمن نباتي",
"Activity-L": "Manufacture of candies,chocolate,halawa,tahina, biscuits, juice, oil & fat",
"ADRESS": "بناية غندور\u001c - طريق صيدا القديمة\u001c - الشويفات - عاليه",
"TEL1": "05/433500",
"TEL2": "05/431054",
"TEL3": "03/204486",
"internet": "info@gandour.com"
},
{
"Category": "First",
"Number": "277",
"com-reg-no": "10363",
"NM": "شركة ماستر للعلكة والسكاكر ش م ل",
"L_NM": "Master Chewing Gum & Candies Factories sal",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "2962",
"Industrial certificate date": "12-May-18",
"ACTIVITY": "صناعة العلكة والسكاكر وتجارة عصير الفاكهة",
"Activity-L": "Manufacture of chewing-gum & candies & trading of juice",
"ADRESS": "ملك غندور\u001c - شارع فيلمون وهبي\u001c - كفرشيما - بعبدا",
"TEL1": "05/436888",
"TEL2": "05/437130",
"TEL3": "05/437132",
"internet": "master@mastergum.com"
},
{
"Category": "Excellent",
"Number": "972",
"com-reg-no": "4346",
"NM": "مختبرات مدي فار - توصية بسيطة",
"L_NM": "Mediphar Laboratories",
"Last Subscription": "2-Feb-18",
"Industrial certificate no": "301",
"Industrial certificate date": "29-Jan-19",
"ACTIVITY": "صناعة الادوية",
"Activity-L": "Manufacture of medicines",
"ADRESS": "ملك ورثة حبيب فاضل\u001c - زوق الخراب - الشارع العام\u001c - الضبيه - المتن",
"TEL1": "04/543715",
"TEL2": "04/540717",
"TEL3": "04542821",
"internet": "mediphar@medipharlabs.com"
},
{
"Category": "Second",
"Number": "6089",
"com-reg-no": "26142",
"NM": "شركة بنكار - شركة توصية بسيطة",
"L_NM": "Benkar & Co",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "3867",
"Industrial certificate date": "24-Apr-18",
"ACTIVITY": "صناعة جبالات الباطون، قوالب صب الباطون ومعدات صب احجار الباطون",
"Activity-L": "Manufacture of machineries for construction concrete mixers, …",
"ADRESS": "بناية ماضي ويزبك\u001c - المدينة الصناعية - شارع الكهرباء\u001c - سد البوشرية - المتن",
"TEL1": "01/880609",
"TEL2": "01/880601",
"TEL3": "03/706213",
"internet": "benkar@idm.net.lb"
},
{
"Category": "First",
"Number": "4053",
"com-reg-no": "32245",
"NM": "بي اند بي  - بيبس اند بمبس",
"L_NM": "P & P - Pipes & Pumpes",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "072",
"Industrial certificate date": "21-Dec-18",
"ACTIVITY": "تنفيد التعهدات المدنية - معملا لتجميع مضخات ومولدات وتابلوهات كهربائية",
"Activity-L": "Gathering of pumps, generators & electrical boards - Civil contracting",
"ADRESS": "ملك جوزف نعيمه\u001c - نهر الموت\u001c - الجديدة - المتن",
"TEL1": "01/873935",
"TEL2": "01/872972",
"TEL3": "01/872871",
"internet": "eliefr@tajjgroup.com"
},
{
"Category": "First",
"Number": "5010",
"com-reg-no": "58064",
"NM": "ايبكو - شركة البلاستيك الصناعية ش م ل",
"L_NM": "Ipco Industrial Plastics Co. sal",
"Last Subscription": "3-Mar-17",
"Industrial certificate no": "3783",
"Industrial certificate date": "7-Apr-18",
"ACTIVITY": "صناعة اكياس وادوات مطبخية بلاستيكية",
"Activity-L": "Manufacture of plastic bags & kitchenware",
"ADRESS": "ملك انطوان معلوف وشركاه\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/497312",
"TEL2": "",
"TEL3": "",
"internet": "ipco@inco.com.lb"
},
{
"Category": "Third",
"Number": "22175",
"com-reg-no": "64439",
"NM": "شركة سافاري الومينيوم ش م م",
"L_NM": "Safari Aluminum sarl",
"Last Subscription": "27-Feb-18",
"Industrial certificate no": "3167",
"Industrial certificate date": "18-Jan-18",
"ACTIVITY": "تجارة منجور الومنيوم",
"Activity-L": "Trading of aluminium panelling",
"ADRESS": "ملك وقف مار فوقا\u001c - منطقة المعامل\u001c - حصرايل - جبيل",
"TEL1": "09/791799",
"TEL2": "09/790799",
"TEL3": "03/886683",
"internet": "safarialuminium@hotmail.com"
},
{
"Category": "First",
"Number": "4756",
"com-reg-no": "72607",
"NM": "اليكسكو ش م م خبراء الالمنيوم كومباني",
"L_NM": "Alexco sarl Almunium Experts Company",
"Last Subscription": "18-Apr-17",
"Industrial certificate no": "4631",
"Industrial certificate date": "20-Sep-18",
"ACTIVITY": "صناعة المنجور المعدني",
"Activity-L": "Manufacture of metallic panelling",
"ADRESS": "بناية الاعور\u001c - المدينة الصناعية\u001c - عاليه",
"TEL1": "05/550250",
"TEL2": "70/111033",
"TEL3": "",
"internet": "info@alexcolebanon.com"
},
{
"Category": "First",
"Number": "4303",
"com-reg-no": "1016154",
"NM": "شركة زهير مراد ش م م",
"L_NM": "Zuhair Murad sarl",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4161",
"Industrial certificate date": "19-Jun-18",
"ACTIVITY": "تصميم وخياطة الالبسة النسائية",
"Activity-L": "Designing & sewing of ladies clothes",
"ADRESS": "سنتر زهير مراد\u001c - جادة شارل حلو\u001c - المدور - بيروت",
"TEL1": "01/575222",
"TEL2": "01/575333",
"TEL3": "",
"internet": "info@zuhairmurad.com"
},
{
"Category": "Second",
"Number": "6660",
"com-reg-no": "6074",
"NM": "المؤسسة اللبنانية للطباعة والتجليد والتجارة العامة - ا.ل.ي.ر",
"L_NM": "Entreprise Libanaise D\'Impression et de Reliure - Commerce Generale E.L.I.R",
"Last Subscription": "11-Feb-17",
"Industrial certificate no": "1642",
"Industrial certificate date": "5-Apr-17",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "ملك صواف ومصري\u001c - جسر الواطي\u001c - سن الفيل - المتن",
"TEL1": "01/492034",
"TEL2": "01/492311",
"TEL3": "03/434252",
"internet": "r_aoun@hotmail.com"
},
{
"Category": "Third",
"Number": "11135",
"com-reg-no": "22786",
"NM": "ايفا ساك",
"L_NM": "Eva Sacs",
"Last Subscription": "3-Mar-17",
"Industrial certificate no": "3125",
"Industrial certificate date": "14-Jan-18",
"ACTIVITY": "صناعة الجزادين والمصنوعات الجلدية",
"Activity-L": "Manufacture of leather handbags",
"ADRESS": "ملك اشجيان\u001c - الشارع العام\u001c - برج حمود - المتن",
"TEL1": "01/260479",
"TEL2": "03/274868",
"TEL3": "",
"internet": "info@sergiohandbags.com"
},
{
"Category": "Third",
"Number": "17511",
"com-reg-no": "13027",
"NM": "شركة ريكان العالمية المحدودة المسؤولية ش م م",
"L_NM": "Rikan International Limited Co. SARL",
"Last Subscription": "1-Mar-17",
"Industrial certificate no": "1882",
"Industrial certificate date": "14-May-17",
"ACTIVITY": "صناعة مستحضرات التجميل ومساحيق التنظيف والشامبوان",
"Activity-L": "Cosmetics , Shampoo& Detergents Industry",
"ADRESS": "ملك ورثة انطوان الكك\u001c - الروضه \u001c - البوشرية  - المتن",
"TEL1": "01/689005",
"TEL2": "01/689006",
"TEL3": "",
"internet": "rikan@rikan.net.lb"
},
{
"Category": "Excellent",
"Number": "1569",
"com-reg-no": "77615",
"NM": "شركة M.M. Sinno & Sons sal",
"L_NM": "M.M. Sinno & Sons sal",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "4743",
"Industrial certificate date": "17-Oct-18",
"ACTIVITY": "تجارة جملة مواد غذائية وتوضيب الحبوب والشاي واللحوم",
"Activity-L": "Wholesale of foodstuffs & packing of cereals & tea & meat",
"ADRESS": "بناية سنو ط 1 و 2\u001c - شارع نعمة يافت\u001c - الحمراء - بيروت",
"TEL1": "01/755444",
"TEL2": "03/909040",
"TEL3": "05/803444",
"internet": "mmsinno@mmsinno.com"
},
{
"Category": "Second",
"Number": "6111",
"com-reg-no": "45407",
"NM": "Electronic Systems",
"L_NM": "Electronic Systems",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4552",
"Industrial certificate date": "28-Aug-18",
"ACTIVITY": "تعهدات هندسة كهربائية- صناعة الماكينات المعطرة ومنظمات كهربائية",
"Activity-L": "Electrical engineering - manufact. of perfume machines diffusers, UPS & APS",
"ADRESS": "ملك فادي الحسيني\u001c - حي عواد - شارع المطران\u001c - سن الفيل - المتن",
"TEL1": "01/261222",
"TEL2": "03/669468",
"TEL3": "",
"internet": "es@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "830",
"com-reg-no": "65563",
"NM": "شركة شهاب للغازات الصناعية والطبية ش م ل",
"L_NM": "Chehab Industrial & Medical Gazes sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "451",
"Industrial certificate date": "22-Feb-19",
"ACTIVITY": "صناعة وتجارة الغازات الطبية والصناعية",
"Activity-L": "Manufacture& trading of medical & industrial gases",
"ADRESS": "ملك شهاب اخوان\u001c - شارع نجيب حبيقة\u001c - الصيفي - بيروت",
"TEL1": "01/447584",
"TEL2": "01/449584",
"TEL3": "03/674548",
"internet": "cbgaz@chehab-bros.com"
},
{
"Category": "Excellent",
"Number": "26",
"com-reg-no": "650",
"NM": "الشركة العصرية اللبنانية للتجارة المساهمة ش م ل",
"L_NM": "Société Moderne Libanaise Pour le Commerce sal",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "2772",
"Industrial certificate date": "6-Apr-18",
"ACTIVITY": "تعبئة المرطبات والمياه الغازية والعصير (بيبسي كولا)وجملة السكاكر والشوكولا",
"Activity-L": "Bottling of soft drinks,soda water& juice( Pepsi Cola)w. of confectionery",
"ADRESS": "ملك الشركة\u001c - طريق دمشق القديم - شارع وادي خطار\u001c - الحازمية - بعبدا",
"TEL1": "05/433900",
"TEL2": "05/433135",
"TEL3": "05/453100",
"internet": "w.abuhadeer@smlc.com.lb"
},
{
"Category": "Third",
"Number": "6224",
"com-reg-no": "24530",
"NM": "شركة مالك اخوان وشركاهم ش م م",
"L_NM": "Malek Bros & Co.sarl",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "2647",
"Industrial certificate date": "21-Mar-18",
"ACTIVITY": "طحن وتعبئة البهارات والشاي والزهورات وصناعة الشامبو والكريمات",
"Activity-L": "Grinding of spices Tea & herbs -manufacture of shampoo & cream",
"ADRESS": "ملك خليل ابو جوده\u001c - مار تقلا\u001c - بقنايا - المتن",
"TEL1": "04/711294",
"TEL2": "",
"TEL3": "",
"internet": "info@malekbros.com"
},
{
"Category": "Second",
"Number": "4488",
"com-reg-no": "962",
"NM": "مؤسسة ميشال نجيم ش م ل",
"L_NM": "Ets. Michel Noujaim sal",
"Last Subscription": "28-Feb-18",
"Industrial certificate no": "4227",
"Industrial certificate date": "3-Jul-18",
"ACTIVITY": "صناعة سدادات معدنية وعبوات بلاستيكية",
"Activity-L": "Manufacture of metal stoppers and plastic cans",
"ADRESS": "ملك يونس\u001c - شارع العسيلى\u001c - الرميل - بيروت",
"TEL1": "01/683084",
"TEL2": "01/689032",
"TEL3": "",
"internet": "emnjaim@sodetel.net.lb"
},
{
"Category": "Second",
"Number": "6670",
"com-reg-no": "7310",
"NM": "كلزي وشركاه ش م ل",
"L_NM": "Kilzi & Co. sal",
"Last Subscription": "11-Aug-17",
"Industrial certificate no": "4352",
"Industrial certificate date": "22-Jul-18",
"ACTIVITY": "معملا للفلين العازل ومواد البيوت الجاهزة",
"Activity-L": "Manufacture of Insulator cork & prefabricated house materials",
"ADRESS": "بناية كلزي\u001c - الفنار - شارع كنيسة السيدة - قرب معمل جونال\u001c - عين سعادة  - المتن",
"TEL1": "01/885750",
"TEL2": "01/885180",
"TEL3": "03/896669",
"internet": "info@kilzico.com"
},
{
"Category": "First",
"Number": "4988",
"com-reg-no": "16565",
"NM": "شركة نحاس للصناعة والتجارة - سنيك - شركة توصية بسيطة",
"L_NM": "Société Nahas Pour L\'industrie Et Le Commerce SNIC",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "3830",
"Industrial certificate date": "18-Apr-18",
"ACTIVITY": "معملا لانتاج الرافعات والمكابس ومناشرللحديد ونحت الحجر",
"Activity-L": "Manufacture of cranes, compressors & saws",
"ADRESS": "ملك الشركة\u001c - المنطقة الصناعية\u001c - عين سعاده - المتن",
"TEL1": "01/878800",
"TEL2": "03/652783",
"TEL3": "01/890696",
"internet": "snic@dm.net.lb"
},
{
"Category": "Excellent",
"Number": "1259",
"com-reg-no": "44667",
"NM": "شركة اطياب ش م م",
"L_NM": "Atyab sarl",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "3275",
"Industrial certificate date": "2-Feb-18",
"ACTIVITY": "انتاج وتعبئة المكابيس وماء الزهر والورد والمربى والزيوت والشرابات والمشروب",
"Activity-L": "Manufacture of pickles, orange-flower & rose water, jams, oils & drinks",
"ADRESS": "ملك بولس مارون\u001c - الشارع العام\u001c - زوق مكايل - كسروان",
"TEL1": "09/918525",
"TEL2": "03/629429",
"TEL3": "09/910090",
"internet": "info@zeitboulos.com"
},
{
"Category": "Third",
"Number": "5269",
"com-reg-no": "766",
"NM": "استبكو",
"L_NM": "Stepco",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "3558",
"Industrial certificate date": "8-Mar-18",
"ACTIVITY": "صناعة جبالات باطون ومكابس للبلاط",
"Activity-L": "Manufacture of construction machines",
"ADRESS": "ملك الياس حبوش\u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/497207",
"TEL2": "03/666664",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "793",
"com-reg-no": "10497",
"NM": "الشركة الوطنية للرخام - ش م ل",
"L_NM": "National Marble Company sal",
"Last Subscription": "1-Mar-18",
"Industrial certificate no": "2924",
"Industrial certificate date": "6-May-18",
"ACTIVITY": "معمل لنشر وجلي الرخام وصب الموزاييك",
"Activity-L": "Manufacture of marbles & mosaic",
"ADRESS": "ملك وقف الروم\u001c - شارع البستاني\u001c - وطى المصيطبة - بيروت",
"TEL1": "01/819593",
"TEL2": "01/819594",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1667",
"com-reg-no": "5683",
"NM": "قساطلي شتوره ش م ل",
"L_NM": "Kassatly Chtaura sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "2933",
"Industrial certificate date": "9-Jun-18",
"ACTIVITY": "صناعة المشروبات الروحيه والشرابات والخل والمربيات والكبيس",
"Activity-L": "Manufacture of alcoholic drinks,beverages,vinegar,jams & pickles",
"ADRESS": "ملك نايف اكرم قساطلي\u001c - الشارع العام\u001c - روميه - المتن",
"TEL1": "01/899888",
"TEL2": "01/878068",
"TEL3": "08/543500",
"internet": "kassatly@kassatly.net"
},
{
"Category": "First",
"Number": "3472",
"com-reg-no": "18907",
"NM": "كلوازال ميدل ايست",
"L_NM": "Cloisall - Middle East",
"Last Subscription": "6-Jun-17",
"Industrial certificate no": "4065",
"Industrial certificate date": "1-Jun-18",
"ACTIVITY": "صناعة الواح بوليسترين والبوليرتيان ومفروشات ومنجور خشبي واسقف مستعارة",
"Activity-L": "Manufacture of flat polystyrene,wooden furniture,panels&false ceilings",
"ADRESS": "بناية ابو شلش\u001c - شارع فردان\u001c - عين التينة - بيروت",
"TEL1": "05/431550",
"TEL2": "03/243700",
"TEL3": "05/481530",
"internet": "info@cloisallme.com"
},
{
"Category": "Excellent",
"Number": "1611",
"com-reg-no": "18",
"NM": "مؤسسة رفيق ابي نصر التجارية",
"L_NM": "Rafic Abi Nasr Trading Est",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4539",
"Industrial certificate date": "28-Aug-18",
"ACTIVITY": "تحميص وطحن البن وتجارة جملة البزورات والمواد الغذائية والقهوة والتبغ",
"Activity-L": "Roasting of coffee & Wholesale of mixed nuts,foodstuffs, coffee & tobacco",
"ADRESS": "ملك ابي نصر\u001c - الميناء الجديدة\u001c - جونيه -حارة صخر-- كسروان",
"TEL1": "09/938441",
"TEL2": "09/930791",
"TEL3": "03/301536",
"internet": "info@cafeabinasr.com"
},
{
"Category": "Excellent",
"Number": "1712",
"com-reg-no": "13964",
"NM": "شركة فورميتال - مكاوي وشركاهم - توصية بسيطة",
"L_NM": "Société Formetal - Mekawy & Co",
"Last Subscription": "12-Jan-17",
"Industrial certificate no": "2095",
"Industrial certificate date": "10-Jan-18",
"ACTIVITY": "صناعة المفروشات المكتبية",
"Activity-L": "Manufacture of office furniture",
"ADRESS": "ملك احمد مكاوي\u001c - شارع الرهبان\u001c - المدور- بيروت",
"TEL1": "01/442538",
"TEL2": "03/811666",
"TEL3": "03/814202",
"internet": "formetalalmekawi@gmail.com"
},
{
"Category": "Second",
"Number": "717",
"com-reg-no": "13814",
"NM": "خالد الخطيب وشركاه",
"L_NM": "Khaled Khatib & Co",
"Last Subscription": "1-Feb-18",
"Industrial certificate no": "2219",
"Industrial certificate date": "25-Jan-18",
"ACTIVITY": "صناعة لف الخيوط وانتاج سحابات وتخاريج",
"Activity-L": "Manufacture of zippers, embroideries & rolling up threads",
"ADRESS": "بناية ميقاتي\u001c - قصقص\u001c - الحرج - بيروت",
"TEL1": "05/433259",
"TEL2": "03/664423",
"TEL3": "",
"internet": "khatibex@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "1395",
"com-reg-no": "21743/1130",
"NM": "ليماتيك ش م ل",
"L_NM": "Lematic sal",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4788",
"Industrial certificate date": "25-Oct-18",
"ACTIVITY": "صناعة الادوات الكهربائية المنزلية",
"Activity-L": "Manufacture of electrical home appliances",
"ADRESS": "ملك الياس وبشير غناجه وشركاهما\u001c - شارع بشاره الخوري\u001c - الباشورة - بيروت",
"TEL1": "01/789400",
"TEL2": "01/789401",
"TEL3": "01/789402+4",
"internet": "lematic@lematicsal.com"
},
{
"Category": "Third",
"Number": "22915",
"com-reg-no": "2002384",
"NM": "ديلوكس - DELUX - تضامن",
"L_NM": "DELUX",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4949",
"Industrial certificate date": "28-Nov-18",
"ACTIVITY": "صناعة القازانات والسخانات",
"Activity-L": "Manufacture of boilers",
"ADRESS": "بناية شهاب\u001c - شارع واكد\u001c - حارة حريك - بعبدا",
"TEL1": "01/556727",
"TEL2": "01/556288",
"TEL3": "03/368516",
"internet": ""
},
{
"Category": "First",
"Number": "4270",
"com-reg-no": "70916",
"NM": "شركة ايمكو لاين انترناسيونال ش م م",
"L_NM": "Societe I.M.CO. Line International sarl",
"Last Subscription": "3-Feb-18",
"Industrial certificate no": "872",
"Industrial certificate date": "21-Dec-17",
"ACTIVITY": "صناعة البسة رياضية ورجالية والبسة العمل/ تجارة البسة رياضية ومعدات تزلج",
"Activity-L": "Manufacture of men\'s clothes, sportswear,workwear &Trade of sport articles",
"ADRESS": "ملك عصام مبارك\u001c - الشارع الرئيسي\u001c - فيطرون - كسروان",
"TEL1": "03/718002",
"TEL2": "09/958625",
"TEL3": "09/958203",
"internet": "info@lamaisonduski.net"
},
{
"Category": "Excellent",
"Number": "1311",
"com-reg-no": "72010",
"NM": "اراكيليان ش م م",
"L_NM": "Arakelian sarl",
"Last Subscription": "15-Jan-18",
"Industrial certificate no": "4137",
"Industrial certificate date": "14-Jun-18",
"ACTIVITY": "معملا لتصنيع علب وستاندات للمجوهرات",
"Activity-L": "Manufacture of jewellery boxes & stands",
"ADRESS": "ملك اراكيليان\u001c - شارع الشل\u001c - برج حمود - المتن",
"TEL1": "01/242424",
"TEL2": "03/824411",
"TEL3": "01/266662",
"internet": "a@a.com.lb"
},
{
"Category": "Excellent",
"Number": "1734",
"com-reg-no": "67063",
"NM": "شركة دار الفنون ش م ل",
"L_NM": "Dar El Founoun sal",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "594",
"Industrial certificate date": "15-Mar-19",
"ACTIVITY": "مطبعة وصناعة كبايات من كرتون",
"Activity-L": "Printing press & manufacture of carton cups",
"ADRESS": "ملك بطرس\u001c - شارع وديع نعيم\u001c - الشياح - بعبدا",
"TEL1": "01/282128",
"TEL2": "01/282800",
"TEL3": "01/280326",
"internet": "info@darelfounoun.com"
},
{
"Category": "Third",
"Number": "21665",
"com-reg-no": "70689",
"NM": "باتيسري لوليتا",
"L_NM": "Patisserie Lolita",
"Last Subscription": "29-Apr-17",
"Industrial certificate no": "2776",
"Industrial certificate date": "6-Apr-18",
"ACTIVITY": "تجارة الحلويات العربية والافرنجية",
"Activity-L": "Trading of oriental & western sweets",
"ADRESS": "ملك وسام شرتوني\u001c - شارع البستاني\u001c - الليلكي - بعبدا",
"TEL1": "01/475172",
"TEL2": "03/336398",
"TEL3": "",
"internet": "patisserie-lolita@hotmail.com"
},
{
"Category": "Third",
"Number": "21716",
"com-reg-no": "71973",
"NM": "شركة بوليتكس تايم -  توصية بسيطة",
"L_NM": "Polytex - Time Co",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "287",
"Industrial certificate date": "26-Jan-19",
"ACTIVITY": "معملا لحياكة البريم وخياطة الليف الزراعي",
"Activity-L": "Manufacture of lace & fibers",
"ADRESS": "ملك مصطفى عويدات\u001c - شارع البيادر\u001c - شحيم - الشوف",
"TEL1": "07/240144",
"TEL2": "03/239817",
"TEL3": "",
"internet": "polytextime@hotmail.com"
},
{
"Category": "Third",
"Number": "4056",
"com-reg-no": "58408",
"NM": "دار الكتب العلمية للطباعة والنشر والتوزيع - محمد علي بيضون وشركاه - شركة تضامن",
"L_NM": "Dar Al Kotob Al Ilmiyah Co",
"Last Subscription": "27-Jan-18",
"Industrial certificate no": "4629",
"Industrial certificate date": "20-Sep-18",
"ACTIVITY": "مطبعة لطباعة الكتب وأعمال التجليد",
"Activity-L": "Printing & bookbinding",
"ADRESS": "بناية العيتاني\u001c - شارع البطركية\u001c - زقاق البلاط - بيروت",
"TEL1": "05/804810",
"TEL2": "05/804811+12",
"TEL3": "03/555956",
"internet": "mazen@al-ilmiyah.com"
},
{
"Category": "Second",
"Number": "6297",
"com-reg-no": "43485",
"NM": "شركة نجم كروب وشركاهم ش م م",
"L_NM": "Najem Group & Cie sarl",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "158",
"Industrial certificate date": "10-Jan-19",
"ACTIVITY": "معملا لصب البلاط ونشر وجلي الرخام وتجارة جملة البلاط والرخام",
"Activity-L": "Manufacture & wholesale of marbles & tiles",
"ADRESS": "ملك وقف الروم\u001c - شارع البستاني\u001c - وطى المصيطبة - بيروت",
"TEL1": "01/303330",
"TEL2": "01/305250",
"TEL3": "01/310405",
"internet": "info@najemgroup.com"
},
{
"Category": "Third",
"Number": "9423",
"com-reg-no": "16507",
"NM": "معمل محمود الحارس واولاده - شركة تضامن",
"L_NM": "Mahmoud El Hares & Sons Factory",
"Last Subscription": "19-May-17",
"Industrial certificate no": "2978",
"Industrial certificate date": "16-May-18",
"ACTIVITY": "صناعة الاواني المنزلية من الحديد والالمنيوم",
"Activity-L": "Manufacture of metal kitchenware",
"ADRESS": "ملك ابناء محمود الحارس\u001c - شارع الجندي الشهيد\u001c - حارة الناعمة - الشوف",
"TEL1": "05/600654",
"TEL2": "71/371684",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "28365",
"com-reg-no": "1018384",
"NM": "اللبنانية لأنابيب المياه البلاستيكية ش م ل",
"L_NM": "Libanese Plastic Water Pipes (P.W.P) sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "79",
"Industrial certificate date": "21-Dec-18",
"ACTIVITY": "صناعة انابيب بلاستيكية",
"Activity-L": "Manufacture of plastic pipes",
"ADRESS": "ملك وسام قبرصلي\u001c - شارع المتني\u001c - المصيطبة - بيروت",
"TEL1": "01/494661",
"TEL2": "01/494662",
"TEL3": "",
"internet": "info@pwp-lb.com"
},
{
"Category": "Fourth",
"Number": "28366",
"com-reg-no": "1017380",
"NM": "الخلاط اللبناني (لوميكس) ش م ل",
"L_NM": "Lebanese Mixer (Lemix) sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "3456",
"Industrial certificate date": "23-Feb-18",
"ACTIVITY": "صناعة خلاطات المياه",
"Activity-L": "Manufacture of water mixer",
"ADRESS": "ملك وسام قبرصلي\u001c - شارع المتني\u001c - المصيطبة - بيروت",
"TEL1": "01/494661",
"TEL2": "01/494663",
"TEL3": "03/886161",
"internet": "info@lemix-lb.com"
},
{
"Category": "Third",
"Number": "17670",
"com-reg-no": "47482",
"NM": "ايتالوكاب ش م م",
"L_NM": "Italocapp sarl",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "113",
"Industrial certificate date": "28-Dec-18",
"ACTIVITY": "تعبئة القهوة السريعة الذوبان والشوكولا والكريمات",
"Activity-L": "Filling of Instant coffee, hot chocolate & cream",
"ADRESS": "ملك رينيه جريصاتي\u001c - الشارع العام\u001c - ديك المحدي - المتن",
"TEL1": "03/610365",
"TEL2": "04/912063",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "16709",
"com-reg-no": "50141",
"NM": "شركة سليب هاي ش م م",
"L_NM": "Sleep - High sarl",
"Last Subscription": "22-Feb-18",
"Industrial certificate no": "381",
"Industrial certificate date": "12-Feb-19",
"ACTIVITY": "صناعة الفرش المرفصة",
"Activity-L": "Manufacture of mattresses",
"ADRESS": "ملك شركة سليب هاي ش م م - حي الامراء - الشويفات - عاليه",
"TEL1": "05/437324+26",
"TEL2": "03/620887",
"TEL3": "05/437322",
"internet": "sleephig@terra.net.lb"
},
{
"Category": "First",
"Number": "865",
"com-reg-no": "29422",
"NM": "شركة تصنيع بلاط الرخام والموزاييك ش م م  نامارمي",
"L_NM": "Société pour la Fabrication de Marbre et Mosaique sarl",
"Last Subscription": "8-Aug-17",
"Industrial certificate no": "2578",
"Industrial certificate date": "20-Sep-17",
"ACTIVITY": "معمل لصب البلاط ونشر الصخور والرخام",
"Activity-L": "Manufacture of tiles & sawing of rocks & marbles",
"ADRESS": "ملك وقف مار الياس بطينا\u001c - شارع سليمان البستاني\u001c - وطى المصيطبة - بيروت",
"TEL1": "01/301864",
"TEL2": "01/311220",
"TEL3": "01/315845",
"internet": "najmgrp@inco.com.lb"
},
{
"Category": "Second",
"Number": "2295",
"com-reg-no": "37946",
"NM": "اكتيال",
"L_NM": "Actuel",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "280",
"Industrial certificate date": "25-Jan-19",
"ACTIVITY": "صناعة الالبسة النسائية",
"Activity-L": "Manufacture of ladies\' clothes",
"ADRESS": "ملك سنو اخوان\u001c - كورنيش المزرعة - شارع عفيف الطيبي\u001c - الملعب البلدي - بيروت",
"TEL1": "01/315693",
"TEL2": "01/702720",
"TEL3": "01/317219",
"internet": ""
},
{
"Category": "Second",
"Number": "2982",
"com-reg-no": "39345",
"NM": "اوكسيجين",
"L_NM": "Oxygene",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "4110",
"Industrial certificate date": "9-Jun-18",
"ACTIVITY": "صناعة الالبسة النسائية",
"Activity-L": "Manufacture of ladies\' clothes",
"ADRESS": "ملك ساحاك جاريقيان\u001c - الشارع الرئيسي\u001c - فرن الشباك - بعبدا",
"TEL1": "01/875001",
"TEL2": "01/875002",
"TEL3": "",
"internet": "oxygene@dm.net.lb"
},
{
"Category": "Excellent",
"Number": "8",
"com-reg-no": "2793",
"NM": "وردية هولدينكز انك ش م ل",
"L_NM": "Wardieh Holdings INC. sal",
"Last Subscription": "29-Jan-18",
"Industrial certificate no": "198",
"Industrial certificate date": "16-Jan-19",
"ACTIVITY": "تجارة جملة المحروقات وصناعة الزيوت المعدنية",
"Activity-L": "Wholesale of fuel and manufacture of lubricants",
"ADRESS": "ملك الوقف الماروني\u001c - ساحة الوردية - شارع روما\u001c - الحمراء - بيروت",
"TEL1": "01/241848",
"TEL2": "01/241849",
"TEL3": "70/005551",
"internet": "info@wardieh.com"
},
{
"Category": "Excellent",
"Number": "593",
"com-reg-no": "24509",
"NM": "باسيل اخوان ش م ل",
"L_NM": "Bassile Frères sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4254",
"Industrial certificate date": "6-Jul-18",
"ACTIVITY": "صناعة الدفاتر والقرطاسية",
"Activity-L": "Manufacture of copybooks & stationery",
"ADRESS": "ملك الشركة\u001c - الشارع العام\u001c - حريصا - كسروان",
"TEL1": "09/261000",
"TEL2": "09/263001",
"TEL3": "09/263500",
"internet": "bassile@bassile.com"
},
{
"Category": "Excellent",
"Number": "344",
"com-reg-no": "7006",
"NM": "شركة مؤسسة ميشال نجار ش م ل",
"L_NM": "Société Etablissements Michel Najjar sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4946",
"Industrial certificate date": "28-May-18",
"ACTIVITY": "تحميص وطحن وتعبئة وتجارة البن وتجميع ماكينات البن",
"Activity-L": "Coffee processing& Trading- gathering of coffee machines",
"ADRESS": "ملك جورج نجار\u001c - المدينة الصناعية\u001c - الفنار - المتن",
"TEL1": "01/884831+2",
"TEL2": "01/877250",
"TEL3": "03/226121",
"internet": "maindinial@cafenajjar.com"
},
{
"Category": "Excellent",
"Number": "218",
"com-reg-no": "2549/23153",
"NM": "شركة المياه المعدنية اللبنانية ش م ل",
"L_NM": "Société Des Eaux Minérales Libanaises sal",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "559",
"Industrial certificate date": "12-Mar-19",
"ACTIVITY": "تعبئة المياه المعدنية (مياه صحة)",
"Activity-L": "Bottling of mineral water(Sohat)",
"ADRESS": "ملك شركة فانتشور فاسيليتز ش م ل\u001c - شارع جون كينيدي\u001c - سن الفيل - المتن",
"TEL1": "01/485085",
"TEL2": "01/493099",
"TEL3": "",
"internet": "tanya.wakim@nestle-waters.com.lb"
},
{
"Category": "Excellent",
"Number": "109",
"com-reg-no": "34103",
"NM": "ابناء انطوان بشاره كرم - شركة تضامن",
"L_NM": "Les Fils d\'Antoine Bechara Karam",
"Last Subscription": "13-Mar-18",
"Industrial certificate no": "2548",
"Industrial certificate date": "9-Sep-17",
"ACTIVITY": "مصنعا لنشر الاخشاب",
"Activity-L": "Sawmilling of  wood",
"ADRESS": "ملك كرم\u001c - شارع كورنيش النهر\u001c - الاشرفية - بيروت",
"TEL1": "01/581031",
"TEL2": "09/211761+62",
"TEL3": "09/211763+5",
"internet": "karambois@inco.com.lb"
},
{
"Category": "Excellent",
"Number": "229",
"com-reg-no": "5376",
"NM": "معامل رخام هبر وشركاهم ش م ل",
"L_NM": "Arabian Mining Habre & Co. sal",
"Last Subscription": "13-Jan-17",
"Industrial certificate no": "2641",
"Industrial certificate date": "15-Dec-17",
"ACTIVITY": "معمل لنشر الصخور والرخام",
"Activity-L": "Manufacture of rocks & marbles",
"ADRESS": "ملك الشركة\u001c - حي مار الياس\u001c - الكحالة - عاليه",
"TEL1": "05/769666",
"TEL2": "05/768891+93",
"TEL3": "03/809797",
"internet": "amhabre@amhabre.com.lb"
},
{
"Category": "Second",
"Number": "2832",
"com-reg-no": "56789",
"NM": "شركة المطابع الدولية ش م ل",
"L_NM": "Int. Press sal",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "4653",
"Industrial certificate date": "29-Sep-18",
"ACTIVITY": "مطبعة تجاريه وتجارة الكتب والمجلات",
"Activity-L": "Printing press & bookbinding -Trading of books & prints",
"ADRESS": "سنتر الخياط\u001c - شارع مي طراد - قرب السبينس\u001c - وطى المصيطبة - بيروت",
"TEL1": "01/853150",
"TEL2": "01/853151",
"TEL3": "03/341039",
"internet": "interpress@int-press.com"
},
{
"Category": "Excellent",
"Number": "225",
"com-reg-no": "40",
"NM": "شركة معامل فيلوكس للقازانات - Velox - توصية بسيطة",
"L_NM": "Velox Boiler\'s Factory Co",
"Last Subscription": "11-Feb-17",
"Industrial certificate no": "3269",
"Industrial certificate date": "1-Feb-18",
"ACTIVITY": "صناعة القازانات ومعدات تدفئة وصحية",
"Activity-L": "Manufacture of boilers, sanitary & heating equipments",
"ADRESS": "ملك شهاب\u001c - جامع العرب\u001c - برج البراجنة - بعبدا",
"TEL1": "01/472042",
"TEL2": "01/472060",
"TEL3": "03/375123",
"internet": "veloxco@hotmail.com"
},
{
"Category": "Excellent",
"Number": "120",
"com-reg-no": "52490",
"NM": "انتربراند ش م ل",
"L_NM": "Interbrand sal",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "3873",
"Industrial certificate date": "25-Apr-18",
"ACTIVITY": "صناعة جميع انواع العصير والكاتشاب وتعليب الفاكهة",
"Activity-L": "Manufacture of juice & ketchup & canned of fruits",
"ADRESS": "ملك جاموريان\u001c - طريق زوق الخراب شارع رقم54\u001c - الضبيه - المتن",
"TEL1": "04/541707",
"TEL2": "03/542297",
"TEL3": "03/731299",
"internet": "interbrand@interbrand.com.lb"
},
{
"Category": "Excellent",
"Number": "217",
"com-reg-no": "18269",
"NM": "شركة اوهانس قصارجيان لصب المعادن ش م ل",
"L_NM": "Fonderies Ohannes H. Kassardjian sal",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "103",
"Industrial certificate date": "27-Dec-18",
"ACTIVITY": "صناعة صب المعادن على انواعها",
"Activity-L": "Manufacture of fonderies",
"ADRESS": "ملك قصارجيان\u001c - طريق وادي شحرور\u001c - المرداشة - بعبدا",
"TEL1": "05/462244",
"TEL2": "05/462846",
"TEL3": "05/462462",
"internet": "okfond@okfond.com"
},
{
"Category": "Excellent",
"Number": "1717",
"com-reg-no": "24674",
"NM": "شركة غريب للتخليص والشحن",
"L_NM": "Ghorayeb Clearing & Forwarding Co",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "056",
"Industrial certificate date": "19-Dec-18",
"ACTIVITY": "شحن جوي وبحري وبري - مطبعة",
"Activity-L": "Air, Sea & land transport - Printing press",
"ADRESS": "بناية كنفاني وملص\u001c - شارع الارز\u001c - الصيفي - بيروت",
"TEL1": "01/450550",
"TEL2": "03/662770",
"TEL3": "05/480680",
"internet": "ghrbtvl@cyberia.net.lb"
},
{
"Category": "First",
"Number": "3744",
"com-reg-no": "51571",
"NM": "شركة عبد الغني الحداد واولاده للتجارة والصناعة - تضامن",
"L_NM": "Abdul Ghani Haddad & Sons Co",
"Last Subscription": "20-Apr-17",
"Industrial certificate no": "4119",
"Industrial certificate date": "12-Jun-18",
"ACTIVITY": "مطاحن للحبوب وتجارة جملة المواد الغذائية",
"Activity-L": "Grain milling & wholesale of foodstuffs",
"ADRESS": "ملك حسن حجيج\u001c - شارع صليبا\u001c - المزرعة - بيروت",
"TEL1": "01653179",
"TEL2": "01653181",
"TEL3": "03/892321",
"internet": "haddadsonsco@hotmail.com"
},
{
"Category": "Excellent",
"Number": "70",
"com-reg-no": "19536",
"NM": "شركة كابلات لبنان ش م ل",
"L_NM": "Liban Cables sal",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "4943",
"Industrial certificate date": "28-Nov-18",
"ACTIVITY": "صناعة الكابلات الكهربائية",
"Activity-L": "Manufacture of electrical cables\r\nManufacture of electrical cables",
"ADRESS": "بناية غرفة التجارة والصناعة طـ 10\u001c - شارع جوستينيان\u001c - الصنائع - بيروت",
"TEL1": "01/350040+3",
"TEL2": "01/350043+5",
"TEL3": "01/745749+50",
"internet": "bassem.elhibri@nexans.com"
},
{
"Category": "Fourth",
"Number": "11803",
"com-reg-no": "33993",
"NM": "مجموعة دار الحدائق",
"L_NM": "Dar Al Hadaek Group",
"Last Subscription": "18-May-17",
"Industrial certificate no": "3508",
"Industrial certificate date": "1-Mar-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Print press",
"ADRESS": "بناية حويلان\u001c - الجناح - شارع BHV\u001c - الشياح - بعبدا",
"TEL1": "01/821679",
"TEL2": "01/840389",
"TEL3": "03/315582",
"internet": "alhadaek@alhadaekgroup.com"
},
{
"Category": "Fourth",
"Number": "17200",
"com-reg-no": "70081",
"NM": "اتش كزوتشي",
"L_NM": "H - Cassucci",
"Last Subscription": "22-Feb-18",
"Industrial certificate no": "3160",
"Industrial certificate date": "18-Feb-18",
"ACTIVITY": "صناعة الاحذية النسائية والولادية والرجالية",
"Activity-L": "Manufacture of ladies\',children\'s & men\'s shoes",
"ADRESS": "بناية الانوار ملك سميرة بزي\u001c - حي الاميركان\u001c - حارة حريك  - بعبدا",
"TEL1": "03/180823",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "5863",
"com-reg-no": "74616",
"NM": "شركة مطبعة ايبكس - عصام وهشام منيمنة وشركاؤهم - شركة توصية بسيطة",
"L_NM": "Ipex Printing Press",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4014",
"Industrial certificate date": "23-May-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "ملك عصام منيمنة واولاده\u001c - شارع عدنان الحكيم- قرب BHV\u001c - بئر حسن - بيروت",
"TEL1": "01/856962",
"TEL2": "01/856963",
"TEL3": "",
"internet": "hisham@ipexpp.com"
},
{
"Category": "Third",
"Number": "21704",
"com-reg-no": "52689",
"NM": "اونا كروب ش م م",
"L_NM": "Onna Group sarl",
"Last Subscription": "14-Jun-17",
"Industrial certificate no": "4112",
"Industrial certificate date": "9-Jun-18",
"ACTIVITY": "صناعة الالبسة النسائية والولادية",
"Activity-L": "Manufacture of ladies\' & children\'s clothes",
"ADRESS": "ملك عبد الملك وشقرا\u001c - شارع مطر ابو جوده\u001c - جل الديب - المتن",
"TEL1": "04/717367",
"TEL2": "04/717368",
"TEL3": "04/711611",
"internet": ""
},
{
"Category": "Second",
"Number": "5960",
"com-reg-no": "30056",
"NM": "كونتاكت ش م م",
"L_NM": "Contact sarl",
"Last Subscription": "28-Dec-17",
"Industrial certificate no": "066",
"Industrial certificate date": "21-Dec-18",
"ACTIVITY": "معملا لتصوير افلام للطباعة",
"Activity-L": "Factory of plate making for printing",
"ADRESS": "ملك جرجس الخوري وجنفياف ايوب\u001c - الشارع العام\u001c - بصاليم - المتن",
"TEL1": "04/808990",
"TEL2": "03/526360",
"TEL3": "",
"internet": "contactsarl@idm.net.lb"
},
{
"Category": "Second",
"Number": "6506",
"com-reg-no": "23048",
"NM": "بومو فود اندستري ش م م",
"L_NM": "Pomo Food Industries sarl",
"Last Subscription": "20-Jan-18",
"Industrial certificate no": "552",
"Industrial certificate date": "12-Mar-19",
"ACTIVITY": "صناعة بطاطا شيبس",
"Activity-L": "Manufacture of potato chips",
"ADRESS": "ملك صبحي الجميل\u001c - الغابة - الشارع العام\u001c - برمانا - المتن",
"TEL1": "04/961949",
"TEL2": "04/865091",
"TEL3": "03/215606",
"internet": "pomofood@cyberia.net.lb"
},
{
"Category": "Excellent",
"Number": "29",
"com-reg-no": "4589",
"NM": "شركة سايبس الدولية لصنع الدهانات ش م ل",
"L_NM": "Sipes International Paint Manufacturing Co.sal",
"Last Subscription": "16-Jan-18",
"Industrial certificate no": "173",
"Industrial certificate date": "11-Jan-19",
"ACTIVITY": "صناعة الدهانات",
"Activity-L": "Manufacture of paints",
"ADRESS": "ملك ماجد البزري\u001c - شارع تقي الدين الصلح\u001c - الصنوبرة - بيروت",
"TEL1": "01/862626",
"TEL2": "01/813846",
"TEL3": "01/813849",
"internet": "sipes@cyberia.net.lb"
},
{
"Category": "Second",
"Number": "2204",
"com-reg-no": "24777",
"NM": "Kbe Establishment for Air Movement Products",
"L_NM": "Kbe Establishment for Air Movement Products",
"Last Subscription": "21-Jun-17",
"Industrial certificate no": "4661",
"Industrial certificate date": "3-Oct-18",
"ACTIVITY": "صناعة فتحات ومجاري لتكييف الهواء",
"Activity-L": "Manufacture of air conditioning drafts",
"ADRESS": "ملك باخوس\u001c - شارع المدور\u001c - الجديدة - المتن",
"TEL1": "01/898268",
"TEL2": "03/884400",
"TEL3": "01/896899",
"internet": "kboutros@kbelebanon.com"
},
{
"Category": "Excellent",
"Number": "378",
"com-reg-no": "15261",
"NM": "ميديا فورم  ش م ل",
"L_NM": "Mediaform sal",
"Last Subscription": "7-Jan-17",
"Industrial certificate no": "4633",
"Industrial certificate date": "20-Sep-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing press",
"ADRESS": "ملك الشركة\u001c - شارع مار الياس\u001c - المكلس - المتن",
"TEL1": "01/683288",
"TEL2": "01/683287",
"TEL3": "",
"internet": "info@mediaformsal.com"
},
{
"Category": "Third",
"Number": "22939",
"com-reg-no": "2002207",
"NM": "المركز التجاري اللبناني ش م م",
"L_NM": "Lebanese Commercial Center sarl - LCC sarl",
"Last Subscription": "17-Jan-18",
"Industrial certificate no": "248",
"Industrial certificate date": "22-Jan-19",
"ACTIVITY": "تجارة ادوات مطبخية منزلية واعمال الحفر والرسم على الزجاج",
"Activity-L": "Trading of kitchenware & drawing & engraving on glass",
"ADRESS": "ملك بدري وفاروق جنبلاط\u001c - حي القبيزة - الشارع العام\u001c - انطلياس - المتن",
"TEL1": "04/412553",
"TEL2": "03/855144",
"TEL3": "03/964529",
"internet": "lcc@dm.net.lb"
},
{
"Category": "Fourth",
"Number": "29178",
"com-reg-no": "2004039",
"NM": "سنبلاست - توصية بسيطة",
"L_NM": "Sun Plast",
"Last Subscription": "19-Jan-18",
"Industrial certificate no": "4492",
"Industrial certificate date": "14-Aug-18",
"ACTIVITY": "صناعة المنجورات البلاستيكية",
"Activity-L": "Manufacture of plastic panels",
"ADRESS": "بناية كيبنيان\u001c - المدينة الصناعية - شارع مصنع الاسفنج\u001c - البوشرية - المتن",
"TEL1": "01/497230",
"TEL2": "03/660263",
"TEL3": "",
"internet": "sunplastlebanon@gmail.com"
},
{
"Category": "First",
"Number": "1445",
"com-reg-no": "43801",
"NM": "شركة مي دوره ش م ل",
"L_NM": "Mie Dorée sal",
"Last Subscription": "3-Feb-18",
"Industrial certificate no": "34",
"Industrial certificate date": "14-Oct-18",
"ACTIVITY": "مطعم وسناك",
"Activity-L": "Restaurant & snack",
"ADRESS": "ملك شركة مي دوره ش م ل\u001c - شارع الغزاليه\u001c - الاشرفية - بيروت",
"TEL1": "01/216730",
"TEL2": "01/202678",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "2254",
"com-reg-no": "21163",
"NM": "شلهوب فارماسوتيكالس - شفا ش م ل",
"L_NM": "Chalhoub Pharmaceuticals sal - Cha-Pha",
"Last Subscription": "27-Mar-17",
"Industrial certificate no": "3688",
"Industrial certificate date": "24-Mar-18",
"ACTIVITY": "صناعة الادوية",
"Activity-L": "Manufacture of medicines",
"ADRESS": "ملك الشركة\u001c - الشارع العام\u001c - المنصورية - المتن",
"TEL1": "04/400750",
"TEL2": "04/400130",
"TEL3": "04/530399",
"internet": "ccf@ch-pharma.com"
},
{
"Category": "Second",
"Number": "4924",
"com-reg-no": "13161",
"NM": "جورج حموي - مجوهرات",
"L_NM": "Georges Hamawi - Joaillier",
"Last Subscription": "1-Dec-17",
"Industrial certificate no": "4310",
"Industrial certificate date": "19-Mar-16",
"ACTIVITY": "تجارة المجوهرات",
"Activity-L": "Trading of jewellery",
"ADRESS": "ملك شركة دده يان للانماء ش م م\u001c - اوتوستراد الدورة\u001c - البوشرية - المتن",
"TEL1": "01/265176",
"TEL2": "01/263297",
"TEL3": "03/608160",
"internet": "hamawig@cyberia.net.lb"
},
{
"Category": "First",
"Number": "5064",
"com-reg-no": "35376",
"NM": "شركة الصناعات الالكترونية الحديثة ش م ل - مايكو",
"L_NM": "Modern Electronic Industries Company sal MEICO",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "2550",
"Industrial certificate date": "7-Mar-18",
"ACTIVITY": "صناعة محولات وتابلوهات كهربائية واجهزة انذار",
"Activity-L": "Manufacture of electrical boards & transformers & alarm systems",
"ADRESS": "ملك الشركة\u001c - شارع جنبلاط\u001c - سبلين - الشوف",
"TEL1": "01/664800+1",
"TEL2": "07/970680+1",
"TEL3": "03/591471",
"internet": "info@meico-lb.com"
},
{
"Category": "First",
"Number": "5218",
"com-reg-no": "51468",
"NM": "شركة اوفيس ورك سنتر ش م م",
"L_NM": "Office Work Center sarl",
"Last Subscription": "10-Mar-17",
"Industrial certificate no": "4543",
"Industrial certificate date": "28-Aug-18",
"ACTIVITY": "صناعة المفروشات الخشبية والمكتبية",
"Activity-L": "Manufacture & trading of wooden & office furniture",
"ADRESS": "ملك الشركة\u001c - الشارع العام\u001c - المنصورية - المتن",
"TEL1": "04/530251",
"TEL2": "04/530252",
"TEL3": "04/409870",
"internet": "owc@dm.net.lb"
},
{
"Category": "Third",
"Number": "18343",
"com-reg-no": "53118",
"NM": "شركة اي . اس  ترايدينغ ش م م",
"L_NM": "E.S. Trading sarl",
"Last Subscription": "22-Feb-18",
"Industrial certificate no": "1487",
"Industrial certificate date": "12-Mar-18",
"ACTIVITY": "صناعة مواد التنظيف والشامبو",
"Activity-L": "Manufacture of detergents & Shampoo",
"ADRESS": "ملك دينا شميعة ط سفلي\u001c - الاوتوستراد\u001c - الفنار - المتن",
"TEL1": "03/302067",
"TEL2": "01/687575",
"TEL3": "03/302067",
"internet": "mireille@estradinglb.com"
},
{
"Category": "Third",
"Number": "25423",
"com-reg-no": "964/245",
"NM": "شوكولا بالادان",
"L_NM": "Chocolat Paladin",
"Last Subscription": "8-Apr-17",
"Industrial certificate no": "4399",
"Industrial certificate date": "29-Jul-18",
"ACTIVITY": "صناعة الشوكولا",
"Activity-L": "Manufacture of chocolate",
"ADRESS": "ملك رامز كنعان\u001c - كرم الزيتون\u001c - الشياح - بعبدا",
"TEL1": "05/455558",
"TEL2": "",
"TEL3": "",
"internet": "info@chocolat-paladin.com"
},
{
"Category": "First",
"Number": "4497",
"com-reg-no": "54283",
"NM": "الشركة الشرقية لمنتوجات الورق ش م ل - بكداش وشركاه O.p.p",
"L_NM": "Oriental Paper Products sal O.P.P",
"Last Subscription": "18-Jan-18",
"Industrial certificate no": "4577",
"Industrial certificate date": "7-Sep-18",
"ACTIVITY": "صناعة الدفاتر والملفات من بلاستيك وكرتون",
"Activity-L": "Manufacture of plastic & carton copybooks & files",
"ADRESS": "بناية الكنار ط 4\u001c - شارع مايكل انجلو\u001c - الروشة - بيروت",
"TEL1": "01/870555+6",
"TEL2": "01/883844",
"TEL3": "03/201524",
"internet": "opp@opp.com.lb"
},
{
"Category": "First",
"Number": "4741",
"com-reg-no": "59566/11881",
"NM": "مصانع ومحلات سعد الله الابيض واولاده",
"L_NM": "Est. Fabriques Saadallah Al Abiad & Fils",
"Last Subscription": "3-Mar-18",
"Industrial certificate no": "4234",
"Industrial certificate date": "4-Jul-18",
"ACTIVITY": "تجارة مواد الاولية للحلويات وصناعة الشوكولا",
"Activity-L": "Trading of primary material for sweets & manufacture of chocolate",
"ADRESS": "ملك زياد الابيض\u001c - خلف كنيسة مار مخايل\u001c - الشياح - بعبدا",
"TEL1": "01/834327",
"TEL2": "01/834330",
"TEL3": "03/224758",
"internet": ""
},
{
"Category": "Third",
"Number": "13683",
"com-reg-no": "33829",
"NM": "شركة تروساديا للصناعة والتجارة ش م م",
"L_NM": "Trussadia for Industry & Commerce sarl",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "4599",
"Industrial certificate date": "14-Sep-18",
"ACTIVITY": "صناعة الالبسة الرجالية والولادية",
"Activity-L": "Manufacture of men\'s & children\'s clothes",
"ADRESS": "بناية قازان\u001c - شارع القسيس\u001c - حارة حريك - بعبدا",
"TEL1": "01/271421+2",
"TEL2": "01/271454",
"TEL3": "03/221669",
"internet": "info@trussadia.com"
},
{
"Category": "First",
"Number": "5187",
"com-reg-no": "24139",
"NM": "مؤسسة غانم للحوم المبردة",
"L_NM": "Ghanem Frozen Meats Est",
"Last Subscription": "25-Aug-17",
"Industrial certificate no": "4506",
"Industrial certificate date": "19-Aug-18",
"ACTIVITY": "توضيب وحفط اللحوم",
"Activity-L": "Packing& preserving  of meat",
"ADRESS": "ملك عادل غانم\u001c - الشارع العام\u001c - الورهانية - الشوف",
"TEL1": "05/240688",
"TEL2": "03/619688",
"TEL3": "03/619677",
"internet": ""
},
{
"Category": "First",
"Number": "817",
"com-reg-no": "1447",
"NM": "مؤسسة فؤاد سبليني واولاده - شركة تضامن",
"L_NM": "Fouad Siblini et Fils",
"Last Subscription": "6-Jul-17",
"Industrial certificate no": "4039",
"Industrial certificate date": "29-May-18",
"ACTIVITY": "صناعة اجهزة الانارة وتجارة المفروشات",
"Activity-L": "Manufacture of lighting articles & trading of furniture",
"ADRESS": "بناية يونس ط2\u001c - بولفار سامي الصلح\u001c - بدارو - بيروت",
"TEL1": "01/390190",
"TEL2": "01/390191",
"TEL3": "01/390192",
"internet": "info@siblini-lighting.com"
},
{
"Category": "Excellent",
"Number": "1548",
"com-reg-no": "66754",
"NM": "شركة سادا باك ش م م",
"L_NM": "Sada Pack  sarl",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4820",
"Industrial certificate date": "1-Nov-18",
"ACTIVITY": "صناعة الجل والكريمات والشامبو",
"Activity-L": "Manufacture of jel, cream & shampoo",
"ADRESS": "ملك علي ياسين ضاهر\u001c - شارع البعل\u001c - الناعمة - الشوف",
"TEL1": "05/679758",
"TEL2": "07/986000",
"TEL3": "70/222722",
"internet": "info@sadapack.com"
},
{
"Category": "Fourth",
"Number": "8830",
"com-reg-no": "33908",
"NM": "شركة النهضة للتجارة والصناعة والاستيراد والتصدير - شركة تضامن",
"L_NM": "Al-Nahda Co. for Trade & Industry",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "4965",
"Industrial certificate date": "4-Dec-18",
"ACTIVITY": "معملا لنشر الرخام والصخور وتجارة ادوات صحية",
"Activity-L": "Manufature of marble & rocks & trading of sanitary articles",
"ADRESS": "ملك علي راجح\u001c - شارع المرج\u001c - بعقلين - الشوف",
"TEL1": "05/300777",
"TEL2": "03/422996",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "24352",
"com-reg-no": "30960",
"NM": "فاريانس ش م م",
"L_NM": "Variance sarl",
"Last Subscription": "27-Oct-17",
"Industrial certificate no": "4729",
"Industrial certificate date": "16-Oct-18",
"ACTIVITY": "صناعة المفروشات",
"Activity-L": "Manufacture of furniture",
"ADRESS": "بناية فاريانس\u001c - الاوتوستراد\u001c - صربا - كسروان",
"TEL1": "09/636666",
"TEL2": "09/636663",
"TEL3": "03/221422",
"internet": "variance@variance.com.lb"
},
{
"Category": "First",
"Number": "4347",
"com-reg-no": "35075",
"NM": "وايت سيتي ش م م",
"L_NM": "White City sarl",
"Last Subscription": "5-Mar-18",
"Industrial certificate no": "453",
"Industrial certificate date": "22-Feb-19",
"ACTIVITY": "صناعة البياضات المنزلية وبزات العمل وحرفيات",
"Activity-L": "Manufacture of linen, workwear & artisanat items",
"ADRESS": "بناية وايت سيتي\u001c - شارع مار شربل\u001c - الفنار - المتن",
"TEL1": "01/690240",
"TEL2": "01/690250",
"TEL3": "01/262661",
"internet": "whitecity@whitecitylinen.com"
},
{
"Category": "Fourth",
"Number": "11644",
"com-reg-no": "44544",
"NM": "توتريكو ش م م",
"L_NM": "Toutricot sarl",
"Last Subscription": "23-Jan-18",
"Industrial certificate no": "4042",
"Industrial certificate date": "20-May-18",
"ACTIVITY": "صناعة الالبسة النسائية والولادية التريكو",
"Activity-L": "Manufacture of ladies\' and children\'s clothes & Tricot",
"ADRESS": "ملك يونان\u001c - الشارع الداخلي\u001c - عقبة بياقوت - المتن",
"TEL1": "01/893758",
"TEL2": "01/893768",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "25713",
"com-reg-no": "26682",
"NM": "شركة نجيم للبلاستيك - نوجا بلاست ش م م",
"L_NM": "Société Noujaim pour le Plastique - Noujaplast - sarl",
"Last Subscription": "10-Jun-17",
"Industrial certificate no": "1697",
"Industrial certificate date": "3-Jun-18",
"ACTIVITY": "صناعة القناني والغالونات البلاستيك",
"Activity-L": "Manufacture of plastic galons & bottles",
"ADRESS": "ملك الشركة\u001c - حي مار الياس\u001c - المكلس - المتن",
"TEL1": "01/683296",
"TEL2": "01/683295",
"TEL3": "",
"internet": "noujaplast@idm.net.lb"
},
{
"Category": "Excellent",
"Number": "1535",
"com-reg-no": "31105",
"NM": "شركة سبارتن الكيماوية ش م م",
"L_NM": "Spartan Chemical Co. sarl",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "52",
"Industrial certificate date": "17-Oct-18",
"ACTIVITY": "صناعة المنظفات والمطهرات والشامبوان",
"Activity-L": "Manufacture of antiseptics, detergents and shampoo",
"ADRESS": "ملك ورثة خديجة عيتاني\u001c - شارع الحسيني\u001c - رأس بيروت - بيروت",
"TEL1": "05/803530",
"TEL2": "05/801427",
"TEL3": "05/802273+4",
"internet": "spartan@spartan.com.lb"
},
{
"Category": "Fourth",
"Number": "4929",
"com-reg-no": "44592",
"NM": "مؤسسة محمود داود المكاري لصناعة الكلاج والرقاق والحلويات والكريب",
"L_NM": "Mahmoud Daoud Makari Est. for Sweets Industry",
"Last Subscription": "11-Jan-17",
"Industrial certificate no": "2822",
"Industrial certificate date": "14-Dec-17",
"ACTIVITY": "صناعة الكلاج والرقاق والحلويات والكريب",
"Activity-L": "Manufacture of pastry & sweets",
"ADRESS": "ملك نحلاوي وورثة احمد جراب\u001c - شارع ابن الرشد\u001c - دار الفتوى - بيروت",
"TEL1": "01/310044",
"TEL2": "03/630972",
"TEL3": "",
"internet": "makari_m@yahoo.fr"
},
{
"Category": "Third",
"Number": "11860",
"com-reg-no": "33315",
"NM": "لوك ان",
"L_NM": "Look In",
"Last Subscription": "5-Jan-18",
"Industrial certificate no": "267",
"Industrial certificate date": "24-Jan-19",
"ACTIVITY": "صناعة الالبسة النسائية والولادية",
"Activity-L": "Manufacture of ladies\' & children\'s clothes",
"ADRESS": "بناية الهلال\u001c - شارع مار الياس\u001c - المصيطبة - بيروت",
"TEL1": "01/704423",
"TEL2": "01/319008",
"TEL3": "",
"internet": "lookin@terra.net.lb"
},
{
"Category": "Fourth",
"Number": "28460",
"com-reg-no": "1015387",
"NM": "شركة القلعه بدادون ش م م",
"L_NM": "Citadel Bdadoun ltd",
"Last Subscription": "22-Feb-17",
"Industrial certificate no": "4796",
"Industrial certificate date": "25-Oct-18",
"ACTIVITY": "صناعة زيت الزيتون وتجارة الزيتون",
"Activity-L": "Manufacture of olive oil & Tading of olive",
"ADRESS": "سنتر داغر - ملك رفيق ضو ط5\u001c - شارع شارل الحلو\u001c - الاشرفية - بيروت",
"TEL1": "01/563413",
"TEL2": "03/771558",
"TEL3": "",
"internet": "nadine.h@adonandmyrrh.com"
},
{
"Category": "Fourth",
"Number": "27451",
"com-reg-no": "2037929",
"NM": "هانتراكو ش.م.م.",
"L_NM": "Hintraco sarl",
"Last Subscription": "25-Apr-17",
"Industrial certificate no": "4930",
"Industrial certificate date": "27-Nov-18",
"ACTIVITY": "مصنعا للفلين والبلاستيك",
"Activity-L": "Manufacture of Cork &Plastic",
"ADRESS": "ملك الحجار\u001c - اوتوستراد الدورة\u001c - البوشرية- المتن",
"TEL1": "01/254102",
"TEL2": "03/448946",
"TEL3": "",
"internet": ""
},
{
"Category": "Excellent",
"Number": "1802",
"com-reg-no": "24431",
"NM": "فاريوس ميديل ايست ش م ل",
"L_NM": "Varios Middle East sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "4404",
"Industrial certificate date": "1-Aug-18",
"ACTIVITY": "صناعة الكترود التلحيم واحجار الجلخ والقص",
"Activity-L": "Manufacture of abrasive products",
"ADRESS": "ملك شهاب اخوان\u001c - شارع اسكندر عازار\u001c - الروشة - بيروت",
"TEL1": "01/807916",
"TEL2": "01/562530",
"TEL3": "01/562531",
"internet": "variosme@chehab-bros.com"
},
{
"Category": "Second",
"Number": "6245",
"com-reg-no": "54007",
"NM": "محلات احمد محمد بكري للصناعة والتجارة ش م م - بيماتيك",
"L_NM": "Ahmad Mohamed Bakri Ests. For Industry and Trade Bimatic sarl",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "097",
"Industrial certificate date": "26-Dec-18",
"ACTIVITY": "صناعة الافران ومطاحن ومحامص البن",
"Activity-L": "Manufacture of bakeries,mills & roasters",
"ADRESS": "بناية الفيحاء رقم 1\u001c - شارع نظيرة جنبلاط\u001c - الملعب البلدي - بيروت",
"TEL1": "01/653679",
"TEL2": "01/653681",
"TEL3": "01/655776",
"internet": "bimatic@bimatic.com.lb"
},
{
"Category": "Third",
"Number": "11450",
"com-reg-no": "51426",
"NM": "الدار العربية للعلوم - شبارو اخوان - شركة تضامن",
"L_NM": "Arab Scientific Publishers",
"Last Subscription": "11-Jan-18",
"Industrial certificate no": "4953",
"Industrial certificate date": "29-Nov-18",
"ACTIVITY": "مطبعة",
"Activity-L": "Printing Press",
"ADRESS": "بناية الريم\u001c - شارع المفتي توفيق خالد\u001c - ساقية الجنزير - بيروت",
"TEL1": "01/785107",
"TEL2": "01/785108",
"TEL3": "03/433836",
"internet": "asp@asp.com.lb"
},
{
"Category": "Fourth",
"Number": "30784",
"com-reg-no": "67033",
"NM": "مجوهرات خاجريان",
"L_NM": "Khatcherian Jewellery",
"Last Subscription": "17-Feb-17",
"Industrial certificate no": "3230",
"Industrial certificate date": "26-Jan-18",
"ACTIVITY": "صناعة المجوهرات",
"Activity-L": " Manufacture of Jewellery",
"ADRESS": "بناية هاربويان - ملك ديكران خاجريان\u001c - شارع اراكس\u001c - برج حمود - المتن",
"TEL1": "01/242607",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "30887",
"com-reg-no": "1005396",
"NM": "فارما م. ش م ل",
"L_NM": "Pharma M sal",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "3690",
"Industrial certificate date": "27-Mar-18",
"ACTIVITY": "توضيب كبسولات واقراص للمتممات الغذائية",
"Activity-L": "Packing of capsules for food additives",
"ADRESS": "ملك الجمعية الثقافية - تيكيان\u001c - الصيفي\u001c - بيروت",
"TEL1": "04/883866",
"TEL2": "03/449936",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "29601",
"com-reg-no": "2007847",
"NM": "سينايا - Sinaya",
"L_NM": "Sinaya",
"Last Subscription": "26-Aug-17",
"Industrial certificate no": "2744",
"Industrial certificate date": "25-Oct-17",
"ACTIVITY": "صناعة الالات الصناعية وماكينات التعبئة والتغليف",
"Activity-L": "Manufacture of industrail, filling & packing machinery",
"ADRESS": "بناية حبوش ملك ابراهيم الثوم\u001c - شارع المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/496876",
"TEL2": "03/526876",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "29542",
"com-reg-no": "1002627",
"NM": "Diamonds and Gems Stones Cutters andTraders sal",
"L_NM": "Diamonds and Gems Stones Cutters andTraders sal",
"Last Subscription": "13-Jan-18",
"Industrial certificate no": "3663",
"Industrial certificate date": "22-Mar-18",
"ACTIVITY": "نشر وفرز الاحجار والمعادن الثمينة",
"Activity-L": "Cutting of precious stones & metals",
"ADRESS": "بناية ال سعود\u001c - الشارع الرئيسي\u001c - الحمراء - بيروت",
"TEL1": "01/736348",
"TEL2": "01/343636",
"TEL3": "",
"internet": "hassan@dgct.co"
},
{
"Category": "Fourth",
"Number": "28887",
"com-reg-no": "2043824",
"NM": "هابيناتس ش م م",
"L_NM": "Happinuts sarl",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "060",
"Industrial certificate date": "20-Dec-18",
"ACTIVITY": "تجارة جملة النقولات والبزورات",
"Activity-L": "Wholesale of mixed nuts",
"ADRESS": "ملك جان بيار ضباعي\u001c - المنطقة الصناعية - المعامل\u001c - المكلس - المتن",
"TEL1": "01/695277",
"TEL2": "03/692212",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "31047",
"com-reg-no": "2040582",
"NM": "نيو فيجن غروب ش م م",
"L_NM": "New Vision Group L.L.C.",
"Last Subscription": "4-Jan-17",
"Industrial certificate no": "2837",
"Industrial certificate date": "14-Nov-17",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "بناية نيو فيجن غروب \u001c - المدينة الصناعية\u001c - عين سعاده - المتن",
"TEL1": "01/330750",
"TEL2": "71/330750",
"TEL3": "",
"internet": "info@newvision-gr.com"
},
{
"Category": "Fourth",
"Number": "31011",
"com-reg-no": "1016837",
"NM": "ليه شنشل ش م م",
"L_NM": "Les Shanshalles sarl",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "4987",
"Industrial certificate date": "5-May-18",
"ACTIVITY": "صناعة الشوكولا",
"Activity-L": "Manufacture of chocolate",
"ADRESS": "بناية شاتيلا\u001c - شارع توفيق طبارة\u001c - الصنائع - بيروت",
"TEL1": "03/890550",
"TEL2": "",
"TEL3": "",
"internet": "sarahshanshal@gmail.com"
},
{
"Category": "Fourth",
"Number": "31253",
"com-reg-no": "1021253",
"NM": "شركة ارمانور ش م م",
"L_NM": "Armanor sarl",
"Last Subscription": "29-Jan-18",
"Industrial certificate no": "62",
"Industrial certificate date": "25-Jan-19",
"ACTIVITY": "صناعة المجوهرات",
"Activity-L": "Manufacture of jewellery",
"ADRESS": "ملك داكيسيان\u001c - كمب هاجين\u001c - المدور - بيروت",
"TEL1": "01/561519",
"TEL2": "01/562593",
"TEL3": "03/234279",
"internet": "armanor@cyberia.net.lb"
},
{
"Category": "Third",
"Number": "31103",
"com-reg-no": "2038970",
"NM": "Elysee Wise sal",
"L_NM": "Elysee Wise sal",
"Last Subscription": "12-Jan-18",
"Industrial certificate no": "602",
"Industrial certificate date": "15-Mar-19",
"ACTIVITY": "صناعة انابيب البلاستيك للمياه",
"Activity-L": "Manufacture of water plastic tubes",
"ADRESS": "ملك سامي الخوري\u001c - الشارع العام\u001c - غرفين - جبيل",
"TEL1": "09/624551",
"TEL2": "",
"TEL3": "",
"internet": "info@elyseewise.com"
},
{
"Category": "Second",
"Number": "6773",
"com-reg-no": "1018406",
"NM": "قساطلي بيروت ش.م.ل",
"L_NM": "Kassatly Beirut sal",
"Last Subscription": "9-Jan-18",
"Industrial certificate no": "3922",
"Industrial certificate date": "5-Mar-19",
"ACTIVITY": "صناعة البيرة",
"Activity-L": "Manufacture of beer",
"ADRESS": "بناية اكاسيا - ملك اكرم قساطلي\u001c - السيوفي - الشارع العام\u001c - الاشرفية - بيروت",
"TEL1": "01/899888",
"TEL2": "",
"TEL3": "",
"internet": "kassatly@kassatly.net"
},
{
"Category": "Fourth",
"Number": "28939",
"com-reg-no": "2037207",
"NM": "واسكين اغوب قليجي",
"L_NM": "Vasken Kalligi",
"Last Subscription": "27-Feb-18",
"Industrial certificate no": "3660",
"Industrial certificate date": "21-Mar-18",
"ACTIVITY": "صناعة الفضيات",
"Activity-L": "Silver Industry",
"ADRESS": "ملك قلاجي \u001c - المدينة الصناعية\u001c - البوشرية - المتن",
"TEL1": "01/688447",
"TEL2": "03/355549",
"TEL3": "",
"internet": ""
},
{
"Category": "First",
"Number": "4373",
"com-reg-no": "2047363",
"NM": "بـريبـاك ش م ل",
"L_NM": "Prepak sal",
"Last Subscription": "26-Jan-18",
"Industrial certificate no": "4880",
"Industrial certificate date": "15-Nov-18",
"ACTIVITY": "تجارة العبوات والغالونات والسدادات البلاستكية",
"Activity-L": "Trading of plastic containers & stoppers",
"ADRESS": "ملك روي الحاج\u001c - المدينة الصناعية - الشارع العام\u001c - مزرعة يشوع - المتن",
"TEL1": "09/230130",
"TEL2": "",
"TEL3": "",
"internet": "maroun.assi@mapcgroup.com"
},
{
"Category": "Fourth",
"Number": "29666",
"com-reg-no": "1020512",
"NM": "اف دي ام اتش ش م ل",
"L_NM": "FDMH sal",
"Last Subscription": "4-Jan-18",
"Industrial certificate no": "4728",
"Industrial certificate date": "13-Apr-18",
"ACTIVITY": "التجارة العامة",
"Activity-L": "General trade",
"ADRESS": "بناية شوكتلي\u001c - الشارع الرئيسي\u001c - الصيفي - بيروت",
"TEL1": "03/365665",
"TEL2": "03/030545",
"TEL3": "03/788000",
"internet": "dekmak.fadia@gmail.com"
},
{
"Category": "Fourth",
"Number": "27470",
"com-reg-no": "2042435",
"NM": "أم تي أم تريدينغ ش.م.م.",
"L_NM": "MTM Trading sarl",
"Last Subscription": "10-Mar-17",
"Industrial certificate no": "3659",
"Industrial certificate date": "21-Mar-18",
"ACTIVITY": "التجارة العامة",
"Activity-L": "General Trade",
"ADRESS": "ملك عبدو درغم  - الشارع العام - ذوق مصبح - كسروان",
"TEL1": "03/482818",
"TEL2": "",
"TEL3": "",
"internet": "joseph@mtmleb.co"
},
{
"Category": "Fourth",
"Number": "29684",
"com-reg-no": "2022652",
"NM": "بوظة عواد",
"L_NM": "Awad Ice Cream",
"Last Subscription": "8-Mar-17",
"Industrial certificate no": "4739",
"Industrial certificate date": "18-Nov-15",
"ACTIVITY": "تجارة جملة البوظة",
"Activity-L": "Wholesale of ice cream",
"ADRESS": "بناية عواد\u001c - حي الفتاح - الشارع العام\u001c - درعون - كسروان",
"TEL1": "70/301547",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "4129",
"com-reg-no": "2012411",
"NM": "شركة ايدكو ليبلز ش م ل",
"L_NM": "Societe Eidco Labels sal",
"Last Subscription": "31-Jan-18",
"Industrial certificate no": "3827",
"Industrial certificate date": "13-Apr-18",
"ACTIVITY": "تجارة الصمغ والغراء والمواد اللاصقة",
"Activity-L": "Trading of Glues",
"ADRESS": "ملك زغيب\u001c - الشارع العام \u001c - زوق مكايل - كسروان",
"TEL1": "09/225501",
"TEL2": "03/611530",
"TEL3": "",
"internet": "info@eidcolabels.com"
},
{
"Category": "Excellent",
"Number": "1707",
"com-reg-no": "2007161",
"NM": "شركة زيروك كونستراكشن ليبانون ش م ل",
"L_NM": "Zerock Construction Lebanon ltd - ZCL sal",
"Last Subscription": "11-Jul-17",
"Industrial certificate no": "1941",
"Industrial certificate date": "23-Jun-17",
"ACTIVITY": "تنفيذ تعهدات الهندسة المدنية صناعة الباطون الجاهز",
"Activity-L": "Civil engineering contracting, Manufacture of ready mixed concrete",
"ADRESS": "سنتر فيكتوريا\u001c - الاوتوستراد\u001c - الضبيه - المتن",
"TEL1": "04/444955",
"TEL2": "04/444966",
"TEL3": "03/259393",
"internet": "info@zerok.com"
},
{
"Category": "Second",
"Number": "5930",
"com-reg-no": "67735",
"NM": "شربل سلامة واولاده ش م م",
"L_NM": "Charbel Salameh & Sons sarl",
"Last Subscription": "20-Oct-17",
"Industrial certificate no": "4691",
"Industrial certificate date": "9-Oct-18",
"ACTIVITY": "ميني ماركت وصناعة وتوضيب المأكولات والحلويات",
"Activity-L": "Mini market & manufacture & packing of foods & sweets",
"ADRESS": "ملك شربل سلامة\u001c - شارع الاليزيه\u001c - جبيل",
"TEL1": "09/548065",
"TEL2": "09/547195",
"TEL3": "09/946042",
"internet": "accounting@salamehlb.com"
},
{
"Category": "Fourth",
"Number": "30848",
"com-reg-no": "2047807",
"NM": "مجوهرات القسيس ش م م",
"L_NM": "Al Kassis Jewellery sarl",
"Last Subscription": "10-Jan-18",
"Industrial certificate no": "4779",
"Industrial certificate date": "23-Apr-18",
"ACTIVITY": "تجارة المجوهرات",
"Activity-L": "Trading of jewellery",
"ADRESS": "مبنى هاربويان  - ملك القسيس والعشي\u001c - شارع الماستر مول\u001c - برج حمود - المتن",
"TEL1": "01/260151",
"TEL2": "03/801644",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "31269",
"com-reg-no": "2021168",
"NM": "شركة: Leather Touch - شركة تضامن",
"L_NM": "Leather Touch",
"Last Subscription": "23-Jan-18",
"Industrial certificate no": "4819",
"Industrial certificate date": "1-Nov-18",
"ACTIVITY": "تجارة الجزادين النسائية",
"Activity-L": "Tading of ladies\' sacs",
"ADRESS": "ملك ايفا هاشم\u001c - شارع شركة الكهرباء\u001c - البوشرية - المتن",
"TEL1": "01/883362",
"TEL2": "03/833407",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "31855",
"com-reg-no": "2050623",
"NM": "فـرحـات فـود اكـويـبـمـنـت ش م م",
"L_NM": "Farhat Food Equipment sarl",
"Last Subscription": "8-Jan-18",
"Industrial certificate no": "10",
"Industrial certificate date": "12-Mar-18",
"ACTIVITY": "تجارة معدات ولوازم الافران",
"Activity-L": " Trade of bakery equipment",
"ADRESS": "ملك شكيب الريشاني\u001c - العمروسيه - طريق صيدا القديمة\u001c - الشويفات - عاليه",
"TEL1": "05/441607",
"TEL2": "03/883411",
"TEL3": "",
"internet": "info@farhatbakery.com"
},
{
"Category": "Fourth",
"Number": "31678",
"com-reg-no": "1011270",
"NM": "شركة مصنوعات الكعكي للاراكيل لصاحبيها غسان وحسان الكعكي - شركة تضامن",
"L_NM": "Kaaki Sisha",
"Last Subscription": "9-Jun-17",
"Industrial certificate no": "3786",
"Industrial certificate date": "7-Apr-18",
"ACTIVITY": "صناعة قوالب الاراكيل المعدنية",
"Activity-L": "Manufacture of hubble bubble molds",
"ADRESS": "بناية الفقيه\u001c - شارع الاستقلال\u001c - حوض الولاية - بيروت",
"TEL1": "01/568190",
"TEL2": "03/548363",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "31740",
"com-reg-no": "2047497",
"NM": "شركة Crazy Nuts sarl",
"L_NM": "Crazy Nuts sarl",
"Last Subscription": "20-Jul-17",
"Industrial certificate no": "3289",
"Industrial certificate date": "4-Feb-18",
"ACTIVITY": "محمصة",
"Activity-L": "Roastary",
"ADRESS": "مبنى سارة 5 ملك نادر المصري واخوانه\u001c - حي الامراء \u001c - الشويفات - عاليه",
"TEL1": "05/437388",
"TEL2": "03/678219",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "30735",
"com-reg-no": "2034612",
"NM": "اسكو ش م ل",
"L_NM": "ASCO sal",
"Last Subscription": "3-Jan-18",
"Industrial certificate no": "3393",
"Industrial certificate date": "25-Feb-19",
"ACTIVITY": "صناعة الدهانات واللكر والسلر والتنر والمعاجين",
"Activity-L": "Manufacture of paints",
"ADRESS": "ملك سامي عساف\u001c - الوادي الصناعي - طريق نهر الموت\u001c - عين سعاده - المتن",
"TEL1": "01/897550",
"TEL2": "01/892799",
"TEL3": "03/635996",
"internet": "info@ascopaints.com"
},
{
"Category": "Fourth",
"Number": "31653",
"com-reg-no": "2043826",
"NM": "زهر الدين للتجارة والصناعة",
"L_NM": "Zahreddine Trading & Manufacturing",
"Last Subscription": "26-May-17",
"Industrial certificate no": "3352",
"Industrial certificate date": "11-Feb-18",
"ACTIVITY": "صناعة وتعبئة العطورات ومزيل الرائحة وشامبو وجل",
"Activity-L": "Manufature & filling of perfume, deodorant, shampoo & gel",
"ADRESS": "بناية زهر الدين\u001c - حي الحرش\u001c - كيفون - عاليه",
"TEL1": "05/270806",
"TEL2": "03/903261",
"TEL3": "",
"internet": "mahdi@zahreddine.com"
},
{
"Category": "Fourth",
"Number": "30826",
"com-reg-no": "2043087",
"NM": "مارسيا ش م ل",
"L_NM": "Marcia sal",
"Last Subscription": "30-Jan-18",
"Industrial certificate no": "3735",
"Industrial certificate date": "1-Apr-18",
"ACTIVITY": "مصنعا لتحميص وتعبئة وتوضيب البزورات والمكسرات",
"Activity-L": "Manufacture for mixed nuts, roasting & packaging",
"ADRESS": "ملك كرم وشمعون\u001c - الشارع العام\u001c - غزير - كسروان",
"TEL1": "03/457933",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Fourth",
"Number": "32002",
"com-reg-no": "2043127",
"NM": "تن ش م ل",
"L_NM": "Ten sal",
"Last Subscription": "26-Jul-17",
"Industrial certificate no": "2889",
"Industrial certificate date": "9-Nov-17",
"ACTIVITY": "مصنعا لتعبئة المياه ضمن غالونات بلاستيك",
"Activity-L": "Manufacture of filling water in plastic containers",
"ADRESS": "ملك شركة الارض الخضراء ش م ل\u001c - الاوتوستراد\u001c - النقاش - المتن",
"TEL1": "04/528004",
"TEL2": "",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "6898",
"com-reg-no": "2043795",
"NM": "ايفر, انك ش م ل",
"L_NM": "Aver, Inc. sal",
"Last Subscription": "23-Feb-18",
"Industrial certificate no": "4874",
"Industrial certificate date": "14-Nov-18",
"ACTIVITY": "صناعة الالبسة الموحدة والبياضات والاحذية",
"Activity-L": "Manufacture of uniforms, linen & shoes",
"ADRESS": "ملك شركة فيتراس ش م م\u001c - شارع الزحيمة\u001c - الحازمية - بعبدا",
"TEL1": "05/950202",
"TEL2": "05/451732",
"TEL3": "",
"internet": "rnj@emilerassam.com"
},
{
"Category": "Fourth",
"Number": "32094",
"com-reg-no": "2050337",
"NM": "ديمانتو",
"L_NM": "Demanto",
"Last Subscription": "27-Jan-18",
"Industrial certificate no": "4659",
"Industrial certificate date": "2-Apr-18",
"ACTIVITY": "صناعة المجوهرات",
"Activity-L": "Manufacture of jewelery",
"ADRESS": "سنتر هاربويان- ملك دميرجيان\u001c - شارع سان فارتان\u001c - برج حمود - المتن",
"TEL1": "01/244183",
"TEL2": "03/030300",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "29482",
"com-reg-no": "2046912",
"NM": "غلوبل فودز ش م ل",
"L_NM": "Global Foods sal",
"Last Subscription": "12-Feb-18",
"Industrial certificate no": "612",
"Industrial certificate date": "19-Sep-18",
"ACTIVITY": "تجارة الخبز والكعك",
"Activity-L": "Trading of bread & cakes",
"ADRESS": "ملك كاظم ابراهيم\u001c - اوتوستراد خلده\u001c - القبه - عاليه",
"TEL1": "01/837437",
"TEL2": "05/815815",
"TEL3": "",
"internet": ""
},
{
"Category": "Second",
"Number": "7322",
"com-reg-no": "2036049",
"NM": "جــيمـكو لـلتـجـارة والـصـناعـة الـعـامـة ش م ل",
"L_NM": "Gimco for General Trading & Industry sal",
"Last Subscription": "10-Feb-18",
"Industrial certificate no": "132",
"Industrial certificate date": "4-Jul-18",
"ACTIVITY": "صناعة مواد تجميل",
"Activity-L": "Manufacture of cosmetic products",
"ADRESS": "بناية جيمكو\u001c - الشارع العام - المدينة الصناعية\u001c - بعبدات - المتن",
"TEL1": "04/977773",
"TEL2": "03/245514",
"TEL3": "",
"internet": "geoffrey.maalouf@gimco.com"
},
{
"Category": "Third",
"Number": "15185",
"com-reg-no": "42005",
"NM": "مطاحن عمار",
"L_NM": "Ammar Mills",
"Last Subscription": "15-Feb-18",
"Industrial certificate no": "349",
"Industrial certificate date": "7-Feb-19",
"ACTIVITY": "معملا لطحن البهارات وتعبئة الحبوب",
"Activity-L": "Grinding of spices & packing of cereal",
"ADRESS": "ملك حياة مكتبي\u001c - الشارع العام\u001c - المكلس - المتن",
"TEL1": "01/684180",
"TEL2": "03/884040",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "25552",
"com-reg-no": "51613",
"NM": "مؤسسة ميشال سعد لصناعة وتجارة المفروشات",
"L_NM": "Ets. Michel Saad Pour Fabrication Et Commerce de Meubles",
"Last Subscription": "15-Feb-18",
"Industrial certificate no": "4647",
"Industrial certificate date": "29-Sep-18",
"ACTIVITY": "صناعة المفروشات الخشبية",
"Activity-L": "Manufacture of wooden furniture",
"ADRESS": "ملك ميشال سعد\u001c - المدينة الصناعية - شارع محطة الكهرباء\u001c - البوشرية - المتن",
"TEL1": "01/875372",
"TEL2": "03/386640",
"TEL3": "",
"internet": ""
},
{
"Category": "Third",
"Number": "29500",
"com-reg-no": "2043498",
"NM": "شركة ليفانتين لوكشيري باكيجينغ ش م م",
"L_NM": "Levantine Luxury Packaging sarl",
"Last Subscription": "1-Feb-18",
"Industrial certificate no": "4873",
"Industrial certificate date": "14-May-18",
"ACTIVITY": "صناعة الجلديات والعلب وتجليد الكتب",
"Activity-L": "Manufacture of leather , boxes & bookbinding",
"ADRESS": "بناية البعينو\u001c - طريق المطار  - شارع محطة الايتام\u001c - برج البراجنة - بعبدا",
"TEL1": "01/455000",
"TEL2": "03/455000",
"TEL3": "",
"internet": ""
}
]';


    $array=json_decode($json,true);
//var_dump($array);

     foreach($array as $row){
         echo $row['TEL1'];
  
         $companies = $this->Company->GetCompaniesByMinistry($row['TEL1'], $row['TEL2'], $row['TEL3'], '', '');
     $id='';
     if(count($companies)>0)
     {
         foreach($companies as $company)
         {
             $id.=$company->id.',';
             if($row['Category']!='' or $row['Number']!=''){
                 $this->Administrator->edit('tbl_company',array('chambe_commerce_category'=>$row['Category'],'chambe_commerce_no'=>$row['Number']),$company->id);
             }

         }
     }

    $data=array(
        'Category'=>$row['Category'],
        'Number'=>$row['Number'],
        'com_reg_no'=>$row['com_reg_no'],
        'NM'=>$row['NM'],
        'L_NM'=>$row['L_NM'],
        'LastSubscription'=>$row['Last_Subscription'],
        'Industrial_certificate_no'=>$row['Industrial_certificate_no'],
        'Industrial_certificate_date'=>$row['Industrial_certificate_date'],
        'ACTIVITY'=>$row['ACTIVITY'],
        'Activity_L'=>$row['Activity_L'],
        'ADRESS'=>$row['ADRESS'],
        'TEL1'=>$row['TEL1'],
        'TEL2'=>$row['TEL2'],
        'TEL3'=>$row['TEL3'],
        'internet'=>$row['internet'],
        'company_id'=>$id
        );
        
        $this->General->save('wcompanies',$data);
        
        }
    }
    public function dc()
    {

        //$name = $_FILES;
        $name = FCPATH.'industrialcompanies2017-2018.xlsx';
      //  echo $name;
        $file= base_url().'industrialcompanies2017-2018.xlsx';
        include APPPATH . 'libraries/PHPExcel/IOFactory.php';
        header('Content-type: text/html; charset=UTF-8; encoding=UTF-8');
        $objPHPExcel = PHPExcel_IOFactory::load($name);
        //echo 'test123';
        var_dump($objPHPExcel);
        $maxCell = $objPHPExcel->getActiveSheet()->getHighestRowAndColumn();

        $sheetData = $objPHPExcel->getActiveSheet()->rangeToArray('A1:' . $maxCell['column'] . $maxCell['row']);
        $sheetData = array_map('array_filter', $sheetData);

        $sheetData = array_filter($sheetData);
        var_dump($sheetData);
        //$format = array('title','Date (DD-MM-YYYY)','start time (HH:MM:SS AM/PM)','end time (HH:MM:SS AM/PM)','Tags (Comma Separated)','Is AD','title en');
        //if($sheetData[0] == $format)
        //	{
        unset($sheetData[0]);
        foreach ($sheetData as $filesop) {
            $data = array(
                'name' => $filesop[1],
                'activity1' => $filesop[2],
                'activity2' => $filesop[3],
                'activity3' => $filesop[15],
                'district' => $filesop[4],
                'area' => $filesop[5],
                'street' => $filesop[6],
                'address' => $filesop[7],
                'phone1' => $filesop[8],
                'phone2' => $filesop[9],
                'phone3' => $filesop[10],
                'mobile1' => @$filesop[11],
                'mobile2' => @$filesop[12],
                'email' => @$filesop[13],
                'type' => @$filesop[14],
                'note' => @$filesop[16],
                'create_time' => $this->datetime,
                'update_time' => $this->datetime,
            );
            echo '<pre>';
            var_dump($data);
            echo '</pre>';
            // $this->General->save('ministry_industry',$data);
        }
        //	redirect('clients/schedules');
        //}
    }

    public function statements()
    {
        $row = 0;
        $query = array();
        $total_row = 0;
        if (isset($_GET['search'])) {
            $limit = 50;
            $row = $this->input->get('per_page');
            $govID = $this->input->get('gov');
            $districtID = $this->input->get('district_id');
            $year = $this->input->get('year');
            $areaID = $this->input->get('area_id');
            $config['base_url'] = base_url() . 'companies/statements?gov=' . $govID . '&district_id=' . $districtID . '&area_id=' . $areaID . '&years=' . $year . '&search=Search';

            $statements = $this->Company->GetStatementsIDs($year);
            $array_ids = array();
            foreach ($statements as $statement) {
                array_push($array_ids, $statement->company_id);
            }
            $query = $this->Company->GetStatementsCompanies($array_ids, $govID, $districtID, $areaID, $row, $limit);
            $total_row = count($this->Company->GetStatementsCompanies($array_ids, $govID, $districtID, $areaID, 0, 0));

            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['total_rows'] = $total_row;
            $config['per_page'] = $limit;
            $config['num_links'] = 6;
            $this->pagination->initialize($config);

            $this->data['links'] = $this->pagination->create_links();
        } elseif (isset($_GET['clear'])) {
            redirect('companies/statements');
        }
        $this->data['total_row'] = $total_row;
        $this->data['govID'] = @$govID;
        $this->data['districtID'] = @$districtID;
        $this->data['areaID'] = @$areaID;
        $this->data['year'] = @$year;
        $this->data['query'] = $query;
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Companies');
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";;
        $this->data['subtitle'] = "المسح الصناعي";
        $this->data['sectors'] = $this->Item->GetSector('online', 0, 0);
        $this->data['sections'] = $this->Item->GetSection('online', 0, 0);
        $this->data['districts'] = $this->Address->GetDistrictByGov('online', $this->data['govID']);
        $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        $this->data['areas'] = $this->Address->GetAreaByDistrict('online', @$districtID);
        $this->template->load('_template', 'company/statements', $this->data);
    }

    public function statement($id, $sid = '')
    {
        $action = 'add';
        if (isset($_POST['action'])) {
            $action = $this->input->post('action');
            if ($action == 'add') {
                $data = array(
                    'company_id' => $id,
                    'notes' => $this->input->post('notes'),
                    'year' => $this->input->post('year'),
                    'create_time' => $this->datetime,
                    'update_time' => $this->datetime,
                    'user_id' => $this->session->userdata('id'),
                );
                $this->General->save('tbl_companies_statements', $data);
                $this->session->set_userdata(array('admin_message' => 'Added Successfully'));
            } elseif ($action == 'edit') {
                $data = array(
                    'notes' => $this->input->post('notes'),
                    'year' => $this->input->post('year'),
                    'update_time' => $this->datetime,
                    'user_id' => $this->session->userdata('id'),
                );
                $this->Administrator->edit('tbl_companies_statements', $data, $sid);
                $this->session->set_userdata(array('admin_message' => 'Added Successfully'));
            }
            redirect('companies/statement/' . $id);
        }
        if ($sid != '') {
            $action = 'edit';
            $row = $this->Company->GetStatementById($sid);
            $this->data['notes'] = $row['notes'];
            $this->data['year'] = $row['year'];
        }
        /* 	$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'delete');
          $p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'edit');
          $p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,16,'add');
         */
        $this->data['action'] = $action;
        $query = $this->Company->GetCompanyById($id);
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Companies', 'companies');
        $this->breadcrumb->add_crumb($query['name_en'], 'companies/details/' . $id);
        $this->breadcrumb->add_crumb(' المسح الصناعي', 'companies/statement/' . $id);

        $this->data['id'] = $id;
        $this->data['query'] = $query;

        $this->data['p_delete'] = TRUE;
        $this->data['p_edit'] = TRUE;
        $this->data['p_add'] = TRUE;
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->data['items'] = $this->Company->GetStatementsByCompanyId($id);
        $this->data['title'] = $this->data['Ctitle'] . " -  المسح الصناعي";
        $this->data['subtitle'] = "  المسح الصناعي";
        $this->template->load('_template', 'company/statement', $this->data);
    }

    public function ministry($row = 0)
    {
        $query = array();
        $total_row = 0;
        $limit = 30;
        $this->data['search'] = FALSE;
        $query = $this->Company->GetAllMinistryCompanies($row, $limit);

        $total_row = count($this->Company->GetAllMinistryCompanies(0, 0));


        $config['total_rows'] = $total_row;


        $this->pagination->initialize($config);
        $this->data['query'] = $query;
        $this->data['total_row'] = $total_row;

        $config['enable_query_strings'] = FALSE;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $total_row;
        $config['per_page'] = $limit;
        $config['num_links'] = 6;
        $config['base_url'] = base_url() . 'companies/ministry';
        $this->pagination->initialize($config);

        $this->data['links'] = $this->pagination->create_links();
        $this->data['st'] = $this->uri->segment(4);
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Companies');
        $this->data['title'] = $this->data['Ctitle'] . "وزارة الصناعة";
        $this->data['subtitle'] = "وزارة الصناعة";
        // $this->data['districts'] = $this->Address->GetDistrictByGov('online', $this->data['govID']);
        // $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        //$this->data['areas'] = $this->Address->GetAreaByDistrict('online', $districtID);
        $this->template->load('_template', 'company/ministry', $this->data);
    }

    public function geo()
    {
        $this->data['query'] = $query = $this->Company->GetGeoCompanies();
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Companies');
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";;
        $this->data['subtitle'] = "Companies - الشركات";

        $this->template->load('_template', 'company/geo', $this->data);
    }
    public function district()
    {
        $this->data['query'] = $query = $this->Company->GetGeoCompaniesByDistrict();
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Companies','companies');
        $this->breadcrumb->add_crumb('By Kazaa');
        $this->data['title'] = $this->data['Ctitle'] . " - Companies By Kazaa";
        $this->data['subtitle'] = "Companies By Kazaa";

        $this->template->load('_template', 'company/district', $this->data);
    }
    public function governorate()
    {
        $this->data['query'] = $query = $this->Company->GetGeoCompaniesByGovernorate();
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Companies','companies');
        $this->breadcrumb->add_crumb('By Mohafazat');
        $this->data['title'] = $this->data['Ctitle'] . " - Companies By Mohafazat";
        $this->data['subtitle'] = "Companies By Mohafazat";

        $this->template->load('_template', 'company/governorate', $this->data);
    }

    public function geo_export()
    {

        // filename for download
        $filename = "geo-companies-" . time() . ".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        echo '<style type="text/css">
*{
background: none !important;
}
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
        $query = $this->Company->GetGeoCompanies();
        // $query=$all['results'];
        // $total_row = $all['num_results'];

        echo '<table style="background: none !important;" cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th width="20%">Mohafaz</th>
                                        <th width="20%">Kazaa</th>
                                        <th width="20%">Area</th>
                                        <th width="20%">Company Number</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($query as $row) {
            echo '<tr>
                                    <td style="text-align:right;">' . $row->governorate_ar . ' - ' . $row->governorate_en . '</td>
                                    <td style="direction:rtl !important; text-align:right !important;">' . $row->district_ar . ' - ' . $row->district_en . '</td>
                                     <td>' . $row->area_ar . ' - ' . $row->area_en . '</td>
                                    <td>' . $row->company_count . '</td>
                                   
                                </tr>';

        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }
    public function district_export()
    {

        // filename for download
        $filename = "district-companies-" . time() . ".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        echo '<style type="text/css">
*{
background: none !important;
}
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
        $query = $this->Company->GetGeoCompaniesByDistrict();
        // var_dump($query);
        // $query=$all['results'];
        // $total_row = $all['num_results'];

        echo '<table style="background: none !important;" cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th width="20%">Mohafaz</th>
                                        <th width="20%">Kazaa</th>
                                        <th width="20%">Percentage</th>
                                        <th width="20%">Company Number</th>
                            </tr>
                        </thead>
                        <tbody>';
        $total=0;
        foreach($query as $row){
            $total+=$row->company_count;

        }
        foreach($query as $row){
            $percentage=round((($row->company_count*100)/$total),2);
            echo '<tr>
                                    <td style="text-align:right;">' . $row->governorate_ar . ' - ' . $row->governorate_en . '</td>
                                    <td style="direction:rtl !important; text-align:right !important;">' . $row->district_ar . ' - ' . $row->district_en . '</td>
                                    <td>'.$percentage.' %</td>
                                    <td>' . $row->company_count . '</td>
                                   
                                </tr>';

        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }
    public function governorate_export()
    {

        // filename for download
        $filename = "governorate-companies-" . time() . ".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        echo '<style type="text/css">
*{
background: none !important;
}
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
        $query = $this->Company->GetGeoCompaniesByGovernorate();
        // $query=$all['results'];
        // $total_row = $all['num_results'];

        echo '<table style="background: none !important;" cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th width="20%">Mohafaz</th>
                                 <th width="20%">Percentage</th>
                                 <th width="20%">Company Number</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($query as $row) {
            $total=0;
            foreach($query as $row){
                $total+=$row->company_count;

            }
            $percentage=round((($row->company_count*100)/$total),2);
            echo '<tr>
                                    <td style="text-align:right;">' . $row->governorate_ar . ' - ' . $row->governorate_en . '</td>
                                    <td>'.$percentage.' %</td>
                                    <td>' . $row->company_count . '</td>
                                   
                                </tr>';

        }
        echo '</tbody>';

        echo '</table>';

        //return $filename;
        exit;
    }

    public function ministry_company($row = 0)
    {
        $query = array();
        $total_row = 0;
        $limit = 30;
        $this->data['search'] = FALSE;
        $query = $this->Company->GetAllMinistry($row, $limit);

        $total_row = count($this->Company->GetAllMinistry(0, 0));


        $config['total_rows'] = $total_row;


        $this->pagination->initialize($config);
        $this->data['query'] = $query;
        $this->data['total_row'] = $total_row;

        $config['enable_query_strings'] = FALSE;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $total_row;
        $config['per_page'] = $limit;
        $config['num_links'] = 6;
        $config['base_url'] = base_url() . 'companies/ministry_company';
        $this->pagination->initialize($config);

        $this->data['links'] = $this->pagination->create_links();
        $this->data['st'] = $this->uri->segment(4);
        $this->data['msg'] = $this->session->userdata('admin_message');
        $this->session->unset_userdata('admin_message');
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard', 'dashboard');
        $this->breadcrumb->add_crumb('Companies');
        $this->data['title'] = $this->data['Ctitle'] . "وزارة الصناعة";
        $this->data['subtitle'] = "وزارة الصناعة";
        // $this->data['districts'] = $this->Address->GetDistrictByGov('online', $this->data['govID']);
        // $this->data['governorates'] = $this->Address->GetGovernorate('online', 0, 0);
        //$this->data['areas'] = $this->Address->GetAreaByDistrict('online', $districtID);
        $this->template->load('_template', 'company/ministry_company', $this->data);
    }

    public function save_report()
    {
        $ministry_id = $this->input->post('ministry_id');
        $companies = $this->Company->GetCompaniesByMinistry($this->input->post('phone1'), $this->input->post('phone2'), $this->input->post('phone3'), $this->input->post('mobile1'), $this->input->post('mobile2'));


        $data = array(
            'ministry_id' => $ministry_id,
            'title' => $this->input->post('ministry_title'),
            'companies' => json_encode($companies),
            'create_time' => $this->datetime,
            'update_time' => $this->datetime,
            'user_id' => $this->session->userdata('id'),
        );
        $query = $this->Company->GetMinistryReport($ministry_id);
        if (count($query) > 0) {
            $this->session->set_userdata(array('admin_message' => 'Company Upadted in Report'));
            $this->Administrator->edit('ministry_reports', $data, $query['id']);
        } else {
            $this->session->set_userdata(array('admin_message' => 'Company Added To Report'));
            $this->General->save('ministry_reports', $data);
        }
        redirect($this->agent->referrer());


    }

    public function insert($id)
    {
        $query = $this->Company->GetMinistryCompanyById($id);

        $governorate = $this->Administrator->GetGovernorateByName($query['governorate']);
        $districts = $this->Administrator->GetDistrictByName($query['district']);
        $area = $this->Administrator->GetAreaByName($query['area']);

        $activities_array = array();
        $phone_array = array();
        (@$query['activity1'] != '') ? array_push($activities_array, @$query['activity1']) : false;
        (@$query['activity2'] != '') ? array_push($activities_array, @$query['activity2']) : false;
        (@$query['activity3'] != '') ? array_push($activities_array, @$query['activity3']) : false;
        (@$query['activity4'] != '') ? array_push($activities_array, @$query['activity4']) : false;

        (@$query['phone1'] != '') ? array_push($phone_array, @$query['phone1']) : false;
        (@$query['phone2'] != '') ? array_push($phone_array, @$query['phone2']) : false;
        (@$query['phone3'] != '') ? array_push($phone_array, @$query['phone3']) : false;
        (@$query['mobile1'] != '') ? array_push($phone_array, @$query['mobile1']) : false;
        (@$query['mobile2'] != '') ? array_push($phone_array, @$query['mobile2']) : false;

        $data = array(
            'name_ar' => $query['name'],
            'activity_ar' => implode('-', $activities_array),
            'governorate_id' => @$governorate['id'],
            'district_id' => @$districts['id'],
            'area_id' => @$area['id'],
            'street_ar' => $query['street'],
            'bldg_ar' => $query['address'],
            'phone' => implode('-', $phone_array),
            'email' => $query['email'],

            'wezara_source' => 1,
            'nbr_source' => $query['note'],
            'address2_ar' => $query['governorate'] . ' - ' . $query['district'] . ' - ' . $query['area'],
            'type_source' => $query['type'],
            'ministry_id' => $id,
            'create_time' => $this->datetime,
            'update_time' => $this->datetime,
            'user_id' => $this->session->userdata('id'),
        );

        if ($cid = $this->General->save($this->company, $data)) {
            $history = array('action' => 'add', 'logs_id' => 0, 'type' => 'company-ministry', 'details' => json_encode($data), 'item_id' => $cid, 'item_title' => $data['name_ar'], 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
            $this->General->save('logs', $history);
            $this->session->set_userdata(array('admin_message' => 'Company Added successfully'));
            $this->General->delete('ministry_industry', array('id' => $id));
            redirect('companies/edit/' . $cid);
        } else {
            $this->session->set_userdata(array('admin_message' => 'Error'));
            redirect($this->agent->referrer());
        }

    }

    public function save($id)
    {
        $query = $this->Company->GetMinistryById($id);

        $governorate = $this->Administrator->GetGovernorateByName($query['governorate']);
        $districts = $this->Administrator->GetDistrictByName($query['district']);
        $area = $this->Administrator->GetAreaByName($query['area']);

        $activities_array = array();
        $phone_array = array();
        (@$query['activity1'] != '') ? array_push($activities_array, @$query['activity1']) : false;
        (@$query['activity2'] != '') ? array_push($activities_array, @$query['activity2']) : false;
        (@$query['activity3'] != '') ? array_push($activities_array, @$query['activity3']) : false;
        (@$query['activity4'] != '') ? array_push($activities_array, @$query['activity4']) : false;

        (@$query['phone1'] != '') ? array_push($phone_array, @$query['phone1']) : false;
        (@$query['phone2'] != '') ? array_push($phone_array, @$query['phone2']) : false;
        (@$query['phone3'] != '') ? array_push($phone_array, @$query['phone3']) : false;
        (@$query['mobile1'] != '') ? array_push($phone_array, @$query['mobile1']) : false;
        (@$query['mobile2'] != '') ? array_push($phone_array, @$query['mobile2']) : false;

        $data = array(
            'name_ar' => $query['name'],
            'activity_ar' => implode('-', $activities_array),
            'governorate_id' => @$governorate['id'],
            'district_id' => @$districts['id'],
            'area_id' => @$area['id'],
            'street_ar' => $query['street'],
            'bldg_ar' => $query['address'],
            'phone' => implode('-', $phone_array),
            'email' => $query['email'],

            'wezara_source' => 1,
            'nbr_source' => $query['note'],
            'address2_ar' => $query['governorate'] . ' - ' . $query['district'] . ' - ' . $query['area'],
            'type_source' => $query['type'],
            'ministry_id' => $id,
            'origin' => $query['origin'],
            'investment' => $query['investment'],
            'create_time' => $this->datetime,
            'update_time' => $this->datetime,
            'user_id' => $this->session->userdata('id'),
        );

        if ($cid = $this->General->save($this->company, $data)) {
            $history = array('action' => 'add', 'logs_id' => 0, 'type' => 'company-ministry', 'details' => json_encode($data), 'item_id' => $cid, 'item_title' => $data['name_ar'], 'create_time' => $this->datetime, 'user_id' => $this->session->userdata('id'));
            $this->General->save('logs', $history);
            $this->session->set_userdata(array('admin_message' => 'Company Added successfully'));
            $this->General->delete('ministry_company', array('id' => $id));
            redirect('companies/edit/' . $cid);
        } else {
            $this->session->set_userdata(array('admin_message' => 'Error'));
            redirect($this->agent->referrer());
        }
    }

    public function update_ministry($id, $cid)
    {
        $query = $this->Company->GetMinistryById($id);
        $data = array(
            'origin' => $query['origin'],
            'investment' => $query['investment'],
            'update_time' => $this->datetime,
            'user_id' => $this->session->userdata('id'),
        );
        $this->Administrator->edit($this->company, $data, $cid);
        $this->session->set_userdata(array('admin_message' => 'Company Updated successfully'));
        $this->General->delete('ministry_company', array('id' => $id));
        redirect($this->agent->referrer());

    }

    public function ministry_delete($id)
    {

        $this->session->set_userdata(array('admin_message' => 'Company Deleted successfully'));
        $this->General->delete('ministry_industry', array('id' => $id));
        redirect($this->agent->referrer());

    }

    public function ministry_company_delete($id)
    {

        $this->session->set_userdata(array('admin_message' => 'Company Deleted successfully'));
        $this->General->delete('ministry_company', array('id' => $id));
        redirect($this->agent->referrer());

    }

    public function report_ministry($id)
    {
        $query = $this->Company->GetMinistryById($id);

        $companies = $this->Company->GetCompaniesByMinistry($query['phone1'], $query['phone2'], $query['phone3'], $query['mobile1'], $query['mobile2']);


        $data = array(
            'ministry_id' => $id,
            'title' => $query[''],
            'companies' => json_encode($companies),
            'create_time' => $this->datetime,
            'update_time' => $this->datetime,
            'user_id' => $this->session->userdata('id'),
        );
        $query = $this->Company->GetMinistryReport($id);
        if (count($query) > 0) {
            $this->session->set_userdata(array('admin_message' => 'Company Updated in Report'));
            $this->Administrator->edit('ministry_reports', $data, $query['id']);
        } else {
            $this->session->set_userdata(array('admin_message' => 'Company Added To Report'));
            $this->General->save('ministry_reports', $data);
        }
        redirect($this->agent->referrer());


    }
    public function adv()
    {
if($this->input->get('clear'))
        {
            redirect('companies/adv');
        }
        $get_array=array();
        $this->data['search'] = TRUE;
        $limit = 10;
        $row = $this->input->get('per_page');
       $config['base_url'] = '?search=';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $sales_man=$this->input->get('sales_man');

        $query = $this->Company->GetAdCompanies($sales_man, $row, $limit);

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
        $this->breadcrumb->add_crumb('Companies');
        $this->breadcrumb->add_crumb('Adv. Companies','companies/adv/');
        $this->data['title'] = $this->data['Ctitle'] ."Adv. Companies";
        $this->data['subtitle'] = "Adv. Companies";
        $this->data['sales'] = $this->Company->GetSalesMen();

        $this->template->load('_template', 'company/adv', $this->data);
    }
    public function adv_view()
    {
        $sales_man=$this->input->get('sales_man');
        if($sales_man!='')
        {
            $salesm=$this->Company->GetSalesMan($sales_man);
            $subtitle=$salesm['fullname'];
        }
        else{
            $subtitle='جميع المندوبين';
        }
        $query = $this->Company->GetAdCompanies($sales_man, 0, 0);
        $this->data['query'] =$query['rows'];
        $this->data['total'] =$query['total'];
        $this->data['title'] = $this->data['Ctitle'] . " - Companies - الشركات";
        $this->data['subtitle'] = "الشركات المعلنة<br>".$subtitle;
        $this->load->view('company/listviewad', $this->data);
    }
     public function adv_excel()
    {
        $sales_man=$this->input->get('sales_man');
        $filename = "Adv-company-" . $sales_man . ".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        
        if($sales_man!='')
        {
            $salesm=$this->Company->GetSalesMan($sales_man);
            $subtitle=$salesm['fullname'];
        }
        else{
            $subtitle='جميع المندوبين';
        }
        $query = $this->Company->GetAdCompanies($sales_man, 0, 0);
        
        
        echo '<table class="tblx">
        <tr>
            <th>رقم</th>
            <th>Code</th>
            <th style="width: 150px !important">الشركة</th>
            <th style="width: 150px !important">المسؤول</th>
            <th>النشاط</th>
            <th style="width: 100px !important">المحافظة</th>
            <th style="width: 100px !important">القضاء</th>
            <th style="width: 100px !important">المنطقة</th>
            <th>الشارع</th>
            <th>هاتف</th>
            <th>المندوب</th>
 <th>القيمة 1</th>
 <th>القيمة 2</th>

            <th>عدد دليل</th>
            <th>عدد انترنت</th>
            <th style="width: 150px !important">صفحات عربي</th>
            <th style="width: 150px !important">صفحات إنجليزي</th>
            <th style="width: 350px !important">ملاحظات</th>

        </tr>';
      
		$i=1;
		foreach($query['rows'] as $row){

			if($row->is_exporter==1){
					$exporter='نعم';
				}
				else{
					$exporter='كلا';
					}
				if($row->is_adv==1){
					$is_adv='نعم';
				}
				else{
					$is_adv='كلا';
					}	
					if($row->copy_res==1){
					$copy_res='نعم';
				}
				else{
					$copy_res='كلا';
					}
            

		
        	echo '<tr>
        	     <td>'.$i.'</td>
                    <td>'.$row->id.'</td>
                    <td>'.$row->name_ar.'</td>
                    <td>'.str_replace('-','<br>',$row->owner_name).'</td>
                    <td>'.$row->activity_ar.'</td>
                    <td>'.$row->governorate_ar.'</td>
                    <td>'.$row->district_ar.'</td>
                    <td>'.$row->area_ar.'</td>
                    <td>'.$row->street_ar.'</td>
                    <td>'.str_replace('-','<br>',$row->phone).'</td>
                    <td>'.$row->salesman.'</td>
                    <td>'.$row->adv_value1.'</td>
                    <td>'.$row->adv_value2.'</td>
                    <td align="center">'.(($row->CNbr*2)+1).'</td>
                    <td align="center">'.(($row->CNbr*2)+4).'</td>
                    <td>'.$row->guide_pages_ar.'</td>
                    <td>'.$row->guide_pages_en.'</td>
                    <td></td>
        	</tr>';
		   $i++;
		   } 
            echo '</table>';
            
    }


}

?>