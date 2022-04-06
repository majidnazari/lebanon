<?php

class Report extends CI_Model {
    
    function GetAdvAndCopyCompanies()
    {
        $this->db->select('tbl_company.*', FALSE);
        $this->db->select('COUNT(tbl_company_heading.id) as CNbr');
        $this->db->select('tbl_companies_guide_pages.guide_pages_ar, tbl_companies_guide_pages.guide_pages_en');
        $this->db->select('tbl_governorates.label_ar as governorate_ar,tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar, tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar, tbl_area.label_en as area_en');
        $this->db->select('tbl_company.name_ar as company_ar, tbl_company.name_en as company_en');
        $this->db->select('tbl_company.street_ar as street_ar, tbl_company.street_en as street_en');
        $this->db->select('tbl_company.owner_name,tbl_company.activity_ar,tbl_company.phone,tbl_company.fax,tbl_company.personal_notes,tbl_company.is_exporter,tbl_company.is_adv,tbl_company.copy_res');
        $this->db->select('tbl_sales_man.fullname as employer_ar,tbl_sales_man.fullname_en as employer_en');
        $this->db->select('t.fullname as sales_man_ar,t.fullname_en as sales_man_en');
        $this->db->select('tbl_company.delivery_by as delivery_by,tbl_company.delivery_date as delivery_date, tbl_company.receiver_name as receiver_name, tbl_company.personal_notes as personal_notes');
        $this->db->select('d.fullname as delivery_by_ar,d.fullname_en as delivery_by_en');
        $this->db->select('tbl_tasks.*',FALSE);

        $this->db->from('tbl_company');
        $this->db->join('tbl_tasks', 'tbl_tasks.company_id = tbl_company.id', 'left');
        $this->db->join('tbl_company_heading', 'tbl_company_heading.company_id = tbl_company.id', 'left');
        $this->db->join('tbl_companies_guide_pages', 'tbl_companies_guide_pages.company_id = tbl_company.id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_tasks.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_tasks.district_id', 'left');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_sales_man', 'tbl_sales_man.id = tbl_tasks.sales_man_id', 'left');
        $this->db->join('tbl_sales_man t', 't.id = tbl_company.sales_man_id', 'left');
        $this->db->join('tbl_sales_man d', 'd.id = tbl_company.delivery_by', 'left');
        

            $this->db->where('tbl_company.is_adv', 1);
            $this->db->or_where('tbl_company.copy_res', 1);
        
      
        $this->db->order_by('tbl_area.label_ar', 'ASC');
        $this->db->group_by('tbl_tasks.id');
        $this->db->group_by('tbl_company.id');
        $query = $this->db->get();
        return  $query->result();

    }
    function GetShowItemCompanies()
    { 
    //     $this->db->select('1tbl_company.*', FALSE);
    //     $this->db->select('COUNT(tbl_company_heading.id) as CNbr');
    //     $this->db->select('tbl_companies_guide_pages.guide_pages_ar, tbl_companies_guide_pages.guide_pages_en');
    //     $this->db->select('clients_status.start_date as show_item_start_date, clients_status.end_date as  show_item_end_date,clients_status.status as  show_item_status');
    //     $this->db->select('tbl_governorates.label_ar as governorate_ar,tbl_governorates.label_en as governorate_en');
    //     $this->db->select('tbl_districts.label_ar as district_ar, tbl_districts.label_en as district_en');
    //     $this->db->select('tbl_area.label_ar as area_ar, tbl_area.label_en as area_en');
    //     $this->db->select('tbl_company.name_ar as company_ar, tbl_company.name_en as company_en');
    //     $this->db->select('tbl_company.street_ar as street_ar, tbl_company.street_en as street_en');
    //     $this->db->select('tbl_company.owner_name,tbl_company.activity_ar,tbl_company.phone,tbl_company.fax,tbl_company.personal_notes,tbl_company.is_exporter,tbl_company.is_adv,tbl_company.copy_res');
    //     $this->db->select('tbl_sales_man.fullname as employer_ar,tbl_sales_man.fullname_en as employer_en');
    //     $this->db->select('t.fullname as sales_man_ar,t.fullname_en as sales_man_en');
    //      $this->db->select('tbl_company.delivery_by as delivery_by,tbl_company.delivery_date as delivery_date, tbl_company.receiver_name as receiver_name, tbl_company.personal_notes as personal_notes');
    //      $this->db->select('d.fullname as delivery_by_ar,d.fullname_en as delivery_by_en');
    //     // $this->db->select('tbl_tasks.*',FALSE);

    //     $this->db->from('tbl_company');
    //     $this->db->join('tbl_tasks', 'tbl_tasks.company_id = tbl_company.id', 'left');
    //     $this->db->join('tbl_company_heading', 'tbl_company_heading.company_id = tbl_company.id', 'left');
    //     $this->db->join('tbl_companies_guide_pages', 'tbl_companies_guide_pages.company_id = tbl_company.id', 'left');
    //     $this->db->join('clients_status', 'clients_status.client_id = tbl_company.id', 'left');
    //     $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_tasks.governorate_id', 'left');
    //     $this->db->join('tbl_districts', 'tbl_districts.id = tbl_tasks.district_id', 'left');
    //     $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
    //     $this->db->join('tbl_sales_man', 'tbl_sales_man.id = tbl_tasks.sales_man_id', 'left');
    //     $this->db->join('tbl_sales_man t', 't.id = tbl_company.sales_man_id', 'left');
    //     $this->db->join('tbl_sales_man d', 'd.id = tbl_company.delivery_by', 'left');
        

    //       //  $this->db->where('tbl_company.is_adv', 1);
    //         $this->db->where('tbl_company.copy_res', 1);
        
      
    //    // $this->db->order_by('tbl_area.label_ar', 'ASC');
    //     $this->db->group_by('tbl_tasks.id');
    //     $this->db->group_by('tbl_company.id');
    //     //$this->db->order_by('clients_status.id','DESC');
    //     $query = $this->db->get();
    //     return  $query->result();
       
    //  
    $getMaxClients="SELECT MAX( `id`) as `maxed_id`  FROM `clients_status`
    group by `client_id`"; 
    $max_ids=$this->db->query($getMaxClients); 
    $max_ids=$max_ids->result(); 
    $tmparray=[];
    foreach ($max_ids as $max_id)
    {
        $tmparray[]=$max_id->maxed_id;
        //echo ( $max_id->maxed_id);
       // echo "<br>";
    }
    $arr=implode(',',$tmparray);
    //echo($arr);
   // die();
   // var_dump($max_ids); die();
        $sql="SELECT tbl_company.*, COUNT(tbl_company_heading.id) as CNbr
        , `tbl_companies_guide_pages`.`guide_pages_ar`, `tbl_companies_guide_pages`.`guide_pages_en`,
         `client`.`start_date` as show_item_start_date, `client`.`end_date` as show_item_end_date,
          `client`.`status` as show_item_status, `tbl_governorates`.`label_ar` as governorate_ar,
           `tbl_governorates`.`label_en` as governorate_en, `tbl_districts`.`label_ar` as district_ar,
            `tbl_districts`.`label_en` as district_en, `tbl_area`.`label_ar` as area_ar,
             `tbl_area`.`label_en` as area_en, `tbl_company`.`name_ar` as company_ar,
              `tbl_company`.`name_en` as company_en, `tbl_company`.`street_ar` as street_ar,
               `tbl_company`.`street_en` as street_en, `tbl_company`.`owner_name`, `tbl_company`.`activity_ar`,
                `tbl_company`.`phone`, `tbl_company`.`fax`, `tbl_company`.`personal_notes`, `tbl_company`.`is_exporter`,
                 `tbl_company`.`is_adv`, `tbl_company`.`copy_res`,
                 -- `tbl_sales_man`.`fullname` as employer_ar, `tbl_sales_man`.`fullname_en` as employer_en,
                  `t`.`fullname` as sales_man_ar,`t`.`fullname_en` as sales_man_en,
                    `tbl_company`.`delivery_by` as delivery_by,
                    `tbl_company`.`delivery_date` as delivery_date, `tbl_company`.`receiver_name` as receiver_name, 
                    `tbl_company`.`personal_notes` as personal_notes,  
                    `d`.`fullname` as delivery_by_ar,`d`.`fullname_en` as delivery_by_en 
        FROM (`tbl_company`) 
        LEFT JOIN `tbl_tasks` ON `tbl_tasks`.`company_id` = `tbl_company`.`id`
        LEFT JOIN `tbl_company_heading` ON `tbl_company_heading`.`company_id` = `tbl_company`.`id`
        LEFT JOIN `tbl_companies_guide_pages` ON `tbl_companies_guide_pages`.`company_id` = `tbl_company`.`id`
        LEFT JOIN `clients_status` as `client` ON  `tbl_company`.`id` = `client`.`client_id`
       
        LEFT JOIN `tbl_governorates` ON `tbl_governorates`.`id` = `tbl_tasks`.`governorate_id`
        LEFT JOIN `tbl_districts` ON `tbl_districts`.`id` = `tbl_tasks`.`district_id` 
        LEFT JOIN `tbl_area` ON `tbl_area`.`id` = `tbl_company`.`area_id` 
        -- LEFT JOIN `tbl_sales_man` ON `tbl_sales_man`.`id` = `tbl_tasks`.`sales_man_id`
        LEFT JOIN `tbl_sales_man` t ON `t`.`id` = `tbl_company`.`sales_man_id` 
        LEFT JOIN `tbl_sales_man` d ON `d`.`id` = `tbl_company`.`delivery_by` 
        WHERE `tbl_company`.`copy_res` = 1 and  `client`.`id` in ($arr)
        
        -- GROUP BY `tbl_tasks`.`id`, `tbl_company`.`id`
        GROUP BY  `tbl_company`.`id`
        ORDER BY   `tbl_company`.`id` asc" ;
        $query = $this->db->query($sql);
       // echo $query; die();
        return  $query->result();

    }
    function GetCompaniesAdvertiser() {
        $this->db->select('tbl_company.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_company');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->where('tbl_company.is_adv', 1);
        $this->db->order_by('tbl_company.name_en', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
function GetBanksAdvertiser() {
        $this->db->select('tbl_bank.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_bank');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_bank.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_bank.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_bank.district_id', 'left');
        $this->db->where('tbl_bank.is_adv', 1);
        $this->db->order_by('tbl_bank.name_en', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
function GetInsurancesAdvertiser() {
        $this->db->select('tbl_insurances.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_insurances');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_insurances.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_insurances.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_insurances.district_id', 'left');
        $this->db->where('tbl_insurances.is_adv', 1);
        $this->db->order_by('tbl_insurances.name_en', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }    
function GetImportersAdvertiser() {
        $this->db->select('tbl_importers.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_importers');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_importers.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_importers.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_importers.district_id', 'left');
        $this->db->where('tbl_importers.is_adv', 1);
        $this->db->order_by('tbl_importers.name_en', 'ASC');
        $query = $this->db->get();
        return $query->result();
    } 
function GetTransportAdvertiser() {
        $this->db->select('tbl_transport.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_transport');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_transport.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_transport.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_transport.district_id', 'left');
        $this->db->where('tbl_transport.is_adv', 1);
        $this->db->order_by('tbl_transport.name_en', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }     


function GetCompaniesWithourHSCode()
    {

        $this->db->select('tbl_company.id, tbl_company.name_ar, tbl_company.name_en , COUNT(tbl_company_heading.id) as hscode_count');
        $this->db->from('tbl_company');
        $this->db->join('tbl_company_heading', 'tbl_company_heading.company_id = tbl_company.id', 'left');
        $this->db->where('tbl_company.is_closed', 0);
        $this->db->where('tbl_company.error_address', 0);
        $this->db->group_by('tbl_company.id');
        $this->db->having('hscode_count <', 1);
        $this->db->order_by('tbl_company.name_ar', 'ASC');
        //$this->db->limit(5);
        $query = $this->db->get();
        return $query->result();
    }
    function GetCompaniesHSCode($nbr='',$op='',$row=0,$limit=0)
    {

        $this->db->select('SQL_CALC_FOUND_ROWS tbl_company.id, tbl_company.name_ar, tbl_company.name_en , COUNT(tbl_company_heading.id) as hscode_count',FALSE);
        $this->db->from('tbl_company');
        $this->db->join('tbl_company_heading', 'tbl_company_heading.company_id = tbl_company.id', 'left');
        $this->db->where('tbl_company.is_closed', 0);
        $this->db->where('tbl_company.error_address', 0);
        $this->db->where('tbl_company.is_adv', 0);
        $this->db->group_by('tbl_company.id');
        if($nbr!=''){
            if($op=='greater')
        $this->db->having('hscode_count >', $nbr);
        elseif($op=='less')
        $this->db->having('hscode_count <', $nbr);
        else
        $this->db->having('hscode_count', $nbr);
        }
        $this->db->order_by('hscode_count', 'ASC');
        if($limit != 0)
        $this->db->limit($limit, $row);
        $query = $this->db->get();
        $query1 = $this->db->query('SELECT FOUND_ROWS() AS `total_rows`');
        $objCount = $query1->result_array();
        $totalres = $objCount[0]['total_rows'];
        $data_array = array('num_results' =>$totalres , 'results' => $query->result() );
        return $data_array;
    }
     function GetCompaniesStatus($status='',$closed='',$wrong_address='',$row=0,$limit=0)
    {

        $this->db->select('SQL_CALC_FOUND_ROWS tbl_company.*',FALSE);
         $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_company');
         $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        if($closed!=''){
             $this->db->where('tbl_company.is_closed', $closed);
        }
        if($wrong_address!=''){
        $this->db->where('tbl_company.error_address', $wrong_address);
        }
         if($status!=''){
        $this->db->where('tbl_company.show_online', $status);
         }
        
      
        $this->db->order_by('tbl_company.name_ar', 'ASC');
        if($limit != 0)
        $this->db->limit($limit, $row);
        $query = $this->db->get();
        $query1 = $this->db->query('SELECT FOUND_ROWS() AS `total_rows`');
        $objCount = $query1->result_array();
        $totalres = $objCount[0]['total_rows'];
        $data_array = array('num_results' =>$totalres , 'results' => $query->result() );
        return $data_array;
    }
    
    
function GetMinistryReports($row,$limit)
{
    $this->db->select('SQL_CALC_FOUND_ROWS ministry_reports.*',FALSE);
    $this->db->select('users.username as username');
    $this->db->from('ministry_reports');
    $this->db->join('users', 'users.id = ministry_reports.user_id', 'left');
    $this->db->order_by('ministry_reports.id', 'DESC');
    if($limit != 0)
        $this->db->limit($limit, $row);
    $query = $this->db->get();
    $query1 = $this->db->query('SELECT FOUND_ROWS() AS `total_rows`');
    $objCount = $query1->result_array();
    $totalres = $objCount[0]['total_rows'];
    $data_array = array('num_results' =>$totalres , 'results' => $query->result() );
    return $data_array;

}
//$this->db->where('tbl_company.update_info', 1);

    function GetCompanyByMarkets($market, $type = 'country', $language = 'ar') {
        $this->db->select('tbl_company.*');
        //$this->db->select('tbl_company_heading.code as course_code');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_company');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->join('tbl_markets_company', 'tbl_markets_company.company_id = tbl_company.id', 'inner');
        $this->db->where('tbl_company.is_closed !=', 1);
        $this->db->where('tbl_markets_company.market_id', $market);
        $this->db->where('tbl_markets_company.item_type', $type);
        if($language == 'en') {
            $this->db->order_by('tbl_company.name_en', 'ASC');
        }
        else {
            $this->db->order_by('tbl_company.name_ar', 'ASC');
        }
        $query = $this->db->get();
        return $query->result();
    }

    function SearchBanks($status = '', $gov, $district, $area) {
        $this->db->select('tbl_bank.*');
        $this->db->from('tbl_bank');
        if($gov != 0)
            $this->db->where('tbl_bank.governorate_id', $gov);
        if($district != 0)
            $this->db->where('tbl_bank.district_id', $district);
        if($area != 0)
            $this->db->where('tbl_bank.area_id', $area);
        if($status != 'all')
            $this->db->where('tbl_bank.status', $status);
        $this->db->order_by('tbl_bank.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function SearchBanksByName($name, $lang) {
        $this->db->select('tbl_bank.*');
        $this->db->from('tbl_bank');
        $this->db->like('tbl_bank.name_en', $name);
        $this->db->or_like('tbl_bank.name_ar', $name);
        if($lang == 'en')
            $this->db->order_by('tbl_bank.name_en', 'ASC');
        else
            $this->db->order_by('tbl_bank.name_ar', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function SearchInsurancesByName($name, $lang) {
        $this->db->select('tbl_insurances.*');
        $this->db->from('tbl_insurances');
        $this->db->like('tbl_insurances.name_en', $name);
        $this->db->or_like('tbl_insurances.name_ar', $name);
        if($lang == 'en')
            $this->db->order_by('tbl_insurances.name_en', 'ASC');
        else
            $this->db->order_by('tbl_insurances.name_ar', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetIndexProductions($language = '') {
        $this->db->select('tbl_heading.*');
        //$this->db->select('tbl_company_heading.code as course_code');
        $this->db->from('tbl_heading');
        $this->db->join('tbl_company_heading', 'tbl_company_heading.heading_id = tbl_heading.id', 'inner');
        $this->db->where('tbl_heading.description_ar !=', '');
        $this->db->where('tbl_heading.description_en !=', '');
        $this->db->group_by('tbl_heading.id');
        //$this->db->group_by('tbl_heading.hs_code_print');
        if($language == 'en') {
            $this->db->order_by('tbl_heading.description_en', 'ASC');
        }
        else {
            $this->db->order_by('tbl_heading.description_ar', 'ASC');
        }
        $query = $this->db->get();
        return $query->result();
    }

    function GetCompanyByBankId($bankID, $language = '') {
        $this->db->select('tbl_company.*');
        //$this->db->select('tbl_company_heading.code as course_code');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_company');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->join('tbl_banks_company', 'tbl_banks_company.company_id = tbl_company.id', 'inner');
        $this->db->where('tbl_banks_company.bank_id', $bankID);
        //$this->db->group_by('tbl_heading.hs_code_print');
        if($language == 'en') {
            $this->db->order_by('tbl_company.name_en', 'ASC');
        }
        else {
            $this->db->order_by('tbl_company.name_ar', 'ASC');
        }
        $query = $this->db->get();
        return $query->result();
    }

    function GetCompanyByInsuranceId($InsuranceID, $language = '') {
        $this->db->select('tbl_company.*');
        //$this->db->select('tbl_company_heading.code as course_code');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_company');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->join('tbl_insurances_company', 'tbl_insurances_company.company_id = tbl_company.id', 'inner');
        $this->db->where('tbl_insurances_company.insurance_id', $InsuranceID);
        //$this->db->group_by('tbl_heading.hs_code_print');
        if($language == 'en') {
            $this->db->order_by('tbl_company.name_en', 'ASC');
        }
        else {
            $this->db->order_by('tbl_company.name_ar', 'ASC');
        }
        $query = $this->db->get();
        return $query->result();
    }

    function GetCompaniesSubHeading($heading, $language = '') {
        $this->db->select('tbl_company.*');
        //$this->db->select('tbl_company_heading.code as course_code');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_company');
        $this->db->join('tbl_company_heading', 'tbl_company_heading.company_id = tbl_company.id', 'inner');
        $this->db->join('tbl_heading', 'tbl_heading.id = tbl_company_heading.heading_id', 'inner');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->where('tbl_company.is_closed !=', 1);
        $this->db->where('tbl_heading.description_ar !=', '');
        $this->db->where('tbl_heading.description_en !=', '');
        $this->db->where('tbl_company_heading.heading_id', $heading);
        //$this->db->group_by('tbl_heading.hs_code_print');
        if($language == 'en') {
            $this->db->order_by('tbl_company.name_en', 'ASC');
        }
        else {
            $this->db->order_by('tbl_company.name_ar', 'ASC');
        }
        $query = $this->db->get();
        return $query->result();
    }

    function GetBankBranchesByArea($area, $language = '') {
         $this->db->select('tbl_bank_branch.*');
        $this->db->select('tbl_bank.name_ar as bank_ar');
        $this->db->select('tbl_bank.name_en as bank_en');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_bank_branch');
        $this->db->join('tbl_bank', 'tbl_bank.id = tbl_bank_branch.bank_id', 'inner');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_bank_branch.area_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_area.district_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_districts.governorate_id', 'left');
        $this->db->where('tbl_bank_branch.area_id', $area);

        if($language == 'en') {
            //$this->db->order_by('governorate_en', 'ASC');
            $this->db->order_by('district_en', 'ASC');
            $this->db->order_by('area_en', 'ASC');
            $this->db->order_by('bank_en', 'ASC');
        }
        else {
            //$this->db->order_by('governorate_ar', 'ASC');
            $this->db->order_by('district_ar', 'ASC');
            $this->db->order_by('area_ar', 'ASC');
            $this->db->order_by('bank_ar', 'ASC');
        }
        $query = $this->db->get();
        return $query->result();
        
      
    }
    function GetCompaniesByArea($area, $language = '') {
        $this->db->select('tbl_company.*');
        //$this->db->select('tbl_company_heading.code as course_code');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_company');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->where('tbl_company.area_id', $area);
        $this->db->where('tbl_company.is_closed', 0);
        $this->db->where('tbl_company.error_address', 0);
        $this->db->where('tbl_company.show_online', 1);
        //$this->db->where('tbl_company.is_closed !=', 1);
        //$this->db->group_by('tbl_heading.hs_code_print');
        if($language == 'en') {
            $this->db->order_by('tbl_company.name_en', 'ASC');
        }
        else {
            $this->db->order_by('tbl_company.name_ar', 'ASC');
        }
        $query = $this->db->get();
        return $query->result();
    }

    function GetCompanyByGov($gov, $language = '') {
        $this->db->select('tbl_company.governorate_id, tbl_company.sector_id as sectorID, COUNT(tbl_company.sector_id) as company_nbr');
        $this->db->select('tbl_sectors.label_ar as sector_ar, tbl_sectors.label_en as sector_en');
        $this->db->select('tbl_governorates.label_ar as governorate_ar, tbl_governorates.label_en as governorate_en');
        //	$this->db->select('tbl_governorates.label_en as governorate_en');
        //	$this->db->select('tbl_districts.label_ar as district_ar');
        //	$this->db->select('tbl_districts.label_en as district_en');
        //	$this->db->select('tbl_area.label_ar as area_ar');
        //	$this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_company');
        $this->db->join('tbl_sectors', 'tbl_sectors.id = tbl_company.sector_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->where('tbl_company.is_closed !=', 1);
        $this->db->where('tbl_company.error_address', 0);
        if($gov != 0)
            $this->db->where('tbl_company.governorate_id', $gov);
        $this->db->group_by('tbl_company.sector_id');
        $this->db->group_by('tbl_company.governorate_id');
        if($language == 'en') {
            $this->db->order_by('tbl_company.name_en', 'ASC');
        }
        else {
            $this->db->order_by('tbl_company.name_ar', 'ASC');
        }
        $query = $this->db->get();
        return $query->result();
    }

    function GetCompanyByGovById($gov, $language = '') {
        $this->db->select('tbl_company.governorate_id,tbl_company.district_id as districtID, tbl_company.sector_id as sectorID, COUNT(tbl_company.sector_id) as company_nbr');
        $this->db->select('tbl_sectors.label_ar as sector_ar, tbl_sectors.label_en as sector_en');
        $this->db->select('tbl_governorates.label_ar as governorate_ar, tbl_governorates.label_en as governorate_en');
        //	$this->db->select('tbl_governorates.label_en as governorate_en');
        //	$this->db->select('tbl_districts.label_ar as district_ar');
        //	$this->db->select('tbl_districts.label_en as district_en');
        //	$this->db->select('tbl_area.label_ar as area_ar');
        //	$this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_company');
        $this->db->join('tbl_sectors', 'tbl_sectors.id = tbl_company.sector_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->where('tbl_company.is_closed !=', 1);
        $this->db->where('tbl_company.error_address', 0);
        if($gov != 0)
            $this->db->where('tbl_company.governorate_id', $gov);
        $this->db->group_by('tbl_company.sector_id');
        $this->db->group_by('tbl_company.district_id');
        if($language == 'en') {
            $this->db->order_by('tbl_company.name_en', 'ASC');
        }
        else {
            $this->db->order_by('tbl_company.name_ar', 'ASC');
        }
        $query = $this->db->get();
        return $query->result();
    }

    function GetCompanyByHSCode($heading, $language = '') {
        $this->db->select('tbl_company.*');
        //$this->db->select('tbl_company_heading.code as course_code');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_company');
        $this->db->join('tbl_company_heading', 'tbl_company_heading.company_id = tbl_company.id', 'inner');
        $this->db->join('tbl_heading', 'tbl_heading.id = tbl_company_heading.heading_id', 'inner');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->where('tbl_heading.description_ar !=', '');
        $this->db->where('tbl_heading.description_en !=', '');
        $this->db->where('tbl_heading.hs_code_print', $heading);
        $this->db->where('tbl_company.is_closed !=', 1);
        //$this->db->group_by('tbl_heading.hs_code_print');
        if($language == 'en') {
            $this->db->order_by('tbl_heading.label_en', 'ASC');
        }
        else {
            $this->db->order_by('tbl_heading.label_ar', 'ASC');
        }
        $query = $this->db->get();
        return $query->result();
    }

    function GetHeadingByTitle($heading, $language = '') {
        $this->db->select('tbl_heading.*');
        $this->db->select('count(tbl_heading.hs_code_print) as number');
        //	$this->db->select('tbl_governorates.label_ar as governorate_ar');
        //	$this->db->select('tbl_governorates.label_en as governorate_en');
        //	$this->db->select('tbl_districts.label_ar as district_ar');
        //	$this->db->select('tbl_districts.label_en as district_en');
        //	$this->db->select('tbl_area.label_ar as area_ar');
        //	$this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_heading');
        $this->db->join('tbl_company_heading', 'tbl_company_heading.heading_id = tbl_heading.id', 'inner');
        $this->db->join('tbl_company', 'tbl_company.id = tbl_company_heading.company_id', 'inner');
//		$this->db->join('tbl_heading', 'tbl_heading.id = tbl_company_heading.heading_id', 'inner');
//		$this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
//		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
//		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        //$this->db->where('tbl_heading.description_ar !=','');
        //$this->db->where('tbl_heading.description_en !=','');
        //if($activity!=''){
        //$where2 = "( tbl_company.activity_ar LIKE '%$activity%' OR tbl_company.activity_ar LIKE '%$activity%')";
        //	$this->db->where($where2);
        //	}
        //$this->db->where('tbl_heading.description_ar',$heading);
        $this->db->group_by('tbl_heading.hs_code_print');
        $this->db->where('tbl_company.is_closed !=', 1);
        if($language == 'en') {
            $this->db->like('tbl_heading.description_en', $heading);
            $this->db->order_by('tbl_heading.label_en', 'ASC');
        }
        else {
            $this->db->like('tbl_heading.description_ar', $heading);
            $this->db->order_by('tbl_heading.label_ar', 'ASC');
        }
        $query = $this->db->get();
        return $query->result();
    }
    function SearchHeadingByTitle($heading, $language = '') {
        $this->db->select('tbl_heading.*');
        //$this->db->select('tbl_company_heading.code as course_code');
        //	$this->db->select('tbl_governorates.label_ar as governorate_ar');
        //	$this->db->select('tbl_governorates.label_en as governorate_en');
        //	$this->db->select('tbl_districts.label_ar as district_ar');
        //	$this->db->select('tbl_districts.label_en as district_en');
        //	$this->db->select('tbl_area.label_ar as area_ar');
        //	$this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_heading');
        //	$this->db->join('tbl_company_heading', 'tbl_company_heading.company_id = tbl_company.id', 'inner');
//		$this->db->join('tbl_heading', 'tbl_heading.id = tbl_company_heading.heading_id', 'inner');
//		$this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
//		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
//		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        //$this->db->where('tbl_heading.description_ar !=','');
        //$this->db->where('tbl_heading.description_en !=','');
        //if($activity!=''){
        //$where2 = "( tbl_company.activity_ar LIKE '%$activity%' OR tbl_company.activity_ar LIKE '%$activity%')";
        //	$this->db->where($where2);
        //	}
        //$this->db->where('tbl_heading.description_ar',$heading);
        //$this->db->group_by('tbl_heading.hs_code_print');
        $this->db->where('tbl_company.is_closed !=', 1);
        if($language == 'en') {
            $this->db->like('tbl_heading.description_en', $heading);
            $this->db->order_by('tbl_heading.label_en', 'ASC');
        }
        else {
            $this->db->like('tbl_heading.description_ar', $heading);
            $this->db->order_by('tbl_heading.label_ar', 'ASC');
        }
        $query = $this->db->get();
        return $query->result();
    }

    function GetBanks($lang = 'ar') { 
        $this->db->select('tbl_bank.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_bank');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_bank.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_bank.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_bank.district_id', 'left');

        if($lang == 'en') {
            $this->db->order_by('tbl_bank.name_en', 'ASC');
            //$this->db->order_by('governorate_en', 'ASC');
            $this->db->order_by('district_en', 'ASC');
            $this->db->order_by('area_en', 'ASC');
            
        }
        else {
            //$this->db->order_by('governorate_ar', 'ASC');
            $this->db->order_by('tbl_bank.name_ar', 'ASC');
            $this->db->order_by('district_ar', 'ASC');
            $this->db->order_by('area_ar', 'ASC');
            
        }
        $query = $this->db->get();
        return $query->result();
    }

    function GetTransportation($lang = 'ar') {
        $this->db->select('tbl_transport.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_transport');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_transport.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_transport.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_transport.district_id', 'left');

        if($lang == 'en') {
            //$this->db->order_by('governorate_en', 'ASC');
            $this->db->order_by('tbl_transport.name_en', 'ASC');
            $this->db->order_by('district_en', 'ASC');
            $this->db->order_by('area_en', 'ASC');
            
        }
        else {
            //$this->db->order_by('governorate_ar', 'ASC');
            $this->db->order_by('tbl_transport.name_ar', 'ASC');
            $this->db->order_by('district_ar', 'ASC');
            $this->db->order_by('area_ar', 'ASC');
            
        }
        $query = $this->db->get();
        return $query->result();
    }

    function GetInsurance($lang = 'ar') {
        $this->db->select('tbl_insurances.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_insurances');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_insurances.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_insurances.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_insurances.district_id', 'left');

        if($lang == 'en') {
            //$this->db->order_by('governorate_en', 'ASC');
            $this->db->order_by('tbl_insurances.name_en', 'ASC');
            $this->db->order_by('district_en', 'ASC');
            $this->db->order_by('area_en', 'ASC');
            
        }
        else {
            //$this->db->order_by('governorate_ar', 'ASC');
            $this->db->order_by('tbl_insurances.name_ar', 'ASC');
            $this->db->order_by('district_ar', 'ASC');
            $this->db->order_by('area_ar', 'ASC');
            
        }
        $query = $this->db->get();
        return $query->result();
    }

    function GetBankBranches($lang = 'ar') {
        $this->db->select('tbl_bank_branch.*');
        $this->db->select('tbl_bank.name_ar as bank_ar');
        $this->db->select('tbl_bank.name_en as bank_en');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_bank_branch');
        $this->db->join('tbl_bank', 'tbl_bank.id = tbl_bank_branch.bank_id', 'inner');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_bank_branch.area_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_area.district_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_districts.governorate_id', 'left');


        if($lang == 'en') {
            //$this->db->order_by('governorate_en', 'ASC');
            $this->db->order_by('district_en', 'ASC');
            $this->db->order_by('area_en', 'ASC');
            $this->db->order_by('bank_en', 'ASC');
        }
        else {
            //$this->db->order_by('governorate_ar', 'ASC');
            $this->db->order_by('district_ar', 'ASC');
            $this->db->order_by('area_ar', 'ASC');
            $this->db->order_by('bank_ar', 'ASC');
        }
        $query = $this->db->get();
        return $query->result();
    }
    function GetUpdatedCompanies() {
        $this->db->select('tbl_company.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->select('tbl_sectors.label_ar as sector_ar');
        $this->db->select('tbl_sectors.label_en as sector_en');
        $this->db->select('tbl_company_type.label_ar as type_ar,tbl_company_type.label_en as type_en');
        $this->db->from('tbl_company');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->join('tbl_sectors', 'tbl_sectors.id = tbl_company.sector_id', 'left');
        $this->db->join('tbl_company_type', 'tbl_company_type.id = tbl_company.company_type_id', 'left');
        $this->db->where('tbl_company.update_info', 1);
        $this->db->order_by('governorate_ar', 'ASC');
        $this->db->order_by('district_ar', 'ASC');
        $this->db->order_by('area_ar', 'ASC');
        $this->db->order_by('tbl_company.name_ar', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }
    function GetFullCompanies() 
    {

        //         SELECT a.*        
        //           ,b.*
                
        //       FROM tbl_company AS a
        //  LEFT JOIN clients_status AS b 
        //         ON b.client_id=a.id
        //        AND b.id = (SELECT MAX(id) 
        //                        FROM clients_status T 
        //                       WHERE T.client_id = a.id 
        //                     )
        //                     where a.id=11522;

                // $getMaxClients="SELECT MAX( `id`) as `maxed_id`  FROM `clients_status` where sales_man_id= $sales_man 
                // group by `client_id`"; 
                // $max_ids=$this->db->query($getMaxClients); 
                // $max_ids=$max_ids->result(); 
                // $tmparray=[];
                // foreach ($max_ids as $max_id)
                // {
                //     $tmparray[]=$max_id->maxed_id; 
                //     //echo ( $max_id->maxed_id);
                //    // echo "<br>";
                // }
                // $arr=implode(',',$tmparray);

        $this->db->select('tbl_company.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->select('tbl_sectors.label_ar as sector_ar');
        $this->db->select('tbl_sectors.label_en as sector_en');
        $this->db->select('tbl_company_type.label_ar as type_ar,tbl_company_type.label_en as type_en');
        $this->db->from('tbl_company As comp');
    
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->join('tbl_sectors', 'tbl_sectors.id = tbl_company.sector_id', 'left');
        $this->db->join('tbl_company_type', 'tbl_company_type.id = tbl_company.company_type_id', 'left');
        $this->db->order_by('governorate_ar', 'ASC');
        $this->db->order_by('district_ar', 'ASC');
        $this->db->order_by('area_ar', 'ASC');
        $this->db->order_by('tbl_company.name_ar', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

    function GetfullCompaniesNew()
    {
        $sql=" SELECT `tbl_company`.*,
                `tbl_governorates`.`label_ar` as governorate_ar, `tbl_governorates`.`label_en` as governorate_en, `tbl_districts`.`label_ar` as district_ar, `tbl_districts`.`label_en` as district_en, `tbl_area`.`label_ar` as area_ar, `tbl_area`.`label_en` as area_en, `tbl_sectors`.`label_ar` as sector_ar, `tbl_sectors`.`label_en` as sector_en, `tbl_company_type`.`label_ar` as type_ar, `tbl_company_type`.`label_en` as type_en ,
                `clients_status`.`id` as  `clients_status_id` ,`clients_status`.`start_date` as `clients_status_start_date`,
                `clients_status`.`end_date` as `clients_status_end_date`, `clients_status`.`status` as `clients_status_status`,
                `clients_status`.`client_id` as `clients_status_client_id`,
                `tbl_sales_man`.`fullname_en` AS `salesman_fullname_en`,
                `tbl_sales_man`.`fullname` AS `salesman_fullname_ar`
                FROM `tbl_company` 
                left join `clients_status`   ON `clients_status`.client_id=`tbl_company`.`id` and `clients_status`.`id`=(SELECT MAX(`id`) FROM`clients_status`  T    WHERE T.client_id = `tbl_company`.`id` )
                left join `tbl_sales_man` ON `tbl_sales_man`.`id`= `tbl_company`.`sales_man_id`
                LEFT JOIN `tbl_area` ON `tbl_area`.`id` = `tbl_company`.`area_id` 
                LEFT JOIN `tbl_governorates` ON `tbl_governorates`.`id` = `tbl_company`.`governorate_id`
                LEFT JOIN `tbl_districts` ON `tbl_districts`.`id` = `tbl_company`.`district_id` 
                LEFT JOIN `tbl_sectors` ON `tbl_sectors`.`id` = `tbl_company`.`sector_id` 
                LEFT JOIN `tbl_company_type` ON `tbl_company_type`.`id` = `tbl_company`.`company_type_id` 
                
                ORDER BY `governorate_ar` ASC, `district_ar` ASC, `area_ar` ASC, `tbl_company`.`name_ar` ASC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function GetCompany($lang = 'ar') {
        $this->db->select('tbl_company.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_company');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->where('tbl_company.is_closed !=', 1);
        if($lang == 'en') {
            //$this->db->order_by('governorate_en', 'ASC');
            $this->db->order_by('district_en', 'ASC');
            $this->db->order_by('area_en', 'ASC');
            $this->db->order_by('tbl_company.name_en', 'ASC');
        }
        else {
            //$this->db->order_by('governorate_ar', 'ASC');
            $this->db->order_by('district_ar', 'ASC');
            $this->db->order_by('area_ar', 'ASC');
            $this->db->order_by('tbl_company.name_ar', 'ASC');
        }
        $query = $this->db->get();
        return $query->result();
    }

    function SearchCompany($sector, $section, $chapter, $lang = 'ar') {
        $this->db->select('tbl_company.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->select('tbl_heading.description_en as heading_en');
        $this->db->select('tbl_heading.description_ar as heading_ar');

        $this->db->select('tbl_sectors.label_en as sector_en');
        $this->db->select('tbl_sectors.label_ar as sector_ar');

        $this->db->select('tbl_section.label_en as section_en');
        $this->db->select('tbl_section.label_ar as section_ar');

        $this->db->select('tbl_chapter.label_en as chapter_en');
        $this->db->select('tbl_chapter.label_ar as chapter_ar');

        $this->db->select('tbl_heading.hs_code_print as hs_code');
        $this->db->from('tbl_company');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->join('tbl_company_heading', 'tbl_company_heading.company_id = tbl_company.id', 'inner');
        $this->db->join('tbl_heading', 'tbl_heading.id = tbl_company_heading.heading_id', 'inner');
        $this->db->join('tbl_sectors', 'tbl_sectors.id = tbl_company.sector_id', 'inner');
        $this->db->join('tbl_chapter', 'tbl_chapter.id = tbl_heading.chapter_id', 'inner');
        $this->db->join('tbl_section', 'tbl_section.id = tbl_chapter.section_id', 'inner');
        $this->db->where('tbl_company.is_closed !=', 1);
        if($chapter != 0) {
            $this->db->where('tbl_heading.chapter_id', $chapter);
        }
        if($sector != 0) {
            $this->db->where('tbl_section.sector_id', $sector);
        }
        if($section != 0) {
            $this->db->where('tbl_chapter.section_id', $section);
        }
        //	$this->db->where('tbl_heading.chapter_id',$chapter);
        $this->db->order_by('tbl_sectors.rank', 'ASC');
        if($lang == 'en') {

            $this->db->order_by('section_en', 'ASC');
            $this->db->order_by('chapter_en', 'ASC');
            $this->db->order_by('heading_en', 'ASC');

            $this->db->order_by('governorate_en', 'ASC');
            $this->db->order_by('district_en', 'ASC');
            $this->db->order_by('area_en', 'ASC');
            $this->db->order_by('tbl_company.name_en', 'ASC');
        }
        else {

            $this->db->order_by('section_ar', 'ASC');
            $this->db->order_by('chapter_ar', 'ASC');
            $this->db->order_by('heading_ar', 'ASC');

            $this->db->order_by('governorate_ar', 'ASC');
            $this->db->order_by('district_ar', 'ASC');
            $this->db->order_by('area_ar', 'ASC');
            $this->db->order_by('tbl_company.name_ar', 'ASC');
        }
        $query = $this->db->get();
        return $query->result();
    }

    function GetCompanyHeading($seciton, $chapter, $lang = 'ar') {
        $this->db->select('tbl_heading_company.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_company');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->where('tbl_company.is_closed !=', 1);
        if($lang == 'en') {
            //$this->db->order_by('governorate_en', 'ASC');
            $this->db->order_by('district_en', 'ASC');
            $this->db->order_by('area_en', 'ASC');
            $this->db->order_by('tbl_company.name_en', 'ASC');
        }
        else {
            //$this->db->order_by('governorate_ar', 'ASC');
            $this->db->order_by('district_ar', 'ASC');
            $this->db->order_by('area_ar', 'ASC');
            $this->db->order_by('tbl_company.name_ar', 'ASC');
        }
        $query = $this->db->get();
        return $query->result();
    }

    function GetImporters($lang = 'ar') {

        $this->db->select('tbl_importers.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar');
        $this->db->select('tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar');
        $this->db->select('tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar');
        $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_importers');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_importers.area_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_importers.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_importers.district_id', 'left');
        if($lang == 'en') {
            //$this->db->order_by('governorate_en', 'ASC');
            $this->db->order_by('tbl_importers.name_en', 'ASC');
            $this->db->order_by('district_en', 'ASC');
            $this->db->order_by('area_en', 'ASC');
            
        }
        else {
            //$this->db->order_by('governorate_ar', 'ASC');
            $this->db->order_by('tbl_importers.name_ar', 'ASC');
            $this->db->order_by('district_ar', 'ASC');
            $this->db->order_by('area_ar', 'ASC');
            
        }
        $query = $this->db->get();
        return $query->result();
    }
     function GetHeadingCompaniesRep($lang = 'ar') {

        $this->db->select('tbl_heading.id,tbl_heading.hs_code,tbl_heading.hs_code_print,tbl_heading.label_ar,tbl_heading.description_ar,tbl_heading.rate1');
        $this->db->select('COUNT(tbl_company_heading.id) as TotalCompanies');
        $this->db->select("(case when tbl_heading_rate.year = '2018' then tbl_heading_rate.tones_import end) as tones_import_2018,
                            (case when tbl_heading_rate.year = '2018' then tbl_heading_rate.import_lbp end) as import_lbp_2018,
                            (case when tbl_heading_rate.year = '2018' then tbl_heading_rate.import_usd end) as import_usd_2018,
                            (case when tbl_heading_rate.year = '2017' then tbl_heading_rate.tones_import end) as tones_import_2017,
                            (case when tbl_heading_rate.year = '2017' then tbl_heading_rate.import_lbp end) as import_lbp_2017,
                            (case when tbl_heading_rate.year = '2017' then tbl_heading_rate.import_usd end) as import_usd_2017,
                            (case when tbl_heading_rate.year = '2016' then tbl_heading_rate.tones_import end) as tones_import_2016, 
                            (case when tbl_heading_rate.year = '2016' then tbl_heading_rate.import_lbp end) as import_lbp_2016,
                            (case when tbl_heading_rate.year = '2016' then tbl_heading_rate.import_usd end) as import_usd_2016,
                            (case when tbl_heading_rate.year = '2018' then tbl_heading_rate.tones_export end) as tones_export_2018,
                            (case when tbl_heading_rate.year = '2018' then tbl_heading_rate.export_lbp end) as export_lbp_2018,
                            (case when tbl_heading_rate.year = '2018' then tbl_heading_rate.export_usd end) as export_usd_2018,
                            (case when tbl_heading_rate.year = '2017' then tbl_heading_rate.tones_export end) as tones_export_2017,
                            (case when tbl_heading_rate.year = '2017' then tbl_heading_rate.export_lbp end) as export_lbp_2017,
                            (case when tbl_heading_rate.year = '2017' then tbl_heading_rate.export_usd end) as export_usd_2017,
                            (case when tbl_heading_rate.year = '2016' then tbl_heading_rate.tones_export end) as tones_export_2016,
                            (case when tbl_heading_rate.year = '2016' then tbl_heading_rate.export_lbp end) as export_lbp_2016, 
                            (case when tbl_heading_rate.year = '2016' then tbl_heading_rate.export_usd end) as export_usd_2016",FALSE);
    
        $this->db->from('tbl_heading');
        $this->db->join('tbl_heading_rate', 'tbl_heading_rate.heading_id = tbl_heading.id', 'inner');
        $this->db->join('tbl_company_heading', 'tbl_company_heading.heading_id = tbl_heading.id', 'inner');
         $this->db->group_by('tbl_heading.id');
         $this->db->group_by('tbl_heading.hs_code', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

}