<?php

class Deliverym extends CI_Model {
    function GetDeliverySales($type='guide')
    {
        $this->db->select('delivery.* ', FALSE);
        $this->db->from('delivery');
        $where='(delivery_companies.adv_salesman_id='.$salesman.' or delivery_companies.copy_res_salesman_id='.$salesman.')';
        $this->db->where($where);
        if($status!='')
        {
            $this->db->where('delivery_companies.delivery_status',$status);
        }
        else{
            $where1='(delivery_companies.delivery_status='.$status.' or delivery_companies.delivery_status=null)';
            $this->db->where($where);
        }
        $this->db->order_by('delivery_companies.name_ar', 'DESC');

        if ($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        $query1 = $this->db->query('SELECT FOUND_ROWS() AS `total_rows`');
        $objCount = $query1->result_array();
        $totalres = $objCount[0]['total_rows'];
        $data_array = array('total' => $totalres, 'rows' => $query->result());
        return $data_array;
    }
    
  function GetGeoDeliveryCompanies($gov='',$dist_id='',$area_id='',$salesmen_all='',$status)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS tbl_company.* ', FALSE);
        $this->db->select('sales_items.* ', FALSE);
        $this->db->select('delivery_items.delivery_id', FALSE);
        $this->db->from('tbl_company');
         $this->db->join('sales_items', 'sales_items.item_id = tbl_company.id AND sales_items.item_type="company"', 'inner');
          $this->db->join('delivery_items', 'delivery_items.item_id = tbl_company.id AND delivery_items.item_type="company"', 'left');
         if($salesmen_all!='')
         {
              $where='(sales_items.copy_reservation!='.$salesman.' or sales_items.advertisment='.$salesman.')';
         }
         else{
              $where='(sales_items.copy_reservation!=0 or sales_items.advertisment!=0)';
         }
       
        $this->db->where($where);
        if($status!='')
        {
        $this->db->where('sales_items.status',$status);
        }
       $this->db->where('delivery_items.id IS NOT NULL');
        $this->db->order_by('tbl_company.governorate_id', 'ASC');
        $this->db->order_by('tbl_company.district_id', 'ASC');
        $this->db->order_by('tbl_company.area_id', 'ASC');
        $this->db->order_by('tbl_company.name_ar', 'ASC');

        if ($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        $query1 = $this->db->query('SELECT FOUND_ROWS() AS `total_rows`');
        $objCount = $query1->result_array();
        $totalres = $objCount[0]['total_rows'];
        $data_array = array('total' => $totalres, 'rows' => $query->result());
        return $data_array;
    }
 
    function GetDeliveryCompanies($salesman,$status,$row=0,$limit=0)
    {
        $this->db->select('delivery_companies.* ', FALSE);
        $this->db->from('delivery_companies');
        $where='(delivery_companies.adv_salesman_id='.$salesman.' or delivery_companies.copy_res_salesman_id='.$salesman.')';
        $this->db->where($where);
        if($status!='')
        {
            $this->db->where('delivery_companies.delivery_status',$status);
        }
        else{
            $where1='(delivery_companies.delivery_status='.$status.' or delivery_companies.delivery_status=null)';
            $this->db->where($where);
        }
        $this->db->order_by('delivery_companies.name_ar', 'DESC');

        if ($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        $query1 = $this->db->query('SELECT FOUND_ROWS() AS `total_rows`');
        $objCount = $query1->result_array();
        $totalres = $objCount[0]['total_rows'];
        $data_array = array('total' => $totalres, 'rows' => $query->result());
        return $data_array;
    }
    function GetDeliveryCompaniesReports($salesman)
    {
        $this->db->select('COUNT(DISTINCT(tbl_company.id)) as TotalCompanies', FALSE);
        $this->db->select('COUNT(CASE WHEN (delivery_items.status="pending" AND delivery_items.item_type="company") THEN delivery_items.id END) as TotalCompaniesPending',FALSE);
        $this->db->select('COUNT(CASE WHEN (delivery_items.status="done" AND delivery_items.item_type="company") THEN delivery_items.id END) as TotalCompaniesDone',FALSE);
        $this->db->select('COUNT(CASE WHEN (delivery_items.status="cancel" AND delivery_items.item_type="company") THEN delivery_items.id END) as TotalCompaniesCancel',FALSE);
        $this->db->select('COUNT(CASE WHEN (delivery_items.status IS NULL or delivery_items.status="" or delivery_items.status=null) THEN 1 END) as TotalDeliveryCompaniesUnTask',FALSE);
        $this->db->select('tbl_company.adv_salesman_id, tbl_company.copy_res_salesman_id');
        $this->db->select('sales_adv.fullname as salesman_adv');
        $this->db->select('sales_copy.fullname as salesman_copy');
        $this->db->from('tbl_company');
        $this->db->join('delivery_items', 'delivery_items.item_id = tbl_company.id AND delivery_items.item_type="company"', 'left');
        $this->db->join('tbl_sales_man sales_adv', 'sales_adv.id = tbl_company.adv_salesman_id', 'left');
        $this->db->join('tbl_sales_man sales_copy', 'sales_copy.id = tbl_company.copy_res_salesman_id', 'left');
        if($salesman!=''){
        $where='(tbl_company.adv_salesman_id='.$salesman.' or tbl_company.copy_res_salesman_id='.$salesman.')';
        $this->db->where($where);
        }
        
       $this->db->where('tbl_company.error_address !=', 1);
       $this->db->where('tbl_company.is_closed !=', 1);
        $query = $this->db->get();
        return $query->result();
    }
    function GetDeliveryTaskById($delivery_id)
    {
        $this->db->select('delivery.*', FALSE);
        $this->db->select('COUNT(CASE WHEN delivery_items.status="pending" THEN delivery_items.id END) as TotalPending',FALSE);
        $this->db->select('COUNT(CASE WHEN delivery_items.status="done" THEN delivery_items.id END) as TotalDone',FALSE);
        $this->db->select('delivery_schedules.start_date as DeliveryStartDate, delivery_schedules.end_date as DeliveryEndDate');
        $this->db->select('tbl_sales_man.fullname as salesman');
        $this->db->select('users.username, users.fullname');
        $this->db->from('delivery');
        $this->db->join('delivery_items', 'delivery_items.delivery_id = delivery.id', 'inner');
        $this->db->join('delivery_schedules', 'delivery_schedules.delivery_id = delivery.id', 'left');
        $this->db->join('tbl_sales_man', 'tbl_sales_man.id = delivery.salesman_id', 'left');
        $this->db->join('users', 'users.id = delivery.user_id', 'left');
       
            $this->db->where('delivery.id', $delivery_id);
        $query = $this->db->get();
      
       
        return $query->row_array();
    }
    function GetDeliveryTasks($delivery_id,$salesman,$company_id,$status,$row,$limit)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS delivery.*', FALSE);
        $this->db->select('COUNT(CASE WHEN delivery_items.status="pending" THEN delivery_items.id END) as TotalPending',FALSE);
        $this->db->select('COUNT(CASE WHEN delivery_items.status="done" THEN delivery_items.id END) as TotalDone',FALSE);
        $this->db->select('delivery_schedules.start_date as DeliveryStartDate, delivery_schedules.end_date as DeliveryEndDate');
        $this->db->select('tbl_sales_man.fullname as salesman');
        $this->db->select('users.username, users.fullname');
        $this->db->select('delivery.salesman_id');
        $this->db->from('delivery');
        $this->db->join('delivery_items', 'delivery_items.delivery_id = delivery.id', 'left');
        $this->db->join('delivery_schedules', 'delivery_schedules.delivery_id = delivery.id', 'left');
        $this->db->join('tbl_sales_man', 'tbl_sales_man.id = delivery.salesman_id', 'left');
        $this->db->join('users', 'users.id = delivery.user_id', 'left');
        if($delivery_id!='') {
            $this->db->where('delivery.id', $delivery_id);
        }
        if($status!='')
        {
            $this->db->where('delivery.status', $status);
        }
        if($salesman!='')
        {
            $this->db->where('delivery.salesman_id', $salesman);
        }
        if($company_id!='')
        {
            $this->db->where('delivery_items.item_id', $company_id);
            $this->db->where('delivery_items.item_type', 'company');
        }
        $this->db->group_by('delivery.id');
        $this->db->order_by('delivery_schedules.id', 'DESC');

        if ($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        $query1 = $this->db->query('SELECT FOUND_ROWS() AS `total_rows`');
        $objCount = $query1->result_array();
        $totalres = $objCount[0]['total_rows'];
        $data_array = array('total' => $totalres, 'rows' => $query->result());
        return $data_array;
    }
    function GetCompaniesBySalesman($gov='',$district='',$array_salesmen='',$array_area=array())
    {
        $this->db->select('tbl_company.*');
       // $this->db->select('COUNT(CASE WHEN tbl_company.delivery=0 THEN tbl_company.id END) as TotalCompanies',FALSE);
       // $this->db->select('COUNT(tbl_company.id) as TotalCompanies');
       // $this->db->select('COUNT(CASE WHEN delivery_items.id IS NULL THEN 1 END) as TotalDelivery');
        $this->db->from('tbl_company');
        //$this->db->join('tbl_area', ' tbl_area.id = tbl_company.area_id', 'inner');
        $this->db->join('delivery_items', 'delivery_items.item_id = tbl_company.id AND delivery_items.item_type="company"', 'left',false);
        $this->db->where('tbl_company.is_closed', 0);
        $this->db->where('tbl_company.error_address', 0);
       // $this->db->where('(tbl_company.delivery_by IS NULL)');
        if($array_salesmen!='')
        {
            $where='( tbl_company.adv_salesman_id IN ('.$array_salesmen.') OR tbl_company.copy_res_salesman_id IN ('.$array_salesmen.'))';
            $this->db->where($where);
        }
        else{
            
            $where='( tbl_company.adv_salesman_id !=0 OR tbl_company.copy_res_salesman_id !=0)';
            $this->db->where($where);
        }
         $where1='( tbl_company.delivery=0 OR tbl_company.delivery IS NULL OR tbl_company.delivery="")';
            $this->db->where($where1);
        //$this->db->where('tbl_company.adv_salesman_id', 0);
        //$this->db->where('tbl_company.copy_res_salesman_id', 0);

        if($gov!='' and $gov!=0)
            $this->db->where('tbl_company.governorate_id',$gov);
        if($district!='' and $district!=0)
            $this->db->where('tbl_company.district_id',$district);
        if(count($array_area)>0)
        {
            
           $this->db->where_in('tbl_company.area_id',$array_area); 
        }
       $this->db->where('delivery_items.id', NULL);
        $this->db->order_by('tbl_company.name_ar', 'ASC');
        $query = $this->db->get();
        return $query->result();
        
    }
    function GetCompaniesBySalesman1($gov='',$district='',$area_id='',$salesman_array)
    {
        $this->db->select('tbl_company.*');

        $this->db->from('tbl_company');
        $this->db->where('tbl_company.is_closed', 0);
        $this->db->where('tbl_company.error_address', 0);

        if(count($salesman_array)>0){
            $where='(';
           for($i=0;$i<count($salesman_array);$i++){
                if(count($salesman_array[$i]['area']==0))
                {
                    $where.='( adv_salesman_id='.$salesman_array[$i]['salesman'].' or (copy_res_salesman_id='.$salesman_array[$i]['salesman'].' and adv_salesman_id=0))';
                }
                else{
                    //$areawhere='and area_id IN ('.implode(",", $salesman_array[$i]['area']).')';
$areawhere='';
                    $where.='(( adv_salesman_id='.$salesman_array[$i]['salesman'].' '.$areawhere.') or (copy_res_salesman_id='.$salesman_array[$i]['salesman'].' and adv_salesman_id=0 '.$areawhere.' ))';
                }


                if($i<count($salesman_array)-1)
                {
                    $where.=' OR ';
                }
            }
            $where.=' )';
        }
        
        $this->db->where($where);
        if($gov!='' and $gov!=0)
            $this->db->where('tbl_company.governorate_id',$gov);
        if($district!='' and $district!=0)
            $this->db->where('tbl_company.district_id',$district);
        if($area_id!='' and $area_id!=0)
            $this->db->where_in('tbl_company.area_id',$area_id);
        $this->db->order_by('tbl_company.name_ar', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    function GetCompaniesByAreaIds($array_area=array())
    {
        $this->db->select('tbl_company.*');
        $this->db->select('delivery_items.id as DeliveryId');
        $this->db->from('tbl_company');
        $this->db->join('delivery_items', 'delivery_items.item_id = tbl_company.id AND delivery_items.item_type="company"', 'left',false);
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'inner');
        $this->db->where('tbl_company.is_closed', 0);
        $this->db->where('tbl_company.error_address', 0);
        $this->db->where('tbl_company.adv_salesman_id', 0);
        $this->db->where('tbl_company.copy_res_salesman_id', 0);
        $this->db->where('delivery_items.id', NULL);
        $this->db->where_in('tbl_company.area_id',$array_area);
        $this->db->order_by('tbl_area.label_ar', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    function GetAreaByDistrictID($gov='',$district='',$array_salesmen='')
    {
        $this->db->select('tbl_area.*');
        $this->db->select('COUNT(CASE WHEN (tbl_company.delivery=0 OR tbl_company.delivery IS NULL OR tbl_company.delivery="") THEN tbl_company.id END) as TotalCompanies',FALSE);
       // $this->db->select('COUNT(tbl_company.id) as TotalCompanies');
        $this->db->select('COUNT(CASE WHEN delivery_items.id IS NULL THEN 1 END) as TotalDelivery');
        $this->db->from('tbl_area');
        $this->db->join('tbl_company', 'tbl_company.area_id = tbl_area.id', 'inner');
        $this->db->join('delivery_items', 'delivery_items.item_id = tbl_company.id AND delivery_items.item_type="company"', 'left',false);
        $this->db->where('tbl_company.is_closed', 0);
        $this->db->where('tbl_company.error_address', 0);
       // $this->db->where('(tbl_company.delivery_by IS NULL)');
        if($array_salesmen!='' and $array_salesmen!='null')
        {
            $where='( tbl_company.adv_salesman_id IN ('.$array_salesmen.') OR tbl_company.copy_res_salesman_id IN ('.$array_salesmen.'))';
            $this->db->where($where);
        }
        else{
            
            $where='( tbl_company.adv_salesman_id !=0 OR tbl_company.copy_res_salesman_id !=0)';
            $this->db->where($where);
        }
       
        //$this->db->where('tbl_company.adv_salesman_id', 0);
        //$this->db->where('tbl_company.copy_res_salesman_id', 0);

        if($gov!='' and $gov!=0)
            $this->db->where('tbl_company.governorate_id',$gov);
        if($district!='' and $district!=0)
            $this->db->where('tbl_company.district_id',$district);
       $this->db->group_by('tbl_area.id');
        $this->db->having('TotalDelivery >',0);
        $this->db->having('TotalCompanies >',0);
        $this->db->order_by('tbl_area.label_ar', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    function GetCompanies($delivery_id,$status='',$row,$limit,$item_id='')
    {
        $this->db->select('SQL_CALC_FOUND_ROWS tbl_company.*', FALSE);
        $this->db->select('delivery_items.delivery_id as DeliveryId,delivery_items.item_type as DeliveryItemType,delivery_items.receiver_name as ReceiverName');
        $this->db->select('delivery_items.receiver_date as ReceiverDate,delivery_items.notes as DeliveryNotes, delivery_items.status as DeliveryStatus, delivery_items.paid_status as PaidStatus');
        $this->db->select('delivery_items.copy_quantity as CopyQuantity,delivery_items.delivery_man_id as DeliveryManId,delivery_items.id as DeliveryItemId');
        $this->db->select('delivery_schedules.start_date as DeliveryStartDate, delivery_schedules.end_date as DeliveryEndDate');
        $this->db->select('tbl_sales_man.fullname as salesman');
        $this->db->select('dc.fullname as DeliverySales');
        $this->db->select('tbl_governorates.label_ar as governorate_ar,tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar, tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar, tbl_area.label_en as area_en');
        $this->db->select('users.username, users.fullname');
        $this->db->select('COUNT(tbl_company_heading.id) as CNbr');
        $this->db->select('tbl_companies_guide_pages.guide_pages_ar, tbl_companies_guide_pages.guide_pages_en');
        $this->db->select('delivery.salesman_id');
        $this->db->from('tbl_company');
        $this->db->join('delivery_items', 'delivery_items.item_id = tbl_company.id', 'inner');
        $this->db->join('delivery', 'delivery.id = delivery_items.delivery_id', 'inner');
        $this->db->join('delivery_schedules', 'delivery_schedules.delivery_id = delivery.id', 'left');
        $this->db->join('tbl_sales_man', 'tbl_sales_man.id = tbl_company.sales_man_id', 'left');
        $this->db->join('tbl_sales_man dc', 'dc.id = delivery.salesman_id', 'left');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
        $this->db->join('tbl_company_heading', 'tbl_company_heading.company_id = tbl_company.id', 'left');
        $this->db->join('tbl_companies_guide_pages', 'tbl_companies_guide_pages.company_id = tbl_company.id', 'left');
        $this->db->join('users', 'users.id = delivery.user_id', 'left');
        $this->db->where('delivery_items.delivery_id', $delivery_id);
        if($status!='')
        {
            $this->db->where('delivery_items.status', $status);
        }
        if($item_id!=''){
             $this->db->where('delivery_items.item_id', $item_id);
         }
        $this->db->group_by('delivery_items.id');
        $this->db->group_by('tbl_company.id');
        $this->db->order_by('delivery_schedules.id', 'DESC');
        /* 
         if($from!=''){
             $this->db->where('tbl_update_info_logs.create_time >=', $from.' 00:00:00');
         }
         if($to!=''){
             $this->db->where('tbl_update_info_logs.create_time <=', $to.' 23:59:59');
         }
         if($company_id!=''){
             $this->db->where('tbl_update_info_logs.user_id', $user_id);
         }
        */

        if ($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        $query1 = $this->db->query('SELECT FOUND_ROWS() AS `total_rows`');
        $objCount = $query1->result_array();
        $totalres = $objCount[0]['total_rows'];
        $data_array = array('total' => $totalres, 'rows' => $query->result());
        return $data_array;
    }
    function GetActivities($status)
    {
        $this->db->select('magazine_activities.*,magazine_activities.name as text');
        $this->db->select('users.username, users.fullname');
        $this->db->from('magazine_activities');
        $this->db->join('users', 'users.id = magazine_activities.user_id', 'left');
        if($status!=''){
            $this->db->where('magazine_activities.status', $status);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function GetActivityById($id)
    {
        $this->db->select('magazine_activities.*');
        $this->db->select('users.username, users.fullname');
        $this->db->from('magazine_activities');
        $this->db->join('users', 'users.id = magazine_activities.user_id', 'left');
        $this->db->where('magazine_activities.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    function GetSources($status)
    {
        $this->db->select('magazine_sources.*, magazine_sources.name as text');
        $this->db->select('users.username, users.fullname');
        $this->db->from('magazine_sources');
        $this->db->join('users', 'users.id = magazine_sources.user_id', 'left');
        if($status!=''){
            $this->db->where('magazine_sources.status', $status);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function GetSourceById($id)
    {
        $this->db->select('magazine_sources.*');
        $this->db->select('users.username, users.fullname');
        $this->db->from('magazine_sources');
        $this->db->join('users', 'users.id = magazine_sources.user_id', 'left');
        $this->db->where('magazine_sources.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    function GetLegalForms($status)
    {
        $this->db->select('magazine_legal_forms.*');
        $this->db->select('users.username, users.fullname');
        $this->db->from('magazine_legal_forms');
        $this->db->join('users', 'users.id = magazine_legal_forms.user_id', 'left');
        if($status!=''){
            $this->db->where('magazine_legal_forms.status', $status);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function GetLegalFormById($id)
    {
        $this->db->select('magazine_legal_forms.*');
        $this->db->select('users.username, users.fullname');
        $this->db->from('magazine_legal_forms');
        $this->db->join('users', 'users.id = magazine_legal_forms.user_id', 'left');
        $this->db->where('magazine_legal_forms.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    function GetLabels()
    {
        $this->db->select('magazine_labels.*');
        $this->db->select('users.username, users.fullname');
        $this->db->from('magazine_labels');
        $this->db->join('users', 'users.id = magazine_labels.user_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }
    function GetLabelId($id)
    {
        $this->db->select('magazine_labels.*');
        $this->db->select('users.username, users.fullname');
        $this->db->from('magazine_labels');
        $this->db->join('users', 'users.id = magazine_labels.user_id', 'left');
        $this->db->where('magazine_labels.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetCountries()
    {
        $this->db->select('tbl_countries.*');
        $this->db->select('users.username, users.fullname');
        $this->db->from('tbl_countries');
        $this->db->join('users', 'users.id = tbl_countries.user_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }
    function GetAllGeo()
    {
        $this->db->select('tbl_countries.id, tbl_countries.label_ar as name');
        $this->db->select('users.username, users.fullname');
        $this->db->from('tbl_countries');
        $this->db->join('users', 'users.id = tbl_countries.user_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }
    function GetAllGovernorateByCountry($country)
    {
        $this->db->select('tbl_governorates.id, tbl_governorates.label_ar as name');
        $this->db->select('users.username, users.fullname');
        $this->db->from('tbl_governorates');
        $this->db->join('users', 'users.id = tbl_governorates.user_id', 'left');
        $this->db->where('tbl_governorates.country_id',$country);
        $this->db->order_by('tbl_governorates.label_ar','asc');
        $query = $this->db->get();
        return $query->result();
    }
    function GetDistrictJsonByGovernorate($governorate)
    {
        $this->db->select('tbl_districts.id, tbl_districts.label_ar as name');
        $this->db->select('users.username, users.fullname');
        $this->db->from('tbl_districts');
        $this->db->join('users', 'users.id = tbl_districts.user_id', 'left');
        $this->db->where('tbl_districts.governorate_id',$governorate);
        $this->db->order_by('tbl_districts.label_ar','asc');
        $query = $this->db->get();
        return $query->result();
    }
    function GetAreaJsonByDistrict($district)
    {
        $this->db->select('tbl_area.id, tbl_area.label_ar as name');
        $this->db->select('users.username, users.fullname');
        $this->db->from('tbl_area');
        $this->db->join('users', 'users.id = tbl_area.user_id', 'left');
        $this->db->where('tbl_area.district_id',$district);
        $this->db->order_by('tbl_area.label_ar','asc');
        $query = $this->db->get();
        return $query->result();
    }
    function GetSalesmen()
    {
        $this->db->select('tbl_sales_man.*');
        $this->db->select('users.username, users.fullname as user_fullname');
        $this->db->from('tbl_sales_man');
        $this->db->join('users', 'users.id = tbl_sales_man.user_id', 'left');
        $this->db->order_by('tbl_sales_man.fullname','asc');
        $query = $this->db->get();
        return $query->result();
    }


}