<?php
if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends Application {
    public function __construct() {
        parent::__construct();
        $this->ag_auth->restrict('dashboard'); // restrict this controller to admins only
        $this->load->model(array('Administrator', 'Company', 'Bank', 'Insurance', 'Importer', 'Transport','Task'));
    }

    public function _Invoices() {
        $paids_nb = $this->Invoice->GetNumberOfInvoiceByDate(date('Y'), 'paid');
        $total_paids = $this->Invoice->GetSumByDate(date('Y'), 'paid');
        if($total_paids['subtotal'] != '')
            $total_pd = $total_paids['subtotal'];
        else
            $total_pd = 0;
        $total_pending = $this->Invoice->GetSumByDate(date('Y'), 'pending');
        if($total_pending['subtotal'] != '')
            $total_pend = $total_pending['subtotal'];
        else
            $total_pend = 0;
        $pending_nb = $this->Invoice->GetNumberOfInvoiceByDate(date('Y'), 'pending');
        $paids = $this->Invoice->GetDataInvoiceByDate(date('Y'), 'paid');
        $pending = $this->Invoice->GetDataInvoiceByDate(date('Y'), 'pending');
        return array('paids' => $paids, 'pending' => $pending, 'paids_nb' => $paids_nb, 'pending_nb' => $pending_nb, 'total_paids' => $total_pd, 'total_pending' => $total_pend);
    }

    public function _Schedules() {
        $biding = $this->Schedule->GetNbrSchedules(1, 'pending');
        $public = $this->Schedule->GetNbrSchedules(2, 'pending');
        $visa = $this->Schedule->GetNbrSchedulesPendingVisa('Pending');
        return array('biding' => $biding, 'public' => $public, 'visa' => $visa);
    }

    public function companystatement($id) {
        $this->Administrator->edit('tbl_companies_statements', array('notes' => ''), $id);
        $this->session->set_userdata(array('companies_statements_message' => 'Closed'));
        redirect('dashboard');
    }
    public function visitors_monthly()
    {

        $this->data['title'] = $this->data['Gtitle']." - Monthly Visitors ".date('m');
        $this->data['days_visitors'] = $days_visitors = $this->Administrator->GetVisitorsByDays(date('m'));
        $this->load->view('visitors_monthly',$this->data);
    }
    public function visitors_search()
    {

        $from=$this->input->get('from');
        $to=$this->input->get('to');
        $this->data['title'] = $this->data['Gtitle']." - Search Visitors : ".$from.' -> '.$to;
        $this->data['search_visitors'] = $search_visitors = $this->Administrator->SearchVisitorsByDays($from,$to);
        $this->load->view('visitors_search',$this->data);
    }
    public function CompanyTasks()
    {

    }
    public function index() {
       
        $this->data['title'] = $this->data['Gtitle']." - Dashboard";
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Dashboard');
        $from='';
        $to='';
        if($this->input->get('search'))
        {
            $from=$this->input->get('from');
            $to=$this->input->get('to');


        }
        $this->data['search_visitors'] = $search_visitors = $this->Administrator->SearchVisitorsByDays($from,$to);
        $this->data['company_statement_msg'] = $this->session->userdata('companies_statements_message');
        $this->session->unset_userdata('companies_statements_message');

        $companies = $this->Company->GetCompanies('', 0, 0);
        //$companies = [];
         
        $copy_res = $this->Company->GetIndustrialCompanies(1, '', 0, 0);
        $is_adv = $this->Company->GetIndustrialCompanies('', 1, 0, 0);
       $statements = $this->Company->GetStatementsIDs(date('Y'));
        $all = $this->Task->GetTasks('','', 0, 0, 0, '', '', '', '','', '', '','done','', 0, 0,'');

        $tasks=$all['num_results'];
        $banks = $this->Bank->GetBanks('', 0, 0);
        $banks_copy_res = $this->Bank->GetBanksS(1, '', 0, 0);
        $banks_is_adv = $this->Bank->GetBanksS('', 1, 0, 0);
        $insurances = $this->Insurance->GetInsurances('', 0, 0);
        $insurances_copy_res = $this->Insurance->GetInsurancesS(1, '', 0, 0);
        $insurances_is_adv = $this->Insurance->GetInsurancesS('', 1, 0, 0);

        $importers = $this->Importer->GetImporters('', 0, 0);
        $importers_copy_res = $this->Importer->GetImportersS(1, '', 0, 0);
        $importers_is_adv = $this->Importer->GetImportersS('', 1, 0, 0);

        $transports = $this->Transport->GetTransportations('', 0, 0);
        $transports_copy_res = $this->Transport->GetTransportsS(1, '', 0, 0);
        $transports_is_adv = $this->Transport->GetTransportsS('', 1, 0, 0);

        $this->data['companies_nbr'] = count($companies);
        $this->data['copy_res'] = count($copy_res);
        $this->data['is_adv'] = count($is_adv);
        $this->data['tasks'] = $tasks;
        $this->data['statements'] = $statements;
        $this->data['banks_nbr'] = count($banks);
        $this->data['banks_copy_res'] = count($banks_copy_res);
        $this->data['banks_is_adv'] = count($banks_is_adv);
        $this->data['insurances_nbr'] = count($insurances);
        $this->data['insurances_copy_res'] = count($insurances_copy_res);
        $this->data['insurances_is_adv'] = count($insurances_is_adv);

        $this->data['importers_nbr'] = count($importers);
        $this->data['importers_copy_res'] = count($importers_copy_res);
        $this->data['importers_is_adv'] = count($importers_is_adv);

        $this->data['transports_nbr'] = count($transports);
        $this->data['transports_copy_res'] = count($transports_copy_res);
        $this->data['transports_is_adv'] = count($transports_is_adv);

        $this->data['states_users'] = $states_users = $this->Administrator->GetStatesUsers(date('Y'));
        $total_visitors = 0;
        foreach($states_users as $states_user) {
            $total_visitors+=$states_user->Views;
        }

        $this->data['total_visitors'] = $total_visitors;
        $this->data['today_visitors'] = $today_visitors = $this->Administrator->GetDailyVisitors(date('Y-m-d'));
        $this->data['days_visitors'] = $days_visitors = $this->Administrator->GetVisitorsByDays(date('m'));
        $this->data['monthly_country_visitors'] = $monthly_country_visitors = $this->Administrator->GetVisitorsByCountries(date('Y-m-d'));
        $this->data['country_visitors'] = $country_visitors = $this->Administrator->GetVisitorsByCountries('');
        $total_monthly_visitors = 0;
        foreach($monthly_country_visitors as $monthly_v) {
            $total_monthly_visitors+=$monthly_v->Views;
        }
        $this->data['total_monthly_visitors'] = $total_monthly_visitors;

        $this->template->load('_template', 'dashboard', $this->data);
    }

}